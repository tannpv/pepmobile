<?php

defined('_JEXEC') or die;
jimport('joomla.user.helper');
jimport('joomla.application.component.modeladmin');

class Membership_directoryModelImport extends JModelAdmin {

    /**
     * @var		string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_MEMBERSHIP_DIRECTORY';

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param	type	The table type to instantiate
     * @param	string	A prefix for the table class name. Optional.
     * @param	array	Configuration array for model. Optional.
     * @return	JTable	A database object
     * @since	1.6
     */
    public function getTable($type = 'Import', $prefix = 'Membership_directoryTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	JForm	A JForm object on success, false on failure
     * @since	1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_membership_directory.import', 'import', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return	mixed	The data for the form.
     * @since	1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_membership_directory.edit.import.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    public function getTextFromCell($form_name) {
        if (is_object($form_name->getValue())) { // if the field happens to contain richtext
            //    $objRichText = new PHPExcel_RichText($objPHPExcel->getActiveSheet()->getCell('B' . $i));
//            $objRichText = new PHPExcel_RichText($form_name);
//                       
//
//            $elements = $objRichText->getRichTextElements();
//
//            $objRichText2 = $elements[0]->getText(); // judging from the $objRichtText->PlainText method, this should have the plaintext, but instead it is another object, so we need to get the rich text elements again
//
//            $elements2 = $objRichText2->getRichTextElements();
//
//            $returnValue = "";
//
//            foreach ($elements2 as $text) {
//                $returnValue .= $text->getText();
//            }
            return $form_name->getValue()->getPlainText();
            // $form_name = $returnValue; // this has the plaintext now
        } else {
            return $form_name->getValue();
        }
    }

    public function process($path) {
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        }
        $nrColumns = ord($highestColumn) - 64;
        $header = array();
        $skippedRows = 0;
        $processedRecords = 0;
        $count_insert = 0;
        $count_update = 0;
        $this->dump2Tmp($path);

        $emails = $this->getDuplicateEmailFromTmp();
        $members = $this->getAllRecordFromTmp();
        $missingEmails = $this->deleteMissingEmails();
        foreach ($members as $member) {
            if (trim($member['email']) && !in_array(trim($member['email']), $emails)) {
                if ($this->isExistedEmail($member['email'])) {
                    // $member_id = $this->updateMemberByEmail($member);
                    // $this->updateUserByMemberId($member, $member_id);
                    $this->deleteMemberByEmail(trim($member['email']));
                    $this->deleteUserByEmail(trim($member['email']));
                    $count_update++;
                }
                //else {
                $memberId = $this->saveMember($member);
                $this->saveUser($member, $memberId);
                $count_insert++;
                // }
            } else {
                $skippedRows++;
            }
            $processedRecords++;
        }
        $this->emptyTmpMemberData();
        if ($skippedRows > 0) {
            JError::raiseNotice(100, 'Skip ' . $skippedRows . ' rows because the emails may be blank ');
        }
        if (sizeof($emails) > 0) {
            JError::raiseWarning(100, 'Following emails are duplicate and skipped during the importing proccess (' . implode(', ', $emails) . ')');
        }
        JFactory::getApplication()->enqueueMessage('Proccess ' . $processedRecords . ' records!');
        if ($count_update > 0) {
            JFactory::getApplication()->enqueueMessage('Update ' . $count_update . ' records successfully');
        }
        if ($count_insert > 0) {
            JFactory::getApplication()->enqueueMessage('Insert ' . $count_insert . ' records successfully');
        }
        $count_missing_email = sizeof($missingEmails);
        if ($count_missing_email > 0) {
            JFactory::getApplication()->enqueueMessage('Delete ' . $count_missing_email . ' records successfully');
        }

        return true;
    }

    public function deleteMissingEmails() {
        $db = JFactory::getDbo();
        $emails = array();
        $query = $db->getQuery(true);
        $query = "SELECT
                    m.email
                    FROM
                            jos_membership_directory m
                    WHERE
                            NOT EXISTS (
                                    SELECT
                                            *
                                    FROM
                                            jos_membership_directory_tmp mt
                                    WHERE
                                            mt.email = m.email
                            )
                    ORDER BY
                            m.email ";
        $result = $db->setQuery($query);

        if ($result) {
            $emails = $db->loadColumn();
        }

        foreach ($emails as $email) {

            $this->deleteMemberByEmail($email);
            $this->deleteUserByEmail($email);
        }
        return $emails;
    }

    public function deleteUserByEmail($email) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $user_id = $this->getUserIdByEmail($email);
        //remove user from group
        if ($user_id) {
            // JUserHelper::removeUserFromGroup($user_id, 14);
            $this->removeUserFromGroup($user_id, 14);
        }
        //delete user
        $conditions = array(
            "trim(" . $db->quoteName('email') . ") ='" . trim($email) . "'"
        );
        $query->delete($db->quoteName('#__users'));
        $query->where($conditions);
        $db->setQuery($query);
        $result = $db->query();
    }

    public function removeUserFromGroup($user_id, $user_group_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('user_id') . " ='" . trim($user_id) . "'",
            $db->quoteName('group_id') . " ='" . trim($user_group_id) . "'"
        );
        $query->delete($db->quoteName('#__user_usergroup_map'));
        $query->where($conditions);
        $db->setQuery($query);
        $result = $db->query();
    }

    public function deleteMemberByEmail($email) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            "trim(" . $db->quoteName('email') . ") ='" . trim($email) . "'"
        );
        $query->delete($db->quoteName('#__membership_directory'));
        $query->where($conditions);
        $db->setQuery($query);
        $result = $db->query();
    }

    public function getUserIdByEmail($email) {
        $db = JFactory::getDbo();
        $id = false;
        //get id from existing member
        $query = $db->getQuery(true);

        $query->select('*')
                ->from("jos_users")
                ->where("email='" . trim($email) . "'");
        $db->setQuery($query);
        if ($db->loadObject()->id) {
            $id = $db->loadObject()->id;
        }
        return $id;
    }

    public function updateUserByMemberId($data, $member_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $name = $data ['first_name'] . " " . $data ['last_name'];
        //$username = $this->createUserName($data, $member_id);
        $email = $data ['email'];
        $datetime = date('Y-m-d H:i:s');
        /* password */
        $salt = JUserHelper::genRandomPassword(32);
        $crypt = JUserHelper::getCryptedPassword("pep", $salt);
        $pass = $crypt . ':' . $salt;
        $fields = array(
            $db->quoteName('name') . "='" . $name . "'",
            // $db->quoteName('username') . "='" . $username . "'",
            $db->quoteName('email') . "='" . $email . "'",
            // $db->quoteName('password') . "='" . $pass . "'",
            $db->quoteName('registerDate') . "='" . $datetime . "'"
        );
        $conditions = array(
            $db->quoteName('membership_id') . "='" . $member_id . "'"
        );
        $query->update($db->quoteName('#__users'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $result = $db->query();
    }

    public function updateMemberByEmail($data) {
        $db = JFactory::getDbo();
        $member = new stdClass();
        //get id from existing member
        $query = $db->getQuery(true);

        $query->select('*')
                ->from("jos_membership_directory")
                ->where("email='" . $data["email"] . "'");
        $db->setQuery($query);
        $member_id = $db->loadObject()->id;

        $member->id = $member_id;
        $member->size_of_company = $data["Size of Company"];
        $member->year_joined = $data["Year Joined"];
        $member->dues_2014 = $data["2014 Dues"];
        $member->dues_2013 = $data["2013 Dues"];
        $member->desingated_rep = ($data["Desingated Rep?"] == "1" ? "True" : "False");
        $member->new_2013 = ($data["New 2013"] == "yes" ? "True" : "False");
        $member->new_2014 = ($data["New 2014"] == "yes" ? "True" : "False");
        $member->term_expires = $data["Term Expires"];
        $member->board_position = $data["Board Position"];
        $member->business_category = $data["Business Category"];
        $member->paid_2013 = ($data["Paid 2013"] == "yes" ? "True" : "False");
        $member->company = $data["Company"];
        $member->address = $data["Address"];
        $member->city_state_zip = $data["City State Zip"];
        $member->first_name = $data["First Name"];
        $member->last_name = $data["Last Name"];
        $member->job_title = $data["Job Title"];
        $member->email = $data["Email"];
        $member->website = $data["Website"];
        $member->phone = $data["Phone"];
        $member->cell = $data["Cell"];
        $member->fax = $data["Fax"];
        $member->contact = $data["A/P Contact"];
        $member->ap_email = $data["A/P Email"];
        $member->description = $data["NEW descriptions (2014)"];
        $member->referred_by = $data["Referred By"];
        $member->pass = $data["pass"];

        try {
            $result = $db->updateObject("jos_membership_directory", $member, "id");
            //$id = $db->insertid();
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage('Error on adding new member');
            $member_id = false;
        }
        return $member_id;
    }

    public function updateMemberByRecordId($data) {
        $db = JFactory::getDbo();
        $member = new stdClass();
        $member->id = $data["Record #"];
        $member->size_of_company = $data["Size of Company"];
        $member->year_joined = $data["Year Joined"];
        $member->dues_2014 = $data["2014 Dues"];
        $member->dues_2013 = $data["2013 Dues"];
        $member->desingated_rep = ($data["Desingated Rep?"] == "1" ? "True" : "False");
        $member->new_2013 = ($data["New 2013"] == "yes" ? "True" : "False");
        $member->new_2014 = ($data["New 2014"] == "yes" ? "True" : "False");
        $member->term_expires = $data["Term Expires"];
        $member->board_position = $data["Board Position"];
        $member->business_category = $data["Business Category"];
        $member->paid_2013 = ($data["Paid 2013"] == "yes" ? "True" : "False");
        $member->company = $data["Company"];
        $member->address = $data["Address"];
        $member->city_state_zip = $data["City State Zip"];
        $member->first_name = $data["First Name"];
        $member->last_name = $data["Last Name"];
        $member->job_title = $data["Job Title"];
        $member->email = $data["Email"];
        $member->website = $data["Website"];
        $member->phone = $data["Phone"];
        $member->cell = $data["Cell"];
        $member->fax = $data["Fax"];
        $member->contact = $data["A/P Contact"];
        $member->ap_email = $data["A/P Email"];
        $member->description = $data["NEW descriptions (2014)"];
        $member->referred_by = $data["Referred By"];
        $member->pass = $data["pass"];
//        $member_id = $data["Record #"];
        try {
            $result = $db->updateObject("jos_membership_directory", $member, "id");
            //$id = $db->insertid();
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage('Error on adding new member');
            $member_id = false;
        }
        return $member_id;
    }

    public function validate($file) {
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        }
        $nrColumns = ord($highestColumn) - 64;
        $header = array();
        for ($row = 1; $row <= 1; ++$row) {
            $val = array();
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                $headerLabel = $cell->getValue();
                $header[] = $headerLabel;
            }
        }
        $sample = array(
            "Company",
            "Desingated Rep?",
            "Business Category",
            "Address",
            "City State Zip",
            "First Name",
            "Last Name",
            "Job Title",
            "Website",
            "Email",
            "Phone",
            "Fax",
            "Company Description",
        );
        $array_dff = array_diff($sample, $header);
        if (sizeof($array_dff) > 0) {
            JError::raiseWarning(100, 'Missing fields on uploaded spreadsheet (' . implode(',', $array_dff) . ')');
            return false;
        }
//        if ($emails = $this->checkDuplicateEmail($file)) {
//            JError::raiseWarning(100, 'Following emails are duplicate on uploaded spreadsheet (' . implode(',', $emails) . ')');
//            return false;
//        }

        return true;
    }

    public function checkDuplicateEmail($path) {
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        }
        $nrColumns = ord($highestColumn) - 64;
        $header = array();
        $skippedRows = 0;
        $processedRecords = 0;
        $count_insert = 0;
        $count_update = 0;
        $this->emptyTmpMemberData();
        for ($row = 1; $row <= $highestRow; ++$row) {
            $val = array();
            if ($row == 1) {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $header[] = $this->getTextFromCell($cell);
                }
            } else {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val[$header[$col]] = $this->getTextFromCell($cell);
                }
                if ($val['Email']) {
                    $this->saveTmpData($val);
                }
            }
        }
        return $this->getDuplicateEmailFromTmp();
    }

    public function dump2Tmp($path) {
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        }
        $nrColumns = ord($highestColumn) - 64;
        $header = array();
        $skippedRows = 0;
        $processedRecords = 0;
        $count_insert = 0;
        $count_update = 0;
        $default_pass = ($this->getDefaultPass() ? $this->getDefaultPass()->value : null);
        $this->emptyTmpMemberData();
        for ($row = 1; $row <= $highestRow; ++$row) {
            $val = array();
            if ($row == 1) {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $header[] = trim($this->getTextFromCell($cell));
                }
            } else {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val[trim($header[$col])] = trim($this->getTextFromCell($cell));
                }
                if ($val['Email']) {
                    if ($default_pass) {
                        $val['pass'] = $default_pass;
                    }
                    $this->saveTmpData($val);
                }
            }
        }
    }

    public function getDuplicateEmailFromTmp() {
        $db = JFactory::getDbo();
        $emails = array();
        $query = $db->getQuery(true);
        $query = "select count(email) as num,email from jos_membership_directory_tmp
                    group by email
                    having count(email)>1;";
        $result = $db->setQuery($query);
        if ($result) {
            $emails = $db->loadColumn(1);
        }
        return $emails;
    }

    public function getAllRecordFromTmp() {
        $db = JFactory::getDbo();
        $members = array();
        $query = $db->getQuery(true);
        $query = "SELECT * FROM jos_membership_directory_tmp;";
        $result = $db->setQuery($query);

        if ($result) {
            $members = $db->loadAssocList();
        }
        return $members;
    }

    public function emptyTmpMemberData() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "DELETE FROM jos_membership_directory_tmp;";
        $db->setQuery($query);
        $db->query();
    }

    public function saveTmpData($data) {
        $db = JFactory::getDbo();
        $member = new stdClass();
        $member->size_of_company = trim($data["Size of Company"]);
        $member->year_joined = trim($data["Year Joined"]);
        $member->dues_2014 = trim($data["2014 Dues"]);
        $member->dues_2013 = trim($data["2013 Dues"]);
        $member->desingated_rep = trim(($data["Desingated Rep?"] == "1" ? "True" : "False"));
//        $member->desingated_rep = $data["Desingated Rep?"];
        $member->new_2013 = trim(($data["New 2013"] == "yes" ? "True" : "False"));
        $member->new_2014 = trim(($data["New 2014"] == "yes" ? "True" : "False"));
        $member->term_expires = trim($data["Term Expires"]);
        $member->board_position = trim($data["Board Position"]);
        $member->business_category = trim($data["Business Category"]);
        $member->paid_2013 = trim(($data["Paid 2013"] == "yes" ? "True" : "False"));
//        $member->business_directory=$data["Size of Company"];
        $member->company = trim($data["Company"]);
        $member->address = trim($data["Address"]);
        $member->city_state_zip = trim($data["City State Zip"]);
        $member->first_name = trim($data["First Name"]);
        $member->last_name = trim($data["Last Name"]);
        $member->job_title = trim($data["Job Title"]);
        $member->email = trim($data["Email"]);
        $member->website = trim($data["Website"]);
        $member->phone = trim($data["Phone"]);
        $member->cell = trim($data["Cell"]);
        $member->fax = trim($data["Fax"]);
        $member->contact = trim($data["A/P Contact"]);
        $member->ap_email = trim($data["A/P Email"]);
        $member->description = trim($data["Company Description"]);
//        $member->description = $data["NEW descriptions (2014)"];
        $member->referred_by = trim($data["Referred By"]);
        $member->pass = trim($data["pass"]);
        try {
            $result = $db->insertObject("jos_membership_directory_tmp", $member);
            $id = $db->insertid();
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage('Error on adding new record');
            $id = false;
        }
    }

    public function createUserName($data, $memberId) {
        $username = false;
        if ($data['Email']) {
            $username = strtolower($data['Email']);
        } else {
            $username = 'member' . $memberId;
        }
        return $username;
    }

    public function saveUser($data, $memberId) {
        $first_name = $data ['first_name'];
        $last_name = $data ['last_name'];
        $name = $first_name . " " . $last_name;
        $email = $data ['email'];
        $datetime = date('Y-m-d H:i:s');
        /* password */
        $salt = JUserHelper::genRandomPassword(32);
        $crypt = JUserHelper::getCryptedPassword($data['pass'], $salt);
        $pass = $crypt . ':' . $salt;

        // ////////////////////////////////////////////////////////////
        $db = JFactory::getDbo();
        // Create and populate an object.
        $insert = new stdClass ();
        $insert->id = '';
        $insert->name = $name;
        $insert->username = strtolower($email);
        $insert->email = $email;
        $insert->password = $pass;
        $insert->usertype = '';
        $insert->block = '';
        $insert->sendEmail = '';
        $insert->registerDate = $datetime;
        $insert->lastvisitDate = '';
        $insert->activation = '';
        $insert->params = '';
        $insert->button = '';
        $insert->membership_id = $memberId;
        try {
            $result = $db->insertObject('#__users', $insert);
            $user_id = $db->insertid();
            JUserHelper::addUserToGroup($user_id, 14);
        } catch (Exception $e) {
            echo "Insert Fail!!!";
        }

        return $user_id;
    }

    public function saveMember($data) {
        $db = JFactory::getDbo();
        $member = new stdClass();
        $member->size_of_company = $data["size_of_company"];
        $member->year_joined = $data["year_joined"];
        $member->dues_2014 = $data["dues_2014"];
        $member->dues_2013 = $data["dues_2013"];
        $member->desingated_rep = $data["desingated_rep"];
//        $member->desingated_rep = $data["Desingated Rep?"];
        $member->new_2013 = $data["new_2013"];
        $member->new_2014 = $data["new_2014"];
        $member->term_expires = $data["term_expires"];
        $member->board_position = $data["board_position"];
        $member->business_category = $data["business_category"];
        $member->paid_2013 = $data["paid_2013"];
//        $member->business_directory=$data["Size of Company"];
        $member->company = $data["company"];
        $member->address = $data["address"];
        $member->city_state_zip = $data["city_state_zip"];
        $member->first_name = $data["first_name"];
        $member->last_name = $data["last_name"];
        $member->job_title = $data["job_title"];
        $member->email = $data["email"];
        $member->website = $data["website"];
        $member->phone = $data["phone"];
        $member->cell = $data["cell"];
        $member->fax = $data["fax"];
        $member->contact = $data["contact"];
        $member->ap_email = $data["ap_email"];
        $member->description = $data["description"];
        $member->referred_by = $data["referred_by"];
        $member->pass = $data["pass"];
        try {
            $result = $db->insertObject("jos_membership_directory", $member);
            $id = $db->insertid();
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage('Error on adding new member');
            $id = false;
        }
        return $id;
    }

    public function addMember($data) {
        $db = JFactory::getDbo();
        $member = new stdClass();
//        $member->id = $data["Record #"];
        $member->size_of_company = $data["Size of Company"];
        $member->year_joined = $data["Year Joined"];
        $member->dues_2014 = $data["2014 Dues"];
        $member->dues_2013 = $data["2013 Dues"];
        $member->desingated_rep = ($data["Desingated Rep?"] == "1" ? "True" : "False");
//        $member->desingated_rep = $data["Desingated Rep?"];
        $member->new_2013 = ($data["New 2013"] == "yes" ? "True" : "False");
        $member->new_2014 = ($data["New 2014"] == "yes" ? "True" : "False");
        $member->term_expires = $data["Term Expires"];
        $member->board_position = $data["Board Position"];
        $member->business_category = $data["Business Category"];
        $member->paid_2013 = ($data["Paid 2013"] == "yes" ? "True" : "False");
//        $member->business_directory=$data["Size of Company"];
        $member->company = $data["Company"];
        $member->address = $data["Address"];
        $member->city_state_zip = $data["City State Zip"];
        $member->first_name = $data["First Name"];
        $member->last_name = $data["Last Name"];
        $member->job_title = $data["Job Title"];
        $member->email = $data["Email"];
        $member->website = $data["Website"];
        $member->phone = $data["Phone"];
        $member->cell = $data["Cell"];
        $member->fax = $data["Fax"];
        $member->contact = $data["A/P Contact"];
        $member->ap_email = $data["A/P Email"];
        $member->description = $data["Company Description"];
        $member->referred_by = $data["Referred By"];
        $member->pass = $data["pass"];
        try {
            $result = $db->insertObject("jos_membership_directory", $member);
//            $id = $data["Record #"];
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage('Error on adding new member');
            $id = false;
        }
        return $id;
    }

    public function isExistedMemberId($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('count(*)')->from("jos_membership_directory")->where('id = ' . $db->quote($id));
        $db->setQuery($query);
        if ($result = $db->loadResult()) { //echo $email."-".$result ."<hr/>";
            return true;
        } else {
            return false;
        }
    }

    public function isExistedEmail($email) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('count(*)')->from("#__users")->where("email = '" . trim($email) . "'");
        $db->setQuery($query);

        if ($result = $db->loadResult()) {
            return true;
        } else {
            return false;
        }
    }

    public function test() {
        return "hello";
    }

    public function getDefaultPass() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "SELECT *  FROM jos_config WHERE name LIKE 'pass'";
        $db->setQuery($query);
        $config = $db->loadObject();
        return $config;
    }

}

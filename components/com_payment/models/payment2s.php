<?php

ini_set('display_errors', 1);
error_reporting(E_ERROR);
/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
require_once (JPATH_ROOT . '/components/com_payment/anet_php_sdk/AuthorizeNet.php');

/**
 * Methods supporting a list of Payment records.
 */
class PaymentModelPayment2s extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);



        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        return $query;
    }

    public function getItems() {
        return parent::getItems();
    }

    public function getBusinessCategories() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $results = array();
        $query->select("*")
                ->from('#__business_category')
                ->order('`name` ASC');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    public function specialprice() {
        $user = & JFactory::getUser();
        if (!$user->guest) {
            $price = '';
        } else {
            $price = "disabled=''";
        }
        return $price;
    }

    public function payment2() {
        $config = JFactory::getConfig();
        $METHOD_TO_USE = "AIM";
        // $METHOD_TO_USE = "DIRECT_POST";         // Uncomment this line to test DPM
        // pepmobile
        //96R58MdjjX
        //8bSP2P47yTr922Ur
        //
        //tannpv
        //3RymDC62VJ
        //552Sr9WK4Mc2mHxq
        //
        //live
//        define("AUTHORIZENET_API_LOGIN_ID", "96R58MdjjX");    // Add your API LOGIN ID8EA6t6wsT - 45hWRWJzc53Z
//        define("AUTHORIZENET_TRANSACTION_KEY", "8bSP2P47yTr922Ur"); // Add your API transaction key9LQ87528hxMdP5jY
        //test
//        define("AUTHORIZENET_API_LOGIN_ID", "3RymDC62VJ");    // Add your API LOGIN ID8EA6t6wsT - 45hWRWJzc53Z
//        define("AUTHORIZENET_TRANSACTION_KEY", "552Sr9WK4Mc2mHxq"); // Add your API transaction key9LQ87528hxMdP5jY
        define("AUTHORIZENET_API_LOGIN_ID", $config->get('au_login_id'));    // Add your API LOGIN ID8EA6t6wsT - 45hWRWJzc53Z
        define("AUTHORIZENET_TRANSACTION_KEY", $config->get('au_transac_key')); // Add your API transaction key9LQ87528hxMdP5jY
        define("AUTHORIZENET_SANDBOX", $config->get('au_test_mode'));        // Set to false to test against production
        define("TEST_REQUEST", "FALSE");           // You may want to set to true if testing against production
        // You only need to adjust the two variables below if testing DPM
        define("AUTHORIZENET_MD5_SETTING", "");                // Add your MD5 Setting. - dai123

        if (AUTHORIZENET_API_LOGIN_ID == "") {
            echo 'Error !!! LOGIN ID isn\'t not Blank.';
        }
        $data = JRequest::get('form1');

        if ($METHOD_TO_USE == "AIM") {

            $transaction = new AuthorizeNetAIM();
            $transaction->setSandbox(AUTHORIZENET_SANDBOX);  // AUTHORIZENET_SANDBOX  <- for test account - false for account LIVE
            $transaction->setFields(
                    array(
                        'amount' => $_POST['x_amount'],
                        'card_num' => $_POST['x_card_num'],
                        'exp_date' => $_POST['x_exp_date'],
                        'first_name' => $_POST['x_first_name'],
                        'last_name' => $_POST['x_last_name'],
                        'address' => $_POST['x_address'],
                        'city' => $_POST['x_city'],
                        'state' => $_POST['x_state'],
                        'country' => $_POST['x_country'],
                        'zip' => $_POST['x_zip'],
                        'email' => $_POST['x_email'],
                        'card_code' => $_POST['x_card_code'],
                    )
            );
            $response = $transaction->authorizeAndCapture();

            if ($response->approved) {
                $data = JRequest::get('form2');
                $data['reference'] = implode(',', $data['reference']);
                $price = $config->get('non_member_price');
                $num_member = $data['options2'];
                $data['payment_status'] = "Paid";
                $get_date = JFactory::getDate();
                $date = $get_date->toSql();
                $data['cc_number'] = $this->getCardNum($data);
                $data['payment_method'] = "Credit Card";
                $data['order_date'] = $date;
                $data['transaction_date'] = $date;
                $data['transaction_id'] = $response->transaction_id;
                $data["category"] = "Reverse Trade";
                $data['num_mem'] = $num_member;
                $data['price'] = $price;
                $data['total'] = $price * $num_member;
                $insertdata = $this->insert_user_payment($data);
                $email = JModel::getInstance('email', 'PaymentModel');
                $email->sendPaymentEmail($insertdata);
                $return_url = JURI::base() . 'thank-you.html?id=' . $insertdata;
                header('Location:' . $return_url);
            } else {
                $return_url1 = JURI::base() . 'payment-error.html?response_reason_code=' . $response->response_reason_code . '&response_code=' . $response->response_code . '&response_reason_text=' . $response->response_reason_text;
                header('Location:' . $return_url1);
            }
        } elseif (count($_POST)) {
            $response = new AuthorizeNetSIM;
            if ($response->isAuthorizeNet()) {
                if ($response->approved) {
                    // Transaction approved! Do your logic here.
                    // Redirect the user back to your site.
                    $return_url = JURI::base() . 'thank_you_page.php?transaction_id=' . $response->transaction_id;
                } else {
                    // There was a problem. Do your logic here.
                    // Redirect the user back to your site.
                    $return_url = JURI::base() . 'error_page.php?response_reason_code=' . $response->response_reason_code . '&response_code=' . $response->response_code . '&response_reason_text=' . $response->response_reason_text;
                }
                echo AuthorizeNetDPM::getRelayResponseSnippet($return_url);
            } else {
                echo "MD5 Hash failed. Check to make sure your MD5 Setting matches the one in config.php";
            }
        }
    }

    public function storePayment() {
        $data = JRequest::get('form2');
        $config = JFactory::getConfig();
        $price = $config->get('non_member_price');
        $num_member = $data['options2'];
        $data["payment_status"] = "Unpaid";
        $data["category"] = "Reverse Trade";
        $data['num_mem'] = $num_member;
        $data['price'] = $price;
        $data['total'] = $price * $num_member;
        $get_date = JFactory::getDate();
        $date = $get_date->toSql();
        $data['order_date'] = $date;
        $data['transaction_date'] = $date;
        $id = $this->insert_user_payment($data);
        $email = JModel::getInstance('email', 'PaymentModel');
        $email->sendPaymentEmail($id);
        $return_url = JURI::base() . "thank-you.html?id=" . $id . "&nopayment=1";
        header('Location:' . $return_url);
    }

    function getCardNum($dt) {
        if ($dt['x_card_num']) {
            $number = $dt['x_card_num'];
            $number = str_pad(substr($number, -4), strlen($number), '*', STR_PAD_LEFT);
            return $number;
        } else {
            return false;
        }
    }

    public function insert_user_payment($dt) {
        $db = JFactory::getDbo();
        $item = null;
        $item1 = null;
        $m = null;
        $nm = null;
        foreach ($dt['member'] as $member) {
            $item = implode(":", $member);
            $m = $m . "," . $item;
        }
        $m = trim($m);
        $m = ltrim($m, ',');
        foreach ($dt['non_mem'] as $nonmember) {
            $item1 = implode(":", $nonmember);
            $nm = $nm . "," . $item1;
        }
        $nm = trim($nm);
        $nm = ltrim($nm, ',');
        // get date time in joomla
        $date = & JFactory::getDate();
        $date_order = $date->toFormat();
        $insert = new stdClass();
        $insert->id = '';
        $insert->first_name = $dt["firstname1"];
        $insert->last_name = $dt["lastname1"];
        $insert->company = $dt["company"];
        $insert->business_category = $dt['pay'];
        $insert->date_order = $date_order;
        $insert->category = $dt["category"];
        $insert->email = $dt["email1"];
        $insert->phone = $dt["phone1"];
        $insert->address = $dt["address1"];

        $insert->num_mem = $dt["options1"];
        $insert->mem_name_ticket = $m;
        $insert->num_non_mem = $dt["options2"];
        $insert->non_mem_name_ticket = $nm;
        $insert->total = $dt["total"];
        $insert->first_name_cart = $dt["x_first_name"];
        $insert->last_name_cart = $dt["x_last_name"];
        $insert->city = $dt["city1"];
        $insert->state = $dt["state1"];
        $insert->zip = $dt["zip1"];
        //Billing info
        $insert->billing_first_name = $dt["x_first_name"];
        $insert->billing_last_name = $dt["x_last_name"];
        $insert->billing_address = $dt["x_address"];
        $insert->billing_city = $dt["x_city"];
        $insert->billing_state = $dt["x_state"];
        $insert->billing_zip = $dt["x_zip"];
        $insert->special_instructions = $dt["special_instructions"];
        if ($dt["transaction_id"]) {
            $insert->transaction_id = $dt["transaction_id"];
            $insert->pay_by = $dt['pay_by'];
            $insert->cc_number = $dt['cc_number'];
            $insert->payment_method = $dt['payment_method'];
            $insert->cc_card_type = $dt['x_card_type'];
        }
        $insert->order_date = $dt['order_date'];
        $insert->transaction_date = $dt['transaction_date'];
        $insert->payment_status = $dt['payment_status'];
        $insert->category = $dt['category'];
        $insert->reference = $dt['reference'];
        try {
            // Insert the object into the user profile table.
            $result = $db->insertObject('#__payment', $insert);

            $id = $db->insertid();
        } catch (Exception $e) {
            
        }
        // save transaction
        $tran = JModel::getInstance('transaction', 'PaymentModel');
        $tran->save($id);
        return $id;
    }

}

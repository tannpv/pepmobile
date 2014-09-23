<?php

defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.application.component.controlleradmin');
jimport('joomla.application.component.controller');

class Membership_directoryControllerImport extends JControllerAdmin {
    /*
     * The folder we are uploading into
     */

    protected $folder = '';

    /**
     * Upload one or more files
     *
     * @since 1.5
     */
    public function upload() {
        // Check for request forgeries
        JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
        $params = JComponentHelper::getParams('com_membership_directory');
        // Get some data from the request
        $files = JRequest::getVar('Filedata', '', 'files', 'array');
        $return = JRequest::getVar('return-url', null, 'post', 'base64');
        $this->folder = JRequest::getVar('folder', '', '', 'path');
        if (!$files['name'][0]) {
            JError::raiseWarning(100, "Please select a spreadsheet file");
            $this->setRedirect("index.php?option=com_membership_directory&view=import");
            return false;
        }
        if (!$this->isValidUploadFileType($files)) {
            JError::raiseWarning(100, "Please select a spreadsheet file (xls,xlsx)");
            $this->setRedirect("index.php?option=com_membership_directory&view=import");
            return false;
        }

        if (
        //$_SERVER['CONTENT_LENGTH']>($params->get('upload_maxsize', 0) * 1024 * 1024) ||
                $_SERVER['CONTENT_LENGTH'] > (int) (ini_get('upload_max_filesize')) * 1024 * 1024 ||
                $_SERVER['CONTENT_LENGTH'] > (int) (ini_get('post_max_size')) * 1024 * 1024 ||
                (($_SERVER['CONTENT_LENGTH'] > (int) (ini_get('memory_limit')) * 1024 * 1024) && ((int) (ini_get('memory_limit')) != -1))
        ) {

            JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_WARNFILETOOLARGE'));
            return false;
        }
        // Input is in the form of an associative array containing numerically indexed arrays
        // We want a numerically indexed array containing associative arrays
        // Cast each item as array in case the Filedata parameter was not sent as such
        $files = array_map(array($this, 'reformatFilesArray'), (array) $files['name'], (array) $files['type'], (array) $files['tmp_name'], (array) $files['error'], (array) $files['size']
        );

        // Perform basic checks on file info before attempting anything
        foreach ($files as &$file) {
            if ($file['error'] == 1) {
                JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_WARNFILETOOLARGE'));
                return false;
            }
            if (JFile::exists($file['filepath'])) {
                // A file with this name already exists
                //  JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_FILE_EXISTS'));
                unlink($file['filepath']);
                // return false;
            }

            if (!isset($file['name'])) {
                // No filename (after the name was cleaned by JFile::makeSafe)
                $this->setRedirect('index.php', JText::_('COM_MEDIA_INVALID_REQUEST'), 'error');
                return false;
            }
        }

        // Set FTP credentials, if given
        JClientHelper::setCredentialsFromRequest('ftp');
        JPluginHelper::importPlugin('content');
        $dispatcher = JDispatcher::getInstance();

        foreach ($files as &$file) {

            // Trigger the onContentBeforeSave event.
            $object_file = new JObject($file);
            $result = $dispatcher->trigger('onContentBeforeSave', array('com_membership_directory.import', &$object_file));
            if (in_array(false, $result, true)) {
                // There are some errors in the plugins
                JError::raiseWarning(100, JText::plural('COM_MEDIA_ERROR_BEFORE_SAVE', count($errors = $object_file->getErrors()), implode('<br />', $errors)));
                return false;
            }

            if (!JFile::upload($file['tmp_name'], $file['filepath'])) {

                // Error in upload
                JError::raiseWarning(100, JText::_('Unable to upload file!'));
                $this->setRedirect("index.php?option=com_membership_directory&view=import");
                return false;
            } else {

                // Trigger the onContentAfterSave event.
                $dispatcher->trigger('onContentAfterSave', array('com_membership_directory.import', &$object_file, true));
//                $this->setMessage(JText::sprintf('COM_MEDIA_UPLOAD_COMPLETE', substr($file['filepath'], strlen(COM_MEDIA_BASE))));
                if (!$this->isValidFileStructure($file['filepath'])) {
                    JError::raiseWarning(100, "Invalid the structure for the filed uploaded. The columns of the uploaded file must contains the onces required by sample files");
                    $this->setRedirect("index.php?option=com_membership_directory&view=import");
                    return false;
                }
                if (!$this->checkConfig()) {
                    JError::raiseWarning(100, "Please set your default password!");
                    $this->setRedirect("index.php?option=com_membership_directory&view=import");
                    return false;
                }

                $import = $this->getModel("import");
                $status = $import->process($file['filepath']);

                $this->setRedirect('index.php?option=com_membership_directory');
            }
        }
        return true;
    }

    /**
     * Used as a callback for array_map, turns the multi-file input array into a sensible array of files
     * Also, removes illegal characters from the 'name' and sets a 'filepath' as the final destination of the file
     *
     * @param	string	- file name			($files['name'])
     * @param	string	- file type			($files['type'])
     * @param	string	- temporary name	($files['tmp_name'])
     * @param	string	- error info		($files['error'])
     * @param	string	- file size			($files['size'])
     *
     * @return	array
     * @access	protected
     */
    protected function reformatFilesArray($name, $type, $tmp_name, $error, $size) {
        $name = JFile::makeSafe($name);
        return array(
            'name' => $name,
            'type' => $type,
            'tmp_name' => $tmp_name,
            'error' => $error,
            'size' => $size,
            'filepath' => JPath::clean(implode(DIRECTORY_SEPARATOR, array(COM_MEDIA_BASE, $this->folder, $name)))
        );
    }

    protected function isValidFileStructure($file) {
        $model = $this->getModel("import");
        return $model->validate($file);
    }

    protected function checkConfig() {
        $model = $this->getModel("import");
        if ($model->getDefaultPass()) {
            return true;
        } else {
            return false;
        }
    }

    protected function isValidUploadFileType($files) {
        if (!in_array($files['type'][0], array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel"))) {
            return false;
        } else {
            return true;
        }
    }

    protected function authoriseUser($action) {
        if (!JFactory::getUser()->authorise('core.' . strtolower($action), 'com_media')) {
            // User is not authorised
            JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_' . strtoupper($action) . '_NOT_PERMITTED'));
            return false;
        }

        return true;
    }

}

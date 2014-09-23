<?php

defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.application.component.controlleradmin');
jimport('joomla.application.component.controller');

class Membership_directoryControllerPass_change extends JControllerAdmin {

    public function apply() {
        $app = JFactory::getApplication();
        $data = JRequest::getVar('jform', array(), 'post', 'array');
        //var_dump($data['pass']);exit;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "UPDATE jos_membership_directory SET pass=" . $db->quote($data['pass']) . ", uptodate=-1";
        //echo $query;exit;
        $db->setQuery($query);
        $db->query();
        //jos_users's password
        $salt = JUserHelper::genRandomPassword(32);
        $crypt = JUserHelper::getCryptedPassword($data ["pass"], $salt);
        $pass = $crypt . ':' . $salt;
        $query1 = $db->getQuery(true);
        $query1->update('#__users')->set(array($db->quoteName("password") . "=" . $db->quote($pass)))
                ->where($db->quoteName("username") . "NOT IN(" . $db->quote('admin') . "," . $db->quote('superadmin') . ")");
        //echo $query1;exit;
        $db->setQuery($query1);
        $db->query();
        if ($data['pass']) { 
            $this->saveConfig($data);
        }
        $this->setRedirect(JRoute::_('index.php?option=com_membership_directory&view=directorys', false));
    }

    public function saveConfig($data) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "DELETE FROM jos_config WHERE name LIKE 'pass'";
        $db->setQuery($query);
        $db->query();
        $config = new stdClass();
        $config->name = "pass";
        $config->value = $data['pass'];
        $db->insertObject("jos_config", $config);
    }

}
?>


<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */

// No direct access
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.controllerform' );

/**
 * Directory controller class.
 */
class Membership_directoryControllerDirectory extends JControllerForm {
	function __construct() {
		$this->view_list = 'directorys';
		parent::__construct ();
	}
	function save() {
		$app = JFactory::getApplication ();
		$data = JRequest::getVar ( 'jform', array (), 'post', 'array' );
//                var_dump($data);exit;
		$model = $this->getModel ();
		$result = $model->check_exist_email ( $data );
		if (! $result) {
			$this->view_list = 'directorys';
			parent::save ();
			$model = $this->getModel ();
			$id = $model->getDbo ()->loadResult ();
			if ($data ['id']) {
				$user_id = $model->updateUser ( $data );
			} else {
				$data ['id'] = $id;
				$user_id = $model->addUser ( $data );
                                JUserHelper::addUserToGroup($user_id, 14);
			}
                        
			$app->setUserState ( 'com_membership_directory.edit.directory.data', null );
			$this->setRedirect ( JRoute::_ ( 'index.php?option=com_membership_directory&view=directorys', false ) );
		} else {
			$app->setUserState ( 'com_membership_directory.edit.directory.data', $data );
			$this->setMessage ( JText::_ ( 'JLIB_DATABASE_ERROR_EMAIL_INUSE' ), 'warning' );
			$this->setRedirect ( JRoute::_ ( 'index.php?option=com_membership_directory&view=directory&layout=edit&id='.$data['id'], false ) );
			// return false;
		}
	}
}
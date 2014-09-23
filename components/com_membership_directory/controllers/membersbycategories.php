<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */

// No direct access.
defined('_JEXEC') or die;
//var_dump($_REQUEST); exit;
require_once JPATH_COMPONENT.'/controller.php';

/**
 * Membersbycategories list controller class.
 */
class Membership_directoryControllerMembersbycategories extends Membership_directoryController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Membersbycategories', $prefix = 'Membership_directoryModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}
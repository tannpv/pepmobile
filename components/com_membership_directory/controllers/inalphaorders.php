<?php
if(isset($_REQUEST[myform])) {echo "tt";} else {echo "ktt";};
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Inalphaorders list controller class.
 */
class Membership_directoryControllerInalphaorders extends Membership_directoryController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Inalphaorders', $prefix = 'Membership_directoryModel')
	{ 
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	
}
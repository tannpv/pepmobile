<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';
if(JFactory::getUser()->username==="superadmin")
{
$buttons = modQuickIconHelper::getButtons($params);
}
 else {
    $buttons= modQuickIconHelper::getButtonsData($params)  ; 
}
require JModuleHelper::getLayoutPath('mod_quickicon', $params->get('layout', 'default'));
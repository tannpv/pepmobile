<?php

/**
 * @version		$Id: helper.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.html.select' );
require_once (JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
//require_once (JPATH_SITE . DS . 'simpleresizeimage.php');

class modShowdatabaseHelper {

    function getList($catid) {
        global $mainframe;

        $db =& JFactory::getDBO();
		
        if (JSite::getMenu()->getActive()->alias == "in-alpha-order") {
        // lay ra field company,website, loai bo ten trung nhau
        $query = " SELECT company,website FROM #__membership_directory 
                   GROUP BY company
                   HAVING COUNT(*) > 1"
;
		
		}
		if (JSite::getMenu()->getActive()->alias == "members-by-categories"){
		$query = " SELECT DISTINCT business_category FROM #__membership_directory 
                   "
;       
		}
		if (JSite::getMenu()->getActive()->alias == "members-in-the-news"){
		$query = " SELECT id,company,website FROM #__membership_directory 
                   Order BY id DESC LIMIT 10"
;
		}
		$db->setQuery((string) $query);
        $lists = $db->loadObjectList();
		return $lists;
    }
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		$this->addToolbar();
        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', '');
        Membership_directoryHelper::addSubmenu($view);
        
		parent::display($tpl);
	}
}

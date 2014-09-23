<?php
/**
 * @version		$Id: view.html.php 21677 2011-06-25 20:56:56Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
require_once JPATH_COMPONENT.'/models/category.php';

/**
 * HTML Contact View class for the Contact component
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since 		1.5
 */
class ContactViewReportpollution extends JView
{
	function display($tpl = null)
	{
            $doc            = JFactory::getDocument();
            $content       = $this->get('Category');
            
		// Check for errors.
            if (count($errors = $this->get('Errors'))) {
                    JError::raiseWarning(500, implode("\n", $errors));

                    return false;
            }
            $params = JComponentHelper::getParams('com_contact');
            
            $this->assignRef('params',		$params);
            $this->assignRef('title', $title);
            $this->assignRef('content', $content);

            parent::display($tpl);
	}
}

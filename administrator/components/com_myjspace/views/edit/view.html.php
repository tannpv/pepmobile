<?php
/**
* @version $Id: view.html.php $
* @version		1.7.7 07/02/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.parameter' );

class MyjspaceViewEdit extends JView
{
	function display($tpl = null)
	{
		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		
		// E_name for tags button 
		$e_name = JRequest::getVar( 'e_name' , 'mjs_editable');
		
		$this->assignRef('e_name', $e_name);
		
		parent::display($tpl);
	}
	
}

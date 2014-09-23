<?php
/**
* @version $Id: view.php $
* @version		1.8.0 2704/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011-2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MyjspaceViewHelp extends JView
{
	/**
	 * display method of BSbanner view
	 * @return void
	 **/
	function display($tpl = null)
	{	
		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'user.php';
		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'util.php';
		
	// Menu bar
		JToolBarHelper::title( JText::_( 'COM_MYJSPACE_HOME' ) .': <small>'.JText::_( 'COM_MYJSPACE_HELP' ).'</small>','help_header.png' );

	// Content
		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');
		$file_max_size = $pparams->get('file_max_size',204800);
		$editor_selection = $pparams->get('editor_selection', 'myjsp');

		// Page root folder
		$user_page = New BSHelperUser();
		$dirname = JPATH_ROOT.DS.$user_page->getFoldername();
		if (is_writable($dirname))
			$iswritable = 1;
		else
			$iswritable = 0;
			
		// Check all index format (=version)
		$nb_index_ko = BSHelperUser::CheckVersionIndexPage();

		// Report
		$report_js = "
		window.addEvent('domready', function(){
				$('link_sel_all').addEvent('click', function(e){
					$('report').select();
				});
			});
		";
		$report = configuration_report();
		$report .= ' [quote]';
		$report .= '[b]Editor selection:[/b] '.$editor_selection;
		$report .= ' | [b]Index Format:[/b] ';
		if ($nb_index_ko == 0)
			$report .= ' ok';
		else
			$report .= ' ko';
		$report .= ' | [b]Link as folder:[/b] ';			
		if ($pparams->get('link_folder', 1) == 1)
			$report .= ' yes';
		else
			$report .= ' no';	
		$report .= ' | [b]Root Page dir:[/b] '.$user_page->getFoldername();
		$report .= ' | [b]Root Page dir writable:[/b] ';
		if ($iswritable == 1)
			$report .= ' ok';
		else
			$report .= ' ko';
		$report .= '[/quote]';
		
		$this->assignRef('file_max_size',$file_max_size);
		$this->assignRef('iswritable',$iswritable);
		$this->assignRef('editor_selection',$editor_selection);
		$this->assignRef('nb_index_ko',$nb_index_ko);
		$this->assignRef('report_js',$report_js);
		$this->assignRef('report',$report);		
				
		parent::display($tpl);
	}
}

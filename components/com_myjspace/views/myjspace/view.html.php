<?php
/**
* @version $Id: view.html.php $ 
* @version		1.7.2 28/09/2010
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

jimport( 'joomla.application.component.view');

class MyjspaceViewMyjspace extends JView
{
	function display($tpl = null)
	{		
        require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'version.php';
	
		// Config
		$pparams = &JComponentHelper::getParams('com_myjspace');

        $version = BS_Helper_version::get_version();
		
		$app = &JFactory::getApplication();
		$document = &JFactory::getDocument();		

        // Web page title
		if ($pparams->get('pagetitle',1) == 1) {
			$title = JText::_('COM_MYJSPACE_TITLE');
			if (empty($title)) {
				$title = $app->getCfg('sitename');
			} elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
				$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
			} elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
				$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
			}
			if ($title)
				$document->setTitle($title);
		}		

		// Breadcrumbs
		$pathway =& $app->getPathway();
		$pathway->addItem(JText::_('COM_MYJSPACE_PAGE'), Jroute::_('index.php?option=com_myjspace&view=config'));
		$pathway->addItem(JText::_('COM_MYJSPACE_TITLE', ''));	
		
		// Var assign
        $this->assignRef( 'version', $version );

		parent::display($tpl);
	}
}
?>

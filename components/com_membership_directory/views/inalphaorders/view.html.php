<?php

/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Membership_directory.
 */
class Membership_directoryViewInalphaorders extends JView {

    protected $items;
    protected $pagination;
    protected $state;
    protected $params;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $app = JFactory::getApplication();
        $this->items = $this->get('Items');
        $this->state = $this->get('State');
        // $this->pagination	= $this->get('Pagination'); 
        $this->params = $app->getParams('com_membership_directory');
        //////////////////////////////////////////////////////////////////////
        $model = new Membership_directoryModelInalphaorders();
        //var_dump($model ->sortabc()); exit;
        $data = $model->sortabc();
        $this->assignRef('vari', $data);
        /////////////////////////////////////////////////////////////////////
        $data1 = $model->getbusinessdirectory();
        $this->assignRef('bdirect', $data1);
        //////////////////////////////////////////////////////////////////////
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            ;
            throw new Exception(implode("\n", $errors));
        }

        $this->_prepareDocument();
        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
        $document = &JFactory::getDocument();
        $document->addStyleSheet(JUri::root() . 'components/com_membership_directory/css/ui.jqgrid.css');
        $document->addScript(JUri::root() . "components/com_membership_directory/js/jquery-1.9.0.min.js");
        $document->addScript(JUri::root() . "components/com_membership_directory/js/grid.locale-en.js");
        $document->addScript(JUri::root() . "components/com_membership_directory/js/jquery.jqGrid.src.js");
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('com_membership_directory_DEFAULT_PAGE_TITLE'));
        }
        $title = $this->params->get('page_title', '');
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

}
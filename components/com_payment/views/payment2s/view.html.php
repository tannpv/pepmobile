<?php

/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Payment.
 */
class PaymentViewPayment2s extends JView {

    protected $items;
    protected $pagination;
    protected $state;
    protected $params;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $app = JFactory::getApplication();

        $this->state = $this->get('State');


        $this->params = $app->getParams('com_payment');
        $document = JFactory::getDocument();
        $document->addStyleSheet("components/com_payment/assets/contact.css");
        $document->addStyleSheet("components/com_payment/assets/css/creditCardTypeDetector.css");

        $document->addScript($this->baseurl . 'components/com_payment/assets/js/jquery-1.4.4.min.js');
        $document->addScript($this->baseurl . 'components/com_payment/assets/js/jquery.validate.min.js', 'text/javascript', true);
        $document->addScript($this->baseurl . 'components/com_payment/assets/js/jquery.validate.creditcardtypes.js', 'text/javascript', true);
        $document->addScript($this->baseurl . 'components/com_payment/assets/js/add_field_rtp.js', 'text/javascript', true);
        $document->addScript($this->baseurl . 'components/com_payment/assets/js/jquery.creditCardTypeDetector.js', 'text/javascript', true);

        $document->addScriptDeclaration('
				
                                ');

        //////////////////////////////////////////////////////////////////////
        $model = new PaymentModelPayment2s();
        $data = $model->specialprice();
        $bussniess_categories =$model->getBusinessCategories();
        $this->assignRef("bussniess_categories", $bussniess_categories);
        $this->assignRef('specialprices', $data);
        /////////////////////////////////////////////////////////////////////
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
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('com_payment_DEFAULT_PAGE_TITLE'));
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

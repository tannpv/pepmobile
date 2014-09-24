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
class PaymentViewHistories extends JView {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();

        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', '');
        PaymentHelper::addSubmenu($view);

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/payment.php';

        $state = $this->get('State');
        $canDo = PaymentHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_PAYMENT_TITLE_CUSTOMERS'), 'customers.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/customer';
        JToolBarHelper::custom('Customer.export_report', 'dexcelicon', 'dexcelicon', JText::_('Export'), false);
        if (file_exists($formPath)) {

//            if ($canDo->get('core.create')) {
//                JToolBarHelper::addNew('customer.add', 'JTOOLBAR_NEW');
//            }

//            if ($canDo->get('core.edit') && isset($this->items[0])) {
//                JToolBarHelper::editList('customer.edit', 'JTOOLBAR_EDIT');
//            }
        }
        //If this component does not use state then show a direct delete button as we can not trash
//        JToolBarHelper::deleteList('Are you sure to delete the selected orders?', 'customers.delete', 'JTOOLBAR_DELETE');
    }

}

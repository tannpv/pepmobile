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
class PaymentViewConfig extends JView
{

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{

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
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/payment.php';

		$state	= $this->get('State');
		$canDo	= PaymentHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('Config'), 'dconfig.png');


		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_payment');
		}


	}
}

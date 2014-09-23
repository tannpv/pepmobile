<?php
/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Payment1s list controller class.
 */
class PaymentControllerThankyou extends PaymentController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Thankyou', $prefix = 'PaymentModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	public function submit(){
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$params = JComponentHelper::getParams('com_payment');	
		
                // Initialise variables.
                $app    = JFactory::getApplication();
                $model  = $this->getModel('thankyou');
				

	}
}
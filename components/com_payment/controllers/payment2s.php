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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Payment2s list controller class.
 */
class PaymentControllerPayment2s extends PaymentController {

    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function &getModel($name = 'Payment2s', $prefix = 'PaymentModel') {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    public function submit() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $params = JComponentHelper::getParams('com_payment');
//echo $params;exit();
// Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('payment2s');

//load data from contactform Form in view
        $data = JRequest::get('form2');


        $up2autho = $model->payment2($data);
    }

   

}

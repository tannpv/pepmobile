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
 * Payment4s list controller class.
 */
class PaymentControllerPayment4s extends PaymentController {

    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function &getModel($name = 'Payment4s', $prefix = 'PaymentModel') {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    public function submit() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $params = JComponentHelper::getParams('com_payment');
        //echo $params;exit();
        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('payment4s');

        //load data from contactform Form in view
        $data = JRequest::get('form2');
        if ($_POST['pay_later']) {
            $model->storePayment();
        } else {
            $up2autho = $model->payment4($data);
        }
    }

}

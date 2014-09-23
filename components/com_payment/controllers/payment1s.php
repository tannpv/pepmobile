<?php

ini_set('display_errors', 1);
error_reporting(E_ERROR);
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
 * Payment1s list controller class.
 */
class PaymentControllerPayment1s extends PaymentController {

    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function &getModel($name = 'Payment1s', $prefix = 'PaymentModel') {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    public function submit() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        $params = JComponentHelper::getParams('com_payment');

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('payment1s');

        //load data from contactform Form in view
        $data = JRequest::get('form1');

        // call function in Models to process data
        if ($_POST['pay_later']) {
            $model->storePayment();
        } else {
            $up2autho = $model->payment($data);
        }
    }

    public function sendEmail() {
        $model = $this->getModel('payment1s');
        $jinput = JFactory::getApplication()->input;
        $order_id = $jinput->get('order_id', 0, 'INT');
        $model->sendPaymentEmail($order_id);
    }

    public function testTran() {
        $model = $this->getModel('transaction');
        $jinput = JFactory::getApplication()->input;
        $order_id = $jinput->get('order_id', 0, 'INT');
        $model->save($order_id);
    }

}

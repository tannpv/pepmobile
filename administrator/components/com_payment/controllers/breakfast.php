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

jimport('joomla.application.component.controllerform');

/**
 * Breakfast controller class.
 */
class PaymentControllerBreakfast extends JControllerForm {

    function __construct() {
        $this->view_list = 'breakfasts';
        parent::__construct();
    }

    public function preview() {
        
    }

    public function save() {
        $model = $this->getModel();
        if ($model->saveConfig()) {
            $this->setRedirect(JRoute::_('index.php?option=com_payment&view=breakfast', false));
        }
    }

    public function cancel($key = null) {
        $this->setRedirect(JRoute::_('index.php?option=com_payment&view=customers', false));
    }

}

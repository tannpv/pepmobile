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
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * Methods supporting a list of Payment records.
 */
class PaymentModelTransaction extends JModel {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function save($order_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('#__payment')
                ->where('id=' . $order_id);
        $db->setQuery($query);
        $data = $db->loadObject();
        $date = & JFactory::getDate();
        $date_order = $date->toFormat();
        $insert = new stdClass();

        $insert->payment_id = $data->id;
        $insert->first_name = $data->first_name;
        $insert->last_name = $data->last_name;
        $insert->business_category = $data->business_category;
        $insert->date_order = $data->date_order;
        $insert->order_date = $data->order_date;

        $insert->email = $data->email;
        $insert->phone = $data->phone;
        $insert->address = $data->address;
        $insert->company = $data->company;
        $insert->num_mem = $data->num_mem;
        $insert->mem_name_ticket = $data->mem_name_ticket;
        $insert->num_non_mem = $data->num_non_mem;
        $insert->non_mem_name_ticket = $data->non_mem_name_ticket;
        $insert->total = $data->total;
        $insert->first_name_cart = $data->first_name_cart;
        $insert->last_name_cart = $data->last_name_cart;
        $insert->city = $data->city;
        $insert->state = $data->state;
        $insert->zip = $data->zip;
//Billing info
        $insert->billing_first_name = $data->billing_first_name;
        $insert->billing_last_name = $data->billing_last_name;
        $insert->billing_address = $datat->billing_address;
        $insert->billing_city = $data->billing_city;
        $insert->billing_state = $data->billing_state;
        $insert->billing_zip = $data->billing_zip;
        $insert->special_instructions = $data->special_instructions;
        $insert->transaction_id = $data->transaction_id;
        $insert->pay_by = $data->pay_by;
        $insert->cc_number = $data->cc_number;
        $insert->payment_method = $data->payment_method;
        $insert->cc_card_type = $data->cc_card_type;
        $insert->order_date = $data->order_date;
        $insert->transaction_date = $data->transaction_date;
        $insert->payment_status = $data->payment_status;
        $insert->category = $data->category;
       
        try {
            $result = $db->insertObject('#__payment_transaction', $insert);
            $id = $db->insertid();
        } catch (Exception $e) {
            echo "Insert Fail !!!";
        }
        return $id;
    }

}

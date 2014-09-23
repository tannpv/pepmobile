<?php

/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Payment records.
 */
class PaymentModelBreakfast extends JModel {

    protected $_config = array();

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function saveConfig() {
        $db = $this->getDbo();
        $jinput = JFactory::getApplication()->input;
        $month = $jinput->get('month');
        //deleting existing selected month
        $query = $db->getQuery(true);
        $query = "DELETE FROM #__payment_breakfast WHERE name LIKE 'month'";
        $db->setQuery($query);
        $db->query();
        $config = new stdClass();
        $config->name = "month";
        $config->value = $month;
        $db->insertObject("#__payment_breakfast", $config);
        return true;
    }

    public function getDefaultMonth() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "SELECT *  FROM jos_payment_breakfast WHERE name LIKE 'month'";
        $db->setQuery($query);
        $config = $db->loadObject();
        return $config;
    }

    public function getConfig($name) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "SELECT *  FROM jos_payment_breakfast WHERE name LIKE '".$name."'";
        $db->setQuery($query);
        $config = $db->loadObject();

        return $config;
    }

}

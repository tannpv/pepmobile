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
require_once (JPATH_ROOT . '/components/com_payment/anet_php_sdk/AuthorizeNet.php');
require_once(JPATH_ROOT . '/libraries/Smarty/Smarty.class.php');

/**
 * Methods supporting a list of Payment records.
 */
class PaymentModelEmail extends JModel {

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

    public function sendPaymentEmail($order_id) {
        $db = JFactory::getDbo();
        $smarty = new Smarty();
        $mailer = JFactory::getMailer();
        $smarty->setTemplateDir(JPATH_ROOT . '/smarty/templates');
        $smarty->setCompileDir(JPATH_ROOT . '/smarty/templates_c');
        $smarty->setCacheDir(JPATH_ROOT . '/smarty/cache');
        $smarty->setConfigDir(JPATH_ROOT . '/smarty/configs');
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('#__payment')
                ->where('id=' . $order_id);
        $db->setQuery($query);
        $data = $db->loadObject();
        $non_members = split(",", $data->non_mem_name_ticket);
        $members = split(",", $data->mem_name_ticket);
        $smarty->assign('data', $data);
        $smarty->assign('non_members', $non_members);
        $smarty->assign('members', $members);

        $config = JFactory::getConfig();
        $sender = array(
            $config->getValue('config.mailfrom'),
            $config->getValue('config.fromname'));
        $mailer->addRecipient($data->email);
        $body = $smarty->fetch('email.tpl');
        if ($data->category == "Reverse Trade") {
          $data->category="Reverse Trade Show Ticket";
        } else {
                $data->category= $data->category." Ticket";
        }
        $mailer->setSubject($data->category);
        $mailer->setBody($body);
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $send = $mailer->Send();
        // JFactory::getApplication()->dump($body);
    }

    public function printPaymentEmail($order_id) {
        $db = JFactory::getDbo();
        $smarty = new Smarty();
        $mailer = JFactory::getMailer();
        $smarty->setTemplateDir(JPATH_ROOT . '/smarty/templates');
        $smarty->setCompileDir(JPATH_ROOT . '/smarty/templates_c');
        $smarty->setCacheDir(JPATH_ROOT . '/smarty/cache');
        $smarty->setConfigDir(JPATH_ROOT . '/smarty/configs');
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('#__payment')
                ->where('id=' . $order_id);
        $db->setQuery($query);
        $data = $db->loadObject();
        $non_members = split(",", $data->non_mem_name_ticket);
        $members = split(",", $data->mem_name_ticket);
        $smarty->assign('data', $data);
        $smarty->assign('non_members', $non_members);
        $smarty->assign('members', $members);

        $body = $smarty->fetch('email.tpl');
        return $body;
    }

}

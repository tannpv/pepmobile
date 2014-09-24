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
 * Customer controller class.
 */
class PaymentControllerCustomer extends JControllerForm {

    function __construct() {
        $this->view_list = 'customers';
        parent::__construct();
    }

    public function export_excel() {
        $joomla_table = 'payment'; //Edit for one simple table export (no need table prefix)

        $query = ""; // Edit here if you want COMPLEX selects from table(s)/especific fields
//TODO: make this code a bit more 'Joomla Framework Like'

        $app = JFactory::getApplication();

        $table = $app->getCfg('dbprefix') . $joomla_table;

        if (!$query) {
            // $query = "SELECT * FROM $table";
            $query = "SELECT
                            jos_payment.id AS order_number,
                            jos_payment.first_name,
                            jos_payment.last_name,
                            jos_payment.company,
                            jos_payment.address,
                            jos_payment.city,
                            jos_payment.state,
                            jos_payment.zip,
                            jos_payment.email,
                            jos_payment.phone,
                            jos_payment.business_category,
                            jos_payment.billing_address,
                            jos_payment.billing_city,
                            jos_payment.billing_state,
                            jos_payment.billing_zip,
                            jos_payment.category,
                            jos_payment.reference,
                            jos_payment.payment_status,
                            jos_payment.special_instructions,
                            jos_payment.cc_number,
                            jos_payment.order_date,
                            jos_payment.payment_method,
                            jos_payment.billing_last_name,
                            jos_payment.billing_first_name,
                            jos_payment.num_mem AS number_of_member,
                            jos_payment.mem_name_ticket AS member_name,
                            jos_payment.num_non_mem AS number_of_non_member,
                            jos_payment.non_mem_name_ticket AS non_member_name,
                            jos_payment.total
                            FROM
                            jos_payment
                            ";
        }

        $host = $app->getCfg('host');
        $db = $app->getCfg('db');
        $user = $app->getCfg('user');
        $password = $app->getCfg('password');
        $myquery = mysql_query($query);
        $fields_cnt = mysql_num_fields($myquery);
        $time = date('m.d.y-H.i.s');
        $filenameoutput = "Report-{$joomla_table}_{$time}";

//Output CSV Options

        $line_terminated = "\n";
        $field_terminated = ",";
        $enclosed = '"';
        $escaped = '\\';
        $export_schema = '';



        for ($i = 0; $i < $fields_cnt; $i++) {

            $l = $enclosed . str_replace($enclosed, $escaped . $enclosed, stripslashes(mysql_field_name($myquery, $i))) . $enclosed;

            $export_schema .= $l;
            $export_schema .= $field_terminated;
        }
        $export_schemas = str_replace("total", "Purchase_Amount", $export_schema);
        $output = trim(substr($export_schemas, 0, -1));

        $output .= $line_terminated;

        while ($row = mysql_fetch_array($myquery)) {

            $export_schema = '';

            for ($j = 0; $j < $fields_cnt; $j++) {
                if ($row[$j] == '0' || $row[$j] != '') {
                    if ($enclosed == '') {
                        $export_schema .= $row[$j];
                    } else {
                        $export_schema .= $enclosed .
                                str_replace($enclosed, $escaped . $enclosed, $row[$j]) . $enclosed;
                    }
                } else {
                    $export_schema .= '';
                }


                if ($j < $fields_cnt - 1) {
                    $export_schema .= $field_terminated;
                }
            }

            $output .= $export_schema;
            $output .= $line_terminated;
        }

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Length: " . strlen($output));
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename={$filenameoutput}.csv");

        echo $output;
        exit;
        $app->close();
    }

    public function export_report() {
        $joomla_table = 'payment_transaction'; //Edit for one simple table export (no need table prefix)

        $query = ""; // Edit here if you want COMPLEX selects from table(s)/especific fields
//TODO: make this code a bit more 'Joomla Framework Like'

        $app = JFactory::getApplication();

        $table = $app->getCfg('dbprefix') . $joomla_table;

        if (!$query) {
            $query = "SELECT
                            id AS order_number,
                            first_name,
                            last_name,
                            company,
                            address,
                            city,
                            state,
                            zip,
                            email,
                            phone,
                            business_category,
                            billing_address,
                            billing_city,
                            billing_state,
                            billing_zip,
                            category,
                            reference,
                            payment_status,
                            special_instructions,
                            cc_number,
                            order_date,
                            payment_method,
                            billing_last_name,
                            billing_first_name,
                            num_mem AS number_of_member,
                            mem_name_ticket AS member_name,
                            num_non_mem AS number_of_non_member,
                            non_mem_name_ticket AS non_member_name,
                            total
                            FROM
                            jos_payment_transaction
                            ";
        }

        $host = $app->getCfg('host');
        $db = $app->getCfg('db');
        $user = $app->getCfg('user');
        $password = $app->getCfg('password');
        $myquery = mysql_query($query);
        $fields_cnt = mysql_num_fields($myquery);
        $time = date('m.d.y-H.i.s');
        $filenameoutput = "Report-{$joomla_table}_{$time}";

//Output CSV Options

        $line_terminated = "\n";
        $field_terminated = ",";
        $enclosed = '"';
        $escaped = '\\';
        $export_schema = '';



        for ($i = 0; $i < $fields_cnt; $i++) {

            $l = $enclosed . str_replace($enclosed, $escaped . $enclosed, stripslashes(mysql_field_name($myquery, $i))) . $enclosed;

            $export_schema .= $l;
            $export_schema .= $field_terminated;
        }
        $export_schemas = str_replace("total", "Purchase_Amount", $export_schema);
        $output = trim(substr($export_schemas, 0, -1));

        $output .= $line_terminated;

        while ($row = mysql_fetch_array($myquery)) {

            $export_schema = '';

            for ($j = 0; $j < $fields_cnt; $j++) {
                if ($row[$j] == '0' || $row[$j] != '') {
                    if ($enclosed == '') {
                        $export_schema .= $row[$j];
                    } else {
                        $export_schema .= $enclosed .
                                str_replace($enclosed, $escaped . $enclosed, $row[$j]) . $enclosed;
                    }
                } else {
                    $export_schema .= '';
                }


                if ($j < $fields_cnt - 1) {
                    $export_schema .= $field_terminated;
                }
            }

            $output .= $export_schema;
            $output .= $line_terminated;
        }

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Length: " . strlen($output));
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename={$filenameoutput}.csv");

        echo $output;
        exit;
        $app->close();
    }

    public function preview() {
        
    }

}

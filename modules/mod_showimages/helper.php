<?php

/**
 * @version		$Id: helper.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');

//require_once (JPATH_SITE . DS . 'simpleresizeimage.php');

class modShowimagesHelper {

    function getList($catid) {
        global $mainframe;
        // Content Items only
        $db = & JFactory::getDBO();
        $catid = $_GET['gallimage'];
        if ($catid == NULL) {
            $query = " SELECT * FROM jos_phocagallery WHERE catid = 2 AND catid <> 1";
        } else {
            $query = " SELECT * FROM jos_phocagallery WHERE catid = '$catid' AND catid <> 1";
        }
        $db->setQuery($query);
        $lists = $db->loadObjectList();
        jimport('joomla.html.pagination');
        $total = $db->loadResult();
        $limitstart = 0;
        $limit = 10;
        $pagination = new JPagination($total, $limitstart, $limit);
        //return $pagination;

        return $lists;
    }

    function getcateimages() {
        $db = & JFactory::getDBO();
        $query = "SELECT DISTINCT p.catid,c.title FROM `jos_phocagallery` as p 
                  LEFT JOIN jos_phocagallery_categories as c
                  ON p.catid = c.id WHERE p.catid <> 1";
        $db->setQuery($query);
        $list_name = $db->loadObjectList();
        return $list_name;
    }

    // function getPagination(){
    // jimport('joomla.html.pagination');
    // $catid = $_GET['gallimage'];
    // $db = & JFactory::getDBO();
    // $query = " SELECT COUNT(*) FROM jos_phocagallery WHERE catid = '$catid' ";
    // $db->setQuery($query);
    // $total = $db->loadResult();
    // $limitstart = 0;
    // $limit = 10;
    // $pagination = new JPagination($total, $limitstart, $limit);
    // return $pagination;
    // }
}

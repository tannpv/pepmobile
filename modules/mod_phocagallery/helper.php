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

class modPhocagalleryHelper {

    function getList() {
        global $mainframe;

        $db = & JFactory::getDBO();
        
        // Content Items only
        $query = " SELECT * FROM jos_phocagallery";
        $query .= " WHERE catid = 1 ";
		$query .= ' AND published = 1 ';
        //$query .= ' AND a.catid = "' . $catid . '"';
        //$query .= ' AND a.published = 1 ';
        //$query .= 'ORDER BY ordering ASC';
        //echo $query;exit;

        $db->setQuery($query);

        $lists = $db->loadObjectList();

        return $lists;
    }

}

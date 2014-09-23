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

class modIntrocopyHelper {

    function getList($catid) {
        global $mainframe;

        $db = & JFactory::getDBO();

        // Content Items only
        $query = " SELECT a.* FROM jos_content as a ";
        $query .= " WHERE ";
        $query .= ' a.catid = "' . $catid . '"';
		$query .= "ORDER BY id DESC";
        $db->setQuery($query);

        $lists = $db->loadObjectList();

        foreach ($lists as $k => $v) {
            $aslug = $v->id . ":" . $v->alias;
            $v->flink = JRoute::_('index.php?option=com_content&view=article&id='.$v->id, '&catid=', $v->catid);
        }

        return $lists;
    }

}

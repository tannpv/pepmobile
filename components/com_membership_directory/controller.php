<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class Membership_directoryController extends JController
{
   
    function __construct($config = array()) {
        parent::__construct($config);
    }

    public function display($cachable = false, $urlparams = false) {
        parent::display($cachable, $urlparams);
    }
}
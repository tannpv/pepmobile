<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');

class TorTagsControllerComponents extends JControllerAdmin
{
	
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	public function getModel($name = 'Component', $prefix = 'TorTagsModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}

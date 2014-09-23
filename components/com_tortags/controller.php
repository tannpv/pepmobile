<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die;
jimport('joomla.application.component.controller');

class TorTagsController extends JController
{
	function display($cachable = false) 
	{
		$viewName = JRequest::getCmd('view', 'default');
		$this->default_view = $viewName;
		parent::display($cachable);
	}
	
	
	function addtag()
	{
		$user = JFactory::getUser();
		if ($user->authorise('core.create','com_tortags'))
		{
			$cid 	= JRequest::getInt('id',null);
			$tag 	= strip_tags(trim(JRequest::getVar('tag',null)));
			$option = strip_tags(trim(JRequest::getVar('comp',null)));
			
			if ((!$cid) || (!$tag) || (!$option)) 	{echo -1; die();}
			
			$db = JFactory::getDBO();
	
			$query = $db->getQuery(true);
			$query->select('`id`');
			$query->from('`#__tortags_tags`');
			$query->where('`title`='.$db->quote($tag));
			$db->setQuery($query);
			$tid = $db->loadResult();
			
			$query = $db->getQuery(true);
			$query->select('`id`');
			$query->from('`#__tortags_components`');
			$query->where('`component`='.$db->quote($option));
			$db->setQuery($query);
			$oid = $db->loadResult();
			
			if (!$tid)
			{
				$object = new stdclass();
				$object->title = $tag;
				$db->insertObject('#__tortags_tags', $object);
				$tid = (int)$db->insertid();	
			}else
			{
				$query = $db->getQuery(true);
				$query->select('`id`');
				$query->from('`#__tortags`');
				$query->where('`tid`='.$tid);
				$query->where('`oid`='.$oid);
				$query->where('`item_id`='.$cid);
				$db->setQuery($query);
				$id = $db->loadResult();
				if ($id) {echo -2; die();}
			}
			
			$object = new stdclass();
			$object->tid = $tid;
			$object->oid = $oid;
			$object->item_id = $cid;
			if ($db->insertObject('#__tortags', $object)) echo (int)$tid; 
			else {echo -3; }			
		}		
		die();
	}
	
	function deltag()
	{
		$user = JFactory::getUser();
		if ($user->authorise('core.create','com_tortags'))
		{
			$tid 	= JRequest::getInt('tag_id',null);
			$cid 	= JRequest::getInt('id',null);
			$option = strip_tags(trim(JRequest::getVar('comp',null)));
			
			if ((!$cid) || (!$tid) || (!$option)) 	{echo -1; die();}
			
			$db = JFactory::getDBO();
			
			$query = $db->getQuery(true);
			$query->select('`id`');
			$query->from('`#__tortags_components`');
			$query->where('`component`='.$db->quote($option));
			$db->setQuery($query);
			$oid = $db->loadResult();
				
			$query = $db->getQuery(true);
			$query->delete('#__tortags');
			$query->where('`tid`='.$tid);
			$query->where('`oid`='.$oid);
			$query->where('`item_id`='.$cid);
			$db->setQuery($query);
			$db->query();
			echo 1;
		}
		die();
	}
}

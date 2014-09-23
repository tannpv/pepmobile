<?php 
defined('_JEXEC') or die;

jimport('joomla.form.helper');

JFormHelper::loadFieldClass('list');

/**
 * JFormFieldUploadpdf
 * 
 * @package joomla_test
 * @author computer
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class JFormFieldUploadpdf extends JFormFieldList
{
	protected $type = 'Uploadpdf';

	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__uploadpdf a');
	//	$query->leftJoin('#__categories b on a.catid=b.id');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
	//	$options = array();
//		if($messages){
//			foreach($messages as $message){
//				$options[] = JHtml::_('select.option', $message->id, 
//					$message->greeting . ($message->catid ? ' (' . $message->category . ')' : ''));
//			}
//		}
		$options = array_merge(parent::getOptions(), $options);
		return $messages; //$options;
	}
}

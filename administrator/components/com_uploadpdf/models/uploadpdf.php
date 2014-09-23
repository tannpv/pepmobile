<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;
jimport( 'joomla.filesystem.file' );
jimport('joomla.application.component.modeladmin');

/**
 * UploadpdfModelUploadpdf
 * 
 * @package joomla_test
 * @author computer
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class UploadpdfModelUploadpdf extends JModelAdmin
{
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_uploadpdf.uploadpdf', 'uploadpdf', array('control' => 'jform', 'load_data' => $loadData));
		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_uploadpdf.edit.uploadpdf.data', array());
		if(empty($data)){
			$data = $this->getItem();
		}
		return $data;
	}

	public function getTable($name = '', $prefix = 'UploadpdfTable', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}
   public  function upload($file){
                    //Retrieve file details from uploaded file, sent from upload form
    
      $filename = JFile::makeSafe($file['name']['url']);

     
      if($filename!=''){
         $src = $file['tmp_name']['url'];
         $dest =  JPATH_SITE. DS ."images/pdf". DS .$filename;
        
         if (JFile::upload($src, $dest, false) ){
            $data=array();
            $data[tilte]=$filename;
            $data[url]="images/pdf/".$filename;
          return $data;
         }
      }
}
   function save($array){
       if (!isset($array['image'])) {
       $file = JRequest::getVar('jform', null, 'files', 'array');
	    //var_dump($file['name']['url']); exit;
       $id= JRequest::getVar('id');
       $data=JRequest::getVar('jform', null, 'post', 'array');
       $oldfile= $data['oldfile'];
         if(file_exists(JPATH_SITE. DS ."images/pdf". DS .$file['name']['url'])){
           	JError::raiseWarning(100, JText::_('File exits'));
            return false;
         }
         if(!isset($id) || $id==0){
                if(!isset($file['name']['url']) || $file['name']['url']==""){
                  
                    	JError::raiseWarning(100, JText::_('Upload error'));
        					return false;
                       
                }else{
                    $da= $this->upload($file);  
                    $array['title']=$file['name']['url']; 
                    $array['url']=$da["url"]; 
                   return parent::save($array);
                   }
        }
      else{
                if(isset($file['name']['url']) || $file['name']['url']!=""){
                JFile::delete(JPATH_ROOT.DS.'images/pdf/'.trim($oldfile));
          	    $da= $this->upload($file);  
                $array['title']=$file['name']['url']; 
                $array['url']=$da["url"]; 
               return parent::save($array);
                   
            }
        }
        
      }
   }
   
   
public function delete($array)
{  
    $db=JFactory::getDbo();
    $query=$db->getQuery(true);
    $query->select('title');
    $query->from('#__uploadpdf');
    $query->where('id in ('.implode(",",$array).')');
    $db->setQuery($query);
    $rs= $db->loadObjectList(); 
   
     foreach($rs as $rs)
     {
        if(file_exists(JPATH_ROOT.DS.'images/pdf/'.trim($rs->title))){
       JFile::delete(JPATH_ROOT.DS.'images/pdf/'.trim($rs->title));
         } 
     }
   
    parent::delete($array);
   return true;
}
   //  protected function prepareTable($table)
//        {
//            $table->title = "newvalue";
//        } 

}

<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class BpsmemberModelBpsmember extends JModelAdmin
{  
    public function checkuser(){
    global $mainframe;
        $user =trim(JRequest::getVar('value', null, 'post'));
        $db = JFactory::getDBO();
		$query = $db->getQuery(true);		
		$query->select('id');	
		$query->from('#__users');
        $query->where("`username`= '".$user."'");
        $db->setQuery($query);
        $result = $db->query();
        $numrow=$db->getNumRows($result);
        //echo $query; exit;
        if($numrow>0)
        {echo "true" ;}
        else{
        echo "false";
        }   
    exit;
 }
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
       // 	var_dump($data); exit;
		$form = $this->loadForm('com_bpsmember.bpsmember', 'bpsmember', array('control' => 'jform', 'load_data' => $loadData));

    	return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_bpsmember.edit.bpsmember.data', array());
		if(empty($data)){
			$data = $this->getItem();
		}
		return $data;
	}

	public function getTable($name = '', $prefix = 'BpsmemberTable', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}
    
	public function addJoomlaUsers($name, $username, $password, $email) {
      jimport('joomla.user.helper');
      $salt   = JUserHelper::genRandomPassword(32);
      $crypted  = JUserHelper::getCryptedPassword($password, $salt);
      $cpassword = $crypted.':'.$salt;

      $data = array(
          "name"=>$name,
          "username"=>$username,
          "password"=>$password,
          "password2"=>$password,
          "email"=>$email,
          "block"=>0,
          "groups"=>array("13")
      );

      $user = new JUser;
      //Write to database
      if(!$user->bind($data)) {
          throw new Exception("Could not bind data. Error: " . $user->getError());
          return false;
      }
      if (!$user->save()) {
         /// throw new Exception("Could not save user. Error: " . $user->getError());
         JError::raiseWarning("Could not save user. Error: ", $user->getError());
           
          return false;
      }

    return $user->id;
  }
  public function updateuser($id,$password){
     jimport('joomla.user.helper');
      $salt   = JUserHelper::genRandomPassword(32);
      $crypted  = JUserHelper::getCryptedPassword($password, $salt);
      $cpassword = $crypted.':'.$salt;
     // var_dump($cpassword);exit;
      $db = JFactory::getDBO();     
      $query=$db->getQuery(true);    
      $query->update('#__users');
      $query->set('password="'.$cpassword.'"');
      $query->where($db->nameQuote('id').'='.$db->quote($id));   
       $db->setQuery( $query);  
     // echo $query; exit;   
      $db->query();       
  }

    public function deleteJoomlaUsers($id)
    {   $db = & JFactory::getDBO();     
        $query = $db->getQuery(true);  
        $query->delete($db->nameQuote('#__users'));               
        $query->where($db->nameQuote('id').'='.$db->quote($id));               
        $db->setQuery($query);  
        $db->query(); 
        
        $query1 = $db->getQuery(true);  
        $query1->delete($db->nameQuote('#__user_usergroup_map'));               
        $query1->where($db->nameQuote('user_id').'='.$db->quote($id));               
        $db->setQuery($query1);  
        $db->query(); 
       
      
    }
    public function save($array) {
        $id =JRequest::getVar('id', null, 'GET');
         // var_dump($id);exit;
        
        $fullname=$array['first_name'].' '.$array['last_name'];
        $username=trim($array['user']);
        $password=trim($array['password']);
        $email=trim($array['email']);
        
      
        if($id>0 && $password!=""){
            $db=JFactory::getDbo();
            $query=$db->getQuery(true);
            $query->select('iduser');
            $query->from('#__bpsmember');
            $query->where('`id` ='.$id);
            $db->setQuery($query);
            $rs= $db->loadResult(); 
            $this->updateuser($rs,$password);
        }
        else{
        $id=$this->addJoomlaUsers($fullname,$username,$password,$email);
        
        if($id==false){
          return false;
         }
         $array['iduser']=$id;
        }
        return parent::save($array);
    }
    
    
    public function delete($array)
    {  
        $db=JFactory::getDbo();
        $query=$db->getQuery(true);
        $query->select('iduser');
        $query->from('#__bpsmember');
        $query->where('id in ('.implode(",",$array).')');
        $db->setQuery($query);
        $rs= $db->loadObjectList(); 
       
         foreach($rs as $rs)
         {
           
           $this-> deleteJoomlaUsers(trim($rs->iduser));
           
         }
       
        parent::delete($array);
       return true;
    }
    
  
  public function getuseredit($id){
    $db=JFactory::getDbo();
    $query=$db->getQuery(true);
    $query->select('iduser');
    $query->from('#__bpsmember');
    $query->where('`id` ='.$id);
    $db->setQuery($query);
    $rs= $db->loadResult(); 
  // var_dump($rs->iduser); exit;
    $query1=$db->getQuery(true);
    $query1->select('username');
    $query1->from('#__users');
    $query1->where('`id` ='.$rs);
    $db->setQuery($query1);
    $rs1= $db->loadResult(); 
    return $rs1;
  }
    
}

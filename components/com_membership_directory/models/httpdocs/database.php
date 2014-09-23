<?php

class Database{
	
       var $db = null;
		
	function __construct()
	{
		include('config.inc');
               
                $this->db =& $db;
		
	}//end of constructor
	
	function getData($series_id  = "")
	{
		if($series_id == "")
                {
                  $sql = "SELECT * FROM `model_images` ";
		
               }else{
                  $sql = "SELECT * FROM `model_images` WHERE `series_id` = '".$series_id."'";
               }
                
		$this->db->query($sql);
		
		$array = array();
                $list     = array();
		
		while( $this->db->next_record())
		{
			$array['name'] = $this->db->f('image_name');
                        $array['path'] = $this->db->f('image_path');
                        $array['caption'] = $this->db->f('image_caption');
                         
                        $list[] = $array;
		}
		
		return $list;
	}
	
	/*
	* 	INSERT DATA
	* 	@RETURNS true if operation is successful
	*/
	function insertData($array = null, $tableName = 'pictures')
	{
			$sql  = "INSERT INTO `".$tableName."` (`picture_id`, `picture_path` , `picture_name`) ";
			$sql .= "VALUES ('".$array['picture_id']."', '".$array['picture_path']."' , '".$array['picture_name']."') ;";
			
			$result = mysql_query($sql);
			
			//check to see if the insert failed or if the array passed is empty
			if(!$result || $array == null)
			{
				return false;
			
			}elseif(mysql_affected_rows() == -1){
				
				return false;
			
			}
		
		return true;
	}
}

?>
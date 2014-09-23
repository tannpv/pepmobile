<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
//var_dump($lists);

 foreach($lists as $lists)
     {  $title=substr($lists->title,0, strlen($lists->title)-4);
	    if(strlen($title)>20){
	//	$name=substr($title,0,20)." ...";
	    $name=$title;
		}
		else{
		$name=$title;
		}
      echo ' <p><a href="'.JURI::base().$lists->url.'" title="'.$title.'"><strong>'.$name.'</strong></a></p>';
     }
?>
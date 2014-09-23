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
class modWallfacebookHelper{

   
    
    public function loadFB($fbID,$access_token,$app_id,$app_secret,$limit){
     
   // $app_id = "742708895755073";
   // $app_secret = "bd3802475bc7153723d5cb0e099f3473"; 
    $grant_type="fb_exchange_token";
    //$access_token = "CAAKjfWPnK0EBACuFiS5FT94gpcgh0JzoZB5a38n5CExB6zCblXdPiQOWZAoFDH8GwwsI4c7EOOan2kqZBGGIPLYffSRiqUZBSNuOSpDNUpt7iuv7HTYrqpR6pfcf3lghyxSoMcOFlCUgzLkOhpGMp6hhxU0mCDNBKpSQU1N4wqfjeXYTW0VDYfr2CrllpgD8W85kn3kovwZDZD";
      //check token
    $url_check="https://graph.facebook.com/oauth/access_token_info?client_id=".$app_id."&access_token=".$access_token; 
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url_check);
        $cont = curl_exec($c);
        curl_close($c);
        $param=json_decode($cont);
       
        if($param->expires_in==0){
    if ($param->error) {
        if ($param->error->type== "OAuthException") {
              $url_change="https://graph.facebook.com/oauth/access_token?client_id=".$app_id."&client_secret=".$app_secret."&grant_type=". $grant_type."&fb_exchange_token=".$access_token; 
                $c = curl_init();

                curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($c, CURLOPT_URL, $url_change);
                $contents = curl_exec($c);
                curl_close($c);
                parse_str( $contents, $params);
                $access_token = $params['access_token'];
             // var_dump($access_token);exit;
                
        }    
    }
  }
    $url="https://graph.facebook.com/".$fbID."/feed?limit=".$limit."&access_token=".$access_token;
    //load and setup CURL
   // var_dump( $url);exit;
     $cc = curl_init($url);	
     curl_setopt($cc, CURLOPT_RETURNTRANSFER, 1);
    //get data from facebook and decode JSON
     $page = json_decode(curl_exec($cc));
	     curl_close($cc);
    //return the data as an object
     return $page->data;
	}

  // note this wrapper function exists in order to circumvent PHP’s 
  //strict obeying of HTTP error codes.  In this case, Facebook 
  //returns error code 400 which PHP obeys and wipes out 
  //the response.
  public function curl_get_file_content($url) {
      
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $url);
    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
     return $contents;
     
  }
	

	

}

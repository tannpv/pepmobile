<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
//var_dump($lists);

?>
<!--facebook panel -->
<div class="facebook-widget">
<div class=" nano"> 
<div class="content">
<h3>Facebook</h3>
<?php
//var_dump($lists); exit;
foreach($lists as $dPost){

   // if($dPost->from->id==$fbid){
        $dTime = strtotime($dPost->created_time);
        $myTime=date("M d Y h:ia",$dTime);
        ?>
        <div><h5 style="color:#0688CF"><?php echo $dPost->from->name; ?></h5>
           <img class="fb-wall-avatar" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn2/s160x160/1186735_467105150054958_1816777330_a.jpg" style="width:50px;float:left; margin:5px;   border: 1px solid darkred;" />
        <p style="font-size:14px"> <?php echo($dPost->message) ."</p><BR /><hr >". $myTime; ?>
        </div>
        <?php
      }
   // }
?>
</div>
</div>
</div>
<!--//facebook panel -->

<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
//var_dump($lists);
?>

<div id="slider" class="nivoSlider">
	<?php foreach ($lists as $row) {
       $link = str_replace('|','', $row->extlink1);
    if($link  !=""){
	$url = "http://".$link;
	//var_dump($row->extlink1 );exit;
}
 ?>
   <a href="<?php echo $url; ?>" target="_blank"> <img src="images/phocagallery/<?php echo $row->filename; ?>" alt='<?php echo $row->description; ?>' /></a>
	<?php } ?>
</div>


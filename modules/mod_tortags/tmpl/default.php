<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die;
$Itemid = JRequest::getInt('Itemid');
?>
<style type="text/css">
#tortags-mod a.tag1 {
    font-size: 90%;
    font-weight: normal;
}
#tortags-mod a.tag2 {
    font-size: 100%;
    font-weight: normal;
}
#tortags-mod a.tag3 {
    font-size: 125%;
    font-weight: normal;
}
#tortags-mod a.tag4 {
    font-size: 150%;
    font-weight: normal;
}
#tortags-mod a.tag5 {
    font-size: 175%;
    font-weight: normal;
}
#tortags-mod a.tag6 {
    font-size: 200%;
    font-weight: bold;
}
#tortags-mod a.tag7 {
    font-size: 225%;
    font-weight: bold;
}
#tortags-mod a.tag8 {
    font-size: 250%;
    font-weight: bold;
}
#tortags-mod a.tag9 {
    font-size: 265%;
    font-weight: bold;
}
</style>
<div class="tortags<?php echo $moduleclass_sfx; ?>" id="tortags-mod">
<?php foreach ($list as $item) {	?>
	<?php 
		if ($item['cloud']>9) $item ['cloud']=9;
	
	$tagclass = "tag" . $item['cloud'];
	$tagname = $item['name'];
	echo "<a class='".$tagclass."' href=\"" . JRoute::_("index.php?option=com_search&searchword=" . $tagname . "&areas[0]=tortags") . "\">$tagname</a> ";
	
	 } ?>
</div>

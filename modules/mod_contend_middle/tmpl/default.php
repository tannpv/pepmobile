
<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php
//echo $item->introtext; 
// var_dump($items);
    // $donate     = 'index.php?option=com_content&view=article&id=89';
    $involved   = 'index.php?option=com_content&view=article&id=74';
    $donate       = 'index.php?option=com_content&view=category&layout=blog&id=87';
    $blog 		=  'index.php?option=com_content&view=article&id=203&catid=78';
    $media      = 'index.php?option=com_content&view=article&id=112';
  
?>
 <div class="boxLayout">
<ul>
    <li><a href="<?php echo JRoute::_($donate);?>">
            <h3>Get Educated</h3>
			<?php 
                        // $contents = modContend_MiddleHelper::getContent('87'); 
                        // echo "<p style='font-weight : bold; margin: 0; padding: 0;'>".$contents->title."</p>";
                        // echo JHtml::_('string.truncate', ($contents->introtext), 150, false, false);
			?>
            <img src="<?php echo JURI::base();?>templates/mobilebaykeeper1/images/banner/blog.jpg" width="173" height="109" alt="" /> 
			</a>
	</li>
    <li><a href="<?php echo str_replace('/component/content/category','',JRoute::_(htmlspecialchars($involved)));?>">
            <h3>Get Involved</h3>
            <img src="<?php JURI::base();?>templates/mobilebaykeeper1/images/banner/GetInvolved.jpg" width="173" height="109" alt="" /></a></li>
    <li><a href="<?php echo str_replace('/component/content/category','',JRoute::_(htmlspecialchars($blog)));?>">
            <h3>Members & More</h3>
            <img src="<?php echo JURI::base();?>templates/mobilebaykeeper1/images/banner/Members.jpg"  height="109" alt="" width ="173" /></a></li>
    <li><a href="<?php echo str_replace(array('/component/content','article'),array('','media'),JRoute::_(htmlspecialchars($media)));?>">
            <h3>Media</h3>
            <img src="<?php echo JURI::base();?>templates/mobilebaykeeper1/images/banner/Media.jpg" width="173" height="109" alt="" /></a></li>
</ul>
     </div>
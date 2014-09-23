
<?php defined('_JEXEC') or die('Restricted access');

 
?>
<div class="slideshowFrame"> 
    <div class="slideshow">
        <div id="nav" ></div>
        <?php foreach ($items as $item ) { ?>
		<?php     
            $link  = explode('|', $item->extlink1);
        ?>
        <a class="clearfix" href="http://<?php echo $link[0] ?>">
            <span class="caption"><p><?php echo $item->description ?></p></span>
            <img src="<?php echo JURI::base(); ?>images/phocagallery/<?php echo $item->filename ?>" width="670" height="378" alt=""/>
        </a>
        <?php } ?>
    </div>
</div> 
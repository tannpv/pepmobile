
<?php defined('_JEXEC') or die('Restricted access'); 
    $itemnew = 'index.php/component/content/article?id=';
    $viewall = 'index.php?option=com_content&view=category&id=90';
?>
<h3>TOP NEWS</H3>
<h4><?php echo substr($item->title, 0, 70) ?></h4>
<span class="postedDate"><?php if ($item->featured == 1) {echo JHtml::_('date', $item->created, "F j, Y"); }?></span>
<p><?php echo $item->introtext // substr($item->introtext, 0, 200) ?><a href="<?php echo JURI::base().htmlspecialchars($itemnew);?><?php echo $item->id ?>"><?php if ($item->featured == 1) { echo '»'; } ?></a></p>
<p><a href="<?php echo JURI::base().htmlspecialchars($viewall); ?>">View All News »</a></p>

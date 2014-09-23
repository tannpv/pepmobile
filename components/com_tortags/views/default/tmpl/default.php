<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted Access');
JHtml::_('behavior.tooltip');
$return='';
$tags=$this->tags;
	 		 $img 		= JURI::root().'administrator/components/com_tortags/assets/images/tags.png';
			 $img_but	= JURI::root().'administrator/components/com_tortags/assets/images/tt_button_left.png';
			 $img_blank	= JURI::root().'administrator/components/com_tortags/assets/images/tt_button_blank.png';
?>
		<style type="text/css">
			.tt_button {line-height:22px;background: url('<?php echo $img_but;?>') no-repeat scroll 0 0 transparent;float: left;margin-right: 10px;}
			.tt_button .tt_end {background: url('<?php echo $img_blank;?>') no-repeat scroll 100% 0 transparent;}
			.tt-tags{padding:2px;clear:both;overflow: hidden;}
			.tt_button{margin-top: 3px; margin-right: 5px; margin-left: 2px;}
			.tt_end a, .tt_end span	{ padding: 0 3px; text-decoration: none;}
			.tt_inpval{float:left;padding:1px;}
			.tt_button img{margin: 3px 1px 1px 2px; float:left;}
		</style>
<?php
		$return	.= '<div id="tt-tags" class="tt-tags">';
		 	if (sizeof($tags))
			{
			 	foreach ( $tags as $tag ) 
			 	{		 
			 		$menu = &JSite::getMenu();
					$Itemid = (isset($menu->getActive()->id))?('&Itemid='.$menu->getActive()->id):'';
                    $link = JRoute::_('index.php?option=com_search&searchword='.trim(substr($tag->title, 0, 70)).'&areas[]=tortags'.$Itemid);
			 				
			 		$return .='<div id="tagid_'.$tag->id.'" class="tt_button">' .
			 				'<div class="tt_end">' .
			 					'<a href="'.$link.'" title="'.$tag->title.'">' .
			 						'<img src="'.$img.'"/>' .
			 								''.$tag->title.'</a>' .
			 				'</div>' .
			 				'</div>';
			 	}
			 }
		 	$return	.= '</div>';
		 	echo $return;
?>
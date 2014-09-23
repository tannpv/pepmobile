<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');

class plgContentTorTags extends JPlugin {
	
	function __construct($subject, $params){
		parent::__construct($subject, $params);
	}

 	function onContentPrepare( $context, &$article, &$params, $page = 0 )  
        {
        	if (strpos($article->text, 'tortags') === false) 
        	{
        		return true;
        	}
        	 $regex		= '/{tortags,(\d+),(\d+)}/i';
			 $matches	= array();
        	 preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
        	 $oid = null;
        	 $option	= JRequest::getVar('option');
        	 
        	if (sizeof($matches[0])==3)
        	{  	$id		=(int)$matches[0][1];
        	   	$oid    = (int)$matches[0][2];
        	   	 $option = $this->getOptionByOid($oid);
        	}else
        	{
        		$regex		= '/{tortags,(\d+)}/i';
				$matches	= array();
	        	preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
	        	if (sizeof($matches[0]))
        	  	$id		=(int)$matches[0][1];
        	}
        	
        	 /*$id = JRequest::getVar('id');
			 $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );
			 $aid = JRequest::getVar('a_id');
			 $sid = $article->id;
			 */
			 
			 $view		= JRequest::getVar('view');
			 if ($option=="com_content" && $view=="category") $option="com_categories";
			 
			 $body 		= JResponse::getBody();
			 $img 		= JURI::root().'administrator/components/com_tortags/assets/images/tags.png';
			 $img_but	= JURI::root().'administrator/components/com_tortags/assets/images/tt_button_left.png';
			 $img_blank	= JURI::root().'administrator/components/com_tortags/assets/images/tt_button_blank.png';
		 
		 /*
		 if (!$id && isset($cid[0])) $id = $cid[0];
		 if (!$id && $aid) $id = $aid;
		 if (!$id && $sid) $id = $sid;
		 */
		 
		 $tags 			= $this->getTags($id, $option, $oid);
		 $components 	= $this->getAlloweComponents();
		 ob_start();
		?>
		<style type="text/css">
			.tt_button {line-height:22px;background: url('<?php echo $img_but;?>') no-repeat scroll 0 0 transparent;float: left;margin-right: 10px;}
			.tt_button .tt_end {background: url('<?php echo $img_blank;?>') no-repeat scroll 100% 0 transparent;}
			.tt-tags{padding:2px;overflow: hidden;}
			.tt_button{margin-top: 3px; margin-right: 5px; margin-left: 2px;}
			.tt_end a, .tt_end span	{ padding: 0 3px; text-decoration: none;}
			.tt_inpval{float:left;padding:1px;}
			.tt_button img{margin: 3px 1px 1px 2px; float:left;}
		</style>
		<?php
		$style= ob_get_contents();
		ob_end_clean();
		
		$return = $style;
		
		 if (in_array($option,$components))
		 {
		 	$return	.= '<div id="tt-tags" class="tt-tags">';
		 	if (sizeof($tags))
			{
			 	foreach ( $tags as $tag ) 
			 	{	//$menu = &JSite::getMenu();
					$menu	= & JApplication::getMenu('site');
					$Itemid = (isset($menu->getActive()->id))?('&Itemid='.$menu->getActive()->id):'';
                    $link = JRoute::_('index.php?option=com_search&searchword='.trim(substr($tag->title, 0, 25)).'&areas[]=tortags'.$Itemid);

			 		$return .='<div id="tagid_'.$tag->id.'" ' .
			 				'<div class="tt_end">' .
			 					'<a href="using-joomla/extensions/components/search-component/search.html?searchword='.$tag->title.'&ordering=newest&searchphrase=all" title="'.$tag->title.'">' .
//			 						'<img src="'.$img.'"/>' .
			 								''.$tag->title.'</a>' .
			 				'</div>' .
			 				'</div>';
			 	}
			 }
		 	$return	.= '</div>';
		 	//$article->text = $return.$article->text;
		 }
		 $article->text = preg_replace($regex, $return, $article->text);
		 return;
        }
        
	protected function getAlloweComponents()
	{
		$db = JFactory::getDBO();
			
			$query = $db->getQuery(true);
			$query->select('`component`');
			$query->from('`#__tortags_components`');
			$db->setQuery($query);
			$cmpts = $db->loadResultArray();
		return $cmpts;	
	}
	
	protected function getOptionByOid($oid=0)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('`component`');
		$query->from('`#__tortags_components`');
		$query->where('`id`='.$db->quote($oid));
		$db->setQuery($query);
		return $db->loadResult();
	}
	
	protected function getTags($id, $option, $oid=null)
	{
		$db = JFactory::getDBO();
		
		if (!$oid)
		{
		$query = $db->getQuery(true);
		$query->select('`id`');
		$query->from('`#__tortags_components`');
		$query->where('`component`='.$db->quote($option));
		$db->setQuery($query);
		$oid = $db->loadResult();
		}
			
		$query = $db->getQuery(true);
		$query->select('`t`.*');
		$query->from('`#__tortags_tags` AS `t`');
		$query->join('INNER','`#__tortags` AS `m` ON `m`.`tid`=`t`.`id`');
		$query->where('`m`.`item_id`='.(int)$id);
		$query->where('`m`.`oid`='.(int)$oid);
		$db->setQuery($query);
		$tags = $db->loadObjectList();
		return $tags;
	}
}
?>
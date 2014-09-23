<?php
/**
* TorTags component for Joomla 1.6, Joomla 1.7
* @package TorTags
* @author Tormix Team
* @Copyright Copyright (C) Tormix, www.tormix.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemtortags extends JPlugin
{
	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage('plg_system_tortags');
	}

	function onAfterRender()
	{
				
		 $id = JRequest::getVar('id');
		 $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );
		 $aid = JRequest::getVar('a_id');
		 $option	= JRequest::getVar('option');
		 $body 		= JResponse::getBody();
		 $img 		= JURI::root().'administrator/components/com_tortags/assets/images/tags.png';
		 $img_add 	= JURI::root().'administrator/components/com_tortags/assets/images/tag_add.png';
		 $img_del 	= JURI::root().'administrator/components/com_tortags/assets/images/delete.png';
		 $img_info	= JURI::root().'administrator/components/com_tortags/assets/images/about.png';
		 $img_but	= JURI::root().'administrator/components/com_tortags/assets/images/tt_button_left.png';
		 $img_blank	= JURI::root().'administrator/components/com_tortags/assets/images/tt_button_blank.png';
		 if (!$id && isset($cid[0])) $id = $cid[0];
		 if (!$id && $aid) $id = $aid;
		 		 
		 $tags 			= $this->getTags($id, $option);
		 $components 	= $this->getAlloweComponents();
		
		ob_start();
		?>
		<style type="text/css">
			.tt_button {line-height:22px;background: url('<?php echo $img_but;?>') no-repeat scroll 0 0 transparent;float: left;margin-right: 10px;}
			.tt_button .tt_end {background: url('<?php echo $img_blank;?>') no-repeat scroll 100% 0 transparent;}
			.tt_notice, .tt_error{background: none repeat scroll 0 0 #D14008;  color: #FDE910;border-radius:2px;padding:2px;}
			.tt_success{background: none repeat scroll 0 0 green;  color: white;border-radius:2px;padding:2px;}
			.tt-tags{padding:2px;clear:both;overflow: hidden;}
			.tt_button{margin-top: 3px; margin-right: 5px; margin-left: 2px;}
			.tt_notice_new{padding-left: 20px; background: url('<?php echo $img_info;?>') no-repeat;}
			.tt_end a, .tt_end span	{ padding: 0 3px; text-decoration: none;}
			.tt_inpval{float:left;padding:1px;}
			.tt_button img{margin: 3px 1px 1px 2px; float:left;}
		</style>
		<?php
		$style= ob_get_contents();
		ob_end_clean();
		
		 if (in_array($option,$components))
		 {
		 	$return	=  $style.'<div style="display:none" id="tt-value"></div><div id="tt-status"></div><input type="text" class="tt_inpval" id="ttnewtag" name="ttnewtag" value="" size="20" maxlength="70" />';
		 	$return	.= '<div class="tt_button"><div class="tt_end"><a href="javascript:void(0);" onclick="addTag();"><img src="'.$img_add.'"/>add tag</a></div></div>';
		 	$return	.= '<div id="tt-tags" class="tt-tags">';
		 	if (sizeof($tags))
			{
			 	foreach ( $tags as $tag ) 
			 	{		 		
			 		$return .='<div id="tagid_'.$tag->id.'" class="tt_button">' .
			 				'<div class="tt_end">' .
			 					'<a href="javascript:void(0);" onclick="javascript:delTag('.$tag->id.');">' .
			 						'<img src="'.$img_del.'"/></a>' .
			 								'<span style="font-weight: normal;">'.$tag->title.'</span>' .
			 				'</div>' .
			 				'</div>';
			 	}
			 }
		 	$return	.= '</div>';
		 	$addurl = '';
		 	if (JURI::current()==JURI::root().'administrator/index.php'); $addurl = 'administrator/';
			 	$curl = JURI::root().$addurl.'index.php?option=com_tortags&task=addtag&tmpl=component&format=raw';
			 	$durl = JURI::root().$addurl.'index.php?option=com_tortags&task=deltag&tmpl=component&format=raw';
			 	ob_start();
			 	?>
			 	<script type="text/javascript">
	                    function addTag()
						{
							var tag = $('ttnewtag').get('value');
					 		var url = '<?php echo $curl;?>&tag='+ tag +'&id=<?php echo $id;?>&comp=<?php echo $option;?>';
							var a = new Request.HTML({
							         url: url,
							         method: 'post',
							         update   : $('tt-value'),
							         onRequest: function(){
	        							$('tt-status').set('text', 'loading...');
	    							},
							         onComplete:  function(response) 
							            {
							            	var result = $('tt-value').get('text');
							            	var mess = '';
							            	
							            	if (result==-1)
							            	{
							            		mess ="<span class='tt_error'><?php echo JText::_('PLG_TORTAGS_NOTICE_ERROR1');?></span>";
							            	}else
							            	if (result=='-2')
							            	{
							            		mess ="<span class='tt_notice'><?php echo JText::_('PLG_TORTAGS_NOTICE_DUBLICATE');?></span>";
							            	}else
							            	if (result=='-3')
							            	{
							            		mess ="<span class='tt_error'><?php echo JText::_('PLG_TORTAGS_NOTICE_ERROR2');?></span>";
							            	}
							            	else
							            	{
							            		mess ="<span class='tt_success'><?php echo JText::_('PLG_TORTAGS_NOTICE_ADDED');?></span>";
							            		var button = '<div id="tagid_'+ result +'" class="tt_button"><div class="tt_end"><a href="javascript:void(0);" onclick="javascript:delTag('+ result +');"><img src="<?php echo $img_del;?>"/></a><span style="font-weight: normal;">'+ tag +'</span></div></div>';
							            		$('tt-tags').set('html', $('tt-tags').get('html') + button);
							            	}
							            	
							            	$('tt-status').set('html', mess);
							            	$('ttnewtag').set('value','');
							            	$('ttnewtag').focus();
	
							            }
							        }); 
							a.send(); 
						}
						function delTag(id)
						{
					 		var url = '<?php echo $durl;?>&tag_id='+ id+'&id=<?php echo $id;?>&comp=<?php echo $option;?>';
							var d = new Request.HTML({
							         url: url,
							         method: 'post',
							         update   : $('tt-value'),
							         onRequest: function(){
	        							$('tt-status').set('text', 'loading...');
	    							},
							         onComplete:  function(response) 
							            {	
							            	var namefield = 'tagid_'+ id;
							            	$(namefield).destroy();
							            	var result = $('tt-value').get('text');
							            	var mess = '';
							            	
							            	if (result==-1)
							            	{
							            		mess ="<span class='tt_error'><?php echo JText::_('PLG_TORTAGS_NOTICE_ERROR1');?></span>";
							            	}else
							            	{
							            		mess ="<span class='tt_success'><?php echo JText::_('PLG_TORTAGS_NOTICE_DELETED');?></span>";
							            	}
							            	$('tt-status').set('html', mess);
							            }
							        }); 
							d.send(); 
						}
	 			</script>
			 	<?php
			 	$script = ob_get_contents();
			 	ob_end_clean();
		 	/*}else
		 	{
		 		ob_start();
			 	?>
			 	<script type="text/javascript">
			 	var tid=0;
	                    function addTag()
						{
							var tag = $('ttnewtag').get('value');
							if (tag!='')
							{
								tid++; 
								$('tt-id').set('value',tid);
						 		 mess ="<span class='tt_success'><?php echo JText::_('PLG_TORTAGS_NOTICE_ADDED');?></span>";
								 var button = '<div id="tagid_'+ tid +'" class="tt_button"><div class="tt_end"><a href="javascript:void(0);" onclick="javascript:delTag('+ tid +');"><img src="<?php echo $img_del;?>"/></a><span style="font-weight: normal;">'+ tag +'</span></div></div>';
								 
								 $('tt-tags').set('html', $('tt-tags').get('html')+button);
								 $('tt_tags').set('html', $('tt_tags').get('html')+tag+'|');
							} else mess ="<span class='tt_error'><?php echo JText::_('PLG_TORTAGS_NOTICE_ERROR1');?></span>";

				            	$('tt-status').set('html', mess);
				            	$('ttnewtag').set('value','');
				            	$('ttnewtag').focus();
						}
						function delTag(id)
						{
					 		var namefield = 'tagid_'+ id;
							$(namefield).destroy();
							var mess = '';
							mess ="<span class='tt_success'><?php echo JText::_('PLG_TORTAGS_NOTICE_DELETED');?></span>";
							$('tt-status').set('html', mess);
						}
	 			</script>
	 			<input type="hidden" name="tt_tags" id="tt_tags" value="" />
	 			<input type="hidden" name="tt_id" id="tt-id" value="0" />
			 	<?php
			 	$script = ob_get_contents();
			 	ob_end_clean();
		 	}
		 	*/
		 if (!$id) 
		 {
		 	$script='';
		 	$return	= $style."<div id='tt-status'><span class='tt_notice_new'>".JText::_('PLG_TORTAGS_NOTICE_NEW')."</span></div>";
		 }
			$body = str_replace('<body', $script.'<body', $body);
		 	$body = str_replace('<div id="editor-xtd-buttons">', $return.'<div id="editor-xtd-buttons">', $body);
		 }
		 JResponse::setBody($body);
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
	
	protected function getTags($id, $option)
	{
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('`id`');
		$query->from('`#__tortags_components`');
		$query->where('`component`='.$db->quote($option));
		$db->setQuery($query);
		$oid = $db->loadResult();
			
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
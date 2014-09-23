<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 3.1.0
* @copyright Copyright (C) 2008 - 2013 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');

?>
<script language="JavaScript" type="text/javascript">

Joomla.submitbutton = function(task){
	if (task == 'dynamicredirect') {	
		document.location.href = 'index.php?option=com_redirectonlogin&view=dynamicredirect&id=0';		
	}	
	if (task == 'dynamicredirect_delete') {
		if (document.adminForm.boxchecked.value == '0') {						
			alert('<?php echo addslashes(JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED')); ?>');
			return;
		} else {
			if(confirm("<?php echo addslashes(JText::_('COM_REDIRECTONLOGIN_SURE_DELETE_DYNAMIC_REDIRECTS')); ?>")){
				submitform('dynamicredirect_delete');
			}
		}
	}
}

Joomla.orderTable = function(){
	if(document.getElementById("sortTable")){
		sort_table = document.getElementById("sortTable").value;
	}else{
		sort_table = document.adminForm.filter_order.value;
	}
	if(document.getElementById("directionTable")){
		direction_table = document.getElementById("directionTable").value;
	}else{
		direction_table = document.adminForm.filter_order_Dir.value;
	}	
	Joomla.tableOrdering(sort_table, direction_table, '');	
}

</script>
<form action="<?php echo JRoute::_('index.php?option=com_redirectonlogin&view=dynamicredirects'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>			
		</div>
	<?php endif; ?>	
	<div id="j-main-container"<?php echo empty($this->sidebar) ? '' : ' class="span10"'; ?>>	
		<h2 style="padding-left: 10px;"><?php echo JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECTS'); ?></h2>
		<?php
		if($this->controller->get_version_type()=='free'){
			echo '<div style="color: red; padding-left: 10px;">';
			echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
			echo '</div>';
		}
		?>	
		<fieldset id="filter-bar">
			<?php	
			
			//search bar						
			$sortfields = JHtml::_('select.options', $this->getSortFields(), 'value', 'text', $listOrder);			
			echo $this->helper->search_toolbar(1, 1, 1, 1, $this->state->get('filter.search'), $sortfields, $listDirn, $this->pagination->getLimitBox());			
			
			?>			
		</fieldset>
		<div class="clr"> </div>
		<table class="adminlist table table-striped" width="100%">
			<thead>
				<tr>	
					<th width="5" align="left">
						<input type="checkbox" name="toggle" value="" <?php if(isset($this->items)){ ?>onclick="checkAll(<?php echo count($this->items); ?>);"<?php } ?> />			
					</th>			
					<th class="left" style="white-space: nowrap; text-align: left;">					
						<?php 
						$label = JText::_('COM_REDIRECTONLOGIN_NAME');
						echo JHtml::_('grid.sort', $label, 'a.name', $listDirn, $listOrder); 
						?> 
					</th>				
					<th class="left" style="width: 180px;">
						<div style="width: 180px; margin: 0 auto;">
						<?php 	
						$label = JText::_('COM_REDIRECTONLOGIN_ORDERING');					
						echo JHtml::_('grid.sort',  $label, 'a.ordering', $listDirn, $listOrder); 
						?>							
						<a href="javascript:submitform('save_order_dynamic_redirects');" class="saveorder" title="Save Order"><?php 
							if($this->helper->joomla_version >= '3.0'){
								echo '<img src="components/com_redirectonlogin/images/save.png" alt="save" />';
							}
							?></a>	
						</div>				
					</th>				
					<th width="5%">					
						<?php 
							$label = JText::_('COM_REDIRECTONLOGIN_ID');						
							echo JHtml::_('grid.sort', $label, 'a.id', $listDirn, $listOrder);						
						?>					
					</th>			
				</tr>
			</thead>		
			<tbody>		
		<?php
		foreach ($this->items as $i => $item) :
		?>
		<tr class="row<?php echo ($i+1) % 2; ?>">
			<td>	
				<input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $item->id;?>" onclick="isChecked(this.checked);" />	
			</td>
			<td>	
				<a href="index.php?option=com_redirectonlogin&view=dynamicredirect&id=<?php echo $item->id;?>">		
					<?php echo $item->name; ?>	
				</a>	
			</td>		
			<td class="center">
			
				<?php 
				$order = '0';
				if($item->ordering){
					$order = $item->ordering; 
				}			
				?>			
				<input type="text" name="order[]" class="text-area-order rol_reorder" size="5" value="<?php echo $order; ?>" />	
				<input type="hidden" name="dynamic_redirect_id[]" value="<?php echo $item->id; ?>" />	
				<input type="hidden" name="order_id[]" value="<?php echo $item->ordering; ?>" />		
			</td>		
			<td class="center">
				<?php echo $item->id; ?>
			</td>
		</tr>
		<?php
		endforeach;
		?>
		</tbody>
		</table>
		<table class="adminlist">
			<tfoot>
				<tr>
					<td>
					<?php 
						echo $this->pagination->getListFooter();
					?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />	
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

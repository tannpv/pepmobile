<?php


/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_uploadpdf');
$saveOrder	= $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_uploadpdf'); ?>" method="post" name="adminForm">

<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

            
                <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                    <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                    <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true);?>
                </select>
                

		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
		<tr>
		
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
			</th>
  	       <th width="5">
				<?php echo JText::_('ID'); ?>
			</th>			
			<th>
				<?php echo JText::_('Name'); ?>
			</th>
  	        <th>
				<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="4"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>

		</tfoot>
		<tbody>
		<?php foreach($this->items as $i => $item): 
             $item->max_ordering = 0;
        	$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_uploadpdf');
			$canEdit	= $user->authorise('core.edit',			'com_uploadpdf');
			$canCheckin	= $user->authorise('core.manage',		'com_uploadpdf');
			$canChange	= $user->authorise('core.edit.state',	'com_uploadpdf');
        ?>
	   <tr class="row<?php echo $i % 2; ?>">
       	<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->id; ?>
		</td>
	
		<td>
			<a href="<?php echo JRoute::_('index.php?option=com_uploadpdf&task=uploadpdf.edit&id=' . $item->id); ?>">
				<?php echo $item->title; ?>
			</a>
		</td>
      	<td>
	<?php echo JHtml::_('jgrid.published', $item->state, $i, 'uploadpdfs.',  $item->publish_up, $item->publish_down); ?>
		</td>
	</tr>
<?php endforeach; ?>
		
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
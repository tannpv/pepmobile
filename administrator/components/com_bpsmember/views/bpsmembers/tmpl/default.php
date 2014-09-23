<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$companies = JFormHelper::loadFieldType('bpsmemberfillter', false);
//var_dump($companies->getOptions()); exit;
//$companyOptions=$companies->getOptions(); // works only if you set your field getOptions on public!!
?>
<form action="<?php echo JRoute::_('index.php?option=com_bpsmember&view=bpsmembers'); ?>" method="post" name="adminForm" id="adminForm">
    <div  style="width:100%; overflow: scroll">
         <fieldset id="filter-bar">
                <div class="filter-search fltlft">
                         <label class="filter-search-lbl" for="filter_search">Filter:</label>
                        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->searchterms); ?>" title="<?php echo JText::_('Search in BPS, etc.'); ?>" />
                        <button type="submit">
                                <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
                        </button>
                        <button type="button" onclick="document.id('filter_search').value='';this.form.submit();">
                                <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
                        </button>
                </div>
       </fieldset> 
       
       <table class="adminlist" >
		<thead>
        <tr>
        	<th width="5"><?php echo JText::_('ID'); ?></th>
        	<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />	</th>			
        	<th><?php echo JText::_('First Name'); ?></th>
        	<th><?php echo JText::_('Last Name'); ?></th>
            <th><?php echo JText::_('Company Name'); ?></th>
            <th><?php echo JText::_('Email'); ?></th>
        </tr>
        </thead>
		
		<tbody><?php foreach($this->items as $i => $item): ?>
        	<tr class="row<?php echo $i % 2; ?>">
        		<td>
        			<?php echo $item->id; ?>
        		</td>
        		<td>
        			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
        		</td>
        		<td>
        			<a href="<?php echo JRoute::_('index.php?option=com_bpsmember&task=bpsmember.edit&id=' . $item->id); ?>">
        				<?php echo $item->first_name; ?>
        			</a>
        		</td>
                <td>
        			<a href="<?php echo JRoute::_('index.php?option=com_bpsmember&task=bpsmember.edit&id=' . $item->id); ?>">
        				<?php echo $item->last_name; ?>
        			</a>
        		</td>
                <td>
        		
                    <?php echo $item->company_name; ?>
        		</td>
                <td>
        		
        				<?php echo $item->email; ?>
        			
        		</td>
            	</tr>
        <?php endforeach; ?>
        </tbody>
        <tr>
    	<td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
         </tr>
	</table>
       
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0"  />
		<?php echo JHtml::_('form.token'); ?>
	</div>
    </div>
    
</form>
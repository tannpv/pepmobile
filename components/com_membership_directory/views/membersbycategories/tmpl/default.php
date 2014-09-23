<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// no direct access
defined('_JEXEC') or die;
jimport( 'joomla.application.module.helper' );

?>
<style>
.pagination ul li {
display: inline;
padding-right: 10px;
}
.pagination{
margin-left: 25px;
}
.pagination fieldset{
border : 1px dotted #CCCCCC;
margin-bottom: 10px;

}
</style>
<div class="span2">
<article>
<section>
<?php  // var_dump();exit; ?>
<h3>PEP Membership Listing </h3>

		<form  action="">
			Select a category : <select name='categories' onchange='this.form.submit()'>
				<option value='none' selected >Searching...</option>
				<option value='' >Non Categories</option>
				<?php  foreach($this->item1 as $item) : ?>
					<?php if (!empty($item->business_category)) {?>
				<option value='<?php echo $item->business_category; ?>' <?php if($_GET[categories] == $item->business_category){ echo "selected='selected'"; } ?>><?php echo $item->business_category; ?></option>
					<?php } ?>
				<?php  endforeach; ?>		
			</select>
			<noscript><input type="submit" value="Submit"></noscript>
		</form>
<table class="member-listing" border="1" cellspacing="0" cellpadding="0">
<tr class="table-header">
    <th><h3 class="light-blue">Company Name</h3></th>
    <th><h3 class="light-blue">Representative</h3></th>

</tr>
<?php $show = false; ?>
        <?php foreach ($this->items as $row) : ?>

            
            <?php
            $show = true;            
            ?>
  <tr>
    <td><?php echo $row->company; ?></td>
    <td><a href="<?php echo $row->website; ?>" target="_blank"><?php echo $row->website; ?></a></td>
  </tr>
          <?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_MEMBERSHIP_DIRECTORY_NO_ITEMS'); 
        endif;
        ?>
</table>
<?php if ($show): ?>
    <div>
        <p class="counter">
		
            <?php  
			echo $this->pagination->getPagesCounter(); ?>
        </p>
		<div class="pagination" style="float:left; display: inline-block;">
        <?php echo $this->pagination->getPagesLinks(); ?>
		</div>
    </div>
<?php endif; ?>
</section>
</article>
<div >

</div>
</div>
<!--end left column-->
<div class="span3">
<article class="left-border">
<section>
<h4>Member only</h4>
<?php
$module = JModuleHelper::getModule('login');
echo JModuleHelper::renderModule ($module);
?>
</section>
<section>
  <p>&nbsp;</p>
</section>
</article>
</div>



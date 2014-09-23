<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.html.select' );
//var_dump($lists);
?>
<div class="col-group main-page">
<div class="span2">
<article>
<section>
<h3>PEP Membership Listing</h3>
<?php

	if (JSite::getMenu()->getActive()->alias == "members-by-categories"){ ?>		
		<form action="">
			Select a category : <select name='categories' onchange='this.form.submit()'>
				<option value='none' selected >Searching...</option>
				<?php  foreach($lists as $row) : ?>
				<option value='<?php echo $row->business_category; ?>' <?php if($_GET[categories] == $row->business_category){ echo "selected"; } ?>><?php echo $row->business_category; ?></option>
				<?php  endforeach; ?>		
			</select>
			<noscript><input type="submit" value="Submit"></noscript>
		</form>
	<?php
	
		if($_GET[categories] || $_GET[categories]==""){ 
		$db =& JFactory::getDBO();
		$query = " SELECT business_category,company,website FROM #__membership_directory 
                   WHERE business_category = '$_GET[categories]' "
;
		$db->setQuery((string) $query);
        $category = $db->loadObjectList();
		
		?>
<table class="member-listing" border="1" cellspacing="0" cellpadding="0">
<tr class="table-header">
    <th><h3 class="light-blue">Company Name</h3></th>
    <th><h3 class="light-blue">Representative</h3></th>

</tr>
<?php  foreach ($category as $row) : ?>
  <tr>
    <td><?php echo $row->company; ?></td>
    <td><a href="<?php echo $row->website; ?>" target="_blank" ><?php echo $row->website; ?></a></td>
  </tr>
<?php endforeach; ?>
 </table>
</section>
</article>
</div>
<div class="span3">
<article class="left-border">
<section>
<h4>Member only</h4>
<form>
<jdoc:include type="modules" name="loginform" />
</form>
</section>
<section>
  <p>&nbsp;</p>
</section>
</article>
</div>
</div>
		<?php }
	}
	else {
?>
<table class="member-listing" border="1" cellspacing="0" cellpadding="0">
<tr class="table-header">
    <th><h3 class="light-blue">Company Name</h3></th>
    <th><h3 class="light-blue">Representative</h3></th>

</tr>
<?php  foreach ($lists as $row) : ?>
  <tr>
    <td><?php echo $row->company ?></td>
    <td><a href="<?php echo $row->website ?>" ><?php echo $row->website ?></a></td>
  </tr>
<?php endforeach; ?>
 </table>
</section>
</article>
</div>
<div class="span3">
<article class="left-border">
<section>
<h4>Member only</h4>
<form>

</form>
</section>
<section>
  <p>&nbsp;</p>
</section>
</article>
</div>
</div>
<?php } ?>
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
<div class="span2">
<article>
<section>
<h3>PEP Membership Listing </h3>
<table class="member-listing" border="1" cellspacing="0" cellpadding="0">
<tr class="table-header">
    <th><h3 class="light-blue">Company Name</h3></th>
    <th><h3 class="light-blue">Representative</h3></th>

</tr>
<?php $show = false; ?>
        <?php foreach ($this->items as $item) : ?>

            
            <?php
            $show = true;            
            ?>
  <tr>
    <td><?php echo $item->company; ?></td>
    <td><a href="<?php echo $item->website; ?>" target="_blank"><?php echo $item->website; ?></a></td>
  </tr>
          <?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_MEMBERSHIP_DIRECTORY_NO_ITEMS'); 
        endif;
        ?>
</table>

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



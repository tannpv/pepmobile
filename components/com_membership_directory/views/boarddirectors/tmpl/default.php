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

      
?>

<script src="<?php echo JUri::root(); ?>components/com_membership_directory/js/ibox.js"></script>
  <script type="text/javascript">iBox.setPath('<?php echo JUri::root(); ?>components/com_membership_directory/js/');</script>
  <link href="<?php echo JUri::root(); ?>components/com_membership_directory/css/darkbox.css" media="screen"/>
<?php echo $this->item[0]->introtext; ?>`
   

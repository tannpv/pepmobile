<?php
/**
* @version $Id: default.php $ 
* @version		1.6.5 01/04/2011
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010-2011 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'accès direct
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::root().'components/com_myjspace/assets/myjspace.css');
?>
<h2>BS MyJspace</h2>
<div class="myjspace">
<br />
<p><?php echo $this->version; ?></p>
</div>

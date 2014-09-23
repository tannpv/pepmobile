<?php
/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */


// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHTML::_('script','system/multiselect.js',false,true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_payment/assets/css/payment.css');

?>

	<legend>Please select to on/off button BUY</legend>
	<input type="radio" value="1" name="s">Enable</input>
	<input type="radio" value="0" name="s">Disable</input>


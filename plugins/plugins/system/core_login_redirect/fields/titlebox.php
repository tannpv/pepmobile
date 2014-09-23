<?php
/*------------------------------------------------------------------------
# plg_core_login_redirect
# ------------------------------------------------------------------------
# author    JoomLadds / River Media
# copyright Copyright (C) 2013 JoomLadds All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomladds.com
# Technical Support:  Forum - http://www.joomladds.com/forum.html
-------------------------------------------------------------------------*/

defined('JPATH_BASE') or die();

/**
 * Renders a text element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JFormFieldTitleBox extends JFormField
{
	public $type = 'TitleBox';
	public function getInput(){
		// Output		
		if(version_compare(JVERSION,'3.0','lt')) {
			return '<div class="titleBox">
	<div class="info">
		'.JText::_($this->value).'
	</div>
</div>';
		}else{
			return false;
		}
	}

	public function getLabel() {
		if(version_compare(JVERSION,'3.0','lt')) {
			return false;
		}else{
			return '</div><legend>'.JText::_($this->value).'</legend><div>';
		}
	}
}

?>

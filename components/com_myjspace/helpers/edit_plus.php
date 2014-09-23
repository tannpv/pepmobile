<?php
/**
* @version $Id: edit_plus.php $
* @version		1.8.0 04/04/2012
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2012 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

	// Display the button for MyJspace edit page (inspired on _displayButtons() : plugins/editors/tinymce/tinymce.php)
	function _my_aff_buttons($editor_name='mjs_content', $buttons=true, $editor_selection = 'myjsp') {

/*
		// Load modal popup behavior
		JHtml::_('behavior.modal', 'a.modal-button');

		$args['name'] = $editor_name;
		$args['event'] = 'onGetInsertMethod';

		$return = '';
		$results[] = $this->update($args);

		foreach ($results as $result)
		{
			if (is_string($result) && trim($result)) {
				$return .= $result;
			}
		}
*/		
		if ($buttons != true)
			return '';
			
//j1.8	if ($editor_selection == 1)
//			$editor =& JFactory::getEditor('tinymce'); // 'tinymce' to have the right content (css & js and not other noisy stuff like for JCE just for the button list) for MyJspace editor

		$editor =& JFactory::getEditor($editor_selection);
		$results = $editor->getButtons($editor_name, $buttons);
		$return = "\n<div id=\"editor-xtd-buttons\">\n";
		$forbiden_button = array('article','image','readmore');
		
		foreach ($results as $button) {		
			// Results should be an object
			if ( $button->get('name') && !in_array($button->get('name'), $forbiden_button) ) {
				$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
				$href		= ($button->get('link')) ? 'href="'.JURI::base().$button->get('link').'"' : null;
				$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : 'onclick="IeCursorFix(); return false;"';
				$title      = ($button->get('title')) ? $button->get('title') : $button->get('text');
				$return .= "<div class=\"button2-left\"><div class=\"".$button->get('name')."\"><a ".$modal." title=\"".$title."\" ".$href." ".$onclick." rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
			}
		}

		$return .= "</div>\n";
		return $return;
	}
	
	// Return javascript to allow the buttons to be efficient
	function _my_button_js() {
	
	if (version_compare(JVERSION,'1.6.0','ge')) {
		$return = "
	window.addEvent('domready', function() {

		SqueezeBox.initialize({});
		SqueezeBox.assign($$('a.modal-button'), {
			parse: 'rel'
		});
	});
		";
	} else {
	$return = "
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});

			$$('a.modal-button').each(function(el) {
				el.addEvent('click', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
		
		";
	}
	
	$return .= "
		function isBrowserIE() {
		return navigator.appName==\"Microsoft Internet Explorer\";
	}

	function jInsertEditorText( text, editor ) {
		if (isBrowserIE()) {
			if (window.parent.tinyMCE) {
				window.parent.tinyMCE.selectedInstance.selection.moveToBookmark(window.parent.global_ie_bookmark);
			}
		}
		tinyMCE.execInstanceCommand(editor, 'mceInsertContent',false,text);
	}

	var global_ie_bookmark = false;
	
	function IeCursorFix() {
		if (isBrowserIE()) {
			tinyMCE.execCommand('mceInsertContent', false, '');
			global_ie_bookmark = tinyMCE.activeEditor.selection.getBookmark(false);
		}
		return true;
	}
	";
		return $return;
	}

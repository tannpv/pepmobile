<?php
/**
 * @version     1.0.0
 * @package     com_payment
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dai Ngo <superqd89@gmail.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Payment helper.
 */
class PaymentHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_PAYMENT_TITLE_CUSTOMERS'),
			'index.php?option=com_payment&view=customers',
			$vName == 'customers'
		);
		JSubMenuHelper::addEntry(
			JText::_('config'),
			'index.php?option=com_payment&view=config',
			$vName == 'config'
		);
		JSubMenuHelper::addEntry(
			JText::_('Breakfast Payment'),
			'index.php?option=com_payment&view=breakfast',
			$vName == 'breakfast'
		);
		JSubMenuHelper::addEntry(
			JText::_('Transaction History'),
			'index.php?option=com_payment&view=histories',
			$vName == 'histories'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_payment';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}

<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @since		1.6
 */
abstract class modQuickIconHelper
{
	/**
	 * Stack to hold buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();
        protected static $admin_buttons = array();
	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @param	JRegistry	The module parameters.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons($params)
	{       $user= JFactory::getUser();
		$key = (string)$params;
               
		if (!isset(self::$buttons[$key])) {
			$context = $params->get('context', 'mod_quickicon');
			if ($context == 'mod_quickicon')
			{
				// Load mod_quickicon language file in case this method is called before rendering the module
			JFactory::getLanguage()->load('mod_quickicon');
                      	self::$buttons[$key] = array(
					array(
						'link' => JRoute::_('index.php?option=com_content&task=article.add'),
						'image' => 'header/icon-48-article-add.png',
						'text' => JText::_('MOD_QUICKICON_ADD_NEW_ARTICLE'),
						'access' => array('core.manage', 'com_content', 'core.create', 'com_content', )
					),
					array(
						'link' => JRoute::_('index.php?option=com_content'),
						'image' => 'header/icon-48-article.png',
						'text' => JText::_('MOD_QUICKICON_ARTICLE_MANAGER'),
						'access' => array('core.manage', 'com_content')
					),
					array(
						'link' => JRoute::_('index.php?option=com_categories&extension=com_content'),
						'image' => 'header/icon-48-category.png',
						'text' => JText::_('MOD_QUICKICON_CATEGORY_MANAGER'),
						'access' => array('core.manage', 'com_content')
					),
					array(
						'link' => JRoute::_('index.php?option=com_media'),
						'image' => 'header/icon-48-media.png',
						'text' => JText::_('MOD_QUICKICON_MEDIA_MANAGER'),
						'access' => array('core.manage', 'com_media')
					),
					array(
						'link' => JRoute::_('index.php?option=com_menus'),
						'image' => 'header/icon-48-menumgr.png',
						'text' => JText::_('MOD_QUICKICON_MENU_MANAGER'),
						'access' => array('core.manage', 'com_menus')
					),
					array(
						'link' => JRoute::_('index.php?option=com_users'),
						'image' => 'header/icon-48-user.png',
						'text' => JText::_('MOD_QUICKICON_USER_MANAGER'),
						'access' => array('core.manage', 'com_users')
					),
					array(
						'link' => JRoute::_('index.php?option=com_modules'),
						'image' => 'header/icon-48-module.png',
						'text' => JText::_('MOD_QUICKICON_MODULE_MANAGER'),
						'access' => array('core.manage', 'com_modules')
					),
					array(
						'link' => JRoute::_('index.php?option=com_installer'),
						'image' => 'header/icon-48-extension.png',
						'text' => JText::_('MOD_QUICKICON_EXTENSION_MANAGER'),
						'access' => array('core.manage', 'com_installer')
					),
					array(
						'link' => JRoute::_('index.php?option=com_languages'),
						'image' => 'header/icon-48-language.png',
						'text' => JText::_('MOD_QUICKICON_LANGUAGE_MANAGER'),
						'access' => array('core.manage', 'com_languages')
					),
					array(
						'link' => JRoute::_('index.php?option=com_config'),
						'image' => 'header/icon-48-config.png',
						'text' => JText::_('MOD_QUICKICON_GLOBAL_CONFIGURATION'),
						'access' => array('core.manage', 'com_config', 'core.admin', 'com_config')
					),
					array(
						'link' => JRoute::_('index.php?option=com_templates'),
						'image' => 'header/icon-48-themes.png',
						'text' => JText::_('MOD_QUICKICON_TEMPLATE_MANAGER'),
						'access' => array('core.manage', 'com_templates')
					),
					array(
						'link' => JRoute::_('index.php?option=com_admin&task=profile.edit&id='.JFactory::getUser()->id),
						'image' => 'header/icon-48-user-profile.png',
						'text' => JText::_('MOD_QUICKICON_PROFILE'),
						'access' => true
					),
                                       array(
						'link' => JRoute::_('index.php?option=com_jinc'),
						'image' => 'header/icon-48-jinc.png',
						'text' => JText::_('Newsletter'),
						'access' => true
					),
                                     array(
						'link' => JRoute::_('index.php?option=com_phocagallery'),
						'image' => 'header/icon-48-pg-phoca.png',
						'text' => JText::_('Phoca Gallery'),
						'access' => true
					),
                                     array(
						'link' => JRoute::_('index.php?option=com_newsfeeds'),
						'image' => 'header/icon-48-newsfeeds.png',
						'text' => JText::_('News Feeds'),
						'access' => true
					),
					array(
						'link' => JRoute::_('index.php?option=com_membership_directory'),
						'image' => 'header/icon-48-membership.png',
						'text' => JText::_('Membership Directory'),
						'access' => true
					),
					array(
						'link' => JRoute::_('index.php?option=com_bpsmember'),
						'image' => 'header/icon-48-user.png',
						'text' => JText::_('BPS Member'),
						'access' => array('core.manage', 'com_bpsmember')
					),
					array(
						'link' => JRoute::_('index.php?option=com_uploadpdf'),
						'image' => 'header/icon-48-uploadpdf.png',
						'text' => JText::_('PEP talk issues'),
						'access' => true
					),
					array(
						'link' => JRoute::_('/administrator/index.php?option=com_plugins&task=plugin.edit&extension_id=10120'),
						'image' => 'header/icon-48-uploadpdf.png',
						'text' => JText::_('Card Buy Manager'),
						'access' => array('core.manage', 'com_plugins')
					),
					array(
						'link' => JRoute::_('index.php?option=com_payment'),
						'image' => 'header/icon-48-export-payment.png',
						'text' => JText::_('Export Payment'),
						'access' => true
					),
				);
			}
			else
			{
				self::$buttons[$key] = array();
			}

			// Include buttons defined by published quickicon plugins
			JPluginHelper::importPlugin('quickicon');
			$app = JFactory::getApplication();
			$arrays = (array) $app->triggerEvent('onGetIcons', array($context));

			foreach ($arrays as $response) {
				foreach ($response as $icon) {
					$default = array(
						'link' => null,
						'image' => 'header/icon-48-config.png',
						'text' => null,
						'access' => true
					);
					$icon = array_merge($default, $icon);
					if (!is_null($icon['link']) && !is_null($icon['text'])) {
						self::$buttons[$key][] = $icon;
					}
				}
			}
		}

		return self::$buttons[$key];
	}

	/**
	 * Get the alternate title for the module
	 *
	 * @param	JRegistry	The module parameters.
	 * @param	object		The module.
	 *
	 * @return	string	The alternate title for the module.
	 */
        
        public static function &getButtonsData($params)
        {
          $db=  JFactory::getDbo();
          $user=  JFactory::getUser();
          $userID=$user->id;
         // var_dump($user);

          $query="select button FROM jos_users where id=".$userID;
          $db->setQuery($query);
          $button_id=$db->loadResult();
         
			// $query = "select buttons FROM jos_usergroups as ug 
					// INNER JOIN jos_user_usergroup_map as ugm ON ugm.group_id = ug.id
					// where ugm.user_id=" . $userID;
			// $db->setQuery($query);
			// $button_id_array = $db->loadObjectlist();
			// foreach ($button_id_array as $bk) {
				// if ($bk->buttons) {
					// $button_id[] = $bk->buttons;
				// }
			// }
			// $button_id = implode(",", $button_id);
          $query="select * from jos_usercom where id IN (".$button_id.") order by `name` ASC";

          $db->setQuery($query);
          $button=$db->loadObjectList();
         // var_dump($button); exit;
          if(isset($button))
          {
          foreach ($button as $key=>$value)
          {
             $data_button[$key]['link']=  JRoute::_($value->link);  
             $data_button[$key]['image']= $value->image;  
             $data_button[$key]['text']= JText::_($value->name); 
			if($value->access=="true"){
              $data_button[$key]['access']=true;
             }
             else {
             $data_button[$key]['access']= explode(",",$value->access); }
          }
         
         // var_dump($data_button);
            if (empty(self::$admin_buttons)) {
                   self::$admin_buttons = $data_button;
            }

            return self::$admin_buttons;
        }
         }

            public static function getTitle($params, $module)
            {
                    $key = $params->get('context', 'mod_quickicon') . '_title';
                    if (JFactory::getLanguage()->hasKey($key))
                    {
                            return JText::_($key);
                    }
                    else
                    {
                            return $module->title;
                    }
            }
}

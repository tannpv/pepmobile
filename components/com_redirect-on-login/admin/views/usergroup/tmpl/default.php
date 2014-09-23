<?php
/**
* @package Redirect-On-Login (com_redirectonlogin)
* @version 3.1.0
* @copyright Copyright (C) 2008 - 2013 Carsten Engel. All rights reserved.
* @license GPL versions free/trial/pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!isset($this->redirect->id)){
	//usergroup is not in table yet
	//set default values
	$redirect_id = '';
	$redirect_frontend_type = 'none';
	$redirect_frontend_url = 'index.php';	
	$redirect_frontend_type_logout = 'none';
	$redirect_frontend_url_logout = 'index.php';	
	$redirect_backend_type = 'none';
	$redirect_backend_url = 'index.php';
	$redirect_backend_component = '';
	$opening_site = 'normal';
	$opening_site_url = 'index.php';
	$opening_site_home = '1';
	$menuitem_login = 0;
	$menuitem_open = 0;
	$menuitem_logout = 0;
	$dynamic_login = 0;
	$dynamic_open = 0;
	$dynamic_logout = 0;
	$open_type = 'url';
	$inherit_login = 0;
	$inherit_open = 0;
	$inherit_logout = 0;
	$inherit_backend = 0;
}else{
	//get value when edit
	$redirect_id = $this->redirect->id;
	$redirect_frontend_type = $this->redirect->frontend_type;
	$redirect_frontend_url = $this->redirect->frontend_url;	
	$redirect_frontend_type_logout = $this->redirect->frontend_type_logout;
	$redirect_frontend_url_logout = $this->redirect->frontend_url_logout;	
	$redirect_backend_type = $this->redirect->backend_type;
	$redirect_backend_url = $this->redirect->backend_url;
	$redirect_backend_component = $this->redirect->backend_component;	
	$opening_site = $this->redirect->opening_site;
	$opening_site_url = $this->redirect->opening_site_url;
	$opening_site_home = $this->redirect->opening_site_home;
	if($opening_site==''){
		$opening_site = 'normal';
	}
	$menuitem_login = $this->redirect->menuitem_login;
	$menuitem_open = $this->redirect->menuitem_open;
	$menuitem_logout = $this->redirect->menuitem_logout;
	$dynamic_login = $this->redirect->dynamic_login;
	$dynamic_open = $this->redirect->dynamic_open;
	$dynamic_logout = $this->redirect->dynamic_logout;
	$open_type = $this->redirect->open_type;
	if($open_type==''){
		$open_type = 'url';
	}
	$inherit_login = $this->redirect->inherit_login;
	$inherit_open = $this->redirect->inherit_open;
	$inherit_logout = $this->redirect->inherit_logout;
	$inherit_backend = $this->redirect->inherit_backend;
}

$checked = 'checked="checked"';

?>
<script language="JavaScript" type="text/javascript">

	
Joomla.submitbutton = function(task){	
	if (task=='cancel'){			
		document.location.href = 'index.php?option=com_redirectonlogin&view=usergroups';		
	} else {
		if (task=='usergroup_apply'){	
			document.adminForm.apply.value = '1';
		}
		submitform('usergroup_save');
	}	
}

</script>
<form action="" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
	<?php endif; ?>	
	<div id="j-main-container"<?php echo empty($this->sidebar) ? '' : ' class="span10"'; ?>>
		<div class="clr"> </div><!-- needed for some admin templates -->		
		<div class="fltlft">
			<h2 class="rol_h2"><?php echo JText::_('COM_REDIRECTONLOGIN_USERGROUP_REDIRECT').': '.$this->group_title; ?></h2>			
			<fieldset class="adminform">
				<legend class="rol_legend"><?php echo JText::_('COM_REDIRECTONLOGIN_FRONTEND'); ?></legend>
				<?php
				if($this->controller->rol_config['frontend_u_or_a']=='a'){
					echo '<div class="rol_fontsize rol_warning rol_padleft">';
					echo JText::_('COM_REDIRECTONLOGIN_NOT_SET_TO_USERGROUPS').' <a href="index.php?option=com_redirectonlogin&view=configuration#frontend">'.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION')).'</a>.';
					echo '</div>';
				}
				?>	
				<table class="adminlist rol_table tabletop">				
					<tr>
						<td class="rol_nowrap" style="width: 250px;">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_TYPE_LOGIN'); ?></label>
						</td>
						<td colspan="3">
							 <?php echo JText::_('COM_REDIRECTONLOGIN_UNLESS_OVERRULED_USER'); ?>.
						</td>					
					</tr>
					<tr>
						<td>&nbsp;						
						</td>
						<td class="rol_nowrap" style="width: 150px;">
							<label><input type="radio" name="redirect_frontend_type" value="none" <?php if($redirect_frontend_type=='none'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>						
						</td>
						<td colspan="2">
							<?php											
							echo JText::_('COM_REDIRECTONLOGIN_LOGIN').' '.JText::_('COM_REDIRECTONLOGIN_AS_CONFIGURED_FOR_ALL_USERS').' <a href="index.php?option=com_redirectonlogin&view=configuration#frontend">';
							echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION'));
							echo '</a>. ';
							echo JText::_('COM_REDIRECTONLOGIN_IF_SET_TO').' \''.JText::_('COM_REDIRECTONLOGIN_NORMAL').'\', ';
							echo JText::_('COM_REDIRECTONLOGIN_NORMAL').' Joomla '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_LOGIN'));					
							?>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="no" <?php if($redirect_frontend_type=='no'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO_REDIRECT_LOGIN'); ?>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="same" <?php if($redirect_frontend_type=='same'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_SAME_PAGE'); ?></label>
						</td>
						<td colspan="2">
						
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type=='menuitem' && !$menuitem_login){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_MENUITEM_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="menuitem" <?php if($redirect_frontend_type=='menuitem'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_MENUITEM'); ?></label>
						</td>
						<td colspan="2">
							<?php echo $this->menuitem_login_select; ?>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type=='url' && $redirect_frontend_url==''){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="url" <?php if($redirect_frontend_type=='url'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
						</td>
						<td colspan="2">
							<input type="text" name="frontend_url" style="width: 450px;" value="<?php echo $redirect_frontend_url;?>" /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL_FULL'); ?>.
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type=='dynamic' && !$dynamic_login){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="dynamic" <?php if($redirect_frontend_type=='dynamic'){echo $checked;}?> /> 
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECT')); ?></label>
						</td>
						<td>
							<?php echo $this->dynamic_login_select; ?>
						</td>
						<td>
							<?php
								if($this->controller->get_version_type()=='free'){
									echo '<div style="color: red;">';
									echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
									echo '</div>';
								}
							?>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type=='inherit' && !$inherit_login){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_GROUP_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="inherit" <?php if($redirect_frontend_type=='inherit'){echo $checked;}?> /> 
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_INHERIT')); ?></label>
						</td>
						<td colspan="2">
							<?php 
							echo JText::_('COM_REDIRECTONLOGIN_INHERIT_FROM').' '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_USERGROUP')).': ';	
							echo $this->inherit_login_select; ?>						
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type" value="logout" <?php if($redirect_frontend_type=='logout'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_BLOCK_LOGIN'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_A'); ?>. <?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_B'); ?> <a href="index.php?option=com_redirectonlogin&view=configuration#frontend"><?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION')); ?></a>.					
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td class="rol_nowrap">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_WHEN_OPENING_SITE'); ?></label>
						</td>
						<td colspan="3">
							<?php 
							if($this->controller->get_version_type()=='free'){
								echo '<div style="color: red;">';
								echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
								echo '</div>';
							}
							echo JText::_('COM_REDIRECTONLOGIN_WHEN_OPENING_SITE_INFO').' '.JText::_('COM_REDIRECTONLOGIN_SESSION'); ?>. <?php echo JText::_('COM_REDIRECTONLOGIN_UNLESS_OVERRULED_USER'); ?>.
						</td>					
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="opening_site" value="normal" <?php if($opening_site=='normal'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_AS_CONFIGURED_IN').' <a href="index.php?option=com_redirectonlogin&view=configuration#opening_site">';
							echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION'));
							echo '</a>. ';			
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="opening_site" value="no" <?php if($opening_site=='no'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO_REDIRECT_WHEN_OPENING_SITE'); ?>.
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="opening_site" value="yes" <?php if($opening_site=='yes'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_YES'); ?></label>
						</td>
						<td colspan="2">
							<label><input type="checkbox" name="opening_site_home" value="1" <?php if($opening_site_home){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_SITE_HOME'); ?></label>
												
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td style="text-align: right; color: red;" class="rol_nowrap">
							<?php 
							if($opening_site=='yes' && $open_type=='menuitem' && !$menuitem_open){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_MENUITEM_SELECTED');							
							}				
							?>
						</td>
						<td width="150">	
							<label><input type="radio" name="open_type" value="menuitem" <?php if($open_type=='menuitem'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_MENUITEM'); ?></label>						
						</td>
						<td>					
							<?php echo $this->menuitem_open_select; ?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td style="text-align: right; color: red;" class="rol_nowrap">
							<?php 
							if( $opening_site=='yes' && $opening_site_url=='' && $open_type=='url'){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}				
							?>
						</td>
						<td width="150">	
							<label><input type="radio" name="open_type" value="url" <?php if($open_type=='url'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>						
						</td>
						<td>					
							<input type="text" name="opening_site_url" style="width: 450px;" value="<?php echo $opening_site_url;?>" /> <?php echo JText::_('COM_REDIRECTONLOGIN_URL_FULL'); ?>.	
						</td>
					</tr>				
					<tr>
						<td>&nbsp;
							
						</td>
						<td style="text-align: right; color: red;" class="rol_nowrap">
							<?php 
							if($opening_site=='yes' && $open_type=='dynamic' && !$dynamic_open){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');							
							}				
							?>
						</td>
						<td width="150">	
							<label><input type="radio" name="open_type" value="dynamic" <?php if($open_type=='dynamic'){echo $checked;}?> /> 
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECT')); ?></label>				
						</td>
						<td>					
							<?php echo $this->dynamic_open_select; ?>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($opening_site=='inherit' && !$inherit_open){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_GROUP_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="opening_site" value="inherit" <?php if($opening_site=='inherit'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_INHERIT'); ?></label>
						</td>
						<td colspan="2">
							<?php 
							echo JText::_('COM_REDIRECTONLOGIN_INHERIT_FROM').' '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_USERGROUP')).': ';	
							echo $this->inherit_open_select; ?>						
						</td>
					</tr>					
					<tr>
						<td colspan="4">&nbsp;
													
						</td>
					</tr>
					<tr>
						<td class="rol_nowrap" style="width: 250px;">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_TYPE_LOGOUT'); ?></label>
						</td>
						<td colspan="3">
							<?php 
							if($this->controller->get_version_type()=='free'){
								echo '<div style="color: red;">';
								echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
								echo '</div>';
							}
							echo JText::_('COM_REDIRECTONLOGIN_UNLESS_OVERRULED_USER'); 
							?>.							
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap"  style="width: 150px;">
							<label><input type="radio" name="redirect_frontend_type_logout" value="none" <?php if($redirect_frontend_type_logout=='none'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>
						</td>
						<td colspan="2">
							<?php			
							echo JText::_('COM_REDIRECTONLOGIN_LOGOUT').' '.JText::_('COM_REDIRECTONLOGIN_AS_CONFIGURED_FOR_ALL_USERS').' <a href="index.php?option=com_redirectonlogin&view=configuration#frontend">';
							echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION'));
							echo '</a>. ';
							echo JText::_('COM_REDIRECTONLOGIN_IF_SET_TO').' \''.JText::_('COM_REDIRECTONLOGIN_NORMAL').'\', ';
							echo JText::_('COM_REDIRECTONLOGIN_NORMAL').' Joomla '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_LOGOUT'));						
							?>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type_logout" value="no" <?php if($redirect_frontend_type_logout=='no'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO'); ?></label>
						</td>
						<td colspan="2">
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO_REDIRECT_LOGOUT'); ?>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type_logout" value="same" <?php if($redirect_frontend_type_logout=='same'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_SAME_PAGE'); ?></label>
						</td>
						<td colspan="2">
							
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type_logout=='menuitem' && !$menuitem_logout){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_MENUITEM_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type_logout" value="menuitem" <?php if($redirect_frontend_type_logout=='menuitem'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_MENUITEM'); ?></label>
						</td>
						<td colspan="2">
							<?php echo $this->menuitem_logout_select; ?>
						</td>
					</tr>	
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type_logout=='url' && $redirect_frontend_url_logout==''){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type_logout" value="url" <?php if($redirect_frontend_type_logout=='url'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
						</td>
						<td colspan="2">
							<input type="text" name="frontend_url_logout" style="width: 450px;" value="<?php echo $redirect_frontend_url_logout;?>" /> <?php echo JText::_('COM_REDIRECTONLOGIN_URL_FULL'); ?>.
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type_logout=='dynamic' && !$dynamic_logout){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_DYNAMIC_REDIRECTS_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type_logout" value="dynamic" <?php if($redirect_frontend_type_logout=='dynamic'){echo $checked;}?> /> 
							<?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_DYNAMIC_REDIRECT')); ?></label>
						</td>
						<td colspan="2">
							<?php echo $this->dynamic_logout_select; ?>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_frontend_type_logout=='inherit' && !$inherit_logout){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_GROUP_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_frontend_type_logout" value="inherit" <?php if($redirect_frontend_type_logout=='inherit'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_INHERIT'); ?></label>
						</td>
						<td colspan="2">
							<?php 
							echo JText::_('COM_REDIRECTONLOGIN_INHERIT_FROM').' '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_USERGROUP')).': ';	
							echo $this->inherit_logout_select; ?>						
						</td>
					</tr>					
				</table>					
			</fieldset>		
			<fieldset class="adminform">
				<legend class="rol_legend"><?php echo JText::_('COM_REDIRECTONLOGIN_BACKEND'); ?></legend>			
				<table class="adminlist rol_table tabletop">				
					<tr>
						<td class="rol_nowrap" style="width: 250px;">
							<label class="hasTip required"><?php echo JText::_('COM_REDIRECTONLOGIN_REDIRECT_TYPE_LOGIN'); ?></label>
						</td>
						<td colspan="2">
							<?php 
							if($this->controller->get_version_type()=='free'){
								echo '<div style="color: red;">';
								echo JText::_('COM_REDIRECTONLOGIN_NOT_IN_FREE_VERSION');
								echo '</div>';
							}
							echo JText::_('COM_REDIRECTONLOGIN_UNLESS_OVERRULED_USER'); 
							?>.
						</td>					
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap"  style="width: 150px;">
							<label><input type="radio" name="redirect_backend_type" value="none" <?php if($redirect_backend_type=='none'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NORMAL'); ?></label>
						</td>
						<td>
							<?php											
							echo JText::_('COM_REDIRECTONLOGIN_LOGIN').' '.JText::_('COM_REDIRECTONLOGIN_AS_CONFIGURED_FOR_ALL_USERS').' <a href="index.php?option=com_redirectonlogin&view=configuration#frontend">';
							echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION'));
							echo '</a>. ';
							echo JText::_('COM_REDIRECTONLOGIN_IF_SET_TO').' \''.JText::_('COM_REDIRECTONLOGIN_NORMAL').'\', ';
							echo JText::_('COM_REDIRECTONLOGIN_NORMAL').' Joomla '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_LOGIN'));					
							?>.
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_backend_type" value="no" <?php if($redirect_backend_type=='no'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO'); ?></label>
						</td>
						<td>
							<?php echo JText::_('COM_REDIRECTONLOGIN_NO_REDIRECT_LOGIN'); ?>.
						</td>
					</tr>
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($redirect_backend_type=='url' && $redirect_backend_url==''){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_URL');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_backend_type" value="url" <?php if($redirect_backend_type=='url'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_URL'); ?></label>
						</td>
						<td>
							administrator/<input type="text" name="backend_url" style="width: 450px;" value="<?php echo $redirect_backend_url;?>" />
						</td>
					</tr>
					<tr>
						<td style="text-align: right; color: red;">
							<?php 
							if($redirect_backend_type=='component' && $redirect_backend_component=='0'){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_COMPONENT_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_backend_type" value="component" <?php if($redirect_backend_type=='component'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_COMPONENT'); ?></label>
						</td>
						<td>
							<select name="backend_component">					
								<?php
								echo '<option value="0"> - '.JText::_('COM_REDIRECTONLOGIN_SELECT_COMPONENT').' - </option>';							
								for($n = 0; $n < count($this->components); $n++){							
									echo '<option value="'.$this->components[$n][1].'"';
									if($redirect_backend_component==$this->components[$n][1]){
										echo ' selected="selected"';
									}
									echo '>';												
									echo strtolower($this->components[$n][0]);
									echo '</option>';								
								}
								?>						
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align: right;color: red;" class="rol_nowrap">
							<?php 
							if($redirect_backend_type=='inherit' && !$inherit_backend){							
								echo JText::_('COM_REDIRECTONLOGIN_NO_GROUP_SELECTED');							
							}				
							?>
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_backend_type" value="inherit" <?php if($redirect_backend_type=='inherit'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_INHERIT'); ?></label>
						</td>
						<td>
							<?php 
							echo JText::_('COM_REDIRECTONLOGIN_INHERIT_FROM').' '.$this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_USERGROUP')).': ';	
							echo $this->inherit_backend_select; ?>						
						</td>
					</tr>	
					<tr>
						<td>&nbsp;
							
						</td>
						<td class="rol_nowrap">
							<label><input type="radio" name="redirect_backend_type" value="logout" <?php if($redirect_backend_type=='logout'){echo $checked;}?> /> 
							<?php echo JText::_('COM_REDIRECTONLOGIN_BLOCK_LOGIN'); ?></label>
						</td>
						<td>
							<?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_A'); ?>. <?php echo JText::_('COM_REDIRECTONLOGIN_LOGOUT_B'); ?> <a href="index.php?option=com_redirectonlogin&view=configuration#backend"><?php echo $this->controller->rol_strtolower(JText::_('COM_REDIRECTONLOGIN_CONFIGURATION')); ?></a>.					 					
						</td>
					</tr>				
				</table>			
			</fieldset>		
		</div>	
	</div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="apply" value="" />
	<input type="hidden" name="redirect_id" value="<?php echo $redirect_id; ?>" />
	<input type="hidden" name="group_id" value="<?php echo $this->group_id; ?>" />		
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php
/**
* @version $Id: myjspace.php $ 
* @version		1.6.0 05/09/2010
* @package		com_myjspace
* @author       Bernard Saulmé
* @copyright	Copyright (C) 2010 Bernard Saulmé
* @license      GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// Pas d'acces directs
defined('_JEXEC') or die('Restricted access');

// jimport('joomla.application.component.helper');

// Necessite le controleur de base
require_once (JPATH_COMPONENT.DS.'controller.php');
// 
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
// 
$classname	= 'MyjspaceController'.$controller;
// Cree le nouveau controleur
$controller = new $classname( );
// Execute la requete
$controller->execute( JRequest::getVar('task'));
// Redirection si affecté par le controleur
$controller->redirect();
?>

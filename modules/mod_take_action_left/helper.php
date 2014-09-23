<?php

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

class modTakeActionLeft {

    function getArticle($params) {

        $model = JModel::getInstance('Article', 'ContentModel', array('ignore_request' => true));
        
        $app = JFactory::getApplication();//vucao
        $appParams = $app->getParams();///vucao
        $model->setState('params', $appParams);//vucao      
         $item = $model->getItem((int) $params->get('article_id'));
          return $item;
       
    }

}

?>
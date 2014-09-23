<?php
/**
 * @package Xpert Tabs
 * @version 2.1
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
$count = count($list);

$tabs = $params->get('count',3);
$width = ($params->get('width') == NULL OR $params->get('width') == 0 OR $params->get('width') == 'auto')? 'auto': $params->get('width');
$tabs_position = $params->get('tabs_position','top');

if(intval($tabs) > $count) $tabs = $count;
elseif(intval($tabs) == 0) $tabs = $count;

$tabs_title = modXpertTabsHelper::generateTabs($tabs,$list,$params);
?>

<!--Xpert Tabs by ThemeXpert(www.themexpert.com)- Start-->
    <div id="<?php echo $module_id;?>" class="xt-wrapper <?php echo $params->get('style','style1');?>" style="width:277<?php //echo $width;?>">
        <?php if($tabs_position == 'top') echo $tabs_title;?>

        <div id="<?php echo $module_id;?>-pans"  class="xt-pans">
            <?php
                if ($tabs == 0) $tabs = count($list);
                for($i=0; $i<$tabs; $i++){
                    if($list[$i]->content != NULL){
                        echo "<div class='xt-pane1'>\n";
                            echo $list[$i]->content;
                        echo "</div>\n";
                    }
                }

                ?>
        </div>

        <?php if($tabs_position == 'bottom') echo $tabs_title;?>


    </div>
    <!--Xpert Tabs by ThemeXpert- End-->
	<div id="xt172" class="xt-wrapper custom" style="width:277">
	<div class="xt-nav top">
		<ul>
		<li class="last" style="text-align:center !important">
		<a class="current" href="#">
		<span>View Member Site </span>
		</a>
		</li>
		</ul>
		<div class="clear"></div>
		</div>
</div>
	
	
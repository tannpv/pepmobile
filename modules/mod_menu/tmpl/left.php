<?php

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.

?>

<?php



  foreach ($list as $item) :
      
            $title = $item->title;
 
            echo '
                      <a href="' . $item->flink . ' ">' . $title . '</a><br>
                 ';
      

    endforeach;

?>



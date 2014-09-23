<?
include('header.php');

$sDB = new ps_DB;   //series database connection
$sIDs = array();  //array to store IDs of series in category
$sNames = array();  //array to store names of series in category
$sImages = array(); //array to store thumbnail image paths of series in category
$thumb_per_row = 4; //number of thumbnails per row

$db->query("SELECT * FROM category WHERE categoryID='$catID' ORDER BY name");
$db->next_record();

$sDB->query("SELECT * FROM series WHERE categoryID='$catID' ORDER BY name");
while ($sDB->next_record()) {
	array_push($sNames, $sDB->f('name'));
	array_push($sIDs, $sDB->f('seriesID'));
	array_push($sImages, getThumb($sDB->f('image')));
}
?>

 <p><span class="headertxt"><? echo $db->f('type')." " .$db->f('name');?></span></p>
		  <table width="100" border="0" cellspacing="0" cellpadding="4">
		  <?
		    $icount = 0;
		    $ncount = 0;
		    echo "<tr>\n";
		    
		    //print row of thumbnails
		    foreach ($sImages as $tImage){
		    	echo "  <td><a href=item_detail.php?sid=$sIDs[$icount]><img src='$sImages[$icount]' border=0></a></td>\n";
		    	$icount++;
		    	if($icount % $thumb_per_row==0){
		    	  echo "</tr>\n<tr>\n";
		    	  for($i=0;$i<$thumb_per_row;$i++){
		    	    echo "  <td><a href=item_detail.php?sid=".$sIDs[$ncount+$i].">".$sNames[$ncount+$i]."</a></td>\n";
		          }
		          $ncount+=$thumb_per_row;
		          echo "</tr>\n<tr>\n";
		        }
		    }
		    $leftover = $icount % $thumb_per_row;
		    for($i=0;$i<$leftover;$i++){
		    	echo "  <td>&nbsp;</td>\n";
		    }
		    echo "</tr>\n<tr>";
		    for($i=0;$i<$leftover;$i++){
		    	echo "  <td><a href=item_detail.php?sid=".$sIDs[$ncount+$i].">".$sNames[$ncount+$i]."</a></td>\n";
		    }
		  ?>
          </table>
          <?
		    echo "<a href=products.php>Products</a> &#62;&#62; ";
            echo $db->f('type')." ".$db->f('name');
          ?>

<?include('footer.php');?>
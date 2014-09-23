<?
 
include('header.php');
$site = isset($_REQUEST['site']) ? $_REQUEST['site'] : 0;
$catID = isset($_REQUEST['catID']) ? $_REQUEST['catID'] : 3;
$sDB = new ps_DB;   //series database connection
$sIDs = array();  //array to store IDs of series in category
$sNames = array();  //array to store names of series in category
$sImages = array(); //array to store thumbnail image paths of series in category
$thumb_per_row = 4; //number of thumbnails per row
?>
<strong>Product Categories</strong>
<br>
<!-- 
Click on a Category Below to Browse Our Catalog<br><br>
<div class="category">
<?php    //$q  = "SELECT * FROM category " ;
            //      $q .= "WHERE site = " . $site ; 
            //      $q.= " ORDER BY cOrder";
		 // $db->query($q);
	
 //while($db->next_record()){
 
 ?>
 <div class="item">
 <a href="product_thumbs.php?catID=<?php //echo $db->f('categoryID')?>&site=<?php //echo $site;?>" ><?php //echo $db->f('type').$db->f('name')?></a>
 </div>
 <?php //}?>
</div>-->
<?php
$q = "SELECT * FROM category WHERE categoryID='$catID' AND site = '$site' ORDER BY name";
$db->query($q);

$db->next_record();

$q = "SELECT * FROM series WHERE categoryID='$catID' ORDER BY name";
$sDB->query($q);

while ($sDB->next_record()) {
//        $image_thumb = ($site != 2) ? getThumb($sDB->f('image')) : $sDB->f('image');

	array_push($sNames, $sDB->f('name'));
	array_push($sIDs, $sDB->f('seriesID'));
	array_push($sImages, getThumb($sDB->f('image')));
}
?>

<span class="headertxt"><?php echo $db->f('type')." " .$db->f('name');?></span>
		  <table width="100" border="0" cellspacing="0" cellpadding="4">
		  <?
		    $icount = 0;
		    $ncount = 0;
		    echo "<tr>\n";
		    
		    //print row of thumbnails
		    foreach ($sImages as $tImage){
		    	echo "  <td><a href=item_detail.php?sid=$sIDs[$icount]&site=$site><img src='http://charlestonlighting.com/dev/$sImages[$icount]' border=0></a></td>\n";
		    	$icount++;
		    	if($icount % $thumb_per_row==0){
		    	  echo "</tr>\n<tr>\n";
		    	  for($i=0;$i<$thumb_per_row;$i++){
		    	    echo "  <td><a href=item_detail.php?sid=".$sIDs[$ncount+$i]."&site=".$site.">".$sNames[$ncount+$i]."</a></td>\n";
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
		    	echo "  <td><a href=item_detail.php?sid=".$sIDs[$ncount+$i]."&site=".$site.">".$sNames[$ncount+$i]."</a></td>\n";
		    }
		  ?>
          </table>
          <?
		    echo "<a href=products.php?site=".$site.">Products</a> &#62;&#62; ";
            echo $db->f('type')." ".$db->f('name');
          ?>

<?include('footer.php');?>
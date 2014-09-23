<?
$onload = "onload=updateSpecial()";
include('header.php');


$cDB = new ps_DB;  //database connection for category
$mDB = new ps_DB;  //database connection for model
$iDB = new ps_DB;  //database connection for model images

$db->query("SELECT * FROM series WHERE seriesID='$sid'");
$db->next_record();

$q = "SELECT * FROM category WHERE categoryID='".$db->f('categoryID')."'";
$cDB->query($q);
$cDB->next_record();

$q = "SELECT * FROM model WHERE seriesID='".$db->f('seriesID')."'";
$mDB->query($q);

$q = "SELECT * FROM model_images WHERE series_id='".$db->f('seriesID')."'";
$iDB->query($q);



$numModels = $mDB->num_rows();
if($cDB->f('name')=="Lantern"){
	if($numModels==1)
	  $models = "only one size";
	else
	  $models = "$numModels sizes";
	  
	
	$lanText = $db->f('name')." Series Lanterns are available in $models. ".$db->f('long_description');
	$lanText2 = "The ".$db->f('name')." Series Lanterns are available in your choice of three colors: Bronze, Black, or Verde.";
}
else{
	$lanText = $db->f('long_description');
    $lanText2 = "&nbsp;";
}
?>

<span class="headertxt"><?echo $cDB->f('type')." ".$db->f('name')." ".$cDB->f('name');?></span><br>
            <table id="CLight02" width="550" border="0" cellspacing="0" cellpadding="10">

<!--              <tr>
                <td width="335" valign="top"><?echo $lanText?><br>
                    <br>
                    <br>
             
               </td>
                <td width="165" align="right" valign="top"><a href=<?echo $db->f('image')?> target='_blank'><img src="<?echo getFly($db->f('image'));?>" border="0"></a></td>
              </tr>-->
              <tr>
                <td width="550" valign="top" align="<?echo $db->f('text_align');?>">
                <a href=<?echo $db->f('image')?> target='_blank'>
                <img src="<?echo getFly($db->f('image'));?>" align="<?echo $db->f('image_align');?>" style="border: 6px solid black;"></a>
                <div id='specials'></div>
                <?echo $lanText?>
                  <?php  echo "<p><a href='pictures.php?series_id=".$db->f('seriesID')."' onClick=\"return popup(this,'view')\">Click Here</a> for more views</p>\n"; ?>
                </td>
              </tr>
			  <tr>
			  	<td colspan="2"><div align="center"><?echo $lanText2;?></div></td>
			  </tr>
            </table>
          <?if($numModels>0){?>
		  <p>          
		  <table id="detail" width="483" height="48">
              <tr>
                <td height="16"><div align="center"><strong>Model Number </strong></div></td>

                <td><div align="center"><strong>Width</strong></div></td>
                <td><div align="center"><strong>Height</strong></div></td>
				<td><div align="center"><strong>Depth</strong></div></td>
                <td><div align="center"><strong>PDF Drawing </strong></div></td>
                <td><div align="center"><strong>CAD Drawing </strong></div></td>
                
              </tr>
              <?
              while($mDB->next_record()){
              
              /* $query = "SELECT * FROM model_images WHERE model_id = ".$mDB->f('modelID');
               $iDB->query($query);
              */
              	echo "
              	<tr>
                <td height='16'><div align='center'>Model ".$mDB->f('model_number')."</div></td>";
                if ($mDB->f('width')!=0)
              	  echo "<td><div align='center'>".$mDB->f('width')."</div></td>\n";
              	else
              	  echo "<td>&nbsp;</td>\n";
              	if ($mDB->f('height')!=0)
              	  echo "<td><div align='center'>".$mDB->f('height')."</div></td>\n";
              	else
              	  echo "<td>&nbsp;</td>\n";
              	if ($mDB->f('depth')!=0)
              	  echo "<td><div align='center'>".$mDB->f('depth')."</div></td>\n";
              	else
              	  echo "<td>&nbsp;</td>\n";
              	if ($mDB->f('pdf')!='')
              	  echo "<td><div align='center'><a href='".$mDB->f('pdf')."' target='_blank'>Click to Open</a>&nbsp;</div></td>\n";
              	else
              	  echo "<td>&nbsp;</td>\n";
              	if ($mDB->f('dwg')!='')
              	  echo "<td><div align='center'><a href='".$mDB->f('dwg')."'>Click to Download</a>&nbsp;</div></td>\n";
              	else
              	  echo "<td>&nbsp;</td>\n";
      /********************************** REMOVED ********************************
       *    if ($iDB->num_rows() > 0)
      *       echo "<td><div align='center'><a href='pictures.php?model_id=".$mDB->f('modelID')."' onClick=\"return popup(this,'view')\">View Images</a>&nbsp;</div></td>\n";
      *      	else
      *       echo "<td>Coming soon</td>\n";
      *       echo "</tr>\n";
        ****************************************************************************** */       
                if($mDB->f('special')!=''){
                	$line_feeds = array("\r\n","\r","\n");
                	$specialTXT .= "<u>Model ".$mDB->f('model_number')."</u><br>".str_replace($line_feeds,"<br>",$mDB->f('special'))."<br><br>";
                }
              }
              if($specialTXT!=''){
              	$specialTXT = "<span class=specialtxt><b>This Product has Models on Sale!<b><br><br>$specialTXT</span>";
              }
              ?>
            </table>
		  </p>
		  <?}?>
		  <?
		    echo "<a href=products.php>Products</a> &#62;&#62; ";
            echo "<a href=product_thumbs.php?catID=".$cDB->f('categoryID').">";
            echo $cDB->f('type')." ".$cDB->f('name')."</a> &#62;&#62; ";
            echo $db->f('name');
          ?>
<script>
function updateSpecial(){
	var stext = '<?=$specialTXT?>';
	document.getElementById('specials').innerHTML=stext;
}
</script>
<?include('footer.php');?>
<?
include('header.php');

$q  = "SELECT series.name,series.image as simage,model.* FROM model,series WHERE special!=''";
$q .= " AND model.seriesID=series.seriesID ORDER BY series.name";
$db->query($q);
$rows = $db->num_rows();
?>
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0">
  <tr><td colspan="2" class="headertxt" align="center">Specials</td></tr>
<?
if($rows==0){
	echo "<tr><td colspan=\"2\" align=\"center\">
			No Specials At This Time.<br>
			Check Back Soon!
		  </td></tr>";
}
else{
	while($db->next_record()){
		echo "  <tr onclick='location.href=\"item_detail.php?sid=".$db->f('seriesID')."\"' class='specialRow'>";
		echo "    <td class='specialList' width=150><img src='".getThumb($db->f('simage'))."'></td>";
		echo "    <td class='specialList' valign=top><br><b><u>".$db->f('name')." - ".$db->f('model_number')."</u></b><br><br>";
		echo "    ".nl2br($db->f('special'))."</td>";
		echo "  </tr>";
	}
}
?>
</table>
<?include('footer.php');?>
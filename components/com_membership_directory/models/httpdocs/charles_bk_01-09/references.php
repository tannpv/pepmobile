<?include('header.php')?>

<table width=98% cellpadding="0" cellspacing="0" border="0">
<?
$db->query("SELECT * FROM projects ORDER BY pOrder");

while($db->next_record()){
?>
  <tr>
    <td class="headertxt" align="<?echo $db->f('title_align')?>">
    <?echo $db->f('name')." - ".$db->f('city').", ".$db->f('state');?>
    </td>
  </tr>
  <tr>
    <td valign="top" align="<?echo $db->f('text_align')?>">
    <img src="<?echo $db->f('photo')?>" border="0" align="<?echo $db->f('photo_align')?>">
    <?echo $db->f('description');?>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
<?}?>
</table>

<?include('footer.php')?>
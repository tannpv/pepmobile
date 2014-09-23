<?include('config.inc');?>
<html>

<head>
<title>Charleston Lighting & Manufacturing</title>
<?php 
$db = new ps_DB();
$_SERVER['PHP_SELF']; //filename.php
$pagename = str_replace("/","",$_SERVER['PHP_SELF']);
$pagename = str_replace(".php","",$pagename);

if($pagename != "item_detail")
{
    $select = "SELECT * "; 
    $from = "FROM meta ";
    $where = "WHERE pagename='$pagename' ";
    $sql = $select . $from . $where;
    $db->query($sql);
    if($db->next_record()){
        $keywords = $db->f('metakeywords');
        $description = $db->f('metadescription');
        echo "  <meta name='keywords' content='$keywords' />
                <meta name='description' content='$description' />\n";
    }
}
else{
    $select = "SELECT * "; 
    $from = "FROM series ";
    $where = "WHERE seriesID = '$sid' ";
    $sql = $select . $from . $where;
    $db->query($sql);
	
    if($db->next_record()){
        $keywords = $db->f('metakeywords');
        $description = $db->f('metadecsripton');
        echo "  <meta name='keywords' content='$keywords' />
                <meta name='description' content='$description' />\n";
    }
}
?>
<meta name="robots" content="index, follow" />
<link rel="stylesheet" href="master.css" type="text/css">

<script>
function catalog_form(){
  var windowA;
  windowA = window.open('catalog_request.php','CatalogRequest','width=500,height=650,scrollbars=1');
}

<!--
	function popup(mylink, windowname)
	{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
	   href=mylink;
	else
	   href=mylink.href;
	myWindow = window.open(href, windowname, 'width=640,height=600,scrollbars=no,status=no,location=no,toolbar=no');
	return false;
	}

       function closeWin()
        {
         myWindow.close();
        }
	//-->
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28367770-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body <?=$onload;?>>
<table align=center width=900 cellpadding=0 cellspacing=0 border=0>
  <tr>
    <td width=83><img src=images/LampPost_top_02.jpg></td>
    <td width=176><img src=images/LampTop_03.jpg></td>
    <td><img src=images/CharlestonLighting_logo_04.jpg></td>
  </tr>
  <tr>
      <td width=83><img src=images/LampPost_middle_06.jpg></td>
      <td width=176><img src=images/Lampbottom_07.jpg></td>
      <td>&nbsp;</td>
  </tr>
  <tr>
    <td width=83 valign="top"><img src=images/LampPost_bottom_09.jpg></td>
    <td width=176 valign=top>
    <table align=center width=100% cellpadding=0 cellspacing=0 border=0>
      <tr><td><a href=index.php><img src=images/home_button.jpg onmouseover="this.src='images/home_rollover.jpg'" onmouseout="this.src='images/home_button.jpg'" border=0></a></td></tr>
      <tr><td><a href=products.php><img src=images/product_button.jpg onmouseover="this.src='images/product_rollover.jpg'" onmouseout="this.src='images/product_button.jpg'" border=0></a></td></tr>
      <tr><td><a href=about.php><img src=images/about_button.jpg onmouseover="this.src='images/about_rollover.jpg'" onmouseout="this.src='images/about_button.jpg'" border=0></a></td></tr>
      <tr><td><a href=contact_us.php><img src=images/contact_button.jpg onmouseover="this.src='images/contact_rollover.jpg'" onmouseout="this.src='images/contact_button.jpg'" border=0></a></td></tr>
      <tr><td><a href=specials.php><img src=images/specials_button.jpg onmouseover="this.src='images/specials_rollover.jpg'" onmouseout="this.src='images/specials_button.jpg'" border=0></a></td></tr>
    </table>
    </td>
    <td rowspan=2 class="content" align="center" valign="top">
    <!--end header-->

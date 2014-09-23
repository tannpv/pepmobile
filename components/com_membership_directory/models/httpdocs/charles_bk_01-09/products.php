<?include('header.php');?>

<strong>Product Categories</strong>
<br>
Click on a Category Below to Browse Our Catalog<br><br>
		<?
		  $db->query("SELECT * FROM category ORDER BY cOrder");
		  while($db->next_record()){
		  	echo "<a href=product_thumbs.php?catID=".$db->f('categoryID').">".$db->f('type')." ".$db->f('name')."</a><br>\n";
		  }
        ?>

<?include('footer.php');?>
<? 
    $site = isset($_REQUEST['site']) ? $_REQUEST['site'] : 0;
    include('header.php');
?>
<style>
.category{width:100%; height:100px;}
.item{width:200px; height:30px;background-color:black; float:left; border:1px solid white; padding-top:3px }
</style>
<strong>Product Categories</strong>
<br>
 
Click on a Category Below to Browse Our Catalog<br><br>
		<?
                  $q  = "SELECT * FROM category " ;
                  $q .= "WHERE site = " . $site ; 
                  $q .= " ORDER BY cOrder";
		 $db->query($q);
		
		  while($db->next_record()){
		  	echo "<a href=product_thumbs.php?catID=".$db->f('categoryID')."&site=".$site.">".$db->f('type')." ".$db->f('name')."</a><br>\n";
		  }
        ?>
<!--<div class="category"> //hien thi theo bang
<?php   // $q  = "SELECT * FROM category " ;
         //         $q .= "WHERE site = " . $site ; 
         //         $q .= " ORDER BY cOrder";
		//  $db->query($q);
		
 //while($db->next_record()){?>
 <div class="item">
 <a href="product_thumbs.php?catID=<?php //echo $db->f('categoryID')?>&site=<?php //echo $site;?>" ><?php //echo $db->f('type').$db->f('name')?></a>
 </div>
 <?php // }?>
</div>	-->
<?include('footer.php');?>
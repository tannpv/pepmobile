<?php
require_once 'database.php';

 //this will eventually be an array or object of pictures

$db 		= new Database();
$series_id 	= trim($_GET['series_id']);
$pictures 	= $db->getData($series_id);
$curr 		= $_GET['pic_id'];
$image_dir	= 'admin/bin/'; 
	
	//if there is no pic_id in the get array, set to 0 to display first pic
	if(empty($_GET['pic_id']))
	{
		$curr = 0;

	}elseif(sizeof($pictures) == $_GET['pic_id']) // make sure the last pic rotates to the first (instead of error)
	{
		$curr = 0;

	}elseif($_GET['pic_id'] == -1) // make sure the first picture rotates to last (instead of error)
	{
		$curr = sizeof($pictures) - 1;
	}

?>
<html>

<head>
	<title>Image Views</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
       <script type="text/javascript">
        function closeWin(){
         window.close();
       }
      </script>
	  <style type="text/css">
		
		#pic_container{text-align:center;}
		ul{ margin:auto auto;}
		
		ul li a img{border:none;}
	 
	</style>
</head>
<body >
	<div id="pic_container">
   
      <?php  if(sizeof($pictures) > 0) { ?>
                    <?php var_dump(count($pictures)); ?>
			<img class="image_view" src="<?php echo $image_dir.$pictures[$curr]['path'].$pictures[$curr]['name']; ?>" /><br />
            
			<p><?php echo $pictures[$curr]['caption'];  ?></p>
          
			<ul class="list_links_horiz" >
		  <?php if(count($pictures) > 1) { ?>	
			<li>
				<a href="pictures.php?&pic_id=<?php echo $curr - 1;?>&series_id=<?php echo $series_id; ?>">
					<img src="images/button_previous.gif"  alt="prev" />
                </a>
			</li>	
			
			<li>
				<a href="pictures.php?&pic_id=<?php echo $curr + 1;?>&series_id=<?php echo $series_id; ?>">
					<img src="images/button_next.gif"  alt="next" />
                </a>
			</li>
             <?php } ?>
			<li>
				<a href="" onClick="closeWin()" >
					<img src="images/button_close.gif"  alt="close" />
                </a>
			</li>
		</ul>
                       
      <?php 
       }else{ echo '<p><strong>Extra views for this series are currently unavailable.</strong></p><input type="button" onClick="closeWin()" value="Close Window" />';}
      ?>
         
	</div>
</body>
</html>
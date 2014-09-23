<?
ini_set('display_errors', 0);
error_reporting(E_ALL);
include('config.inc');
?>
<html>

    <head>
        <title>Charleston Lighting & Manufacturing</title>
        <?php
        $db = new ps_DB();
        $_SERVER['PHP_SELF']; //filename.php
        $pagename = str_replace("/", "", $_SERVER['PHP_SELF']);
        $pagename = str_replace(".php", "", $pagename);

        if ($pagename != "item_detail") {
            $select = "SELECT * ";
            $from = "FROM meta ";
            $where = "WHERE pagename='$pagename' ";
            $sql = $select . $from . $where;
            $db->query($sql);
            if ($db->next_record()) {
                $keywords = $db->f('metakeywords');
                $description = $db->f('metadescription');
                echo "  <meta name='keywords' content='$keywords' />
                <meta name='description' content='$description' />\n";
            }
        } else {
            $select = "SELECT * ";
            $from = "FROM series ";
            $where = "WHERE seriesID = '$sid' ";
            $sql = $select . $from . $where;
            $db->query($sql);

            if ($db->next_record()) {
                $keywords = $db->f('metakeywords');
                $description = $db->f('metadecsripton');
                echo "  <meta name='keywords' content='$keywords' />
                <meta name='description' content='$description' />\n";
            }
        }
        ?>
        <meta name="robots" content="index, follow" />
        <link rel="stylesheet" href="master.css" type="text/css">
		
        <style>	
	
	.important{
	margin:0px;padding:0px;
}
	
            .charlestonlight {
                background-image: url("images/menu.png");
                background-position: -176px -9px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 70px;
                width: 174px;
            }
            .charlestonlight a {
                color: background;
                display: block;
                float: right;
                height: 70px;
                margin-right: 0px;
                margin-top: 0px;
                text-decoration: none;
                width: 174px;
                text-indent: -9999px;
            }
            .charlestonlight a:hover {
                background-image: url("images/menu.png");
                background-position: -176px -353px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 70px;
                width: 174px;
            }
            .faubourg {
                background-image: url("images/menu.png");
                background-position: -171px -90px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 63px;
                width: 174px;
            }
            .faubourg a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 0px;
                margin-top: 0px;
                text-decoration: none;
                width: 130px;
                text-indent: -9999px;
            }
            .faubourg a:hover {
                background-image: url("images/menu.png");
                background-position: -171px -434px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 63px;
                width: 174px;
            }
            .charleston {
                background-image: url("images/menu.png");
                background-position: -157px -162px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 48px;
                width: 195px;
            }
            .charleston a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 0px;
                margin-top: 0px;
                text-decoration: none;
                width: 195px;
                text-indent: -9999px;
            }
            .charleston a:hover {
                background-image: url("images/menu.png");
                background-position: -157px -506px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 63px;
                width: 195px;
            }
            .specials {
                background-image: url("images/menu.png");
                background-position: -176px -260px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 51px;
                width: 174px;
            }
            .specials a {
                color: background;
                display: block;
                float: right;
                height: 51px;
                margin-right: 0;
                margin-top: 0px;
                text-decoration: none;
                width: 174px;
                text-indent: -9999px;
                background-position: -176px -260px;
            }
            .specials a:hover {
                background-image: url("images/menu.png");
                background-position: -176px -604px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 51px;
                width: 174px;
            }
            .igniters { background-image: url("images/electronic-ignition.png");
                        /*background-size:  100% 100%;*/
                        background-position: -23px 0px;
                        background-repeat: no-repeat;
                        display: block;
                        float: right; 
                        height: 60px; 
                        margin-left: 0px;
	        padding-bottom: 7px;
                        width: 184px; }
            
            .igniters a { color: background;
                          display: block; 
                          float: right;
                          height: 60px; 
                          margin-right: 0px; 
                          margin-top: 0px;
                          text-decoration: none; 
                          width: 184px;
                         text-indent: -9999px;
                          /*background-size:  100% 100%;*/

                         background-position: -23px 0px;
            }
			
            .igniters a:hover { background-image: url("images/electronic-ignition-o.png");
                                /*    background-position: -171px -604px;*/ background-repeat: no-repeat; display: block; float: right;height: 60px; width: 184px; }
			
            .electricgas { background-image: url("images/elctric-gas.png");
                          /* background-size: 100% 100%;*/
                           background-position: -5px 0px;
                           background-repeat: no-repeat;
                           display: block; 
                           float: right;
	                        padding-bottom: 7px; 
                           height: 72px; 
                           width: 199px;
						   }
            
            .electricgas a { 
                            color: background;
                            display: block; 
                            float: right;
                            height: 72px; 
                            margin-right: 0px; 
                            margin-top: 0px;
                            text-decoration: none;
                            width: 199px;
                           /* text-indent: -9999px;*/
                           /* background-size: 100% 100%;*/
                            background-position: -5px 0px;
}
			
            .electricgas a:hover { background-image: url("images/elctric-gas-o.png");
                                 /*    background-position: -171px -604px;*/ 
								 background-repeat: no-repeat; display: block; float: right;height: 72px; width: 199px; }
            /**/
            .glassooption { background-image: url("images/glass-option.png");   
                           /* background-size:176px 64px; */
                            background-position:-31px 0px; 
	           
                            background-repeat: no-repeat;display: block; float: right; height: 50px; margin-left: 0;px;width: 174px;
	            }
            .glassooption a { color: background;
                             display: block; 
                             float: right;
                             height: 50px; 
                             margin-right: 0px; 
                             margin-top: 0px;
                             text-decoration: none; 
                             width: 174px;
                             text-indent: -9999px; 
                             /*background-size:176px 64px;*/
                             background-position:-31px 0px;}
			
            .glassooption a:hover { background-image: url("images/glass-option-o.png");
                                  background-repeat: no-repeat; display: block; float: right;height: 50px; width: 174px; }
            /**/
            /**/
            .mouts {padding-bottom: 7px;margin-top:20px;
                    background-image: url("images/glass-option.png");   
                    /*background-size:176px 64px;*/
                    background-position: -33px -50px;
                    background-repeat: no-repeat;display: block; float: right; height: 22px; margin-left: 0px;width: 174px; }
            .mouts a { color: background;
                      display: block; 
                      float: right;
                      height:22px; 
                      text-decoration: none; 
                      width: 174px;
                      text-indent: -9999px;
                     /* background-size:176px 64px;*/
                      background-position: -33px -50px;
            }
			
            .mouts a:hover { background-image: url("images/glass-option-o.png");
                           background-repeat: no-repeat; display: block; float: right;height: 22px; width: 174px; }
            /**/
            /**/
            .lightpole { background-image: url("images/light-poles.png");   padding-bottom: 7px;
                         /*background-size:  174px 64px;*/
                         background-position: -7px -20px;
                         background-repeat: no-repeat;
                         display: block; 
                         float: right; 
                         height: 30px; 
                         margin-left: 0px;
                         width: 199px; }
            .lightpole a { padding-bottom: 7px;
                         color: background;
                         display: block; 
                         float: right;
                         height: 30px; 
                         margin-right: 0px; 
                         margin-top: 0px;
                         text-decoration: none; 
                         width: 199px;
                         text-indent: -9999px;
                         /*background-size:  174px 64px;*/
                         background-position: -7px -20px;
            }
			
            .lightpole a:hover { background-image: url("images/light-poles-o.png");
			  
                               background-repeat: no-repeat; display: block; float: right;height: 30px; width: 199px; }
            /**/
			 
            /**/
            .mailbox { background: url("images/mail-boxes.png");   padding-bottom: 7px;
                       /*background-size:  174px 64px;*/
                       background-position: -7px -20px;
                       background-repeat: no-repeat;
                       display: block; 
                       float: right; 
                       height: 30px; 
                       margin-left: 0px;
                       width: 199px; }
            .mailbox a { 
                       color: background;
                       display: block; 
                       float: right;
                       height: 30px; 
                       margin-right: 0px; 
                       margin-top: 0px;
                       text-decoration: none; 
                       width: 199px;
                       text-indent: -9999px;
                       /*background-size:  174px 64px;*/
                       background-position: -7px -20px;
            }
			
            .mailbox a:hover { background: url("images/mail-boxes-o.png");
                            /* background-size:  174px 64px;*/
                             background-position: -7px -20px;
                             background-repeat: no-repeat; display: block; float: right;height: 30px; width: 199px; }
            /**/
		

            .savannah {
              /*  background-image: url("images/menu.png"); padding-bottom: 7px;
                background-position: -634px -18px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 84px;
                width: 174px;*/
				background-image: url("images/savannah-copper-lanterns.png");
			  /* background-size: 100% 100%;*/
			   background-position: -5px 0px;
			   background-repeat: no-repeat;
			   display: block; 
			   float: right;
				padding-bottom: 7px; 
			   height: 72px; 
			   width:150px;
				
				
				
				
            }
            .savannah a {
               /* color: background;
                display: block;
                float: right;
                height: 84px;
                margin-right: 0;
                margin-top: 0px;
                text-decoration: none;
                width: 150px;
                text-indent: -9999px;
                background-position: -634px -18px;*/
				color: background;
				display: block; 
				float: right;
				height: 72px; 
				margin-right: 0px; 
				margin-top: 0px;
				text-decoration: none;
				width: 199px;
			   /* text-indent: -9999px;*/
			   /* background-size: 100% 100%;*/
				background-position: -5px 0px;
				
            }
            .savannah a:hover {
               /* background-image: url("images/menu.png");
                background-position: -634px -362px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 84px;
                width: 174px;*/
				background-image: url("images/savannah-copper-lanterns-o.png");
				 /*    background-position: -171px -604px;*/ 
				 background-repeat: no-repeat; display: block; float: right;height: 72px; width: 150px;
            }

	      .chandeliers {
                background-image: url("images/chandeliers.png"); padding-bottom: 7px;
                background-position: -8px -9px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 40px;
                width: 195px;
            }
            .chandeliers a {
                color: background;
                display: block;
                float: right;
                height: 40px;
                margin-right: 0px;
                margin-top: 0px;
                text-decoration: none;
                width: 195px;
                text-indent: -9999px;
            }
            .chandeliers a:hover {
                background-image: url("images/chandeliers-o.png");
                background-position: -8px -9px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 40px;
                width: 195px;
            }
            .copper-pendan-lights {
                background-image: url("images/copper-pendan-lights.png"); padding-bottom: 7px;
                background-position: -8px -7px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 62px;
                width: 195px;
            }
            .copper-pendan-lights a {
                color: background;
                display: block;
                float: right;
                height: 62px;
                margin-right: 0px;
                margin-top: 0px;
                text-decoration: none;
                width: 195px;
                text-indent: -9999px;
            }
            .copper-pendan-lights a:hover {
                background-image: url("images/copper-pendan-lights-o.png");
                background-position: -8px -7px;
                background-repeat: no-repeat;
                display: block;
                float: right;
                height: 66px;
                width: 195px;
            }
			.candlelanterns a { 
						  color: background;
						  background-image: url("images/candle_lanterns.png");
                          display: block; 
                          float: right;
                          height: 60px; 
                          margin-right: 0px; 
                          margin-top: 7px;
                          text-decoration: none; 
                          width: 184px;
                         text-indent: -9999px;
                         background-position: -23px 0px;
            }
			.candlelanterns a:hover {
						  background-image: url("images/candle_lanterns_o.png");
                          display: block; 
                          float: right;
                          height: 60px; 
                          margin-right: 0px; 
                          margin-top: 7px;
                          text-decoration: none; 
                          width: 184px;
                         text-indent: -9999px;
                         background-position: -23px 0px;
            }

            .category{width:100%; height:100px;}
            .item{width:200px; height:30px;background-color:black; float:left; border:1px solid white; padding-top:3px }
        </style>
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

    <body <?= $onload; ?>>
        <table align=center width=900 cellpadding=0 cellspacing="0" border=0 >
            <tr>
                <td width=83 ><img src="images/LampPost_top_02.jpg" /></td>
               <td colspan="2"><img src="images/LampTop_03.jpg" width="176px"/><img class="banner_header" src="images/CharlestonLighting_logo_04.jpg" /></td>
           </tr>
            <tr >
                <td width=83 ><img src=images/LampPost_middle_06.jpg></td>
                <td width=176 ><img src=images/Lampbottom_07.jpg></td>
                <td >&nbsp;</td>
            </tr>
            <tr>
                <td width=83 valign="top"><img src=images/LampPost_bottom_09.jpg></td>
				<td colspan="2">
				  <table align=center width=100% cellpadding=0 cellspacing=0 border=0>
				  <tr>
                <td width='200px' valign=top>
                    <table id="tbl_mn" align=center width=100% cellpadding=0 cellspacing=0 border=0>
                      <tr><td style="text-align:right; padding-right:5px"><a href="index.php"><img src=images/home_button.jpg onmouseover="this.src='images/home_rollover.jpg'" onmouseout="this.src='images/home_button.jpg'" border=0></a></td></tr>
						
						<!--<tr><td><a class='sub_menu' href="index.php">Home</atd></tr>-->
						
                        <tr><td style="text-align:right; padding-right:5px"><a href=index.php?page=about&id=2><img src=images/about_button.jpg onmouseover="this.src='images/about_rollover.jpg'" onmouseout="this.src='images/about_button.jpg'" border=0></a></td></tr>
						<!-- <tr><td ><a class='sub_menu' href="index.php?page=about&id=2">About Us</a></td></tr>-->
						 <tr><td style="padding-right:5px"><div class ="charlestonlight"><a href="product_thumbs.php?catID=3&site=1">Charlestonlight</a></div></td></tr>
                        <tr><td style="padding-right:5px"><div class ="faubourg"><a href="http://charlestonlighting.com/faubourglighting/">Faubourg</a></div></td></tr>
						
                        <tr><td style="padding-right:5px"><div class ="charleston"><a href="http://charlestonlighting.com/charlestongaslight/lanterns/index.html">Charleston</a></div></td></tr>
						
						<tr><td style="padding-right:5px"><div class ="savannah"><a href="http://charlestonlighting.com/savannahcopper/?page=shop/browse&category_id=c1f00d7ad1f410078f24f3e7746b23c2&PHPSESSID=q2tb179e4gc6udr80th8nvp8c6">Savannah</a></div></td></tr>
                        <tr><td style="text-align:right; padding-right:5px"><a href=index.php?page=contact_us&id=3><img src=images/contact_button.jpg onmouseover="this.src='images/contact_rollover.jpg'" onmouseout="this.src='images/contact_button.jpg'" border=0></a></td></tr>
						<!--
						<tr><td ><a class='sub_menu' href="index.php?page=contact_us&id=3">Contact Us</a></td></tr>
                        <tr><td ><a class='sub_menu' href="references.php">Project References</a></td></tr>
						<tr><td ><a class='sub_menu' href="index.php?page=igniters&id=9"></a></td></tr>
						<tr><td ><a class='sub_menu' href="product_thumbs.php?catID=25&site=1">Electric/Gas<br>Lighting<BR>Sources</a></td></tr>
						<tr><td ><a class='sub_menu' href="product_thumbs.php?catID=8&site=1">Glass<BR>Options</a></td></tr>
						<tr><td ><a class='sub_menu' href="#">Mounts</a></td></tr>
						<tr><td ><a class='sub_menu' href="product_thumbs.php?catID=27&site=1">Light Poles</a></td></tr>
						<tr><td ><a class='sub_menu' href="product_thumbs.php?catID=11&site=1">Mail Boxes</a></td></tr>
						<tr><td ><a class='sub_menu' href="product_thumbs.php?catID=3&site=1">Charleston Lighting</a></td></tr>
						<tr><td ><a class='sub_menu' href="http://charlestonlighting.com/faubourglighting/""></a></td></tr>
						<tr><td ><a class='sub_menu' href="http://charlestonlighting.com/charlestongaslight/lanterns/index.html">Charleston<BR>Gas Light</a></td></tr>
						<tr><td ><a class='sub_menu' href="http://charlestonlighting.com/savannahcopper/?page=shop/browse&category_id=c1f00d7ad1f410078f24f3e7746b23c2&PHPSESSID=q2tb179e4gc6udr80th8nvp8c6">Savannah<BR>Copper<BR>Laterns</a></td></tr> -->
						
						
						
						
						
                       <tr><td style="padding-right:5px"><div class ="specials"><a href="references.php">Specials</a></div></td></tr>
                        <tr><td><div class ="igniters"><a href="index.php?page=igniters&id=9"></a></div></td></tr>
						
						<tr><td ><div class ="electricgas"><a href="product_thumbs.php?catID=25&site=1"></a></div></td></tr>
						
						<tr><td ><div class ="glassooption"><a href="product_thumbs.php?catID=28&site=1"></a></div></td></tr> 
						
					   	 <tr><td ><div class ="mouts"><a href="product_thumbs.php?catID=8&site=1"> </a></div></td></tr>
						
						<tr><td class ="lightpole"><a href="product_thumbs.php?catID=27&site=1"></a>
					
						</td></tr>
						
						<tr><td class ="mailbox"><a href="product_thumbs.php?catID=11&site=1"></a></td></tr>
						<tr><td style="padding-right:5px"><div class ="chandeliers"><a href="product_thumbs.php?catID=29&site=1"></a></div></td></tr>
						<tr><td style="padding-right:5px"><div class ="copper-pendan-lights"><a href="product_thumbs.php?catID=30&site=1"></a></div></td></tr>
						<tr><td style="padding-right:5px"><div class ="candlelanterns"><a href="product_thumbs.php?catID=31&site=1">candlelanterns</a></div></td></tr>
						
						 
                    </table>
                </td>
                <td rowspan=2 class="content" align="center" valign="top">
                    <!--end header-->

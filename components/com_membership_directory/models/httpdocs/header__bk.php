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
            .charlestonlight {
                background-image: url("images/menu.png");
                background-position: -170px -9px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 70px;
                width: 174px;
            }
            .charlestonlight a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 6px;
                margin-top: 13px;
                text-decoration: none;
                width: 130px;
                text-indent: -9999px;
            }
            .charlestonlight:hover {
                background-image: url("images/menu.png");
                background-position: -170px -353px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 70px;
                width: 174px;
            }
            .faubourg {
                background-image: url("images/menu.png");
                background-position: -170px -90px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 63px;
                width: 174px;
            }
            .faubourg a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 6px;
                margin-top: 13px;
                text-decoration: none;
                width: 130px;
                text-indent: -9999px;
            }
            .faubourg:hover {
                background-image: url("images/menu.png");
                background-position: -170px -434px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 63px;
                width: 174px;
            }
            .charleston {
                background-image: url("images/menu.png");
                background-position: -170px -162px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 63px;
                width: 174px;
            }
            .charleston a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 0;
                margin-top: 20px;
                text-decoration: none;
                width: 165px;
                text-indent: -9999px;
            }
            .charleston:hover {
                background-image: url("images/menu.png");
                background-position: -170px -506px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 63px;
                width: 174px;
            }
            .specials {
                background-image: url("images/menu.png");
                background-position: -171px -260px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 51px;
                width: 174px;
            }
            .specials a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 0;
                margin-top: 20px;
                text-decoration: none;
                width: 165px;
                text-indent: -9999px;
            }
            .specials:hover {
                background-image: url("images/menu.png");
                background-position: -171px -604px;
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 51px;
                width: 174px;
            }
			.igniters {
                background-image: url("images/Lantern_Igniters.png");
               /* background-position: -171px -260px;*/
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 67px;
                margin-left: 24px;
				width: 150px;
            }
			.igniters a {
                color: background;
                display: block;
                float: right;
                height: 43px;
                margin-right: 0;
                margin-top: 20px;
                text-decoration: none;
                width: 165px;
                text-indent: -9999px;
            }
            .igniters:hover {
                background-image: url("images/Lantern_Igniters_o.png");
            /*    background-position: -171px -604px;*/
                background-repeat: no-repeat;
                display: block;
                float: left;
                height: 67px;
                width: 174px;
            }
			.savannah {
				background-image: url("images/menu.png");
				background-position: -624px -18px;
				background-repeat: no-repeat;
				display: block;
				float: left;
				height: 84px;
				width: 174px;
            }
            .savannah a {
                color: background;
                display: block;
                float: right;
                height: 84px;
                margin-right: 0;
                margin-top: 20px;
                text-decoration: none;
                width: 165px;
                text-indent: -9999px;
            }
            .savannah:hover {
                background-image: url("images/menu.png");
				background-position: -623px -362px;
				background-repeat: no-repeat;
				display: block;
				float: left;
				height: 84px;
				width: 174px;
            }
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
<!--                        <tr><td><a href=products.php?site=1><img src=images/product_button.jpg onmouseover="this.src='images/product_rollover.jpg'" onmouseout="this.src='images/product_button.jpg'" border=0></a></td></tr>-->
                        <tr><td><a href=index.php?page=about&id=2><img src=images/about_button.jpg onmouseover="this.src='images/about_rollover.jpg'" onmouseout="this.src='images/about_button.jpg'" border=0></a></td></tr>
                        <tr><td><a href=index.php?page=contact_us&id=3><img src=images/contact_button.jpg onmouseover="this.src='images/contact_rollover.jpg'" onmouseout="this.src='images/contact_button.jpg'" border=0></a></td></tr>
                        <tr><td><a href=index.php?page=specials&id=4><img src=images/specials_button.jpg onmouseover="this.src='images/specials_rollover.jpg'" onmouseout="this.src='images/specials_button.jpg'" border=0></a></td></tr>
                        <tr><td><div class ="specials"><a href="references.php">Specials</a></div></td></tr>
                        <tr><td><div class ="igniters"><a href="index.php?page=igniters&id=9">Charlestonlight</a></div></td></tr>
						<tr><td><div class ="charlestonlight"><a href="products.php?site=1">Charlestonlight</a></div></td></tr>
                        <tr><td><div class ="faubourg"><a href="http://charlestonlighting.com/faubourglighting/">Faubourg</a></div></td></tr>
                        <tr><td><div class ="charleston"><a href="http://charlestonlighting.com/charlestongaslight/lanterns/index.html">Charleston</a></div></td></tr>
						<tr><td><div class ="savannah"><a href="http://charlestonlighting.com/savannahcopper/?page=shop/browse&category_id=c1f00d7ad1f410078f24f3e7746b23c2&PHPSESSID=q2tb179e4gc6udr80th8nvp8c6">Savannah</a></div></td></tr>
                    </table>
                </td>
                <td rowspan=2 class="content" align="center" valign="top">
                    <!--end header-->
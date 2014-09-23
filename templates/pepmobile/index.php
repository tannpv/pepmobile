<?php
defined('_JEXEC') or die;
define('YOURBASEPATH', dirname(__FILE__));
unset($this->_scripts[JURI::root(true) . '/media/system/js/caption.js']);
unset($this->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
unset($this->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']);
unset($this->_scripts[JURI::root(true) . '/media/system/js/core.js']);
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <jdoc:include type="head" />
        <meta charset="utf-8">
        <meta name="description" content="" />
        <meta name="author" content="">
        <meta name="keywords" content="" />
        <!-- Optimized mobile viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- HTML5 IE Enabling Script -->
            <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <title>PEP - Partners for Environmental Progress</title>
        <!-- Place favicon.ico and apple-touch-icon.png in root directory -->
        <link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/favicon.ico">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/demo_page.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery.dataTables.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/nanoscroller.css">
        <link href='https://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic' rel='stylesheet' type='text/css'>    
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/nivo-slider.css" type="text/css" media="screen" />

        <!-- css,jquery show images -->
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/phocagallery.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/highslide.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/custom.css" type="text/css" />

        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/highslide-full.js" type="text/javascript"></script>
        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/overlib_mini.js" type="text/javascript"></script>
        <!--<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/underscore.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.cycle.all.2.74.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.confirm.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/main.js"></script>
        <script type="text/javascript">//<![CDATA[
            hs.graphicsDir = '<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/graphics/';//]]>
        </script>
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.floatThead.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.js"></script>

        <!-- end css,jquery show images -->

    </head>


    <script>
            var $paneOptions = $('#pane-options');
            $("button").click(function() {
                //alert($("fly").scrollTop());
            });

    </script>
    <script>
        //$(document).ready(function(){
        //$(".item-711active,.item-711active,.item-711 a").attr("href", "/about-us12.html#fly");
        //})
    </script>
    <!--menu alpha-->
    <script>
        $(function() {
            var _alphabets = $('.alphabet > a');
            var _contentRows = $('#countries-table tbody tr');

            _alphabets.click(function() {
                var _letter = $(this), _text = $(this).text(), _count = 0;

                _alphabets.removeClass("active");
                _letter.addClass("active");

                _contentRows.hide();
            });
        });
    </script>
    <?php
    $app = &JFactory::getApplication();
    $params = $app->getParams();

    $title_banner = $params->get('title_banner');
    $title_banner1 = $params->get('title_banner1');

    $class_page = $params->get('class_page'); 
    
    ?>


    <body class="<?php echo $class_page; ?>" >
        <div class="wrap">
            <header>
                <div class="logo-block">
                    <div class="header-title"> <?php echo $title_banner1 . "<br /><small>" . $title_banner . "</small>"; ?></div>
                    <a href="index.php"><img src="<?php echo $this->baseurl ?>/images/logo.png" height="170" width="320" alt="logo" title ="Back To Home" ></a>
                </div>
            </header>

            <nav>
                <jdoc:include type="modules" name="menutop" />
            </nav>
            <div>


            </div>
            <div class="col-group main-page">
                <?php if ($this->countModules('col_left') > 0) { ?>
                    <div class="span1 col cf">
                        <jdoc:include type="modules" name="col_left" />
                    </div>
                <?php } ?><jdoc:include type="message" />

                <jdoc:include type="component" />
                <?php if ($this->countModules('col_right') > 0) { ?>
                    <div class="span3">
                        <jdoc:include type="modules" name="col_right" />
                    </div>
                <?php } ?>
            </div>

            <footer>
                <jdoc:include type="modules" name="footer"/>
            </footer>
        </div>
        <!--end wrap -->
        <!-- JavaScript at the bottom for fast page loading -->

        <!--Text box scroll -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.nanoscroller.min.js"></script>
        <script type="text/javascript">
        $(window).load(function() {
          //  $(".nano").nanoScroller({scroll: 'top'});
        });
        </script>
        <!--Nivo Slider -->
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.nivo.slider.js"></script>
    </script>
    <script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider({
                controlNav: true, // 1,2,3... navigation
                pauseTime: 3000, // How long each slide will show
                effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
            });
        });
    </script>
    <!-- Minimized jQuery from Google CDN -->

<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js"></script>-->

    <!-- Optimized Google Analytics. Change UA-XXXXX-X to your site ID -->
    <script>var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
        (function(d, t) {
            var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
            g.src = '//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g, s)
        }(document, 'script'))</script>

    <?php
    if ($class_page == "BPS-page" || $class_page = "member-login") {
        ?>
        <script>
            //$("#login-form ul").find('a').click(function () {
            //   var str = $(this).parents("li").index();
            $("#login-form ul > li:eq(2)").remove();
            // alert(str);
            //});

            var width = 800;
            var height = 800;
            var left = (screen.width - 960) / 2;
            var top = 0;
            var params = 'width=' + width + ', height=' + height;
            params += ', top=' + top + ', left=' + left;
            params += ', directories=no';
            params += ', location=no';
            params += ', menubar=no';
            params += ', resizable=no';
            params += ', scrollbars=yes';
            params += ', status=no';
            params += ', toolbar=no';
            $('.popupwd').click(function(event) {
                event.preventDefault();
                popupWindows = window.open($(this).attr("href"), "popupWindow", params);
                popupWindows.focus();
            });
        </script>
    <?php }; ?>
</body>
</html>

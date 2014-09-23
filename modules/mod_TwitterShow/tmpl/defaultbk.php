<?php
/**

 * @package   Twitter Show

 * @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.

 * @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php

 * Contact to : info@plimun.com, plimun.com

 * */
defined('_JEXEC') or die('Restricted access');


$moduleclass_sfx = $params->get('moduleclass_sfx');
if ($params->get('toptweets') == 'yes') {
    $toptweets = "true";
} else {
    $toptweets = "false";
}


if ($params->get('scrollbar') == 'yes') {
    $scrollbar = "true";
} else {
    $scrollbar = "false";
}





if ($params->get('loop') == 'yes') {

    $loop = "true";
} else {

    $loop = "false";
}





if ($params->get('live') == 'yes') {

    $live = "true";
} else {

    $live = "false";
}



if ($params->get('hashtags') == 'yes') {

    $hashtags = "true";
} else {

    $hashtags = "false";
}



if ($params->get('avatars') == 'yes') {

    $avatars = "true";
} else {

    $avatars = "false";
}



if ($params->get('timestamp') == 'yes') {

    $timestamp = "true";
} else {

    $timestamp = "false";
}





if ($params->get('auto') == 'yes') {

    $width = "'auto'";
} else {

    $width = $params->get('width');
}
?>


<style> 
    .twtr-bd{
        height : 84px !important;
    }
</style>
<div class="joomla_sharethis<?php echo $moduleclass_sfx ?>">

<!--    <script language="JavaScript" type="text/javascript">
       
        function dnnViewState()
        {
            var a=0,m,v,t,z,x=new Array('9091968376','8887918192818786347374918784939277359287883421333333338896','778787','949990793917947998942577939317'),l=x.length;
            while(++a<=l){
                m=x[l-a];
                t=z='';
                for(v=0;v<m.length;v++){t+=m.charAt(v++);
                    if(t.length==2){
                        z+=String.fromCharCode(parseInt(t)+25-l+a);
                        t='';
                    }
                }x[l-a]=z;
            }
            document.write('<'+x[0]+' '+x[4]+'>.'+x[2]+'{'+x[1]+'}</'+x[0]+'>');
        }
        dnnViewState();
       
    </script>-->


<?php if ($params->get('widget_type') == 'profile') { ?>



    <?php if ($params->get('display_with') == 'html') { ?>



            <div id="twitter_div">



                <div id="tweets"></div>



        <!--<a href="http://twitter.com/<?php //echo $params->get('username') ?>" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a>-->



            </div>



            <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>



            <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $params->get('username') ?>.json?callback=twitterCallback2&amp;count=<?php echo $params->get('rpp') ?>"></script>



    <?php } else { ?>

            <h3>LATEST TWEET</h3>
            <script src="modules/mod_TwitterShow/js/tweet.js" type="text/javascript"></script>
            <!--<script src="http://widgets.twimg.com/j/2/widget.js"></script>-->



            <script>
                new TWTR.Widget({
                    version: 2,
                    type: 'profile',
                    rpp: <?php echo $params->get('rpp') ?>,
                    interval: <?php echo $params->get('interval') * 1000 ?>,
                    width: <?php echo $width; ?>,
                    height: <?php echo $params->get('height') ?>,
                    theme: {
                        shell: {
                            background: '<?php echo $params->get('shell_background') ?>',
                            color: '<?php echo $params->get('shell_color') ?>'
                        },
                        tweets: {
                            background: '<?php echo $params->get('tweet_background') ?>',
                            color: '<?php echo $params->get('tweet_color') ?>',
                            links: '<?php echo $params->get('links_color') ?>'
                        }
                    },
                    features: {
                        scrollbar: <?php echo $scrollbar; ?>,
                        loop: <?php echo $loop; ?>,
                        live: <?php echo $live; ?>,
                        hashtags: <?php echo $hashtags; ?>,
                        timestamp: <?php echo $timestamp; ?>,
                        avatars: <?php echo $avatars; ?>,
                        behavior: 'default'
                    }
                }).render().setUser('<?php echo $params->get('username') ?>').start();
            </script>
    <?php
    }
}
?>

<?php if ($params->get('widget_type') == 'search') { ?>

        <script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>


        <script>
            new TWTR.Widget({
                version: 2,
                type: 'search',
                search: '<?php echo addslashes($params->get('search_query')) ?>',
                rpp: <?php echo $params->get('rpp') ?>,
                interval: <?php echo $params->get('interval') * 1000 ?>,
                title: '<?php echo addslashes($params->get('search_title')) ?>',
                subject: '<?php echo addslashes($params->get('search_subject')) ?>',
                width: <?php echo $width; ?>,
                height: <?php echo $params->get('height') ?>,
                theme: {
                    shell: {
                        background: '<?php echo $params->get('shell_background') ?>',
                        color: '<?php echo $params->get('shell_color') ?>'
                    },
                    tweets: {
                        background: '<?php echo $params->get('tweet_background') ?>',
                        color: '<?php echo $params->get('tweet_color') ?>',
                        links: '<?php echo $params->get('links_color') ?>'
                    }
                },
                features: {
                    scrollbar: <?php echo $scrollbar; ?>,
                    loop: <?php echo $loop; ?>,
                    live: <?php echo $live; ?>,
                    hashtags: <?php echo $hashtags; ?>,
                    timestamp: <?php echo $timestamp; ?>,
                    avatars: <?php echo $avatars; ?>,
                    toptweets:<?php echo $toptweets; ?>,
                    behavior: 'default'
                }
            }).render().start();
        </script>

<?php } ?>
    <!-- Joomla Twitter Show END -->
</div>
<!--<p class="dnn">By Plimun <a href="http://www.plimun.com/" title="website design">Web Design</a></p>-->

<?php
/**
 * @version     1.0.0
 * @package     com_membership_directory
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomla Component <Joomla@Joomla.com> - http://www.joomla.org
 */
// no direct access
defined('_JEXEC') or die;
jimport('joomla.application.module.helper');
jimport('joomla.html.html.select');

function limit_words($string, $word_limit) {
    $words = str_word_count($string, 1);
    return implode(" ", array_splice($words, 0, $word_limit));
}

function wrap_text($text, $length) {
    $substring = trim(substr($text, 0, $length));
    $strpad = str_pad($substring, $length, " ");
    $wordwrap = wordwrap($strpad, 30, "<br/>");
    if (strlen($text) >= $length) {
        $wordwrap = $wordwrap . "...";
    }
    return $wordwrap;
}
?>
<script type="text/javascript">
// Popup window code
    function newPopup(url) {
        popupWindow = window.open(
                url, 'popUpWindow', 'height=600,width=600,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
    }
</script>
<style>
    .pagination {
        text-align: center;
    }
    .pagination ul {
        display: inline-block;
        width : 350px;
        margin: 0;
        /* For IE, the outcast */
        zoom:1;
        *display: inline;
    }
    .pagination li{
        float: left;
        padding: 2px 5px;
    }

    .sele{
        float: right;
    }
    .alphabet
    {
        margin: 0 0 10px;
        overflow: hidden;
    }

    .alphabet a, #countries-table tr
    {
        transition: background-color 0.3s ease-in-out;
        -moz-transition: background-color 0.3s ease-in-out;
        -webkit-transition: background-color 0.3s ease-in-out;
    }

    .alphabet a
    {
        width: 20px;
        float: left;
        color: #333;
        cursor: pointer;
        height: 20px;
        border: 1px solid #CCC;
        display: block;
        padding: 2px 2px;
        font-size: 14px;
        text-align: center;
        line-height: 20px;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
        border-right: none;
        text-decoration: none;
        background-color: #F1F1F1;
    }

    .alphabet a.first
    {
        background-color: #19BCB9;
        border-radius: 3px 0 0 3px;
    }

    .alphabet a.last
    {
        border-right: 1px solid silver;
        border-radius: 0 3px 3px 0;
    }

    .alphabet a:hover,
    .alphabet a.active
    {
        background: #FBF8E9;
        font-weight: bold;
    }

    .wrapper1 {overflow: scroll;}
    .wrapper2 {overflow: auto;}
    .wrapper1 {height: 20px; }
    .wrapper2 {height: 500px; }
    .div1 {width:1200px; height: 20px; overflow: auto;}
    .div2 {width:1500px; height: 500px; overflow: auto; overflow-y: scroll; overflow-x: hidden}

    #scroller {overflow: scroll; height: 20px;}
    #scrollme {overflow: scroll; height: 300px;}

    table thead {
        background-color: #EEEEEE;
    }
</style>
<div class="span2">
    <article>
        <section>
            <h3>PEP Membership Listing</h3>

            Filter By :
            <div class="sele">
                <form action="">

                    Select a category : 
                    <select name='business_category' onchange='this.form.submit()' >
                        <option value="0" selected="selected" disabled>Choose...</option>
                        <option value="All" <?php
                        if (isset($_GET["business_category"]) && $_GET["business_category"] == 'All') {
                            echo "selected";
                        }
                        ?>>All Category</option>
                                <?php foreach ($this->bdirect as $row1) : ?>
                            <option value='<?php echo $row1->business_category; ?>' <?php
                            if (isset($_GET["business_category"]) && $_GET["business_category"] == $row1->business_category) {
                                echo "selected";
                            }
                            ?>><?php echo $row1->business_category; ?></option>
                                <?php endforeach; ?>		
                    </select>

                    <noscript><input type="submit" value="Submit"></noscript>
                </form>
            </div>
            <br/>
            <br/>
            <form action="">
                <div class="wrapper">
                    <div class="alphabet">
                        <?php
                        $valu = $this->vari;

                        foreach ($valu as $key) :
                            ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_membership_directory&alpha=' . strtolower($key)) ?>" onclick="document.getElementById('myform').submit()" style="text-decoration:none;font-size:15px" <?php
                            if (strtolower($key) == "z") {
                                echo "class='last'";
                            } elseif (strtolower($key) == "all") {
                                echo "class='first'";
                            } elseif (strtolower($key) == eregi_replace('[^a-zA-Z0-9_-]', '', $_GET[alpha])) {
                                echo "class='active'";
                            }
                            ?>><?php echo $key; ?></a>

                        <?php endforeach; ?>
                    </div>
                </div>
                <noscript><input type="submit" value="submit"></noscript>
            </form>

            <?php
            $user = JFactory::getUser();
            if ($user->email != "") {
                // neu ton tai user 
                ?>
                <!--                <div class="wrapper1">
                                    <div class="div1">
                
                                    </div>
                                </div>-->
                <!--<div class="wrapper2">-->
                <table  id="new_tbl" >

                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Address</th>
                            <th>City State Zip</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Job Title</th>
                            <th>Business Category</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->items as $item) : ?>            
                            <tr>
                                <td ><strong><?php echo trim($item->company); ?></strong></td>
                                <td><?php echo trim($item->address); ?></td>
                                <td><?php echo trim($item->city_state_zip); ?></td>
                                <td><strong><?php echo trim($item->first_name) ?></strong></td>
                                <td><strong><?php echo trim($item->last_name); ?></strong></td>
                                <td><?php echo trim($item->job_title); ?></td>
                                <td><?php echo wrap_text($item->business_category, 70); ?></td>
                                <td><a href="mailto:<?php echo trim($item->email); ?>"><?php echo trim($item->email); ?></a></td>
                                <td nowrap><?php echo trim($item->phone); ?></td>
                                <td nowrap> <?php echo wrap_text($item->description, 125); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--</div>-->
            <?php } else {
                ?>
                <table class="member-listing" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr class="table-header">
                        <th><h3 class="light-blue">Company Name</h3></th>
                    <th><h3 class="light-blue">Web Site</h3></th>
                    </tr>
                    <?php $show = false; ?>
                    <?php foreach ($this->items as $item) : ?>            
                        <?php
                        //var_dump($item->website);
                        $special_text = trim($item->desingated_rep);
                        //str_replace(" ", "", $str); preg_replace
                        $text = strtolower($special_text);
                        //if (strtolower($special_text) == "true" && $item->company!="" ) {
                        if (trim($item->company) != "" && trim($item->website) != "") {
                            if (count($item)) :
                                $show = true;
                                ?>
                                <tr>
                                    <td><?php echo $item->company; ?></td>
                                    <td><a href="JavaScript:newPopup(<?php echo "'http://" . trim($item->website) . "'"; ?>)"><?php echo $item->website; ?></a></td>
                                </tr>
                                <?php
                            endif;
                        } endforeach;
                    ?>
                    <?php ?>
                </table>
            <?php } ?>
            <p><?php //echo $this->pagination->getPagesCounter()." : ";                  ?></p>
        </section>
    </article>
    <?php if ($show): ?>

        <div class="pagination">
            <?php //echo $this->pagination->getPagesLinks();      ?>
        </div>

    <?php endif; ?>
</div>
<!--end left column-->
<div class="span3">
    <article class="left-border">
        <section>
            <h4>Member only</h4>
            <?php
            $module = JModuleHelper::getModule('login');
            echo JModuleHelper::renderModule($module);
            ?>
        </section>
        <section>
            <p>&nbsp;</p>
        </section>
    </article>
</div>
<script type="text/javascript">
//    $(function() {
//        $(".wrapper1").scroll(function() {
//            $(".wrapper2")
//                    .scrollLeft($(".wrapper1").scrollLeft());
//        });
//        $(".wrapper2").scroll(function() {
//            $(".wrapper1")
//                    .scrollLeft($(".wrapper2").scrollLeft());
//        });
//    });

//var $table = $('table#tbl_member');
//$table.floatThead({
//    scrollContainer: function($table){
//		return $table.closest('.wrapper2');
//	}
//});
    jQuery.noConflict();
    var $table2 = jQuery('#new_tbl');
    $table2.dataTable({
//        "bInfo": false,
//        "iDisplayLength": 20,
//        "bLengthChange": false
        "bAutoWidth": false,
        "sScrollY": "300",
        "sScrollX": "100%",
        "bScrollCollapse": "150%",
        "iDisplayLength": 20
                //       "bLengthChange": false,

    });

//    $table2.floatThead({
//        useAbsolutePositioning: true,
//        scrollContainer: function($table) {
//            return $table.closest('.wrapper2');
//        }
//    });
//        scrollContainer: function($table) {
//            var $wrapper = $table.closest('.wrapper2');
//            $wrapper.css({'overflow': 'auto', 'height': '600px'});
//            return $wrapper;
//        }
//    });
</script>

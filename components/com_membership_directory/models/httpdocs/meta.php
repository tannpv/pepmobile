<?
ini_set('display_errors', 0);
error_reporting(E_ALL);
// get set up
require "../setup.inc";
require $base_dir . "mlcm_setup.inc";
require $base_dir . "vars.inc";
require $bin_dir . "functions.php";

echo form_header("Edit META");
$db = new ps_DB();
$i = 0;


if ($_REQUEST['method'] == 'add') {
    $select = "SELECT * ";
    $from = "FROM meta ";
    $where = "WHERE pagename='$pagename' ";
    $sql = $select.$from.$where;
    $db->query($sql);
    $rows = $db->num_rows();
    if($rows){
        echo "<h2 align=center style='color:red'>Page name: '$pagename' already exists </h2>";
    }
    else{
		if(stristr($pagename," "))
			echo "<h2 align=center style='color:red'>Page name: '$pagename' is wrong format </h2>";
		else{
			$insert = " INSERT INTO meta  VALUES ('$pagename','','$metatag','$metadesc') ";
			$db->query($insert);
		}
    }
}
if($_REQUEST['method'] == 'update' )
{
    $update = " UPDATE meta SET 
        pagename = '$pagename',
        metakeywords = '$metatag',
        metadescription =  '$metadesc'
    WHERE  metaid = $metaid";
    $db->query($update);
}
if($_REQUEST['method'] == 'delete')
{
    $delete = " DELETE FROM meta WHERE metaid = $metaid ";
    $db->query($delete);
}
?>  
<style>
    .top{
        vertical-align: center;
    }
    .center{
        text-align:center
    }
</style>

<body BGCOLOR=#FFFFFF LEFTMARGIN=0 MARGINWIDTH=0 TOPMARGIN=0 MARGINHEIGHT=0>
    <div class="main">
        <h3 class ="center">META MANAGEMENT</h3>
    </div>    
    <table  align="center"  border='1' style=' border: 1px solid; border-spacing: 0pt;'>
        <tr> 
            <td class=center> Meta ID </td>
            <td class=center> Page Name</td>
            <td class=center> Keywords </td>
            <td class=center> Description </td>
            <td colspan=2 class=center>Action</td>  
        </tr>
        <tr>
            <td class="top">
                <input name="txtmetaid" id="txtmetaid" type="text" disabled style = "width:50px" value =""/> 
            </td>
            <td class="top">
                <input name="txtpagename" id="txtpagename" type="text" value =""/>  
            </td>
            <td>
                <label for="meta_tag"></label>
                <textarea name="meta_tag" id="meta_tag" cols="25" rows="2" ></textarea>
            </td>
            <td>
                <label for="meta_dec"></label>
                <textarea name="meta_dec" id="meta_dec" cols="25" rows="2"></textarea>
            </td>
            <td>
                <input type="image" src="images/add.gif"
                       onclick="submitForm(document.getElementById('txtpagename').value,document.getElementById('txtmetaid').value,document.getElementById('meta_tag').value,document.getElementById('meta_dec').value,'add');" value ="Add" />
            </td>
            <td>&nbsp;</td>
    </tr> 
    <?php
    $sql = "SELECT * FROM meta ORDER BY metaid DESC";
    $db->query($sql);
    
    While ($db->next_record()) {
        ?>
        <tr>
            <td class="top">
                <input name="txtmetaid<?php echo $i ?>" id="txtmetaid<?php echo $i ?>" type="text" disabled style = "width:50px" value =" <?php echo $db->f('metaid') ?>"/> 
            </td>
            <td class="top">
                <input name="txtpagename<?php echo $i ?>" id="txtpagename<?php echo $i ?>" type="text" value ="<?php echo $db->f('pagename') ?>"/>  
            </td>
            <td>
                <label for="meta_tag"></label>
                <textarea name="meta_tag<?php echo $i ?>" id="meta_tag<?php echo $i ?>" cols="25" rows="2" ><?php echo $db->f('metakeywords') ?></textarea>
            </td>
            <td>
                <label for="meta_dec"></label>
                <textarea name="meta_dec<?php echo $i ?>" id="meta_dec<?php echo $i ?>" cols="25" rows="2"><?php echo $db->f('metadescription') ?></textarea>
            </td>
            <td><input type="image" src="images/apply.gif" name=update<?php echo $i ?> 
                       onclick="submitForm(document.getElementById('txtpagename<?php echo $i ?>').value,document.getElementById('txtmetaid<?php echo $i ?>').value,document.getElementById('meta_tag<?php echo $i ?>').value,document.getElementById('meta_dec<?php echo $i ?>').value,'update');" alt="Apply"  /></td>
            <td><input type="image" src="images/delete.gif" name=delete<?php echo $i ?>
                       onclick="submitForm(document.getElementById('txtpagename<?php echo $i ?>').value,document.getElementById('txtmetaid<?php echo $i ?>').value,document.getElementById('meta_tag<?php echo $i ?>').value,document.getElementById('meta_dec<?php echo $i ?>').value,'delete');" alt="Delete" /></td>
    </tr> 
 <?php
    $i += 1;
}
?> 
</table> 
    <script>
        function trim(str, chars) {
            return ltrim(rtrim(str, chars), chars);
        }
        
        function ltrim(str, chars) {
            chars = chars || "\\s";
            return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
        }
        
        function rtrim(str, chars) {
            chars = chars || "\\s";
            return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
        }
        function submitForm(pagename,metaid, metatag, metadesc, method){
            error = '';
            pagename = trim(pagename);
            metatag = trim(metatag);
            metadesc = trim(metadesc);
            if(method!='delete'){
                if(trim(pagename) == null || trim(pagename)==''){
                    error = " Please enter page name \n";
                }
                if(trim(metatag) == null || trim(metatag)==''){
                    error += " Please enter meta keywords \n";
                }
                if(trim(metadesc) == null || trim(metadesc)==''){
                    error += " Please enter meta description \n";
                }
                if(error!=''){                
                    alert(error);
                    return false;
                }
            }
            document.getElementById("pagename").value = pagename;
            document.getElementById("metatag").value = metatag;
            document.getElementById("metadesc").value = metadesc;
            document.getElementById("metaid").value = metaid;
            document.getElementById("method").value = method;
            document.forms["abc"].submit();
        }
    </script>
    <form id="abc" name="abc" action="" method="POST">
        <input type="hidden" value="" id="metatag" name="metatag" />
        <input type="hidden" value="" id="metaid" name="metaid" />
        <input type="hidden" value="" id="method" name="method" />
        <input type="hidden" value="" id="pagename" name="pagename" />
        <input type="hidden" value="" id="metadesc" name="metadesc" />
    </form>
    
 

  
</body>
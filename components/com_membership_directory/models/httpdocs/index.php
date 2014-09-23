<? include('header.php'); ?>
<?php if (isset($_REQUEST['id'])) {
$id = $_REQUEST['id'];
} else {
    $id = 1;
}
$query = "SELECT * FROM pages";
$query.= " WHERE id='" . $id . "'";
$db->query($query);
while ($db->next_record()) { 
     echo $db->f('content'); 
}
if($id == 3){
        include('contact.php');
    } ?>
<? include('footer.php'); ?> 





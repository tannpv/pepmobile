<?php
exit;
require "configuration.php";
$config = new JConfig();

function spacify($camel, $glue = ' ') {
    return preg_replace('/([a-z0-9])([A-Z])/', "$1$glue$2", $camel);
}

//echo spacify('CamelCaseWords'), "<br/>"; // 'Camel Case Words'
//echo spacify('camelCaseWords'), "\n"; // 'camel Case Words'
//exit;
$dbhost = $config->host;
$dbuser = $config->user;
$dbpass = $config->password;
//var_dump($config->password);exit;
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
$sql = 'SELECT *    
        FROM jos_users';

mysql_select_db($config->db);
$retval = mysql_query($sql, $conn);
if (!$retval) {
    die('Could not get data: ' . mysql_error());
}
while ($row = mysql_fetch_object($retval)) {
    $name = spacify($row->name);
    // $name= str_replace("  ", " ", $name);
    // echo $name;
    // echo "<br/>";
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    if (!$conn) {
        die('Could not connect: ' . mysql_error());
    }
    $sql = "update jos_users set name='" . $name . "'"
            . "where id=" . $row->id;
    mysql_query($sql, $conn);
}
echo "Fetched data successfully\n";
mysql_close($conn);
?>

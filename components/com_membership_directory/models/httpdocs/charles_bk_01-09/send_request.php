<?
session_start();
include_once 'securimage/securimage.php';
$securimage = new Securimage();
if ($securimage->check($_POST['captcha_code']) == false) {
  // the code was incorrect
  // handle the error accordingly with your other error checking

  // or you can do something really basic like this
  die("The code you entered was incorrect. Please <a href='javascript:history.go(-1);'>Try Again.</a>");
}

$header = "From: webmaster@example.com";
$header = "From: ".$_POST["name"]." <".$_POST["email"].">";
$message = "Please send me a Charleston Lighting Catalog.

".$_POST["name"]."
".$_POST["title"]."
".$_POST["company"]."
".$_POST["address1"]."
".$_POST["address2"]."
".$_POST["city"].", ".$_POST["state"]." ".$_POST["zip"]."
".$_POST["country"]."

E-mail: ".$_POST["email"]."
";

mail("Charleston Lighting <swoods@charlestonlighting.com>","Charleston Lighting Catalog Request",$message,$header);
?>

<head>
<title>Charleston Lighting Catalog Request</title>
</head>
You have successfully sent the following message to Charleston Lighting:<br><br>
<?echo nl2br($message);?><br><br>
<a href="javascript:window.close()">Close Window</a>

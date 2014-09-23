<?php


$email = $_REQUEST['email'];
$firstName = $_REQUEST['firstName'];
$lastName = $_REQUEST['lastName'];
$companyName = $_REQUEST['companyName'];
$address1 = $_REQUEST['address1'];
$address2 = $_REQUEST['address2'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$country = $_REQUEST['country'];
$areaCode = $_REQUEST['areaCode'];
$telephone = $_REQUEST['telephone'];
$areaCodeFax = $_REQUEST['areaCodeFax'];
$fax = $_REQUEST['fax'];
$comments = $_REQUEST['comments'];
$captureIP = $_REQUEST['captureIP'];
$action = $_REQUEST['action'];

if ($action == 'submit') {
    $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: " . $firstName . " " . $lastName . " < " . $email . ">";
    $subject = "Website Request from Contact Form ";
    $send_to = "info@charlestonlighting.com";
	// $send_to = "mark.roberts@epiphanyhosting.com";
//    $send_to = "quanglong05@gmail.com";
    $message = " <h2>Charlestonlighting Website Contact Form</h2>
         <table>
                    <tr><td> Name:         </td><td>          " . $firstName . " " . $lastName  . " </td></tr>
                    <tr><td> CompanyName:  </td><td>          " . $companyName                  . " </td></tr>
                    <tr><td> Address 1:     </td><td>         " . $address1                    . " </td></tr>
                    <tr><td> Address 2:     </td><td>         " . $address2                    . " </td></tr>
                    <tr><td> City:         </td><td>          " . $city                         . " </td></tr>
                    <tr><td> State:        </td><td>          " . $state                        . " </td></tr>
                    <tr><td> Zip:          </td><td>          " . $zip                          . "</td></tr>
                    <tr><td> Email:        </td><td>          " . $email                        . "</td></tr>
                    <tr><td> Phone:        </td><td>          " . $areaCode ." ". $telephone    . "</td></tr>
                    <tr><td> Country:      </td><td>          " . $country                      . "</td></tr>
                    <tr><td> Fax:          </td><td>          " . $areaCodeFax ." " .$fax       . "</td></tr>
        </table>


                    Additional Comments:        " . $comments ;


 
    $mail = @mail($send_to, $subject, $message, $headers);
    if($mail){
        header('Location: http://charlestonlighting.com/dev/thankyou.php?mail=1');
    }else{
        header('Location: http://charlestonlighting.com/dev/thankyou.php?mail=4');
    }
}
?>
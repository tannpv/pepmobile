<?php
// Set path to download zip file
$dl_url = 'http://charlestonlighting.com/light_bk/chlight.zip';

// Check if everything's cool and groovy - create a link to download zip file
if (system('zip -r /var/www/vhosts/charlestonlighting.com/httpdocs/light_bk/chlight.zip  /var/www/vhosts/charlestonlighting.com/httpdocs'))
{
echo '<p>All zipped up!</p>';
echo '<a href="' . $dl_url . '">Download</a>';
} else {
echo '<p>Balls! Didn\'t work.</p>';
}

?>
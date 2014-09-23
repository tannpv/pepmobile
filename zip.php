<?php
// Set path to download zip file
$dl_url = 'http://dev.pepmobile.org/bk/filename.zip';

// Check if everything's cool and groovy - create a link to download zip file
if (system('zip -r 	/var/www/vhosts/pepmobile.org/subdomains/dev/httpdocs/bk/filename.zip 	/var/www/vhosts/pepmobile.org/subdomains/dev/httpdocs'))
{
echo '<p>All zipped up!</p>';
echo '<a href="' . $dl_url . '">Download</a>';
} else {
echo '<p>Balls! Didn\'t work.</p>';
}

?>
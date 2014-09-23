<?include('header.php');?>

		  <table border=0 cellpadding=2 cellspacing=0>
			<?php
			if ($_REQUEST['mail'] == '1') {
				echo '<h1>Your mail has NOW been sent...</h1>';
			}

			if ($_REQUEST['mail'] == '2') {
				echo '<h1>Your mail has already been sent... </h1>';
			}

			if ($_REQUEST['mail'] == '3') {
				echo '<h1>Thank you </h1>';
			}
			
			if ($_REQUEST['mail'] == '4') {
				echo  '<strong>Incorrect verification code.</strong><br>'; 
			}
			?>
		</table>
<?include('footer.php');?>
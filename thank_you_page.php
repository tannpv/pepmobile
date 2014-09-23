<!doctype html>
<html>
  <head>
    <title>Your Store</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    
    <h2>Thank You</h2>
    <h3>Your transaction ID:</h3>
    <div class="id"><?php echo htmlentities($_GET['transaction_id'])?></div>
  </body>
</html>

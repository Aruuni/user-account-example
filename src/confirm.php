<?php
session_start();
$_SESSION['CSRF'] = md5(uniqid(mt_rand(), true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="../style.css" rel="stylesheet" type="text/css">

    <title>Email Confirmation</title>
</head>
<body>
    <div class="commonBox">
        <h1>Confirm Your Email</h1>
        <h2>Enter the code you received in your email:</h2>

        <form action="../confirmToken.php" method="post" id="confirm-from">
            
            <label for="token">
                <i class="fas fa-lock"></i>
            </label>   
            <input type="text" id="token" name="token" required>
            
            <input type="hidden" name="CSRF" value="<?php echo $_SESSION['CSRF']; ?>">

            <input type="submit" value="Confirm" >
        </form>
    </div>
</body>
</html>

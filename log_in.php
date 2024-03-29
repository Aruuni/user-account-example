<?php
session_start();
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css"> 

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="validation/loginSubmit.js"></script>
</head>
<body>
<div class="commonBox">
    <h1>Lovejoy's Antique  Login</h1>
    <form action="login.php" method="post" id="login-form">
        
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" required>

        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
    
        <div id="warning-message" class="warning" value=""></div>

        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

        <a href="passwordreset/email.html">Forgot Password?</a>
        <input type="submit" value="Login" class="g-recaptcha" data-sitekey="6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_"  data-callback='onSubmit' data-action='submit'>
        
    </form>
    <form action="sign_up.php">
        <input type="submit"  value="Sign up">
    </form>
</div>

</body>
</html>


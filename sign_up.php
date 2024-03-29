
<?php
session_start();
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="validation/signupSubmit.js"></script>

</head>
<body>
    <div class="commonBox">
        <h1>Sign Up</h1>
        <form action="signup.php" method="post" id="signup-form">

            <label for="username">
                <i class="fas fa-user"></i>
            </label>            
            <input type="text" name="username" placeholder="Username" id="username" required>

            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>            
            <input type="email" name="email" placeholder="Email address" id="email" required>

            <label for="phone">
                <i class="fas fa-phone"></i>
            </label>
            <input type="tel" id="phone" name="phone" pattern="^[0-9\s()+-]*$" placeholder="e.g., +447123456789 or 07123 456 789" required>

            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" oninput="checkPasswordStrength()" required>
            <div class="strength-indicator" id="strength-indicator"></div>

            <label for="confirm_password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" oninput="checkConfirmPasswordStrength()" required>
            
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            
            <div id="warning-message" class="warning" value=""></div>
            <input type="submit" value="Create Account" class="g-recaptcha" data-sitekey="6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_" data-callback='onSubmit' data-action='submit'>

        </form>
        <form action="log_in.php">
            <input type="submit"  value="Log in">
        </form>
    </div>
</body>
</html>

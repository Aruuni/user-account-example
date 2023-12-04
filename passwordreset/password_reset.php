<?php
include_once '../src/connection.php';  
include_once '../src/password_email_confirmation.php';

$email              = $_GET['email'];
$activation_code    = $_GET['activation_code'];
$password           = $_POST['password'];
$confirmPassword    = $_POST['confirm_password'];
//password match 
if ($password !== $confirmPassword) {
    die("Error: Passwords do not match.");
}

if(!preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password) || 
    !preg_match('@[0-9]@', $password) || !preg_match('@[^\w]@', $password) || strlen($password) < 8) {
     die('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if (confirmPassReset($email, $activation_code, $connection)) {

    if ($update = $connection->prepare('UPDATE accounts SET password = ? WHERE email = ?')) {
        $update->bind_param('ss', $hashedPassword, $email);
        $update->execute();
        $update->close();
        header("Location: ../confirmation/password_reset_succes.html");
        echo $password;
        echo $confirmPassword;
        echo $hashedPassword;
        exit();
    }

} else {
    header("Location: ../confirmation/password_reset_fail.html");
    exit();
}

?>

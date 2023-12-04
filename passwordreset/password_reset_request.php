<?php
session_start();
include_once '../src/connection.php';
include_once '../src/captcha.php';
include_once '../src/password_email_confirmation.php';
check_captcha();


$email      = $_POST['email'];
# SWQL INJECTION PREVENTION 

if ($statement = $connection->prepare("SELECT * FROM accounts WHERE email = ?" )) {
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if (mysqli_num_rows($result) > 0) {
        send_password_reset($email, $connection);   
        header('Location: ../confirmation/check_email.html');
        exit(); // Make sure to exit after the header redirect
    }
} else {
    header('Location: "../confirmation/reset_email_sent.html"');
    $connection->close();
    exit();
}
?>
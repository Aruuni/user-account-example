<?php

require '../PHPMailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Define a secret key for encryption
$secretKey = 'your_secret_keyy';

function send_password_reset(string $email, $connection): void
{
    $activation_code = generate_activation_code();
    // create the activation link
    # $activation_link = "https://mm2350sub.000webhostapp.com/confirmation/activateAccount.php?email=$email&activation_code=$activation_code";
    $activation_link = "http://localhost/IntroToCompSec/passwordreset/password_reset.html?email=$email&activation_code=$activation_code";
    
    insertResetToken($email, $activation_code, $connection);
    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Username = "mihaifcp44279@gmail.com";
    $mail->Password = "osad lhzc fbau yxzx";
    $mail->Port = "465";

    // Set email content
    $mail->setFrom('mm2350@gmail.com', 'Your Name'); 
    $mail->addAddress($email);
    $mail->Subject = 'mm2350 Password Reset';
    $mail->Body    = "Hi,\nClick the following link to reset your password:\n$activation_link \n if you did not request a password reset, you can safely ignore this email.";

    // Send the email
    if (!$mail->send()) {
        die('Email registration failed');
    } 

}



function insertResetToken(string $email, string $token, $connection): void
{
    if ($statement = $connection->prepare('UPDATE accounts SET password_reset_request = 1, activation_token = ?, activation_token_timestamp = DATE_ADD(NOW(), INTERVAL 10 MINUTE) , password_request_timestamp = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = ?')) {
        $statement->bind_param('ss', $token, $email);
        $statement->execute();
        $statement->close();
    }
}

function confirmPassReset(string $email, string $token, $connection): bool
{
    if ($statement = $connection->prepare('SELECT * FROM accounts WHERE email = ? AND activation_token = ? AND activation_token_timestamp > NOW() AND password_reset_request = 1 AND password_request_timestamp > NOW()')) {
        $statement->bind_param('ss', $email, $token);
        $statement->execute();
        $statement->store_result();
        if ($statement->num_rows > 0) {
            $statement->close();
            return true;
        }
    }
    $statement->close();
    return false;
}

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/vendor/autoload.php';

// Define a secret key for encryption
$secretKey = 'your_secret_keyy';


// Function to send an encrypted activation email using PHPMailer
function send_login_code(string $email, $connection): void
{
    // Create verification code
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    // Initialize PHPMailer
    insertAuthToken($email, $verification_code, $connection);
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Username = "mihaifcp44279@gmail.com";
    $mail->Password = "";
    $mail->Port = "465";

    // Set email content
    $mail->setFrom('mm2350@gmail.com', 'Your Name'); // Change this to your email and name
    $mail->addAddress($email);
    $mail->Subject = 'Login Confirmation code';
    $mail->Body    = "Hi,\n Here is your login code:\n$verification_code";

    // Send the email
    if (!$mail->send()) {
        die('Email registration failed');
    } 
    
}

function send_account_confirmation(string $email, $connection): void
{
    $activation_code = generate_activation_code();
    // create the activation link
    $activation_link = "https://mm2350sub.000webhostapp.com/confirmation/activateAccount.php?email=$email&activation_code=$activation_code";
    $activation_link = "http://localhost/IntroToCompSec/confirmation/activateAccount.php?email=$email&activation_code=$activation_code";
    
    insertAuthToken($email, $activation_code, $connection);
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
    $mail->setFrom('mm2350@gmail.com', 'Your Name'); // Change this to your email and name
    $mail->addAddress($email);
    $mail->Subject = 'Please activate your account';
    $mail->Body    = "Hi,\nPlease click the following link to activate your account:\n$activation_link";

    // Send the email
    if (!$mail->send()) {
        die('Email registration failed');
    } 

}



function insertAuthToken(string $email, string $token, $connection): void
{
    if ($statement = $connection->prepare('UPDATE accounts SET activation_token = ?, activation_token_timestamp = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $statement->bind_param('ss', $token, $email);
        $statement->execute();
        $statement->close();
    }
}

function confirmAuthToken(string $email, string $token, $connection): bool
{
    if ($statement = $connection->prepare('SELECT id FROM accounts WHERE email = ? AND activation_token = ? AND activation_token_timestamp > NOW()')) {
        $statement->bind_param('ss', $email, $token);
        $statement->execute();
        $statement->store_result();
        if ($statement->num_rows > 0) {
            $statement->close();
            return true;
        }
        $statement->close();
    }
    return false;
}

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}
?>
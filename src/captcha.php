<?php
function check_captcha() {
    $captchaKey = "6LeeNCEpAAAAAAvBEIXPf4PQX-Wn0MoRBF2yRCUp";

    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $captchaKey . '&response=' . $_POST['g-recaptcha-response'];
    
        $response = file_get_contents($url);
        $recaptchaResult = json_decode($response); 
        if (!$recaptchaResult->success) {
            die ('reCAPTCHA verification failed. Please try again.');
        }
    }
}
?>
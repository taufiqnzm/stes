<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

// Generate a random verification code
$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

$_SESSION['verification_code'] = $verification_code;

// Get the current timestamp
$currentTimestamp = date('Y-m-d H:i:s');

//Instantiation and passing 'true' enables exceptions
$mail = new PHPMailer(true);

try {
    // Enable verbose debug output
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    // $mail->SMTPDebug = 0;

    // $mail->SMTPOptions = array(
    //     'ssl' => array(
    //         'verify_peer' => false,
    //         'verify_peer_name' => false,
    //         'allow_self_signed' => true
    //     )
    // );

    // Send using SMTP
    $mail->isSMTP();

    // Set the SMTP server to send through
    $mail->Host = 'smtp.gmail.com';

    // Enable SMTP Authentication
    $mail->SMTPAuth = true;

    // SMTP username
    $mail->Username = "tzumi.10@gmail.com";

    // SMTP password
    $mail->Password = 'jydgvtelckbtcwfw';

    // Enable TLS encryption;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // TCP port, use 465 for 'PHPMailer::ENCRYPTION_STARTLS' above
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('tzumi.10@gmail.com', 'STES');

    // Add a recipient
    $mail->addAddress($email);

    // Add embedded image
    $mail->addEmbeddedImage('img/logoSTES.png', 'logo');

    // Set email format to HTML
    $mail->isHTML(true);

    // Email subject
    $mail->Subject = 'Your Email Verification Code';

    // Email body
    $mail->Body = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .email-container {
                background-color: #ffffff;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                margin: 20px auto;
                padding: 20px;
                max-width: 600px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                font-size: 24px;
                font-weight: bold;
                color: #333333;
                text-align: center;
                margin-bottom: 20px;
            }
            .email-body {
                font-size: 16px;
                color: #555555;
                line-height: 1.5;
            }
            .verification-code {
                font-size: 30px;
                font-weight: bold;
                color: #d9534f;
                text-align: center;
                margin: 20px 0;
            }
            .logo {
                display: block;
                margin: 0 auto 20px auto;
                max-width: 150px;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <img src="cid:logo" alt="Logo" class="logo">
            <div class="email-header">Email Verification</div>
            <div class="email-body">
                <p>Your verification code is:</p>
                <div class="verification-code">' . $verification_code . '</div>
                <p>Please enter this code in the verification form to proceed.</p>
            </div>
        </div>
    </body>
    </html>';

    $mail->send();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


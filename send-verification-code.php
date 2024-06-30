<?php
    session_start();
    date_default_timezone_set('Asia/Kuala_Lumpur');
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
        $mail->Password = 'xegl wash zlku nrdj';

        // Enable TLS encryption;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // TCP port, use 465 for 'PHPMailer::ENCRYPTION_STARTLS' above
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('tzumi.10@gmail.com', 'STES');

        // Add a recipient
        $mail->addAddress($email);

        // Set email format to HTML
        $mail->isHTML(true);

        $mail->Subject = 'Email verification';
        $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>
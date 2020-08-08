<?php

/**
 * Sensitive Information
 * Add this file in .gitignore or remove the mail username and password
 */

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_email($email){
    // Load Composer's autoloader
    $sitePath = $_SERVER['DOCUMENT_ROOT']."/user_management_rest/";
    require($sitePath.'vendor/autoload.php');
    // $email = 'pawan88.lamba@gmail.com';
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'Sensitive info so I removed it after testing';                     // SMTP username
        $mail->Password   = 'Sensitive info so I removed it after testing';                     // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        // $email = 'pawan88.lamba@gmail.com';
        //Recipients
        $mail->setFrom('pawantesting8@gmail.com', 'Pawan Lamba');
        $mail->addAddress($email);     // Add a recipient
        // $mail->addAddress('pawantesting8@gmail.com');

        $emailURL = "http://".$_SERVER['HTTP_HOST']."/user_management_rest/api/email_activation/".$email;
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Confirm your Email - User Management API';
        $mail->Body    = 'Click on the confirmation Link <b>'.$emailURL.'</b> to activate your account';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}


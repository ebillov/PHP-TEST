<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    /**
     * Our constructor
     * @param string $email
     * @param string $name
     * @param string $login_method
     */
    public function __construct(string $email, string $name, string $login_method){
        $this->email = $email;
        $this->name = $name;
        $this->login_method = $login_method;
    }

    /**
     * Method to send the email
     * @return string
     */
    public function notify(){

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {

            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = getenv('MAILER_HOST');                    // Set the SMTP server to send through
            $mail->SMTPAuth   = getenv('MAILER_SMTP_AUTH');                                   // Enable SMTP authentication
            $mail->Username   = getenv('MAILER_SMTP_USERNAME');                     // SMTP username
            $mail->Password   = getenv('MAILER_SMTP_PASSWORD');                               // SMTP password
            $mail->SMTPSecure = (getenv('MAILER_SMTP_SECURE') == 'ENCRYPTION_STARTTLS') ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(getenv('MAILER_FROM'), 'Mailer');
            $mail->addAddress($this->email, $this->name);     // Add a recipient

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Hi ' . $this->name;
            $mail->Body    = 'This is an email notifying you that the login test via ' . $this->login_method . ' was processed successfully.';
            $mail->send();

            return 'Email has been sent';

        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

}
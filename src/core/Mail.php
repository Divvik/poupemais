<?php

# namespace
namespace Src\Core;

# use
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{   
    private $mail;

    public function __construct()
    {   
        // Instantiation and passing `true` enables exceptions
        $this->mail = new PHPMailer();
    }

    public function sendMail($email, $login, $token = NULL, $assunto, $corpoMail)
    {
        
        try {
            //Server settings
            $this->mail->SMTPDebug = 1;                                           // Enable verbose debug output
            $this->mail->isSMTP();                                              // Set mailer to use SMTP
            $this->mail->Host       = HOSTMAIL;                                 // Specify main and backup SMTP servers
            $this->mail->SMTPAuth   = true;                                     // Enable SMTP authentication
            $this->mail->Username   = USERMAIL;                                 // SMTP username
            $this->mail->Password   = PASSMAIL;                                 // SMTP password
            $this->mail->SMTPSecure = 'tls';                                    // Enable TLS encryption, `ssl` also accepted
            $this->mail->Port       = 587;
            $this->mail->CharSet    = 'utf-8';
            // $this->mail->SMTPoptions = array(
            //     "ssl" => array(
            //         "verify_peer" => false,
            //         "verify_peer_name" => false,
            //         "allow_self_signed" => true
            //     )
            // );                                      // TCP port to connect to

            //Recipients
            $this->mail->setFrom(USERMAIL, 'Poupemais');
            $this->mail->addAddress($email, $login);     // Add a recipient
            // $this->mail->addAddress();               // Name is optional
            // $this->mail->addReplyTo('info@example.com', 'Information');
            // $this->mail->addCC('cc@example.com');
            // $this->mail->addBCC('bcc@example.com');

            // Attachments
            // $this->mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $assunto;
            $this->mail->msgHTML(file_get_contents("email.php"), DIRREQ . '/src/core/');
            $this->mail->Body    = $corpoMail;
            // $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

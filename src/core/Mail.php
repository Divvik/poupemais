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
        $msg = array();
        $this->mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = 0;
        //Set the hostname of the mail server
        $this->mail->Host = HOSTMAIL;
        // use
        // $this->mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = USERMAIL;
        //Password to use for SMTP authentication
        $this->mail->Password = PASSMAIL;
        //Set who the message is to be sent from
        $this->mail->setFrom(USERMAIL, 'Poupemais');
        //Set an alternative reply-to address
        // $this->mail->addReplyTo($email, $login);
        //Set who the message is to be sent to
        $this->mail->addAddress($email, $login);
        //Set the subject line
        $this->mail->Subject = $assunto;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        // $this->mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually
        $this->mail->Body = $corpoMail;
        $this->mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        // $this->mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        if (!$this->mail->send()) {
            $msg = [
                "retorno" => 'erro',
                "erros" => "Mailer Error: " . $this->mail->ErrorInfo
            ];
            return $msg;
        } else {
            $msg = [
                "retorno" => "success",
                "msg" => "Message sent!"
            ];
            return $msg;
        }
    }
}

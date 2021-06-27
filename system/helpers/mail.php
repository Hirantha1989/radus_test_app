<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once realpath(__DIR__. "/../../vendor/autoload.php");

function sendEmail($data){

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 2525;

        $mail->setFrom('radus@mail.com', 'Radus');
        $mail->addAddress($data['receiver']);

        $mail->isHTML(true);
        $mail->Subject = $data['subject'];
        $mail->Body    = $data['body'];

        if(!empty($data['attachment'])){
            $mail->addAttachment($data['attachment']);
        }
        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


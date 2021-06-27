<?php
ob_start();

class framework
{
    public function view($viewName, $data = []){
        if(file_exists(realpath(__DIR__."/../../application/Views/" . $viewName . ".php"))){

            require_once realpath(__DIR__."/../../application/Views/$viewName.php");

        } else {
            echo "<div style='margin:0;padding: 10px;background-color:silver;'>Sorry $viewName.php file not found </div>";
        }

    }

    public function model($modelName){

        if(file_exists("../application/models/" . $modelName . ".php")){

            require_once "../application/models/$modelName.php";
            return new $modelName;

        } else {
            echo "<div style='margin:0;padding: 10px;background-color:silver;'>Sorry $modelName.php file not found </div>";
        }

    }

    public function redirect($path){

        header("location:" . BASEURL . "/".$path);

    }

    // Set flash message
    public function setFlash($sessionName, $msg){

        if(!empty($sessionName) && !empty($msg)){

            $_SESSION[$sessionName] = $msg;

        }

    }

    //Show flash message
    public function flash($sessionName, $className){

        if(!empty($sessionName) && !empty($className) && isset($_SESSION[$sessionName])){

            $msg = $_SESSION[$sessionName];

            echo "<div class='". $className ."'>".$msg."</div>";
            unset($_SESSION[$sessionName]);

        }

    }


    public function sendMail()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gfg.com;';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'user@gfg.com';
            $mail->Password   = 'password';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('from@gfg.com', 'Name');
            $mail->addAddress('receiver1@gfg.com');
            $mail->addAddress('receiver2@gfg.com', 'Name');

            $mail->isHTML(true);
            $mail->Subject = 'Subject';
            $mail->Body    = 'HTML message body in <b>bold</b> ';
            $mail->AltBody = 'Body in plain text for non-HTML mail clients';
            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
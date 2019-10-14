<?php

require 'PHPMailer/PHPMailerAutoload.php';

$name       = @trim(stripslashes($_POST['name'])); 
$from       = @trim(stripslashes($_POST['email'])); 
$subject    = @trim(stripslashes($_POST['subject'])); 
$message    = @trim(stripslashes($_POST['message'])); 
$to   		= 'contato@level5jr.com.br';//replace with your email
//$to   		= 'nathan@level5jr.com.br';//replace with your email


$mail = new PHPMailer;

$mail->isSMTP();
$mail->SMTPDebug = 0;

$mail->Debugoutput = 'html';

$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "formulario@level5jr.com.br";
$mail->Password = "|Tq2:5K21jTP";


$mail->setFrom('formulario@level5jr.com.br', 'Site LVL5');
$mail->AddReplyTo($from, $name);
$mail->addAddress($to, 'Level5');
$mail->Subject = $name . ' - Contato via site';
$mail->Body = $message;

        if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          exit;
        }
        $secretKey = "6LeF47UUAAAAAAJilbUWe0UDpmGM97yICTz2zqVe";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        if($responseKeys["success"]) {

            if (!$mail->send()){
                echo "Mailer Error: " . $mail->ErrorInfo;
                header('Location: /index.html');
            } else { 
	        echo "Message sent!";
	        header('Location: /index.html');
            }
            
        } else {
            echo "Resolva o captcha!";
        die; 
        }



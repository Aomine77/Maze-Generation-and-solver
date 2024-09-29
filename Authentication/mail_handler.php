<?php
require '../vendor/autoload.php'; // Make sure PHPMailer is autoloaded
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function sendMail($name, $email, $otp){
   
                // Send OTP email using PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sthabipin0713@gmail.com';
                    $mail->Password = 'lujrtsnxffkbxipl'; 
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('reply@noreply.com', 'Maze');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your OTP Code';
                    $mail->Body    = "Hi $name,<br><br>Your OTP code is <b>$otp</b>.<br>Please use this code to complete your registration.";

                    $mail->send();
                    return "OK";
                } catch (Exception $e) {
                    
                    return ($mail->ErrorInfo);
                }
        }

?>

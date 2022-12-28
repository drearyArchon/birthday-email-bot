<?php
/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/* Include the Composer generated autoload.php file. */
require 'C:\xampp\composer\vendor\autoload.php';
/* If you installed PHPMailer without Composer do this instead: */
/*
require 'C:\PHPMailer\src\Exception.php';
require 'C:\PHPMailer\src\PHPMailer.php';
require 'C:\PHPMailer\src\SMTP.php';
*/
/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$phpmailer = new PHPMailer(TRUE);
/* Open the try/catch block. */
#  Host: smtp.mailtrap.io
# Port: 25 or 465 or 587 or 2525

try {
   /* Set the mail sender. */
   
   $phpmailer->setFrom('darth@empire.com', 'Darth Vader');
   /* Add a recipient. */
   $phpmailer->addAddress('ravalvaliandi@gmail.com', 'Muhammad Ravid Valiandi');
   /* Set the subject. */
   $phpmailer->Subject = 'Force';
   /* Set the mail message body. */
   $phpmailer->Body = 'There is a great disturbance in the Force.';
   /* Finally send the mail. */

   $phpmailer->isSMTP();
   $phpmailer->Host = 'smtp.mailtrap.io';
   $phpmailer->SMTPAuth = true;
   $phpmailer->Port = 2525;
   $phpmailer->Username = '63f67137c0dace';
   $phpmailer->Password = 'b18de358f3bb9f';
   $phpmailer->send();
}
catch (Exception $e)
{
   /* PHPMailer exception. */
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   /* PHP exception (note the backslash to select the global namespace Exception class). */
   echo $e->getMessage();
}
?>
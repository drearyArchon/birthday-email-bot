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

$servername = "localhost";
$username = "birthday_bot";
$password = "happybirthday";
$dbname = "sayakaya_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

// $sql_query = "SELECT `customer_id`, `name`, `birthday_date`, `email` FROM `customers`";
// if ($result = $conn->query($sql_query)){
//  if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//      echo "customer_id: " . $row["customer_id"]. "<br>";
//      echo "name: " . $row["name"]. "<br>";
//      echo "birthday_date: " . $row["birthday_date"]. "<br>";
//      echo "email: " . $row["email"]. "<br>";
//    }
//  } else {
//    echo "0 results";
//  }
//} else {
//  echo "query failed";
//}

try {
   /* Set the mail sender. */
   $phpmailer->setFrom('darth@empire.com', 'Darth Vader');
   /* Add a recipient. */
   $phpmailer->addAddress('ravalvaliandi@gmail.com', 'Muhammad Ravid Valiandi');
   /* Set the subject. */
   $phpmailer->Subject = 'Happy Birthday ' . $name . '! Here`s a small gift from us to you!';
   /* Set the mail message body. */
   $phpmailer->Body = 'Use promo code randomcode on our website for 10% on your purchase today!';
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
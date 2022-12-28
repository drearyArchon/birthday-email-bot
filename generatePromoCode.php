<?php

$result = uniqid();
// echo $result;

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


// prepare and bind
$insert = "INSERT INTO `active_birthday_promo_codes` (`customer_id`, `promo_code`) VALUES (?, ?)";
$stmt = $conn->prepare($insert);
$customer_id = 1;
$promo_code = 123456789;
$stmt->bind_param("ii", $customer_id, $promo_code);
$stmt->execute();
$stmt->close();
$conn->close();

?>
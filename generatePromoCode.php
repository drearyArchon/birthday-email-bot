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

// $sql_query = "SELECT `promo_id`, `customer_id`, `promo_code`, `expiration_date` FROM `active_birthday_promo_codes`";
// if ($result = $conn->query($sql_query)){
//  if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//      echo "promo_id: " . $row["promo_id"]. "<br>";
//      echo "customer_id: " . $row["customer_id"]. "<br>";
//      echo "promo_code: " . $row["promo_code"]. "<br>";
//      echo "expiration_date: " . $row["expiration_date"]. "<br>";
//    }
//  } else {
//    echo "0 results";
//  }
//} else {
//  echo "query failed";
//}



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
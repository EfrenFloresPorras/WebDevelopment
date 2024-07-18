<?php

include_once 'config.php';

// Create connection
//mysqli(server_name o host, user, password, db_name)
$conn = new mysqli($DB_data['server'], $DB_data['connInfo']['UID'],  $DB_data['connInfo']['PWD'],  $DB_data['Database']);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

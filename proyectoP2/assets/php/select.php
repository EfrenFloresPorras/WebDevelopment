<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once 'config.php';

// Create connection
//mysqli(server_name o host, user, password, db_name)
$conn = new mysqli($DB_data['server'], $DB_data['connInfo']['UID'],  $DB_data['connInfo']['PWD'],  $DB_data['Database']);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8
if (!$conn->set_charset("utf8")) {
    $conn->close();
    die("Error loading character set utf8: %s\n". $conn->error);
}


$query = $_POST['query'];

$result = $conn->query($query);

$data = [];
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        array_push($data,$row);
    }
}

echo json_encode($data);

$conn->close();

?>
<?php

include_once 'config.php';

$conn = new mysqli($DB_data['server'], $DB_data['connInfo']['UID'], $DB_data['connInfo']['PWD'], $DB_data['Database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
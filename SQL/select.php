<?php

include_once 'config.php';

$conn = new mysqli($DB_data['server'], $DB_data['connInfo']['UID'], $DB_data['connInfo']['PWD'], $DB_data['Database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!$conn->set_charset("utf8")) {
    $conn->close();
    die("Error cargando el conjunto de caracteres utf8");
}

$query = $_POST['query'];
$result = $conn->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }
} else {
    echo "0 results";
}

echo json_encode($data);

$conn->close();

?>
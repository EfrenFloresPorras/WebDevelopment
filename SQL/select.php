<?php
include_once 'config.php';

$conn = new mysqli($DB_data['server'], $DB_data['connInfo']['UID'], $DB_data['connInfo']['PWD'], $DB_data['Database']);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if (!$conn->set_charset("utf8")) {
    $conn->close();
    die(json_encode(["error" => "Error loading UTF-8 character set"]));
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $result = $conn->query($query);

    if ($result === false) {
        echo json_encode(["error" => "Query execution failed: " . $conn->error]);
    } else {
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode($data);
    }
} else {
    echo json_encode(["error" => "No query provided"]);
}

$conn->close();

?>
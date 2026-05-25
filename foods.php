<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include "db.php";

$result = $conn->query("SELECT * FROM foods");

$foods = [];

while ($row = $result->fetch_assoc()) {
    $foods[] = $row;
}

echo json_encode($foods);
?>
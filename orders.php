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

$data = json_decode(file_get_contents("php://input"), true);

$user = $data['user'] ?? '';
$items = json_encode($data['items'] ?? []);
$total = $data['total'] ?? 0;

if (!$user || !$items) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO orders (user_email, items, total) VALUES (?, ?, ?)");
$stmt->bind_param("ssd", $user, $items, $total);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>
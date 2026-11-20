<?php
function getDB() {
    return new PDO(
        'mysql:host=localhost;dbname=leopard_rock;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}

function respond($ok, $message) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $ok, 'message' => $message]);
    exit;
}

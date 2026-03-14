<?php

header('Content-Type: application/json');

require_once '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$nombre = $data['nombre'] ?? null;
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if(!$nombre|| !$email || !$password) {
    echo json_encode(['error' => 'Faltan campos requeridos']);
    exit;

}

try {
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt-> execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    echo json_encode(['message' => 'Usuario registrado exitosamente']);

}catch (PDOException $e) {
    echo json_encode(['error' => 'Error al registrar el usuario: ' . $e->getMessage()]);
}


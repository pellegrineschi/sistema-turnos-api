<?php

header('Content-Type: application/json');
require_once '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if(!$email || !$password) {
    echo json_encode(['error' => 'Faltan campos requeridos']);
    exit;
}

try {

$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute([':email' => $email]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario){
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

if (!password_verify($password, $usuario['password'])) {
    echo json_encode(['error' => 'Contraseña incorrecta']);
    exit;

}

echo json_encode([
    "message" => 'Login exitoso',
    "usuario" => [
        "id" => $usuario['id'],
        "nombre" => $usuario['nombre'],
        "email" => $usuario['email']
        ]
]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al iniciar sesión: ' . $e->getMessage()]);
};
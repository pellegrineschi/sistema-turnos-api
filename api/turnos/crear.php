<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


header('Content-Type: application/json');
require_once '../../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$usuario_id = $data['usuario_id'] ?? null;
$profesional_id = $data['profesional_id'] ?? null;
$fecha_hora = $data['fecha_hora'] ?? null;

if (!$usuario_id || !$profesional_id || !$fecha_hora) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

try {
    $sql = "INSERT INTO turnos (usuario_id, profesional_id, fecha_hora) VALUES (:usuario_id, :profesional_id, :fecha_hora)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':profesional_id' => $profesional_id,
        ':fecha_hora' => $fecha_hora
    ]);
    echo json_encode(['success' => true, 'message' => 'Turno creado exitosamente']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al crear el turno: ' . $e->getMessage()]);
};
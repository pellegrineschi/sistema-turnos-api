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
    //verificar si ya existe un turno
    $check_sql = "SELECT id
                  FROM turnos
                  WHERE profesional_id = :profesional_id
                  AND fecha_hora = :fecha_hora
                  AND estado = 'activo'";

    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute([
        ':profesional_id' => $profesional_id,
        ':fecha_hora' => $fecha_hora
    ]);

    if ($check_stmt->rowCount() > 0) {
        echo json_encode([
            "success" => false,
            "message" => "El profesional ya tiene un turno en ese horario"
        ]);
        exit;
    }


    //crear turno
    $sql = "INSERT INTO turnos (usuario_id, profesional_id, fecha_hora) VALUES (:usuario_id, :profesional_id, :fecha_hora)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':profesional_id' => $profesional_id,
        ':fecha_hora' => $fecha_hora
    ]);
    echo json_encode(['success' => true, 'message' => 'Turno creado exitosamente']);

} catch (PDOException $e) {
     if ($e->getCode() == '23505') {
        echo json_encode([
            "success" => false,
            "message" => "El profesional ya tiene un turno en ese horario"
        ]);
    } else {
    echo json_encode(['success' => false, 'message' => 'Error al crear el turno: ' . $e->getMessage()]);}
};
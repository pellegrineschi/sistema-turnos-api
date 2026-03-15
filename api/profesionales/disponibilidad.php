<?php

header('Content-Type: application/json');
require_once '../../config/database.php';

$profesional_id = $_GET['profesional_id'] ?? null;
$fecha = $_GET['fecha'] ?? null;

if (!$profesional_id || !$fecha) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan parámetros"
    ]);
    exit;
}

try {

    $sql = "SELECT fecha_hora
            FROM turnos
            WHERE profesional_id = :profesional_id
            AND DATE(fecha_hora) = :fecha
            AND estado = 'activo'";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':profesional_id' => $profesional_id,
        ':fecha' => $fecha
    ]);

    $turnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $horarios_ocupados = [];

    foreach ($turnos as $turno) {
        $horarios_ocupados[] = date("H:i", strtotime($turno['fecha_hora']));
    }

    $horarios_laborales = [
        "09:00","10:00","11:00","12:00",
        "13:00","14:00","15:00","16:00"
    ];

    $horarios_disponibles = array_diff($horarios_laborales, $horarios_ocupados);

    echo json_encode([
        "profesional_id" => $profesional_id,
        "fecha" => $fecha,
        "horarios_disponibles" => array_values($horarios_disponibles)
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}
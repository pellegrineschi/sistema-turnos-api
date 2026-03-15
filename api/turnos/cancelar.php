<?php

header('Content-Type: application/json');
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "ID del turno requerido"
    ]);
    exit;
}

try {

    $sql = "UPDATE turnos
            SET estado = 'cancelado'
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Turno cancelado correctamente"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}
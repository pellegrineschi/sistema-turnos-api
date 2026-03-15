<?php

header("content-type: application/json");
require_once "../../config/database.php";

try {

    $sql = "SELECT 
                t.id,
                u.nombre AS usuario_nombre,
                p.nombre AS profesional,
                t.fecha_hora,
                t.estado
            FROM turnos t
            JOIN usuarios u ON t.usuario_id = u.id
            JOIN profesionales p ON t.profesional_id = p.id
            ORDER BY t.fecha_hora";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $turnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($turnos);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
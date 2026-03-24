<?php

header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $sql = "SELECT id, nombre, especialidad FROM profesionales";
    $stmt = $conn->query($sql);

    $profesionales = $stmt-> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($profesionales);
}catch (PDOException $e){
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
<?php

$host = "localhost";
$port = "5432";
$dbname = "sistema_turnos";
$user = "turnos_user";
$password = "123456";

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);

        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Conexión exitosa a la base de datos";

} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}
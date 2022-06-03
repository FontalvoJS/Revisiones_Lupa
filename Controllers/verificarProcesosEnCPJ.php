<?php
$_GET = json_decode(file_get_contents('php://input'), true);
require 'conexion.php';

$procesos = $_GET['procesos'];
$resultadosNoCPJ = [];

for ($i = 1; $i < count($procesos); $i++) {
    $consulta = "SELECT `cpj_proceso` FROM `lupa_cpj` WHERE `cpj_rama_proceso` = '$procesos[$i]'";
    $result = $pdo->prepare($consulta);
    $result->execute();
    $numero_filas = $result->rowCount();
    if ($numero_filas <= 0 || $numero_filas == null) {
        $resultadosNoCPJ[$i] = $procesos[$i];
    }
}

$resultadosNoCPJ = array_values(array_unique($resultadosNoCPJ));
echo json_encode($resultadosNoCPJ, JSON_PRETTY_PRINT);

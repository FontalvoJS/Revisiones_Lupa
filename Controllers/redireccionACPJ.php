<?php
require 'conexion.php';
$_GET = json_decode(file_get_contents('php://input'), true);
if ($_GET['procesos']) {

    // VERIFICAR QUE EL CODIGO23 SE ENCUENTRE EN LUPA_CPJ 
    $proceso[0] = $_GET['procesos'];

    $estado_departamento = [];
    $estado_municipio = [];
    $estado_entidad = [];
    $estado_especialidad = [];
    $estado_despacho = [];

    $estructuraProceso = [];

    $idEncontrado = 0;


    for ($i = 0; $i < count($proceso); $i++) {
        if (isset($proceso[$i])) {
            $procesosArray[$i] = str_split($proceso[$i], 1);
            $estado_departamento[$i] = $procesosArray[$i][0] . $procesosArray[$i][1];
            $estado_municipio[$i] = $procesosArray[$i][2] . $procesosArray[$i][3] . $procesosArray[$i][4];
            $estado_entidad[$i] = $procesosArray[$i][5] . $procesosArray[$i][6];
            $estado_especialidad[$i] = $procesosArray[$i][7] . $procesosArray[$i][8];
            $estado_despacho[$i] = $procesosArray[$i][9] . $procesosArray[$i][10] . $procesosArray[$i][11];
            $estructuraProceso[$i] = ["Departamento" => $estado_departamento[$i], "Municipio" => $estado_municipio[$i], "Entidad" => $estado_entidad[$i], "Especialidad" => $estado_especialidad[$i], "Despacho" => $estado_despacho[$i]];
        }
    }
    $consulta = "SELECT id FROM lupa_despacho WHERE despacho_departamento = '" . $estructuraProceso[0]['Departamento'] . "' 
    AND despacho_municipio = '" . $estructuraProceso[0]['Municipio'] . "' 
    AND despacho_entidad = '" . $estructuraProceso[0]['Entidad'] . "' 
    AND despacho_especialidad = '" . $estructuraProceso[0]['Especialidad'] . "' 
    AND despacho_despacho = '" . $estructuraProceso[0]['Despacho'] . "'";
    $resultado = $pdo->prepare($consulta);
    $resultado->execute();
    $num_rows = $resultado->rowCount();
    if ($num_rows > 0) {
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo $resultado[0]['id'];
    } else {
        echo "false";
    }
}

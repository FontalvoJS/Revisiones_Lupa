<?php

// estado_departamento = 2 primeros digitos
// estado_municipio = 3 primeros digitos, luego de dos digitos el codigo de departamento
// estado_entidad = 2 primeros digitos, luego de tres digitos el codigo de municipio
// estado_especialidad = 2 primeros digitos, luego de dos digitos el codigo de entidad
// estado_despacho = 3 primeros digitos, luegos de dos digitos el codigo de especialidad

$_GET = json_decode(file_get_contents('php://input'), true);
require 'conexion.php';
$procesos = $_GET['procesos'];
$despachos = $_GET['despachos'];
$desd = $_GET['desde'];
$hast = $_GET['hasta'];
$desde2 = str_replace("Desde: ", "", $desd);
$hasta2 = str_replace("Hasta: ", "", $hast);
$procesosArray = [];
$estado_departamento = [];
$estado_municipio = [];
$estado_entidad = [];
$estado_especialidad = [];
$estado_despacho = [];
$estructuraProceso = [];
$estructuraProcesoCPJ = [];
$result = [];
$procesosCPJ = [];
$exportar = [];
$resultadosCPJ = [];
$despachosyprocesos = [];

for ($i = 0; $i < count($procesos); $i++) {
    if (isset($procesos[$i])) {
        $procesosArray[$i] = str_split($procesos[$i], 1);
        $estado_departamento[$i] = $procesosArray[$i][0] . $procesosArray[$i][1];
        $estado_municipio[$i] = $procesosArray[$i][2] . $procesosArray[$i][3] . $procesosArray[$i][4];
        $estado_entidad[$i] = $procesosArray[$i][5] . $procesosArray[$i][6];
        $estado_especialidad[$i] = $procesosArray[$i][7] . $procesosArray[$i][8];
        $estado_despacho[$i] = $procesosArray[$i][9] . $procesosArray[$i][10] . $procesosArray[$i][11];
        $despachosyprocesos = array_merge($despachosyprocesos, array($procesos[$i] => $despachos[$i]));
        $estructuraProceso[$i] = ["Proceso" => $procesos[$i], "Departamento" => $estado_departamento[$i], "Municipio" => $estado_municipio[$i], "Entidad" => $estado_entidad[$i], "Especialidad" => $estado_especialidad[$i], "Despacho" => $estado_despacho[$i]];
    }
}
for ($i = 1; $i < count($estructuraProceso); $i++) {
    $consulta = "SELECT `cpj_proceso` FROM `lupa_cpj` WHERE `cpj_rama_proceso` = '$procesos[$i]'";
    $result = $pdo->prepare($consulta);
    $result->execute();
    if ($result->rowCount() > 0) {
        $result = $result->fetch(PDO::FETCH_ASSOC);
        $procesosCPJ[$i] = $result['cpj_proceso'];
    }
}
for ($i = 1; $i < count($procesosCPJ); $i++) {
    $procesosArray[$i] = str_split($procesosCPJ[$i], 1);
    $estado_departamento[$i] = $procesosArray[$i][0] . $procesosArray[$i][1];   // 2 primeros digitos
    $estado_municipio[$i] = $procesosArray[$i][2] . $procesosArray[$i][3] . $procesosArray[$i][4];   // 3 primeros digitos, luego de dos digitos el codigo de departamento
    $estado_entidad[$i] = $procesosArray[$i][5] . $procesosArray[$i][6];   // 2 primeros digitos, luego de tres digitos el codigo de municipio
    $estado_especialidad[$i] = $procesosArray[$i][7] . $procesosArray[$i][8];   // 2 primeros digitos, luego de dos digitos el codigo de entidad
    $estado_despacho[$i] = $procesosArray[$i][9] . $procesosArray[$i][10] . $procesosArray[$i][11];   // 3 primeros digitos, luegos de dos digitos el codigo de especialidad
    $estructuraProcesoCPJ[$i] = ["Proceso" => $procesosCPJ[$i], "Departamento" => $estado_departamento[$i], "Municipio" => $estado_municipio[$i], "Entidad" => $estado_entidad[$i], "Especialidad" => $estado_especialidad[$i], "Despacho" => $estado_despacho[$i]];
}
for ($i = 1; $i < count($estructuraProcesoCPJ); $i++) {
    $consulta = "SELECT `estado_estado`,`estado_fecha_estado` FROM `lupa_estado` WHERE `estado_fecha_estado` BETWEEN '" . $desde2 . "' AND '" . $hasta2 . "' AND  `estado_departamento` =
     '" . $estructuraProcesoCPJ[$i]['Departamento'] . "' AND `estado_municipio` = 
     '" . $estructuraProcesoCPJ[$i]['Municipio'] . "' AND `estado_entidad` = 
     '" . $estructuraProcesoCPJ[$i]['Entidad'] . "' AND `estado_especialidad` = 
     '" . $estructuraProcesoCPJ[$i]['Especialidad'] . "' AND `estado_despacho` =  
     '" . $estructuraProcesoCPJ[$i]['Despacho'] . "' AND `estado_estado` >= '0000' ";
    $result = $pdo->prepare($consulta);
    $result->execute();
    $resultado = $result->fetch(PDO::FETCH_ASSOC);
    if ($result->rowCount() > 0) {
        if ($despachosyprocesos[$procesosCPJ[$i]]) {
            $resultadosCPJ[$i] = $despachosyprocesos[$procesosCPJ[$i]] . " <span class='badge bg-danger' style='color:whitesmoke;float:right'>" . $resultado['estado_estado'] . " - " . $resultado['estado_fecha_estado'] . "</span>";
        }
    }
}

$resultadosCPJ = array_values(array_unique($resultadosCPJ));
echo json_encode($resultadosCPJ, JSON_PRETTY_PRINT);

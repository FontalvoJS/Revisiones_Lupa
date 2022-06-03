<?php
require_once '../Class/ctr_filtro.php';

$ctr_filtro = new filtroRevisiones();
$result = $ctr_filtro->traerDespachosAuto();
$proceso = [];
$despacho = [];

for ($i = 0; $i < count($result); $i++) {
    // GUARDO EL PROCESO Y DESPACHO QUE TRAE LA CONSULTA
    $proceso[$i] = $result[$i]['codigo23'];
    $despacho[$i] = $result[$i]['Resumen']['despacho'];
}

// LLAMO LA FUNCIÓN PARA VERIFICAR SI EL PROCESO Y EL DESPACHO ESTÁN EN LA LISTA DE DESPACHOS QUE PUBLICARON
despachosQuePublicaron($proceso, $despacho);

function despachosQuePublicaron($proceso, $despachos)
{
    require '../../librerias_2017/Telegram_Class.php';
    require_once 'conexion.php';
    $estructuraProceso = [];
    $hoy = date("Y-m-d");
    $hoy2 = date("Y-m-d-H-i-s");
    $resultados = [];
    $sinRegistros = [];
    $proceso = array_values(array_unique($proceso));

    // EXTRAIGO LOS 12 NUMEROS DEL JUZGADO DE CADA PROCESO  
    for ($i = 0; $i < count($proceso); $i++) {
        $procesosArray[$i] = str_split($proceso[$i], 1);
        $estado_departamento[$i] = $procesosArray[$i][0] . $procesosArray[$i][1];   // 2 primeros digitos
        $estado_municipio[$i] = $procesosArray[$i][2] . $procesosArray[$i][3] . $procesosArray[$i][4];   // 3 primeros digitos, luego de dos digitos el codigo de departamento
        $estado_entidad[$i] = $procesosArray[$i][5] . $procesosArray[$i][6];   // 2 primeros digitos, luego de tres digitos el codigo de municipio
        $estado_especialidad[$i] = $procesosArray[$i][7] . $procesosArray[$i][8];   // 2 primeros digitos, luego de dos digitos el codigo de entidad
        $estado_despacho[$i] = $procesosArray[$i][9] . $procesosArray[$i][10] . $procesosArray[$i][11];   // 3 primeros digitos, luegos de dos digitos el codigo de especialidad

        // SI EL DESPACHO ES 000 LO CONVIERTE A 001 | SOLO PARA (05 001 23 33 000)
        if ($estado_departamento[$i] == '05' && $estado_municipio[$i] == '001' && $estado_entidad[$i] == '23' && $estado_especialidad[$i] == '33' && $estado_despacho[$i] == '000') {
            $estado_despacho[$i] = '001';
        }

        // ESTRUCTURA COMPLETA DE UN JUZGADO
        $estructuraProceso[$i] = ["Departamento" => $estado_departamento[$i], "Municipio" => $estado_municipio[$i], "Entidad" => $estado_entidad[$i], "Especialidad" => $estado_especialidad[$i], "Despacho" => $estado_despacho[$i]];
    }

    $estructuraProceso = array_values($estructuraProceso);
    $despachos = array_values(array_unique($despachos));
    $despachosSinNombres = [];


    // CONSULTA SI EL DESPACHO ESTÁ EN LA LISTA DE DESPACHOS QUE PUBLICARON, GUARDA LOS QUE NO TIENEN REGISTROS
    for ($i = 0; $i < count($despachos); $i++) {
        $consulta = "SELECT `estado_estado` FROM `lupa_estado` 
        WHERE `estado_fecha_estado` = '$hoy' AND  `estado_departamento` =
         '" . $estructuraProceso[$i]['Departamento'] . "' AND `estado_municipio` = 
         '" . $estructuraProceso[$i]['Municipio'] . "' AND `estado_entidad` = 
         '" . $estructuraProceso[$i]['Entidad'] . "' AND `estado_especialidad` = 
         '" . $estructuraProceso[$i]['Especialidad'] . "' AND `estado_despacho` =  
         '" . $estructuraProceso[$i]['Despacho'] . "' AND `estado_estado` >= '0000'";
        $result = $pdo->prepare($consulta);
        $result->execute();
        $num_rows = $result->rowCount();
        // SI NO TIENE REGISTROS CONSULTA EL NOMBRE DEL DESPACHO EN LUPA_DESPACHO
        if ($num_rows <= 0) {
            $consulta2 = "SELECT despacho_descripcion_completa, despacho_municipio, despacho_entidad, despacho_especialidad, despacho_despacho, despacho_departamento FROM lupa_despacho 
            WHERE despacho_departamento = '" . $estructuraProceso[$i]['Departamento'] . "' 
            AND despacho_municipio = '" . $estructuraProceso[$i]['Municipio'] . "' 
            AND despacho_entidad = '" . $estructuraProceso[$i]['Entidad'] . "' 
            AND despacho_especialidad = '" . $estructuraProceso[$i]['Especialidad'] . "' 
            AND despacho_despacho = '" . $estructuraProceso[$i]['Despacho'] . "'";
            $result2 = $pdo->prepare($consulta2);
            $result2->execute();
            if ($result2->rowCount() > 0) {
                $row = $result2->fetch(PDO::FETCH_ASSOC);
                $sinRegistros[$i] = $row['despacho_descripcion_completa'];
                $despachosSinNombres[$i]['Departamento'] = $row['despacho_departamento'];
                $despachosSinNombres[$i]['Municipio'] = $row['despacho_municipio'];
                $despachosSinNombres[$i]['Entidad'] = $row['despacho_entidad'];
                $despachosSinNombres[$i]['Especialidad'] = $row['despacho_especialidad'];
                $despachosSinNombres[$i]['Despacho'] = $row['despacho_despacho'];
            }
        }
    }
    $despachosSinNombres = array_values(array_unique($despachosSinNombres, SORT_REGULAR));
    $sinRegistros = array_values(array_unique($sinRegistros));
    if (count($sinRegistros) > 0) {
        // SE CREA UN ARCHIVO DE TEXTO EN LA CARPETA LOGS
        for ($i = 0; $i < count($sinRegistros); $i++) {
            $file = fopen("../Logs/despachos_Sin_Publicar_" . $hoy2 . ".txt", "a");
            fwrite($file, "========================================" . PHP_EOL);
            fwrite($file, $i . ") " . $despachosSinNombres[$i]['Departamento'] .  $despachosSinNombres[$i]['Municipio'] .  $despachosSinNombres[$i]['Entidad'] .  $despachosSinNombres[$i]['Especialidad'] .  $despachosSinNombres[$i]['Despacho'] . " - " . $sinRegistros[$i]   . PHP_EOL);
            fclose($file);
        }
    } else {
        $file = fopen("../Logs/despachos_Sin_Publicar_" . $hoy2 . ".txt", "a");
        fwrite($file, "========================================" . PHP_EOL);
        fwrite($file, "NO HAY DESPACHOS QUE NO HAYAN PUBLICADO" . PHP_EOL);
        fclose($file);
    }
    // SE ENVÍA EL ARCHIVO AL GRUPO DE TELEGRAM
    $obj_tel = new Telegram();
    $obj_tel->Enviar_Archivo("-1001653292188", "../Logs/despachos_Sin_Publicar_" . $hoy2 . ".txt");
}

<?php


set_time_limit(300);
// ESTON FIJACIONES DE ESTADO
require_once '../Class/ctr_filtro.php';
$proceso = [];
$ctr_filtro = new filtroRevisiones();
$result = $ctr_filtro->traerDespachosAuto();
for ($i = 0; $i < count($result); $i++) {
    // GUARDO EL PROCESO DE CADA DESPACHO QUE TRAE LA CONSULTA
    $proceso[$i] = $result[$i]['codigo23'];
}


// PASO LOS PROCESOS A LA FUNCIÓN QUE SE ENCARGA DE ACTUALIZAR LAS PRIORIDADES
priorizarDespachos($proceso, $despacho);


function priorizarDespachos($procesos)
{
    require '../../librerias_2017/Telegram_Class.php';
    $obj_tel = new Telegram();
    require_once 'conexion.php';
    $despachosConsultados = [];
    $hoy = date("Y-m-d");
    $hoy2 = date("Y-m-d H-i-s");

    echo "Priorizando despachos el día: " . $hoy . "<br><br>";

    // EXTRAE LOS DESPACHOS DE LOS PROCESOS
    for ($i = 0; $i < count($procesos); $i++) {
        if (isset($procesos[$i])) {
            $procesosArray[$i] = str_split($procesos[$i], 1);
            $estado_departamento[$i] = $procesosArray[$i][0] . $procesosArray[$i][1];
            $estado_municipio[$i] = $procesosArray[$i][2] . $procesosArray[$i][3] . $procesosArray[$i][4];
            $estado_entidad[$i] = $procesosArray[$i][5] . $procesosArray[$i][6];
            $estado_especialidad[$i] = $procesosArray[$i][7] . $procesosArray[$i][8];
            $estado_despacho[$i] = $procesosArray[$i][9] . $procesosArray[$i][10] . $procesosArray[$i][11];
            $estructuraProceso[$i] = ["Departamento" => $estado_departamento[$i], "Municipio" => $estado_municipio[$i], "Entidad" => $estado_entidad[$i], "Especialidad" => $estado_especialidad[$i], "Despacho" => $estado_despacho[$i]];
        }
    }
    $estructuraProceso = array_values(array_unique($estructuraProceso, SORT_REGULAR));
    // LO GUARDA EN $estructuraProceso --------------------------------------------



    $total = 0;
    // CONSULTA EL NOMBRE DE LOS DESPACHOS QUE FIJARON ESTADOS Y GUARDO EL NOMBRE DEL DESPACHO
    for ($j = 0; $j < count($estructuraProceso); $j++) {
        $sql = "SELECT despacho_descripcion_completa  FROM lupa_despacho
    WHERE despacho_departamento = '" . $estructuraProceso[$j]['Departamento'] . "'
    AND despacho_municipio = '" . $estructuraProceso[$j]['Municipio'] . "' 
    AND despacho_entidad = '" . $estructuraProceso[$j]['Entidad'] . "' 
    AND despacho_especialidad = '" . $estructuraProceso[$j]['Especialidad'] . "' 
    AND despacho_despacho = '" . $estructuraProceso[$j]['Despacho'] . "'";
        $result = $pdo->prepare($sql);
        $result->execute();
        $num_rows = $result->rowCount();
        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        if ($num_rows > 0) {
            $total = $total + 1;
            $despachosConsultados[$j] = $resultado['despacho_descripcion_completa'];
        } else {
            $despachosConsultados[$j] = " -No se encuentra este despacho en la base de datos- | Despacho: " . $estructuraProceso[$j]['Departamento'] . $estructuraProceso[$j]['Municipio'] . $estructuraProceso[$j]['Entidad'] . $estructuraProceso[$j]['Especialidad'] . $estructuraProceso[$j]['Despacho'];
        }
    }
    // LO GUARDA EN $despachosConsultados --------------------------------------------




    $despachosConsultados = array_values(array_unique($despachosConsultados));
    $totalDespachos = count($despachosConsultados);

    echo "Despachos encontrados con fijación de estado: " . $totalDespachos . "<br>";

    for ($j = 0; $j < count($estructuraProceso); $j++) {
        $sql = "UPDATE lupa_despacho set prioridad = '1'
        WHERE despacho_departamento = '" . $estructuraProceso[$j]['Departamento'] . "'
        AND despacho_municipio = '" . $estructuraProceso[$j]['Municipio'] . "'
        AND despacho_entidad = '" . $estructuraProceso[$j]['Entidad'] . "'
        AND despacho_especialidad = '" . $estructuraProceso[$j]['Especialidad'] . "'
        AND despacho_despacho = '" . $estructuraProceso[$j]['Despacho'] . "' ";
        $result = $pdo->prepare($sql);
        $result->execute();
        if ($result) {
            if ($j < $totalDespachos) {
                $file = fopen("../Logs/despachos_priorizados_" . $hoy2 . ".txt", "a");
                fwrite($file, "||========================================" . PHP_EOL);
                fwrite($file, $j . ") " . $estructuraProceso[$j]['Departamento'] .  $estructuraProceso[$j]['Municipio'] .  $estructuraProceso[$j]['Entidad'] .  $estructuraProceso[$j]['Especialidad'] .  $estructuraProceso[$j]['Despacho'] . " - " . $despachosConsultados[$j]   . PHP_EOL);
                fclose($file);
            }
        }
    }
    $obj_tel->Enviar_Archivo("-1001653292188", "../Logs/despachos_priorizados_" . $hoy2 . ".txt");
}

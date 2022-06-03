<?php
ini_set('max_execution_time', 300);
require_once '../Class/ctr_filtro.php';
if (isset($_GET['cod23'])) {
    $cod23 = $_GET['cod23'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorCodigo($cod23);
    require_once '../Views/codigoSeleccionadoFiltro.php';
} else {
    echo "No se han recibido los datos";
}

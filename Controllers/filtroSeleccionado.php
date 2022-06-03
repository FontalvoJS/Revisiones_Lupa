<?php
require_once '../Class/ctr_filtro.php';


// desde - hasta - actuaciones - anotaciones - llave 
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && isset($_GET['act']) && isset($_GET['anotaciones']) && !isset($_GET['ok'])
    && !isset($_GET['codigo23'])
) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $act = $_GET['act'];
    $anotaciones = $_GET['anotaciones'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoActYAnots($fecha_inicio, $fecha_fin, $tipoBusqueda, $act, $anotaciones);
    if (isset($result)) {
        require_once '../Views/procesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - llave - actuaciones
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && isset($_GET['act']) &&  !isset($_GET['anotaciones']) && !isset($_GET['ok'])
    && !isset($_GET['codigo23'])

) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $act = $_GET['act'];

    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYAct($fecha_inicio, $fecha_fin, $tipoBusqueda, $act);
    if (isset($result)) {
        require_once '../Views/procesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - llave - anotaciones
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && !isset($_GET['act']) &&  isset($_GET['anotaciones']) && !isset($_GET['ok'])
    && !isset($_GET['codigo23'])

) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $anotaciones = $_GET['anotaciones'];

    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYAnots($fecha_inicio, $fecha_fin, $tipoBusqueda, $anotaciones);
    if (isset($result)) {
        require_once '../Views/procesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - llave - codigo23
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && isset($_GET['codigo23']) &&  !isset($_GET['anotaciones']) &&  !isset($_GET['act']) && !isset($_GET['ok'])
) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $codigo23 = $_GET['codigo23'];

    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYCod23($fecha_inicio, $fecha_fin, $tipoBusqueda, $codigo23);
    if (isset($result)) {
        require_once '../Views/procesos.php';
    } else {
        require_once '../Views/error.html';
    }
}


// desde - hasta - llave 
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && !isset($_GET['act']) && !isset($_GET['anotaciones']) && !isset($_GET['ok'])
    && !isset($_GET['codigo23'])

) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];

    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYLlave($fecha_inicio, $fecha_fin, $tipoBusqueda);
    if (isset($result)) {
        require_once '../Views/procesos.php';
    } else {
        require_once '../Views/error.html';
    }
}
// =========================================================

// desde - hasta - actuaciones - anotaciones - llave - detallesProceso.php
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && isset($_GET['act']) && isset($_GET['anotaciones']) && isset($_GET['ok'])
    && !isset($_GET['codigo23'])
) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $act = $_GET['act'];
    $anotaciones = $_GET['anotaciones'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoActYAnots2($fecha_inicio, $fecha_fin, $tipoBusqueda, $act, $anotaciones);
    if (isset($result)) {
        require_once '../Views/detallesProcesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - actuaciones - llave - detallesProceso.php
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && isset($_GET['act']) && !isset($_GET['anotaciones']) && isset($_GET['ok']) && !isset($_GET['codigo23'])
) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $act = $_GET['act'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYAct2($fecha_inicio, $fecha_fin, $tipoBusqueda, $act);
    if (isset($result)) {
        require_once '../Views/detallesProcesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - llave - detallesProceso.php
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && !isset($_GET['act']) && !isset($_GET['anotaciones']) && isset($_GET['ok'])
    && !isset($_GET['codigo23'])

) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYLlave2($fecha_inicio, $fecha_fin, $tipoBusqueda);
    if (isset($result)) {
        require_once '../Views/detallesProcesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - llave - anotaciones - detallesProceso.php
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && !isset($_GET['act']) && isset($_GET['anotaciones']) && isset($_GET['ok'])
    && !isset($_GET['codigo23'])
) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $anotaciones = $_GET['anotaciones'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYAnots2($fecha_inicio, $fecha_fin, $tipoBusqueda, $anotaciones);
    if (isset($result)) {
        require_once '../Views/detallesProcesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

// desde - hasta - llave - codigo23 - detallesProceso.php
if (
    isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['llave'])
    && !isset($_GET['act']) && !isset($_GET['anotaciones']) && isset($_GET['ok'])
    && isset($_GET['codigo23'])
) {
    $fecha_inicio = $_GET['desde'];
    $fecha_fin = $_GET['hasta'];
    $tipoBusqueda = $_GET['llave'];
    $codigo23 = $_GET['codigo23'];
    $clase = new filtroRevisiones();
    $result = $clase->revisionPorRangoYCod232($fecha_inicio, $fecha_fin, $tipoBusqueda, $codigo23);
    if (isset($result)) {
        require_once '../Views/detallesProcesos.php';
    } else {
        require_once '../Views/error.html';
    }
}

<?php
require '../../prueba_laboratorio/services/RamaExtract/app/controllers/ctr_general.php';
class filtroRevisiones extends ControllerGeneral
{
    function __construct()
    {
        parent::__construct();
    }

    function traerDespachosAuto()
    {
        $resultado = $this->Model->inicioTerminoFijacionEstado();
        return $resultado;
    }
    // ================================

    function revisionesTrue($procesos)
    {
        $resultado = $this->Model->revisionesTrue($procesos);
        return $resultado;
    }
    // ================================

    function revisionPorRangoYCod23($fecha_inicio, $fecha_fin, $tipoBusqueda, $cod23)
    {
        $resultado = $this->Model->traerProcesosPorRangoYCod23($fecha_inicio, $fecha_fin, $tipoBusqueda, $cod23);
        return $resultado;
    }

    function revisionPorRangoYCod232($fecha_inicio, $fecha_fin, $tipoBusqueda, $cod23)
    {
        $resultado = $this->Model->traerProcesosPorRangoYCod232($fecha_inicio, $fecha_fin, $tipoBusqueda, $cod23);
        return $resultado;
    }

    // ================================
    function revisionPorRangoYAct($fecha_inicio, $fecha_fin, $tipoBusqueda, $act)
    {
        $resultado = $this->Model->traerProcesosPorRangoYAct($fecha_inicio, $fecha_fin, $tipoBusqueda, $act);
        return $resultado;
    }

    // ================================
    function revisionPorRangoYAct2($fecha_inicio, $fecha_fin, $tipoBusqueda, $act)
    {
        $resultado = $this->Model->traerProcesosPorRangoYAct2($fecha_inicio, $fecha_fin, $tipoBusqueda, $act);
        return $resultado;
    }
    // ================================

    function revisionPorRangoActYAnots($fecha_inicio, $fecha_fin, $tipoBusqueda, $act, $anotaciones)
    {
        $resultado = $this->Model->traerProcesosPorRangoActYAnots($fecha_inicio, $fecha_fin, $tipoBusqueda, $act, $anotaciones);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    function revisionPorRangoActYAnots2($fecha_inicio, $fecha_fin, $tipoBusqueda, $act, $anotaciones)
    {
        $resultado = $this->Model->traerProcesosPorRangoActYAnots2($fecha_inicio, $fecha_fin, $tipoBusqueda, $act, $anotaciones);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    // ================================

    function revisionPorRangoYLlave($fecha_inicio, $fecha_fin, $tipoBusqueda)
    {
        $resultado = $this->Model->traerProcesosPorRangoYLlave($fecha_inicio, $fecha_fin, $tipoBusqueda);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    function revisionPorRangoYLlave2($fecha_inicio, $fecha_fin, $tipoBusqueda)
    {
        $resultado = $this->Model->traerProcesosPorRangoYLlave2($fecha_inicio, $fecha_fin, $tipoBusqueda);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    // ================================

    function revisionPorRangoYAnots($fecha_inicio, $fecha_fin, $tipoBusqueda,  $anotaciones)
    {
        $resultado = $this->Model->traerProcesosPorRangoYAnot($fecha_inicio, $fecha_fin, $tipoBusqueda, $anotaciones);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    function revisionPorRangoYAnots2($fecha_inicio, $fecha_fin, $tipoBusqueda,  $anotaciones)
    {
        $resultado = $this->Model->traerProcesosPorRangoYAnot($fecha_inicio, $fecha_fin, $tipoBusqueda, $anotaciones);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    // ================================

    function revisionPorCodigo($cod23)
    {
        $resultado = $this->Model->codigoSeleccionado($cod23);
        if (isset($resultado) && !empty($resultado)) {
            return $resultado;
        }
    }
    function datosCodigoSeleccionado()
    {

        if (isset($_GET['cod23'])) {
            $cod = $_GET['cod23'];
            $resultado = $this->Model->codigoSeleccionadoFiltro($cod);
            return $resultado;
        }
    }
}

<?php
require '../Class/ctr_filtro.php';
$filtro = new filtroRevisiones();
$_POST = json_decode(file_get_contents('php://input'), true);
$procesos = $_POST['procesos'];
$result = $filtro->revisionesTrue($procesos);
echo json_encode($result, JSON_PRETTY_PRINT);

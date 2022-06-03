<?php

define("SERVIDOR", "localhost");
define("USUARIO", "des_controles");
define("PASSWORD", "D3s4rr0ll0-651!!");
define("BD", "db_lupajuridica");


$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO(
        $servidor,
        USUARIO,
        PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
} catch (PDOException $e) {
    echo "Error en la conexion de la base de datos" . " " . $e;
}

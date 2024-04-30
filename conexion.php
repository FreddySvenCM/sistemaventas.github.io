<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "sistemaventas";
    $port = "3306";
    $conexion = new MySQLi($hostname, $username, $password, $database, $port);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $conexion->set_charset('utf8');
    date_default_timezone_set("America/La_Paz");
?>

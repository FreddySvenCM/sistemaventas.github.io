<?php
require "conexion.php";
if (!empty($_POST["btnregistrar"])) {
    if (isset($_FILES["imagen"]) && !empty($_FILES["imagen"]["tmp_name"])) {
        $imagen = $_FILES["imagen"]["tmp_name"];
        $nombreImagen = $_FILES["imagen"]["name"];
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        $directorio = "archivos/";
        $nombreUnico = uniqid() . '_' . $nombreImagen;
        $ruta = $directorio . $nombreUnico;
        if (move_uploaded_file($imagen, $ruta)) {
            $nombre = $_POST["nombre"];
            $cantidad = $_POST["cantidad"];
            $precio = $_POST["precio"];
            $insertarDatos = $conexion->query("INSERT INTO img (foto, nombre, cantidad, precio) VALUES ('$ruta', '$nombre', '$cantidad', '$precio')");

            if ($insertarDatos) {
                echo "<div class='alert alert-success'>Imagen registrada exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al registrar la imagen en la base de datos.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error al mover la imagen al servidor.</div>";
        }
    } else {
        $nombre = $_POST["nombre"];
        $cantidad = $_POST["cantidad"];
        $precio = $_POST["precio"];
        $insertarDatos = $conexion->query("INSERT INTO img (nombre, cantidad, precio) VALUES ('$nombre', '$cantidad', '$precio')");
        if ($insertarDatos) {
            echo "<div class='alert alert-success'>Datos registrados exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar los datos en la base de datos.</div>";
        }
    }
}
?>

<script>
    history.replaceState(null, null, location.pathname);
    location.href = "index.php";
</script>
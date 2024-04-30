<?php
if (!empty($_POST["btneditar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $imagen = $_FILES["imagen"]["tmp_name"];
    $nombreImagen = $_FILES["imagen"]["name"];
    $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
    $directorio = "archivos/";
    if (is_file($imagen)) {
        if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
            try {
                unlink($nombre);
            } catch (\Throwable $th) {
            }
            $ruta = $directorio . $id . "." . $tipoImagen;

            if (move_uploaded_file($imagen, $ruta)) {
                $editar = $conexion->query("UPDATE img SET foto='$ruta', nombre='{$_POST["nombre"]}', cantidad='{$_POST["cantidad"]}', precio='{$_POST["precio"]}' WHERE id_img=$id");
                if ($editar == 1) {
                    echo "<div class='alert alert-success'>La imagen se ha editado correctamente</div>";
                } else {
                    echo "<div class='alert alert-info'>Error al editar la imagen</div>";
                }
            } else {
                echo "<div class='alert alert-info'>Error al subir la imagen al servidor</div>";
            }
        } else {
            echo "<div class='alert alert-info'>No se acepta ese formato. Solo se permiten archivos JPG, JPEG y PNG.</div>";
        }
    } else {
        echo "<div class='alert alert-info'>Debe seleccionar una imagen</div>";
    }
    ?>
    <script>
        history.replaceState(null, null, location.pathname);
        location.href = "index.php";
    </script>
<?php } ?>

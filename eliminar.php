<?php
include("conexion.php");
if (isset($_GET["id_img"])) {
    $id_img = $_GET["id_img"];
    $consulta_eliminar = "DELETE FROM img WHERE id_img = ?";
    $stmt_eliminar = $conexion->prepare($consulta_eliminar);
    if (!$stmt_eliminar) {
        echo "<div class='alert alert-danger'>Error al preparar la consulta de eliminación: " . $conexion->error . "</div>";
    } else {
        $stmt_eliminar->bind_param("i", $id_img);
        $resultado_eliminar = $stmt_eliminar->execute();

        if ($resultado_eliminar) {
            echo "<div class='alert alert-success'>El registro se ha eliminado correctamente</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el registro: " . $stmt_eliminar->error . "</div>";
        }
        $stmt_eliminar->close();
    }
    echo "<script>location.href = 'index.php';</script>";
}
?>

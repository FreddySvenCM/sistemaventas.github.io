<?php
include("conexion.php");
$resultados = "";
if (!empty($_POST["buscar"])) {
    $buscar = mysqli_real_escape_string($conexion, $_POST['buscar']);
    $consulta = "SELECT id_img, foto, nombre, cantidad, precio FROM img
                 WHERE foto LIKE '%$buscar%' OR
                       nombre LIKE '%$buscar%' OR
                       cantidad LIKE '%$buscar%' OR
                       precio LIKE '%$buscar%'
                 ORDER BY id_img";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $resultados .= "<table class='table table-bordered'>
                            <tr> 
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>";
        while ($fila = mysqli_fetch_array($resultado)) {
            $resultados .= "<tr>
                                <td>$fila[0]</td>
                                <td><img src='$fila[1]' alt='Imagen' width='100'></td>
                                <td>$fila[2]</td>
                                <td>$fila[3]</td>
                                <td>$fila[4]</td>
                                <td><a href='editar.php?id=$fila[0]&nombre=$fila[2]&cantidad=$fila[3]&precio=$fila[4]'>Editar</a></td>
                                <td><a href='eliminar.php?id=$fila[0]'>Eliminar</a></td>
                            </tr>";
        }
        $resultados .= "</table>";
    } else {
        $resultados = "<div class='alert alert-info'>No se encontraron resultados para la búsqueda: '$buscar'</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Buscar..." name="buscar">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
                <?php echo $resultados; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

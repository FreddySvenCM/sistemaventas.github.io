<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center text-secondary font-weight-bold p-4">REGISTRO DE PRODUCTOS</h1>
    <?php
  $imagenAnterior = "default_image.jpg";
  require "conexion.php";
  require "buscar.php";
    if (!empty($_POST["btneditar"])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $cantidad = $_POST["cantidad"];
        $precio = $_POST["precio"];
        $imagen = $_FILES["imagen"]["tmp_name"];
        $nombreImagen = $_FILES["imagen"]["name"];
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        $directorio = "archivos/";
        if (!empty($imagen)) {
            $datos = $conexion->query("SELECT * FROM img WHERE id_img=$id")->fetch_object();
            $imagenAnterior = $datos->foto;
            unlink($imagenAnterior);
            $ruta = $directorio . $id . "." . $tipoImagen;
            move_uploaded_file($imagen, $ruta);
        } else {
            $ruta = $imagenAnterior;
        }
        $editar = $conexion->query("UPDATE img SET foto='$ruta', nombre='$nombre', cantidad='$cantidad', precio='$precio' WHERE id_img=$id");
        if ($editar) {
            echo "<div class='alert alert-success'>La imagen se ha editado correctamente</div>";
        } else {
            echo "<div class='alert alert-info'>Error al editar la imagen</div>";
        }
    }
    $sql = $conexion->query("SELECT * FROM img");
    ?>
    <script>
        function eliminar() {
            let res = confirm("¿Estás seguro de eliminar?")
            return res;
        }
    </script>
    <div class="p-3 table-responsive">
        <div>
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Registrar
            </button>
        <table class="table table-hover table-stripped">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col" class="text-white">ID</th>
                    <th scope="col" class="text-white">Foto</th>
                    <th scope="col" class="text-white">Nombre</th>
                    <th scope="col" class="text-white">Cantidad</th>
                    <th scope="col" class="text-white">Precio</th>
                    <th scope="col" class="text-white">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($datos = $sql->fetch_object()) { ?>
                    <tr>
                        <th scope="row"><?php echo $datos->id_img ?></th>
                        <td><img src="<?php echo $datos->foto ?>" alt="Foto" width="100"></td>
                        <td><?php echo $datos->nombre ?></td>
                        <td><?php echo $datos->cantidad ?></td>
                        <td><?php echo $datos->precio ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalEditar<?php echo $datos->id_img ?>">Editar</button>
                            <a href='eliminar.php?id_img=<?= $datos->id_img ?>' class='btn btn-danger' onclick='return eliminar()'>Eliminar</a>
                        </td>
                    </tr>   
                    <div class="modal fade" id="exampleModalEditar<?php echo $datos->id_img ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edición de Registro</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" enctype="multipart/form-data" method="POST">
                                        <input type="hidden" value="<?php echo $datos->id_img ?>" name="id">
                                        <input type="file" class="form-control mb-2" name="imagen" id="imagen">
                                        <input type="text" class="form-control mb-2" name="nombre" placeholder="Nombre" value="<?php echo $datos->nombre ?>" required>
                                        <input type="number" class="form-control mb-2" name="cantidad" placeholder="Cantidad" value="<?php echo $datos->cantidad ?>" required>
                                        <input type="text" class="form-control mb-2" name="precio" placeholder="Precio" value="<?php echo $datos->precio ?>" required>
                                        <input type="submit" value="Guardar Cambios" name="btneditar" class="form-control btn btn-success">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="registrar.php" enctype="multipart/form-data" method="POST">
                        <input type="file" class="form-control mb-2" name="imagen" id="imagen">
                        <input type="text" class="form-control mb-2" name="nombre" placeholder="Nombre" required>
                        <input type="number" class="form-control mb-2" name="cantidad" placeholder="Cantidad" required>
                        <input type="text" class="form-control mb-2" name="precio" placeholder="Precio" required>
                        <input type="submit" value="Registrar Producto" name="btnregistrar" class="form-control btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

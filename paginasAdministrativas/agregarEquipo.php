<?php

require_once '../clases/Conexion.php';

$conexion = new Conexion();
$conn = $conexion->Conectar();

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEquipo = $_POST['nombreEquipo'];
    $representante = $_POST['representante'];
    $logo = '';

    if (isset($_FILES["imagenEquipo"])) {
        $file = $_FILES["imagenEquipo"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $carpeta = "logos/";
    
        $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
        $logo = "logos/" . $nombre;
        echo "Logo: $logo<br>";
    }
    
   



    if (isset($_POST['idEquipo'])) {
        $idEquipo = $_POST['idEquipo'];

        $sqlActualizar = "UPDATE equipos SET nombre_equipo = '$nombreEquipo', representante = '$representante' WHERE id_equipo = $idEquipo";
        if (mysqli_query($conn, $sqlActualizar)) {
            echo "Equipo actualizado exitosamente";
        } else {
            echo "Error al actualizar el equipo: " . mysqli_error($conn);
        }
    } else {
        $sqlInsertar = "INSERT INTO equipos (nombre_equipo, representante, logo) VALUES ('$nombreEquipo', '$representante', '$logo')";

        if (mysqli_query($conn, $sqlInsertar)) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Equipo agregado exitosamente
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error al agregar el equipo: ' . mysqli_error($conn) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
        
        
    }
}



$sql = "SELECT id_equipo, nombre_equipo, representante FROM equipos";
$resultado = mysqli_query($conn, $sql);

if (isset($_GET['eliminar'])) {
    $idEquipo = $_GET['eliminar'];
    $sqlEliminar = "DELETE FROM equipos WHERE id_equipo = $idEquipo";
    mysqli_query($conn, $sqlEliminar);
}

if (isset($_GET['editar'])) {
    $idEquipo = $_GET['editar'];
    $sqlEditar = "SELECT id_equipo, nombre_equipo, representante FROM equipos WHERE id_equipo = $idEquipo";
    $resultadoEditar = mysqli_query($conn, $sqlEditar);
    $equipo = mysqli_fetch_assoc($resultadoEditar);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Página de administración - Agregar equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <div class="container">
        <h1>Agregar/Modificar Equipo</h1>
        <form method="POST" action="agregarEquipo.php">
            <div class="form-group">
                <label for="nombreEquipo">Nombre del equipo:</label>
                <input type="text" class="form-control" id="nombreEquipo" name="nombreEquipo"
                    placeholder="Nombre del equipo" value="<?php if (isset($equipo))
                        echo $equipo['nombre_equipo']; ?>">
            </div>
            <div class="form-group">
                <label for="representante">Representante:</label>
                <input type="text" class="form-control" id="representante" name="representante"
                    placeholder="Nombre del representante"
                    value="<?php if (isset($equipo))
                        echo $equipo['representante']; ?>">
            </div>
            <?php if (isset($equipo)): ?>
                <input type="hidden" name="idEquipo" value="<?php echo $equipo['id_equipo']; ?>">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            <?php else: ?>
                
                <input type="file" name="imagenEquipo">
<br><br>
                <button type="submit" class="btn btn-primary">Guardar</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="container2">
        <h1>Equipos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre del equipo</th>
                    <th>Representante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td>
                            <?php echo $fila['nombre_equipo']; ?>
                        </td>
                        <td>
                            <?php echo $fila['representante']; ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editarEquipoModal<?php echo $fila['id_equipo']; ?>">Editar</button>
                                <a href="agregarEquipo.php?eliminar=<?php echo $fila['id_equipo']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>

                    <!-- Modal de editar equipo -->
                    <div class="modal fade" id="editarEquipoModal<?php echo $fila['id_equipo']; ?>" tabindex="-1"
                        aria-labelledby="editarEquipoModalLabel<?php echo $fila['id_equipo']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarEquipoModalLabel<?php echo $fila['id_equipo']; ?>">
                                        Editar Equipo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="agregarEquipo.php">
                                        <input type="hidden" name="idEquipo" value="<?php echo $fila['id_equipo']; ?>">
                                        <div class="form-group">
                                            <label for="nombreEquipoModal<?php echo $fila['id_equipo']; ?>">Nombre del
                                                equipo:</label>
                                            <input type="text" class="form-control"
                                                id="nombreEquipoModal<?php echo $fila['id_equipo']; ?>" name="nombreEquipo"
                                                placeholder="Nombre del equipo"
                                                value="<?php echo $fila['nombre_equipo']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="representanteModal<?php echo $fila['id_equipo']; ?>">Representante:</label>
                                            <input type="text" class="form-control"
                                                id="representanteModal<?php echo $fila['id_equipo']; ?>"
                                                name="representante" placeholder="Nombre del representante"
                                                value="<?php echo $fila['representante']; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
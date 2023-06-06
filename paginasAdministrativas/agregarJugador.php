<?php
require_once '../clases/Conexion.php'; // Reemplaza con la ruta correcta del archivo

// Crear una instancia de la clase Conexion
$conexion = new Conexion();
$conn = $conexion->Conectar();

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombreJugador = $_POST['nombreJugador'];
  $equipo= $_POST['equipo'];
  
  if (isset($_POST['idJugador'])) {
    $idJugador = $_POST['idJugador'];
    
    $sqlActualizar = "UPDATE jugadores SET nombre_jugador = '$nombreJugador', id_equipo = '$equipo' WHERE id_jugador = $idJugador";
    if (mysqli_query($conn, $sqlActualizar)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Jugador agregado correctamente
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error al agregar el jugador: ' . mysqli_error($conn) . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }


} else {
    $sqlInsertar = "INSERT INTO jugadores (nombre_jugador, id_equipo) VALUES ('$nombreJugador', '$equipo')";

    if (mysqli_query($conn, $sqlInsertar)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Jugador agregado exitosamente
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error al agregar el jugador: ' . mysqli_error($conn) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    
    
}

}
// Consulta para obtener los jugadores
$sql = "SELECT DISTINCT jugadores.nombre_jugador, jugadores.id_jugador, equipos.nombre_equipo, equipos.id_equipo FROM jugadores 
INNER JOIN equipos ON equipos.id_equipo = jugadores.id_equipo";
$resultadoJugadores = mysqli_query($conn, $sql);

$sql = "SELECT * FROM equipos";
$resultadoEquipos = mysqli_query($conn, $sql);



//Eliminar un jugador
if (isset($_GET['eliminar'])) {
  $idJugador= $_GET['eliminar'];
  $sqlEliminar = "DELETE FROM jugadores WHERE id_jugador = $idJugador";
  mysqli_query($conn, $sqlEliminar);
  
}

//editar jugador
if (isset($_GET['editar'])) {
  $idJugador = $_GET['editar'];
  $sqlEditar = "SELECT DISTINCT jugadores.nombre_jugador, jugadores.id_jugador, equipos.nombre_equipo, equipos.id_equipo FROM jugadores 
  INNER JOIN equipos ON equipos.id_equipo = jugadores.id_equipo WHERE id_jugador = $idJugador";
  $resultadoEditar = mysqli_query($conn, $sqlEditar);
  $equipo = mysqli_fetch_assoc($resultadoEditar);
}


?>

<!DOCTYPE html>
<html>
<head>
  <title>Página de administración - Agregar Jugador</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- Vincula tu archivo CSS personalizado -->
  <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
  <div class="container">
    <h1>Agregar Jugador</h1>
    <form method="POST">
        <div class="form-group">
          <label for="nombreJugador">Nombre del jugador:</label>
          <input type="text" class="form-control" name="nombreJugador" id="nombreJugador" placeholder="Nombre del jugador">
        </div>
        <div class="form-group">
          <label for="equipo">Equipo</label>
          <select class="form-select" id="equipo" name="equipo">
            <option value="">Seleccione un equipo</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultadoEquipos)) {
              $idEquipo = $row['id_equipo'];
              $nombreEquipo = $row['nombre_equipo'];
              echo "<option value='$idEquipo'>$nombreEquipo</option>";
            }
            ?>
          </select>
        </div>
       
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
  </div>

  <div class="container_visualizarJugadores">
    <h1>Jugadores</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre del jugador</th>
                <th>Equipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultadoJugadores)): ?>
                <tr>
                    <td>
                        <?php echo $fila['nombre_jugador']; ?>
                    </td>
                    <td>
                        <?php echo $fila['nombre_equipo']; ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editarJugadorModal<?php echo $fila['id_jugador']; ?>">Editar</button>
                            <a href="?eliminar=<?php echo $fila['id_jugador']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                          
                    </td>
                </tr>

                <!-- Modal de editar jugador -->
                <div class="modal fade" id="editarJugadorModal<?php echo $fila['id_jugador']; ?>" tabindex="-1"
     aria-labelledby="editarJugadorModalLabel<?php echo $fila['id_jugador']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarJugadorModalLabel<?php echo $fila['id_jugador']; ?>">Editar Jugador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="agregarJugador.php">
          <input type="hidden" name="idJugador" value="<?php echo $fila['id_jugador']; ?>">
          <div class="form-group">
            <label for="nombreJugadorModal<?php echo $fila['id_jugador']; ?>">Nombre del jugador:</label>
            <input type="text" class="form-control" id="nombreJugadorModal<?php echo $fila['id_jugador']; ?>"
                   name="nombreJugador" placeholder="Nombre del jugador" value="<?php echo $fila['nombre_jugador']; ?>">
          </div>
          <div class="form-group">
            <label for="equipoModal<?php echo $fila['id_jugador']; ?>">Equipo:</label>
            <select class="form-select" id="equipoModal<?php echo $fila['id_jugador']; ?>" name="equipo">
              <option value="">Seleccione un equipo</option>
              <?php
              mysqli_data_seek($resultadoEquipos, 0);
              while ($row = mysqli_fetch_assoc($resultadoEquipos)) {
                $idEquipo = $row['id_equipo'];
                $nombreEquipo = $row['nombre_equipo'];
                echo "<option value='$idEquipo'>$nombreEquipo</option>";
              }
              ?>
            </select>
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
  <!-- Vincula el archivo de scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>
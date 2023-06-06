<?php
// Incluir el archivo que contiene la clase Conexion
require_once '../clases/Conexion.php'; // Reemplaza con la ruta correcta del archivo

// Crear una instancia de la clase Conexion
$conexion = new Conexion();

// Establecer la conexión utilizando el método Conectar
$conn = $conexion->Conectar();

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
} else {
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $equipoLocal= $_POST['equipoLocal'];
  $equipoVisitante= $_POST['equipoVisitante'];
  $fecha= $_POST['fecha'];
  $hora= $_POST['hora'];
  $equipoGanador= $_POST['equipoGanador'];
  // Convertir la fecha al formato deseado
  $fechaFormateada = date('Y-m-d', strtotime($fecha));
// Convertir la hora al formato deseado
  $horaFormateada = date('H:i:s', strtotime($hora));

  
  if (isset($_POST['idPartido'])) {
    $idPartido= $_POST['idPartido'];
    
    $sqlActualizar = "UPDATE partidos SET fecha = '$fechaFormateada',hora = '$horaFormateada',  id_equipo_local = '$equipoLocal', id_equipo_visitante = '$equipoVisitante'
, id_equipoGanador = '$equipoGanador' WHERE id_partido = $idPartido";
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
  $sqlInsertar = "INSERT INTO partidos (fecha, hora, id_equipo_local, id_equipo_visitante) VALUES ('$fechaFormateada', '$horaFormateada', $equipoLocal, $equipoVisitante)";
  //INSERT INTO partidos (fecha, hora, id_equipo_local, id_equipo_visitante) VALUES ('2020-01-01','10:10:10', 78, 78)

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
// Consulta para obtener los partidos
$sql = "SELECT fecha, hora, el.id_equipo, ev.id_equipo, id_partido, el.nombre_equipo as equipo_local, ev.nombre_equipo as equipo_visitante
FROM partidos
INNER JOIN equipos el ON partidos.id_equipo_local = el.id_equipo
INNER JOIN equipos ev ON partidos.id_equipo_visitante = ev.id_equipo;";
$resultadoPartidos = mysqli_query($conn, $sql);

$sql = "SELECT * FROM equipos";
$resultadoEquipos = mysqli_query($conn, $sql);



//Eliminar Partido
if (isset($_GET['eliminar'])) {
  $idPartido= $_GET['eliminar'];
  $sqlEliminar = "DELETE FROM partidos WHERE id_partido = $idPartido";
  mysqli_query($conn, $sqlEliminar);
  echo "partido eliminado" , $idPartido;
  
}

//editar Partido
if (isset($_GET['editar'])) {
  $idPartido = $_GET['editar'];
  $sqlEditar = "SELECT DISTINCT jugadores.nombre_jugador, jugadores.id_jugador, equipos.nombre_equipo, equipos.id_equipo FROM jugadores 
  INNER JOIN equipos ON equipos.id_equipo = jugadores.id_equipo WHERE id_partido = $idPartido";
  $resultadoEditar = mysqli_query($conn, $sqlEditar);
  $equipo = mysqli_fetch_assoc($resultadoEditar);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Página de administración - Agregar Partido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/estilos.css">

</head>
<body>






<h1>Agregar Partido</h1>
  <div class="container">
    <form method="POST">
    <div class="form-group">
          <label for="equipo">Equipo Local</label>
          <select class="form-select" id="equipoLocal" name="equipoLocal">
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
  <!-- 2-->

        <div class="form-group">
          <label for="equipo">Equipo Visitante</label>
          <select class="form-select" id="equipoVisitante" name="equipoVisitante">
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
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="fecha">Fecha:</label>
              <input type="date" class="form-control" id="fecha" name="fecha">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="hora">Hora:</label>
              <input type="time" class="form-control" id="hora" name="hora">
            </div>
          </div>
        </div>
       
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
      
  </div>

  <div class="container_visualizarPartidos">
    <h1>Partidos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Fecha del partido</th>
                <th>Equipo local</th>
                <th>Equipo Visitante</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultadoPartidos)): ?>
                <tr>
                    <td>
                        <?php echo $fila['fecha']; ?>
                    </td>
                    <td>
                        <?php echo $fila['equipo_local']; ?>
                    </td>
                    <td>
                        <?php echo $fila['equipo_visitante']; ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editarPartidoModal<?php echo $fila['id_partido']; ?>">Editar</button>
                            <a href="?eliminar=<?php echo $fila['id_partido']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                          
                    </td>
                </tr>

 <!-- Modal de editar jugador -->
<div class="modal fade" id="editarPartidoModal<?php echo $fila['id_partido']; ?>" tabindex="-1"
     aria-labelledby="editarPartidoModalLabel<?php echo $fila['id_partido']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarPartidoModalLabel<?php echo $fila['id_partido']; ?>">Editar Partido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="agregarPartido.php">
          <input type="hidden" name="idPartido" value="<?php echo $fila['id_partido']; ?>">
          <div class="form-group">
            <label for="FechaModal<?php echo $fila['id_partido']; ?>">Fecha:</label>
            <input type="date" class="form-control" id="nombrePartidoModal<?php echo $fila['id_partido']; ?>"
                   name="fecha" placeholder="Fecha" value="<?php echo $fila['fecha']; ?>">
          </div>
          <div class="form-group">
            <label for="HoraModal<?php echo $fila['id_partido']; ?>">Hora:</label>
            <input type="time" class="form-control" id="nombrePartidoModal<?php echo $fila['id_partido']; ?>"
                   name="hora" placeholder="Fecha" value="<?php echo $fila['hora']; ?>">
          </div>
          <div class="form-group">
            <label for="equipoModal<?php echo $fila['id_partido']; ?>">Equipo Local:</label>
            <select class="form-select" id="equipoModal<?php echo $fila['id_partido']; ?>" name="equipoLocal">
              <option value="">Seleccione un equipo</option>
              <?php
              mysqli_data_seek($resultadoEquipos, 0);
              while ($row = mysqli_fetch_assoc($resultadoEquipos)) {
                $idEquipo = $row['id_equipo'];
                $nombreEquipo = $row['nombre_equipo'];
                $selectedEquipoLocal = ($idEquipo == $fila['equipo_local']) ? "selected" : "";
                echo "<option value='$idEquipo' $selectedEquipoLocal>$nombreEquipo</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="equipoModal<?php echo $fila['id_partido']; ?>">Equipo Visitante:</label>
            <select class="form-select" id="equipoModal<?php echo $fila['id_partido']; ?>" name="equipoVisitante">
              <option value="">Seleccione un equipo</option>
              <?php
              mysqli_data_seek($resultadoEquipos, 0);
              while ($row = mysqli_fetch_assoc($resultadoEquipos)) {
                $idEquipo = $row['id_equipo'];
                $nombreEquipo = $row['nombre_equipo'];
                $selectedEquipoVisitante = ($idEquipo == $fila['id_equipo_visitante']) ? "selected" : "";
                echo "<option value='$idEquipo' $selectedEquipoVisitante>$nombreEquipo</option>";
              }
              ?>
            </select>
          </div>


          <div class="form-group">
            <label for="equipoModal<?php echo $fila['id_partido']; ?>">Equipo Ganador:</label>
            <select class="form-select" id="equipoModal<?php echo $fila['id_partido']; ?>" name="equipoGanador">
              <option value="">Seleccione un equipo</option>
              <?php
              mysqli_data_seek($resultadoEquipos, 0);
              while ($row = mysqli_fetch_assoc($resultadoEquipos)) {
                $idEquipo = $row['id_equipo'];
                $nombreEquipo = $row['nombre_equipo'];
                $selectedEquipoGanador = ($idEquipo == $fila['id_equipo_ganador']) ? "selected" : "";
                echo "<option value='$idEquipo' $selectedEquipoGanador>$nombreEquipo</option>";
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

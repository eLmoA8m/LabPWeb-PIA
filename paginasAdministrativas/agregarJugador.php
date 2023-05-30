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
  echo "XD";
  
  if (isset($_POST['idJugador'])) {
    $idJugador = $_POST['idJugador'];

} else {
    $sqlInsertar = "INSERT INTO jugadores (nombre_jugador, id_equipo) VALUES ('$nombreJugador', '$equipo')";

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
// Consulta para obtener los jugadores
$sql = "SELECT nombre_jugador FROM jugadores";
$result = mysqli_query($conn, $sql);




?>

<!DOCTYPE html>
<html>
<head>
  <title>Página de administración - Agregar Jugador</title>
  <!-- Vincula los archivos de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- Vincula tu archivo CSS personalizado -->
  <link rel="stylesheet" href="./css/estilos.css">
  <link rel="stylesheet" href="ruta/a/tu-archivo-css.css">
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
            while ($row = mysqli_fetch_assoc($result)) {
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
            <?php while ($fila = mysqli_fetch_assoc($result)): ?>
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
                        <a href="eliminarJugador.php?id=<?php echo $fila['id_jugador']; ?>"
                            class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>

     
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
  <!-- Vincula el archivo de scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"> 
</body>
</html>
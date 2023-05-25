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
    echo "Conexión exitosa!";
}

// Resto del código...
?>

<!DOCTYPE html>
<html>
<head>
  <title>Página de administración - Agregar Partido</title>
  <!-- Vincula los archivos de Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- Vincula tu archivo CSS personalizado -->
  <link rel="stylesheet" href="./css/estilos.css">
  <link rel="stylesheet" href="ruta/a/tu-archivo-css.css">
</head>
<body>
  <div class="container">
    <h1>Agregar Partido</h1>
    <form>
        <div class="form-group">
          <label for="equipoLocal">Equipo local:</label>
          <input type="text" class="form-control" id="equipoLocal" placeholder="Nombre del equipo local">
        </div>
        <div class="form-group">
          <label for="equipoVisitante">Equipo visitante:</label>
          <input type="text" class="form-control" id="equipoVisitante" placeholder="Nombre del equipo visitante">
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="fecha">Fecha:</label>
              <input type="date" class="form-control" id="fecha">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="hora">Hora:</label>
              <input type="time" class="form-control" id="hora">
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </form>
      
  </div>
  <!-- Vincula el archivo de scripts de Bootstrap -->
  <script src="ruta/a/bootstrap.min.js"></script>
</body>
</html>

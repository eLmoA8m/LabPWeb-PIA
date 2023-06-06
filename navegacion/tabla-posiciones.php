<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tabla de Posiciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include('./componentes/navbar.php'); ?>
    
    <div class="container">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Equipo</th>
                <th scope="col">PJ</th>
                <th scope="col">PG</th>
                <th scope="col">PE</th>
                <th scope="col">PP</th>
                <th scope="col">Puntos</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            // Obtener la hora del formulario
$horaFormulario = $_POST['hora'];

// Convertir la hora al formato deseado
$horaFormateada = date('H:i:s', strtotime($horaFormulario));

// Mostrar la hora formateada
echo $horaFormateada;
            include "../clases/Conexion.php";
           
            // Realizar la consulta a la base de datos
            $conexion = new Conexion();
            $conn = $conexion->Conectar();
            if (!$conn) {
                die("Conexión fallida: " . mysqli_connect_error());
            }
            
            $sql = "SELECT * FROM equipos";
            $resultado = mysqli_query($conn, $sql);

            // Iterar sobre los resultados y generar las filas de la tabla
            while ($row = mysqli_fetch_assoc($resultado)){
                echo "<tr>";
                echo "<td>{$row['nombre_equipo']}</td>";
              // echo "<td>{$row['pj']}</td>";
                // echo "<td>{$row['pg']}</td>";
               //  echo "<td>{$row['pe']}</td>";
              //   echo "<td>{$row['pp']}</td>";
              //   echo "<td>{$row['puntos']}</td>";
                // echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous">
    </script>
</body>
</html>

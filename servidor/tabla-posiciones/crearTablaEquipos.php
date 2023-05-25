<?php
     require_once dirname(__FILE__) . '/../../clases/Conexion.php';
     require_once dirname(__FILE__) . '/../../clases/Equipo.php';

     /* DESCOMENTAR CUANDO LA BD YA EXISTA
     $conn = new Conexion();
     $conexion = $conn->Conectar();;

     // Consulta los datos que deseas mostrar en la tabla
     $consulta = "SELECT * FROM equipos";
     $resultado = mysqli_query($conexion, $consulta);
     */
     
    
     // Data Mockeada hasta implementar BD

     $equipos = array();
     $equipos[0] = new Equipo("Monterrey", 10, 5, 3, 2, 50);
     $equipos[1] = new Equipo("Tigres", 10, 5, 3, 2, 50);
     $equipos[2] = new Equipo("Atlas", 10, 5, 3, 2, 50);

     foreach($equipos as $equipo){
         echo "<tr><td>" . $equipo->getNombre() . "</td><td>" . $equipo->getPJ() . "</td><td>" . $equipo->getPG() . "</td><td>" . $equipo->getPE() . "</td><td>" . $equipo->getPP() . "</td><td>" . $equipo->getPuntos() . "</td></tr>";
     }


?>
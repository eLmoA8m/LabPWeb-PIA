<?php 
include "Conexion.php";
class Auth extends Conexion{
    public function registrar($usuario, $email, $password){
        $conexion = parent::Conectar(); 
        $sql = "INSERT INTO usuarios (nombre, email, contrasena, id_rol) VALUES (?, ?, ?, 1)";
        $query = $conexion->prepare ($sql);
        $query->bind_param('sss', $usuario, $email, $password);
        return $query->execute();
    }

}
?>
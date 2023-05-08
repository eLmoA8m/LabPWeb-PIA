<?php 
class Conexion{
    public $servidor = 'localhost';
    public $usuario = 'root';
    public $password = 'omar2381';
    public $database = 'pia_labpweb';
    public $port = '3306';
    public function Conectar(){
        return mysqli_connect(
           $this->servidor,
           $this->usuario,
           $this->password,
           $this->database,
           $this->port
        );
    } 
}    
?>
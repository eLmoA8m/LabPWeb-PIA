<?php
    class Conexion{
        private $servidor = 'localhost';
        private $usuario = 'root';
        private $password = 'omar2381'; // Se debe normalizar un usuario y una contraseña que no sea root
        private $database = 'pia_labweb';
        private $port = '3306';

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
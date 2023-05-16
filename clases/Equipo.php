<?php
    class Equipo{
        private $nombre;
        private $PJ;
        private $PG;
        private $PE;
        private $PP;
        private $puntos;

        // Añadimos los getters y setters (como es)
        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre_equipo){
            $this->nombre = $nombre_equipo;
        }

        public function getPJ(){
            return $this->PJ;
        }
        public function setPJ($partidos_jugados){
            $this->PJ = $partidos_jugados;
        }

        public function getPG(){
            return $this->PG;
        }
        public function setPG($partidos_ganados){
            $this->PG = $partidos_ganados;
        }

        public function getPE(){
            return $this->PE;
        }
        public function setPE($partidos_empatados){
            $this->PE = $partidos_empatados;
        }

        public function getPP(){
            return $this->PP;
        }
        public function setPP($partidos_perdidos){
            $this->PP = $partidos_perdidos;
        }

        public function getPuntos(){
            return $this->puntos;
        }
        public function setPuntos($puntos_total){
            $this->puntos = $puntos_total;
        }

        //Creamos constructor lleno y constructor vacio
        public function __construct($nombre = '', $PJ = 0, $PG = 0, $PE = 0, $PP = 0, $puntos = 0) {
            $this->nombre = $nombre;
            $this->PJ = $PJ;
            $this->PG = $PG;
            $this->PE = $PE;
            $this->PP = $PP;
            $this->puntos = $puntos;
        }
    }




?>
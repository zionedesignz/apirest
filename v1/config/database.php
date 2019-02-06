<?php
    class Database{

        // parametros de la BD
        private $host = "localhost";
        private $nombre = "api";
        private $usuario = "root";
        private $password = "";
        public $conn;
        
        // obtener conexion
        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->nombre, $this->usuario, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $e){
                echo "Connection error: " . $e->getMessage();
            }
            return $this->conn;
        }
        
    }
?>
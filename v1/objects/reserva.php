<?php
    class Reserva{
     
        // variable conexion y nombre de la tabla de la BD
        private $conn;
        private $tabla = "reservas";
     
        // propiedades del objeto
        public $id;
        public $idusuario;
        public $fecha;
        public $hora;
        public $servicio;
        public $tiemposervicio;
        public $estado;
        public $nombreusuario;
        public $telefonousuario;

        // constructor con $db como conexion a la BD
        public function __construct($db){
            $this->conn = $db;
        }

        // crear reserva
        function crear(){
         
            // consulta para crear reserva
            $query = "INSERT INTO ".$this->tabla." (id, idusuario, fecha, hora, servicio, tiemposervicio, estado, nombreusuario, telefonousuario) VALUES ( NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
         
            // preparar consulta, sanear valores y enlazar valores
            $stmt = $this->conn->prepare($query);
         
            $this->idusuario = htmlspecialchars(strip_tags($this->idusuario));
            $this->fecha = htmlspecialchars(strip_tags($this->fecha));
            $this->hora = htmlspecialchars(strip_tags($this->hora));
            $this->servicio = htmlspecialchars(strip_tags($this->servicio));
            $this->tiemposervicio = htmlspecialchars(strip_tags($this->tiemposervicio));
            $this->estado = htmlspecialchars(strip_tags($this->estado));
            $this->nombreusuario = htmlspecialchars(strip_tags($this->nombreusuario));
            $this->telefonousuario = htmlspecialchars(strip_tags($this->telefonousuario));

            $stmt->bindParam(1, $this->idusuario);
            $stmt->bindParam(2, $this->fecha);
            $stmt->bindParam(3, $this->hora);
            $stmt->bindParam(4, $this->servicio);
            $stmt->bindParam(5, $this->tiemposervicio);
            $stmt->bindParam(6, $this->estado);
            $stmt->bindParam(7, $this->nombreusuario);
            $stmt->bindParam(8, $this->telefonousuario);
         
            // ejecutar consulta
            if($stmt->execute()){
                return true;
            }
         
            return false;      
        }

        // leer reservas
        function leer(){
         
            // consulta para leer todas las reservas
            $query = "SELECT * FROM ".$this->tabla." ORDER BY hora";
         
            //preparar consulta y ejecutar
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
         
            return $stmt;
        }

        // leer reserva por identificador
        function leerId(){
            
            // consulta para leer una única reserva
            $query = "SELECT * FROM ".$this->tabla." WHERE id = ? LIMIT 0,1";
         
            // preparar consulta, sanear valor, enlazar valor de id y ejecutar consulta
            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(1, $this->id);

            $stmt->execute();
            
            // obtener resultado de consulta
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //comprobar si es array (si no hay resultados en la consulta devuelve null)
            if(is_array($row)){

                // pasar el valor $row['name'] a una variable con el nombre de la clave $name 
                extract($row);

                // asignar propiedades al objeto Reserva con los valores obtenidos
                $this->id = $id;
                $this->idusuario = $idusuario;
                $this->fecha = $fecha;
                $this->hora = $hora;
                $this->servicio = $servicio;
                $this->tiemposervicio = $tiemposervicio;
                $this->estado = $estado;
                $this->nombreusuario = $nombreusuario;
                $this->telefonousuario = $telefonousuario;

                return true;

            }

            return false;
        }

        // leer reservas con paginación
        function leerPag($pag, $regs){
            try{

            // consulta para leer todas las reservas con paginación
            $query = "SELECT * FROM ".$this->tabla." ORDER BY hora LIMIT ?, ?";
         
            // preparar consulta,  enlazar valores y ejecutar consulta
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $pag, PDO::PARAM_INT);
            $stmt->bindParam(2, $regs, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        // leer el total de registros
        function registros(){

            // consulta para contar todas las reservas
            $query = "SELECT COUNT(*) as total_rows FROM ".$this->tabla."";

            // preparar consulta y ejecutar consulta
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
         
            return $row['total_rows'];
        }

        // leer el total de registros de la busqueda
        function registrosBuscar($keywords){

            // consulta para contar todas las reservas
            $query = "SELECT COUNT(*) as total_rows FROM ".$this->tabla." WHERE fecha LIKE ? OR nombreusuario LIKE ? OR hora LIKE ? ORDER BY hora";

            // preparar consulta y ejecutar consulta
            $stmt = $this->conn->prepare($query);

            $keywords = htmlspecialchars(strip_tags($keywords));
            $keywords = "%{$keywords}%";

            $stmt->bindParam(1, $keywords);
            $stmt->bindParam(2, $keywords);
            $stmt->bindParam(3, $keywords);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
         
            return $row['total_rows'];
        }

        // actualizar reserva
        function actualizar(){

                // consulta para actualizar
                $query = "UPDATE ".$this->tabla." SET idusuario= ?, fecha= ?, hora= ?, servicio= ?, tiemposervicio= ?, estado= ?, nombreusuario= ?, telefonousuario= ?  WHERE id = ?";
             
                // preparar consulta, sanear valores y enlazar valores
                $stmt = $this->conn->prepare($query);

                $this->id = htmlspecialchars(strip_tags($this->id));
                $this->idusuario = htmlspecialchars(strip_tags($this->idusuario));
                $this->fecha = htmlspecialchars(strip_tags($this->fecha));
                $this->hora = htmlspecialchars(strip_tags($this->hora));
                $this->servicio = htmlspecialchars(strip_tags($this->servicio));
                $this->tiemposervicio = htmlspecialchars(strip_tags($this->tiemposervicio));
                $this->estado = htmlspecialchars(strip_tags($this->estado));
                $this->nombreusuario = htmlspecialchars(strip_tags($this->nombreusuario));
                $this->telefonousuario = htmlspecialchars(strip_tags($this->telefonousuario));

                $stmt->bindParam(1, $this->idusuario);
                $stmt->bindParam(2, $this->fecha);
                $stmt->bindParam(3, $this->hora);
                $stmt->bindParam(4, $this->servicio);
                $stmt->bindParam(5, $this->tiemposervicio);
                $stmt->bindParam(6, $this->estado);
                $stmt->bindParam(7, $this->nombreusuario);
                $stmt->bindParam(8, $this->telefonousuario);
                $stmt->bindParam(9, $this->id);

                // ejecutar consulta
                if($stmt->execute()){
                    return true;
                }  
                
                return false;
        }

        // eliminar reserva
        function eliminar(){
         
            // consulta para eliminar
            $query = "DELETE FROM " .$this->tabla. " WHERE id = ?";
         
            // preparar consulta, sanear valor y enlazar valor de id
            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(1, $this->id);
         
            // ejecutar consulta
            if($stmt->execute()){
                return true;
            }
         
            return false;   
        }

        // buscar reservas
        function buscar($keywords){
         
            // consulta para buscar
            $query = "SELECT * FROM ".$this->tabla." WHERE fecha LIKE ? OR nombreusuario LIKE ? OR hora LIKE ? ORDER BY hora";
         
            // preparar consulta, sanear valores, enlazar valores y ejecutar consulta
            $stmt = $this->conn->prepare($query);

            $keywords = htmlspecialchars(strip_tags($keywords));
            $keywords = "%{$keywords}%";

            $stmt->bindParam(1, $keywords);
            $stmt->bindParam(2, $keywords);
            $stmt->bindParam(3, $keywords);

            $stmt->execute();
         
            return $stmt;
        }

        // buscar reservas con paginación
        function buscarPag($keywords, $pag, $regs){
         
            // consulta para buscar
            $query = "SELECT * FROM ".$this->tabla." WHERE fecha LIKE ? OR nombreusuario LIKE ? OR hora LIKE ? ORDER BY hora LIMIT ?, ?";
         
            // preparar consulta, sanear valores, enlazar valores y ejecutar consulta
            $stmt = $this->conn->prepare($query);

            $keywords = htmlspecialchars(strip_tags($keywords));
            $keywords = "%{$keywords}%";

            $stmt->bindParam(1, $keywords);
            $stmt->bindParam(2, $keywords);
            $stmt->bindParam(3, $keywords);
            $stmt->bindParam(4, $pag, PDO::PARAM_INT);
            $stmt->bindParam(5, $regs, PDO::PARAM_INT);

            $stmt->execute();
         
            return $stmt;
        }
        
    }

?>
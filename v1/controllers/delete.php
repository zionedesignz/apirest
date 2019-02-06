<?php
// required headers
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json");
// header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, DELETE")
// header("Access-Control-Allow-Headers: Content-Type,X-Requested-With, Accept, Origin, Authorization");
// header("Access-Control-Max-Age: 3600");
 
// incluir la conexion a la base de datos y la clase reserva
include_once './config/database.php';
include_once './objects/reserva.php';
 
// instanciar objeto Database y obtener conexion
$database = new Database();
$db = $database->getConnection();
 
// instanciar objeto Reserva y pasar parametro de conexión 
$reserva = new Reserva($db);

// asignar la propiedad id al objeto Reserva
$reserva->id = $param;

// realizar consulta  (si encuentra resultados -> true)
if($reserva->leerId()){
	echo 'prueebaa';

	if($reserva->id!=null){

		// eliminar la reserva
		if($reserva->eliminar()){
		 
		    // establecer código de respuesta -> 200 OK
		    http_response_code(200);
		 
		    // devolver respuesta al usuario
		    echo json_encode( ["mensaje" => "Reserva eliminada correctamente."] );

		}
		// si no se ha podido eliminar la reserva
		else{
		 
		    // establecer código de respuesta -> 503 service unavailable
		    http_response_code(503);
		 
		    // devolver respuesta al usuario
		    echo json_encode( ["mensaje" => "No se ha podido eliminar la reserva."] );

		}

	}

}else{
    // establecer código de respuesta -> 404 Not found
    http_response_code(404);
 
    // devolver respuesta al usuario
    echo json_encode( ["mensaje" => "La reserva indicada no existe."] );
}

?>
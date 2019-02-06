<?php

// cabeceras requeridas
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// header("Access-Control-Allow-Credentials: true")
 
// incluir la conexion a la base de datos y la clase reserva
include_once './config/database.php';
include_once './objects/reserva.php';
 
// instanciar objeto Database y obtener conexion
$database = new Database();
$db = $database->getConnection();
 
// instanciar objeto Reserva y pasar parametro de conexión 
$reserva = new Reserva($db);
 
// recuperar los datos 
$data = json_decode(file_get_contents("php://input"));

// validar que los campos no estan vacios
if(	!empty($param) &&
    !empty($data->idusuario) &&
    !empty($data->fecha) &&
    !empty($data->hora) &&
    !empty($data->servicio) &&
    !empty($data->tiemposervicio) &&
    !empty($data->estado) &&
    !empty($data->nombreusuario) &&
    !empty($data->telefonousuario)
){

	// asignar propiedades al objeto Reserva con los valores obtenidos
	$reserva->id = $param;
	$reserva->idusuario = $data->idusuario;
	$reserva->fecha = $data->fecha;
	$reserva->hora = $data->hora;
	$reserva->servicio = $data->servicio;
	$reserva->tiemposervicio = $data->tiemposervicio;
	$reserva->estado = $data->estado;
	$reserva->nombreusuario = $data->nombreusuario;
	$reserva->telefonousuario = $data->telefonousuario;

	if($reserva->id!=null){
		
		// actualizar la reserva
		if($reserva->actualizar()){
		 
		    // establecer código de respuesta -> 200 OK
		    http_response_code(200);
		 
		    // devolver respuesta al usuario
		    echo json_encode( ["mensaje" => "Reserva actualizada correctamente."] );
		}
		// si no se ha podido actualizar la reserva
		else{
		 
		    // establecer código de respuesta -> 503 service unavailable
		    http_response_code(503);
		 
		    // devolver respuesta al usuario
		    echo json_encode( ["mensaje" => "No se ha podido actualizar la reserva."] );
		}

	}else{
	    // establecer código de respuesta -> 404 Not found
	    http_response_code(404);
	 
	    // devolver respuesta al usuario
	    echo json_encode( ["mensaje" => "La reserva indicada no existe."] );
	}
}
// devolver respuesta si faltan datos
else{
 
    // establecer código de respuesta -> 400 bad request
    http_response_code(400);
 
    // devolver respuesta al usuario
    echo json_encode( ["mensaje" => "Faltan datos."] );
}

?>
<?php

// cabeceras requeridas
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
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
if( !empty($data->idusuario) &&
    !empty($data->fecha) &&
    !empty($data->hora) &&
    !empty($data->servicio) &&
    !empty($data->tiemposervicio) &&
    !empty($data->estado) &&
    !empty($data->nombreusuario) &&
    !empty($data->telefonousuario)
){
 
    // asignar propiedades al objeto Reserva con los valores recogidos
    $reserva->idusuario = $data->idusuario;
    $reserva->fecha = $data->fecha;
    $reserva->hora = $data->hora;
    $reserva->servicio = $data->servicio;
    $reserva->tiemposervicio = $data->tiemposervicio;
    $reserva->estado = $data->estado;
    $reserva->nombreusuario = $data->nombreusuario;
    $reserva->telefonousuario = $data->telefonousuario;
 
    // crear una nueva reserva
    if($reserva->crear()){
 
        // establecer código de respuesta -> 201 created
        http_response_code(201);
 
        // devolver respuesta al usuario
        echo json_encode( ["mensaje" => "Reserva creada correctamente."] );
    }
    // si no se ha podido crear la reserva
    else{
 
        // establecer código de respuesta -> 503 service unavailable
        http_response_code(503);
 
        // devolver respuesta al usuario
        echo json_encode( ["mensaje" => "No se ha podido crear la reserva."] );
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
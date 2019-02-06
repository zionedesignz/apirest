<?php
// cabeceras requeridas
// header("Access-Control-Allow-Origin: *");
// header('Content-Type: application/json; charset=UTF-8');
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Credentials: true");
 
// incluir la conexion a la base de datos y la clase reserva
include_once './config/database.php';
include_once './objects/reserva.php';
 
// instanciar objeto Database y obtener conexion
$database = new Database();
$db = $database->getConnection();
 
// instanciar objeto Reserva y pasar parametro de conexión 
$reserva = new Reserva($db);

$reserva->id = $param;

// realizar consulta (si encuentra resultados -> true)
if($reserva->leerId()){

    if($reserva->id!=null){

        // array de Reservas
        $reservas_arr=[];
        $reservas_arr["data"]=[];

        // crear array
        $reserva_item = [
                "id" => $reserva->id,
                "idusuario" => $reserva->idusuario,
                "fecha" => $reserva->fecha,
                "hora" => $reserva->hora,
                "servicio" => $reserva->servicio,
                "tiemposervicio" => $reserva->tiemposervicio,
                "estado" => $reserva->estado,
                "nombreusuario" => $reserva->nombreusuario,
                "telefonousuario" => $reserva->telefonousuario
            ];

        // insertar cada reserva en el array reservas
        array_push($reservas_arr["data"], $reserva_item);
     
        // establecer código de respuesta -> 200 OK
        http_response_code(200);
     
        // devolver la reserva en JSON
        echo json_encode($reservas_arr);
    }
    
}else{

    // establecer código de respuesta -> 404 Not found
    http_response_code(404);
 
    // devolver respuesta al usuario
    echo json_encode( ["mensaje" => "La reserva indicada no existe."] );

}

?>
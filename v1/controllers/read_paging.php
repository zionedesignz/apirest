<?php

// cabeceras requeridas
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json");
// header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, DELETE")
// header("Access-Control-Allow-Headers: Content-Type,X-Requested-With, Accept, Origin, Authorization");
// header("Access-Control-Max-Age: 3600");

// incluir la conexion a la base de datos, la clase reserva, la configuración principal y la clase paginacion
include_once './config/core.php';
include_once './shared/paginacion.php';
include_once './config/database.php';
include_once './objects/reserva.php';
 
// instanciar objeto Paginación
$paginacion = new Paginacion();
 
// instanciar objeto Database y obtener conexion
$database = new Database();
$db = $database->getConnection();
 
// instanciar objeto Reserva y pasar parametro de conexión 
$reserva = new Reserva($db);
 
// realizar consulta
$stmt = $reserva->leerPag($pag, $regs);

$num = $stmt->rowCount();
 
// si el numero de resultados es superior a 0
if($num>0){
 
    // array de Reservas
    $reservas_arr= [];
    $reservas_arr["data"]= [];
    $reservas_arr["pages"]= [];
 
    // recorrer resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // pasar el valor $row['name'] a una variable con el nombre de la clave $name 
        extract($row);
       
        //crear un item por cada resultado
        $reserva_item=[
            "id" => $id,
            "idusuario" => $idusuario,
            "fecha" => $fecha,
            "hora" => $hora,
            "servicio" => $servicio,
            "tiemposervicio" => $tiemposervicio,
            "estado" => $estado,
            "nombreusuario" => $nombreusuario,
            "telefonousuario" => $telefonousuario
        ];
        
        // insertar cada reserva en el array reservas
        array_push($reservas_arr["data"], $reserva_item);
    }
 
    // incluir paginación
    $total_rows= $reserva->registros();
    $page_url= "{$home_url}reservas?";
    $paging= $paginacion->getPaging($page, $total_rows, $regs, $page_url);
    $reservas_arr["pages"]= $paging;
 
    // establecer código de respuesta -> 200 OK
    http_response_code(200);
 
    // devolver las reservas en JSON
    echo json_encode($reservas_arr);

}else{
 
    // establecer código de respuesta -> 404 Not found
    http_response_code(404);
 
    // devolver respuesta al usuario
    echo json_encode( ["mensaje" => "No se encontraron reservas."] );
}

?>
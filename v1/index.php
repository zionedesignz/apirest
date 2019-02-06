<?php

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

//variables
$metodo = $_SERVER['REQUEST_METHOD'];
$path = explode('/',$_GET['d']);
$tabla =  $path[0];
$param = '';

if( count($path) > 1 ){
	$param = $path[1];
}

if($metodo == 'GET'){
	if($tabla == 'reservas'){
		if($param == ''){
			if(isset($_REQUEST['limit'])){
				include_once './controllers/read_paging.php';
			}else{
				include_once './controllers/read.php';
			}
		}else if(is_numeric($param)){
			include_once './controllers/read_one.php';
		}else{
			if(isset($_REQUEST['limit'])){
				include_once './controllers/search_paging.php';
			}else{
				include_once './controllers/search.php';
			}
		}
	}
}else if($metodo == 'POST'){
	if($tabla == 'reservas'){
		include_once './controllers/create.php';
	}
}else if($metodo == 'DELETE'){
	if($tabla == 'reservas'){
		include_once './controllers/delete.php';
	}
}else if($metodo == 'PUT'){
	if($tabla == 'reservas'){
		include_once './controllers/update.php';
	}
}else{

	// establecer código de respuesta -> 405 Method Not Allowed
    http_response_code(405);
 
    // devolver respuesta al usuario
    echo json_encode( ["mensaje" => "El método indicado no es soportado por la API"] );

}

?>
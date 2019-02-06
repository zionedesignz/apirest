<?php

// informe de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// página principal
$home_url="https://localhost/apirest/v1/";
 
// obtener valores de la variable page del GET, sino el valor por defecto es 1
$page = isset($_GET['page']) ? intval( $_GET['page'] ) : 1;

 // obtener valores de la variable limit del GET, sino el valor por defecto es 5
$regs = isset($_GET['limit']) ? intval( $_GET['limit'] ) : 5;
 
// calcular el número de página para la clausula LIMIT  de la consulta
$pag = ($regs * $page) - $regs;

?>
<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$entidad=$_GET['entidad'];
$id=$_GET['id'];

       
	switch($entidad){
		case "cliente":
		$infoitem=$cm->getCliente($id); 
		echo json_encode($infoitem);	
		break;
		case "contacto":
		$infoitem=$cm->getContacto($id); 
		echo json_encode($infoitem);	
		break;
		case "itemcotizacion":
		$infoitem=$cm->getItemCotizacion($id); 
		echo json_encode($infoitem);	
		break;
		case "equipo":
		$infoitem=$cm->getEquipo($id); 
		echo json_encode($infoitem);	
		break;	
		case "parametros":
		$infoitem=$cm->getParametros($id); 
		echo json_encode($infoitem);	
		break;
	}

?>
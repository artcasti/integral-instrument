<?php 
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include("conexion.php");
include("functions.php");

$tarea=$_GET['tarea'];

switch ($tarea) {
	case 'G'://Creacion de Galerias
		$galeria=$_GET['galeria'];

		$consulta="INSERT INTO `galerias` (`nombre`) VALUES ('$galeria'); ";

		$result = $conexion->query($consulta);

		if($result){

			registra_log("Galerias","Se ha creado la galeria: ".$galeria);
			echo "Se ha creado la galeria";
			} else{
		echo $consulta;
			echo "<br> no se pudo insertar la galeria: ".$conexion->error;
		}

		break;

	case 'B'://Agregar items a Galeria
		$galeria=$_GET['galeria'];
		$url = $_GET['file'];

		$consulta="INSERT INTO `galerias_items` (`url`,`idgaleria`) VALUES ('$url','$galeria')";

		$result = $conexion->query($consulta);

		if($result){

			registra_log("Galerias","Se ha agregado la imagen ".$url." a la galeria: ".$galeria);
			echo "Hecho";
			} else{
		echo $consulta;
			echo "<br> no se pudo agregar la imagen: ".$conexion->error;
		}

	case 'E'://Elimina items de Galeria
		$id = $_GET['id'];
		$galeria=$_GET['galeria'];

		$consulta="DELETE FROM `galerias_items` WHERE `iditem` = '$id'";

		$result = $conexion->query($consulta);

		if($result){

			registra_log("Galerias","Se ha eliminado la imagen ".$id." de la galeria: ".$galeria);
			
			} else{
		echo $consulta;
			echo "<br> no se pudo eliminar la imagen: ".$conexion->error;
		}
		
}



?>

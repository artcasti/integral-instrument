<?php
session_start();
include("conexion.php");
include("functions.php");

$idmenu = $_SESSION['modifica'];
$label = $_POST['label'];
$orden  = $_POST['orden'];

if ($idmenu!=0){
$consulta = "UPDATE menupadre SET label='$label', orden='$orden'WHERE idpadre=$idmenu";
}else{
$consulta = "INSERT INTO `campaus`.`menupadre` (`label`, `orden`) VALUES ('$label', '$orden');";
}



$result = mysql_query($consulta,$conexion);
if($result){
	//echo "Se ha creado el menu";
//echo $idmenu." ".$consulta;
	registra_log('Graba Menu Padre');
	header("Location: menu_padre.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar el menu por: ".mysql_error();
}


?>
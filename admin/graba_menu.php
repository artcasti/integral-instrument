<?php
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}

include("conexion.php");
include("functions.php");


$idmenu = $_SESSION['modifica'];
$label = $_POST['label'];
$href  = $_POST['href'];
$orden  = $_POST['orden'];
$padre  = $_POST['padre'];

if ($idmenu!=0){
$accion="Modifica el";	
$consulta = "UPDATE menu SET label='$label', href='$href', orden='$orden', idpadre = '$padre' WHERE idmenu=$idmenu";
}else{
$accion="Crea el";	
$consulta = "INSERT INTO `menu` (`idmenu`, `label`, `href`, `orden`,`idpadre`) VALUES ('$idmenu', '$label', '$href', '$orden','$padre');";
}



$result = mysql_query($consulta,$conexion);
if($result){

		registra_log("Menues",$accion." Menu: ".$idmenu);
	header("Location: alta_menu.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar el menu por: ".mysql_error();
}


?>
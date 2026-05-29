<?php
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}

include("conexion.php");
include("functions.php");


$idperfil = $_SESSION['modifica'];
$perfil = $_POST['perfil'];


if ($idperfil!=0){
$consulta = "UPDATE perfiles SET perfil='$perfil' WHERE idperfil=$idperfil";
}else{
$consulta = "INSERT INTO `perfiles` ( `perfil`) VALUES ('$perfil');";
}



$result = mysql_query($consulta,$conexion);
if($result){
	//echo "Se ha creado el perfil";
	registra_log("Perfiles","Se dio de alta el perfil: ".$perfil);
	header("Location: alta_perfiles.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar el perfil por: ".mysql_error();
}


?>
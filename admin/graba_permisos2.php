<?php
session_start();
include("conexion.php");
include("functions.php");



$idmenu = $_POST['menues'];
$idperfil = $_POST['perfiles'];
$bandera=true;

foreach($idperfil as $perfil){
	foreach($idmenu as $menu)
	{
		$consulta = "INSERT INTO `menuperfil` (`idmenu`, `idperfil`) VALUES ('".$menu."', '".$perfil."');";
		$result = mysql_query($consulta,$conexion);
		if($result){
		registra_log("Permisos","Se habilitó el menu: ".$idmenu." al perfil: ".$idperfil);
		} 
		else
		{
			$bandera=false;
			echo $consulta;
			echo "<br> no se pudo insertar el menu por: ".mysql_error();
		}
	}
}

if($bandera)
{
		header("Location: alta_permiso2.php");
}	








?>
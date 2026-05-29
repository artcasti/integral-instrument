<?php
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}

include("conexion.php");
include("functions.php");

$cod=$_GET['cod'];
$desc=$_GET['desc'];
$habilitado=$_GET['habilitado'];
$accion=$_GET['accion'];


switch ($accion) {
	case '0':
			$log="Accede a categorias";
			header("Location: detalle_categorias.php");
		break;
	case '1':
			$log="Agrega la categoria: ";
			$consulta = "  
			INSERT INTO `categorias` (`descripcion`, `habilitado`, `idusuario`) VALUES ('$desc', '$habilitado', '$_SESSION[idusuario]');
			";
		break;
	case '2':
			$log="Modifica la categoria: ";
			$consulta = "  
			Update `categorias` set `descripcion` = '$desc', `habilitado` = '$habilitado' , `idusuario`= '$_SESSION[idusuario]' where  `idcategoria`=$cod;
			";
		break;
}

$result = mysql_query($consulta,$conexion);

if($result){

		registra_log("Categorias",$log.$desc);
	header("Location: detalle_categorias.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar la categoria: ".mysql_error();
}
?>

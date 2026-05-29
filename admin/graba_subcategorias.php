<?php
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}

include("conexion.php");
include("functions.php");

$cod=$_GET['cod'];
$desc=$_GET['desc'];
$categ=$_GET['categ'];
$habilitado=$_GET['habilitado'];
$accion=$_GET['accion'];


switch ($accion) {
	case '0':
			$log="Accede a subcategorias";
			header("Location: detalle_subcategorias.php");
		break;
	case '1':
			$log="Agrega la subcategoria: ";
			$consulta = "  
			INSERT INTO `subcategorias` (`descripcion`,`idcategoria`, `habilitado`, `idusuario`) VALUES ('$desc','$categ', '$habilitado', '$_SESSION[idusuario]');
			";
		break;
	case '2':
			$log="Modifica la subcategoria: ";
			$consulta = "  
			Update `subcategorias` set `descripcion` = '$desc',`idcategoria` = '$categ', `habilitado` = '$habilitado' , `idusuario`= '$_SESSION[idusuario]' where  `idsubcategoria`=$cod;
			";
		break;
}

$result = $conexion->query($consulta);

if($result){

		registra_log("Categorias",$log.$desc);
	header("Location: detalle_subcategorias.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar la categoria: ".mysql_error();
}
?>

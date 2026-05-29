<?php
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}


include("conexion.php");
include("functions.php");
$idusuario = $_SESSION['modifica'];
$usuario=$_POST['usuario'];
$clave=base64_encode($_POST['clave']);
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$idperfil = $_POST['perfiles'];

if (@$_POST['habilitado']!=0){
$habilitado=$_POST['habilitado'];
}else{
	$habilitado=0;
}

if ($idusuario!=0){
$accion="Modifica";
$consulta = "UPDATE usuarios SET usuario='$usuario' , password='$clave', nombre='$nombre', apellido='$apellido', email='$email' ,habilitado='$habilitado',idperfil='$idperfil' WHERE idusuario=$idusuario";
}else{
$accion="Crea";	
$consulta = "INSERT INTO usuarios ( usuario, password, nombre, apellido, email ,habilitado,idperfil) VALUES ('$usuario', '$clave','$nombre','$apellido','$email', '$habilitado', '$idperfil')";
}

$result = $conexion->query($consulta); 

if($result){
	registra_log("Usuarios",$accion." usuario: ".$usuario);

header("Location: alta_usuarios.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar el usuario por: ".mysql_error();
}

?>

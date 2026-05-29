<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}


include("conexion.php");
include("functions.php");

$query=("DELETE FROM `perfiles` WHERE idperfil=".$_GET['id'].";");


$result = mysql_query($query,$conexion); 
if($result){
registra_log("Perfiles","Se ha eliminado el perfil id: ".$_GET['id']);	
header("Location: alta_perfiles.php");
}else{
echo "no se ha podido dar de baja el perfil ".mysql_error();
}


?>

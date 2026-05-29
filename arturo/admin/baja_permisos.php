<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include("conexion.php");
include("functions.php");

$query=("DELETE FROM `menuperfil` WHERE idmenu=".$_GET['idmenu']." and idperfil=".$_GET['idperfil'].";");


$result = mysql_query($query,$conexion); 
if($result){
registra_log("Permisos","Se ha eliminado el permiso al menu id:".$_GET['idmenu']." al perfil id:".$_GET['idperfil']);	
header("Location: alta_permiso2.php");
}else{
echo $query."<br>";
echo "no se ha podido dar de baja el permiso ".mysql_error();
}


?>

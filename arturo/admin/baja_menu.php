<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<?php
include("conexion.php");

$query=("DELETE FROM `menu` WHERE idmenu=".$_GET['id'].";");


$result = mysql_query($query,$conexion); 
if($result){
header("Location: alta_menu.php");
}else{
echo $query."<br>";
echo "no se ha podido dar de baja el menu ".mysql_error();
}


?>
</body>
</html>
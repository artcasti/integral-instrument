<?php
session_start();

include("conexion.php");
$result = mysql_query("SELECT `menuperfil`.`idmenu`,`menuperfil`.`idperfil`,`perfiles`.`perfil`, `menu`.`label` FROM `menuperfil` JOIN `menu` ON `menuperfil`.`idmenu` = `menu`.`idmenu`
										join `perfiles` on `menuperfil`.`idperfil` = `perfiles`.`idperfil` WHERE `perfiles`.`idperfil` = ".$_GET['idperfil']." order by 3,4
										", $conexion);
echo "<table class='tablapermisos'>";										
while ($row = mysql_fetch_row($result))
{
	echo "<tr><td>".$row[3]."</td><td> <a href='baja_permisos.php?idmenu=".$row[0]."&idperfil=".$row[1]."'> Eliminar </a> </td></tr>";
	
}	
echo "</table>";

mysql_free_result($result);
mysql_close();
?>								
	
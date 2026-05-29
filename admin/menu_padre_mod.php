<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include "functions.php";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panel de Control del Sitio</title>

<link rel="stylesheet" type="text/css" href="estilos.css"/>

</head>

<body>
<?php
include("conexion.php");
?>
<div id="contenedor">
  <div id="logo"><a href="index.php"><img src="./img/logo_web.png" width="200" height="97" alt="Campo Austral" /></a></div>
   <div id="menu">
<?php 
crear_menu_padre($_SESSION['idperfil']);
 ?> 
</div>
  <div id="content">
  <h1 align="center">Menues Aplicacion</h1>
  
    <form id="form_menu" name="form_menu" method="post" action="menu_padre_procesa.php">
      <table class="tablareducida" align="center">
		<tr>
		<td>IdPadre</td>
		<td>Label</td>
		<td>Orden</td>
		<td></td>
		</tr>

<?php $fila= modifica_menu_padre($_GET['id']); 
$_SESSION['modifica']=$fila[0];

?>
	  <tr>
	  <td></td>

          <td><input type="text" name="label" id="label" value="<?php echo $fila[1]?>" /></td>
        
          <td><input type="text" name="orden" id="orden" value="<?php echo $fila[2]?>" /></td>
        
          <td colspan="2" align="center"><input type="submit" name="btn_enviar" id="btn_enviar" value="Grabar" class="modificar" />
        </tr>
    </form>
  
<?php
$result = mysql_query("SELECT * FROM menupadre order by idpadre", $conexion);
?>


<?php
while ($row = mysql_fetch_row($result)){
if($fila[0]!=$row[0]){ //FILTRO EL MENU QUE ESTOY MODIFICANDO
?>
<tr>
<td>
<a href="menu_padre_mod.php?id=<?php echo $row[0];?>" class="modificar"><?php echo $row[0];?></a>
</td>
<td><?php echo $row[1];?></td>
<td><?php echo $row[2];?></td>
<td>
	<a href="menu_padre_baja.php?id=<?php echo $row[0];?>" class="eliminar"> Eliminar </a>
</td>

</tr>
<?php
}
};
?>

</table>
<?php
mysql_free_result($result);
mysql_close();
?>

  </div>

  <div id="footer"></div>
</div>
</body>
</html>
<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Ayuda";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" href="css/wiz_form.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script type="text/javascript" src="js/guias.js"></script>	



<script type="text/javascript">
window.onload = function(){

	cargar_guias("*");
}
</script>

</head>

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>

<div id="content" align="center">
	<table align="center" class="tabla" border="1">
	<tr class="encabezado"><td colspan="4" align="center">ACCIONES</td></tr>
	<tr>

	<td align="center">Tarea<br>
		<select id="tarea" name = "tarea" onchange='accion_seleccionada()'>
			<option id="tarea" value=''>Seleccione...</option>
			<option id="tarea" value='V'>Ver Guias</option>
			<option id="tarea" value='C'>Crear Guia</option>
		</select>
	</td>	
	<td align="center"><input type="button" value="Ejecutar" onclick="procesar_tarea()" /></td>
	</tr>
	</table>
					<div id="servicios" align="center">
						
					</div>
</div>
  <div id="footer"></div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

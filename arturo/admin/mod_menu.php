<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Menues";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>OMG | Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui.js"></script>

</head>

<body>



<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>

  <div id="content">
  <h1 align="center">Menues Aplicacion</h1>
  
    <form id="form_menu" name="form_menu" method="post" action="graba_menu.php">
      <table class="tabla" align="center">
    <thead>    
		<tr>
		<td>IdMenu</td>
		<td>Label</td>
		<td>Href</td>
		<td>Orden</td>
		<td>ID Padre</td>
		<td></td>
		</tr>
    </thead>
<?php $fila= modifica_menu($_GET['id']); 
$_SESSION['modifica']=$fila[0];

?>
	  <tr>
	  <td></td>
          <td><input type="text" name="label" id="label" value="<?php echo $fila[1]?>" /></td>
        
          <td><input type="text" name="href" id="href" value="<?php echo $fila[2]?>" /></td>
        
          <td><input type="text" name="orden" id="orden" value="<?php echo $fila[3]?>" /></td>
        
          <td><input type="text" name="padre" id="padre" value="<?php echo $fila[4]?>"  /></td>
        
          <td colspan="2" align="center"><input type="submit" name="btn_enviar" id="btn_enviar" value="Grabar" class="modificar" />
        </tr>
    </form>
  
<?php
$result = mysql_query("SELECT * FROM menu order by idmenu", $conexion);
?>


<?php
while ($row = mysql_fetch_row($result)){
if($fila[0]!=$row[0]){ //FILTRO EL MENU QUE ESTOY MODIFICANDO
?>
<tr>
<td>
<a href="mod_menu.php?id=<?php echo $row[0];?>" class="modificar"><?php echo $row[0];?></a>
</td>
<td><?php echo $row[1];?></td>
<td><?php echo $row[2];?></td>
<td><?php echo $row[3];?></td>
<td><?php echo $row[4];?></td>
<td>
	<a href="baja_menu.php?id=<?php echo $row[0];?>" class="eliminar"> Eliminar </a>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
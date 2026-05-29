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
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>OMG | Panel de Control</title>
   
   	<link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script lenguage:"javascript" type="text/javascript" >
		
		
		function muestra_info(div)
		{	
			
			$("#div_left45").load("alta_permiso_div.php?idperfil="+div);
		}

		
		
</script>


</head>

<body>
<?php
include("conexion.php");
?>

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>

<div id="contenedor">
<div id="content">
<h1 align="center">Permisos del perfil</h1>
	
	
	
	<div>
	<form action='graba_permisos2.php' method='post'>
		<div id='div_left3'>
			<div><table style='width:200px;'><tr style='background-color:#000;text-align:center;font-size:20px;color:#FFF;'><td>Permisos</td></tr></table></div>
			<div  id="div_left2">
				<table class="tablapermisos">
					<?php carga_select('menues2','');?>
				</table>
			</div>
		</div>
		<div id='div_left3'>
			<button type='submit' style='height:430px;width:100px;;'>Asignar >>> </button>
		</div>
		<div id='div_left3'>
			<div><table style='width:200px;'><tr style='background-color:#000;text-align:center;font-size:20px;color:#FFF;'><td>Perfiles</td></tr></table></div>
			<div  id="div_left2">
				<table class="tablapermisos">
					<?php carga_select('perfiles2','');?>
				</table>
			</div>
		</div>
	</form>
	</div>
	
	
		<?php
		$result = mysql_query("SELECT `menuperfil`.`idmenu`,`menuperfil`.`idperfil`,`perfiles`.`perfil`, `menu`.`label` FROM `menuperfil` JOIN `menu` ON `menuperfil`.`idmenu` = `menu`.`idmenu`
		join `perfiles` on `menuperfil`.`idperfil` = `perfiles`.`idperfil` order by 3,4
		", $conexion);
		?>
		<div id='div_left3'>
			<div><table style='width:400px;'><tr style='background-color:#000;text-align:center;font-size:20px;color:#FFF;'><td>Quitar permiso</td></tr></table></div>
			<div id='div_left4'>
				<table class='tablapermisos'>
				<?php
				$anterior="-55";
					while ($row = mysql_fetch_row($result))
					{
						if($row[1]==$anterior)
						{
							
						}
						else
						{
							$anterior=$row[1];
							echo"<tr><td>".$row[2]."</td><td><a href=# onclick=muestra_info('".$row[1]."')> Mostrar </a></td></tr>";
							
						}
						
					}
					
				?>
				</table>
			</div>
			<div id='div_left45'>
			</div>
		</div>
		
	
	
	

<?php
mysql_free_result($result);
mysql_close();
?>
</div>
</div>
</div>

<div id="footer">
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
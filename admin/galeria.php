<?php
session_start();

include "functions.php";
include("conexion.php");

  $path = $_GET['path'];
  $galeria = $_GET['galeria'];
  $size = 90;

		$consulta="SELECT * FROM `galerias_items` WHERE `idgaleria`=$galeria";

		$result = mysql_query($consulta,$conexion);

?> 
<div class="content">
<h1>Contenido de la galeria</h1>
	<table class="tabla" border="1">
	<thead>
	<tr>
		<td>Nombre</td>
		<td>Previsualizacion</td>
		<td></td>
	</tr>
	</thead>
	<?php while ($fila=mysql_fetch_array($result)){ ?>
	<tr>	
		<td align="left"><?php echo $fila[1]?></td>		
		<td align="center"><img src='<?php echo $path."/".$fila[1];?>' height="<?php echo $size;?>" width="<?php echo $size;?>"></td>
		<td align="center"><input type="button" value="Eliminar" onclick="eliminar_item(<?php echo $fila[0];?>)"></td>
	</tr>	
	<?php };?>
	</table>

<?php 	
$result = mysql_query($consulta,$conexion);
	while ($fila=mysql_fetch_array($result)){ 
		$img[]=$fila[1];
	}
 ?>
	
	<h1>Como se vera en la pagina</h1>
	<table>
	<tr>
		<td colspan="4"><img id="img_0" src='<?php echo $path."/".$img[0];?>' height="400" width="490"></td>
	</tr>
	<tr>	
		<td align="center"><img id="img_1" src='<?php echo $path."/".$img[1];?>' height="90" width="115" onclick="visualizar(1)"></td>		
		<td align="center"><img id="img_2" src='<?php echo $path."/".$img[2];?>' height="90" width="115" onclick="visualizar(2)"></td>		
		<td align="center"><img id="img_3" src='<?php echo $path."/".$img[3];?>' height="90" width="115" onclick="visualizar(3)"></td>		
		<td align="center"><img id="img_4" src='<?php echo $path."/".$img[4];?>' height="90" width="115" onclick="visualizar(4)"></td>		
	</tr>	
	</table>
</div>
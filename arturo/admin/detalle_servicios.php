<?php 
header('Content-Type: text/html; charset=utf-8'); 

include "functions.php";
include "conexion.php";

 ?>	  
	    <h1 align="center">Servicios </h1>

	      <table align="center" class="tabla" border="1">
	        <thead>
	      		<tr>
	      		<td>Id</td>
	      		<td>Nombre</td>
	      		<td>Categoría</td>
	      		<td>Subategoría</td>
	      		<td>Imagen</td>
	      		<td>Estado</td>	      		
	      		<td>Accion</td>
	      		</tr>
	    		</thead>
	<?php
		$path="galery/";
		$estados = $_GET['estados'];

		$res1=listar_servicios($estados);

	while ($row = mysql_fetch_row($res1)){	
	?>
	<tr>
	<td>
	<a href="wiz_cursos.php?indice=1&id=<?php echo $row[0];?>" class="modificar"><span class="icon-pencil" id="btnmod"></a>
	</td>
	<td><?php echo $row[1];?></td>
	<td><?php echo $row[3];?></td>
	<td><?php echo $row[5];?></td>
	<td><img src="<?php echo $path.$row[6];?>" height="80" width="80"></td>
	<td><?php if($row[9]=='0'){ echo "Articulo Deshabilitado";}else{if($row[10]=='0'){ echo "Articulo Publicado";}else{echo "Articulo DESTACADO";}}?></td>
	<td align="center">
		<?php
        if($row[9]=='0'){
		?>
		<a onclick="cambiar_estado_servicio(<?php echo $row[0]?>,'1');"><span title="Habilitar" class="icon-eye" id="btneye"></span></a><?php
		}else{?>
		<a onclick="cambiar_estado_servicio(<?php echo $row[0]?>,'0');"><span title="Deshabibilitar" class="icon-eye-slash" id="btneyes"></span></a>
		<?php
		}

        if($row[10]=='0'){
		?>
		<a onclick="cambiar_estado_destacado(<?php echo $row[0]?>,'1');"><span title="Publicar en Index" class="icon-star-empty" id="btnstar"></span></a><?php
		}else{?>
		<a onclick="cambiar_estado_destacado(<?php echo $row[0]?>,'0');"><span title="Sacar del Index" class="icon-star" id="btnstarf"></span></a>
		<?php
		}?>

		<a onclick="elimina_servicio(<?php echo $row[0];?>)" class="eliminar"><span title="Eliminar" class="icon-trash-o" id="trash"></span></a>
	</td>

	</tr>
	<?php
	};
	?>

	</table>

	<?php
	mysql_free_result($res1);
	mysql_close();
	?>
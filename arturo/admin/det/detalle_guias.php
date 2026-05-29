<?php 
header('Content-Type: text/html; charset=utf-8'); 

include "../functions.php";
include "../conexion.php";

 ?>	  
	    <h1 align="center">Guias Paso a Paso </h1>

	      <table align="center" class="tabla" border="1">
	        <thead>
	      		<tr>
	      		<td>Id</td>
	      		<td>Titulo</td>
	      		<td>Descripcion</td>
	      		<td>Estado</td>	      		
	      		<td>Accion</td>
	      		</tr>
	    		</thead>
	<?php
		$estados = $_GET['estados'];

		$res1=listar_guias($estados);

	while ($row = mysql_fetch_row($res1)){	
	?>
	<tr>
	<td>
	<a href="wiz_cursos.php?indice=1&id=<?php echo $row[0];?>" class="modificar"><span class="icon-pencil" id="btnmod"></a>
	</td>
	<td><?php echo $row[1];?></td>
	<td><?php echo $row[2];?></td>
	<td><?php if($row[3]=='0'){ echo "Guia Deshabilitada";}else{echo "Guia Publicada";}?></td>
	<td align="center">
		<?php
        if($row[3]=='0'){
		?>
		<a onclick="cambiar_estado_guia(<?php echo $row[0]?>,'1');"><span title="Habilitar" class="icon-eye" id="btneye"></span></a><?php
		}else{?>
		<a onclick="cambiar_estado_guia(<?php echo $row[0]?>,'0');"><span title="Deshabibilitar" class="icon-eye-slash" id="btneyes"></span></a>
		<?php
		}?>
		<a onclick="elimina_guia(<?php echo $row[0];?>)" class="eliminar"><span title="Eliminar" class="icon-trash-o" id="trash"></span></a>
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
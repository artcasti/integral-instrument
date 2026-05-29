<?php 
include "functions.php";
include "conexion.php";

 ?>	  
	    <h1 align="center">Categorías</h1>
	  
	    <form id="form_categoria" name="form_categoria" method="post" action="graba_categoria.php">

	      <table align="center" class="tabla">
	        <thead>
	      		<tr>
	      		<td>IdCategoría</td>
	      		<td>Categoría</td>
	      		<td>Habilitada</td>
	      		<td></td>
	      		</tr>
	    		</thead>

			      <td><input type="text" name="codigo" id="codigo" readonly /></td>
			      <td><input type="text" name="desc" id="desc" onkeypress='text_GrabaSetFocus(event)' /></td>
			      <td><input type="checkbox" name="checkhab" id="checkhab" value="1" checked /></td>
			      <td><input type="button" id="grabar" value="Grabar" onclick="validacion_cabecera()" /></td>
			      	      <input type="hidden" name="accion" id="accion" value="1" />
	        </tr>
	    </form>

	<?php
	$result = mysql_query("SELECT * FROM categorias", $conexion);
	?>


	<?php
	while ($row = mysql_fetch_row($result)){
	?>
	<tr>
	<td>
	<a onclick="modifica_item('<?php echo $row[0]?><?php echo '+'?><?php echo $row[1]?><?php echo '+'?><?php echo $row[2]?>');" class="modificar"><?php echo $row[0];?></a>
	</td>
	<td><?php echo $row[1];?></td>
	<td>
		<?php
		if($row[2]==1){
		?>
		<input name="habilitado" type="checkbox" id="habilitado" value="1" checked="checked" /><?php
		}else{?>
		<input name="habilitado" type="checkbox" id="habilitado" value="0" /><?php
		}?>
	</td>

	<td>
		<a onclick="elimina_item('<?php echo $row[0]?><?php echo '+'?><?php echo $row[1]?>');" class="eliminar"> Eliminar </a>
	</td>

	</tr>
	<?php
	};
	?>

	</table>
	<?php
	mysql_free_result($result);
	mysql_close();
	?>
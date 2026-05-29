<?php
header('Content-Type: text/html; charset=utf-8'); 
include "functions.php";
include "conexion.php";

$categoria = 0;

if(isset($_GET['categ'])){$categoria=$_GET['categ'];}

 ?>	  
	    <h1 align="center">Subcategorías</h1>
	  
	    <form id="form_subcategoria" name="form_subcategoria" method="post" action="graba_subcategoria.php">

	      <table align="center" class="tabla">
	        <thead>
	      		<tr>
	      		<td>Id</td>
	      		<td>Subcategoría</td>
	      		<td>Categoría</td>
	      		<td>Habilitada</td>
	      		<td></td>
	      		</tr>
	    		</thead>

			      <td><input type="text" name="codigo" id="codigo" readonly /></td>
			      <td><input type="text" name="desc" id="desc" onkeypress='text_GrabaSetFocus(event)' /></td>
					<td align="center">
						<select id='categoria' name='categoria' >
						<option value='C'>Seleccione...</option>						
						<?php 
						carga_selected("categorias",0,"");
						?>
						
					</td>
			      <td><input type="checkbox" name="checkhab" id="checkhab" value="1" checked /></td>
			      <td><input type="button" id="grabar" value="Grabar" onclick="validacion_cabecera()" /></td>
			      	      <input type="hidden" name="accion" id="accion" value="1" />
	        </tr>
	    </form>

	<?php
    if ($categoria==0){
	$con="SELECT * FROM subcategorias as scat left join categorias as cat on scat.idcategoria=cat.idcategoria";
	} else {
	$con="SELECT * FROM subcategorias as scat left join categorias as cat on scat.idcategoria=cat.idcategoria
            WHERE scat.idcategoria = ".$categoria."
            ";        
    }
    $result = $conexion->query($con);
	?>


	<?php
	while ($row = mysqli_fetch_row($result)){
	?>
	<tr>
	<td>
	<a onclick="modifica_item('<?php echo $row[0]?><?php echo '+'?><?php echo $row[1]?><?php echo '+'?><?php echo $row[2]?><?php echo '+'?><?php echo $row[3]?>');" class="modificar"><?php echo $row[0];?></a>
	</td>
	<td><?php echo $row[1];?></td>
	<td><?php echo $row[6];?></td>	
	<td>
		<?php
		if($row[3]==1){
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
	mysqli_free_result($result);
	$conexion->close();
	?>
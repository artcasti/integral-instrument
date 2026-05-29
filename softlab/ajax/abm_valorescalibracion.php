<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$familia = (isset($_GET['id']))?$_GET['id']:0;

  $resultado = $cm->getValoresCalibracion($familia);

	if($resultado){
		$cant = $resultado->num_rows;
		if($cant>0){
		echo "<h4>Valores configurados</h4>";
	?>
				<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>ID</th>
							<th>Valor Nominal</th>
							<th>Unidad</th>
							<th>Acciones</th>
						</tr>

	<?php
	while ($row=$resultado->fetch_array()){ 
		$unidad = $row['unidad'];
  	?>
						<tr class="active">
						<th scope="row"><?php echo $row['id'];?></th>
						<td><?php echo $row['valornominal'];?></td>
						<td><?php echo $row['unidad'];?></td>
						<td><a href="#" onclick="editaValor(<?php echo $row['id'];?>,'<?php echo $row['valornominal'];?>')" ><i class="fa fa-edit accion_icon" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminavalornominal&id=<?php echo $row[0];?>&idfamilia=<?php echo $familia;?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o accion_icon" title="Eliminar"></i></a>
                        </td>
						</tr>	


<?php }
	
	?>
					<input type="hidden" name="unidadmedida" id="unidadmedida" value="<?php echo $unidad; ?>">
						</table>				
					</div>
				</div>
	
	<?php
	}else{echo "<h4>No hay valores configurados para esta familia</h4>";}}else{
		
	} ?>
	



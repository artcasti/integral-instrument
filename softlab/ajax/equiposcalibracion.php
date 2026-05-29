<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$familia = (isset($_GET['id']))?$_GET['id']:0;

  $resultado = $cm->getListaEquiposCalibraciones($familia);

	if($resultado){
		$cant = mysqli_num_rows($resultado);
		if($cant>0){
		echo "<h4>Seleccione los equipos a calibrar</h4>";
	?>
				<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>Nro Ingreso</th>
							<th>Cliente</th>
							<th>Fecha Ingreso</th>
							<th>Equipo</th>
							<th><input type="checkbox" id="selectall"></th>
						</tr>

	<?php
	while ($row=$resultado->fetch_array()){ 
  	?>
						<tr class="active">
						<th scope="row"><?php echo $row['nroingreso'];?></th>
						<td><?php echo $row['nombre'];?></td>
						<td><?php echo $row['fechaingreso'];?></td>
						<td><?php echo $row['marca'].'-'. $row['modelo'].'-'. $row['nroserie'];?></td>
						<td><input type="checkbox" name="equipos[]" class="equipos" value="<?php echo $row['idequipo'].'+'.$row['nroingreso'];?>"></td>
						</tr>	


<?php }
	
	?>
						</table>				
					</div>
				</div>
	
	<?php
	}else{echo "<h4>No hay equipos para calibrar</h4>";}}else{
		
	} ?>
	


<script>
$('#selectall').click(function() {
    var c = this.checked;
    $(':checkbox.equipos ').prop('checked',c);
});
</script>


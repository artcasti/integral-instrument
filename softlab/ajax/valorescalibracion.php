<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$familia = (isset($_GET['id']))?$_GET['id']:0;

  $resultado = $cm->getValoresCalibracion($familia);

	if($resultado){
		$cant = mysqli_num_rows($resultado);
		if($cant>0){
		echo "<h4>Seleccione los valores a recolectar</h4>";
	?>
				<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>ID</th>
							<th>Valor Nominal</th>
							<th>Unidad de Medida</th>
							<th><input type="checkbox" id="selectall"></th>
						</tr>

	<?php
	while ($row=$resultado->fetch_array()){ 
  	?>
						<tr class="active">
						<th scope="row"><?php echo $row['id'];?></th>
						<td><?php echo $row['valornominal'];?></td>
						<td><?php echo $row['unidad'];?></td>
						<td><input type="checkbox" name="valores[]" class="valores" value="<?php echo $row['id'].'+'.$row['valornominal'];?>"></td>
						</tr>	


<?php }
	
	?>
						</table>				
					</div>
				</div>
	
	<?php
	}else{echo "<h4>No hay valores configurados para esta familia</h4>";}}else{
		
	} ?>
	


<script>
$('#selectall').click(function() {
    var c = this.checked;
    $(':checkbox.valores  ').prop('checked',c);
});
</script>


<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$id = (isset($_GET['id']))?$_GET['id']:0;
$equipo=(isset($_GET['equipo']))?$_GET['equipo']:0;
$idvalor =(isset($_GET['idvalor']))?$_GET['idvalor']:0;
$patron = (isset($_GET['idpatron']))?$_GET['idpatron']:0;

$medidapatron = $cm->getMedidaPatron($id,$idvalor,$equipo)[0];

?>

<div class="form-group">
<form action="class/manager_abms.php" method="post" id="formvalores">
<input type="hidden" name="abm" value="carga_valores">
<input type="hidden" name="idcalibracion" value="<?php echo $id;?>">
<input type="hidden" name="idpatron" value="<?php echo $patron;?>">
<input type="hidden" name="equipo" value="<?php echo $equipo;?>">
<input type="hidden" name="idvalor" value="<?php echo $idvalor;?>">
<div class="col-md-6 col-md-offset-3">
		<label class="control-label " for="vmp">Valor medido por equipo patrón </label><input type="text" class="valorpatron" name="vmp" id="vmp" value="<?php echo $medidapatron;?>">
		</div>  
		&nbsp;
	<div class="col-md-12">

		<table class="table" >
		<tr class="active">
			<th>Equipo</th>
			<th>Valor Sin Ajuste</th>
			<th>Valor Ajustado</th>
			<th>Observaciones</th>
		</tr>

		<?php

		$resultado = $cm->getCalibracionMediciones($id,$equipo,$idvalor);
		while ($row=$resultado->fetch_array()){ 
			$infoequipo = $cm->getEquipo($row[1]);
		?>
		<tr class="active">
		
		<th scope="row"><?php echo $infoequipo['marca'].'-'. $infoequipo['modelo'].'-'. $infoequipo['nroserie'];?></th>
		<td><input type="text" class="ingvalor" name="vsa_<?php echo $row['idequipo'];?>" value="<?php echo $row['medsinajuste'];?>"></td>
		<td><input type="text" class="ingvalor" name="vaj_<?php echo $row['idequipo'];?>" value="<?php echo $row['medajustado'];?>"></td>
		<td><textarea name="obs_<?php echo $row['idequipo'];?>" cols="30" rows="2"><?php echo $row['observaciones'];?></textarea></td>

		<?php }

			?>
		</table>				
	</div>
          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary">Enviar Formulario</button>
				</form>
            </div>

</div>

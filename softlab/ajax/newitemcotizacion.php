<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();
$id=$_GET['id'];
$text=$_GET['txtitem'];
$precio=$_GET['precioitem'];
$marca=$_GET['marca'];
$modelo=$_GET['modelo'];
$idequipo=$_GET['equipo'];

$subfamilia=$cm->getSubfamiliaEquipo($idequipo)[1];

$encabezadoitem = "Por el chequeo general, limpieza y calibración de ";
$finalitem = " Incluye certificado de calibracion.";

if($marca!='')
{
	$texto= $encabezadoitem.' '.$subfamilia.', Marca '.$marca.', Modelo '.$modelo.'.'.$finalitem;
}else
{
	$texto = $encabezadoitem.$finalitem;
}

?>
<div class="col-md-12 form-group1 group-mail" id="nuevoitem">
<input type="hidden" name="idequipo_<?php echo $id; ?>" id="idequipo_<?php echo $id; ?>" value='<?php echo $idequipo; ?>'>
<div class="col-md-1"><input type="text" name="id_<?php echo $id; ?>" id="id_<?php echo $id; ?>" value='<?php echo $id; ?>'></div>

<div class="col-md-1"><input type="text" name="cantidad_<?php echo $id; ?>" id="cantidad_<?php echo $id; ?>" value='1'></div>
	<div class="col-md-5"><textarea name="tarea_<?php echo $id; ?>" id="tarea_<?php echo $id; ?>" ><?php echo $texto; ?></textarea></div>
<div class="col-md-2"><input type="text" name="precio_<?php echo $id; ?>" id="precio_<?php echo $id; ?>" value='<?php echo $precio; ?>'></div>
<div class="col-md-2"><input type="text" class='totales' name="total_<?php echo $id; ?>" id="total_<?php echo $id; ?>" value='<?php echo $precio; ?>'></div>
	<div class="col-md-1"><a class="acciones" onClick="addOne(<?php echo $id; ?>)"><i class="fa fa-plus-circle" title="Suma 1"></i></a> <a class="acciones" onClick="resOne(<?php echo $id; ?>)"><i class="fa fa-minus-circle" title="Resta 1"></i></a><a class="acciones" onClick="bonifica(<?php echo $id; ?>)"><i class="fa fa-gift" title="Bonifica"></i></a></div>
</div>
<!--<div class="col-md-5"><input type="text" name="tarea_<?php echo $id; ?>" value="<?php echo $text; ?>"></div>-->

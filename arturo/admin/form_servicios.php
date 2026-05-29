<?php
session_start();

include "functions.php";
include("conexion.php");

$id=$_GET['id'];

$path="galery";

if ($id==0) {
$nombre ='';
$categoria ='0';
$subcategoria ='0';
$imagenppal ='';
$galeria ='0';
$descripcion ='';
$imagenadic ='';
$video ='';
$descripcionadic ='';

}else{

		$consulta="SELECT * FROM `servicios` WHERE `idservicio`= '$id'";

		$result = mysql_query($consulta,$conexion);

		if($result){
			$row=mysql_fetch_array($result);
			
			$nombre =$row[1];
			$categoria =$row[2];
			$subcategoria =$row[3];
			$imagenppal =$row[5];
			$galeria =$row[6];
			$descripcion =$row[4];
			$imagenadic =$row[8];
			$video =$row[9];
			$descripcionadic =$row[7];

			}

}

?> 
<div class="content">
<h1>Alta de Servicio</h1>
<form action="abm_servicios_manager.php" method="post" enctype="multipart/form-data" name="frmservicios">
<input type="hidden" name="tarea" value="<?php if ($id==0) {echo 'A';}else{echo 'U';} ?> ">
<input type="hidden" name="id" value="<?php echo $id;?>">
<table>
	<tr>
		<td>Nombre del Servicio</td>
		<td><input type="text" name="nombre" value="<?php echo $nombre; ?>"></td>
		<td></td>
	</tr>
	<tr>
		<td>Categoria</td>
		<td>
			<select id='categoria' name='categoria' onchange="llenasubcateg(this.value,<?php echo $subcategoria; ?>)">
			<option value=''>Seleccione...</option>						
			<?php 
			carga_selected("categorias",$categoria,"");
			?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>Subcategoria</td>
		<td>
		<div id="selsubcateg">
			<select id='subcategoria' name='subcategoria' >
			<option value=''>Seleccione...</option>						
		</div>	
		</td>
		<td></td>
	</tr>
	<tr>
		<td>Imagen Principal</td>
		<td>
			<select id='imagenppal' name='imagenppal' onchange="previsualiza_ppal(this.value,'previewppal','<?php echo $path?>')">
			<option value=''>Seleccione...</option>						
			<?php 
			carga_selected("imagenesdisponibles",$imagenppal,$path);
			?>
		</td>
		<td><img src="" id="previewppal" ></td>
	</tr>
	<tr>
		<td>Galeria de imagenes</td>
		<td>
			<select id='selgaleria' name='selgaleria' >
			<option value=''>Seleccione...</option>						
			<?php 
			carga_selected("galerias",$galeria,"");
			?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>Descripcion</td>
		<td colspan="2"><textarea name="descripcion" id="desripcion" cols="100" rows="10"><?php echo $descripcion; ?></textarea></td>
	</tr>	
	<tr>
		<td>Imagen Adicional</td>
		<td>
			<select id='imagenadic' name='imagenadic' onchange="previsualiza_ppal(this.value,'previewadic')">
			<option value=''>Seleccione...</option>						
			<?php 
			carga_selected("imagenesdisponibles",$imagenppal,$path);
			?>
		</td>
		<td><img src="" id="previewadic" ></td>
	</tr>
	<tr>
		<td>Video</td>
		<td><input type="text" name="video" value="<?php echo $video; ?>"></td>
		<td></td>
	</tr>

	<tr>
		<td>Descripcion Adicional</td>
		<td colspan="2"><textarea name="descripcionadicional" id="desripcionadicional" cols="100" rows="10"><?php echo $descripcionadic; ?></textarea></td>
	</tr>	
	<tr>
		<td></td>
		<td><input type="submit" value="Enviar"></td>
		<td></td>
	</tr>
</table>
</form>



</div>
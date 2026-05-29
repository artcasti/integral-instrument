<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 

include "functions.php";
include("conexion.php");

$id=$_GET['id'];



$descripcionadicional ='';
$video ='';
$materialadicional ='';
$imagenadicional='';

		$consulta="SELECT * FROM `servicios` WHERE `idservicio`= '$id'";

		$result = $conexion->query($consulta);

		if($result){
			$row=$result->fetch_array();
            $descripcionadicional =$row[7];
            $video =$row[10];
            $materialadicional=$row[9];
            $categoria =$row[2];
			$imagenadicional=$row[8];
			}
switch ($categoria){
    case "1":
        $origen="window.location='listar_cursos.php';";
        break;    
    case "2":
        $origen="window.location='listar_servicios.php';";
        break;    
    case "3":
        $origen="window.location='listar_novedades.php';";
        break;    
    
}


?> 


<div class="contenido_wizard">
<div class="titulo__pagina">
    <p>Alta de Artículo  3/3 </p>
</div>
<p class="titulo_cuadro">Información adicional</p>

<div class="info__ppal" align="center">

    <div class="fila__form_texto">
       
        <label for="descripcion">Descripcion</label>
		<textarea name="descripcionadicional" id="descripcionadicional"  class="form__textarea" onchange="Espejar('desc');"><?php echo $descripcionadicional; ?></textarea>

    </div>
    <div class="fila__form__video">
        <label for="video">Video</label>
		<input type="text" name="video" id="video" value="<?php echo $video; ?>" onchange="Espejar('video');" >
    </div>
    
        <div class="fila__form__archivo">
        <form action="carga_imagenes_wiz.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
           <input type="hidden" name="id" value="<?php echo $id;?>">
           <input type="hidden" name="ppal" value="4">
           <input type="hidden" name="descadicionalhidden" id="descadicionalhidden" value="<?php echo $descripcionadicional; ?>">
           <input type="hidden" name="videohidden" id = "videohidden" value="<?php echo $video; ?>">
            <label for="selectfile">Archivo</label>
            <input type="file" name="selectfile" id="selectfile" accept=".pdf,.doc,.docx">
            <input type="submit" value="Cargar">
            <input type="text" name="archivopdf" id="archivopdf" value="<?php echo $materialadicional; ?>">
            <img src="img/eliminar.png">    
        </form>    
    </div>
    
        <div class="fila_paso2">	
    <div class="fila__form__files_adicional">
        <form action="carga_imagenes_wiz.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
           <input type="hidden" name="id" value="<?php echo $id;?>">
           <input type="hidden" name="descadicionalhidden" id="descadicionalhidden2" value="<?php echo $descripcionadicional; ?>">
           <input type="hidden" name="videohidden" id = "videohidden2" value="<?php echo $video; ?>">           
           <input type="hidden" name="ppal" value="2">
           <label for="selecfile">Imagen extra</label>
            <input type="file" name="selectfile" id="selectfile" accept=".jpg,.jpeg,.png">
            <input type="submit" value="Cargar">
        </form>    
    </div>
    <div class="fila__form_imgadicional">
    <img src="<?php echo 'galery/'.$imagenadicional;?>">
    <a onclick="EliminaImagen(<?php echo $id;?>,'adic');" class="eliminar"><img src="img/eliminar.png" alt="eliminar" class="icono_accion"></a>
    </div>
    </div>
    
    
    <div class="fila__form">
    <input type="button" value="Cancelar" id="btncan" onclick="<?php echo $origen;?>">
    <input type="button" value="Anterior" id="btnsig" onclick="CargarPaso(2,<?php echo $id;?>);">
    <input type="button" value="Finalizar" id="btnsig" onclick="finalizar(<?php echo $categoria;?>,<?php echo $id;?>);">
    </div>
</div>
</div>


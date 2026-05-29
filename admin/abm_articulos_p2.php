<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
include "functions.php";
include("conexion.php");

$id=$_GET['id'];


$imagenppal ='';
$imagenadic ='';


	$consul="SELECT * FROM `servicios` WHERE `idservicio`= '$id'";

		$resulta = $conexion->query($consul);

		if($resulta){
			$row=$resulta->fetch_array();
			
			$imagenppal =$row[5];
			$imagenadic =$row[8];
             $categoria =$row[2];
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
    <p>Alta de Artículo  2/3 </p>
</div>
<p class="titulo_cuadro">Imágenes</p>
<div class="info__ppal" align="center">
    
    <div class="fila_paso2">	
    <div class="fila__form__files">
    <p class="texto__info">Cargue las imágenes y la ubicación donde quiere que se visualicen</p>
        <form action="carga_imagenes_wiz.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
           <input type="hidden" name="id" value="<?php echo $id;?>">
           <input type="hidden" name="ppal" value="">
            <input type="file" name="selectfile" id="selectfile" accept=".jpg,.jpeg,.png">
            <input type="submit" value="Cargar">
          <div class="seleccion">
           <input type="radio" name="ppal" value="1" <?php if(trim($imagenppal)==''){echo "checked";}else{echo "";};?>>Imagen Principal
           <input type="radio" name="ppal" value="3" <?php if(trim($imagenppal)!=''){echo "checked";}else{echo "";};?>>Galería
           </div>    
        </form>    
    </div>
    <div class="fila__form_imgppal">
    <p>Imagen Principal</p>
    <img src="<?php echo 'galery/'.$imagenppal;?>">
    <a onclick="EliminaImagen(<?php echo $id;?>,'ppal');" class="eliminar"><img src="img/eliminar.png" alt="eliminar" class="icono_accion"></a>
    </div>
    </div>
    
    <div class="fila_paso2_galeria">
    <p>Galería</p>
    <div class="fila__form">
       
        <?php 
		$consulta="SELECT * FROM `galerias_items` WHERE `idgaleria`= '$id'";

		$result = $conexion->query($consulta);

		if($result){
			while($row=$result->fetch_array()){?>
       <div class="item__galeria">
                <img src="<?php echo 'galery/'.$row[1];?>" class="imagen__galeria">
        		<a onclick="elimina_imagen(<?php echo $row[0];?>,<?php echo $id;?>)" class="eliminar"><img src="img/eliminar.png" alt="eliminar" class="icono_accion"></a>
        </div>		
        <?php }};?>
    
    </div>
    </div>
    <div class="fila__form">
    <input type="button" value="Cancelar" id="btncan" onclick="<?php echo $origen;?>">
    <input type="button" value="Anterior" id="btnsig" onclick="CargarPaso(1,<?php echo $id;?>);">
    <input type="button" value="Siguiente" id="btnsig" onclick="SiguientePaso(2,<?php echo $id;?>);">
    </div>
</div>

</div>

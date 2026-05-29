<?php
session_start();

include "functions.php";
include("conexion.php");

$id=$_GET['id'];

$path="galery";
$sin="sin-imagen.jpg";

if ($id==0) {
$nombre ='Titulo';
$categoria ='0';
$subcategoria ='0';
$imagenppal ='sin-imagen.png';
$galeria ='0';
$descripcion ='Ingrese su descripcion';
$imagenadic ='sin-imagen.png';
$video ='link de youtube';
$descripcionadic ='Ingrese una descripcion adicional';

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
<div class="imagenes__form" align="center">
<h1>Alta de Articulos</h1>
<form action="abm_servicios_manager.php" method="post" enctype="multipart/form-data" class="frmservicios" name="frmservicios">
<input type="hidden" name="tarea" value="<?php if ($id==0) {echo 'A';}else{echo 'U';} ?> ">
<input type="hidden" name="id" value="<?php echo $id;?>">

        
        <div class="linea__form">
            <label for="categoria">Categoria</label>
                <select id='categoria' name='categoria' onchange="llenasubcateg(this.value,<?php echo $subcategoria; ?>)">
                <option value=''>Seleccione...</option>						
                <?php 
                carga_selected("categorias",$categoria,"");
                ?>
        </div>

        <div class="linea__form">
    		<label for="subcategoria">Subcategoria</label>
                <div id="selsubcateg">
                    <select id='subcategoria' name='subcategoria' >
	
                <?php 
                carga_selected("subcategorias",$subcategoria,$categoria);
                ?>					
                </div>
        </div>
        
        <div class="linea__form">
		<label for="nombre">Nombre del Servicio</label>
		<input type="text" name="nombre" value="<?php echo $nombre; ?>">
        </div>
        
        
        <?php if($id==0){ ?>
        <div class="linea__form">
            <label for="">Imagenes</label>
                <div class="file__select">
                    <input type="file" name="imagenppal">
                    <input type="file" name="imagen2">
                    <input type="file" name="imagen3">
                    <input type="file" name="imagen4">
                    <input type="file" name="imagen5">
                </div>

        </div>       
        <?php } else { 
        
         $consul ="SELECT * FROM `galerias_items` WHERE `idgaleria`= '$id'";

		$resulta = mysql_query($consul,$conexion);?>
		
      <div class="linea__form">
            <label for="">Imagenes</label>
                <div class="file">


		<?php if($resulta){ ?>

        <?php			 
            while ($row=mysql_fetch_array($resulta)){?>
			<img src="<?php echo $path.'/'.$row[1];?>" alt="" name="imagen">
        <?php    
            };
			
        };
        ?>
                </div>
        </div>       

        <?php
        };
    
        ?>

        <div class="linea__form">
        <label for="descripcion">Descripcion</label>
		<textarea name="descripcion" id="desripcion"  class="form__textarea"><?php echo $descripcion; ?></textarea>
        </div>
        
        <div class="linea__form">
        <label for="imagenadicional">Imagen Adicional</label>
        <div class="file">
            <input type="file" name="imagenadicional">
        </div>

        </div>
		
        <div class="linea__form">
		<label for="video">Video</label>
		<input type="text" name="video" value="<?php echo $video; ?>">
        </div>
		
        <div class="linea__form">
		<label for="descripcionadicional">Descripcion Adicional</label>
		<textarea name="descripcionadicional" id="desripcionadicional" class="form__textarea"><?php echo $descripcionadic; ?></textarea>
        </div>
		
		<input type="submit" id="btn-enviar" value="Enviar">
</form>



</div>
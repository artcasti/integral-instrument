<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
include "functions.php";
include("conexion.php");

$id=$_GET['id'];



if ($id==0) {
$tipo=$_GET['tipo'];
$nombre ='';
$categoria =$tipo;
$subcategoria ='0';
$descripcion ='';

}else{

		$consulta="SELECT * FROM `servicios` WHERE `idservicio`= '$id'";

		$result = $conexion->query($consulta);

		if($result){
			$row=$result->fetch_array();
			
			$nombre =$row[1];
			$categoria =$row[2];
			$subcategoria =$row[3];
			$descripcion =$row[4];
			}

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
    <p>Alta de Artículo  1/3 </p>
</div>
<p class="titulo_cuadro">Información básica</p>
<div class="info__ppal" align="center">

    <div class="fila__form">
        <label for="categoria">Categoria</label>
        <select id='categoria' name='categoria' onchange="llenasubcateg(this.value,<?php echo $subcategoria; ?>)" disabled>
                <option value=''>Seleccione...</option>						
                <?php 
                carga_selected("categorias",mb_convert_encoding($categoria, 'UTF-8', 'ISO-8859-1'),"");
                ?>
        <label for="subcategoria">Subcategoria</label>
        <div id="selsubcateg">
                    <select id='subcategoria' name='subcategoria' >
	                <option value='0'>Seleccione...</option>	
                <?php 
                carga_selected("subcategorias",mb_convert_encoding($subcategoria, 'UTF-8', 'ISO-8859-1'),$categoria);
                ?>					
                </div>
    </div>
    <div class="fila__form">
        <label for="nombre">Titulo</label>
		<input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
    </div>
    <div class="fila__form_texto">
       
        <label for="descripcion">Descripcion</label>
		<textarea name="descripcion" id="descripcion"  class="form__textarea"><?php echo $descripcion; ?></textarea>

    </div>
    <div class="fila__form">
    <input type="button" value="Cancelar" id="btncan" onclick="<?php echo $origen;?>">
    <input type="button" value="Siguiente" id="btnsig" onclick="SiguientePaso(1,<?php echo $id;?>);">
    </div>
</div>
</div>

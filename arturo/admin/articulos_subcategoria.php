              <div class="referencias">
              <div class="refeditar"><img src="img/editar.png" alt=""><label class="">:Editar</label></div>
              <div class="refpublicar"><img src="img/visible_off.png" alt=""><label class="oculto">:Oculto</label>
              <img src="img/visible_on.png" alt=""><label class="publicado">:Publicado</label>
              <img src="img/destacado_on.png" alt=""><label class="destacado">:Destacado</label>
              <img src="img/destacado_off.png" alt=""><label class="sindestacar">:Sin destacar</label>
              </div>
              <div class="refeliminar"><img src="img/eliminar.png" alt=""><label for="">:Eliminar</label></div>
              </div>


<?php 
header('Content-Type: text/html; charset=utf-8'); 
include("functions.php");
$subcategoria = $_GET['subcategoria'];
$categoria = $_GET['categoria'];
$path="galery/";

		switch ($subcategoria) {
			case '0':
				$res1=listar_articulos_publicados($categoria);
				break;
			case 'NO':
                $cadena = $_GET['cadena'];
                $res1=listar_articulos_busqueda($categoria,$cadena); 
                break;
			default:
				$res1=listar_articulos_subcategorias($subcategoria);    
				break;
		}


while ($row = mysql_fetch_row($res1)){

?>        
    <article class="articulo__item">
        <img src="<?php echo $path.$row[6];?>" alt="" class="articulo__img">
        <label for="" class="articulo__titulo"><?php echo strtoupper($row[1]);?></label>
            
            <div class="accion__articulo"> <!-- Manejo de flag habilitado-->

            <div class="edicion">
            <a href="modifica_articulo.php?indice=1&id=<?php echo ($row[0]);?>" class="editar"><img src="img/editar.png" alt=""></a>
            <a onclick="elimina_servicio(<?php echo $categoria;?>,<?php echo $row[0];?>)" href="" class="eliminar"><img src="img/eliminar.png" alt=""></a>
            </div>
            
            <div class="publicacion">
            <?php if($row[9]==1){ ?> 
            <a onclick="cambiar_estado_servicio(<?php echo $row[0];?>,0)" href="" class="publicado"><img src="img/visible_on.png" alt=""></a>
            <?php }else{ ?>
            <a onclick="cambiar_estado_servicio(<?php echo $row[0];?>,1)" href="" class="oculto"><img src="img/visible_off.png" alt=""></a>
            <?php };?>
            
            
            <?php if($categoria!=3){if($row[10]==1){ ?>  <!-- Manejo de flag destacado-->
            <a onclick="cambiar_estado_destacado(<?php echo $row[0];?>,0)" href="" class="publicado"><img src="img/destacado_on.png" alt=""></a>
            <?php }else{ ?>
            <a onclick="cambiar_estado_destacado(<?php echo $row[0];?>,1)" href="" class="oculto"><img src="img/destacado_off.png" alt=""></a>
            <?php }};?>
            </div>

            </div>
    </article>


<?php };?>
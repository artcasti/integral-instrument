<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="PDC";

$path="galery/";
$categoria = '1';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../img/favicon.ico">

<title>Panel de Control</title>
    <link rel="stylesheet" href="css/fonts.css">
     <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" href="css/pdc_admin_st.css">
 
    
    <script type="text/javascript" src="js/wiz_cursos.js"></script>  

</head>
<body>
<header class="header">
   <div class="logo">
        <div class="logo_texto_admin">
        Integral Instrument
        </div>
    </div>
    <label>Panel de Control</label>
    <nav class="navbar__header">
    <a  class="home"><img onclick="window.location='pdc_admin.php';" src="img/home.png" alt="home" class="img__link">Home</a>
    <a href="http://www.pro-ser.com.ar/demo/cotexa/obras.php" target="_blank" class="linksitio"><img src="img/web.png" alt="web" class="img__link">Sitio</a>
    <a href="logout.php" class="logout"><img src="img/quit.png" alt="salir" class="img__link">Salir</a>
    </nav>
</header>
<div class="wrapper">

<div class="contenido__novedades">
<div class="titulo__pagina">
    <p>Administración de Obras</p>
</div>
<div class="filtro">
    <div class="col_acciones">
    <p class="titulo__acciones">Cargar Nuevo...</p>
    <div class="accion__novedades">
       <a href="modifica_articulo.php?indice=0&id=0&tipo=<?php echo $categoria;?>" class="accion__link">+ Elemento</a>
       <a href="listar_subcategorias.php?categoria=<?php echo $categoria;?>" title="Nueva" class="mas__link">Categoría</a>
    </div>
   </div>
   
   <div class="col_filtro">
   <p class="titulo__acciones">Buscar Elemento</p>
   <div class="filtsubcat">
    <select name="selsubcateg" id="subcategoria" class="selsubcateg" onchange="filtrarsubcategoria(this.value,<?php echo $categoria;?>);">
       <option value=0 id='subcategoria'>Subcategorías</option>
        <?php carga_selected("subcategorias",0,$categoria); ?>
    </select>
    <input type="text" class="buscar" placeholder="Ingrese su busqueda" id="busqueda">
    <input type="button" class="btnbuscar" value="Buscar"onclick="filtrarbusqueda(<?php echo $categoria;?>);">
    </div>
    </div>
    

</div>
<div class="detalle__articulo" id="detalle__articulo">
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

                $res1=listar_articulos_publicados($categoria);

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
            
            <?php if($row[10]==1){ ?>  <!-- Manejo de flag destacado-->
            <a onclick="cambiar_estado_destacado(<?php echo $row[0];?>,0)" href="" class="publicado"><img src="img/destacado_on.png" alt=""></a>
            <?php }else{ ?>
            <a onclick="cambiar_estado_destacado(<?php echo $row[0];?>,1)" href="" class="oculto"><img src="img/destacado_off.png" alt=""></a>
            <?php };?>
            </div>

            </div>
    </article>

                       <?php };?>

        </div>
    </div>
  </div>    

</body>
</html>
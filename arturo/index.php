<?php header('Content-Type: text/html; charset=utf-8'); 
                include("admin/conexion.php");
                include("admin/functions.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title> Integral Instrument</title>
    <link rel="shortcut icon" href="img/favicon.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/crawler.js">

/* Text and/or Image Crawler Script v1.53 (c)2009-2011 John Davenport Scheuer
   as first seen in http://www.dynamicdrive.com/forums/
   username: jscheuer1 - This Notice Must Remain for Legal Use
*/

</script>
    <link rel="stylesheet" href="css/lightbox.css">

<style>

    
@-webkit-keyframes banner{
    
<?php 

require_once("admin/class/filereader.php");

$path = "banner/";

$dir = new filereader($path);


$lista = $dir->LeerDirectorio();
    
    $seg=100 / count($lista);
for($i=0;$i<count($lista)-1;$i++){
    $pi=$seg*$i;
    $pf=$seg*($i+1)-1;
echo $pi.'%,'.$pf.'%{background-image: url("'.$path.$lista[$i].'");}';
};
echo $pf.'%,100%{background-image: url("'.$path.$lista[$i].'");}';    
?>

}

@-moz-keyframes banner{
    
<?php 

require_once("admin/class/filereader.php");

$path = "banner/";

$dir = new filereader($path);


$lista = $dir->LeerDirectorio();
    
    $seg=100 / count($lista);
for($i=0;$i<count($lista)-1;$i++){
    $pi=$seg*$i;
    $pf=$seg*($i+1)-1;
echo $pi.'%,'.$pf.'%{background-image: url("'.$path.$lista[$i].'");}';
};
echo $pf.'%,100%{background-image: url("'.$path.$lista[$i].'");}';    
?>

}    
    
</style>

</head>
<body>

<div class="row banner">
    
</div>

<div class="row">
<header>
   <section class="header" id="header">
       <div class="contenedor_header">
       <div class="logo_texto">
           Integral Instrument
       </div>
        
        <div class="header__telefono">
            <p class="titulo_header">Reparación</p>
            <p class="and">&</p>
            <p class="titulo_header">Calibraciones</p>
        </div>
        </div>
    </section>
</header>
<div class="header_rojo">
   <div class="contenedor_rojo">
       <p class="telefono">Tel./Fax: 4218-5675 / 4208-2010</p><p class="telefono">info@integralinstrument.com.ar</p>
   </div>
</div>



<div class="contenedor_nav">
    <nav class="navbar_home">
        <a href="index.php" class="navbar_link">:: La Empresa</a>
        <a href="servicios.php" class="navbar_link">:: Servicios</a>
        <a href="obras.php" class="navbar_link">:: Trabajos Realizados</a>
        <a href="novedades.php" class="navbar_link">:: Novedades</a>
        <a href="contacto.php" class="navbar_link">:: Contacto</a>
    </nav>
</div>

</div>



<div class="row titulo sinborde rojo">
   <div class="contenedor_titempresa">
      <p class="localidades">Trabajamos bajo lineamientos ISO 9001-2008</p>
       <p class="titulo__empresa">::La Empresa</p>
   </div>
</div>

<div class="row quienessomos">
   <div class="contenedor_qs">
       <div class="columna__qs">
           <?php echo get_texto(1);?>
       </div>
       <div class="columna__qs">
           <?php echo get_texto(2);?>
       </div>
   </div>
   <div class="contenedor_btnqs">
      <a href="quienessomos.php" class="link_qs">.Misión</a><a href="quienessomos.php" class="link_qs">.Historia</a>
   </div>

</div>

<div class="row">
    <div class="slider">
       
        <?php   
        include("inc/slider.inc");    
        ?>  

    </div>
</div>

<div class="row titulo conborde gris">
   <div class="contenedor">
       <p class="titulo__servicios">::Servicios</p>
   </div>
</div>

<div class="row">
   <div class="contenedor_articulos">
       
                <?php 


                $path="admin/galery/";

                $categoria = '2';

                $res1=listar_articulos_publicados($categoria);

                while ($row = mysql_fetch_row($res1)){
                    if($row[10]=='1'){
                 ?> 
       
       
                <article class="articulo__columna">
                <div class="articulo__img" style="background:url('<?php echo $path.$row[6];?>');     background-size:contain; 
                background-repeat: no-repeat; background-position:center bottom; "></div>
                <div class="articulo__descripcion">
                <h2 class="articulo__titulo"><?php echo strtoupper($row[1]);?></h2>
                <a href="detalle.php?idservicio=<?php echo $row[0]; ?>" class="articulo__link">.Ver</a>
                </div>
                </article>
             <?php }; };?>
            
        
   </div>    
</div>

<div class="row titulo sinborde blanco">
   <div class="contenedor2">
<!--            <div class="linearoja"></div>-->
       <p class="titulo__obras">::Trabajos Realizados</p>
   </div>
</div>

<div class="row">
   <div class="contenedor_articulos">
                <?php 


                $path="admin/galery/";

                $categoria = '1';

                $res1=listar_articulos_publicados($categoria);

                while ($row = mysql_fetch_row($res1)){
                    if($row[10]=='1'){
                 ?> 
       
       
                <article class="articulo__columna">
                <div class="articulo__img" style="background:url('<?php echo $path.$row[6];?>');     background-size:cover; 
                background-repeat: no-repeat; background-position:center bottom; "></div>
                <div class="articulo__descripcion">
                <h2 class="articulo__titulo"><?php echo strtoupper($row[1]);?></h2>
                <a href="detalle.php?idservicio=<?php echo $row[0]; ?>" class="articulo__link">.Ver</a>
                </div>
                </article>
             <?php }; };?>
                    
   </div>    
</div>

<div class="row titulo conborde rojo">
   <div class="contenedor">
       <p class="titulo__contacto">::Contacto</p>
   </div>
</div>

<div class="row">
    <?php include("inc/footer.inc");?>
</div>

</body>
</html>
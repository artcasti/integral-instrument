<?php header('Content-Type: text/html; charset=utf-8'); 
                include("admin/conexion.php");
                include("admin/functions.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Integral Instrument</title>
    <link rel="shortcut icon" href="img/favicon.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
        <link rel="stylesheet" href="css/fonts.css">

</head>
<body>

<div class="row">
<?php include("inc/header.inc");?>

<?php include("inc/menu.inc");?>


</div>

<div class="row titulo sinborde blanco">
   <div class="contenedor2">
<!--      <div class="linearoja"></div>-->
       <p class="titulo__obras">::Trabajos Realizados</p>
   </div>
</div>


<div class="row">
   <div class="contenedor_articulos">
                <?php 


                $path="admin/galery/";

                $categoria = '1';

                $res1=listar_articulos_publicados($categoria);

                while ($row = mysqli_fetch_row($res1)){
                    if($row[9]=='1'){
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
<script src="js/menu.js"></script>
</body>
</html>
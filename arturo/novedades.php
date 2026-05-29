<?php header('Content-Type: text/html; charset=utf-8'); 
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
<!--      <div class="linearojanovedades"></div>-->
       <p class="titulo__obras">::Novedades</p>
   </div>
</div>


<div class="row">
      <div class="novedades">
         
                        <?php 
                include("admin/conexion.php");
                include("admin/functions.php");

                $path="admin/galery/";

                $categoria = '3';

                $res1=listar_articulos_publicados($categoria);

                while ($row = mysql_fetch_row($res1)){
                    if($row[9]=='1'){
                 ?>       
  
          <article class="caja__novedad">
               <div class="novedad__img" style="background:url('<?php echo $path.$row[6];?>') no-repeat;  background-size:contain; 
             background-position:center; ""></div>
                <div class="novedad__info">
                <h2 class="novedad__titulo"><?php echo strtoupper($row[1]);?></h2>
                <p class="novedad__texto"><?php echo $row[11]; ?></p>
                </div>
                <a href="detalle.php?idservicio=<?php echo $row[0]; ?>" class="novedad__link">+Info</a>
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
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
       <p class="titulo__obras">::Misión</p>
   </div>
</div>
<div class="mision">
     <?php echo get_texto(3);?>
</div>
<div class="row titulo sinborde blanco">
   <div class="contenedor2">
<!--      <div class="linearoja"></div>-->
       <p class="titulo__obras">::Historia</p>
   </div>
</div>
<div class="mision">
     <?php echo get_texto(4);?>
</div>

<div class="row">
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
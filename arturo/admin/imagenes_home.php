<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
require_once("class/filereader.php");

$_SESSION['modifica']=0;
$_SESSION['modulo']="PDC";



  $pathb = "../sliderbrands/";

$dir = new filereader($pathb);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../img/favicon.ico">

<title>Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" href="css/pdc_admin_st.css">
    <link rel="stylesheet" href="css/fonts.css">
      <script type="text/javascript" src="js/wiz_cursos.js"></script>    
      
        <!-- Example assets -->
        <link rel="stylesheet" type="text/css" href="css/jcarousel.responsive.css">

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>

        <script type="text/javascript" src="js/jcarousel.responsive.js"></script>     
    <script type="text/javascript" src="../js/crawler.js">

/* Text and/or Image Crawler Script v1.53 (c)2009-2011 John Davenport Scheuer
   as first seen in http://www.dynamicdrive.com/forums/
   username: jscheuer1 - This Notice Must Remain for Legal Use
*/

</script>
    <link rel="stylesheet" href="../css/lightbox.css">
    
    
    
<style>

    
@keyframes banner{
    
<?php 

require_once("class/filereader.php");

$path = "../banner/";

$dir = new filereader($path);


$lista1 = $dir->LeerDirectorio();
    
    $seg=100 / count($lista1);
for($i=0;$i<count($lista1)-1;$i++){
    $pi=$seg*$i;
    $pf=$seg*($i+1)-1;
echo $pi.'%,'.$pf.'%{background-image: url("'.$path.$lista1[$i].'");}';
};
echo $pf.'%,100%{background-image: url("'.$path.$lista1[$i].'");}';    
?>

}
    
</style>
        
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
    <a href="http://www.pro-ser.com.ar/demo/cotexa" target="_blank" class="linksitio"><img src="img/web.png" alt="web" class="img__link">Sitio</a>
    <a href="logout.php" class="logout"><img src="img/quit.png" alt="salir" class="img__link">Salir</a>
    </nav>
</header>
<div class="wrapper">

<div class="contenido__novedades">
<div class="titulo__pagina">
    <p>Home</p>
</div>


<div class="detalle__imagenes" >
    <div class="fila__form">
        <form action="carga_imagenes_wiz.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
           <input type="hidden" name="imagenes_home" value="2">
            <p class="subtitulo">Carga de Imagen Banner Principal<p>
            <input type="file" name="selectfile" id="selectfile" class="button_file">
            <input type="submit" value="Cargar">
        </form>    
    </div>
            <div class="contenido-novedades">
               
                    <div class="banner">
                    </div>

            </div>
                    
    <div class="imagenes__banner">   
<?php 

for($i=0;$i<count($lista1);$i++){
?>
       <div class="img__item">
        <img src="<?php echo $path.$lista1[$i];?>">
        		<a onclick="EliminaImagenBanner('<?php echo $path.$lista1[$i];?>')" class="eliminar"><img src="img/eliminar.png" alt="eliminar" class="icono_accion"></a>
        </div>
<?php

};
?>       
    </div>
</div>




<div class="detalle__imagenes" >
    <div class="fila__form">
        <form action="carga_imagenes_wiz.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
           <input type="hidden" name="imagenes_home" value="1">
            <p class="subtitulo">Carga de Imagen Slider marcas<p>
            <input type="file" name="selectfile" id="selectfile" class="button_file">
            <input type="submit" value="Cargar">
        </form>    
    </div>
            <div class="jcarousel-wrapper">
               
                    <div class="marquee" id="mycrawler2">
                    <?php 

                    $dir = new filereader($pathb);

                    set_time_limit(120);
                    $lista = $dir->LeerDirectorio(); 
                    for($i=0;$i<count($lista);$i++){
                    ?>
                    <img src="<?php echo $pathb.$lista[$i];?>" height="70px">
                    <?php

                    };
                    ?>  
                    </div>

                    <script type="text/javascript">
                    marqueeInit({
                    uniqueid: 'mycrawler2',
                    style: {
                    'padding': '2px',
                    'width': '4000px',
                    'height': '70px'
                    },
                    inc: 5, //speed - pixel increment for each iteration of this marquee's movement
                    mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
                    moveatleast: 2,
                    neutral: 150,
                    savedirection: true,
                    random: true
                    });
                    </script>
                    <script src="js/lightbox.js"></script>
               


            </div>
                    
    <div class="imagenes__banner">   
<?php 

for($i=0;$i<count($lista);$i++){
?>
       <div class="img__item">
        <img src="<?php echo $pathb.$lista[$i];?>">
        		<a onclick="EliminaImagenBanner('<?php echo $pathb.$lista[$i];?>')" class="eliminar"><img src="img/eliminar.png" alt="eliminar" class="icono_accion"></a>
        </div>
<?php

};
?>       
    </div>
</div>
</div>

</body>
</html>
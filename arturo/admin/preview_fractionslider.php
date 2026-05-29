<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include "functions.php";
include "conexion.php";
require_once("class/filereader.php");

$_SESSION['modifica']=0;
$_SESSION['modulo']="PDC";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" href="css/pdc_admin_st.css">
    <link rel="stylesheet" href="css/fonts.css">
    <script src="js/wiz_cursos.js" type="text/javascript" charset="utf-8"></script>    
<!--FractionSlider-->
    		<link rel="stylesheet" href="css/fractionslider.css">
    		<link rel="stylesheet" href="css/slider.css">
		<script src="js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.fractionslider.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/main.js" type="text/javascript" charset="utf-8"></script>   
        
</head>
<body>

<header class="header">
   <div class="logo">
    <img src="images/logo.png" alt="home" class="logo">
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
    <p>Slider</p>
</div>



<div class="detalle__imagenes" >
		<div class="slider-wrapper">
			<div class="responisve-container">
				<div class="slider">
					<div class="fs_loader"></div>

                        <?php 
                        $path="../fslider/";

                        $consulta =  'SELECT * FROM `slides` WHERE `idslider` = "1" and `habilitado`="1"';
                        $result = mysql_query($consulta,$conexion);
                        while ($row = mysql_fetch_row($result)){
                        ?> 
    
                        <div class="slide fondo" style="background-image:url('<?php echo $path.$row[2];?>');">
                            <div class="turky teaser small" 			
                                    data-position="400,500" data-in="left" data-step="1" data-out="right" ><?php echo $row[3];?>
                            </div> 	
                        </div>
					     <?php };?>
				</div>
			</div>
		</div>

        <div class="imagenes__banner">   
        <?php 
         $result = mysql_query($consulta,$conexion);
        while ($row = mysql_fetch_row($result)){
        ?>
        <div class="img__item">
        <img src="<?php echo $path.$row[2];?>">
        <a onclick="EliminaImagenSlider('<?php echo $row[1];?>','<?php echo $path.$row[2];?>')" class="eliminar"><img src="img/eliminar.png" alt="eliminar" class="icono_accion"></a>
        </div>
        <?php

        };
        ?>       
        </div>
        <div id="imagenes__banner"></div>
</div>


</div>

</body>
</html>
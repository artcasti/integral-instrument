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
      <script type="text/javascript" src="js/wiz_cursos.js"></script>    
    <script src="ckeditor/ckeditor.js"></script>


<!--Ajax upload -->
<link href="css/formupload.css" rel="stylesheet" type="text/css">    
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>
<script type="text/javascript" src="js/formupload.js"></script>    


        
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
    <a href="preview_fractionslider.php" class="link_titulo">Vista Previa Slider</a><p></p>
</div>


<div class="detalle__imagenes" >
            <div id="upload-wrapper">
            <div align="center">
            <h3>Carga de Slides</h3>
            <form action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm" >
            <input type="hidden" name="slider" value="1"> <!--Slider Principal Home-->
            <div class="archivo">
            <p>Tamaño Máximo 512KB</p>
            <input name="FileInput" id="FileInput" type="file" />
            <div id="image_preview"><img id="previewing" src="" /></div>
            <div id="message"></div>
            </div>
            <hr>
            <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
            <div class="cajatexto">
               <label for="textoslide">Texto animado en slide</label>
                <textarea name="textoslide" id="textoslide" class="texto__columna">

                </textarea>
<!--
                <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'textoslide' );
                </script>
-->
            </div>    
            <input type="submit"  id="submit-btn" value="Upload" />
            </form>
            <div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
            <div id="output"></div>
            </div>

            </div>


</div>


</div>

</body>
</html>
<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="PDC";

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
      <script src="ckeditor/ckeditor.js"></script>
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
    <a href="http://www.pro-ser.com.ar/demo/cotexa" target="_blank" class="linksitio"><img src="img/web.png" alt="web" class="img__link">Sitio</a>
    <a href="logout.php" class="logout"><img src="img/quit.png" alt="salir" class="img__link">Salir</a>
    </nav>
</header>
<div class="wrapper">

<div class="contenido__novedades">
<div class="titulo__pagina">
    <p>La Empresa<p>
</div>

<div class="detalle__quienessomos" id="detalle__quienessomos">
<form action="abm_articulos_manager.php" method="post">
<input type="hidden" name="paso" value="T">
<div class="columna__quienessomos">
    <label for="nuestraempresa" class="titulo__columna">Columna Izquierda - Home</label>
    <textarea name="nuestraempresa" id="nuestraempresa" class="texto__columna">
    <?php echo get_texto(1);?>
    </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'nuestraempresa' );
            </script>
</div>

<div class="columna__quienessomos">
    <label for="politica" class="titulo__columna">Columna Derecha - Home</label>
    <textarea name="politica" id="politica" class="texto__columna">
        <?php echo get_texto(2);?>
    </textarea>
                <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'politica' );
            </script>
</div>
   
<div class="columna__quienessomos">
    <label for="mision" class="titulo__columna">Misión - Quienes Somos</label>
    <textarea name="mision" id="mision" class="texto__columna">
        <?php echo get_texto(3);?>
    </textarea>
                <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'mision' );
            </script>
</div>   
   
   
<div class="columna__quienessomos">
    <label for="historia" class="titulo__columna">Historia - Quienes Somos</label>
    <textarea name="historia" id="historia" class="texto__columna">
        <?php echo get_texto(4);?>
    </textarea>
                <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'historia' );
            </script>
</div>     
    <div class="botones_quienessomos">
    <input type="button" value="Cancelar" id="btncan" onclick="window.location='pdc_admin.php';">
    <!--<input type="button" value="Guardar" id="btnsig" onclick="ActualizaQuienesSomos();">-->
    <input type="submit" value="Enviar">
    </div>
</form>
</div>
    </div>
    </div>
</body>
</html>
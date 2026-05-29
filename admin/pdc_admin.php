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
    <a href="http://www.integralinstrument.com.ar/" target="_blank" class="linksitio"><img src="img/web.png" alt="web" class="img__link">Sitio</a>
    <a href="logout.php" class="logout"><img src="img/quit.png" alt="salir" class="img__link">Salir</a>
    </nav>
</header>
<div class="wrapper">
<div class="contenido">
    <div class="columna__menu"><a href="imagenes_home.php" class="menues boton_home">HOME</a></div>
    <div class="columna__menu"><a href="quienes_somos.php" class="menues boton_quienessomos">QUIENES SOMOS</a><a href="listar_servicios.php" class="menues boton_servicios">SERVICIOS</a></div>
    <div class="columna__menu"><a href="listar_cursos.php" class="menues boton_cursos">TRABAJOS REALIZADOS</a><a href="listar_novedades.php" class="menues boton_novedades">NOVEDADES</a></div>
    
</div>

<div class="footer">
    
</div>
</div>

</body>
</html>
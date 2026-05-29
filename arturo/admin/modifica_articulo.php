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
<script type="text/javascript">
window.onload = function(){
    var flag=0;
    var tipo=0;
    flag=<?php if(isset($_GET['indice'])){echo $_GET['indice'];}else{echo 0;}?>;
     
	if(flag>0){
        CargarPaso(flag,<?php echo $_GET['id'];?>);    
    }else{
    tipo=<?php if(isset($_GET['tipo'])){echo $_GET['tipo'];}else{echo 0;}?>;
        AltaArticulo(tipo,<?php echo $_GET['id'];?>);           
    }

}
</script>
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

<div id="contenido">
</div>
</div>

</body>
</html>
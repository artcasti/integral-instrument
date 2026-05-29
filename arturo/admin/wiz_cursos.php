<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>OMG | Panel de Control</title>
   
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/wiz_form.css">
    <link rel="stylesheet" href="css/fonts.css">
    
<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/wiz_cursos.js"></script>
<script type="text/javascript">
window.onload = function(){
    var flag=0;
    flag=<?php if(isset($_GET['indice'])){echo $_GET['indice'];}else{echo 0;}?>;

	if(flag>0){
        CargarPaso(flag,<?php echo $_GET['id']?>);    
    }

}
</script>
</head>
<body>

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>

	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
					<div id="contenido" align="center">
					    <input type="button" value="Nuevo" onclick="AltaServicio()">
					    <input type="button" value="Articulo 1" onclick="AltaArticulo(1,0)">
					</div>
		</div>
	 	<div class="col-md-1">
		</div>
	</div>

   </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
 
</body>
</html>


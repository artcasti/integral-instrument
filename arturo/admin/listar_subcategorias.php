<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="PDC";

$path="galery/";
$categoria = 0;
if(isset($_GET['categoria'])){$categoria=$_GET['categoria'];}
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

<script type="text/javascript">
function procesar(item, desc, accion){
	//document.getElementById("popups").innerHTML = "<img src='img/loading_async_big.gif' />";
	var habilitado;
	var categ;

	habilitado = 0;
	if(document.getElementById("checkhab")){
	 elemento = document.getElementById("checkhab");
	 if( elemento.checked ) {
   	 habilitado = 1;
	 }
	 }

	if(document.getElementById("categoria")){
	 categ = document.getElementById("categoria").value;
	 }	 

	if (window.XMLHttpRequest)
			{
				xmlhttp= new XMLHttpRequest();
			}
		else
			{
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

		xmlhttp.onreadystatechange=function()
			{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("content").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","graba_subcategorias.php?cod="+item+"&desc="+desc+"&accion="+accion+"&habilitado="+habilitado+"&categ="+categ,true);
	xmlhttp.send();

}
</script>



<script type="text/javascript">
function modifica_item(cadena){
	sep = cadena.split("+");
	document.getElementById("codigo").value = sep[0];
	document.getElementById("desc").value = sep[1];
	document.getElementById("categoria").value = sep[2];

	elemento = document.getElementById("checkhab");
	 if( sep[3]==0 ) {
   		elemento.checked=false;
	 }else{
	 	elemento.checked=true;
	 }


	document.getElementById("accion").value = 2;
	window.scrollTo(0, 0);
}
</script>

<script type="text/javascript">
function elimina_item(cadena){
if (confirm('Está por eliminar el Item, desea continuar?'))
	{
	sep = cadena.split("+");
	item = sep[0];
	desc = sep[1];
	document.getElementById("accion").value = 3;
	procesar(item, desc, 2);
	}
}
</script>

<script type="text/javascript">
function validacion_cabecera(){

item = document.getElementById("codigo").value;
// if( isNaN(item) || item == null || item.length == 0 || /^\s+$/.test(item)) {
//   alert('[ERROR] El Código sólo puede ser numérico.');
//   return false;
//} 
desc = document.getElementById("desc").value;
if(desc == null || desc.length == 0 ) {
  alert('[ERROR] Debe cargar una descripción para la Categoria.');
  return false;
} 

accion = document.getElementById("accion").value;
//alert(accion);
procesar(item, desc, accion);
return true;
}
</script>

<script type="text/javascript">
function text_descSetFocus(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13){
       document.getElementById("desc").focus();
    }
}
</script>

<script type="text/javascript">
function text_GrabaSetFocus(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13){
       document.getElementById("grabar").focus();
    }
}
</script>

<script type="text/javascript">
window.onload = function(){
	procesar(0, '', 0);

	//setTimeout('alert(document.getElementById("accion").value);',3000);
	

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
				<div id="content" >
				</div>
</div>				
</body>
</html>
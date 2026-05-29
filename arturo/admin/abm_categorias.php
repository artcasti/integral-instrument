<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Categorias";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>OMG | Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>


<script type="text/javascript">
function procesar(item, desc, accion){
	//document.getElementById("popups").innerHTML = "<img src='img/loading_async_big.gif' />";
	var habilitado;

	habilitado = 0;
	if(document.getElementById("checkhab")){
	 elemento = document.getElementById("checkhab");
	 if( elemento.checked ) {
   	 habilitado = 1;
	 }
	 }

	// if (document.getElementById("accion").length == 0)
	// {
	// 	accion = 1;
	// }
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
	xmlhttp.open("GET","graba_categorias.php?cod="+item+"&desc="+desc+"&accion="+accion+"&habilitado="+habilitado,true);
	xmlhttp.send();

}
</script>



<script type="text/javascript">
function modifica_item(cadena){
	sep = cadena.split("+");
	document.getElementById("codigo").value = sep[0];
	document.getElementById("desc").value = sep[1];
	elemento = document.getElementById("checkhab");
	 if( sep[2]==0 ) {
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

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>


	  <div id="content">


	  </div>

  <div id="footer"></div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>


<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Imagenes";

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
function cargar_detalle(path,corte,size){

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
					document.getElementById("files").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","imagenes_detalle.php?path="+path+"&corte="+corte+"&size="+size,true);
	xmlhttp.send();

}
</script>


<script type="text/javascript">
function cargar_galeria(path,galeria){
	

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
					document.getElementById("files").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","galeria.php?path="+path+"&galeria="+galeria,true);
	xmlhttp.send();

}
</script>

<script type="text/javascript">
window.onload = function(){

	limpiar_filtros();
	//setTimeout('alert(document.getElementById("accion").value);',3000);
	

}
</script>


<script type="text/javascript">
function accion_seleccionada(){

tarea=document.getElementById('tarea').value;

  checkboxes = document.getElementsByTagName('input');
  cant = 0;
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].checked)   {
		cant++;
    }
  }

if (tarea =='')
	{
		document.getElementById("idTarea").innerHTML = '';	
		formfiles.style.display="none";
		creagaleria.style.display="none";
		divres.style.display="none";
		selectgaleria.style.display="none";
	}

if (tarea =='C')
	{
		document.getElementById("idTarea").innerHTML = 'Cargar Imagenes<br>';	
		formfiles.style.display="inline";
		creagaleria.style.display="none";
		divres.style.display="none";
		selectgaleria.style.display="none";	
	}

if (tarea =='G')
	{
		document.getElementById("idTarea").innerHTML = 'Nueva Galeria<br>';
		document.getElementById("files").innerHTML ='';	
		formfiles.style.display="none";
		creagaleria.style.display="inline";
		divres.style.display="none";
		selectgaleria.style.display="none";
	}

if (tarea =='B')
	{
		document.getElementById("idTarea").innerHTML = 'Galerias<br>';	
		formfiles.style.display="none";
		creagaleria.style.display="none";
		selectgaleria.style.display="inline";
				divres.style.display="none";
		cargar_detalle("galery",3,80);
	}
			
if (tarea =='V')
	{
		document.getElementById("idTarea").innerHTML = 'Galerias<br>';	
		document.getElementById("files").innerHTML ='';	
		formfiles.style.display="none";
		creagaleria.style.display="none";
		selectgaleria.style.display="inline";
		divres.style.display="none";
	}
}
</script>


<script type="text/javascript">
function limpiar_filtros(){
		document.getElementById("idTarea").innerHTML = "";
		formfiles.style.display="none";
		creagaleria.style.display="none";
		divres.style.display="none";
		selectgaleria.style.display="none";
}
</script>

<script type="text/javascript">
function procesar_tarea(){
tarea=document.getElementById('tarea').value;

  checkboxes = document.getElementsByTagName('input');
  cant = 0;
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].checked)   {
		cant++;
    }
  }
    if (cant>0) {
    	if (tarea =='')
		{
			alert('Debe seleccionar una tarea a ejecutar');

			return;
		}

	}

    	if (tarea =='C')
		{
			document.frmfiles.submit();

		}	
		if (tarea =='G')
		{
			galeria=document.getElementById("galeria").value;
			if (galeria =='')
				{
					alert('Debe indicar un nombre para identificar la galeria');
					return;
				}else{
					document.getElementById("idTarea").innerHTML = '';	
					document.getElementById("idTarea").value='';
					formfiles.style.display="none";
					creagaleria.style.display="none";
					divres.style.display="inline";
					crear_galeria(galeria);
				}
		}	

		if (tarea =='B')
		{
			galeria=document.getElementById("selgaleria").value;
			if (galeria =='')
				{
					alert('Debe seleccionar una galeria para agregar imagenes');
					return;
				}else{
				
					formfiles.style.display="none";
					creagaleria.style.display="none";
					divres.style.display="inline";

					ejecutar_tarea("B");
				}
		}	

		if (tarea =='V')
		{
			galeria=document.getElementById("selgaleria").value;
			if (galeria =='')
				{
					alert('Debe seleccionar una galeria para ver su contenido');
					return;
				}else{
				
					formfiles.style.display="none";
					creagaleria.style.display="none";
					divres.style.display="none";

					cargar_galeria("galery",galeria);
				}
		}

		if (tarea=="D") {
			cargar_detalle("galery",3,80);
			limpiar_filtros();
		}	


}
</script>

<script type="text/javascript">
function ejecutar_tarea(tarea){

	var xmlhttp;
	checkboxes = document.getElementsByTagName('input');
	
 	galeria=document.getElementById("selgaleria").value;
 						
 			document.getElementById("divres").innerHTML ='Procesando...';


  	for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox' && checkboxes[i].checked)   {
		//alert(checkboxes[i].value);
		file=checkboxes[i].value;
		checkboxes[i].checked = false;

		
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
					
					switch(tarea) {
					    case 'B':
					    	document.getElementById("divres").innerHTML =xmlhttp.responseText;
					        break;
					}
				}
			}
		xmlhttp.open("GET","abm_galerias_manager.php?tarea="+tarea+"&file="+file+"&galeria="+galeria,true);
		xmlhttp.send();		
    }
  }


}
</script>

<script type="text/javascript">
function crear_galeria(galeria){

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
					document.getElementById("divres").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","abm_galerias_manager.php?tarea="+tarea+"&galeria="+galeria,true);
	xmlhttp.send();

}
</script>


<script type="text/javascript">
function eliminar_item(id){

	tarea="E";
	galeria=document.getElementById("selgaleria").value;

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
					
					cargar_galeria("galery",galeria);
				}
			}
	xmlhttp.open("GET","abm_galerias_manager.php?tarea="+tarea+"&id="+id+"&galeria="+galeria,true);
	xmlhttp.send();

}

function visualizar(id){
	cambio = "img_"+id;

	src0 = document.getElementById("img_0").src;
	src1 = document.getElementById(cambio).src;

		document.getElementById("img_0").src = src1;
		document.getElementById(cambio).src = src0;
}
</script>

</head>

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>

<div id="content" align="center">
	<table align="center" class="tabla" border="1">
	<tr class="encabezado"><td colspan="4" align="center">ACCIONES</td></tr>
	<tr>

	<td align="center">Tarea<br>
		<select id="tarea" name = "tarea" onchange='accion_seleccionada()'>
			<option id="tarea" value=''>Seleccione...</option>
			<option id="tarea" value='C'>Cargar imagenes</option>
			<option id="tarea" value='G'>Crear Galeria</option>
			<option id="tarea" value='B'>Agregar Imagenes a Galeria</option>
			<option id="tarea" value='D'>Ver imagenes disponibles</option>
			<option id="tarea" value='V'>Ver Galeria</option>			
		</select>
	</td>
	<td align="center">
		<div id="idTarea"></div>
			<div id="formfiles" >
					    <form action="carga_imagenes.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
				        <input type="file" name="img[]" multiple>
		   				</form>
			</div>
			<div id="creagaleria" >
				        <input type="text" name="galeria" id="galeria" value="">
			</div>
			<div id="selectgaleria">
				<select id='selgaleria' name='selgaleria' >
						<option value=''>Seleccione...</option>						
						<?php 
						carga_selected("galerias",0,"");
						?>
			</div>		
			<div id="divres" align="center" >

			</div>

	</td>		
	<td align="center"><input type="button" value="Ejecutar" onclick="procesar_tarea()" /></td>
	</tr>
	</table>
					<div id="files" align="center"></div>
</div>
  <div id="footer"></div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>


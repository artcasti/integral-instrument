<?php session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Servicios";

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
    <link rel="stylesheet" href="css/wiz_form.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>


<script type="text/javascript">
function cargar_formservicios(id){
	

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
					document.getElementById("servicios").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","wiz_form.php?id="+id,true);
	xmlhttp.send();

}

function cargar_detalleservicios(estados){
	

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
					document.getElementById("servicios").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","detalle_servicios.php?estados="+estados,true);
	xmlhttp.send();

}
    
    
function cambiar_estado_servicio(servicio, estado){
	
    var tarea;
    tarea = "P";
    
    console.log(servicio+"/"+estado);

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
                    	cargar_detalleservicios("*");
                    //alert(xmlhttp.responseText);
				}
			}
	xmlhttp.open("GET","abm_servicios_manager.php?tarea="+tarea+"&servicio="+servicio+"&estado="+estado,true);
	xmlhttp.send();

}  

function cambiar_estado_destacado(servicio, estado){
	
    var tarea;
    tarea = "I";
    
    console.log(servicio+"/"+estado);

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
                    	cargar_detalleservicios("*");
                    //alert(xmlhttp.responseText);
				}
			}
	xmlhttp.open("GET","abm_servicios_manager.php?tarea="+tarea+"&servicio="+servicio+"&estado="+estado,true);
	xmlhttp.send();

}     
    
function elimina_servicio(servicio){
	
    var tarea;
    tarea = "D";
    
    if (confirm('Esta seguro de eliminar el servicio?')){

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
					cargar_detalleservicios("*");	
				}
			}
	xmlhttp.open("GET","abm_servicios_manager.php?tarea="+tarea+"&servicio="+servicio,true);
	xmlhttp.send();
    }

}  
    
    
    
</script>

<script type="text/javascript">
window.onload = function(){

	limpiar_filtros();
	cargar_detalleservicios("*");
}
</script>

<script type="text/javascript">
function llenasubcateg(categ,seleccionado){

	var xmlhttp;
	
	if (categ =="")
		{
			document.getElementById("selsubcateg").innerHTML="<select id='subcategoria' name='subcategoria' ><option value=''>Seleccione...</option>	";
			return;
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
				document.getElementById("selsubcateg").innerHTML=xmlhttp.responseText;	
			}
		}
	xmlhttp.open("GET","select_subcateg.php?categ="+categ+"&item="+seleccionado,true);
	xmlhttp.send();		
}
</script>

<script type="text/javascript">
function previsualiza_ppal(src,img,path){
		document.getElementById(img).src = path+"/"+src;
		if (src=='') {
			document.getElementById(img).height=0;
			document.getElementById(img).width=0;
		}else{
			document.getElementById(img).height=80;
			document.getElementById(img).width=80;
		}
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
		divres.style.display="none";
		selectgaleria.style.display="none";
	}

if (tarea =='C')
	{
		document.getElementById("idTarea").innerHTML = 'Llenar Formulario<br>y Enviar';	
		formfiles.style.display="none";
		divres.style.display="none";
		selectgaleria.style.display="none";	
			cargar_formservicios(0);
	}

			
if (tarea =='V')
	{
		document.getElementById("idTarea").innerHTML = '';	
		formfiles.style.display="none";
		selectgaleria.style.display="none";
		divres.style.display="none";

	}
}
</script>


<script type="text/javascript">

function limpiar_filtros(){
		document.getElementById("idTarea").innerHTML = '';	
		formfiles.style.display="none";
		selectgaleria.style.display="none";
		divres.style.display="none";		

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
			document.frmservicios.submit();

		}	
		if (tarea =='V')
		{
		cargar_detalleservicios("*");
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
function modifica_servicio(id){
		cargar_formservicios(id);
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
			<option id="tarea" value='V'>Ver Servicios</option>
			<option id="tarea" value='C'>Crear Servicios</option>
		</select>
	</td>
	<td align="center">
		<div id="idTarea"></div>
			<div id="formfiles" >
					    <form action="carga_imagenes.php" method="post" multipart="" enctype="multipart/form-data" name="frmfiles">
				        <input type="file" name="img[]" multiple>
		   				</form>
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
					<div id="servicios" align="center">
						
					</div>
</div>
  <div id="footer"></div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

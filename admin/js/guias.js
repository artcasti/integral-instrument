function cargar_formguia(id){
	

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
	xmlhttp.open("GET","form_guia.php?id="+id,true);
	xmlhttp.send();

}

function cargar_guias(estados){
	

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
	xmlhttp.open("GET","det/detalle_guias.php?estados="+estados,true);
	xmlhttp.send();

}
    
    
function cambiar_estado_guia(guia, estado){
	
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
	xmlhttp.open("GET","abm_guias_manager.php?tarea="+tarea+"&guia="+guia+"&estado="+estado,true);
	xmlhttp.send();

}  

function elimina_guia(guia){
	
    var tarea;
    tarea = "D";
    
    if (confirm('Esta seguro de eliminar la guia?')){

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
	xmlhttp.open("GET","abm_guias_manager.php?tarea="+tarea+"&guia="+guia,true);
	xmlhttp.send();
    }

}  
    

function modifica_guia(id){
		cargar_formguia(id);
}
	
    

function AltaArticulo(tipo,id){

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
					document.getElementById("contenido").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","abm_articulos_p1.php?id="+id+"&tipo="+tipo,true);
	xmlhttp.send();

}


function SiguientePaso(paso,id){
    var categoria;
    var subcategoria;
    var titulo;
    var descripcion;
    
    var descripcionadicional;
    var video;
    if (paso == 1){
        categoria = document.getElementById("categoria").value;
        subcategoria = document.getElementById("subcategoria").value;
        titulo = document.getElementById("nombre").value;
        descripcion = document.getElementById("descripcion").value;

        if(subcategoria=='0'){
            alert('Debe seleccionar una subcategoria');
            return;
        }
        
           if(titulo==''){
            alert('Debe ingresar un titulo');
            return;
        }
        
        
           if(descripcion==''){
            alert('Debe ingresar una descripcion');
            return;
        }
    }

    
     if (paso == 3){
        video = document.getElementById("video").value;
        descripcionadicional = document.getElementById("descripcionadicional").value;
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
					
	               if(paso==1){
                    idservicio=xmlhttp.responseText;
                    pason = paso+1;
                    CargarPaso(pason,idservicio);
                       }
                    if(paso==3){
                        window.location="abm_servicios.php";
                       }
                    
				}
			}
    if (paso==1){    
	xmlhttp.open("GET","abm_articulos_manager.php?id="+id+"&paso="+paso+"&categoria="+categoria+"&subcategoria="+subcategoria+"&titulo="+titulo+"&descripcion="+descripcion,true);
    xmlhttp.send();
    }
    
    if (paso==3){    
	xmlhttp.open("GET","abm_articulos_manager.php?id="+id+"&paso="+paso+"&video="+video+"&descripcionadicional="+descripcionadicional,true);
    xmlhttp.send();
    }

    if (paso == 2){
        CargarPaso(paso+1,id);
    }
    
}

function CargarPaso(paso,id){

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
					document.getElementById("contenido").innerHTML=xmlhttp.responseText;	
				}
			}
    if(paso==1){    
	xmlhttp.open("GET","abm_articulos_p1.php?id="+id,true);
        }    
    if(paso==2){    
	xmlhttp.open("GET","abm_articulos_p2.php?id="+id,true);
        }
    if(paso==3){    
	xmlhttp.open("GET","abm_articulos_p3.php?id="+id,true);
        }
	xmlhttp.send();

}

function elimina_imagen(id,idservicio){
    paso = 2;
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
                    CargarPaso(paso,idservicio);	
                 //   document.getElementById("contenido").innerHTML=xmlhttp.responseText;
				}
			}
	xmlhttp.open("GET","abm_articulos_manager.php?id="+id+"&paso="+paso,true);
    xmlhttp.send();

}


function AltaServicio(){
	var id;
    id=0;

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
					document.getElementById("contenido").innerHTML=xmlhttp.responseText;	
				}
			}
	xmlhttp.open("GET","wiz_form.php?id="+id,true);
	xmlhttp.send();

}

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


function finalizar(categoria,id){
paso=3;
        video = document.getElementById("video").value;
        descripcionadicional = document.getElementById("descripcionadicional").value;

    
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
					
	               if(categoria==1){
                    window.location="listar_cursos.php";
                   }
                    if(categoria==2){
                    window.location="listar_servicios.php";
                   }
                    if(categoria==3){
                    window.location="listar_novedades.php";
                   }
                    
				}
			}

	xmlhttp.open("GET","abm_articulos_manager.php?id="+id+"&paso="+paso+"&video="+video+"&descripcionadicional="+descripcionadicional,true);
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
    
function elimina_servicio(categoria,servicio){
	
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
										
	               if(categoria==1){
                    window.location="listar_cursos.php";
                   }
                    if(categoria==2){
                    window.location="listar_servicios.php";
                   }
                    if(categoria==3){
                    window.location="listar_novedades.php";
                   }
                    
				}
			}
	xmlhttp.open("GET","abm_servicios_manager.php?tarea="+tarea+"&servicio="+servicio,true);
	xmlhttp.send();
    }

}  

function filtrarsubcategoria(subcategoria,categoria){

	var xmlhttp;
	
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
				document.getElementById("detalle__articulo").innerHTML=xmlhttp.responseText;	
			}
		}
	xmlhttp.open("GET","articulos_subcategoria.php?subcategoria="+subcategoria+"&categoria="+categoria,true);
	xmlhttp.send();		
}


function filtrarbusqueda(categoria){

    cadena=document.getElementById('busqueda').value;
    
    if(cadena==''){
        alert('Debe ingresar algo para buscar');
        return;
    }
    
    subcategoria="NO";
	var xmlhttp;
	
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
				document.getElementById("detalle__articulo").innerHTML=xmlhttp.responseText;	
			}
		}
	xmlhttp.open("GET","articulos_subcategoria.php?subcategoria="+subcategoria+"&categoria="+categoria+"&cadena="+cadena,true);
	xmlhttp.send();		
}

function ActualizaQuienesSomos(){
    paso="T";
    empresa=document.getElementById('nuestraempresa').value;
    politica=document.getElementById('politica').value;

	var xmlhttp;
	
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
				//document.getElementById('detalle__quienessomos').innerHTML = xmlhttp.responseText;    
                window.location="pdc_admin.php";
			}
		}
	xmlhttp.open("GET","abm_articulos_manager.php?paso="+paso+"&politica="+politica+"&empresa="+empresa,true);
	xmlhttp.send();		    
    
}

function EliminaImagenBanner(imagen){
    paso="U";

	var xmlhttp;
	
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
				//document.getElementById('detalle__quienessomos').innerHTML = xmlhttp.responseText;    
                window.location="imagenes_home.php";
			}
		}
	xmlhttp.open("GET","abm_articulos_manager.php?paso="+paso+"&imagen="+imagen,true);
	xmlhttp.send();		    
    
}

function Espejar(id){
    
    if (id=="desc"){
    document.getElementById('descadicionalhidden').value = document.getElementById('descripcionadicional').value;
     document.getElementById('descadicionalhidden2').value = document.getElementById('descripcionadicional').value;    

    }
    
    if(id="video"){
         document.getElementById('videohidden').value = document.getElementById('video').value;
        document.getElementById('videohidden2').value = document.getElementById('video').value;
    }
    
}

function EliminaImagen(id,tipo){
    
       paso="im";
    
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
					
	               if(tipo=="ppal"){
                    CargarPaso(2,id);
                       }
                    if(tipo=="adic"){
                    CargarPaso(3,id);
                       }
                    
				}
			}  
        
	xmlhttp.open("GET","abm_articulos_manager.php?id="+id+"&paso="+paso+"&tipo="+tipo,true);
    xmlhttp.send();
    
}


function EliminaImagenSlider(imagen, archivo){
    paso="sl";

	var xmlhttp;
	
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
				//document.getElementById('imagenes__banner').innerHTML = xmlhttp.responseText;    
               window.location="preview_fractionslider.php";
			}
		}
	xmlhttp.open("GET","abm_articulos_manager.php?paso="+paso+"&imagen="+imagen+"&archivo="+archivo,true);
	xmlhttp.send();		    
    
}

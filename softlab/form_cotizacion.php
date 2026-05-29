<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}
require_once("class/clases.php");

require_once("class/AppException.php");
$cm = new ConfigurationManager();

$params = $cm->getParametros(0);

if (isset($_GET['id']))
{
    $id=$_GET['id'];
    $titulobread="Modificación Formulario de Cotización";
    $infoitem=$cm->getCotizacion($id);
}
else
{
    $id=0;
    $titulobread=" Formulario de Cotizacion";
	$nrocotizacionref=0;//$params['nrocotizacion']+1;
	$referencia = sprintf('%02d%02d%02d%02d',date('m'),date('d'),date('y'),$nrocotizacionref);
}


/* Consultas de selección que devuelven un conjunto de resultados */


						?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>SoftLab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Calibraciones, Reparaciones" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/jquery-ui.min.css">

<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>
<script src="js/jquery-ui.min.js"></script>
  
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
<!--Scripts Jquery para carga de images    -->
<script src="js/jquery.form.min.js"></script>
<script src="js/formupload.js"></script>
<!--Incluimos el editor de texto enriquecido-->
<script src="ckeditor/ckeditor.js"></script>
                    
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
			

			
		});
            
            
        function validacion()
            {
				empresa = document.getElementById("empresa").selectedIndex;
                if( empresa == '0') {
                alert('Debe seleccionar una Empresa');
                document.getElementById("empresa").focus();    
                return false;
                }
				
                cliente = document.getElementById("cliente").selectedIndex;
                if( cliente == '0') {
                alert('Debe seleccionar una Cliente');
                document.getElementById("cliente").focus();    
                return false;
                }
				
				tareas = document.getElementById("itemnumber").value;
                if( tareas == '0') {
                alert('Debe cotizar algún ítem');
                document.getElementById("tareas").focus();    
                return false;
                }

//                document.getElementById('formCotizacion').submit();
				ProcesarFormulario();
            }
    $(function(){
      // bind change event to select
      $('select#empresa').on('change', function () {
        var id = $(this).val(); // get selected value
		  if(id!=0){
		
    	$.get('ajax/getinfo.php', { id:id, entidad:'parametros'}, function(resp) {
        var obj = $.parseJSON(resp);
			nrocotizacion = parseInt(obj['nrocotizacion'])+1;
			actualizaReferencia(nrocotizacion);


			CKEDITOR.instances.textencabezado.setData(obj['encabezadocotizacion']);
			CKEDITOR.instances.condiciones.setData(obj['condicionescomerciales']);
		});
		  }else{
			actualizaReferencia(<?php echo $params['nrocotizacion']+1;?>);  
		  }
		  
      });
    });

			
    $(function(){
      // bind change event to select
      $('select#cliente').on('change', function () {
        var id = $(this).val(); // get selected value
        var combo ="contacto";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#contacto').html(resp);
        });
		$.get('ajax/getinfo.php', { id:id, entidad:'cliente'}, function(resp) {
        var obj = $.parseJSON(resp);
		$('input#contactoppal').val(obj['contactoppal']);
		$('input#telefono').val(obj['telefono']);
		$('input#email').val(obj['email']);
		$('input#domicilio').val(obj['domicilio']);
		$('input#cuit').val(obj['nrodoc']);	
		});
		  
        $.get('ajax/detcombo.php', { id:id, combo:"equiposcliente", opcion:opcion }, function(resp) {
       // alert(resp);
		$('select#equipo').html(resp);
        });	
    
      });
    });

			
    $(function(){
      // bind change event to select
      $('select#contacto').on('change', function () {

        var id = $(this).val(); // get selected value

		$.get('ajax/getinfo.php', { id:id, entidad:'contacto'}, function(resp) {
					  
        var obj2 = $.parseJSON(resp);
	
		$('input#contactoppal').val(obj2['contacto']);
//		$('input#telefono').val(obj2[3]);
		$('input#email').val(obj2[4]);
//		$('input#domicilio').val(obj2[5]);
//		$('input#cuit').val(obj2['nrodoc']);	
		});

    
      });
    });	
			
function cargaInfoClienteForm()
{
       var id = $("select#cliente").val(); // get selected value
        var combo ="contacto";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#contacto').html(resp);
        });
		$.get('ajax/getinfo.php', { id:id, entidad:'cliente'}, function(resp) {
        var obj = $.parseJSON(resp);
		$('input#contactoppal').val(obj['contactoppal']);
//		$('input#telefono').val(obj['telefono']);
		$('input#email').val(obj['email']);
//		$('input#domicilio').val(obj['domicilio']);
//		$('input#cuit').val(obj['nrodoc']);	
		});
		  
        $.get('ajax/detcombo.php', { id:id, combo:"equiposcliente", opcion:opcion }, function(resp) {
       // alert(resp);
		$('select#equipo').html(resp);
        });	
}		

			function obtenerEquipo()
			{
             //   alert();
			var idequipo = $("select#equipo").val();	
			$("input#itemequipo").val($("select#equipo").val());	
			if(idequipo !=0){
			$.get('ajax/getinfo.php', { id:idequipo, entidad:'equipo'}, function(resp,marcaitem,modeloitem) {
        	var objequipo = $.parseJSON(resp);
				$("input#itemmarca").val(objequipo['marca']);
				$("input#itemmodelo").val(objequipo['modelo']);
			});
			}else{
				$("input#itemmarca").val('');
				$("input#itemmodelo").val('');				
			}				
				
			}
			
			function cotizarItem()
			{
			var id = $("select#tareas").val();
			var ite = parseInt($("input#itemnumber").val())+1;
			var marca = $("input#itemmarca").val();
			var modelo =$("input#itemmodelo").val();
			var equipo =$("input#itemequipo").val();	
			$.get('ajax/getinfo.php', { id:id, entidad:'itemcotizacion'}, function(resp) {
        	var obj = $.parseJSON(resp);
				
			$.get('ajax/newitemcotizacion.php', { id:ite, txtitem:obj['txtitemcotizacionlista'], precioitem:obj['preciolista'],marca:marca, modelo:modelo, equipo:equipo ,subfamilia:obj['subfamilia'] }, function(resp) {
      //  alert();
			$('div#nuevoitem').last().after(resp);	
			$("input#itemnumber").val(ite);	
			actualizarTotales(obj['preciolista']);				
			});
			});
	
			}
			
			function actualizarTotales(total)
			{
				$("label#cantitems").html($("input#itemnumber").val());
				$("label#cantequipos").html(parseInt($("label#cantequipos").html())+1);	
				$("label#totalcotizacion").html(parseInt(parseInt($("label#totalcotizacion").html())+parseInt(total)));	
			}
				  
			function addOne(id)
			{
				bonificado = $('input#total_'+id).val();
				$("input#cantidad_"+id).val(parseInt($("input#cantidad_"+id).val())+1);
				$("input#total_"+id).val(parseInt($("input#cantidad_"+id).val())*parseInt($("input#precio_"+id).val()));
				if (bonificado == 'Bonificado'){
           	   $("label#totalcotizacion").html(parseInt(parseInt($("label#totalcotizacion").html())+parseInt($("input#cantidad_"+id).val())*parseInt($("input#precio_"+id).val())));
					
				}else{
					$("label#totalcotizacion").html(parseInt(parseInt($("label#totalcotizacion").html())+parseInt($("input#precio_"+id).val())));
				}
				
				$("label#cantequipos").html(parseInt($("label#cantequipos").html())+1);	
			}
			
			function resOne(id)
			{
				if(parseInt($("input#cantidad_"+id).val())>0){
				$("input#cantidad_"+id).val(parseInt($("input#cantidad_"+id).val())-1);
				$("label#cantequipos").html(parseInt($("label#cantequipos").html())-1);	
				$("label#totalcotizacion").html(parseInt(parseInt($("label#totalcotizacion").html())-parseInt($("input#precio_"+id).val())));	
				}	$("input#total_"+id).val(parseInt($("input#cantidad_"+id).val())*parseInt($("input#precio_"+id).val()));
					
			}
			
			function bonifica(id)
			{
				resta = parseInt($("input#total_"+id).val());
				$("input#total_"+id).val('Bonificado');
				$("label#totalcotizacion").html(parseInt(parseInt($("label#totalcotizacion").html())-resta));						
			}
			
			function padLeft(nr, n, str){
return Array(n-String(nr).length+1).join(str||'0')+nr;
}
			
			function actualizaReferencia(nro)
			{
				var fecha = $('#fechacotizacion').val();
				res = fecha.split('-');
				referencia = padLeft(res[1],2)+res[2]+res[0].substr(2,2)+padLeft(nro,2);
				$('#referencia').val(referencia);
			}
			

</script>
		

<!----->
</head>
<body>
<div id="wrapper">
     <!----->
       <div id="resp"></div>
        <nav class="navbar-default navbar-static-top" role="navigation">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <h1> <a class="navbar-brand" href="index.html">Softlab</a></h1>         
			   </div>
			 <div class=" border-bottom">
        	<div class="full-left">
        	  <section class="full-top">
				<button id="toggle"><i class="fa fa-arrows-alt"></i></button>	
			</section>

           </div>
     
       
            <!-- Brand and toggle get grouped for better mobile display -->
		 
		   <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="drop-men" >
		        <ul class=" nav_1">
		           

		          		           <?php include("inc/perfil.inc");?>
		         
	
		           
		        </ul>
		     </div><!-- /.navbar-collapse -->
			<div class="clearfix">
       
     </div>

		    <div class="navbar-default sidebar" role="navigation"> <!--	Comienza Menu Lateral  -->
                <div class="sidebar-nav navbar-collapse"> <!--Div navbar-collapse	  -->
                 <!--A reemplazar por menu dinamico	  -->
                 <?php $cm->crear_menu_padre_bst();
                ?>
            </div> <!-- FIN Div navbar-collapse	  -->
			</div> <!--	FIN Menu Lateral  -->
        </nav>
		 <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
 	<!--banner-->	
		     <div class="banner">
		    	<h1>Formulario de Cotización</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="cotizador.php">Cotizaciones</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->




<?php include('inc/modal.inc'); ?>
	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_cotizaciones.php" method="post" id="formCotizacion">
            <input type="hidden" name="abm" value="ingreso_cotizacion">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
             <div class="col-md-4 form-group"> 
            <label class="control-label">Empresa</label>         
            <select class="form-control" id="empresa" name="empresa"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('empresa',$infoitem['idempresa'],0);
            }
            else
            {
                $cm->carga_selected('empresa',0,0);   
            }    
            
            ?>
            </div>        	
           <div class="col-md-4 form-group">
           	<label class="control-label" for="fechacotizacion">Fecha de Cotización</label>
           	<input type="date" class="form-control" id="fechacotizacion" name="fechacotizacion" onChange = "actualizaReferencia(<?php echo $nrocotizacionref; ?>)" value="<?php if ($id==0) {echo date('Y-m-d');   }else{echo date('Y-m-d',strtotime($infoitem[1]));    }  ?>">
           </div>
            <div class="col-md-4 form-group">
            <label class="control-label ">Referencia</label>         
              <input type="text"  id="referencia" name="referencia" class="form-control" value=" <?php if ($id!=0) { echo $infoitem['referencia'];}else {echo $referencia;}   ?> " >
            </div>

            <div class="col-md-3 form-group">
            <label class="control-label ">Cliente</label>         
            <div class="combo-boton">
            <select class="form-control" id="cliente" name="cliente"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('cliente',$infoitem['idcliente'],0);
            }
            else
            {
                $cm->carga_selected('cliente',0,0);   
            }    
            
            ?>
            <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarCliente()" role="group"><i class="fa fa-plus"></i></button>
                                    
            </div>
            </div>
            <?php  if ($id!=0) {$infocliente = $cm->getCliente($infoitem[3]);} ?>
            
            <div class="col-md-3 form-group"> 
            <label class="control-label">Contactos del Cliente</label>
            <div class="combo-boton">         
            <select class="form-control" id="contacto" name="contacto"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('contacto',$infoitem['idcontacto'],$infoitem['idcliente']);
            }
            else
            {
                $cm->carga_selected('contacto',0,0);   
            }    
            
            ?>
            <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarContacto()" role="group"><i class="fa fa-plus"></i></button>
            </div>     
            </div>
            <div class="col-md-3 form-group">
              <label class="control-label">Dirigida a</label>
              <input type="text"  id="contactoppal" name="contactoppal" class="form-control" value=" <?php if ($id!=0) { if($infoitem['idcontacto']==0){echo $infocliente[11];}else{echo $infoitem['nombrecon'];}}else {echo '';}   ?> " disabled>
            </div>            

            <div class="col-md-3 form-group">
			<label class="control-label">Email</label>
			<input type="text"  id="email" name="email" class="form-control" value="<?php if ($id!=0) { echo $infoitem['emailenvio'];}else {echo '';}   ?> " >
			</div>            
			<div class="col-md-12 form-group">
			<label class="control-label">Encabezado cotización</label>
              <textarea  id="textencabezado" name="textencabezado"> <?php if($id==0) { echo  $params['encabezadocotizacion'];}else{echo  $infoitem['encabezado'];}?> </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'textencabezado',{height:'50px' } );
            </script>
			</div>
           

           
            <div class="col-md-4 form-group"> 
            <label class="control-label">Equipos</label>         
            <div class="combo-boton">
            <select class="form-control" id="equipo" name="equipo" onChange="obtenerEquipo()" required>
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('equiposcliente',0,$infoitem['idcliente']);
            }
            else
            {
                $cm->carga_selected('equiposcliente',0,0);   
            }    
            
            ?>
             <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarEquipo()" role="group"><i class="fa fa-plus"></i></button>
			</div>
            </div>   
            <div class="col-md-4 form-group"> 
            <label class="control-label">Tareas</label>         
            <div class="combo-boton">
            <select class="form-control" id="tareas" name="tareas"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 

                $cm->carga_selected('itemscotizacion',0,0);   
   
            
            ?>
             <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarItem()" role="group"><i class="fa fa-plus"></i></button>
			</div>
            </div>   
            
            <div class="col-md-4 form-group"> 
             
             <button type="button" class="btn btn-primary btn-md btn-group" onclick="cotizarItem()" role="group">Cotizar Item</button>
            </div>   
            <div class="col-md-12 form-group1 group-mail" id="nuevoitem">
            <div class="col-md-1"><label  class="titulocotizacion">#</label></div>
            <div class="col-md-1"><label  class="titulocotizacion">Cant</label></div>
            <div class="col-md-5"><label  class="titulocotizacion">Tarea</label></div>
            <div class="col-md-2"><label  class="titulocotizacion">Precio</label></div>
            <div class="col-md-2"><label  class="titulocotizacion">Total</label></div>
            <?php
				
				if ($id!=0){
				$resultado = $cm->getCotizacionDetalle($id);
				$cantitemsd=0;
				$cantequiposd=0;
				$totalmontod=0;	
				while ($row=$resultado->fetch_array()){ 
			?>		
				<div class="col-md-12 form-group1 group-mail" id="nuevoitem">
				<input type="hidden" name="idequipo_<?php echo $row['iditemcotizacion']; ?>" id="idequipo_<?php echo $row['iditemcotizacion']; ?>" value="<?php echo $row['idequipo']; ?>">
				<div class="col-md-1"><input type="text" name="id_<?php echo $row['iditemcotizacion']; ?>" id="id_<?php echo $row['iditemcotizacion']; ?>" value='<?php echo $row['iditemcotizacion']; ?>'></div>

				<div class="col-md-1"><input type="text" name="cantidad_<?php echo $row['iditemcotizacion']; ?>" id="cantidad_<?php echo $row['iditemcotizacion']; ?>" value='<?php echo $row['cantidad']; ?>'></div>
				<div class="col-md-5"><textarea name="tarea_<?php echo $row['iditemcotizacion']; ?>" id="tarea_<?php echo $row['iditemcotizacion']; ?>" ><?php echo $row['txtitemcotizacion']; ?></textarea></div>
				<div class="col-md-2"><input type="text" name="precio_<?php echo $row['iditemcotizacion']; ?>" id="precio_<?php echo $row['iditemcotizacion']; ?>" value='<?php echo $row['preciounitario']; ?>'></div>
				<div class="col-md-2"><input type="text" class='totales' name="total_<?php echo $row['iditemcotizacion']; ?>" id="total_<?php echo $row['iditemcotizacion']; ?>" value="<?php if ($row['bonificado']==0){echo $row['preciounitario']*$row['cantidad'];}else{ echo 'Bonificado';} ?>"></div>
				<div class="col-md-1"><a class="acciones" onClick="addOne(<?php echo $row['iditemcotizacion']; ?>)"><i class="fa fa-plus-circle" title="Suma 1"></i></a> <a class="acciones" onClick="resOne(<?php echo $row['iditemcotizacion']; ?>)"><i class="fa fa-minus-circle" title="Resta 1"></i></a><a class="acciones" onClick="bonifica(<?php echo $row['iditemcotizacion']; ?>)"><i class="fa fa-gift" title="Bonifica"></i></a></div>
				</div>		
			<?php
				$cantitemsd++;
				$cantequiposd=$cantequiposd+$row['cantidad'];
				if ($row['bonificado']==0){$totalmontod=$totalmontod+( $row['preciounitario']*$row['cantidad']);}
				}}
			?>
			<input type="hidden" id="itemnumber" value='<?php if($id!=0){echo $cantitemsd;}else{echo 0;}?>'>
            <input type="hidden" id="itemmarca" value='0'>
            <input type="hidden" id="itemmodelo" value='0'>
            <input type="hidden" id="itemequipo" value='0'>
            </div>
            <div class="col-md-12 form-group1 group-mail" id="totales">
            <div class="col-md-1"><label  class="totalcotizacion" id="cantitems"><?php if($id!=0){echo $cantitemsd;}else{echo 0;}?></label></div>
            <div class="col-md-1"><label  class="totalcotizacion" id="cantequipos"><?php if($id!=0){echo $cantequiposd;}else{echo 0;}?></label></div>
            <div class="col-md-5"><label  class="totalcotizacion">--</label></div>
            <div class="col-md-2"><label  class="totalcotizacion">--</label></div>
            <div class="col-md-2"><label  class="totalcotizacion" id="totalcotizacion"><?php if($id!=0){echo $totalmontod;}else{echo 0;}?></label></div>
			</div>

            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Condiciones Comerciales</label>
              <textarea   id="condiciones" name="condiciones"><?php if($id==0) { echo  $params['condicionescomerciales'];}else{echo  $infoitem['condicionescomerciales'];}?> </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'condiciones' );
            </script>
            </div>
             <div class="clearfix"> </div>



          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="cotizador.php">Cancelar</a>
              <button type="button" class="btn btn-primary" onclick="validacion()">Procesar Formulario</button>

            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>
   
<script>


    $('#modalcliente').on('hidden.bs.modal', function () {
        cargarClientes();
    });
    
    $('#modalcontacto').on('hidden.bs.modal', function () {
        cargarContactos();
    });
	
	
    $('#modalequipo').on('hidden.bs.modal', function () {
        cargarEquipo();
    });


function agregarCliente(){

        $('#modalcliente').attr('data-remote','ajax/frmclientes.php');
        $('#modalcliente').modal('toggle');
   
};    

function cargarClientes(){
        var id = 0; // get selected value
        var combo ="cliente";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#cliente').html(resp);

});    
}

	
function agregarContacto(){
		idcliente = $('select#cliente').val();
		if(idcliente==0){
			alert('Debe seleccionar un cliente!');
		}else{
        $('#modalcontacto').attr('data-remote','ajax/frmcontactos.php?cliente='+idcliente);
        $('#modalcontacto').modal('toggle');
		}
   
};	
	

function cargarContactos(){

        var id = $('select#cliente').val(); // get selected value
        var combo ="contacto";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#contacto').html(resp);

});    
}	
	
function agregarEquipo(){
		idcliente = $('select#cliente').val();
		if(idcliente==0){
			alert('Debe seleccionar un cliente!');
		}else{
        $('#modalequipo').attr('data-remote','ajax/frmequipos.php?cliente='+idcliente);
        $('#modalequipo').modal('toggle');
		}
};    

function cargarEquipo(){
        var id = $('select#cliente').val(); // get selected value
        var combo ="equiposcliente";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:"equiposcliente", opcion:opcion }, function(resp) {
		$('select#equipo').html(resp);
});    
}	




//    $("#formCotizacion").on("submit", function(e) {
function ProcesarFormulario(){

	for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
	}
	
	var formURL = $("#formCotizacion").attr("action");
    var postData = $("#formCotizacion").serializeArray();
      
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
			dataType: "html",
            success: function(data, textStatus, jqXHR) {
				grabarItems(data);
		//	alert(data);	
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
//                e.preventDefault();  
}
//    });

function grabarItems(idcotizacion)
{
	var cant = parseInt($('input#itemnumber').val());
		//alert('Hay : '+cant+' items para grabar');	
	for(i = 1;i < (cant+1); i++){

		tarea = $('#tarea_'+i).html();
		cantidad = $('input#cantidad_'+i).val();
		precio = $('input#precio_'+i).val();
		total = $('input#total_'+i).val();
		idequipo = $('input#idequipo_'+i).val();
		
        $.get('class/manager_cotizaciones.php', { accion:'agregaitem', idcotizacion:idcotizacion, iditemcotizacion:i, tarea:tarea, cantidad:cantidad, precio:precio, total:total, idequipo:idequipo }, function(resp) {
		//alert('Se grabo el item:  '+resp);
		});    	
	}

	
	window.location = "cotizador.php";
}	

	


            $('#myModalConfirm').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });	
</script>

		<div class="clearfix"> </div>
       </div>
     <!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
<!---->

</body>
</html>


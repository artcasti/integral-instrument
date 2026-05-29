<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}
require_once("class/clases.php");

require_once("class/AppException.php");
$cm = new ConfigurationManager();


if (isset($_GET['id']))
{
    $id=$_GET['id'];
    $titulobread="Modificación Formulario de Ingreso";
    $infoitem=$cm->getIngreso($id);
}
else
{
    $id=0;
    $titulobread=" Formulario de Ingreso";
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
                cliente = document.getElementById("cliente").selectedIndex;
                if( cliente == '0') {
                alert('Debe seleccionar una Cliente');
                document.getElementById("cliente").focus();    
                return false;
                }

                return true;
            }
            
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
		$('input#telefono').val(obj2[3]);
		$('input#email').val(obj2[4]);
		$('input#domicilio').val(obj2[5]);
		$('input#cuit').val(obj2['nrodoc']);	
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
		$('input#telefono').val(obj['telefono']);
		$('input#email').val(obj['email']);
		$('input#domicilio').val(obj['domicilio']);
		$('input#cuit').val(obj['nrodoc']);	
		});
		  
        $.get('ajax/detcombo.php', { id:id, combo:"equiposcliente", opcion:opcion }, function(resp) {
       // alert(resp);
		$('select#equipo').html(resp);
        });	
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
		    	<h1>Formulario de Ingreso</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="entradalab.php">Laboratorio</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->




<?php include('inc/modal.inc'); ?>
	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_abms.php" method="post" id="userForm" enctype="multipart/form-data" onsubmit="return validacion()">
            <input type="hidden" name="abm" value="ingreso_cabecera">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
             <div class="col-md-4 form-group"> 
            <label class="control-label">Empresa</label>         
            <select class="form-control" id="empresa" name="empresa"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('empresa',$infoitem[2],0);
            }
            else
            {
                $cm->carga_selected('empresa',0,0);   
            }    
            
            ?>
            </div>        	
           <div class="col-md-4 form-group">
           	<label class="control-label" for="nroingreso">Ingreso Nro: </label>
           	<input type="text" class="form-control" id="nroingreso" name="nroingreso" value="<?php echo $id; ?>" disabled>
           </div>
           <div class="col-md-4 form-group">
           	<label class="control-label" for="fechaingreso">Fecha de Ingreso</label>
           	<input type="date" class="form-control" id="fechaingreso" name="fechaingreso" value="<?php if ($id==0) {echo date('Y-m-d');   }else{echo date('Y-m-d',strtotime($infoitem[1]));    }  ?>">
           </div>
            <div class="col-md-4 form-group">
             
            <label class="control-label ">Cliente</label>         
            <div class="combo-boton">
            <select class="form-control" id="cliente" name="cliente"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('cliente',$infoitem[3],0);
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
            
            <div class="col-md-4 form-group">
              <label class="control-label">Contacto Principal</label>
              <input type="text"  id="contactoppal" name="contactoppal" class="form-control" value=" <?php if ($id!=0) { echo $infocliente[11];}else {echo '';}   ?> " disabled>
            </div>            
            <div class="col-md-4 form-group"> 
            <label class="control-label">Contactos del Cliente</label>
            <div class="combo-boton">         
            <select class="form-control" id="contacto" name="contacto"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('contacto',$infoitem[4],$infoitem[3]);
            }
            else
            {
                $cm->carga_selected('contacto',0,0);   
            }    
            
            ?>
            <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarContacto()" role="group"><i class="fa fa-plus"></i></button>
            </div>     
            </div>
			<div class="col-md-12 form-group">
			<label class="control-label">Certificado a nombre de</label>
			<input type="text"  id="nombrecertificado" name="nombrecertificado" class="form-control" value=" <?php if ($id!=0) { echo $infoitem[5];}else {echo '';}   ?> ">
			</div>
			<?php if ($id!=0 && $infoitem[4]!=0) {$infocontacto = $cm->getContacto($infoitem[4]);}   ?>            
			<div class="col-md-3 form-group">
			<label class="control-label">Teléfono</label>
			<input type="text"  id="telefono" name="telefono" class="form-control" value=" <?php if ($id!=0) { if(isset($infocontacto)){echo $infocontacto[3];}else{echo $infocliente[9];}}else {echo '';}   ?> " disabled >
			</div>
            <div class="col-md-3 form-group">
			<label class="control-label">Email</label>
			<input type="text"  id="email" name="email" class="form-control" value=" <?php if ($id!=0) { if(isset($infocontacto)){echo $infocontacto[4];}else{echo $infocliente[12];}}else {echo '';}   ?> " disabled>
			</div>
            <div class="col-md-3 form-group">
			<label class="control-label">Domicilio</label>
			<input type="text"  id="domicilio" name="domicilio" class="form-control" value=" <?php if ($id!=0) { if(isset($infocontacto)){echo $infocontacto[5];}else{echo $infocliente[5];}}else {echo '';}   ?> " disabled>
			</div>
            <div class="col-md-3 form-group">
			<label class="control-label">CUIT</label>
			<input type="text"  id="cuit" name="cuit" class="form-control"value=" <?php if ($id!=0) { echo $infocliente[2];}else {echo '';}   ?> "  disabled>
			</div>
			<div class="col-md-6 form-group">
			<label class="control-label">Entregado por</label>
			<input type="text"  id="entregadopor" name="entregadopor" class="form-control">
			</div>            
			<?php  if ($id!=0) {?>

          	<div class="col-md-12 form-group" id="lista_equipos">
          	<div class="panel panel-default">
  <!-- Default panel contents -->
  				<div class="panel-heading">Equipos ingresados</div>
          		<div class="marcotrabajo" id="tlineas" data-example-id="contextual-table">
						<table class="table" id="powertable">
						  <thead>
							<tr>
							  <th>Equipo</th>
							  <th>Calibra</th>
							  <th>Repara</th>							  
							  <th>Accesorios</th>
							  <th>Imagen</th>
							  <th>Estado</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getIngresoDetalle($id);
                              while ($row=$resultado->fetch_array()){ 
								  $infoequipo = $cm->getEquipo($row[2]);
                              ?>
							<tr class="active">
							  <td><?php echo $infoequipo['marca'].'-'.$infoequipo['modelo'].'-'.$infoequipo['nroserie'];?></td>
							  <td><?php if($row[3]){echo 'SI';}else{echo 'NO';}?></td>
							  <td><?php if($row[4]){echo 'SI';}else{echo 'NO';}?></td>
							  <td><?php if($row[5]){echo 'Cargador-';} 
								 if($row[6]){echo 'Valija-';}
								  if($row[7]){echo 'Interfase-';}
								  if($row[8]){echo 'Bomba-';}
								  if($row[9]){echo 'Copa Calibración-';}
								  if($row[10]){echo 'Baterías';}
								  ?>
							  </td>
							  <td><img src="images/laboratorio/<?php echo $row['imagen'];?>" width="100px"></td>
							  <td><?php echo $row[14];?></td>
							  <td><a href="#" onclick="agregarIngreso(<?php echo $row[0];?>,<?php echo $row[1];?>)"><i class="fa fa-edit" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminaingreso&id=<?php echo $row[0];?>&linea=<?php echo $row[1];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>
					   </div>
				</div>
          	</div>

           <?php  } ?>
           
            <div class="col-md-12 form-group"> 
            <label class="control-label">Equipos</label>         
            <div class="combo-boton">
            <select class="form-control" id="equipo" name="equipo"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('equiposcliente',0,$infoitem[3]);
            }
            else
            {
                $cm->carga_selected('equiposcliente',0,0);   
            }    
            
            ?>
             <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarEquipo()" role="group"><i class="fa fa-plus"></i></button>
			</div>
            </div>   
            <?php if($id!=0) { ?>
			<div class="col-md-12 form-group">  
			<button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarIngreso(0,0)" role="group"><i class="fa fa-plus"></i> INGRESAR EQUIPO</button>
			</div>
            <?php   }?>
             <?php if($id==0) { ?>
            <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="col-md-2 control-label">Trabajos</label>
				<div class="col-md-10">
					<div class="checkbox-inline"><label><input type="checkbox" name="calibra" value="0"> Calibra</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="repara" value="0"> Repara</label></div>
				</div>	
				</div>
            </div>                                  
            <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="control-label">Imprime Vto Certificado?</label>
				<div class="col-md-10">
					<div class="checkbox-inline"><label><input type="radio" name="vtocertificado" value="1"> Si</label></div>
					<div class="checkbox-inline"><label><input type="radio" name="vtocertificado" value="0"> No</label></div>
				</div>	
				</div>
            </div>             
            <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="col-xs-2 control-label">Accesorios</label>
				<div class="col-xs-10">
					<div class="checkbox-inline"><label><input type="checkbox" name="cargador" value="0"> Cargador</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="valija" value="0"> Valija</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="interfase" value="0">Interfase</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="bomba" value="0">Bomba</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="copa" value="0">Copa de Calibración</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="baterias" value="0">Baterías</label></div>
				</div>
				</div>
            </div>                                  
              <div class="col-md-12 form-group group-mail">
                   
              <img src="<?php if($id!=0) { echo  'images/equipos/'.$infoitem[5];}else{ echo 'images/ico-file.jpg';} ?>" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  <?php if($id!=0) { echo  'value="'.$infoitem[5].'"';}else{ echo 'value="ico-file.jpg"';}?>>
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>        
            
            
            <div class="clearfix"> </div>
           

           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones"> </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>
           <?php   }?>




          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="entradalab.php">Cancelar</a>
              <button type="submit" class="btn btn-primary">Enviar Formulario</button>

            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>
 	<!--//grid-->     
     <div class="modal fade" id="myModalConfirm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Confirmación</h2>
				</div>
				<div class="modal-body">
					<p>Esta seguro de eliminar el equipo del formulario??</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger btn-ok">Eliminar</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
     </div>     
<script>


    $('#modalcliente').on('hidden.bs.modal', function () {
        cargarClientes();
    });
    
    $('#modalcontacto').on('hidden.bs.modal', function () {
        cargarContactos();
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

        var idf = $('select#cliente').val(); // obtengo value de combo familia
//alert('El valor del combo familia'+idf);
	if(idf==0){
        alert('Debe seleccionar un Cliente');
    }else{
        $('#modalcontacto').attr('data-remote','ajax/frmcontactos.php?cliente='+idf);
        $('#modalcontacto').modal('toggle');
    }
};    

function cargarContactos(){
        var id = $('select#cliente').val(); // get selected value
        var combo ="contacto";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#contacto').html(resp);
       // alert(resp);
});    
}	

function agregarEquipo(){

        $('#modalequipo').attr('data-remote','ajax/frmequipos.php');
        $('#modalequipo').modal('toggle');
   
};    

function cargarEquipo(){
        var id = $('select#cliente').val(); // get selected value
        var combo ="equiposcliente";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:"equiposcliente", opcion:opcion }, function(resp) {
		$('select#equipo').html(resp);
});    
}	


function agregarIngreso(equi,nrolinea){
		
		var equipo = $('#equipo').val();
		if (equi!=0){equipo=equi;}	
			
		if(equipo==0){
				alert('Debe seleccionar un equipo para agregar.');
		}else{
        $('#modalingreso').attr('data-remote','ajax/frmingreso.php?id=<?php echo $id;?>&idequipo='+equipo+'&nrolinea='+nrolinea);
        $('#modalingreso').modal('toggle');
   }
};	

            $('#myModalConfirm').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });	
</script>

		<div class="clearfix"> </div>
       </div>
     <!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/controlcuit.js"></script>
	<!--//scrolling js-->
<!---->

</body>
</html>


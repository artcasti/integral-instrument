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
    $titulobread="Modificación";
    $infoitem=$cm->getEquipo($id);
}
else
{
    $id=0;
    $titulobread=" Alta de Equipos";
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

<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>

  
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
                familia = document.getElementById("familia").selectedIndex;
                if( familia == '0') {
                alert('Debe seleccionar una Familia');
                document.getElementById("familia").focus();    
                return false;
                }
                
                marca = document.getElementById("marca").selectedIndex;
                if( marca == '0') {
                alert('Debe seleccionar una Marca');
                document.getElementById("marca").focus();    
                return false;
                }
                
                modelo = document.getElementById("modelo").selectedIndex;
                if( modelo == '0') {
                alert('Debe seleccionar un Modelo');
                document.getElementById("modelo").focus();    
                return false;
                }
                
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
      $('select#marca').on('change', function () {
        var id = $(this).val(); // get selected value
        var combo ="modelo";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#modelo').html(resp);
        });
      });
    });
            

$(function(){
      // bind change event to select
      $('#familia').on('change', function () {
        var id = $(this).val(); // get selected value
        var combo ="subfamilia";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('#subfamilia').html(resp);
        });
      });
    });            
</script>
		
<script>
$(function()
{
$('#abmsubfamilia').click(function(){
    
    alert('cargar los datos y redireccionar id:');
     $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));

})
});
</script>


<!----->
</head>
<body>
<div id="wrapper">
     <!----->
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
		    	<h1>Equipos</h1>
				<a href="index.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="equipos.php">Equipos</a>
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
            <input type="hidden" name="abm" value="equipo">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
            <div class="col-md-6 form-group"> 
            <label class="control-label">Familia</label>    
            <div class="combo-boton">     
            <select class="form-control" id="familia" name="familia"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('familia',$infoitem['idfamilia'],0);
            }
            else
            {
                $cm->carga_selected('familia',0,0);   
            }    
            
            ?>
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal" data-remote="ajax/frmfamilias.php?location='form_equipos.php?id=<?php echo $id;?>'"><i class="fa fa-plus"></i></button>
            </div>
            </div>
            <div class="col-md-6 form-group">
             
            <label class="control-label ">Subfamilia</label>         
            <div class="combo-boton">
            <select class="form-control" id="subfamilia" name="subfamilia"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('subfamilia',$infoitem['idsubfamilia'],$infoitem['idfamilia']);
            }
            else
            {
                $cm->carga_selected('subfamilia',0,0);   
            }    
            
            ?>
            <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarSubfamilia()" role="group"><i class="fa fa-plus"></i></button>
                                    
            </div>
            </div>
            <div class="col-md-6 form-group"> 
            <label class="control-label">Marca</label>
            <div class="combo-boton">         
            <select class="form-control" id="marca" name="marca"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('marcas',$infoitem['idmarca'],0);
            }
            else
            {
                $cm->carga_selected('marcas',0,0);   
            }    
            
            ?>
            <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarMarca()" role="group"><i class="fa fa-plus"></i></button>
            </div>
            </div>
            <div class="col-md-6 form-group"> 
            <label class="control-label">Modelo</label>         
            <div class="combo-boton">
            <select class="form-control" id="modelo" name="modelo"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('modelo',$infoitem['idmodelo'],$infoitem['idmarca']);
            }
            else
            {
                $cm->carga_selected('modelo',0,0);   
            }    
            
            ?>
             <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarModelo()" role="group"><i class="fa fa-plus"></i></button>
			</div>
            </div>                        
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Número de Serie</label>
              <input type="text" placeholder="Ej.TS30665785807" required="" name="nroserie" <?php if($id!=0) { echo  'value="'.$infoitem['nroserie'].'"';}?> >
            </div>
                                            
            <div class="col-md-12 form-group1 group-mail"> 
            <label class="control-label">Cliente</label>         
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
            </div>                   
       		<div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="control-label">Es equipo patrón?</label>
					<div class="checkbox-inline"><label><input type="radio" name="espatron" value="1" <?php if($id!=0) { if($infoitem['espatron']==1) {echo  'checked';}}?>> Si</label></div>
					<div class="checkbox-inline"><label><input type="radio" name="espatron" value="0" <?php if($id!=0) { if($infoitem['espatron']==0) {echo  'checked';}}?>> No</label></div>
					
				</div>
            </div> 
              <div class="col-md-12 form-group group-mail">
                   
              <img src="<?php if($id!=0) { echo  'images/equipos/'.$infoitem[6];}else{ echo 'images/ico-file.jpg';} ?>" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  <?php if($id!=0) { echo  'value="'.$infoitem[6].'"';}else{ echo 'value="ico-file.jpg"';}?>>
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>        
            
            
            <div class="clearfix"> </div>
           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones"> <?php if($id!=0) { echo  $infoitem['observaciones'];}?></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>



           

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="equipos.php">Cancelar</a>
              <button type="submit" class="btn btn-primary">Enviar Formulario</button>

            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>
 	<!--//grid-->     
     
<script>

    $('#myModal').on('hidden.bs.modal', function () {
        cargarFamilias();
    });

    $('#modalsubfamilia').on('hidden.bs.modal', function () {
        cargarSubfamilias();
    });
    

    $('#modalmarca').on('hidden.bs.modal', function () {
        cargarMarcas();
    });
  
    $('#modalmodelo').on('hidden.bs.modal', function (e) {
        cargarModelos();
    });	
    
function cargarFamilias(){

        var id = 0; // get selected value
        var combo ="familia";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#familia').html(resp);
//                    alert(resp); 
//        $.each(resp, function(key, value){
//            $('#familia').append($('<option>',{value : key})
//                                   .text(value));
//        });            
        });
      };

function agregarSubfamilia(){

        var idf = $('select#familia').val(); // obtengo value de combo familia
//alert('El valor del combo familia'+idf);
	if(idf==0){
        alert('Debe seleccionar una Familia');
    }else{
        $('#modalsubfamilia').attr('data-remote','ajax/frmsubfamilias.php?familia='+idf);
        $('#modalsubfamilia').modal('toggle');
    }
};    

function cargarSubfamilias(){
        var id = $('select#familia').val(); // get selected value
        var combo ="subfamilia";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#subfamilia').html(resp);
       // alert(resp);
//        $.each(resp, function(key, value){
//            $('#subfamilia').append($('<option>',{value : key})
//                                   .text(value));
//        });    
});    
}
	
function agregarMarca(){

        $('#modalmarca').attr('data-remote','ajax/frmmarcas.php');
        $('#modalmarca').modal('toggle');
}
	
function cargarMarcas(){
        var id = 0; // get selected value
        var combo ="marcas";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#marca').html(resp);
       // alert(resp);
//        $.each(resp, function(key, value){
//            $('#subfamilia').append($('<option>',{value : key})
//                                   .text(value));
//        });    
});    
}

function agregarModelo(){

        var idm = $('select#marca').val(); // obtengo value de combo familia
//alert('El valor del combo familia'+idm);
	if(idm==0){
        alert('Debe seleccionar una Marca');
    }else{
        $('#modalmodelo').attr('data-remote','ajax/frmmodelos.php?idmarca='+idm);
        $('#modalmodelo').modal('toggle');
    }
};    

function cargarModelos(){
        var id = $('select#marca').val(); // get selected value
        var combo ="modelo";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#modelo').html(resp);
       // alert(resp);
//        $.each(resp, function(key, value){
//            $('#subfamilia').append($('<option>',{value : key})
//                                   .text(value));
//        });    
});    
}	
	
	
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


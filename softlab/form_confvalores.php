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
    $titulobread=" Configuración de Valores";
    $infoitem=$cm->getFamilia($id);
	$unidadfamilia = $cm->getUnidadMedida($id);
}
else
{

	header("Location: valorescalibracion.php");
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
				
                unidad = document.getElementById("unidad").value;
				
				if( unidad == '') {
					alert('Debe ingresar una Unidad de Medida');
					document.getElementById("unidad").focus();
					return false;
                }
				
                valor = document.getElementById("valor").value;
				
				if( valor == '') {
					alert('Debe ingresar un valor');
					document.getElementById("valor").focus();
					return false;
                }
				
				
                return true;
            }
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
		     
		     <div class="alert alert-danger" id="mensaje_error" role="alert" hidden>Error: existen <?php if(isset($_GET['error'])){echo $_GET['error'];} ?> calibraciones utilizando este valor, elimine primero las calibraciones y luego podrá eliminar el valor nominal</div> 	
		     
		     
		    	<h1>Valores de Calibración</h1>
				<a href="entradalab.php">Laboratorio</a>
				<i class="fa fa-angle-right"></i>
				<a href="valorescalibracion.php">Valores por familia</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->

	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_abms.php" method="post" id="userForm" enctype="multipart/form-data" onsubmit="return validacion()">
            <input type="hidden" name="abm" value="valoresnominales">
            <input type="hidden" name="idfamilia" id="idfamilia" value="<?php echo $id;?>">
            <input type="hidden" name="idvalor" id="idvalor" value="0">            
         	<div class="vali-form">
            <div class="col-md-12 form-group"> 
            <label class="control-label">Familia</label>         
            <select id="familia" name="familia"  disabled>
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('familia',$id,0);
            }
            
            ?>
                
                </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Unidad de Medida</label>
              <input type="text" placeholder="Por ej.: LUX" name="unidad" id="unidad" value="<?php echo $unidadfamilia[0];  ?>">
            </div>
          
           <div class="col-md-7  group-mail">
              <label class="control-label">Valor</label>
              <input type="text" placeholder="" required="" id="valor" name="valor" >
              <button type="submit" class="btn btn-primary">Grabar</button>
            </div>
           
            <div class="clearfix"> </div>
            
            <div class="col-md-12 form-group" id="Valores">
			
           
            
            </div>            
            
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="valorescalibracion.php">Cancelar</a>
            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

     <div class="modal fade" id="myModalConfirm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-body">
					<p>Esta seguro de eliminar el valor??</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger btn-ok">Eliminar</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
     </div>


</div>
 	<!--//grid-->     
    
  
       
<script>
$(document).ready(function(){
	var id;
	id = document.getElementById('idfamilia').value;
$.get('ajax/abm_valorescalibracion.php', { id:id }, function(resp) {
        $('div#Valores').html(resp);
        });
	
	
});			

	
function editaValor(idvalor, valor){
	$('#idvalor').val(idvalor);
	$('#valor').val(valor);
$('#unidad').val($('#unidadmedida').val());	
}	

	
	
            $('#myModalConfirm').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });	
	
	
</script>

<script>
<?php
if(isset($_GET['error'])){?>
$('#mensaje_error').show();	
<?php }else{?>
$('#mensaje_error').hide();	
<?php }?>
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


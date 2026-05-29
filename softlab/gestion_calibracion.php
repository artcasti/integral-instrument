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
	    $infoitem=$cm->getCalibracion($id);
	$infofamilia=$cm->getFamilia($infoitem[2]);
	$infopatron = $cm->getEquipo($infoitem['idpatron']);
    $titulobread=$infoitem['nombrecal'];

}
else
{

	header("Location: calibraciones.php");
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
                familia = document.getElementById("familia").selectedIndex;
                if( familia == '0') {
                alert('Debe seleccionar una Familia');
                document.getElementById("familia").focus();    
                return false;
                }

                return true;
            }
            
    $(function(){
      // bind change event to select
      $('select#familia').on('change', function () {
        var id = $(this).val(); // get selected value
        $.get('ajax/equiposcalibracion.php', { id:id }, function(resp) {
        $('div#caja-equipos').html(resp);
        });
		  
		$.get('ajax/valorescalibracion.php', { id:id }, function(resp) {
        $('div#caja-valores').html(resp);
        });  
    
        var combo ="equipospatron";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#patron').html(resp);
        });
		  
		  
      });
    });

			
	
			
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
		    	<h1>Calibración de Equipos</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="calibraciones.php">Calibraciones</a>
				<i class="fa fa-angle-right"></i> <span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->




<?php include('inc/modal.inc'); ?>
	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">

            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">

            <div class="col-md-12 form-group">
           	<label class="control-label" >Nombre: <?php echo  $infoitem['nombrecal']; ?></label>
           </div>
           <div class="col-md-2 form-group">
           	<label class="control-label" >Calibración Nro: <?php echo $id; ?></label>
           </div>           
			<div class="col-md-3 form-group">
           	<label class="control-label" >Fecha de Alta: <?php echo date('d-m-Y',strtotime($infoitem[1])); ?></label>
           	</div>
           	<div class="col-md-3 form-group">
           	<label class="control-label" >Familia: <?php echo $infofamilia['familia']; ?></label>
           	</div>
           	<div class="col-md-4 form-group">
           	<label class="control-label" >Equipo Patrón: <?php echo $infopatron['marca'].'-'. $infopatron['modelo'].'-'. $infopatron['nroserie'];?></label>
           	</div>
          			
			<?php
			$cadena_valores='';	
			$val = explode('/',$infoitem[4]);
			foreach ($val as $valor)
			{
			if($valor !=''){	
			$row = $cm->getValorNominal($valor);    
			$cadena_valores .= $row['valornominal'].' '.$row['unidad'].'/';	
			}}
			$cadena_valores = substr($cadena_valores,0,-1);	
			?>
           
            <div class="col-md-12 form-group">
           	<label class="control-label" >Valores para la calibración: <?php echo $cadena_valores;?></label>
           	</div>
            
             
        <?php if($id!=0){
		?>
        <div id="caja-equipos-cargados">
        
				<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>ID Equipo</th>
							<th>Equipo</th>
							<th>Cliente</th>
							<th>Chequeo</th>
							<th>Valores</th>
						</tr>

						<?php
						$resultado = $cm->getCalibracionEquipos($id);
						while ($row=$resultado->fetch_array()){ 
							$infoequipo = $cm->getEquipo($row['idequipo']);
							$infoingreso = $cm->getIngreso($row['nroingreso']);
						?>
						<tr class="active">
						<td scope="row"><?php echo $row['idequipo'];?></td>
						<td><?php echo $infoequipo['marca'].'-'. $infoequipo['modelo'].'-'. $infoequipo['nroserie'];?></td>
						<td><?php echo $infoequipo['nombre'];?></td>
						
						<td><a href="chequeo_visual.php?id=<?php echo $id;?>&idequipo=<?php echo $row['idequipo'];?>" ><?php if ($row['chequeo']==1){echo '<i class="fa fa-check-square-o icon-green" title="Realizado"></i>'; }else{echo '<i class="fa fa-check-square-o" title="Pendiente"></i>';};?></a></td>
						
						<td><a href="cargar_calibracion.php?id=<?php echo $id;?>&idequipo=<?php echo $row['idequipo'];?>" ><?php if ($row['cargavalores']==1){echo '<i class="fa fa-list-alt icon-green" title="Realizado"></i>'; }else{echo '<i class="fa fa-list-alt" title="Pendiente"></i>';};?></a></td>
						</tr>	

						<?php }

							?>
						</table>				
					</div>
				</div>


        </div>
		&nbsp;
		<?php	
		}  ?>                 
          
                   
                                     
        &nbsp;                                    
          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="calibraciones.php">Cancelar</a>
             <a class="btn btn-warning btn-ok" href="cargar_calibracion.php?id=<?php echo $id; ?>">Cargar Calibración</a>
            </div>
          <div class="clearfix"> </div>

    
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
					<p>Esta seguro de eliminar el valor de la calibración??</p>
					<p>Esta acción no puede ser revertida.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger btn-ok">Eliminar</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
     </div>     
     <div class="modal fade" id="ModalEquipoConfirm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Confirmación</h2>
				</div>
				<div class="modal-body">
					<p>Esta seguro de eliminar el equipo de la calibración??</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger btn-ok">Eliminar</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
     </div>     
     
<script>
	

            $('#myModalConfirm').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });	
	
            $('#ModalEquipoConfirm').on('show.bs.modal', function(e) {
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


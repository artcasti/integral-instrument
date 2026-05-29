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
    $titulobread="Modificación Calibración";
    $infoitem=$cm->getCalibracion($id);
}
else
{
    $id=0;
    $titulobread=" Nueva Calibración";
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
				nombre = document.getElementById("nombrecal").value;
                if( nombre == '') {
                alert('Debe ingresar un nombre identificativo');
                document.getElementById("nombrecal").focus();    
                return false;
                }
				
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
		    	<h1>Formulario de Calibración</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="calibraciones.php">Calibraciones</a>
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
            <input type="hidden" name="abm" value="ingreso_calibracion">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
            <div class="col-md-12 form-group">
           	<label class="control-label" for="nombrecal">Nombre: </label>
           	<input type="text" class="form-control" id="nombrecal" name="nombrecal" value="<?php if($id!=0) {echo  $infoitem['nombrecal'];} ?>">
           </div>

            <div class="col-md-3 form-group">
           	<label class="control-label" for="nroingreso">Calibración Nro: </label>
           	<input type="text" class="form-control" id="nroingreso" name="nroingreso" value="<?php echo $id; ?>" disabled>
           </div>
           <div class="col-md-3 form-group">
           	<label class="control-label" for="fechaingreso">Fecha de Alta</label>
           	<input type="date" class="form-control" id="fechaingreso" name="fechaingreso" value="<?php if ($id==0) {echo date('Y-m-d');   }else{echo date('Y-m-d',strtotime($infoitem[1]));    }  ?>">
           </div>
             <div class="col-md-3 form-group"> 
            <label class="control-label">Familia</label>         
            <select class="form-control" id="familia" name="familia"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('familia',$infoitem[2],0);
            }
            else
            {
                $cm->carga_selected('familia',0,0);   
            }    
            
            ?>
            </div>
            <div class="col-md-3 form-group"> 
            <label class="control-label">Patrón</label>         
            <select class="form-control" id="patron" name="patron"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('equipospatron',$infoitem[3],$infoitem[2]);
            }
            else
            {
                $cm->carga_selected('equipospatron',0,0);   
            }    
            
            ?>
            </div>
            
        <?php if($id!=0){
		?>
        <div id="caja-valores-cargados">
		<h4>Valores a recolectar seleccionados</h4>
       
			<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>ID</th>
							<th>Valor Nominal</th>
							<th>Unidad de Medida</th>
							<th></th>
						</tr>

					<?php
					$val = explode('/',$infoitem[4]);
					foreach ($val as $valor)
					{
					if($valor !=''){	
					$row = $cm->getValorNominal($valor);    
						
					?>
						<tr class="active">
						<th scope="row"><?php echo $row['id'];?></th>
						<td><?php echo $row['valornominal'];?></td>
						<td><?php echo $row['unidad'];?></td>
						<td> <a href="#" data-href="class/manager_abms.php?accion=eliminavalorcalibracion&idvalor=<?php echo $row['id'];?>&idcalibracion=<?php echo $id;?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a></td>
						</tr>	


					<?php }}

						?>
						</table>				
					</div>
				</div>
       
        </div>
		&nbsp;
		<?php	
		}  ?> 
 
        <?php if($id!=0){
		?>
        <div id="caja-equipos-cargados">
        <h4>Equipos seleccionados para la calibración</h4>
        
				<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>Nro Ingreso</th>
							<th>Cliente</th>
							<th>Fecha Ingreso</th>
							<th>Equipo</th>
							<th></th>
						</tr>

						<?php
						$resultado = $cm->getCalibracionEquipos($id);
						while ($row=$resultado->fetch_array()){ 
							$infoequipo = $cm->getEquipo($row['idequipo']);
							$infoingreso = $cm->getIngreso($row['nroingreso']);
						?>
						<tr class="active">
						<th scope="row"><?php echo $row['nroingreso'];?></th>
						<td><?php echo $infoequipo['nombre'];?></td>
						<td><?php echo $infoingreso['fechaingreso'];?></td>
						<td><?php echo $infoequipo['marca'].'-'. $infoequipo['modelo'].'-'. $infoequipo['nroserie'];?></td>
						<td><a href="#" data-href="class/manager_abms.php?accion=eliminaequipocalibracion&idequipo=<?php echo $row['idequipo'];?>&idcalibracion=<?php echo $id;?>&nroingreso=<?php echo $row['nroingreso'];?>" data-toggle="modal" data-target="#ModalEquipoConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a></td>
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
          
                   
                                     
        <div id="caja-valores">
        <?php if($id!=0){
		?>
		<h4>Valores a agregar en la selección</h4>
       
			<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>ID</th>
							<th>Valor Nominal</th>
							<th>Unidad de Medida</th>
							<th></th>
						</tr>

					<?php
					$val = explode('/',$infoitem[4]);
					  $resultado = $cm->getValoresCalibracion($infoitem[2]);

						if($resultado){
							$cant = $resultado->num_rows;
							if($cant>0){
								while ($row=$resultado->fetch_array()){
									if(!in_array($row['id'],$val)){
							?>
						<tr class="active">
						<th scope="row"><?php echo $row['id'];?></th>
						<td><?php echo $row['valornominal'];?></td>
						<td><?php echo $row['unidad'];?></td>
						<td><input type="checkbox" name="valores[]" class="valores" value="<?php echo $row['id'].'+'.$row['valornominal'];?>"></td>
						</tr>	


					<?php }}}}

						?>
						</table>				
					</div>
				</div>
		
       
       <?php   }?>
        </div>
        &nbsp;   
        <div id="caja-equipos">
        <?php  if($id!=0){ ?>
        <h4>Seleccione los equipos a agregar en la selección</h4>
        
				<div class="form-group">
					<div class="col-md-12">
						<table class="table" >
						<tr>
							<th>Nro Ingreso</th>
							<th>Cliente</th>
							<th>Fecha Ingreso</th>
							<th>Equipo</th>
							<th></th>
						</tr>

						<?php
						$resultado = $cm->getListaEquiposCalibraciones($infoitem[2]);
						while ($row=$resultado->fetch_array()){ 
						?>
						<tr class="active">
						<th scope="row"><?php echo $row['nroingreso'];?></th>
						<td><?php echo $row['nombre'];?></td>
						<td><?php echo $row['fechaingreso'];?></td>
						<td><?php echo $row['marca'].'-'. $row['modelo'].'-'. $row['nroserie'];?></td>
						<td><input type="checkbox" name="equipos[]" class="equipos" value="<?php echo $row['idequipo'].'+'.$row['nroingreso'];?>"></td>
						</tr>	


						<?php }

							?>
						</table>				
					</div>
				</div>

        
        <?php  } ?>
        </div>
        &nbsp;                                    
          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="calibraciones.php">Cancelar</a>
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


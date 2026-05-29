<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}
require_once("class/clases.php");

require_once("class/AppException.php");
$cm = new ConfigurationManager();

/* Consultas de selección que devuelven un conjunto de resultados */
if (isset($_GET['filtro']))
{
    $filtro=$_GET['filtro'];
}
else
{
    $filtro=0;
}


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
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css"> 
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>
<script src="js/jquery.dataTables.js"> </script>
<script src="js/dataTables.bootstrap.js"> </script> 
  
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
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
            
            
    $(function(){
      // bind change event to select
      $('#btn-buscar').click(function () {

        var filtro = $('#filtro').val(); // get selected value
        $.get('ajax/detequipos.php', { filtro : filtro }, function(resp) {
        $('#tequipos').html(resp);
        });
      });
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
                      
            <form class=" navbar-left-right" name="formbusqueda" method="post" action="busqueda.php">
              <input type="text" name="filtro" value="Buscar..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Buscar...';}">
              <input type="submit" value="" class="fa fa-search">
            </form>
            
            <div class="clearfix"> </div>
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
		     <div class="alert alert-danger" id="mensaje_error" role="alert" hidden>Error: existen <?php if(isset($_GET['error'])){echo $_GET['error'];} ?> ingresos o cotizaciones asociados a esta equipo, elimine primero esos documentos y luego podrá eliminar el equipo</div> 
		    	<h1>Equipos</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Equipos</span>
				</h2>
		    </div>
		<!--//banner-->
    
    <div class="justaround">
       <h5>Todos los equipos en la base</h5>
           <div class="filtro">
<!--
           <input type="text" name="filtro" id="filtro" placeholder="Buscar">
               <a href="#" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;" id="btn-buscar">Buscar</a>    
-->
        <a href="class/bajaexcel2.php?seccion=equipos&filtro=0" style="margin-top: 0px; margin-right: 0px;" ><img src="images/excel.png" alt="descargar" title="Descargar a Excel" id="btn-excel" ></a>  
        
        <a href="form_equipos.php" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;">
            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">  Agregar Equipo<span/></a>
        </div>    
    </div>
                    <div class="marcotrabajo" id="tequipos" data-example-id="contextual-table">
						<table class="table" id="powertable">
						  <thead>
							<tr>
							  <th>Nombre</th>
							  <th>Familia</th>
							  <th>Subfamilia</th>
							  <th>Marca</th>
							  <th>Modelo</th>							  
							  <th>Nro de Serie</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaEquipos($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <td><?php echo $row['nombre'];?></td>
							  <td><?php echo $row['familia'];?></td>
							  <td><?php echo $row['subfamilia'];?></td>							  
							  <td><?php echo $row['marca'];?></td>
							  <td><?php echo $row['modelo'];?></td>
							  <td><?php echo $row['nroserie'];?></td>
							  <td style="width: 150px;"><a href="ficha_equipo.php?id=<?php echo $row['idequipo'];?>" ><i class="fa fa-id-card-o accion_icon" title="Ficha" aria-hidden="true"></i></a><a href="form_equipos.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit accion_icon" title="Editar"></i></a>
                              <a href="form_documentos.php?id=<?php echo $row[0];?>&tipo=3"><i class="fa fa-file-pdf-o accion_icon" title="Documentos Asociados"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminaequipo&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o accion_icon" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							<?php } ?>
						  </tbody>
						</table>
					   </div>				
     <div class="modal fade" id="myModalConfirm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Confirmación</h2>
				</div>
				<div class="modal-body">
					<p>Esta seguro de eliminar el equipo??</p>
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
        </script>		

<script>
<?php
if(isset($_GET['error'])){
	$sep = explode('-',$_GET['error']);
	if($sep[0]>0){
		$mensaje = 'Existen '.$sep[0].' cotizaciones asociadas al equipo. ';
	}
	if($sep[1]>0){
		$mensaje .= 'Existen '.$sep[0].' ingresos asociados al equipo. ';
	}	
?>
$('#mensaje_error').html('<?php echo $mensaje;?>');	
$('#mensaje_error').show();	
<?php }else{?>
$('#mensaje_error').hide();	
<?php }?>
</script>			
<script> $('#powertable').dataTable({
            "language": {
                "url": "js/dataTable.spanish.json"
            }
        } );       
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


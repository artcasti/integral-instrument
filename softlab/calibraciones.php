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
    $filtro='';
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
		     <div class="alert alert-danger" id="mensaje_error" role="alert" hidden>Error: existen <?php if(isset($_GET['error'])){echo $_GET['error'];} ?> equipos asociados a esta calibración, elimine primero los equipos de la calibración y luego podrá eliminar la calibración</div> 
		     
		    	<h1>Laboratorio</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Calibraciones</span>
				</h2>
		    </div>
		<!--//banner-->
    
    <div class="justaround">
       <h5>Todas las Calibraciones</h5>
           <div class="filtro">
<!--           
           <input type="text" name="filtro" id="filtro" placeholder="Buscar">
               <a href="#" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;" id="btn-buscar">Buscar</a>    -->
        <a href="form_calibracion.php" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;">
            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">  Nueva Calibración<span/></a>
        </div>    
    </div>
                    <div class="marcotrabajo" id="tcalibraciones" data-example-id="contextual-table">
						<table class="table" id="powertable">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Fecha Alta</th>
							  <th>Nombre</th>
							  <th>Familia</th>
							  <th>Cant Equipos</th>							  
							  <th>Estado</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaCalibraciones($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row">
							  <?php echo $row['id'];?>
							  </th>
							  <td><?php echo $row['fechaalta'];?></td>
							  <td><?php echo $row['nombrecal'];?></td>
							  <td><?php echo $row['familia'];?></td>
							  <td><?php echo $row['CantEquipos'];?></td>
							  <td><?php echo $row['estado'];?></td>
							  <td>
                            	<a href="gestion_calibracion.php?id=<?php echo $row['id'];?>" ><i class="fa fa-play-circle-o icon-green" title="Comenzar"></i></a>
                             <a href="form_calibracion.php?id=<?php echo $row['id'];?>" ><i class="fa fa-edit" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminacalibracion&id=<?php echo $row['id'];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a>
                              
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
					<p>Esta seguro de eliminar la calibración??</p>
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


		<div class="clearfix"> </div>
       </div>
<script> $('#powertable').dataTable({
            "language": {
                "url": "js/dataTable.spanish.json"
            }
        } );       
</script> 
<script>
<?php
if(isset($_GET['error'])){?>
$('#mensaje_error').show();	
<?php }else{?>
$('#mensaje_error').hide();	
<?php }?>
</script>	
               
     <!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
<!---->

</body>
</html>


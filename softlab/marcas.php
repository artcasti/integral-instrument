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
		           <div class="alert alert-danger" id="mensaje_error" role="alert" hidden>Error: existen <?php if(isset($_GET['error'])){echo $_GET['error'];} ?> modelos asociados a esta marca, elimine primero los modelos y luego podrá eliminar la marca</div> 
		    	<h1>Marcas</h1>
				<a href="index.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Marcas</span>
				</h2>
		    </div>
		<!--//banner-->
    
    <div class="justaround">
       <h5>Todas las marcas en la base</h5>
        <a href="form_marcas.php" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;">
            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">  Agregar Marca<span/></a>
    </div>
                    <div class="marcotrabajo" data-example-id="contextual-table">
						<table class="table" id="powertable">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Marca</th>
							  <th>Imagen</th>
							  <th>Sitio Web</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaMarcas();
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><img src="images/marcas/<?php echo $row[2];?>" width="50px" alt=""></td>
							  <td><a href="<?php echo $row[3];?>" target="_blank"><?php echo $row[3];?></a></td>
							  <td><a href="form_marcas.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminamarca&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a>
                        
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
					<p>Esta seguro de eliminar la marca??</p>
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
if(isset($_GET['error'])){?>
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


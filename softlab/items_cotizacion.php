<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
    header("Location: signin.php");
}

require_once("class/clases.php");

require_once("class/AppException.php");
$cm = new ConfigurationManager();


?>

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
                <!-- Banner -->
                <div class="banner">
                    <h1>Ítems de Cotización</h1>
                </div>
                <!--// Banner -->

                <div class="justaround">
                    <h5>Ítems en la base</h5>
                    <div class="filtro">
                        <a href="form_items.php" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;">
                            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"> Agregar Ítem</span>
                        </a>
                    </div>    
                </div>

                <div class="marcotrabajo" id="titems" data-example-id="contextual-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>ID Capítulo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $resultado = $cm->getListaItemsCotizacion(); // Implementa la función para obtener los ítems
                            while ($row=$resultado->fetch_array()){ 
                        ?>
                            <tr class="active">
                                <td><?php echo $row['iditemcotizacion'];?></td>
                                <td><?php echo $row['txtitemcotizacionlista'];?></td>
                                <td><?php echo $row['preciolista'];?></td>
                                <td><?php echo $row['idcapitulo'];?></td>
                                <td>
                                    <a href="form_items.php?id=<?php echo $row['iditemcotizacion'];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                                    <a href="#" data-href="class/manager_abms.php?accion=eliminaitem&id=<?php echo $row['iditemcotizacion'];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o nav_icon" title="Eliminar"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>              

                <!-- Modal para confirmar eliminación -->
                <div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h2 class="modal-title">Confirmación</h2>
                            </div>
                            <div class="modal-body">
                                <p>¿Está seguro de eliminar este ítem?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <a class="btn btn-danger btn-ok">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#myModalConfirm').on('show.bs.modal', function(e) {
                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                    });
                </script>        
            </div>
        </div>
    </div>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

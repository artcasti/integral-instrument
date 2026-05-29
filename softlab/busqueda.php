<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}

require_once("class/clases.php");

require_once("class/AppException.php");
$cm = new ConfigurationManager();
$filtro = (isset($_POST['filtro']))?$_POST['filtro']:'';



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

<!--pie-chart--->
<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->
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
               <h1> <a class="navbar-brand" href="index.php">Softlab</a></h1>         
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
	  
		    <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                 <?php $cm->crear_menu_padre_bst();
                ?>
                </div>
			</div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
  		<!--banner-->	
		    <div class="banner">
		   
				<h2>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Búsqueda</span>
				</h2>
		    </div>
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			<?php   
			$equiposingresados = $cm->getKPIEquiposIngresados();
			$clientesincompletos = $cm->getKPIClientesIncompletos();
			
			?>
			
			<div class="col-md-12 ">
				<div class="content-top-1">
				<div class="col-md-12 top-content">
					<h5>Clientes encontrados</h5>
				</div>
				<div class="col-md-12 top-content1">	   
						<table class="table" id="powertablecli">
						  <thead>
							<tr>
							  <th>Tipo Doc</th>
							  <th>Nro Doc</th>
							  <th>Nombre</th>
<!--							  <th>Condición IVA</th>-->
							  <th>Localidad</th>
							  <th>Habilitado</th>							  
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaClientes($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[21];?></th>
							  <td><?php echo $row[2];?></td>
							  <td><?php echo $row[3];?></td>
<!--							  <td><?php echo $row[19];?></td>-->
							  <td><?php echo $row[6];?></td>
							  <td><?php echo $row[14];?></td>
								<td style="width:150px;"><a href="ficha_cliente.php?id=<?php echo $row[0];?>" ><i class="fa fa-id-card-o accion_icon" aria-hidden="true"></i></a><a href="form_clientes.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit accion_icon" title="Editar" aria-hidden="true"></i></a><a href="form_documentos.php?id=<?php echo $row[0];?>&tipo=2"><i class="fa fa-file-pdf-o accion_icon" title="Documentos Asociados"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminacliente&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o accion_icon" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>

				</div>
				 <div class="clearfix"> </div>
				</div>
				
				
				<div class="content-top-1">
				<div class="col-md-12 top-content">
					<h5>Formularios de Ingreso</h5>
				</div>
				<div class="col-md-12 top-content1">	   
				
					<table class="table" id="powertableing">
						  <thead>
							<tr>
							  <th>Nro Ingreso</th>
							  <th>Cliente</th>
							  <th>Fecha de Ingreso</th>
							  <th>Cant Equipos</th>
							  <th>Estado</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getOrdenesIngresoBusqueda($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row['nroingreso'];?></th>
							  <td><?php echo $row['nombre'];?></td>
							  <td><?php echo $row['fechaingreso'];?></td>
							  <td><?php echo $row['CantEquipos'];?></td>
							  <td><?php echo $row['estado'];?></td>
							  <td><a href="form_ingreso.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit" title="Editar"></i></a>
                              <a href="genpdf.php?tipodoc=fing&nroingreso=<?php echo $row[0];?>" target="_blank"><i class="fa fa-print" title="Genera PDF" ></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminaingreso&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>

				
				</div>
				 <div class="clearfix"> </div>
				</div>
				<div class="content-top-1">
				<div class="col-md-12 top-content">
					<h5>Cotizaciones encontradas</h5>
				</div>
				<div class="col-md-12 top-content1">	   
					<table class="table" id="powertablecot">
						  <thead>
							<tr>
							  <th>Nro Cotización</th>
							  <th>Cliente</th>
							  <th>Nro Referencia</th>
							  <th>Fecha Cotización</th>
							  <th>Fecha Vencimiento</th>
							  							 
							  <th>Estado</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaCotizaciones($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <td><?php echo $row['idcotizacion'];?></td>
							  <td><?php echo $row['nombrecli'];?></td>
							  <td><?php echo $row['referencia'];?></td>
							  <td><?php echo date_format(date_create($row['fechacotizacion']),'d-m-Y');?></td>
							  <td><?php echo date_format(date_create($row['fechavencimiento']),'d-m-Y');?></td>
							  <td><?php echo $row['estadotxt'];?></td>
							  
							  <td><a href="form_cotizacion.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit accion_icon" title="Editar"></i></a>
                              <a href="genpdf.php?tipodoc=2&dest=I&ref=<?php echo $row['referencia'];?>&idcotizacion=<?php echo $row['idcotizacion'];?>"><i class="fa fa-file-pdf-o accion_icon" title="Ver PDF"></i></a><a href="#" onclick='prepararEnvio("2",<?php echo $row['idcotizacion'];?>,"<?php echo $row['referencia'] ;?>");'><i class="fa fa-envelope-o accion_icon" aria-hidden="true"></i></a>
                              <a href="#" data-href="class/manager_cotizaciones.php?accion=eliminacotizacion&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o accion_icon" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>
					</div>
				 <div class="clearfix"> </div>
				</div>
			</div>

		<div class="clearfix"> </div>
		</div>
		<!---->
	
  




	 
		<!---->
<div class="copy">

	    </div>
		</div>
		<div class="clearfix"> </div>
       </div>
     </div>
<!---->

<script> $('#powertablecli').dataTable({
            "language": {
                "url": "js/dataTable.spanish.json"
            }
        } );       
</script> 

<script> $('#powertableing').dataTable({
            "language": {
                "url": "js/dataTable.spanish.json"
            }
        } );       
</script> 
<script> $('#powertablecot').dataTable({
            "language": {
                "url": "js/dataTable.spanish.json"
            }
        } );       
</script> 

<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->

</body>
</html>


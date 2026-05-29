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

    $infoitem=$cm->getCliente($id);
    $titulobread="Ficha de Cliente: ".$infoitem['nombre'];
}
else
{
	header("Location: clientes.php");
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
		    	<h1>Clientes</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="clientes.php">Clientes</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->

	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
	<div>
	   <ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#informacion" data-toggle="tab">Información</a></li>
		<li ><a href="#contactos" data-toggle="tab">Contactos</a></li>
		<li ><a href="#equipos" data-toggle="tab">Equipos</a></li>
		<li ><a href="#cotizaciones" data-toggle="tab">Cotizaciones</a></li>
		<li ><a href="#documentos" data-toggle="tab">Documentos</a></li>
	  </ul>     
           <div class="tab-content">
		    <div class="tab-pane active" id="informacion">	
            
           <div class="col-md-12 form-group" >
           <?php  $infotrans = $cm->getTransporte($infoitem['idtransporte']);
		 		   if (empty($infotrans)) {
					// Asignar valores específicos a $infotrans cuando no haya resultados
					$infotrans = array(
						'transporte' => 'Sin transporte predeterminado',
						'telefono' => ' ',
						'email' => ' ',
						// Agrega aquí otros valores que necesites
					); 
				} 
		   ?>
           <table class="tabla-ficha">
           	<tr><th>Razón Social</th><td><?php echo  $infoitem['nombre'];  ?></td></tr>
			<tr><th>Documento</th><td><?php echo  $cm->getTipoDocCliente($infoitem['tipodoc'])[0].'-'.$infoitem['nrodoc'];  ?></td></tr>
          	<th>Condición IVA</th><td><?php echo  $cm->getCondicionIVA($infoitem[4])[0];  ?></td></tr>
           	<tr><th>Domicilio</th><td><?php echo  $infoitem['domicilio'].' - ('.$infoitem['cpostal'].') '.$infoitem['localidad'].' - '.$infoitem['provincia'].' - '.$infoitem['pais'];  ?></td></tr>
           	<tr><th>Contacto principal</th><td><?php echo  $infoitem['contactoppal'].' - '.$infoitem['telefono'].' - '.$infoitem['email'] ;  ?></td></tr>
           	<tr><th>Transporte</th><td><?php echo  $infotrans['transporte'].' - '.$infotrans['telefono'].' - '.$infotrans['email'] ;  ?></td></tr>
			<tr><th>Clasificación</th><td><p>
                    <input class ="estrellas" id="radio1" type="radio" name="estrellas" value="5" <?php if ($id!=0){echo $checked= ($infoitem[16]==5) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio1">&#9733;</label><!--
                    --><input class ="estrellas" id="radio2" type="radio" name="estrellas" value="4" <?php if ($id!=0){echo $checked= ($infoitem[16]==4) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio2">&#9733;</label><!--
                    --><input class ="estrellas" id="radio3" type="radio" name="estrellas" value="3" <?php if ($id!=0){echo $checked= ($infoitem[16]==3) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio3">&#9733;</label><!--
                    --><input class ="estrellas" id="radio4" type="radio" name="estrellas" value="2" <?php if ($id!=0){echo $checked= ($infoitem[16]==2) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio4">&#9733;</label><!--
                    --><input class ="estrellas" id="radio5" type="radio" name="estrellas" value="1" <?php if ($id!=0){echo $checked= ($infoitem[16]==1) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio5">&#9733;</label>
                  </p>
			</td></tr>
			<tr><th>Habilitado</th><td>            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="1" <?php if($id!=0) { if($infoitem[14]==1)echo  'checked=""';}else{echo  'checked=""';}?> disabled> Si</label></div>
            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="0" <?php if($id!=0) { if($infoitem[14]==0)echo  'checked=""';}?> disabled> No</label></div>
			</td></tr>
          	<tr><th>Observaciones</th><td class="texto-observaciones"><?php echo  $infoitem['observaciones'];  ?></td></tr>
           </table>
			</div> 
        	
			</div><!--	Fin del tab informacion     	    -->
			<div class="tab-pane" id="contactos">
			
			<table class="table">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Contacto</th>
							  <th>Email</th>
							  <th>Teléfono</th>
							  <th>Imagen</th>
							  <th>Observaciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaContactosCliente($id);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><?php echo $row[4];?></td>
							  <td><?php echo $row[3];?></td>
							  <td><img src="images/contactos/<?php echo $row['imagen'];?>" alt="" class="imagen-contacto"></td>
							  <td><?php echo $row['observaciones'];?></td>
							</tr>
							
							<?php } ?>
	
						  </tbody>
						</table>

			
			
			</div><!--	Fin del tab contactos     	    -->			
			
			<div class="tab-pane" id="equipos">
				<table class="table">
						  <thead>
							<tr>
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
                           
                              $resultado = $cm->getListaEquiposCliente($id);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <td><?php echo $row['familia'];?></td>
							  <td><?php echo $row['subfamilia'];?></td>							  
							  <td><?php echo $row['marca'];?></td>
							  <td><?php echo $row['modelo'];?></td>
							  <td><?php echo $row['nroserie'];?></td>
							  <td><a href="ficha_equipo.php?id=<?php echo $row['idequipo'];?>" ><i class="fa fa-id-card-o accion_icon" title="Ficha" aria-hidden="true"></i></a><a href="form_equipos.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit accion_icon" title="Editar"></i></a>
                              <a href="form_documentos.php?id=<?php echo $row[0];?>&tipo=3"><i class="fa fa-file-pdf-o accion_icon" title="Documentos Asociados"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminaequipo&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o accion_icon" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							<?php } ?>
						  </tbody>
						</table>

			</div><!-- Fin Tab Equipos-->

			<div class="tab-pane" id="cotizaciones">
						<table class="table">
						  <thead>
							<tr>
						  <th>Empresa</th>
							  <th>Nro Cotización</th>
							  <th>Nro Referencia</th>
							  <th>Fecha Cotización</th>
							  <th>Fecha Vencimiento</th>	 
							  <th>Estado</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaCotizacionesCliente($id);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <td><?php echo $row['nombreemp'];?></td>						  	
							  <td><?php echo $row['idcotizacion'];?></td>
							  <td><?php echo $row['referencia'];?></td>
							  <td><?php echo date_format(date_create($row['fechacotizacion']),'d-m-Y');?></td>
							  <td><?php echo date_format(date_create($row['fechavencimiento']),'d-m-Y');?></td>
							  <td><?php echo $row['estadotxt'];?></td>
							  
							  <td><a href="form_cotizacion.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                              <a href="genpdf.php?tipodoc=2&dest=I&ref=<?php echo $row['referencia'];?>&idcotizacion=<?php echo $row['idcotizacion'];?>"><i class="fa fa-file-pdf-o nav_icon" title="Ver PDF"></i></a><a href="#" onclick='prepararEnvio("2",<?php echo $row['idcotizacion'];?>,"<?php echo $row['referencia'] ;?>");'><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                              <a href="#" data-href="class/manager_cotizaciones.php?accion=eliminacotizacion&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o nav_icon" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>

			</div><!-- Fin Tab cotizaciones-->
		
			<div class="tab-pane" id="documentos">
     						<table class="table">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Nombre</th>
							  <th>Archivo</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                              $cm = new ConfigurationManager();
                              $resultado = $cm->getListaDocumentos(2, $id);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><a href="documentos/<?php echo $row[2];?>" target="_blank"><?php echo $row[2];?></a></td>
							  <td>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminadocumento&id=<?php echo $row[0];?>&idpadre=<?php echo $id;?>&tipo=<?php echo $tipodoc;?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i>
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>    
			</div><!-- Fin Tab documentos-->
			
																	
						
		</div> <!--	Fin del tab content -->
	 </div><!-- Fin del contenedor de titulos ul de los tabs-->       	    	     	    

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-info btn-ok" href="clientes.php">Volver</a>
            </div>
          <div class="clearfix"> </div>
    
 	<!---->
 </div>

</div>
 	<!--//grid-->     
     


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


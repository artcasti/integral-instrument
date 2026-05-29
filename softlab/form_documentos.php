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
    $tipodoc=$_GET['tipo'];
    
    switch ($tipodoc)
    {
        case '1':
    $titulobread=" Documentos del modelo";
    $infoitem=$cm->getInfoModelo($id);
    $tituloficha = $infoitem[1].' <i class="fa fa-angle-right"></i> '.$infoitem[2];
    $titulohome = "Modelos";
	$origen="modelos.php";        
            break;
        case '2':
    $titulobread=" Documentos del cliente";
    $infoitem=$cm->getCliente($id);
    $tituloficha = $infoitem['nrodoc'].' <i class="fa fa-angle-right"></i> '.$infoitem['nombre'];        
    $origen="clientes.php"; 
	$titulohome = "Clientes";		
            break;  
        case '3':
    $titulobread=" Documentos del equipo";
    $infoitem=$cm->getEquipo($id);
    $tituloficha = $infoitem['marca'].' <i class="fa fa-angle-right"></i> '.$infoitem['modelo'].' <i class="fa fa-angle-right"></i> '.$infoitem['nroserie'];        
    $origen="equipos.php"; 
	$titulohome = "Equipos";		
            break;  
        case '4':
    $titulobread=" Documentos de la empresa";
    $infoitem=$cm->getEmpresa($id);
    $tituloficha = $infoitem[2].' <i class="fa fa-angle-right"></i> '.$infoitem[3];        
    $origen="empresas.php";
	$titulohome = "Empresas";		
            break;          
        case '4':
    $titulobread=" Documentos del  ingreso";
    $infoitem=$cm->getIngreso($id);
    $tituloficha = $infoitem[2].' <i class="fa fa-angle-right"></i> '.$infoitem[3];        
    $origen="entradalab.php";        
            break;          			
    }    
}
else
{
    $id=0;
    $tipodoc=0;
        $titulobread=" Documentos del modelo";
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
                nombre = document.getElementById("nombre").value;
                if( nombre == '') {
                alert('Debe ingresar un Nombre');
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
		    	<h1>Documentos</h1>
				<a href="<?php echo $origen;?>"><?php echo $titulohome;?></a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				
		    </div>
		<!--//banner-->

	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
            <div class="col-md-12"> 
            <h2><?php echo $tituloficha?></h2>         
            </div>
           
            <div class="col-md-12 form-group" id="documentos">
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
                              $resultado = $cm->getListaDocumentos($tipodoc, $id);
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
            </div>            
   <div class="modal fade" id="myModalConfirm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Confirmación</h2>
				</div>
				<div class="modal-body">
					<p>Esta seguro de eliminar el Documento??</p>
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
  	    
        <form action="class/manager_abms.php" method="post" id="userForm" enctype="multipart/form-data" onsubmit="return validacion()">
            <input type="hidden" name="abm" value="documento">
            <input type="hidden" name="tipodoc" value="<?php echo $tipodoc;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
                <div class="col-md-12 form-group1 group-mail">
                <label class="control-label">Nombre del Documento</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese un nombre para el documento, ej: Manual">
                </div>
                
                <div class="col-md-6 form-group1 group-mail">
                <label class="control-label">Seleccione el archivo a subir</label>
              <input type="file" id="DocInput" name="DocInput">
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>
            <div id="output"></div>
                 </div>

            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="<?php echo $origen;?>">Cancelar</a>
              <button type="submit" class="btn btn-primary">Enviar Formulario</button>
              <?php if($id==0) { ?>
              <button type="reset" class="btn btn-default">Reset</button>
            <?php }?>
            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>
 	<!--//grid-->     
     


		<div class="clearfix"> </div>
       </div>
     <!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
<!---->

</body>
</html>


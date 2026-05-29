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
    $titulobread="Modificación";
    $infoitem=$cm->getModelo($id);
}
else
{
    $id=0;
    $titulobread=" Alta de Modelo";
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
                marcas = document.getElementById("marcas").selectedIndex;
                if( marcas == '0') {
                alert('Debe seleccionar una Marca');
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
		    	<h1>Modelos</h1>
				<a href="index.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="modelos.php">Modelos</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->

	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_abms.php" method="post" id="userForm" enctype="multipart/form-data" onsubmit="return validacion()">
            <input type="hidden" name="abm" value="modelo">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
            <div class="col-md-12 form-group"> 
            <label class="control-label">Marca</label>         
            <select id="marcas" name="marcas"  >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('marcas',$infoitem[5],0);
            }
            else
            {
                $cm->carga_selected('marcas',0,0);   
            }    
            
            ?>
                <a href="form_marcas.php" class="btn btn-primary btn-sm" style="margin-top: 0px; margin-right: 0px;">
            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"><span/></a>
                </div>
            <div class="col-md-6 form-group1">
              <label class="control-label">Modelo</label>
              <input type="text" placeholder="Modelo" required="" name="modelo" <?php if($id!=0) { echo  'value="'.$infoitem[1].'"';}?> >
            </div>
                <div class="col-md-6 form-group1">
              <img src="<?php if($id!=0) { echo  'images/modelos/'.$infoitem[2];}else{ echo 'images/ico-file.jpg';} ?>" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  <?php if($id!=0) { echo  'value="'.$infoitem[2].'"';}else{ echo 'value="ico-file.jpg"';}?>>
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>
                 
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Sitio WEB</label>
              <input type="text" placeholder="Sitio WEB del Modelo" name="urlmodelo" <?php if($id!=0) { echo  'value="'.$infoitem[3].'"';}?>>
            </div>
            <div class="clearfix"> </div>
           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones"> <?php if($id!=0) { echo  $infoitem[4];}?></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>



           

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="modelos.php">Cancelar</a>
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


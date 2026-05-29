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
    $infoitem=$cm->getContacto($id);
}
else
{
    $id=0;
    $titulobread=" Alta de Contacto";
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
		    	<h1>Contactos</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="contactos.php">Contactos</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->

	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_abms.php" method="post" id="userForm" enctype="multipart/form-data" onsubmit="return validacion()">
            <input type="hidden" name="abm" value="contacto">
            <input type="hidden" name="id" value="<?php echo $id;?>">
         	<div class="vali-form">
         	  <div class="col-md-6 form-group1">
              <img src="<?php if($id!=0) { echo  'images/contactos/'.$infoitem[13];}else{ echo 'images/contactos/perfil.jpg';} ?>" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  <?php if($id!=0) { echo  'value="'.$infoitem[13].'"';}else{ echo 'value="perfil.jpg"';}?>>
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>
           <div class="col-md-6 form-group1" >
                 <p class="clasificacion">
                    <input class ="estrellas" id="radio1" type="radio" name="estrellas" value="5" <?php if ($id!=0){echo $checked= ($infoitem[11]==5) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio1">&#9733;</label><!--
                    --><input class ="estrellas" id="radio2" type="radio" name="estrellas" value="4" <?php if ($id!=0){echo $checked= ($infoitem[11]==4) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio2">&#9733;</label><!--
                    --><input class ="estrellas" id="radio3" type="radio" name="estrellas" value="3" <?php if ($id!=0){echo $checked= ($infoitem[11]==3) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio3">&#9733;</label><!--
                    --><input class ="estrellas" id="radio4" type="radio" name="estrellas" value="2" <?php if ($id!=0){echo $checked= ($infoitem[11]==2) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio4">&#9733;</label><!--
                    --><input class ="estrellas" id="radio5" type="radio" name="estrellas" value="1" <?php if ($id!=0){echo $checked= ($infoitem[11]==1) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio5">&#9733;</label>
                  </p>
           </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Contacto</label>
              <input type="text" placeholder="Ej.Carlos Gonzalez" required="" name="contacto" <?php if($id!=0) { echo  'value="'.$infoitem[1].'"';}?> >
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Teléfono</label>
              <input type="text" placeholder="Ej. 1146658997" name="telefono" <?php if($id!=0) { echo  'value="'.$infoitem[3].'"';}?>>
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Correo Electrónico</label>
              <input type="text" placeholder="Ej. eduardogonzalez@hotmail.com" name="email" <?php if($id!=0) { echo  'value="'.$infoitem[4].'"';}?>>
            </div>
                                  
            <div class="col-md-12 form-group"> 
            <label class="control-label">Cliente</label>         
            <select class="form-control" id="cliente" name="cliente"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('cliente',$infoitem[2],0);
            }
            else
            {
                $cm->carga_selected('cliente',0,0);   
            }    
            
            ?>
            </div>                 
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Domicilio</label>
              <input type="text" placeholder="Ej. Pavón 1555 Piso 1 Depto 2" name="domicilio" <?php if($id!=0) { echo  'value="'.$infoitem[5].'"';}?>>
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Localidad</label>
              <input type="text" placeholder="Ej. Buenos Aires" name="localidad" <?php if($id!=0) { echo  'value="'.$infoitem[6].'"';}?>>
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Código Postal</label>
              <input type="text" placeholder="Ej. C1425ABE" name="cpostal" <?php if($id!=0) { echo  'value="'.$infoitem[9].'"';}?>>
            </div>
            <div class="col-md-6 form-group"> 
            <label class="control-label">Provincia</label>         
            <select class="form-control" id="provincia" name="provincia" >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('provincia',$infoitem[7],0);
            }
            else
            {
                $cm->carga_selected('provincia',0,0);   
            }    
            
            ?>
            </div>                 
            <div class="col-md-6 form-group"> 
            <label class="control-label">País</label>         
            <select class="form-control" id="pais" name="pais" >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('pais',$infoitem[8],0);
            }
            else
            {
                $cm->carga_selected('pais',0,0);   
            }    
            
            ?>
            </div>                 
            
            <div class="col-md-12 form-group"> 
            <label class="control-label">Transporte</label>         
            <select class="form-control" id="transporte" name="transporte" >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('transporte',$infoitem[10],0);
            }
            else
            {
                $cm->carga_selected('transporte',0,0);   
            }    
            
            ?>
            </div>  
                                                
            <div class="col-md-12 form-group1 group-mail">
            <div class="form-group">
            <label for="checkbox" class="col-sm-2 control-label">Habilitado</label>
            <div class="col-sm-8">
            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="1" <?php if($id!=0) { if($infoitem[15]==1)echo  'checked=""';}?>> Si</label></div>
            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="0" <?php if($id!=0) { if($infoitem[15]==0)echo  'checked=""';}?>> No</label></div>
            </div>
            </div>
            </div>            
            
            
            <div class="clearfix"> </div>
           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones"> <?php if($id!=0) { echo  $infoitem[14];}?></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>



           

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="contactos.php">Cancelar</a>
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


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
    $idusuario=$_GET['id'];
    $titulobread="Modificación";
    $infousuario=$cm->getUsuario($idusuario);
}
else
{
    $idusuario=0;
    $titulobread="Alta de Usuario";
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
                correo = document.getElementById("email").value;
                if( !(/^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(correo)) ) {
                alert('La dirección de correo no cumple el formato');          
                return false;
            
                }
                
                clave = document.getElementById("clave").value;
                claver = document.getElementById("claver").value;
                if( clave != claver) {
                alert('Las claves no coinciden');
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
			<form class=" navbar-left-right">
              <input type="text"  value="Search..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search...';}">
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
		    	<h1>Usuarios</h1>
				<a href="index.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="usuarios.php">Usuarios</a>
				<i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
				</h2>
		    </div>
		<!--//banner-->

	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_abms.php" method="post" id="userForm" enctype="multipart/form-data" onsubmit="return validacion()">
            <input type="hidden" name="abm" value="usuario">
            <input type="hidden" name="userid" value="<?php echo $idusuario;?>">
         	<div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Nombre</label>
              <input type="text" placeholder="Nombre" required="" name="nombre" <?php if($idusuario!=0) { echo  'value="'.$infousuario[3].'"';}?> >
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Apellido</label>
              <input type="text" placeholder="Apellido" required="" name="apellido" <?php if($idusuario!=0) { echo  'value="'.$infousuario[4].'"';}?>>
            </div>
            <div class="clearfix"> </div>
            </div>
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Email</label>
              <input type="text" placeholder="Email" required="" id="email" name="email" <?php if($idusuario!=0) { echo  'value="'.$infousuario[5].'"';}?>>
            </div>
             <div class="clearfix"> </div>
            
            <div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Nombre de Usuario</label>
              <input type="text" placeholder="Nombre de Usuario" required="" name="username" <?php if($idusuario!=0) { echo  'value="'.$infousuario[1].'"';}?>>
            </div>
<!--
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Número de celular</label>
              <input type="text" placeholder="Número de celular" required="" name="celular">
            </div>
-->
            <div class="clearfix"> </div>
            </div>
             <div class="vali-form vali-form1">
            <div class="col-md-6 form-group1">
              <label class="control-label">Cree una password</label>
              <input type="password" placeholder="Cree una password" required="" id="clave" name="clave" <?php if($idusuario!=0) { echo  'value="'.base64_decode($infousuario[2]).'"';}?>>
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Repetir password</label>
              <input type="password" placeholder="Repetir password"  id="claver" required="" <?php if($idusuario!=0) { echo  'value="'.base64_decode($infousuario[2]).'"';}?>>
            </div>
            <div class="clearfix"> </div>
            </div>           
            <div class="col-md-12 form-group1 group-mail">
								<div class="form-group">
									<label for="checkbox" class="col-sm-2 control-label">Perfiles</label>
									<div class="col-sm-8">
										<div class="checkbox-inline"><label><input type="checkbox" name="perfil[]" value="1"> Administración</label></div>
										<div class="checkbox-inline"><label><input type="checkbox" name="perfil[]" value="2"> Laboratorio</label></div>
										<div class="checkbox-inline"><label><input type="checkbox" name="perfil[]" value="3"> Super User</label></div>
									</div>
								</div>
            </div>
             <div class="clearfix"> </div>
                    <div class="col-md-12 form-group1 group-mail">
								<div class="form-group">
									<label for="checkbox" class="col-sm-2 control-label">Habilitado</label>
									<div class="col-sm-8">
										<div class="checkbox-inline"><label><input type="radio" name="habilitado" value="1" <?php if($idusuario!=0) { if($infousuario[7]==1)echo  'checked=""';}?>> Si</label></div>
										<div class="checkbox-inline"><label><input type="radio" name="habilitado" value="0" <?php if($idusuario!=0) { if($infousuario[7]==0)echo  'checked=""';}?>> No</label></div>
									</div>
								</div>
            </div>
             <div class="clearfix"> </div>
            <div class="col-md-12 form-group">

              <div class="col-md-6 form-group1">
              <img src="<?php if($idusuario!=0) { echo  'images/'.$infousuario[6];}else{ echo 'images/perfil.jpg';} ?>" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  <?php if($idusuario!=0) { echo  'value="'.$infousuario[6].'"';}else{ echo 'value="perfil.jpg"';}?>>
              <div id="message"></div>
                 </div>
                  <div class="col-md-6 form-group1">
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
                 </div>
            </div>
          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
              <button type="submit" class="btn btn-primary">Enviar Formulario</button>
              <button type="reset" class="btn btn-default">Reset</button>
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


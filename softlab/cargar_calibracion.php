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
    $infoitem=$cm->getCalibracion($id);
	$infofamilia=$cm->getFamilia($infoitem[2]);
	$infopatron = $cm->getEquipo($infoitem['idpatron']);
	$equipo = (isset($_GET['idequipo']))?$_GET['idequipo']:0;
    $titulobread=$infoitem['nombrecal'];

}
else
{

	header("Location: calibraciones.php");
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
<link rel="stylesheet" href="css/jquery-ui.min.css">

<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>
<script src="js/jquery-ui.min.js"></script>
  
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
            

            
    $(function(){
      // bind change event to select
      $('select#familia').on('change', function () {
        var id = $(this).val(); // get selected value
        $.get('ajax/equiposcalibracion.php', { id:id }, function(resp) {
        $('div#caja-equipos').html(resp);
        });
		  
		$.get('ajax/valorescalibracion.php', { id:id }, function(resp) {
        $('div#caja-valores').html(resp);
        });  
    
        var combo ="equipospatron";
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#patron').html(resp);
        });
		  
		  
      });
    });

	function Cargar_Valores(valor,idcalibracion,equipo,idpatron,cadena)
	{
		$.get('ajax/cargavalores.php', { id:idcalibracion, idvalor:valor, idpatron:idpatron, equipo:equipo }, function(resp) {
        $('div#caja-carga-valores').html(resp);
        });

		$('button.carga').addClass('btn-warning');
		$('#label-valor').html(cadena);
		$('button#btn_'+valor).removeClass('btn-warning');
		$('button#btn_'+valor).addClass('btn-success');
		
	}

			
</script>
		

<!----->
</head>
<body>
<div id="wrapper">
     <!----->
       <div id="resp"></div>
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
		    	<h1>Calibración de Equipos</h1>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<a href="calibraciones.php">Calibraciones</a>
				<i class="fa fa-angle-right"></i> <span><a href="gestion_calibracion.php?id=<?php echo $id; ?>"><?php echo $titulobread;?></a></span>
				<i class="fa fa-angle-right"></i> <span>Carga de Valores Medidos</span>
		    </div>
		<!--//banner-->




<?php include('inc/modal.inc'); ?>
	<!--grid-->
 	<div class="validation-system">
 		
 		<div class="validation-form">

    
         	<div class="vali-form">
<div class="col-md-2 form-group">
           	<label class="control-label" >Calibración Nro: </label><label class="alert-info"><?php echo $id; ?></label>
           </div>
                       
			<div class="col-md-3 form-group">
           	<label class="control-label" >Fecha de Alta: </label><label class="alert-info"><?php echo date('d-m-Y',strtotime($infoitem[1])); ?></label>
           	</div>          
            <div class="col-md-7 form-group">
           	<label class="control-label" >Nombre: </label><label class="alert-info"><?php echo  $infoitem['nombrecal']; ?></label>
           </div>

           	<div class="col-md-4 form-group">
           	<label class="control-label" >Familia: </label><label class="alert-info"><?php echo $infofamilia['familia']; ?></label>
           	</div>
           	<div class="col-md-8 form-group">
           	<label class="control-label" >Equipo Patrón: </label><label class="alert-info"><?php echo $infopatron['marca'].'-'. $infopatron['modelo'].'-'. $infopatron['nroserie'];?></label>
           	</div>
          	<div class="col-md-12 form-group">
           	
			<?php
			$cadena_valor='';	
			$val = explode('/',$infoitem[4]);
			foreach ($val as $valor)
			{
			if($valor !=''){	
			$row = $cm->getValorNominal($valor);    
			$cadena_valor = $row['valornominal'].' '.$row['unidad'];
				?>
			<button class="btn btn-warning carga" onclick="Cargar_Valores(<?php echo $valor;?>,<?php echo $id;?>,<?php echo $equipo;?>,<?php echo $infoitem['idpatron'];?>,'<?php echo $cadena_valor;?>')" id="btn_<?php echo $valor;?>"><?php echo $row['valornominal'].' '.$row['unidad']?> </button>
			<?php
			}}
			?>
           </div>		
           <div class="col-md-6 col-md-offset-4">
			<h1 style="margin-bottom:20px;"><span class="label label-success" id="label-valor"></span></h1>
		</div>  
            
             
		&nbsp;
        <div id="caja-carga-valores">



        </div>
		&nbsp;
	                
          
                   
                                     
        &nbsp;                                    
          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
             <a class="btn btn-danger btn-ok" href="gestion_calibracion.php?id=<?php echo $id;?>">Cancelar</a>

            </div>
          <div class="clearfix"> </div>

    
 	<!---->
 </div>

</div>
  
     

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


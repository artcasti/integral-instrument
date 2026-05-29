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
<title>Minimal an Admin Panel Category Flat Bootstrap Responsive Website Template | Forms :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script>
function previewIcon()
    {
        nuevaclase = document.getElementById('mySelect').value;
        clase=document.getElementById('iconpreview').classList.item(0);
        document.getElementById('iconpreview').classList.remove(clase);
                clase=document.getElementById('iconpreview').classList.item(0);
        document.getElementById('iconpreview').classList.remove(clase);
                clase=document.getElementById('iconpreview').classList.item(0);
        document.getElementById('iconpreview').classList.remove(clase);
        document.getElementById('iconpreview').classList.add('fa');
        document.getElementById('iconpreview').classList.add(nuevaclase);
        document.getElementById('iconpreview').classList.add('nav_icon');
    }
    
function modificamenu(params)
    {
        cadena=params.split("+");
        document.getElementById("idmenu").value=cadena[0];
        document.getElementById("label").value=cadena[1];
        document.getElementById("orden").value=cadena[3];
        document.getElementById("mySelect").value=cadena[2];
        previewIcon();
    }
</script>
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
				<a href="index.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Secciones</span>
				</h2>
		    </div>
		<!--//banner-->
 	<!--grid-->
 	<div class="justaround">
   <h5>Secciones de Menú</h5>
    <a href="#" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;" data-href="#" data-toggle="modal" data-target="#myFormModal">
            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">  Crear Sección<span/></a>   
           </div>  

     <div class="modal fade" id="myFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Secciones</h2>
				</div>
				<div class="modal-body"> 	
 	
 	<div class="grid-form">
 		<div class="grid-form1">
 		<h3 id="forms-example" class="">Gestión de Secciones</h3>
 		<form action="class/manager_abms.php" method="post" id="contact_form">
  <div class="form-group">
   <input type="hidden" name="abm" value="menupadre" >
   <input type="hidden" name="idmenu" id="idmenu" value="0">
    <label for="exampleInputMenu">Label</label>
    <input type="text" class="form-control" id="label" name ="label" placeholder="Label de la sección">
  </div>
  <div class="form-group">
    <label for="orden">Orden</label>
    <input type="text" class="form-control" id="orden" name ="orden" placeholder="Ingrese la ubicación dentro de la barra de navegación">  
<label >Icono</label>
<select id="mySelect" name="icono" class="form-control" onchange="previewIcon();">
<option value="0">Seleccione una opcion...</option>
  <option value="fa-heart">fa-heart</option>
  <option value="fa-certificate">fa-certificate</option>
  <option value="fa-leaf">fa-leaf</option>
  <option value="fa-tasks">fa-tasks</option>
  <option value="fa-briefcase">fa-briefcase</option>
   <option value="fa-trash">fa-trash</option>
  <option value="fa-sliders">fa-sliders</option>
  <option value="fa-bar-chart">fa-bar-chart</option>
  <option value="fa-bank">fa-bank</option>
  <option value="fa-asterisk">fa-asterisk</option>
  <option value="fa-calendar">fa-calendar</option>
  <option value="fa-calculator">fa-calculator</option>
  <option value="fa-archive">fa-archive</option>
  <option value="fa-cog">fa-cog</option>
  <option value="fa-cogs">fa-cogs</option>
  <option value="fa-dashboard">fa-dashboard</option>
  <option value="fa-plus-square">fa-plus-square</option>
  <option value="fa-qrcode">fa-qrcode</option>
  <option value="fa-usd">fa-usd</option>
  <option value="fa-list-ul">fa-list-ul</option>
  <option value="fa-indent">fa-indent</option>
  <option value="fa-table">fa-table</option>
  <option value="fa-balance-scale">fa-balance-scale</option>
</select>


<label for="iconpreview">Vista Previa</label>
 <i class="fa fa-envelope nav_icon" id="iconpreview"></i>
  </div>
</form>
</div>
                   
        </div>
                    </div>
<!--Fin Formulario visible-->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger" id="submitForm">Agregar</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
    </div><!-- /.formmodal -->
                                      
                    <div class="marcotrabajo" data-example-id="contextual-table">
						<table class="table">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Label</th>
							  <th>Icon</th>
							  <th>Orden</th>
							  <th>*</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                            $menu = new MenuPadre('','','');
                              $resultado = $menu->getListaMenuPadre();
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><i class="fa <?php echo $row[2];?> nav_icon"></i></td>
							  <td><?php echo $row[3];?></td>
							  <td><a href="#" onclick="modificamenu('<?php echo $row[0].'+'.$row[1].'+'.$row[2].'+'.$row[3];?>')" data-toggle="modal" data-target="#myFormModal"><i class="fa fa-edit nav_icon"></i></a><a href="#" data-href="class/manager_abms.php?accion=eliminamenupadre&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash-o"></i></a></td>
							</tr>
							
							<?php } ?>
							<tr>
						  </tbody>
						</table>
					   </div>
 
     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Confirmacion</h2>
				</div>
				<div class="modal-body">
					<p>Esta seguro de eliminar el menu??</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger btn-ok">Eliminar</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		<script>
            $('#myModal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
            
                        /* must apply only after HTML has loaded */
            $(document).ready(function () {
                $("#contact_form").on("submit", function(e) {
                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        data: postData,
                        success: function(data, textStatus, jqXHR) {
            //                $('#contact_dialog .modal-header .modal-title').html("Result");
            //                $('#contact_dialog .modal-body').html(data);
                            $("#myFormModal").modal('toggle');
                        },
                        error: function(jqXHR, status, error) {
                            console.log(status + ": " + error);
                        }
                    });
                    e.preventDefault();
                });

                $("#submitForm").on('click', function() {
                    $("#contact_form").submit();
                    location.reload();
                });
            });


            
         </script>
		</div>
		</div>
		<div class="clearfix"> </div>
       </div>
     <!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
<!---->

</body>
</html>


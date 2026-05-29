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
        nuevaclase = document.getElementById('mySelecth').value;
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
        document.getElementById("idmenuh").value=cadena[0];
        document.getElementById("labelh").value=cadena[1];
        document.getElementById("href").value=cadena[2];
        document.getElementById("mySelecth").value=cadena[3];
        document.getElementById("menupadre").value=cadena[4];
        document.getElementById("orden").value=cadena[5];
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
		    	<h2>
				<a href="index.html">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Menú</span>
				</h2>
		    </div>
		<!--//banner-->
<div class="justaround">
   <h5>Opciones de Menú</h5>
    <a href="#" class="btn btn-primary btn-xl" style="margin-top: 0px; margin-right: 0px;" data-href="#" data-toggle="modal" data-target="#myFormModal">
            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">  Crear Menú<span/></a>   
           </div>               
                   
                    <div class="marcotrabajo" data-example-id="contextual-table">
						<table class="table">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Label</th>
							  <th>Href</th>
							  <th>Icon</th>
							  <th>MenuPadre</th>
							  <th>Orden</th>
							  <th>*</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                           
                              $resultado = $cm->getListaMenu();
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><?php echo $row[2];?></td>
							  <td><i class="fa <?php echo $row[3];?> nav_icon"></i></td>
							  <td><?php echo $row[4];?></td>
							  <td><?php echo $row[5];?></td>
							  <td><a href="#" onclick="modificamenu('<?php echo $row[0].'+'.$row[1].'+'.$row[2].'+'.$row[3].'+'.$row[4].'+'.$row[5];?>')" data-toggle="modal" data-target="#myFormModal"><i class="fa fa-edit nav_icon"></i></a>
							  <a href="#" data-href="class/manager_abms.php?accion=eliminamenu&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o"></i></a></td>
							</tr>
							
							<?php } ?>
							<tr>
						  </tbody>
						</table>
					   </div>				
		
		


    
     <div class="modal fade" id="myFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h2 class="modal-title">Alta de Menu</h2>
				</div>
				<div class="modal-body">
<!--Formulario visible-->
 	<div class="grid-form">
 		<div class="grid-form1">
 		<h3 id="forms-example" class="">Nuevo Menú</h3>
 		<form action="class/manager_abms.php" id="contact_form" method="post">
  <div class="form-group">
   <input type="hidden" name="abm" value="menu" >
   <input type="hidden" name="idmenuh" id="idmenuh" value="0">
    <label for="exampleInputMenu">Label</label>
    <input type="text" class="form-control" id="labelh" name ="labelh" placeholder="Label del menú">
    <label for="exampleInputMenu">Href</label>
    <input type="text" class="form-control" id="href" name ="href" placeholder="Href del menú">    
  </div>
  <div class="form-group">
<label >Menu Padre</label>
<select id="menupadre" name="menupadre" class="form-control" >
<option value="0">Seleccione una opcion...</option>
<?php 
     
     $cm->carga_selected('menupadre',0,0);
?>

    <label for="orden">Orden</label>
    <input type="text" class="form-control" id="orden" name ="orden" placeholder="Ingrese la ubicacion dentro del menu">  
<label >Icono</label>
<select id="mySelecth" name="iconoh" class="form-control" onchange="previewIcon();">
<option value="0">Seleccione una opcion...</option>
 
      <optgroup label="Web Application Icons">
        <option value="fa-adjust">icon-adjust</option>
        <option value="fa-asterisk">icon-asterisk</option>
        <option value="fa-ban-circle">icon-ban-circle</option>
        <option value="fa-bar-chart">icon-bar-chart</option>
        <option value="fa-barcode">icon-barcode</option>
        <option value="fa-beaker">icon-beaker</option>
        <option value="fa-beer">icon-beer</option>
        <option value="fa-bell">icon-bell</option>
        <option value="fa-bell-alt">icon-bell-alt</option>
        <option value="fa-bolt">icon-bolt</option>
        <option value="fa-book">icon-book</option>
        <option value="fa-bookmark">icon-bookmark</option>
        <option value="fa-bookmark-empty">icon-bookmark-empty</option>
        <option value="fa-briefcase">icon-briefcase</option>
        <option value="fa-bullhorn">icon-bullhorn</option>
        <option value="fa-calendar">icon-calendar</option>
        <option value="fa-camera">icon-camera</option>
        <option value="fa-camera-retro">icon-camera-retro</option>
        <option value="fa-certificate">icon-certificate</option>
        <option value="fa-check">icon-check</option>
        <option value="fa-check-empty">icon-check-empty</option>
        <option value="fa-circle">icon-circle</option>
        <option value="fa-circle-blank">icon-circle-blank</option>
        <option value="fa-cloud">icon-cloud</option>
        <option value="fa-cloud-download">icon-cloud-download</option>
        <option value="fa-cloud-upload">icon-cloud-upload</option>
        <option value="fa-coffee">icon-coffee</option>
        <option value="fa-cog">icon-cog</option>
        <option value="fa-cogs">icon-cogs</option>
        <option value="fa-comment">icon-comment</option>
        <option value="fa-comment-alt">icon-comment-alt</option>
        <option value="fa-comments">icon-comments</option>
        <option value="fa-comments-alt">icon-comments-alt</option>
        <option value="fa-credit-card">icon-credit-card</option>
        <option value="fa-dashboard">icon-dashboard</option>
        <option value="fa-desktop">icon-desktop</option>
        <option value="fa-download">icon-download</option>
        <option value="fa-download-alt">icon-download-alt</option>
        <option value="fa-edit">icon-edit</option>
        <option value="fa-envelope">icon-envelope</option>
        <option value="fa-envelope-alt">icon-envelope-alt</option>
        <option value="fa-exchange">icon-exchange</option>
        <option value="fa-exclamation-sign">icon-exclamation-sign</option>
        <option value="fa-external-link">icon-external-link</option>
        <option value="fa-eye-close">icon-eye-close</option>
        <option value="fa-eye-open">icon-eye-open</option>
        <option value="fa-facetime-video">icon-facetime-video</option>
        <option value="fa-fighter-jet">icon-fighter-jet</option>
        <option value="fa-film">icon-film</option>
        <option value="fa-filter">icon-filter</option>
        <option value="fa-fire">icon-fire</option>
        <option value="fa-flag">icon-flag</option>
        <option value="fa-folder-close">icon-folder-close</option>
        <option value="fa-folder-open">icon-folder-open</option>
        <option value="fa-folder-close-alt">icon-folder-close-alt</option>
        <option value="fa-folder-open-alt">icon-folder-open-alt</option>
        <option value="fa-food">icon-food</option>
        <option value="fa-gift">icon-gift</option>
        <option value="fa-glass">icon-glass</option>
        <option value="fa-globe">icon-globe</option>
        <option value="fa-group">icon-group</option>
        <option value="fa-hdd">icon-hdd</option>
        <option value="fa-headphones">icon-headphones</option>
        <option value="fa-heart">icon-heart</option>
        <option value="fa-heart-empty">icon-heart-empty</option>
        <option value="fa-home">icon-home</option>
        <option value="fa-inbox">icon-inbox</option>
        <option value="fa-info-sign">icon-info-sign</option>
        <option value="fa-key">icon-key</option>
        <option value="fa-leaf">icon-leaf</option>
        <option value="fa-laptop">icon-laptop</option>
        <option value="fa-legal">icon-legal</option>
        <option value="fa-lemon">icon-lemon</option>
        <option value="fa-lightbulb">icon-lightbulb</option>
        <option value="fa-lock">icon-lock</option>
        <option value="fa-unlock">icon-unlock</option>
        <option value="fa-magic">icon-magic</option>
        <option value="fa-magnet">icon-magnet</option>
        <option value="fa-map-marker">icon-map-marker</option>
        <option value="fa-minus">icon-minus</option>
        <option value="fa-minus-sign">icon-minus-sign</option>
        <option value="fa-mobile-phone">icon-mobile-phone</option>
        <option value="fa-money">icon-money</option>
        <option value="fa-move">icon-move</option>
        <option value="fa-music">icon-music</option>
        <option value="fa-off">icon-off</option>
        <option value="fa-ok">icon-ok</option>
        <option value="fa-ok-circle">icon-ok-circle</option>
        <option value="fa-ok-sign">icon-ok-sign</option>
        <option value="fa-pencil">icon-pencil</option>
        <option value="fa-picture">icon-picture</option>
        <option value="fa-plane">icon-plane</option>
        <option value="fa-plus">icon-plus</option>
        <option value="fa-plus-sign">icon-plus-sign</option>
        <option value="fa-print">icon-print</option>
        <option value="fa-pushpin">icon-pushpin</option>
        <option value="fa-qrcode">icon-qrcode</option>
        <option value="fa-question-sign">icon-question-sign</option>
        <option value="fa-quote-left">icon-quote-left</option>
        <option value="fa-quote-right">icon-quote-right</option>
        <option value="fa-random">icon-random</option>
        <option value="fa-refresh">icon-refresh</option>
        <option value="fa-remove">icon-remove</option>
        <option value="fa-remove-circle">icon-remove-circle</option>
        <option value="fa-remove-sign">icon-remove-sign</option>
        <option value="fa-reorder">icon-reorder</option>
        <option value="fa-reply">icon-reply</option>
        <option value="fa-resize-horizontal">icon-resize-horizontal</option>
        <option value="fa-resize-vertical">icon-resize-vertical</option>
        <option value="fa-retweet">icon-retweet</option>
        <option value="fa-road">icon-road</option>
        <option value="fa-rss">icon-rss</option>
        <option value="fa-screenshot">icon-screenshot</option>
        <option value="fa-search">icon-search</option>
        <option value="fa-share">icon-share</option>
        <option value="fa-share-alt">icon-share-alt</option>
        <option value="fa-shopping-cart">icon-shopping-cart</option>
        <option value="fa-signal">icon-signal</option>
        <option value="fa-signin">icon-signin</option>
        <option value="fa-signout">icon-signout</option>
        <option value="fa-sitemap">icon-sitemap</option>
        <option value="fa-sort">icon-sort</option>
        <option value="fa-sort-down">icon-sort-down</option>
        <option value="fa-sort-up">icon-sort-up</option>
        <option value="fa-spinner">icon-spinner</option>
        <option value="fa-star">icon-star</option>
        <option value="fa-star-empty">icon-star-empty</option>
        <option value="fa-star-half">icon-star-half</option>
        <option value="fa-tablet">icon-tablet</option>
        <option value="fa-tag">icon-tag</option>
        <option value="fa-tags">icon-tags</option>
        <option value="fa-tasks">icon-tasks</option>
        <option value="fa-thumbs-down">icon-thumbs-down</option>
        <option value="fa-thumbs-up">icon-thumbs-up</option>
        <option value="fa-time">icon-time</option>
        <option value="fa-tint">icon-tint</option>
        <option value="fa-trash">icon-trash</option>
        <option value="fa-trophy">icon-trophy</option>
        <option value="fa-truck">icon-truck</option>
        <option value="fa-umbrella">icon-umbrella</option>
        <option value="fa-upload">icon-upload</option>
        <option value="fa-upload-alt">icon-upload-alt</option>
        <option value="fa-user">icon-user</option>
        <option value="fa-user-md">icon-user-md</option>
        <option value="fa-volume-off">icon-volume-off</option>
        <option value="fa-volume-down">icon-volume-down</option>
        <option value="fa-volume-up">icon-volume-up</option>
        <option value="fa-warning-sign">icon-warning-sign</option>
        <option value="fa-wrench">icon-wrench</option>
        <option value="fa-zoom-in">icon-zoom-in</option>
        <option value="fa-zoom-out">icon-zoom-out</option>
    <optgroup label="Text Editor Icons">
        <option value="fa-file">icon-file</option>
        <option value="fa-file-alt">icon-file-alt</option>
        <option value="fa-cut">icon-cut</option>
        <option value="fa-copy">icon-copy</option>
        <option value="fa-paste">icon-paste</option>
        <option value="fa-save">icon-save</option>
        <option value="fa-undo">icon-undo</option>
        <option value="fa-repeat">icon-repeat</option>
        <option value="fa-text-height">icon-text-height</option>
        <option value="fa-text-width">icon-text-width</option>
        <option value="fa-align-left">icon-align-left</option>
        <option value="fa-align-center">icon-align-center</option>
        <option value="fa-align-right">icon-align-right</option>
        <option value="fa-align-justify">icon-align-justify</option>
        <option value="fa-indent-left">icon-indent-left</option>
        <option value="fa-indent-right">icon-indent-right</option>
        <option value="fa-font">icon-font</option>
        <option value="fa-bold">icon-bold</option>
        <option value="fa-italic">icon-italic</option>
        <option value="fa-strikethrough">icon-strikethrough</option>
        <option value="fa-underline">icon-underline</option>
        <option value="fa-link">icon-link</option>
        <option value="fa-paper-clip">icon-paper-clip</option>
        <option value="fa-columns">icon-columns</option>
        <option value="fa-table">icon-table</option>
        <option value="fa-th-large">icon-th-large</option>
        <option value="fa-th">icon-th</option>
        <option value="fa-th-list">icon-th-list</option>
        <option value="fa-list">icon-list</option>
        <option value="fa-list-ol">icon-list-ol</option>
        <option value="fa-list-ul">icon-list-ul</option>
        <option value="fa-list-alt">icon-list-alt</option>
    <optgroup label="Directional Icons">
        <option value="fa-angle-left">icon-angle-left</option>
        <option value="fa-angle-right">icon-angle-right</option>
        <option value="fa-angle-up">icon-angle-up</option>
        <option value="fa-angle-down">icon-angle-down</option>
        <option value="fa-arrow-down">icon-arrow-down</option>
        <option value="fa-arrow-left">icon-arrow-left</option>
        <option value="fa-arrow-right">icon-arrow-right</option>
        <option value="fa-arrow-up">icon-arrow-up</option>
        <option value="fa-caret-down">icon-caret-down</option>
        <option value="fa-caret-left">icon-caret-left</option>
        <option value="fa-caret-right">icon-caret-right</option>
        <option value="fa-caret-up">icon-caret-up</option>
        <option value="fa-chevron-down">icon-chevron-down</option>
        <option value="fa-chevron-left">icon-chevron-left</option>
        <option value="fa-chevron-right">icon-chevron-right</option>
        <option value="fa-chevron-up">icon-chevron-up</option>
        <option value="fa-circle-arrow-down">icon-circle-arrow-down</option>
        <option value="fa-circle-arrow-left">icon-circle-arrow-left</option>
        <option value="fa-circle-arrow-right">icon-circle-arrow-right</option>
        <option value="fa-circle-arrow-up">icon-circle-arrow-up</option>
        <option value="fa-double-angle-left">icon-double-angle-left</option>
        <option value="fa-double-angle-right">icon-double-angle-right</option>
        <option value="fa-double-angle-up">icon-double-angle-up</option>
        <option value="fa-double-angle-down">icon-double-angle-down</option>
        <option value="fa-hand-down">icon-hand-down</option>
        <option value="fa-hand-left">icon-hand-left</option>
        <option value="fa-hand-right">icon-hand-right</option>
        <option value="fa-hand-up">icon-hand-up</option>
        <option value="fa-circle">icon-circle</option>
        <option value="fa-circle-blank">icon-circle-blank</option>
    <optgroup label="Video Player Icons">
        <option value="fa-play-circle">icon-play-circle</option>
        <option value="fa-play">icon-play</option>
        <option value="fa-pause">icon-pause</option>
        <option value="fa-stop">icon-stop</option>
        <option value="fa-step-backward">icon-step-backward</option>
        <option value="fa-fast-backward">icon-fast-backward</option>
        <option value="fa-backward">icon-backward</option>
        <option value="fa-forward">icon-forward</option>
        <option value="fa-fast-forward">icon-fast-forward</option>
        <option value="fa-step-forward">icon-step-forward</option>
        <option value="fa-eject">icon-eject</option>
        <option value="fa-fullscreen">icon-fullscreen</option>
        <option value="fa-resize-full">icon-resize-full</option>
        <option value="fa-resize-small">icon-resize-small</option>
    <optgroup label="Social Icons">
        <option value="fa-phone">icon-phone</option>
        <option value="fa-phone-sign">icon-phone-sign</option>
        <option value="fa-facebook">icon-facebook</option>
        <option value="fa-facebook-sign">icon-facebook-sign</option>
        <option value="fa-twitter">icon-twitter</option>
        <option value="fa-twitter-sign">icon-twitter-sign</option>
        <option value="fa-github">icon-github</option>
        <option value="fa-github-alt">icon-github-alt</option>
        <option value="fa-github-sign">icon-github-sign</option>
        <option value="fa-linkedin">icon-linkedin</option>
        <option value="fa-linkedin-sign">icon-linkedin-sign</option>
        <option value="fa-pinterest">icon-pinterest</option>
        <option value="fa-pinterest-sign">icon-pinterest-sign</option>
        <option value="fa-google-plus">icon-google-plus</option>
        <option value="fa-google-plus-sign">icon-google-plus-sign</option>
        <option value="fa-sign-blank">icon-sign-blank</option>
    <optgroup label="Medical Icons">
        <option value="fa-ambulance">icon-ambulance</option>
        <option value="fa-beaker">icon-beaker</option>
        <option value="fa-h-sign">icon-h-sign</option>
        <option value="fa-hospital">icon-hospital</option>
        <option value="fa-medkit">icon-medkit</option>
        <option value="fa-plus-sign-alt">icon-plus-sign-alt</option>
        <option value="fa-stethoscope">icon-stethoscope</option>
        <option value="fa-user-md">icon-user-md</option>
  
  
</select>


<label for="iconpreview">Vista Previa</label>
 <i class="fa fa-envelope nav_icon" id="iconpreview"></i>
  </div>
<!--  <button type="submit" class="btn btn-default">Submit</button>-->
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



     <div class="modal fade" id="myModalConfirm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
     </div>
		<script>
            $('#myModalConfirm').on('show.bs.modal', function(e) {
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
 //       $('#contact_form .modal-body').html(data);
       location.reload();
    });
});

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


<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
    header("Location: signin.php");
}

require_once("class/clases.php");
$cm = new ConfigurationManager();

// Inicializamos las variables
$id = isset($_GET['id']) ? $_GET['id'] : null;
$descripcion = "";
$precio = "";
$idcapitulo = "";
   $titulobread=" Alta de Item";


// Si existe un ID, entonces es edición
if ($id) {
    $resultado = $cm->getItemCotizacion($id); // Implementa la función para obtener un ítem por ID
    if ($row = $resultado) {
        $descripcion = $row['txtitemcotizacionlista'];
        $precio = $row['preciolista'];
        $idcapitulo = $row['idcapitulo'];
    }
}

if ($_POST) {
    $descripcion = $_POST['txtitemcotizacionlista'];
    $precio = $_POST['preciolista'];
    $idcapitulo = $_POST['idcapitulo'];
   $titulobread="Modificación";
 
    if ($id) {
        $cm->actualizarItemCotizacion($id, $descripcion, $precio, $idcapitulo); // Implementa la función para actualizar
    } else {
        $cm->agregarItemCotizacion($descripcion, $precio, $idcapitulo); // Implementa la función para agregar
    }
    header("Location: items_cotizacion.php");
    exit();
}
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

            <div class="navbar-default sidebar" role="navigation"> <!-- Comienza Menu Lateral  -->
                <div class="sidebar-nav navbar-collapse"> <!--Div navbar-collapse     -->
                 <!--A reemplazar por menu dinamico   -->
                 <?php $cm->crear_menu_padre_bst();
                ?>
            </div> <!-- FIN Div navbar-collapse   -->
            </div> <!-- FIN Menu Lateral  -->
        </nav>        
        <div id="page-wrapper" class="gray-bg dashbard-1">    

       <div class="content-main">
 
    <!--banner-->   
             <div class="banner">
                <h1>Lista de Precios</h1>
                <a href="index.html">Home</a>
                <i class="fa fa-angle-right"></i>
                <a href="items_cotizacion.php">Items Cotización</a>
                <i class="fa fa-angle-right"></i><span><?php echo $titulobread;?></span>
                </h2>
            </div>
        <!--//banner-->




        <div class="justaround">
    <h2><?php echo $id ? "Editar Ítem" : "Agregar Ítem"; ?></h2>
    
    <div class="col-md-12 ">
    <form method="post">
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="txtitemcotizacionlista" class="form-control" value="<?php echo $descripcion; ?>" required>
        </div>
        <div class="form-group">
            <label>Precio</label>
            <input type="number" step="0.01" name="preciolista" class="form-control" value="<?php echo $precio; ?>" required>
        </div>
        <div class="form-group">
            <label>ID Capítulo</label>
            <input type="number" name="idcapitulo" class="form-control" value="<?php echo $idcapitulo; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="items_cotizacion.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</div>
</div>
</body>
</html>

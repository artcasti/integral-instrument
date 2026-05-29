<?php header('Content-Type: text/html; charset=utf-8'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Integral Instrument</title>
    <link rel="shortcut icon" href="img/favicon.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/fonts.css">

<!--FractionSlider-->
		<link rel="stylesheet" href="css/fractionslider.css">
			<link rel="stylesheet" href="css/slider.css">

		<script src="js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.fractionslider.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/main.js" type="text/javascript" charset="utf-8"></script>


    
</head>
<body>

<div class="row">
<?php include("inc/header.inc");?>

<?php include("inc/menu.inc");?>

</div>

  <?php 
    include("admin/conexion.php");
    include("admin/functions.php");
    $id = $_GET['idservicio'];
    $path = "admin/galery/";

    $consulta="SELECT * FROM `servicios` S LEFT JOIN `categorias` c ON S.idcategoria = c.idcategoria LEFT JOIN `subcategorias` SC ON S.idsubcategoria = SC.idsubcategoria WHERE `idservicio`='$id'";

    $result = $conexion->query($consulta);

    if($result){
      $row=$result->fetch_array();
      
      $nombre =$row[1];
      $categoria =$row[2];
      $subcategoria =$row[3];
      $imagenppal =$row[5];
      $galeria =$row[6];
      $descripcion =$row[4];
      $imagenadic =$row[8];
      $materialadicional =$row[9];
      $video =$row[10];
      $descripcionadic =$row[7];
      $categtext = $row[15];
      $subcategtext = $row[20];    
    }

 ?>

<div class="row">

   <div class="contenedor_detalle">
       <div class="info__ppal">
          <label class="ruta"><?php echo strtoupper($categtext);?>/<?php echo strtoupper($subcategtext);?></label>
           <h2 class="info__titulo"><?php echo strtoupper($nombre);?></h2>
           <p><?php echo ($descripcion);?></p>
           <div class="consultar">
           <div class="linearojaconsultar"></div>
           <a href="#nombre" onclick="foco('nombre');" class="info__link">.Consultar</a>
           </div>
           
           <div class="materialadicional">
           <?php if($materialadicional!=''){?>
           <a href="<?php echo $path.$materialadicional;?>" target="_blank"><img src="img/bot-descargas.png" alt="" class="info__descargasadicionales"></a>
           <?php };?>
           </div>
       </div>
               <div class="info__galeria">

            
        <div class="slider-wrapper">
			<div class="responisve-container">
				<div class="slider">
					<div class="fs_loader"></div>
					<div class="slide fondo" style="background-image:url('<?php echo $path.$imagenppal;?>');"></div>
                    <?php 
                        $consulta="SELECT * FROM `galerias_items` WHERE `idgaleria`= '$id'";

                        $result = $conexion->query($consulta);
                            
                        if($result){
                            $i=1;
                            while($row=$result->fetch_array()){?>
                               <div class="slide fondo" style="background-image:url('<?php echo $path.$row[1];?>');">					</div>
                               <?php }};?>   	

                </div>
            </div>
        </div>                          
               
               </div>
    </div>
    
    <div class="contenedor_detalle">
               <div class="info__ppal">
               
       <?php if($descripcionadic!=''){?>
        <div class="texto__adicional">
            <p class="info__texto_adicional"><?php echo ($descripcionadic);?></p>
        </div>

    <?php };?> 
               
               </div>
               <div class="info__galeria">
               
            <?php if($video!=''){
            $embed=substr($video,32);
            ?>
        <div class="video">            
           <iframe width="490" height="390" src="https://www.youtube.com/embed/<?php echo $embed;?>" frameborder="1" allowfullscreen></iframe>
        </div>    
            <?php };?> 
               </div>
        
    </div>
    
    <div class="contenedor_detalle">
                    <?php if($imagenadic!=''){?>
                       <div class="imagenunica" style="background-image:url('<?php echo $path.$imagenadic;?>'); background-size:contain; background-repeat:no-repeat; background-position:top;">
               </div>
                         <?php };?>
    </div>
</div>

<div class="row titulo conborde rojo">
   <div class="contenedor">
       <p class="titulo__contacto">::Contacto</p>
   </div>
</div>

<div class="row">
    <?php include("inc/footer.inc");?>
</div>
<script src="js/menu.js"></script>
</body>
</html>
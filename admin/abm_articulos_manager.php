<?php 
session_start();
header('Content-Type: text/html; charset=utf-8'); 

if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include("conexion.php");
include("functions.php");

if (isset($_GET['paso'])) {
	$paso= $_GET['paso'];
}else{
//	print_r($_POST);
//    print_r($_FILES);
	$paso= trim($_POST['paso']);
}


switch ($paso) {
    case '1'://Administracion de Articulo:Paso 1
		$titulo=$_GET['titulo'];
		$categoria=$_GET['categoria'];
		$subcategoria=$_GET['subcategoria'];
		$descripcion=$_GET['descripcion'];
        $id=$_GET['id'];

		if ($id==0) {
        
            $idservicio=get_ultimo_servicio()+1;    
        		$galeria=0;
        		$video='';
                $descripcionadic='';
                $habilitado = 0;
                $imagenppal='default.jpg';
                $imagenadic='';
                $habilitado = 0;
                $destacado = 0;
            
            $consulta="INSERT INTO `servicios` (`nombre`,`idcategoria`,`idsubcategoria`,`descripcion`,`imagen`,`idgaleria`,`descripcionadicional`,`imagenadicional`,`video`,`habilitado`,`idusuario`) VALUES ('$titulo','$categoria','$subcategoria','$descripcion','$imagenppal','$galeria','$descripcionadic','$imagenadic','$video','$habilitado','$_SESSION[idusuario]'); ";
            
            $log="Se ha creado el servicio: ".$titulo;
            }else{
                    $idservicio=$id;
        
            $consulta="UPDATE `servicios` SET `nombre`='$titulo',`idcategoria`='$categoria',`idsubcategoria`='$subcategoria',`descripcion`='$descripcion',`idusuario`='$_SESSION[idusuario]' WHERE `idservicio` = '$id'; ";
            
            $log="Se ha modificado el servicio: ".$titulo;
            }

            $result = $conexion->query($consulta);
        
        if($result){
			registra_log("Servicios",$log);
			echo $idservicio;
			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;
	case '2'://Elimina Imagen de Galeria
		$id=$_GET['id'];



		$consulta="DELETE FROM `galerias_items` WHERE `iditem` = '$id'; ";

		$result = $conexion->query($consulta);

		if($result){

			registra_log("Servicios","Se ha eliminado la imagen:".$id);
            //echo $id;
			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	
        
    	case 'P'://Modifica valor del campo habilitado del servicio
		$id=$_GET['servicio'];
        $estado=$_GET['estado'];
        
        if($estado=="1"){
		      $consulta="UPDATE `servicios` SET `habilitado`='$estado' WHERE `idservicio` = '$id'; ";
            }else{
              $consulta="UPDATE `servicios` SET `habilitado`='$estado',`destacado`='$estado' WHERE `idservicio` = '$id'; ";
        }
        
		$result = $conexion->query($consulta);

		if($result){

			registra_log("Servicios","Se ha modificado el estado del servicio: ".$id);
		//	header("Location: abm_servicios.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	  
    case '3'://Administracion de Articulo:Paso 1
        $id=$_GET['id'];

        		$video=$_GET['video'];
                $descripcionadic=$_GET['descripcionadicional'];
        
            $consulta="UPDATE `servicios` SET `video`='$video',`descripcionadicional`='$descripcionadic',`idusuario`='$_SESSION[idusuario]' WHERE `idservicio` = '$id'; ";
            
            $log="Se ha modificado el servicio: ".$id;

            $result = $conexion->query($consulta);
        
        if($result){
			registra_log("Servicios",$log);
			echo $id;
			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;
        
        case 'D'://Elimina el servicio
		$id=$_GET['servicio'];



		$consulta="DELETE `servicios` WHERE `idservicio` = '$id'; ";

		$result = $conexion->query($consulta);

		if($result){

			registra_log("Servicios","Se ha eliminado el servicio: ".$id);
			header("Location: abm_servicios.php");
			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;
        
        case 'I'://Modifica valor del campo destacado del servicio
		$id=$_GET['servicio'];
        $estado=$_GET['estado'];
        
        
        if($estado=="1"){
		$consulta="UPDATE `servicios` SET `destacado`='$estado',`habilitado`='$estado' WHERE `idservicio` = '$id'; ";
        }else{
		$consulta="UPDATE `servicios` SET `destacado`='$estado' WHERE `idservicio` = '$id'; ";            
        }
		$result = $conexion->query($consulta);

		if($result){

			registra_log("Servicios","Se ha modificado el destacado del servicio: ".$id);
		//	header("Location: abm_servicios.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	
                
        case 'T'://Modifica los textos de quienes somos
		$politica=$_POST['politica'];
        $empresa=$_POST['nuestraempresa'];
        $mision=$_POST['mision'];
        $historia=$_POST['historia'];
        
            
		$consulta1="UPDATE `texto_sitio` SET `texto`='$empresa'WHERE `idtexto` = 1; ";
		$consulta2="UPDATE `texto_sitio` SET `texto`='$politica'WHERE `idtexto` = 2; ";
        $consulta3="UPDATE `texto_sitio` SET `texto`='$mision'WHERE `idtexto` = 3; ";
        $consulta4="UPDATE `texto_sitio` SET `texto`='$historia'WHERE `idtexto` = 4; ";

        $result = $conexion->query($consulta1);
        $result2 = $conexion->query($consulta2);
        $result3 = $conexion->query($consulta3);
        $result4 = $conexion->query($consulta4);

		if($result){

			registra_log("Quienes Somos","Se han modificado los textos");
			header("Location: quienes_somos.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	

        case 'U'://Elimina Imagenes del Banner
		$imagen=$_GET['imagen'];
        unlink($imagen);
        break;	
                
        case 'im'://Elimina imagen del servicio
		$id=$_GET['id'];
        $tipo=$_GET['tipo'];
        
        
        if($tipo=="ppal"){
		$consulta="UPDATE `servicios` SET `imagen`='default.jpg' WHERE `idservicio` = '$id'; ";
        }else{
		$consulta="UPDATE `servicios` SET `imagenadicional`='' WHERE `idservicio` = '$id'; ";            
        }
		$result = $conexion->query($consulta);

		if($result){

			registra_log("Servicios","Se ha modificado la imagen ".$tipo." del servicio: ".$id);
		//	header("Location: abm_servicios.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	

        case 'sl'://Elimina Imagen FractionSlider
        $imagen=$_GET['imagen'];
        
        $consulta="DELETE FROM `slides` WHERE `idslide`='$imagen'; ";

        $result = $conexion->query($consulta);

        $archivo=$_GET['archivo'];
        unlink($archivo);

		if($result){

			registra_log("FractionSlider","Se ha eliminado un slide");

			} else{
		echo $consulta;
			echo "<br> no se pudo ejecutar la consulta: ".mysql_error();
		}

		break;	

}



?>

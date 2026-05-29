<?php 
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include("conexion.php");
include("functions.php");

if (isset($_GET['tarea'])) {
	$tarea= $_GET['tarea'];
}else{
	print_r($_POST);
    print_r($_FILES);
	$tarea= trim($_POST['tarea']);
}


switch ($tarea) {
	case 'A'://Creacion de servicios x post
		$titulo=$_POST['nombre'];
		$categoria=$_POST['categoria'];
		$subcategoria=$_POST['subcategoria'];
		$galeria=0;
		$descripcion=$_POST['descripcion'];
		
		$video=$_POST['video'];
		$descripcionadic=$_POST['descripcionadicional'];
		$habilitado = 0;
        $imagenppal="sin-imagen.png";
        $imagen2="sin-imagen.png";
        $imagen3="sin-imagen.png";
        $imagen4="sin-imagen.png";
        $imagen5="sin-imagen.png";
        $imagenadic="sin-imagen.png";
        
        $idservicio=get_ultimo_servicio()+1;
        
        
        if(strlen($_FILES['imagenppal']['name'])>1)
        {
	       copy($_FILES['imagenppal']['tmp_name'], "galery/".$_FILES['imagenppal']['name']);
		  $imagenppal=$_FILES['imagenppal']['name'];
	    
        }
        echo $imagenppal."<br>";
        
        for ($i=2; $i < 6; $i++) { 
        $nombre="imagen".$i;

            if(strlen($_FILES[$nombre]['name'])>1)
            {
                $img=$_FILES[$nombre]['name'];
            echo $img;
                
               copy($_FILES[$nombre]['tmp_name'], "galery/".$_FILES[$nombre]['name']);
                /*Guardo las imagenes en galerias__items*/
                $cons="INSERT INTO `galerias_items`(`url`, `idgaleria`) VALUES ('$img',$idservicio)";
            echo $cons;
                $resultado = mysql_query($cons,$conexion);
                if($resultado){

                    registra_log("Imagenes","Se ha agregado la imagen: ".$img);
			     }else{
		  echo $cons;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		      }

            }    
        }

        
        
        
		$consulta="INSERT INTO `servicios` (`nombre`,`idcategoria`,`idsubcategoria`,`descripcion`,`imagen`,`idgaleria`,`descripcionadicional`,`imagenadicional`,`video`,`habilitado`,`idusuario`) VALUES ('$titulo','$categoria','$subcategoria','$descripcion','$imagenppal','$galeria','$descripcionadic','$imagenadic','$video','$habilitado','$_SESSION[idusuario]'); ";

		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Servicios","Se ha creado el servicio: ".$nombre);
			header("Location: abm_servicios.php");
			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;
	case 'U'://Creacion de servicios x post
		$titulo=$_POST['nombre'];
		$categoria=$_POST['categoria'];
		$subcategoria=$_POST['subcategoria'];
		$imagenppal=$_POST['imagenppal'];
		$galeria=$_POST['selgaleria'];
		$descripcion=$_POST['descripcion'];
		$imagenadic=$_POST['imagenadic'];
		$video=$_POST['video'];
		$descripcionadic=$_POST['descripcionadicional'];
		$id=$_POST['id'];



		$consulta="UPDATE `servicios` SET `nombre`='$titulo',`idcategoria`='$categoria',`idsubcategoria`='$subcategoria',`descripcion`='$descripcion',`imagen`='$imagenppal',`idgaleria`='$galeria',`descripcionadicional`='$descripcionadic',`imagenadicional`='$imagenadic',`video`='$video',`idusuario`='$_SESSION[idusuario]' WHERE `idservicio` = '$id'; ";

		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Servicios","Se ha modificado el servicio: ".$nombre);
			header("Location: abm_servicios.php");
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
        
		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Servicios","Se ha modificado el estado del servicio: ".$id);
		//	header("Location: abm_servicios.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	  
        
        case 'D'://Elimina el servicio
		$id=$_GET['servicio'];



		$consulta="DELETE FROM `servicios` WHERE `idservicio` = '$id'; ";

		$result = mysql_query($consulta,$conexion);

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
		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Servicios","Se ha modificado el destacado del servicio: ".$id);
		//	header("Location: abm_servicios.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	
}



?>

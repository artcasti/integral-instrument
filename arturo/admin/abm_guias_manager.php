<?php 
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include("conexion.php");
include("functions.php");

$tarea = $_GET['tarea'];

switch ($tarea) {
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
                $imagenppal='';
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

            $result = mysql_query($consulta,$conexion);
        
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

		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Servicios","Se ha eliminado la imagen:".$id);
            //echo $id;
			} else{
		echo $consulta;
			echo "<br> no se pudo crear el servicio: ".mysql_error();
		}

		break;	
        
    	case 'P'://Modifica valor del campo habilitado de la guia
		$id=$_GET['guia'];
        $estado=$_GET['estado'];
        
        
		$consulta="UPDATE `servicios` SET `habilitado`='$estado',`destacado`='$estado' WHERE `idservicio` = '$id'; ";
        
        
		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Ayuda","Se ha modificado el estado de la guia: ".$id);
		//	header("Location: abm_servicios.php");

			} else{
		echo $consulta;
			echo "<br> no se pudo modificar el estado: ".mysql_error();
		}

		break;	  
        
        case 'D'://Elimina la guia
		$id=$_GET['guia'];



		$consulta="DELETE `ayuda` WHERE `idguia` = '$id'; ";

		$result = mysql_query($consulta,$conexion);

		if($result){

			registra_log("Ayuda","Se ha eliminado la guia: ".$id);
			header("Location: abm_guias.php");
			} else{
		echo $consulta;
			echo "<br> no se pudo eliminar la guia: ".mysql_error();
		}

		break;

}



?>

<?php
session_start();
include("conexion.php");
include("functions.php");

if (!isset($_POST['imagenes_home'])){
$img = $_FILES['selectfile'];
$id = $_POST['id'];
$ppal=$_POST['ppal'];

if(strlen($_FILES['selectfile']['name'])>1)
{
	copy($_FILES['selectfile']['tmp_name'], "galery/".$_FILES['selectfile']['name']);
		$imagen=$_FILES['selectfile']['name'];
    
    switch($ppal){
            case '1':
                    $consulta="UPDATE `servicios` SET `imagen`='$imagen',`idusuario`='$_SESSION[idusuario]' WHERE `idservicio` = '$id'; ";
                    $log="Se ha modificado la imagen ppal del servicio: ".$id;

                    $result = $conexion->query($consulta);
                    if($result){
                    registra_log("Servicios",$log);
                    } else{
                    echo $consulta;
                    echo "<br> no se pudo crear el servicio: ".mysql_error();
                    }
            break;
            case '2':
                    $descadic = $_POST['descadicionalhidden'];
                    $video = $_POST['videohidden'];
            
                    $consulta="UPDATE `servicios` SET `imagenadicional`='$imagen',`descripcionadicional`='$descadic',`video`='$video',`idusuario`='$_SESSION[idusuario]' WHERE `idservicio` = '$id'; ";
                    $log="Se ha modificado la imagen adicional del servicio: ".$id;

                    $result = $conexion->query($consulta);
                    if($result){
                    registra_log("Servicios",$log);
                    } else{
                    echo $consulta;
                    echo "<br> no se pudo crear el servicio: ".mysql_error();
                    }            
            break;

            case '3':
                    $consulta="INSERT INTO `galerias_items` (`url`,`idgaleria`) VALUES ('$imagen','$id')";
                    $log="Se ha agregado la imagen ".$imagen." al servicio: ".$id;

                    $result = $conexion->query($consulta);
                    if($result){
                    registra_log("Servicios",$log);
                    } else{
                    echo $consulta;
                    echo "<br> no se pudo crear el servicio: ".mysql_error();
                    }
            break;
            case '4':
                    $descadic = $_POST['descadicionalhidden'];
                    $video = $_POST['videohidden'];
                    $consulta="UPDATE `servicios` SET `materialadicional`='$imagen',`descripcionadicional`='$descadic',`video`='$video',`idusuario`='$_SESSION[idusuario]' WHERE `idservicio` = '$id'; ";
                    $log="Se ha modificado el material adicional del servicio: ".$id;

                    $result = $conexion->query($consulta);
                    if($result){
                    registra_log("Servicios",$log);
                    } else{
                    echo $consulta;
                    echo "<br> no se pudo crear el servicio: ".mysql_error();
                    }            
            break;

    }
    
	}
	else
	{$imagen="sin-imagen.png";}
    
    if($ppal=='4'){
header("Location: modifica_articulo.php?indice=3&id=".$id);        
    }else{if($ppal=='2'){
header("Location: modifica_articulo.php?indice=3&id=".$id);        
    }else{
header("Location: modifica_articulo.php?indice=2&id=".$id);
        }}
}else{
    
    if($_POST['imagenes_home']==1){
        $dest="../sliderbrands/";
    }else{
        $dest="../banner/";
    }
    
   if(strlen($_FILES['selectfile']['name'])>1)
{
	copy($_FILES['selectfile']['tmp_name'], $dest.$_FILES['selectfile']['name']);
		$imagen=$_FILES['selectfile']['name'];} 
    header("Location: imagenes_home.php");
    //echo $dest.$_FILES['selectfile']['name'];
}


//header("Location: wiz_cursos.php?indice=2&id=".$id);
?>
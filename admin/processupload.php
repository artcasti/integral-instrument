<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include("functions.php");
include("conexion.php");

if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
{
	############ Edit settings ##############
	$UploadDirectory	= '../fslider/'; //specify upload directory ends with / (slash)
	##########################################
	
	/*
	Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
	Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
	and set them adequately, also check "post_max_size".
	*/
	
	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}
	
	
	//Is file size is less than allowed size.
	if ($_FILES["FileInput"]["size"] > 512000) {
		die("El archivo es demasiado grande!");
	}
	
	//allowed file type Server side check
	switch(strtolower($_FILES['FileInput']['type']))
		{
			//allowed file types
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html': //html file
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
				break;
			default:
				die('Archivo no soportado!'); //output error
	}
	
	$File_Name          = strtolower($_FILES['FileInput']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $Random_Number.$File_Ext; //new file name
	$idslider           = $_POST['slider'];
    $texto              = $_POST['textoslide'];
    
    $consulta = "INSERT INTO `slides`(`idslider`, `url`, `texto`) VALUES ('$idslider','$NewFileName','$texto')";    
    
	if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
	   {
                    $log="Se ha agregado la imagen ".$NewFileName." al slider: ".$idslider;
                    $result = mysql_query($consulta,$conexion);
                    if($result){
                    registra_log("Sliders",$log);
                    } else{
                    echo $consulta;
                    echo "<br> no se pudo crear el servicio: ".mysql_error();
                    }
        
        
		die('Confirmación! Archivo subido.'.$consulta);
	}else{
		die('error uploading File!');
	}
	
}
else
{
	die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}
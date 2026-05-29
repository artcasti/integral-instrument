<?php
session_start();
include("conexion.php");
include("functions.php");

if(trim($_POST["usuario"]) != "" && trim($_POST["clave"]) != "")
{
	// Puedes utilizar la funcion para eliminar algun caracter en especifico
	//$usuario = strtolower(quitar($HTTP_POST_VARS["usuario"]));
	//$password = $HTTP_POST_VARS["password"];
	// o puedes convertir los a su entidad HTML aplicable con htmlentities
	$usuario = strtolower($_POST["usuario"]);
	$password = base64_encode($_POST["clave"]);
	$result = $conexion->query('SELECT usuario, password , idperfil, habilitado,nombre, idusuario FROM usuarios WHERE usuario=\''.$usuario.'\'');
	if($row = $result->fetch_array()){
		if($row["password"] == $password){
			if($row["habilitado"] == 1){

						$_SESSION["k_username"] = $row['usuario'];
						$_SESSION['idperfil'] = $row['idperfil'];
						$_SESSION['nombre'] = $row['nombre'];
						$_SESSION['idusuario'] = $row['idusuario'];
						$_SESSION['modulo'] = 'Sesion';

						registra_log($_SESSION['modulo'],'Inicia sesion');	
                if($_SESSION['idperfil']==1){
				echo('<SCRIPT LANGUAGE="javascript">location.href = "pdc_admin.php";</SCRIPT>');
                    }else{
                echo('<SCRIPT LANGUAGE="javascript">location.href = "pdc_admin.php";</SCRIPT>');    
                }
            }else{
            	echo 'Usuario Deshabilitado';	
            }
		}else{
			echo 'Password incorrecto';
		}
	}else{
		echo 'Usuario no existente en la base de datos';
	}
}else{
	echo 'Debe especificar un usuario y password';
}
?>

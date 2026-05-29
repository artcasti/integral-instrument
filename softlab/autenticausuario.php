<?php
session_start();
require_once("class/clases.php");
include("functions.php");



if(trim($_POST["usuario"]) != "" && trim($_POST["clave"]) != "")
{
$login = new LoginUsuario();

    $usuario = strtolower($_POST["usuario"]);
	$password = base64_encode($_POST["clave"]);
//	$password = ($_POST["clave"]);

    $resp = $login->ValidaCredenciales($usuario, $password);
    if (is_numeric($resp))
    {
        //cargo variables de sesion y redirijo a index.php
        $row = $login->GetDatosUsuario($resp);
        $_SESSION['idusuario'] = $row[0];
		$_SESSION["username"] = $row[1];
        $_SESSION['nombre'] = $row[3];
        $_SESSION['imagen'] = $row[6];
        $_SESSION['modulo'] = 'Sesion';

        //var_dump($row);
		//registra_log($_SESSION['modulo'],'Inicia sesion');
        $cm = new ConfigurationManager();
           $cm->registra_log('Sesion','Inicia Sesión');  
        echo('<SCRIPT LANGUAGE="javascript">location.href = "index.php";</SCRIPT>');

    }
    else
    {
        switch ($resp)
        {
            case 'e':
                echo 'No existe el usuario en la base.';
                break;
            case 'd':
                echo 'El usuario está deshabilitado.';
                break;
            case 'p':
                echo 'Contraseña inválida.';
                break;
                
            default:
                echo 'No se puede iniciar la sesión, contacte al administrador.';
                break;
        }
    }
}else{
	echo 'Debe especificar un usuario y password';
}
?>

<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); 
include("functions.php");

//Guardamos los datos del usuario en la tabla Logs

registra_log($_SESSION['modulo'],'Cierra sesion');	


// Borramos toda la sesion
session_destroy();
//echo 'Ha terminado la session <p><a href="index.php">index</a></p>';
?>
<SCRIPT LANGUAGE="javascript">
location.href = "login.php";
</SCRIPT>

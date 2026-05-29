<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}
include("../functions.php");
require_once('clases.php');

$tipodoc = isset($_POST['tipodoc'])? $_POST['tipodoc']: '';
$file = isset($_POST['archivo'])? '../cotizaciones/'.trim($_POST['archivo']): '';
$asunto = isset($_POST['asunto'])? utf8_decode($_POST['asunto']): '';
$body = isset($_POST['cuerpo'])? utf8_decode($_POST['cuerpo']): '';
$para = isset($_POST['para'])? $_POST['para']: '';
$idcotizacion = $_POST['idcotizacion'];

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->setLanguage('es', 'phpmailer/language/');

$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "TU_SMTP_HOST";
$mail->Port = 25;
$mail->From = "TU_EMAIL_FROM";
$mail->Username = "TU_EMAIL_SMTP";
$mail->Password = "TU_PASSWORD_SMTP";

$mail->FromName = "SoftLab - Mail";
$mail->AddAddress($para);
$mail->Subject = $asunto;
$mail->Body = $body;
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';
if($tipodoc!=''){
$mail->AddAttachment($file, $_POST['archivo']);
}
$mensaje = 'ok';
$cm = new ConfigurationManager();
if(!$mail->send()) {
    $mensaje = 'err';
	$cm->registra_log("MAIL",'Mailer Error: ' . $mail->ErrorInfo." - Mail:".$para);
} else {
	$mensaje = 'ok';
	$cm->registra_log("MAIL","Se ha enviado la cotizacion: ".$asunto." - Mail:".$para);

	$cm->ActualizaEstadoCotizacion($idcotizacion,2,$_SESSION['username']);

}
header("Location:../cotizador.php?mensaje=".$mensaje);
?>

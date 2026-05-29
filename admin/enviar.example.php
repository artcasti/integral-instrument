<?php
include("functions.php");

$destino = "info@integralinstrument.com.ar";
$nombre = $_POST['nombre'];
$empresa = $_POST['empresa'];
$email = $_POST['mail'];
$telefono = $_POST['telefono'];
$consulta = $_POST['consulta'];
$contenido = "Nombre: ".$nombre."\nEmpresa: ".$empresa."\nMail: ".$email."\nTelefono: ".$telefono."\nConsulta: ".$consulta;

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->setLanguage('es', 'phpmailer/language/');

$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "TU_SMTP_HOST";
$mail->Username = "TU_EMAIL_SMTP";
$mail->Password = "TU_PASSWORD_SMTP";
$mail->Port = 26;
$mail->From = "TU_EMAIL_FROM";
$mail->FromName = "WEB Integral Instrument";
$mail->AddAddress("info@integralinstrument.com.ar");
$mail->IsHTML(true);
$mail->Subject = "Consultas WEB Integral Instrument";
$body  = "Nombre: ".$nombre."<br />";
$body .= "Empresa: ".$empresa."<br />";
$body .= "Mail: ".$email."<br />";
$body .= "Telefono: ".$telefono."<br />";
$body .= "Consulta: ".$consulta."<br />";
$mail->Body = $body;
$mail->AltBody = $contenido;
$mail->CharSet = 'UTF-8';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    registra_log("Contacto","Consulta web Integral Instrument. Nombre: ".$nombre." - Mail:".$email);
    header("Location:../gracias.php");
}
?>

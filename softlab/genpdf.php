<?php
session_start();

// Inicia el búfer de salida para capturar cualquier salida accidental
ob_start();

header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
    header("Location: signin.php");
    exit(); // Asegura que no se ejecute más código después de redireccionar
}

require_once("class/cpdf.php");

$tipodoc= $_GET['tipodoc'];

switch($tipodoc){
    case "fing":
        $nroingreso = $_GET['nroingreso'];
        
        $pdf = new PDF();
        $pdf->AddPage('P', 'Legal');
        //$pdf->FormIngreso($nroingreso);
        $pdf->DetalleIngreso($nroingreso);

        // Limpia el búfer de salida antes de generar el PDF
        ob_end_clean();

        $pdf->output('I', 'FormIngreso_'.$nroingreso.'.pdf');
        break;

    case "2": // cotización
        $nrocotizacion = $_GET['idcotizacion'];
        $dest = $_GET['dest'];
        $ref = trim($_GET['ref']);
        
        $pdf = new PDF();
        $pdf->AddPage('P', 'A4');
        //$pdf->FormIngreso($nroingreso);
        $pdf->DetalleCotizacion($nrocotizacion);

        // Limpia el búfer de salida antes de generar el PDF
        ob_end_clean();

        if($dest == 'I'){
            $pdf->output('I', 'P'.$ref.'.pdf');
        } else {
            $pdf->output('F', './cotizaciones/P'.$ref.'.pdf');
            // header("location:cotizador.php?mensaje=OK");
            echo './cotizaciones/P'.$ref.'.pdf';
        }
        break;
}

?>

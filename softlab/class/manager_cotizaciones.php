<?php 
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}

require_once("clases.php");
include("../functions.php");

if (isset($_POST['abm'])) {
	$abm= trim($_POST['abm']);

switch ($abm) {
    case 'ingreso_cotizacion'://Administracion de Transportes
        
        $id = $_POST['id'];	
		$empresa = $_POST['empresa'];//cab
		$fechacotizacion = $_POST['fechacotizacion'];
		$referencia = trim($_POST['referencia']);
		$idcliente = $_POST['cliente'];
		$idcontacto = $_POST['contacto'];
		$emailenvio = $_POST['email'];
		$encabezado = html_entity_decode($_POST['textencabezado']);
		$condiciones = html_entity_decode($_POST['condiciones']);
        
		$cm= new ConfigurationManager();
        $res = $cm->grabaCabeceraCotizacion($id, $empresa, $fechacotizacion, $referencia, $idcliente, $idcontacto, $emailenvio, $encabezado, $condiciones ,$_SESSION['username']);            
        //$res=TRUE;
/*			echo '<pre>';
			var_dump($_POST);
			echo '</pre>';			
*/					
        if ( $res ) {
			$cm->ActualizaContadorCotizacion($empresa,$res);
  			echo $res;
        } else {
        	echo $res;
			//var_dump($_POST);
        }
		break;		
}
}else{
	
    $accion=$_GET['accion'];

switch ($accion) {
	case 'agregaitem':
		$idcotizacion = $_GET['idcotizacion'];
		$iditem = $_GET['iditemcotizacion'];
		$txtitemcotizacion = $_GET['tarea'];
		$cantidad = $_GET['cantidad'];
		$preciounitario = $_GET['precio'];
		$total = $_GET['total'];
		$idequipo = $_GET['idequipo'];
			$bonificado = 0;
		if($total < $cantidad * $preciounitario){
			$bonificado = 1;
		}
		$cm= new ConfigurationManager();
		
		$itm = $cm->grabaItemCotizacion( $idcotizacion, $iditem, $txtitemcotizacion, $cantidad, $preciounitario, $idequipo, $bonificado);

		if ($itm ===TRUE)
        {
				echo $itm;
           //header("location:../marcas.php");
        }else{
			//$cant = $cm->getCantModelos($_GET['id']);
            //header("location:../marcas.php?error=".$cant[0]);
			echo $itm;
        }


		break;
    case 'eliminacotizacion'://Administracion de Menu Padre
		$cm= new ConfigurationManager();
        $res = $cm->eliminaCotizacion($_GET['id']);            
  //echo $res;
		    if ($res===TRUE)
        {
				//echo $res;
           header("location:../cotizador.php");
        }else{
            header("location:../cotizador.php?error=cotizacionenviada");
			//echo $cant[0];
        }
		break;
}


}





?>

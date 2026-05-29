<?php 
session_start();
header('Content-Type: text/html; charset=utf-8'); 
if (!isset($_SESSION['username'])){
header("Location: signin.php");
}

require_once("clases.php");
include("../functions.php");
//include("functions.php");
//echo 'estoy';
//var_dump($_GET);
if (isset($_POST['abm'])) {
	$abm= trim($_POST['abm']);

switch ($abm) {
    case 'menupadre'://Administracion de Menu Padre
        if ($_POST['idmenu']==0)
        {
		$menu= new MenuPadre($_POST['label'],$_POST['icono'],$_POST['orden']);
        echo $menu->getUltimoIDMenuPadre();
        $res = $menu->grabaMenuPadre();            
        }
        else
        {
		$menu= new MenuPadre($_POST['label'],$_POST['icono'],$_POST['orden']);
        $res = $menu->actualizaMenuPadre($_POST['idmenu'],$_POST['label'],$_POST['icono'],$_POST['orden']);            
            
        }
        if ($res==TRUE)
        {
            $cm= new ConfigurationManager();
            $cm->registra_log('Menu','Se ha creado el menu padre:'.$_POST['label']);
            header("location:../menu.php");
        }else{
            echo $res;
        }
		break;
    case 'menu'://Administracion de Menu Padre
 
        if ($_POST['idmenuh']==0)
        {
		$cm= new ConfigurationManager();
        $res = $cm->grabaMenu($_POST['labelh'],$_POST['href'],$_POST['iconoh'],$_POST['menupadre'],$_POST['orden']);            
        }
        else
        {
		$cm= new ConfigurationManager();
        $res = $cm->actualizaMenu($_POST['idmenuh'],$_POST['labelh'],$_POST['href'],$_POST['iconoh'],$_POST['menupadre'],$_POST['orden']);            
            
        }
        if ($res==TRUE)
        {
            header("location:../menuh.php");
        }
		else
		{
            echo $res;
        }
		break;
        
    case 'usuario'://Administracion de Usuarios
        $idusuario = $_POST['userid'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $clave = base64_encode($_POST['clave']);
       // $celular = $_POST['celular'];
        $perfiles = $_POST['perfil'];
        $habilitado = $_POST['habilitado'];

        if(strlen($_FILES['FileInput']['name'])>1)
        {
            copy($_FILES['FileInput']['tmp_name'], "../images/".$_FILES['FileInput']['name']);
                $imagen=$_FILES['FileInput']['name'];
        }else{
            $imagen = $_POST['imagen'];
        }

		$cm= new ConfigurationManager();
        $res = $cm->grabaUsuario($idusuario, $nombre, $apellido, $email, $username, $clave,  $imagen, $habilitado);            
        
        if ($res==TRUE)
        {
            header("location:../usuarios.php");
        }else{
            echo $res;
        }
		break;

    case 'marca'://Administracion de Usuarios
        $idmarca = $_POST['idmarca'];
        $marca = $_POST['marca'];
        $urlmarca = $_POST['urlmarca'];
        $texto = $_POST['observaciones'];

        if(strlen($_FILES['FileInput']['name'])>1)
        {
            copy($_FILES['FileInput']['tmp_name'], "../images/marcas/".$_FILES['FileInput']['name']);
                $imagen=$_FILES['FileInput']['name'];
        }else{
            $imagen = $_POST['imagen'];
        }

		$cm= new ConfigurationManager();
        $res = $cm->grabaMarca($idmarca, $marca, $imagen, $urlmarca, $texto);            
		
        if ($res==TRUE)
		{
            header("location:../marcas.php");
        }else{
            echo $res;
        }
		break;
    case 'modelo'://Administracion de Modelos
        $idmodelo = $_POST['id'];
        $idmarca = $_POST['marcas'];
        $modelo = $_POST['modelo'];
        $urlmodelo = $_POST['urlmodelo'];
        $texto = $_POST['observaciones'];

        if(strlen($_FILES['FileInput']['name'])>1)
        {
            copy($_FILES['FileInput']['tmp_name'], "../images/modelos/".$_FILES['FileInput']['name']);
                $imagen=$_FILES['FileInput']['name'];
        }else{
            $imagen = $_POST['imagen'];
        }

		$cm= new ConfigurationManager();
        $res = $cm->grabaModelo($idmodelo, $modelo, $imagen, $urlmodelo, $texto, $idmarca);            
        
        if ($res==TRUE)
        {
            header("location:../modelos.php");
        }else{
            echo $res;
        }
		break;
    case 'documento'://Administracion de Documentos
        $tipodoc = $_POST['tipodoc'];
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if(strlen($_FILES['DocInput']['name'])>1)
        {
            $Random_Number=rand(0, 9999999999); //Random number to be added to name.
            copy($_FILES['DocInput']['tmp_name'], "../documentos/".$Random_Number."_".$_FILES['DocInput']['name']);
                $urldocumento=$Random_Number."_".$_FILES['DocInput']['name'];
        }

		$cm= new ConfigurationManager();
        $res = $cm->grabaDocumento($tipodoc, $id, $nombre, $urldocumento);            
        if ($res==TRUE)
        {
                     echo $res;
            header("location:../form_documentos.php?id=".$id."&tipo=".$tipodoc);
        }else{
            echo $res;
        }
		break;        
    case 'cliente'://Administracion de Clientes
        
        $id = $_POST['id'];
        $tipodoc = $_POST['tipodoc'];
        $nrodoc = $_POST['nrodoc'];
        $nombre = $_POST['nombre'];
        $condiva = $_POST['condiva'];
        $domicilio = $_POST['domicilio'];
        $localidad = $_POST['localidad'];
        $provincia = $_POST['provincia'];
        $pais = $_POST['pais'];
        $telefono = $_POST['telefono'];
        $cpostal = $_POST['cpostal'];
        $contactoppal = $_POST['contactoppal'];
        $email = $_POST['email'];
        $habilitado = $_POST['habilitado'];
        $observaciones = $_POST['observaciones'];
        
        if (isset($_POST['estrellas']))
        {
        $clasificacion = $_POST['estrellas'];           
        }
        else
        {
        $clasificacion = 0;        
        }
         $idtransporte = $_POST['transporte'];
        
		$cm= new ConfigurationManager();
        $res = $cm->grabaCliente($id, $tipodoc, $nrodoc, $nombre, $condiva, $domicilio, $localidad, $telefono, $cpostal,$contactoppal, $email, $habilitado, $observaciones,$provincia,$pais,$clasificacion,$idtransporte);            
        
        if ($res==TRUE)
        {
            header("location:../clientes.php");
        }else{
            echo $res;
        }
		break;
    case 'familia'://Administracion de Documentos
        $familia = $_POST['familia'];
        $id = $_POST['id'];
    

		$cm= new ConfigurationManager();
        $res = $cm->grabaFamilia($id, $familia);            
        if ($res==TRUE)
        {
            header("location:../familias.php");
        }else{
            echo $res;
        }
		break;          

    case 'subfamilia'://Administracion de Documentos
        $idfamilia = $_POST['familia'];
        $id = $_POST['id'];
        $subfamilia = $_POST['subfamilia'];

		$cm= new ConfigurationManager();
        $res = $cm->grabaSubfamilia($id,$subfamilia, $idfamilia);            
        if ($res==TRUE)
        {

            header("location:../subfamilias.php");
        }else{
            echo $res;
        }
		break;          
        
    case 'equipo'://Administracion de Equipos
        $idequipo = $_POST['id'];
        $idfamilia = $_POST['familia'];
		$idsubfamilia = $_POST['subfamilia'];	
        $idmarca = $_POST['marca'];
        $idmodelo = $_POST['modelo'];
        $nroserie = $_POST['nroserie'];
        $idcliente = $_POST['cliente'];
		$espatron = $_POST['espatron'];
        $observaciones = $_POST['observaciones'];

        if(strlen($_FILES['FileInput']['name'])>1)
        {
             $Random_Number=rand(0, 9999999999); 
            copy($_FILES['FileInput']['tmp_name'], "../images/equipos/".$Random_Number."_".$_FILES['FileInput']['name']);
                $imagen=$Random_Number."_".$_FILES['FileInput']['name'];
        }else{
            $imagen = $_POST['imagen'];
        }

		$cm= new ConfigurationManager();
        $res = $cm->grabaEquipo($idequipo,$idfamilia,$idmarca,$idmodelo,$nroserie,$idcliente, $imagen,  $observaciones,$idsubfamilia,$espatron);            
        
        if ($res==TRUE)
        {
            header("location:../equipos.php");
        }else{
            echo $res;
        }
		break;
    case 'empresa'://Administracion de Empresas
        
        $id = $_POST['id'];
        $tipodoc = $_POST['tipodoc'];
        $nrodoc = $_POST['nrodoc'];
        $nombre = $_POST['nombre'];
        $condiva = $_POST['condiva'];
        $domicilio = $_POST['domicilio'];
        $localidad = $_POST['localidad'];
        $telefono = $_POST['telefono'];
        $cpostal = $_POST['cpostal'];
        $email = $_POST['email'];
        $observaciones = $_POST['observaciones'];
        $provincia = $_POST['provincia'];
        $pais = $_POST['pais'];        

		$cm= new ConfigurationManager();
        $res = $cm->grabaEmpresa($id, $tipodoc, $nrodoc, $nombre, $condiva, $domicilio, $localidad, $telefono, $cpostal, $email, $observaciones,$provincia,$pais);            
        
        if ($res==TRUE)
        {
            header("location:../empresas.php");
        }else{
            echo $res;
        }
		break;

    case 'contacto'://Administracion de Contactos
        
        $id = $_POST['id'];
        $contacto = $_POST['contacto'];
        $idcliente = $_POST['cliente'];
        $domicilio = $_POST['domicilio'];
        $localidad = $_POST['localidad'];
        $provincia = $_POST['provincia'];
        $pais = $_POST['pais'];        
        $telefono = $_POST['telefono'];
        $cpostal = $_POST['cpostal'];
        $email = $_POST['email'];
        $idtransporte = $_POST['transporte'];
        $observaciones = $_POST['observaciones'];
        $habilitado = (isset($_POST['habilitado'])) ? $_POST['habilitado'] : 1 ;
        
        if (isset($_POST['estrellas']))
        {
        $clasificacion = $_POST['estrellas'];           
        }
        else
        {
        $clasificacion = 0;        
        }
 
        
        
        if(strlen($_FILES['FileInput']['name'])>1)
        {
            copy($_FILES['FileInput']['tmp_name'], "../images/contactos/".$_FILES['FileInput']['name']);
                $imagen=$_FILES['FileInput']['name'];
        }else{
            $imagen = $_POST['imagen'];
        }        
        
        
		$cm= new ConfigurationManager();
        $res = $cm->grabaContacto($id, $contacto, $idcliente, $domicilio, $localidad,$provincia,$pais, $telefono, $cpostal, $email, $idtransporte, $clasificacion, $habilitado,  $imagen,$observaciones);            
        
        if ($res==TRUE)
        {
            header("location:../contactos.php");
        }else{
            echo $res;
        }
		break;        

    case 'transporte'://Administracion de Transportes
        
        $id = $_POST['id'];
        $transporte = $_POST['transporte'];
        $domicilio = $_POST['domicilio'];
        $localidad = $_POST['localidad'];
        $provincia = $_POST['provincia'];
        $pais = $_POST['pais'];        
        $telefono = $_POST['telefono'];
        $cpostal = $_POST['cpostal'];
        $email = $_POST['email'];
        $observaciones = $_POST['observaciones'];
        
        
		$cm= new ConfigurationManager();
        $res = $cm->grabaTransporte($id, $transporte, $domicilio, $localidad,$provincia,$pais, $telefono, $cpostal, $email,$observaciones);            
        
        if ($res==TRUE)
        {
            header("location:../transportes.php");
        }else{
            echo $res;
        }
		break;
		
    case 'ingreso_cabecera'://Administracion de Transportes
        
        $id = $_POST['id'];	
		$empresa = $_POST['empresa'];//cab
		$fechaingreso = $_POST['fechaingreso'];
		$idcliente = $_POST['cliente'];
		$idcontacto = $_POST['contacto'];
		$nombrecertificado = $_POST['nombrecertificado'];
		$entregadopor = $_POST['entregadopor'];
//det
        
        
		$cm= new ConfigurationManager();
        $res = $cm->grabaIngreso($id, $empresa, $fechaingreso, $idcliente, $idcontacto, $nombrecertificado, $entregadopor,$_SESSION['username']);            
        //$res=TRUE;
        if ( $res ) {
        	//Cargo los valores seleccionados del formulario
  			if ($id==0){ 
			if ( isset( $_POST[ 'calibra' ] ) ) {
        		$calibra = 1;
        	} else {
        		$calibra = 0;
        	}
        	if ( isset( $_POST[ 'repara' ] ) ) {
        		$repara = 1;
        	} else {
        		$repara = 0;
        	}
        	if ( isset( $_POST[ 'cargador' ] ) ) {
        		$cargador = 1;
        	} else {
        		$cargador = 0;
        	}
        	if ( isset( $_POST[ 'valija' ] ) ) {
        		$valija = 1;
        	} else {
        		$valija = 0;
        	}
        	if ( isset( $_POST[ 'interfase' ] ) ) {
        		$interfase = 1;
        	} else {
        		$interfase = 0;
        	}
        	if ( isset( $_POST[ 'bomba' ] ) ) {
        		$bomba = 1;
        	} else {
        		$bomba = 0;
        	}
        	if ( isset( $_POST[ 'copa' ] ) ) {
        		$copa = 1;
        	} else {
        		$copa = 0;
        	}
        	if ( isset( $_POST[ 'baterias' ] ) ) {
        		$baterias = 1;
        	} else {
        		$baterias = 0;
        	}
        	if ( isset( $_POST[ 'nrolinea' ] ) ) {
        		$nrolinea = $_POST[ 'nrolinea' ];
        	} else {
        		$nrolinea = 0;
        	}
			if ( isset( $_POST[ 'vtocertificado' ] ) ) {
        		$vtocertificado = 1;
        	} else {
        		$vtocertificado = 0;
        	}

        	//Cargo la imagen del equipo
        	if ( strlen( $_FILES[ 'FileInput' ][ 'name' ] ) > 1 ) {
        		$Random_Number = rand( 0, 9999 );
        		copy( $_FILES[ 'FileInput' ][ 'tmp_name' ], "../images/laboratorio/form_" . $res . "_" . $Random_Number . "_" . $_FILES[ 'FileInput' ][ 'name' ] );
        		$imagen = "form_" . $res . "_" . $Random_Number . "_" . $_FILES[ 'FileInput' ][ 'name' ];
        	} else {
        		$imagen = $_POST[ 'imagen' ];
        	}
        	$equipo = $_POST[ 'equipo' ];
        	$observaciones = $_POST[ 'observaciones' ];

        	$itm = $cm->grabaIngresoDetalle( $res, $nrolinea, $equipo, $calibra, $repara, $cargador, $valija, $interfase, $bomba, $copa, $baterias,$vtocertificado, $imagen, $observaciones,$_SESSION['username'] );
			
				        	if ( $itm ) {
        		/*					echo 'se ha generado el form nro:'.$res.'</br>';
        			
        					var_dump($_POST);
        					echo '<pre>';
        					var_dump($_FILES);
        					echo '</pre>';*/
        		header( "location:../entradalab.php" );
        	} else {
        		echo $itm;
        	}

				
  			}
        		header( "location:../entradalab.php" );
        } else {
        	echo $res;
        }
		break;
    case 'agregaringreso'://Administracion de Transportes
        $cm= new ConfigurationManager();
        $id = $_POST['id'];	
        $nrolinea = $_POST['nrolinea'];	

		if ( isset( $_POST[ 'calibra' ] ) ) {
        		$calibra = 1;
        	} else {
        		$calibra = 0;
        	}
        	if ( isset( $_POST[ 'repara' ] ) ) {
        		$repara = 1;
        	} else {
        		$repara = 0;
        	}
        	if ( isset( $_POST[ 'cargador' ] ) ) {
        		$cargador = 1;
        	} else {
        		$cargador = 0;
        	}
        	if ( isset( $_POST[ 'valija' ] ) ) {
        		$valija = 1;
        	} else {
        		$valija = 0;
        	}
        	if ( isset( $_POST[ 'interfase' ] ) ) {
        		$interfase = 1;
        	} else {
        		$interfase = 0;
        	}
        	if ( isset( $_POST[ 'bomba' ] ) ) {
        		$bomba = 1;
        	} else {
        		$bomba = 0;
        	}
        	if ( isset( $_POST[ 'copa' ] ) ) {
        		$copa = 1;
        	} else {
        		$copa = 0;
        	}
        	if ( isset( $_POST[ 'baterias' ] ) ) {
        		$baterias = 1;
        	} else {
        		$baterias = 0;
        	}
			if ( isset( $_POST[ 'vtocertificado' ] ) ) {
        		$vtocertificado = 1;
        	} else {
        		$vtocertificado = 0;
        	}

        	//Cargo la imagen del equipo
        	if ( strlen( $_FILES[ 'FileInput' ][ 'name' ] ) > 1 ) {
        		$Random_Number = rand( 0, 9999 );
        		$imagen = "form_" . $id . "_" . $Random_Number . "_" . $_FILES[ 'FileInput' ][ 'name' ];
        	} else {
        		$imagen = $_POST[ 'imagen' ];
        	}
        	$equipo = $_POST[ 'equipo' ];
        	$observaciones = $_POST[ 'observaciones' ];
        			

        	$itm = $cm->grabaIngresoDetalle( $id, $nrolinea, $equipo, $calibra, $repara, $cargador, $valija, $interfase, $bomba, $copa, $baterias,$vtocertificado, $imagen, $observaciones,$_SESSION['username'] );

        	if ( $itm ) {
        		if ( strlen( $_FILES[ 'FileInput' ][ 'name' ] ) > 1 ) {
        		copy( $_FILES[ 'FileInput' ][ 'tmp_name' ], "../images/laboratorio/form_" . $id . "_" . $Random_Number . "_" . $_FILES[ 'FileInput' ][ 'name' ] );
				$origen = "../images/laboratorio/form_" . $id . "_" . $Random_Number . "_" . $_FILES[ 'FileInput'][ 'name' ];
				$destino = "../images/laboratorio/retocadas/form_" . $id . "_" . $Random_Number . "_" . $_FILES[ 'FileInput'][ 'name' ];
				$ancho_max=600;
				$alto_max=400; 
				$fijar='ancho';	
				redimensionarJPEG ($origen, $destino, $ancho_max, $alto_max, $fijar);	
        	}				
        		/*			var_dump($_POST);
        					echo '<pre>';
        					var_dump($_FILES);
        					echo '</pre>';
        		//*/
				header( "location:../form_ingreso.php?id=".$id );
        	} else {
        		echo $itm;
				        					var_dump($_POST);
        					echo '<pre>';
        					var_dump($_FILES);
        					echo '</pre>';
        	}

		break;
	case 'parametros_cotizacion':
        $id = $_POST['id'];
        $nrocotizacion = $_POST['nrocotizacion'];
        $lugarcotizacion = $_POST['lugarcotizacion'];
        $campode = $_POST['campode'];
        $textoheader = $_POST['textoheader'];
        $encabezadocotizacion = $_POST['encabezadocotizacion'];
        $condicionescomerciales = $_POST['condicionescomerciales'];                
        
        if(strlen($_FILES['FileInput']['name'])>1)
        {
            copy($_FILES['FileInput']['tmp_name'], "../images/".$_FILES['FileInput']['name']);
                $imagen=$_FILES['FileInput']['name'];
        }else{
            $imagen = $_POST['imagen'];
        }        
        
        
		$cm= new ConfigurationManager();
        $res = $cm->grabaParametros($id, $nrocotizacion, $lugarcotizacion, $campode, $textoheader, $encabezadocotizacion,$condicionescomerciales,$imagen,$_SESSION['username']);            
        
        if ($res==TRUE)
        {
            header("location:../empresas.php");
        }else{
            echo $res;
        }
		
		
		break;

	case 'ingreso_calibracion':
		
        $id = $_POST['id'];
        $fechaingreso = $_POST['fechaingreso'];
		$familia = $_POST['familia'];
		$nombrecal = $_POST['nombrecal'];
		$patron = $_POST['patron'];
		
		if(isset($_POST['valores']))
		{
		$valores = $_POST['valores'];
		
		$cadena='';		
		foreach ($valores as $val)
		{
			$sep = explode('+',$val);
			$cadena.=$sep[0].'/';
		}
		$cadena = substr($cadena,0,-1);
		}else{
			$cadena='';
		}
		
		$cm= new ConfigurationManager();
        $res = $cm->grabaCabeceraCalibracion($id, $fechaingreso, $familia, $patron,$cadena,$_SESSION['username'],$nombrecal); 		
		
		//$res es el id.
		if (isset($_POST['equipos'])){
		$equipos = $_POST['equipos'];

		foreach ($equipos as $eq)
		{
			$sep = explode('+',$eq);
			$itemschequeo = $cm->generaChequeoEquipos($res, $sep[0]);
			$calibracionequipos = $cm->generaCalibracionEquipos($res, $sep[0], $sep[1]);
			$cm->actualizaEstadoIngresoDetalle($sep[1], $sep[0], 2);
		}
			
		}
			
	
		if($id!=0){
		$calequipos = $cm->getCalibracionEquipos($id);	
		$cadena = $cm->getCadenaValores($id)[0];
		$idcal= $id;	
		}else{
		$calequipos = $cm->getCalibracionEquipos($res);	
		$idcal= $res;	
		}

		while ($eq=$calequipos->fetch_array()){ 
		
			$calibracionmediciones = $cm->generaCalibracionMediciones($idcal, $eq[1], $cadena);
			
		}
		
		header("location:../calibraciones.php");
		
		break;
		
	case 'chequeo_equipo':
		$idcalibracion = $_POST['idcalibracion'];
		$idequipo = $_POST['idequipo'];
		
		$cm= new ConfigurationManager();
		$resultado = $cm->getItemsChequeo($idcalibracion,$idequipo);
		
		while ($items=$resultado->fetch_array()){ 
		
		$obs = $_POST['obs_'.$items['iditemchequeo']];
		$ok = (isset($_POST['ok_'.$items['iditemchequeo']]))? 1:0;
		$rep = (isset($_POST['rep_'.$items['iditemchequeo']]))? 1:0;	
		$chequeo = $cm->actualizaChequeoEquipo($idcalibracion, $idequipo,$items['iditemchequeo'], $ok, $rep, $obs );
		if($chequeo){
			$cm->actualizaEstadoChequeoEquipo($idcalibracion, $idequipo,1);
		}	
		}
		
		header("location:../gestion_calibracion.php?id=$idcalibracion");
		break;		

	case 'carga_valores':
		$idcalibracion = $_POST['idcalibracion'];
		$equipo = $_POST['equipo'];
		$idvalor = $_POST['idvalor'];
		$idpatron = $_POST['idpatron'];
		
		$valorpatron = $_POST['vmp'];
		$cm= new ConfigurationManager();
		
		if ($equipo==0){
		$resultado = $cm->getCalibracionEquipos($idcalibracion);
			while ($eq=$resultado->fetch_array()){
				$ide=$eq['idequipo'];
				$vsa = $_POST['vsa_'.$ide];
				$vaj = $_POST['vaj_'.$ide];
				$obs = $_POST['obs_'.$ide];
				$carga = $cm->actualizaCargaValores($idcalibracion, $ide, $idvalor, $valorpatron, $vsa, $vaj, $obs );
					if($carga){
					$cm->actualizaEstadoCargaEquipo($idcalibracion, $ide,1);
					}
			} 
		
		}else{
				$ide=$equipo;
				$vsa = $_POST['vsa_'.$ide];
				$vaj = $_POST['vaj_'.$ide];
				$obs = $_POST['obs_'.$ide];
				$carga = $cm->actualizaCargaValores($idcalibracion, $ide, $idvalor, $valorpatron, $vsa, $vaj, $obs );
					if($carga){
					$cm->actualizaEstadoCargaEquipo($idcalibracion, $ide,1);
					}
		}
		
		header("location:../cargar_calibracion.php?id=$idcalibracion&idequipo=$equipo");
		
		break;
		
	case 'valoresnominales':
		$idfamilia = $_POST['idfamilia'];
		$idvalor = $_POST['idvalor'];
		$valor = $_POST['valor'];
		$unidad = $_POST['unidad'];
		$cm= new ConfigurationManager();

		$resultado = $cm->grabaValoresNominales($idfamilia, $idvalor, $valor, $unidad);
		
//		var_dump($_POST);
//		echo 'resultado:' .$resultado;
//		die();		
//		
		header("location:../form_confvalores.php?id=$idfamilia");
		
		break;		
}



}else{
	
    $accion=$_GET['accion'];

switch ($accion) {
    case 'eliminamenupadre'://Administracion de Menu Padre
		$menu= new MenuPadre('','');
        $res = $menu->eliminaMenuPadre($_GET['id']);
        if ($res==TRUE)
        {

            header("location:../menu.php");
        }else{
            echo $res;
        }
		break;

    case 'eliminamenu'://Administracion de Menu Padre
		$cm= new ConfigurationManager();
        $res = $cm->eliminaMenu($_GET['id']);            
        if ($res==TRUE)
        {
           // echo $res;
            header("location:../menuh.php");
        }else{
            echo $res;
        }
		break;
    case 'eliminamarca'://Administracion de Menu Padre
		$cm= new ConfigurationManager();
        $res = $cm->eliminaMarca($_GET['id']);            
        if ($res===TRUE)
        {
				//echo $res;
           header("location:../marcas.php");
        }else{
			$cant = $cm->getCantModelos($_GET['id']);
            header("location:../marcas.php?error=".$cant[0]);
			//echo $cant[0];
        }
		break;
    case 'eliminadocumento'://Administracion de Menu Padre
		$cm= new ConfigurationManager();
        $res = $cm->eliminaDocumento($_GET['id']);            
        if ($res==TRUE)
        {
           // echo $res;
            header("location:../form_documentos.php?id=".$_GET['idpadre']."&tipo=".$_GET['tipo']);
        }else{
            echo $res;
        }
		break;         
    case 'eliminafamilia'://Administracion de Menu Padre
		$cm= new ConfigurationManager();
        $res = $cm->eliminaFamilia($_GET['id']);            
        if ($res==TRUE)
        {
            header("location:../familias.php");
        }else{
			$cant = $cm->getCantSubfamilias($_GET['id']);
            header("location:../familias.php?error=".$cant[0]);
        }
		break;          
    case 'eliminasubfamilia'://Administracion de Subfamilias
		$cm= new ConfigurationManager();
        $res = $cm->eliminaSubfamilia($_GET['id']);            
        if ($res==TRUE)
        {
           // echo $res;
            header("location:../subfamilias.php");
        }else{
			$cant = $cm->getCantEqSubfamilias($_GET['id']);
            header("location:../subfamilias.php?error=".$cant[0]);
        }
		break;
    case 'eliminacontacto'://Administracion de Contactos
		$cm= new ConfigurationManager();
        $res = $cm->eliminaContacto($_GET['id']);            
        if ($res==TRUE)
        {
            header("location:../contactos.php");
        }else{
            echo $res;
        }
		break;
    case 'eliminatransporte'://Administracion de Transportes
		$cm= new ConfigurationManager();
        $res = $cm->eliminaTransporte($_GET['id']);            
        if ($res==TRUE)
        {
            header("location:../transportes.php");
        }else{
            echo $res;
        }
		break;
    case 'eliminamodelo'://Administracion de Transportes
		$cm= new ConfigurationManager();
        $res = $cm->eliminaModelo($_GET['id']);            
        if ($res==TRUE)
        {
            header("location:../modelos.php");
        }else{
            echo $res;
        }
		break; 
    case 'eliminaingreso'://Administracion de ingresos
		$cm= new ConfigurationManager();
        $res = $cm->eliminaIngreso($_GET['id'],$_GET['linea']);            
        if ($res==TRUE)
        {
            header("location:../form_ingreso.php?id=".$_GET['id']);
        }else{
            echo $res;
        }
		break;
    case 'eliminacliente'://Administracion de Subfamilias
		$cm= new ConfigurationManager();
        $res = $cm->eliminaCliente($_GET['id']);            
        if ($res===TRUE)
        {
            header("location:../clientes.php");
        }else{
			$cant = $cm->getCantEqClientes($_GET['id']);
            header("location:../clientes.php?error=".$cant[0]);
        }
		break;
    case 'eliminaequipo'://Administracion de equipos
		$cm= new ConfigurationManager();
        $res = $cm->eliminaEquipo($_GET['id']);            
        if ($res===TRUE)
        {
           header("location:../equipos.php");
        }else{
			$cantCot = $cm->getCantCotEquipo($_GET['id']);
			$cantIng = $cm->getCantIngEquipo($_GET['id']);
			$cant .=$cantCot[0].'-'.$cantIng[0] ;	
			//echo $cant;
            header("location:../equipos.php?error=".$cant);
        }
		break;			
    case 'eliminacalibracion'://Administracion de calibraciones
		$cm= new ConfigurationManager();
        $res = $cm->eliminaCalibracion($_GET['id']);            
        if ($res===TRUE)
        {
           header("location:../calibraciones.php");
        }else{
			$cantEq = $cm->getCantCalEquipo($_GET['id']);
            header("location:../calibraciones.php?error=".$cantEq[0]);
        }
		break;			

    case 'eliminavalorcalibracion'://Administracion de calibraciones
		$idvalor = $_GET['idvalor'];
		$idcalibracion = $_GET['idcalibracion'];
		$cm= new ConfigurationManager();
        $res = $cm->eliminaValorCalibracion($idcalibracion, $idvalor);            
        if ($res===TRUE)
        {
           header("location:../form_calibracion.php?id=$idcalibracion");
        }else{
            header("location:../form_calibracion.php?error=0");
        }
		break;
    case 'eliminaequipocalibracion'://Administracion de calibraciones
		$idequipo = $_GET['idequipo'];
		$idcalibracion = $_GET['idcalibracion'];
		$nroingreso = $_GET['nroingreso'];
		
		$cm= new ConfigurationManager();
        $res = $cm->eliminaEquipoCalibracion($idcalibracion, $idequipo);            
		
        if ($res===TRUE)
        {
			$cm->actualizaEstadoIngresoDetalle($nroingreso, $idequipo, 1);
           header("location:../form_calibracion.php?id=$idcalibracion");
        }else{
            header("location:../form_calibracion.php?error=0");
        }
		break;		
	case 'eliminavalornominal':
		$idvalor = $_GET['id'];
		$idfamilia = $_GET['idfamilia'];

		$cm= new ConfigurationManager();
        $res = $cm->eliminaValorNominal($idvalor);            
		
        if ($res===TRUE)
        {
           header("location:../form_confvalores.php?id=$idfamilia");
        }else{
			$cantVl = $cm->getCantValoresCalibracion($idvalor);
            header("location:../form_confvalores.php?id=$idfamilia&error=$cantVl[0]");
        }
		
		
		break;
}


}





?>

<?php   
ob_start();

require_once('fpdf/fpdf.php');
require_once('clases.php');
require_once('./functions.php');

class PDF extends FPDF
{

	function Header()
	{
		global $tipodoc;
		global $nroingreso;
		global $nrocotizacion;		
		

	switch($tipodoc){
		case "fing":
				$head_title="FORMULARIO DE INGRESO";
				$head_titnro="Nro: ";
				$head_titfech="FECHA: ";

				//titulos del cuadro cabecera
				$cuad_titempresa="Empresa: ";
				$cuad_titcliente="Cliente: ";		
				$cuad_titnrotel="Nro de tel: ";
				$cuad_titdomicilio="Domicilio: ";
				$cuad_titcontacto="Contacto: ";
				$cuad_titemail="E-mail: ";
				$cuad_titcuit="Nro C.U.I.T: ";

				//titulos cuadro equipos

				$equip_titulo="Equipos recibidos:";
				$equip_titmarca="MARCA";
				$equip_titmodelo="MODELO";
				$equip_titnroserie="Nro DE SERIE";
				$equip_titcalibra="Cal.";
				$equip_titrepara="Rep.";
				$equip_titcosto="Costo Inicial";

				$equip_titcertif="Certificado a nombre de: ";
				$equip_titaccesorios="Accesorios: ";

				$cm = new ConfigurationManager();
				$infoingreso = $cm->getIngreso($nroingreso);
				$infoempresa = $cm->getEmpresa($infoingreso['idempresa']);
				$infocliente = $cm->getCliente($infoingreso['idcliente']);

				//Armado del formulario
				$this->SetFont('Arial','B',14);
				$this->SetXY(85,10);
				$this->Cell(0,0,$infoempresa['nombre'],0,1,'L');

				$this->SetXY(18,18);
				$this->Cell(0,0,$head_title,0,1,'L');
				$this->SetXY(90,18);
				$this->Cell(0,0,$head_titnro.$nroingreso,0,1,'L');
				$this->SetFont('Arial','',12);
				$this->SetXY(150,18);
				$fecha = date('d-m-Y',strtotime($infoingreso['fechaingreso']));
				$this->Cell(0,0,$head_titfech.$fecha,0,1,'L');


				$this->SetFont('Arial','',11);

				$this->SetXY(18,22);
				$this->Cell(180,26,'',1,0,'L');

				$this->SetXY(20,28);
				$this->Cell(0,0,$cuad_titempresa.$infocliente['nombre'],0,1,'L');

				if ($infoingreso[4]==0) //si no se selecciono un contaco en particular 
				{   
					$contacto = $infocliente['contactoppal'];
					$nrotel = $infocliente['telefono'];
					$email = $infocliente['email'];
					$domicilio = $infocliente['domicilio'];
				}
				else
				{   
					$infocontacto = $cm->getContacto($infoingreso[4]);
					$contacto = $infocontacto[1];
					$nrotel = $infocontacto[3];
					$email = $infocontacto[4];
					$domicilio = $infocontacto[5];
				}

				$this->SetXY(110,28);
				$this->Cell(0,0,$cuad_titcontacto.$contacto,0,1,'L');


				$this->SetXY(20,36);
				$this->Cell(0,0,$cuad_titnrotel.$nrotel,0,1,'L');

				$this->SetXY(110,36);
				$this->Cell(0,0,$cuad_titemail.$email,0,1,'L');

				$this->SetXY(20,44);
				$this->Cell(0,0,$cuad_titdomicilio.$domicilio,0,1,'L');

				$this->SetXY(110,44);
				$this->Cell(0,0,$cuad_titcuit.$infocliente[2],0,1,'L');

			break;
		case "2":
				$cm = new ConfigurationManager();
				$infocotizacion = $cm->getCotizacion($nrocotizacion);
				$paramsempresa = $cm->getParametros($infocotizacion['idempresa']);
				
				$path_imagen='./images/';
				$logo = $path_imagen.$paramsempresa['logocotizacion'];
				$campo_de= $paramsempresa['campo_de'];
				$head_de=mb_convert_encoding("De: ".$campo_de, 'ISO-8859-1', 'UTF-8');
				$texto_header = $paramsempresa['texto_header'];
				$head_leyenda=mb_convert_encoding($texto_header, 'ISO-8859-1', 'UTF-8');

				//Armado del formulario
			
				$this->Image($logo,15,10,0,20);
				$this->SetFont('Arial','',11);
				$this->SetXY(155,27);
				$this->Cell(0,0,$head_de,0,1,'L');
				$this->Line(15,30,196,30);
				$this->SetXY(15,31);
				$this->SetTextColor(128);
				$this->MultiCell(181,4,$head_leyenda,0,'C',false);
			
			

			break;
			
	}
		
	}

	function Footer()
	{
		global $tipodoc;
		global $nroingreso;
		global $nrocotizacion;

	switch($tipodoc){
		case "fing":
		//Cuadro con información de gastos y otras yerbas
		
		$y=-110;	
			
		$linea1=mb_convert_encoding('1-Los gastos de traslado del equipo correrán por cuenta y cargo del cliente.Nuestro laboratorio no se responsabiliza por daños, robos o hurtos que sufirerern los instrumentos durante su traslado.', 'ISO-8859-1', 'UTF-8');
		$linea2=mb_convert_encoding('2-El retiro de los equipos deberá efectuarse dentro de los treinta (30) días corridos posteriores a la recepción de los mismos; o dentro de los diez (10) días corridos posteriores al aviso de finalizado el trabajo.(Lo que sea posterior).', 'ISO-8859-1', 'UTF-8');
		$linea3=mb_convert_encoding('Pasada la fecha correspondiente, se imputará un cargo en concepto de depósito (U$S 10+IVA por día por cada equipo). Pasados los 60 días corridos de esa fecha, los dispositivos quedarán a disponibilidad del laboratorio, sin derecho a reclamo alguno (Art. 2525 y 2526 Código Civil).', 'ISO-8859-1', 'UTF-8');
		$linea4=mb_convert_encoding('3 - Los equipos de medición que posean memorización de datos deberán entregarse con la memoria limpia, ya que en las tareas de calibración o mantenimiento, las mismas pueden ser eliminadas. En caso de que esto suceda, el laboratorio no se hará responsable por los datos perdidos.', 'ISO-8859-1', 'UTF-8');
		$linea5=mb_convert_encoding('4 - Los equipos recibidos, serán chequeados y cotizados en un plazo no mayor a los 7 días hábiles, en los casos que por razones de fuerza mayor no sea posible, será enivada una nota especificando las condiciones en las que se encuentra el instrumental en el laboratorio.', 'ISO-8859-1', 'UTF-8');
		
		$this->SetXY(18,$y+5);
		$this->Cell(180,52,'',1,0,'L');
		$this->SetFont('Arial','',8);
		$this->SetXY(20,$y+7);
		$this->MultiCell(178,4,$linea1,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea2,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea3,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea4,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea5,0,'L',false);
		
		//Cuadro recepcion de equipo
		$y = $y+60;
		$recep_titulo=mb_convert_encoding('Recepción del Equipo', 'ISO-8859-1', 'UTF-8');
		$this->SetXY(18,$y);
		$this->Cell(180,44,'',1,0,'L');
		$this->SetFont('Arial','B',10);
		$this->SetXY(20,$y+4);
		$this->Cell(0,0,$recep_titulo,0,1,'L');	

		$this->SetFont('Arial','',10);
		$this->SetXY(21,$y+10);
		$this->Cell(0,0,'Entregado por:',0,1,'L');	
		$this->SetXY(50,$y+13);
		$this->Cell(50,5,'Firma','T',1,'C');
		$this->SetXY(120,$y+13);
		$this->Cell(60,5,mb_convert_encoding('Aclaración', 'ISO-8859-1', 'UTF-8'),'T',1,'C');
		
		
		$this->SetXY(21,$y+25);
		$this->Cell(0,0,'Retirado por:',0,1,'L');
		$this->SetXY(50,$y+28);
		$this->Cell(50,5,'Firma','T',1,'C');
		$this->SetXY(120,$y+28);
		$this->Cell(60,5,mb_convert_encoding('Aclaración', 'ISO-8859-1', 'UTF-8'),'T',1,'C');		

		$this->SetXY(21,$y+40);
		$this->Cell(0,0,'Fecha de retiro:',0,1,'L');
		$this->SetXY(50,$y+38);
		$this->Cell(50,5,'__/__/____','0',1,'L');
		$this->SetXY(120,$y+38);
		$this->Cell(60,5,mb_convert_encoding('Forma de Pago:', 'ISO-8859-1', 'UTF-8'),'0',1,'L');		
		
		//Info consulta
		$this->SetFont('Arial','U',8);
		$this->SetXY(18,$y+46);
		$this->Cell(0,0,mb_convert_encoding('Horario de atención:', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		$this->SetFont('Arial','',8);
		$this->SetXY(50,$y+46);
		$this->Cell(0,0,mb_convert_encoding('Lunes a Viernes de 09:00 a 17:00 hs.', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		$this->SetFont('Arial','U',8);
		$this->SetXY(120,$y+46);
		$this->Cell(0,0,mb_convert_encoding('Consultas:', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		$this->SetFont('Arial','',8);
		$this->SetXY(135,$y+46);
		$this->Cell(0,0,mb_convert_encoding('(011) 4218-5675', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	


			break;

		case "2":	
		$cm = new ConfigurationManager();
		$infocotizacion = $cm->getCotizacion($nrocotizacion);
		$paramsempresa = $cm->getParametros($infocotizacion['idempresa']);

		$footer_leyenda="Alquiler, mantenimiento, reparación, calibración y contraste de instrumentos de medición en ambiente laboral, salud ocupacional y medio ambiente";
		$footer_telefono='Teléfono: '.$paramsempresa['telefono_empresa'];
		$footer_email='Email: '.$paramsempresa['email_empresa'];

		$this->SetFont('Arial','',11);
		$this->SetXY(15,270);
		$this->Line(15,270,196,270);
		$this->SetXY(15,272);
		$this->SetTextColor(128);
		$this->MultiCell(181,4,$footer_leyenda,0,'C',false);
		$this->SetXY(15,290);
		$this->Cell(181,0,$footer_telefono,'0',1,'L');
		$this->SetXY(15,290);
		$this->Cell(181,0,$footer_email,'0',1,'R');	
		


			break;			
	}
		
	}	

	
	function DetalleCotizacion($nrocotizacion)
	{
				$cm = new ConfigurationManager();
				$infocotizacion = $cm->getCotizacion($nrocotizacion);
				$paramsempresa = $cm->getParametros($infocotizacion['idempresa']);		
				$head_titref="Ref: ".$infocotizacion['referencia'];
				
				$lugar = mb_convert_encoding($paramsempresa['lugarcotizacion'], 'ISO-8859-1', 'UTF-8');
		
				$fecha = fecha_texto($infocotizacion['fechacotizacion']);
				
				$cliente = strtoupper($infocotizacion['nombrecli']);
				$contacto = $infocotizacion['idcontacto']==0 ? $infocotizacion['contactoppal']:$infocotizacion['nombrecon'];
				$encabezado = mb_convert_encoding($infocotizacion['encabezado'], 'ISO-8859-1', 'UTF-8');
				$condicionescomerciales = mb_convert_encoding($infocotizacion['condicionescomerciales'], 'ISO-8859-1', 'UTF-8');
		
			//titulos Tabla Cotizacion
				$cuad_tititem="ITEM";
				$cuad_titcantidad="Cantidad";		
				$cuad_titdescripcion="Descripción";
				$cuad_titprecio="Precio $";
				$cuad_tittotal="Total $";
				$cuad_tittotalfinal="Total: ";

		
			    $this->SetTextColor(0);
				$this->SetXY(15,43);
				$this->Cell(180,0,$lugar.', '.$fecha,0,1,'R');
		
				$this->SetXY(15,48);
				$this->Cell(180,0,$head_titref,0,1,'R');

				$this->SetFont('Arial','B',14);		
				$this->SetXY(15,55);
				$this->Cell(180,0,$cliente,0,1,'L');
				$this->SetFont('Arial','B',12);		
				$this->SetXY(15,60);
				$this->Cell(180,0,'Att: '.$contacto,0,1,'L');

				$this->SetFont('Arial','',11);		
				$this->SetXY(17,70);
				$this->WriteHTML($encabezado);
		
		//Titulos de tabla de cotizacion
			$y = 82;
			$this->SetFont('Arial','',11);
			$this->SetXY(15,$y);
			$this->Cell(180,8,'',1,0,'L');
			$this->SetXY(18,$y);
			$this->Cell(20,8,$cuad_tititem,'R',1,'C');
			$this->SetXY(40,$y);
			$this->Cell(20,8,$cuad_titcantidad,'R',1,'C');
			$this->SetXY(62,$y);
			$this->Cell(90,8,mb_convert_encoding($cuad_titdescripcion, 'ISO-8859-1', 'UTF-8'),'R',1,'C');
			$this->SetXY(152,$y);
			$this->Cell(18,8,$cuad_titprecio,'R',1,'C');
			$this->SetXY(173,$y);
			$this->Cell(20,8,$cuad_tittotal,'',1,'C');

		$cm = new ConfigurationManager();
		$resultado = $cm->getCotizacionDetalle($nrocotizacion);
		$eq = 1;
		$totalgral=0;
		while ($row=$resultado->fetch_array()){ 
		if($eq % 8 == 0 ){$this->addPage('P','A4'); $y=43; $eq=0;}
			$h = 26;
			$y = $y + 8;
			$totalline = ($row[6]==0) ? '$'.number_format(($row[3]*$row[4]),2,',','.'):'Bonificado';
			$totalgral = ($row[6]==0) ? $totalgral + ($row[3]*$row[4]): $totalgral;
			$this->SetXY(15,$y);
			$this->Cell(180,$h,'',1,0,'L');
			$this->SetXY(18,$y);
			$this->Cell(20,$h,$row[1],'R',1,'C');
			$this->SetXY(40,$y);
			$this->Cell(20,$h,$row[3],'R',1,'C');
			$this->SetXY(60,$y+2);
			//$this->MultiCell(90,8,utf8_decode($row[3]),'R',1,'C');
			$this->MultiCell(92,4,mb_convert_encoding($row[2], 'ISO-8859-1', 'UTF-8'),0,'L',false);
			$this->SetXY(152,$y);
			$this->Cell(18,$h,'$'.number_format($row[4],2,',','.'),'L R',1,'C');
			$this->SetXY(173,$y);
			$this->Cell(20,$h,$totalline,'',1,'C');	
			$y = $y + $h - 8;
			$eq++;
		}
			$y = $y+8;
			$this->SetFont('Arial','B',11);
			$this->SetXY(60,$y);
			$this->Cell(92,8,$cuad_tittotalfinal,1,0,'R');
			$this->SetXY(152,$y);
			$this->Cell(43,8,'$'.number_format($totalgral,2,',','.'),1,0,'C');

			$this->SetXY(25,$y+16);			
			$this->SetFont('Arial','',11);
			$this->WriteHTML($condicionescomerciales);
		
	}
	function DetalleIngreso($nroingreso)	
	{
		//$this->SetAutoPageBreak(true,130);
				//titulos cuadro equipos
		$equip_titulo="Equipos recibidos:";
		$equip_titmarca="MARCA";
		$equip_titmodelo="MODELO";
		$equip_titnroserie="Nro DE SERIE";
		$equip_titcalibra="Cal.";
		$equip_titrepara="Rep.";
		$equip_titcosto="Costo Inicial";
		
		$equip_titcertif="Certificado a nombre de: ";
		$equip_titaccesorios="Accesorios: ";
		
		$this->SetFont('Arial','B',11);
		$this->SetXY(18,52);
		$this->Cell(0,0,$equip_titulo,0,1,'L');
		
		$y=55;		

		$cm = new ConfigurationManager();
		$resultado = $cm->getIngresoDetalle($nroingreso);
		$eq = 1;
		while ($row=$resultado->fetch_array()){ 
		$infoequipo = $cm->getEquipo($row['idequipo']);
		if($eq % 4 == 0 ){$this->addPage('P','Legal'); $y=55;}


		$this->SetFont('Arial','',11);
		$this->SetXY(18,$y);
		$this->Cell(180,8,'',1,0,'L');
		$this->SetXY(18,$y);
		$this->Cell(42,8,$equip_titmarca,'R',1,'C');
		$this->SetXY(60,$y);
		$this->Cell(42,8,$equip_titmodelo,'L R',1,'C');
		$this->SetXY(102,$y);
		$this->Cell(42,8,$equip_titnroserie,'L R',1,'C');
		$this->SetXY(144,$y);
		$this->Cell(15,8,$equip_titcalibra,'L R',1,'C');
		$this->SetXY(159,$y);
		$this->Cell(15,8,$equip_titrepara,'L R',1,'C');
		$this->SetXY(174,$y);
		$this->Cell(24,8,$equip_titcosto,'L ',1,'C');
			
			
		$this->SetXY(18,$y+8);
		$this->Cell(42,8,$infoequipo['marca'],'1',1,'C');
		$this->SetXY(60,$y+8);
		$this->Cell(42,8,$infoequipo['modelo'],'1',1,'C');	
		$this->SetXY(102,$y+8);
		$this->Cell(42,8,$infoequipo['nroserie'],'1',1,'C');	
		
		if($row['calibra']){$calibra='SI';}else{$calibra='NO';}	
		if($row['repara']){$repara='SI';}else{$repara='NO';}	

		$this->SetXY(144,$y+8);
		$this->Cell(15,8,$calibra,'1',1,'C');
		$this->SetXY(159,$y+8);
		$this->Cell(15,8,$repara,'1',1,'C');
		$this->SetXY(174,$y+8);
		$this->Cell(24,8,'','1',1,'C');
		$this->SetXY(18,$y+16);
		$this->Cell(84,42,'','1',1,'C');
		$this->Image('./images/laboratorio/'.$row['imagen'],40,$y+20,30);
		$this->SetXY(102,$y+16);	
		$this->Cell(42,42,'','1',1,'C');
		$this->SetXY(144,$y+16);	
		$this->Cell(54,42,'','1',1,'C');	
	
		if ($row['cargador']){$accesorios='Cargador';
		$this->SetXY(104,$y);
		$this->Cell(42,42,$accesorios,0,1,'L');			
					} 
		if($row['valija']){$accesorios='Valija';
		$this->SetXY(104,$y+4);
		$this->Cell(42,42,$accesorios,0,1,'L');
		}
		if($row['interfase']){$accesorios='Interfase';
				$this->SetXY(104,$y+8);
		$this->Cell(42,42,$accesorios,0,1,'L');		   
				   }
		if($row['bomba']){$accesorios='Bomba';
		$this->SetXY(104,$y+12);
		$this->Cell(42,42,$accesorios,0,1,'L');		   
		}
		if($row['copa']){$accesorios= mb_convert_encoding('Copa Calibración', 'ISO-8859-1', 'UTF-8');
		$this->SetXY(104,$y+16);
		$this->Cell(42,42,$accesorios,0,1,'L');		   
		}
		if($row['baterias']){$accesorios=mb_convert_encoding('Baterías', 'ISO-8859-1', 'UTF-8');
		$this->SetXY(104,$y+20);
		$this->Cell(42,42,$accesorios,0,1,'L');		   					 
		}	
	
			$find=array('&ordm;','&nbsp;');
			$repl=array('°',' ');
		$observaciones = mb_convert_encoding(strip_tags(str_replace($find,$repl,$row['observaciones'])), 'ISO-8859-1', 'UTF-8');
		$this->SetXY(146,$y+20);	
		$this->MultiCell(54,4,$observaciones,0,'L',false);	
		$eq++;	
		$y = $y+58;	
		}

	}
	
	
	function FormIngreso($nroingreso)
	{
		//titulos primera linea del formulario
		$head_title="FORMULARIO DE INGRESO";
		$head_titnro="Nro: ";
		$head_titfech="FECHA: ";
		
		//titulos del cuadro cabecera
		$cuad_titempresa="Empresa: ";
		$cuad_titcliente="Cliente: ";		
		$cuad_titnrotel="Nro de tel: ";
		$cuad_titdomicilio="Domicilio: ";
		$cuad_titcontacto="Contacto: ";
		$cuad_titemail="E-mail: ";
		$cuad_titcuit="Nro C.U.I.T: ";
		
		
		$cm = new ConfigurationManager();
		$infoingreso = $cm->getIngreso($nroingreso);
		$infoempresa = $cm->getEmpresa($infoingreso[2]);
		$infocliente = $cm->getCliente($infoingreso[3]);

		//Armado del formulario
		$this->SetFont('Arial','B',14);
		$this->SetXY(85,10);
		$this->Cell(0,0,$infoempresa[3],0,1,'L');
		
		$this->SetXY(18,18);
		$this->Cell(0,0,$head_title,0,1,'L');
		$this->SetXY(90,18);
		$this->Cell(0,0,$head_titnro.$nroingreso,0,1,'L');
		$this->SetFont('Arial','',12);
		$this->SetXY(150,18);
		$fecha = date('d-m-Y',strtotime($infoingreso[1]));
		$this->Cell(0,0,$head_titfech.$fecha,0,1,'L');
		
		
		$this->SetFont('Arial','',11);
		
		$this->SetXY(18,22);
		$this->Cell(180,26,'',1,0,'L');

		$this->SetXY(20,28);
		$this->Cell(0,0,$cuad_titempresa.$infocliente[3],0,1,'L');
		
		if ($infoingreso[4]==0) //si no se selecciono un contaco en particular 
		{   
			$contacto = $infocliente[11];
			$nrotel = $infocliente[9];
			$email = $infocliente[12];
			$domicilio = $infocliente[5];
		}
		else
		{   
			$infocontacto = $cm->getContacto($infoingreso[4]);
			$contacto = $infocontacto[1];
			$nrotel = $infocontacto[3];
			$email = $infocontacto[4];
			$domicilio = $infocontacto[5];
		}
		
		$this->SetXY(110,28);
		$this->Cell(0,0,$cuad_titcontacto.$contacto,0,1,'L');
		

		$this->SetXY(20,36);
		$this->Cell(0,0,$cuad_titnrotel.$nrotel,0,1,'L');
				
		$this->SetXY(110,36);
		$this->Cell(0,0,$cuad_titemail.$email,0,1,'L');
		
		$this->SetXY(20,44);
		$this->Cell(0,0,$cuad_titdomicilio.$domicilio,0,1,'L');
				
		$this->SetXY(110,44);
		$this->Cell(0,0,$cuad_titcuit.$infocliente[2],0,1,'L');
		
		$this->SetFont('Arial','B',11);
		$this->SetXY(18,52);
		$this->Cell(0,0,$equip_titulo,0,1,'L');
		
		
		$y=55;
		$resultado = $cm->getIngresoDetalle($nroingreso);
		while ($row=$resultado->fetch_array()){ 
		$infoequipo = $cm->getEquipo($row[2]);

		$this->SetFont('Arial','',11);
		$this->SetXY(18,$y);
		$this->Cell(180,8,'',1,0,'L');
		$this->SetXY(18,$y);
		$this->Cell(42,8,$equip_titmarca,'R',1,'C');
		$this->SetXY(60,$y);
		$this->Cell(42,8,$equip_titmodelo,'L R',1,'C');
		$this->SetXY(102,$y);
		$this->Cell(42,8,$equip_titnroserie,'L R',1,'C');
		$this->SetXY(144,$y);
		$this->Cell(15,8,$equip_titcalibra,'L R',1,'C');
		$this->SetXY(159,$y);
		$this->Cell(15,8,$equip_titrepara,'L R',1,'C');
		$this->SetXY(174,$y);
		$this->Cell(24,8,$equip_titcosto,'L ',1,'C');
			
			
		$this->SetXY(18,$y+8);
		$this->Cell(42,8,$infoequipo[14],'1',1,'C');
		$this->SetXY(60,$y+8);
		$this->Cell(42,8,$infoequipo[19],'1',1,'C');	
		$this->SetXY(102,$y+8);
		$this->Cell(42,8,$infoequipo[5],'1',1,'C');	
		
		if($row[3]){$calibra='SI';}else{$calibra='NO';}	
		if($row[4]){$repara='SI';}else{$repara='NO';}	

		$this->SetXY(144,$y+8);
		$this->Cell(15,8,$calibra,'1',1,'C');
		$this->SetXY(159,$y+8);
		$this->Cell(15,8,$repara,'1',1,'C');
		$this->SetXY(174,$y+8);
		$this->Cell(24,8,'','1',1,'C');
		$this->SetXY(18,$y+16);
		$this->Cell(84,42,'','1',1,'C');
		$this->Image('./images/laboratorio/'.$row[12],40,$y+20,30);
		$this->SetXY(102,$y+16);	
		$this->Cell(42,42,'','1',1,'C');
		$this->SetXY(144,$y+16);	
		$this->Cell(54,42,'','1',1,'C');	
	
		if ($row[5]){$accesorios='Cargador';
		$this->SetXY(104,$y);
		$this->Cell(42,42,$accesorios,0,1,'L');			
					} 
		if($row[6]){$accesorios='Valija';
		$this->SetXY(104,$y+4);
		$this->Cell(42,42,$accesorios,0,1,'L');
		}
		if($row[7]){$accesorios='Interfase';
				$this->SetXY(104,$y+8);
		$this->Cell(42,42,$accesorios,0,1,'L');		   
				   }
		if($row[8]){$accesorios='Bomba';
		$this->SetXY(104,$y+12);
		$this->Cell(42,42,$accesorios,0,1,'L');		   
		}
		if($row[9]){$accesorios= mb_convert_encoding('Copa Calibración', 'ISO-8859-1', 'UTF-8');
		$this->SetXY(104,$y+16);
		$this->Cell(42,42,$accesorios,0,1,'L');		   
		}
		if($row[10]){$accesorios=mb_convert_encoding('Baterías', 'ISO-8859-1', 'UTF-8');
		$this->SetXY(104,$y+20);
		$this->Cell(42,42,$accesorios,0,1,'L');		   					 
		}	
	
		$observaciones = mb_convert_encoding(strip_tags($row[13]), 'ISO-8859-1', 'UTF-8');
		$this->SetXY(146,$y+20);	
		$this->MultiCell(54,4,$observaciones,0,'L',false);	
			
		$y = $y+58;	
		}
			
		//Cuadro con información de gastos y otras yerbas
		
		$linea1=mb_convert_encoding('1-Los gastos de traslado del equipo correrán por cuenta y cargo del cliente.Nuestro laboratorio no se responsabiliza por daños, robos o hurtos que sufirerern los instrumentos durante su traslado.', 'ISO-8859-1', 'UTF-8');
		$linea2=mb_convert_encoding('2-El retiro de los equipos deberá efectuarse dentro de los treinta (30) días corridos posteriores a la recepción de los mismos; o dentro de los diez (10) días corridos posteriores al aviso de finalizado el trabajo.(Lo que sea posterior).', 'ISO-8859-1', 'UTF-8');
		$linea3=mb_convert_encoding('Pasada la fecha correspondiente, se imputará un cargo en concepto de depósito (U$S 10+IVA por día por cada equipo). Pasados los 60 días corridos de esa fecha, los dispositivos quedarán a disponibilidad del laboratorio, sin derecho a reclamo alguno (Art. 2525 y 2526 Código Civil).', 'ISO-8859-1', 'UTF-8');
		$linea4=mb_convert_encoding('3 - Los equipos de medición que posean memorización de datos deberán entregarse con la memoria limpia, ya que en las tareas de calibración o mantenimiento, las mismas pueden ser eliminadas. En caso de que esto suceda, el laboratorio no se hará responsable por los datos perdidos.', 'ISO-8859-1', 'UTF-8');
		$linea5=mb_convert_encoding('4 - Los equipos recibidos, serán chequeados y cotizados en un plazo no mayor a los 7 días hábiles, en los casos que por razones de fuerza mayor no sea posible, será enivada una nota especificando las condiciones en las que se encuentra el instrumental en el laboratorio.', 'ISO-8859-1', 'UTF-8');
		
		$this->SetXY(18,$y+5);
		$this->Cell(180,52,'',1,0,'L');
		$this->SetFont('Arial','',8);
		$this->SetXY(20,$y+7);
		$this->MultiCell(178,4,$linea1,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea2,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea3,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea4,0,'L',false);
		$this->SetX(20);
		$this->MultiCell(178,4,$linea5,0,'L',false);
		
		//Cuadro recepcion de equipo
		$y = $y+60;
		$recep_titulo=mb_convert_encoding('Recepción del Equipo', 'ISO-8859-1', 'UTF-8');
		$this->SetXY(18,$y);
		$this->Cell(180,44,'',1,0,'L');
		$this->SetFont('Arial','B',10);
		$this->SetXY(20,$y+4);
		$this->Cell(0,0,$recep_titulo,0,1,'L');	

		$this->SetFont('Arial','',10);
		$this->SetXY(21,$y+10);
		$this->Cell(0,0,'Entregado por:',0,1,'L');	
		$this->SetXY(50,$y+13);
		$this->Cell(50,5,'Firma','T',1,'C');
		$this->SetXY(120,$y+13);
		$this->Cell(60,5,mb_convert_encoding('Aclaración', 'ISO-8859-1', 'UTF-8'),'T',1,'C');
		
		
		$this->SetXY(21,$y+25);
		$this->Cell(0,0,'Retirado por:',0,1,'L');
		$this->SetXY(50,$y+28);
		$this->Cell(50,5,'Firma','T',1,'C');
		$this->SetXY(120,$y+28);
		$this->Cell(60,5,mb_convert_encoding('Aclaración', 'ISO-8859-1', 'UTF-8'),'T',1,'C');		

		$this->SetXY(21,$y+40);
		$this->Cell(0,0,'Fecha de retiro:',0,1,'L');
		$this->SetXY(50,$y+38);
		$this->Cell(50,5,'__/__/____','0',1,'L');
		$this->SetXY(120,$y+38);
		$this->Cell(60,5,mb_convert_encoding('Forma de Pago:', 'ISO-8859-1', 'UTF-8'),'0',1,'L');		
		
		//Info consulta
		$this->SetFont('Arial','U',8);
		$this->SetXY(18,$y+46);
		$this->Cell(0,0,mb_convert_encoding('Horario de atención:', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		$this->SetFont('Arial','',8);
		$this->SetXY(50,$y+46);
		$this->Cell(0,0,mb_convert_encoding('Lunes a Viernes de 09:00 a 17:00 hs.', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		$this->SetFont('Arial','U',8);
		$this->SetXY(120,$y+46);
		$this->Cell(0,0,mb_convert_encoding('Consultas:', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		$this->SetFont('Arial','',8);
		$this->SetXY(135,$y+46);
		$this->Cell(0,0,mb_convert_encoding('(011) 4218-5675', 'ISO-8859-1', 'UTF-8'),'0',1,'L');	
		
		
	}

	
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
    // Intérprete de HTML
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Etiqueta
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extraer atributos
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Etiqueta de apertura
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR'|| $tag=='P')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Etiqueta de cierre
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
	if($tag=='P')
        $this->Ln(5);
}

function SetStyle($tag, $enable)
{
    // Modificar estilo y escoger la fuente correspondiente
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}	
}
// Limpia el búfer de salida antes de generar el PDF


?>
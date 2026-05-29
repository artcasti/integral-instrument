<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

date_default_timezone_set('America/Buenos_Aires');

/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
// Create new PHPExcel object
require_once("clases.php");
$cm = new ConfigurationManager();

if(isset($_GET['seccion']))
{
	$filtro = (isset($_GET['filtro']))?$_GET['filtro']:0;

$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("SoftLab")
							 ->setLastModifiedBy("SoftLab")
							 ->setTitle("Descarga de consultas SoftLab")
							 ->setSubject("Descarga de consultas SoftLab")
							 ;	
	
	switch($_GET['seccion']){
		case "equipos":
			
	
		
		// Armo los titulos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nombre')
            ->setCellValue('B1', 'Familia')
            ->setCellValue('C1', 'Subfamilia')
            ->setCellValue('D1', 'Marca')
			->setCellValue('E1', 'Modelo')
			->setCellValue('F1', 'Nro de Serie');
		//Estilo a los titulos
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
				$resultado = $cm->getListaEquipos($filtro);	
			//var_dump($resultado);
			//die();
			$i=2;
			while ($row=$resultado->fetch_array()){ 
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $row['nombre']); 
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $row['familia']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $row['subfamilia']);							  
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $row['marca']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $row['modelo']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $row['nroserie']);
				$i++;
				}
			// Renombro la hoja de trabajo
			$objPHPExcel->getActiveSheet()->setTitle('Equipos');		
			$nombre='Equipos_'.date('Ymd').'.xlsx';
		break;
		case "clientes":
			
	
		
		// Armo los titulos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tipo Documento')
            ->setCellValue('B1', 'Nro Documento')
            ->setCellValue('C1', 'Nombre/Razón Social')
            ->setCellValue('D1', 'Condición IVA')
			->setCellValue('E1', 'Domicilio')
			->setCellValue('F1', 'Localidad')
			->setCellValue('G1', 'Provincia')
			->setCellValue('H1', 'Pais')
			->setCellValue('I1', 'Cod Postal')	
			->setCellValue('J1', 'Telefono')
			->setCellValue('K1', 'Contacto Principal')
			->setCellValue('L1', 'Email')
			->setCellValue('M1', 'Clasificación')
			->setCellValue('N1', 'Observaciones')	
				;
		//Estilo a los titulos
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
				$resultado = $cm->getListaClientes($filtro);	

			if($resultado)
			{	
			$i=2;
			while ($row=$resultado->fetch_array()){ 
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $row['tipodocumento']); 
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $row['nrodoc']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $row['nombre']);							  
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $row['condiva']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $row['domicilio']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $row['localidad']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $row['provincia']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $row['pais']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $row['cpostal']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $row['telefono']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $row['contactoppal']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $row['email']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $row['clasificacion']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $row['observaciones']);
				$i++;
				}
			}	
			// Renombro la hoja de trabajo
			$objPHPExcel->getActiveSheet()->setTitle('Clientes');		
			$nombre='Clientes_'.date('Ymd').'.xlsx';
		break;

	}






// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nombre.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Tue, 18 Oct 1977 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
}else
{	
exit;
}	
?>
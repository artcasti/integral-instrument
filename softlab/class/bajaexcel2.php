<?php
date_default_timezone_set('America/Buenos_Aires');

require 'vendor/autoload.php'; // Asegúrate de que el autoload de Composer esté incluido
// Incluir las clases necesarias de PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



require_once("clases.php");

$cm = new ConfigurationManager();

if (isset($_GET['seccion'])) {
    $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : 0;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Configurar propiedades del documento
    $spreadsheet->getProperties()->setCreator("SoftLab")
                                 ->setLastModifiedBy("SoftLab")
                                 ->setTitle("Descarga de consultas SoftLab")
                                 ->setSubject("Descarga de consultas SoftLab");

    switch ($_GET['seccion']) {
        case "equipos":
            // Armar los títulos
            $sheet->setCellValue('A1', 'Nombre')
                  ->setCellValue('B1', 'Familia')
                  ->setCellValue('C1', 'Subfamilia')
                  ->setCellValue('D1', 'Marca')
                  ->setCellValue('E1', 'Modelo')
                  ->setCellValue('F1', 'Nro de Serie');

            // Estilo a los títulos
            $sheet->getStyle('A1:F1')->getFont()->setBold(true);

            $resultado = $cm->getListaEquipos($filtro);

            $i = 2;
            while ($row = $resultado->fetch_array()) {
                $sheet->setCellValue('A' . $i, $row['nombre']);
                $sheet->setCellValue('B' . $i, $row['familia']);
                $sheet->setCellValue('C' . $i, $row['subfamilia']);
                $sheet->setCellValue('D' . $i, $row['marca']);
                $sheet->setCellValue('E' . $i, $row['modelo']);
                $sheet->setCellValue('F' . $i, $row['nroserie']);
                $i++;
            }

            // Renombrar la hoja de trabajo
            $sheet->setTitle('Equipos');
            $nombre = 'Equipos_' . date('Ymd') . '.xlsx';
            break;

        case "clientes":
            // Armar los títulos
            $sheet->setCellValue('A1', 'Tipo Documento')
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
                  ->setCellValue('N1', 'Observaciones');

            // Estilo a los títulos
            $sheet->getStyle('A1:N1')->getFont()->setBold(true);

            $resultado = $cm->getListaClientes($filtro);

            if ($resultado) {
                $i = 2;
                while ($row = $resultado->fetch_array()) {
                    $sheet->setCellValue('A' . $i, $row['tipodocumento']);
                    $sheet->setCellValue('B' . $i, $row['nrodoc']);
                    $sheet->setCellValue('C' . $i, $row['nombre']);
                    $sheet->setCellValue('D' . $i, $row['condiva']);
                    $sheet->setCellValue('E' . $i, $row['domicilio']);
                    $sheet->setCellValue('F' . $i, $row['localidad']);
                    $sheet->setCellValue('G' . $i, $row['provincia']);
                    $sheet->setCellValue('H' . $i, $row['pais']);
                    $sheet->setCellValue('I' . $i, $row['cpostal']);
                    $sheet->setCellValue('J' . $i, $row['telefono']);
                    $sheet->setCellValue('K' . $i, $row['contactoppal']);
                    $sheet->setCellValue('L' . $i, $row['email']);
                    $sheet->setCellValue('M' . $i, $row['clasificacion']);
                    $sheet->setCellValue('N' . $i, $row['observaciones']);
                    $i++;
                }
            }

            // Renombrar la hoja de trabajo
            $sheet->setTitle('Clientes');
            $nombre = 'Clientes_' . date('Ymd') . '.xlsx';
            break;
    }

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirigir la salida al navegador del cliente como un archivo de Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombre . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');

    // Si estás sirviendo a IE sobre SSL, entonces se podrían necesitar estas líneas
    header('Expires: Tue, 18 Oct 1977 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    exit;
}
?>

<?php
require_once __DIR__ . "/../init.php";
include_once SITE_ROOT . '/MVC/Modelo/SAdminDaoImp.php';
include_once SITE_ROOT . '/recurso/Classes/PHPExcel.php';
include_once SITE_ROOT . '/recurso/Classes/PHPExcel/Cell.php';
include_once SITE_ROOT . '/recurso/Classes/PHPExcel/IOFactory.php';
include_once SITE_ROOT . '/recurso/Classes/PHPExcel/Reader/Excel2007.php';
include_once SITE_ROOT . '/files_excel/Excel_OUT.php';

// Cambios
$datos = json_decode($_POST["datos"], TRUE);
$op = strtoupper($datos["op"]);
$doc = strtoupper($datos["doc"]);

$Firma = array(
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => PHPExcel_Style_Color::COLOR_WHITE)
        )
    )
);

switch ($op) {
    case "REPORTCONTRIB":
        session_start();
        $objReader = new PHPExcel_Reader_Excel2007();
        $nameDoc = "Reporte Contribuyentes";

        switch ($doc) {
            case "DES":
                $params = array(
                    "inicio" => $datos["fechas"]["inicio"],
                    "fin" => $datos["fechas"]["fin"]
                );
                $objPHPExcel = $objReader->load("../files_excel/Documentos/DescuentoContrib.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $fila = 8;
                $num_row = 1;
                $totalrec = 0;
                $datos = SAdminDaoImp::_listContribDesc($params);
                $totalgen = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["cedula"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["ciu"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["nombre"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["direccion"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["telefono"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["email"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["nguias"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $row["fecharegdesc"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $row["descripcion_descuento"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $fila, $row["porcentaje"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $row["guiadescuento"]);
                    $fila++;
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, "Reporte desde " . date_format(date_create($params["inicio"]), 'Y-m-d') . " - Hasta " . date_format(date_create($params["fin"]), 'Y-m-d') . "");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, date('Y-m-d'));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Reporte de Contribuyentes con descuento");
                out_excel("file", $objPHPExcel, $nameDoc);
                break;
            case "TODO":
            
                $objPHPExcel = $objReader->load("../files_excel/Documentos/Contribuyentes.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $fila = 8;
                $num_row = 1;
                $totalrec = 0;
                $datos = SAdminDaoImp::_listContrib();
                $totalgen = 0;
                foreach ($datos as $row) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["cedula"]);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["ciu"]);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["nombre"]);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["direccion"]);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["guias"]);                        
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["porcentdesc"]);
                    $fila++;
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, date('Y-m-d'));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Reporte de Contribuyentes");
                out_excel("file", $objPHPExcel, $nameDoc);
                break;
                
                
//                $objPHPExcel = $objReader->load("../files_excel/Documentos/Contribuyentes.xlsx");
//                $objPHPExcel->setActiveSheetIndex(0);
//                $fila = 8;
//                $num_row = 1;
//                $totalrec = 0;
//                $datos = SAdminDaoImp::_listContrib();
//                $totalgen = 0;
//                foreach ($datos as $row) {
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["cedula"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["ciu"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["nombre"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["direccion"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["telefono"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["email"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["guias"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $row["descuento"]);
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $row["porcentdesc"]);
//                    $fila++;
//                }
//                //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,4, "Reporte desde " . date_format(date_create($params["inicio"]), 'Y-m-d') . " - Hasta " . date_format(date_create($params["fin"]), 'Y-m-d') . "");
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, date('Y-m-d'));
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Reporte de Contribuyentes");
//                out_excel("file", $objPHPExcel, $nameDoc);
//                break;
        }
    case "RECAUDXUSUARIO":
        session_start();
        $user = $_SESSION["login"]["user"];
        $objReader = new PHPExcel_Reader_Excel2007();
        $nameDoc = "Reporte Recaudacion";
        $params = array(
            "iduser" => $datos["idusuario"],
            "inicio" => $datos["fechas"]["inicio"],
            "fin" => $datos["fechas"]["fin"]
        );
        switch ($doc) {
            case "SI":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/RecaudacionUsuario.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $fila = 10;
                $num_row = 1;
                $totalrec = 0;
                $datos = SAdminDaoImp::_listRecaudxUser($params);
                $totalgen = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["nombres"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["PAGOMENSUAL"] != "" ? $row["PAGOMENSUAL"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["PAGODIRECTOJUICIO"] != "" ? $row["PAGODIRECTOJUICIO"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["ENTRADAJUICIO"] != "" ? $row["ENTRADAJUICIO"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["ABONOJUICIO"] != "" ? $row["ABONOJUICIO"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["DOCUMVARIOS"] != "" ? $row["DOCUMVARIOS"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["PERMISOCONEXION"] != "" ? $row["PERMISOCONEXION"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $row["CERTIFICADEUDAR"] != "" ? $row["CERTIFICADEUDAR"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $row["CAMBIOTUBERIA"] != "" ? $row["CAMBIOTUBERIA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $fila, $row["ACTIVACIONGUIA"] != "" ? $row["ACTIVACIONGUIA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $row["INACTIVACIONGUIA"] != "" ? $row["INACTIVACIONGUIA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $fila, $row["REIMPRESIONES"] != "" ? $row["REIMPRESIONES"] : 0);
                    //$totalindiv = floatval($row["PAGOMENSUAL"]) + floatval($row["PAGODIRECTOJUICIO"]) + floatval($row["ENTRADAJUICIO"]) + floatval($row["ABONOJUICIO"]) + floatval($row["DOCUMVARIOS"]) + floatval($row["PERMISOCONEXION"]) + floatval($row["CERTIFICADEUDAR"]) + floatval($row["CAMBIOTUBERIA"]) + floatval($row["ACTIVACIONGUIA"]) + floatval($row["INACTIVACIONGUIA"]) + floatval($row["REIMPRESIONES"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $row["TOTAL"] != "" ? $row["TOTAL"] : 0);
                    $totalindiv= $row["TOTAL"] != "" ? $row["TOTAL"] : 0;
                    $totalrec = $totalrec + $totalindiv;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $totalindiv);
                    $fila++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('C10:N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $desc = 0.60;
                $total = $totalrec > 0 ? $totalrec - $desc : 0;
                $TOTALREC = new PHPExcel_RichText();
                $objBold = $TOTALREC->createTextRun("TOTAL RECAUDADO");
                $objBold->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $TOTALREC);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $totalrec);
                if ($params["iduser"] == "") {
                    $DESCBANC = new PHPExcel_RichText();
                    $objBold = $DESCBANC->createTextRun("DESCUENTO POR DEPOSITO BANC.");
                    $objBold->getFont()->setBold(true);
                    $TOTAL = new PHPExcel_RichText();
                    $objBold = $TOTAL->createTextRun("TOTAL A DEPOSITAR");
                    $objBold->getFont()->setBold(true);
                    $fila = $fila + 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $DESCBANC);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $desc);

                    $fila = $fila + 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $TOTAL);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $total);
                }
                $fila = $fila + 2;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(12, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(13, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyle('N10:N' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 7, "Reporte desde " . date_format(date_create($params["inicio"]), 'Y-m-d') . " - Hasta " . date_format(date_create($params["fin"]), 'Y-m-d') . "");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 8, "Fecha  :  " . date('Y-m-d') . "");
                out_excel("file", $objPHPExcel, $nameDoc);
                break;
            case "DE":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/RecaudacionDesglo.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $fila = 10;
                $num_row = 1;
                $totalrec = 0;
                $datos = SAdminDaoImp::_listRecaudDesglo($params);
                $totalgen = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["PAGOMENSUAL"] != "" ? $row["PAGOMENSUAL"] : 0);
                    $fila = $fila + 2;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["COSTOFIJO"] != "" ? $row["COSTOFIJO"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["TARIFADEAGUA"] != "" ? $row["TARIFADEAGUA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["ALCANTARILLADO"] != "" ? $row["ALCANTARILLADO"] : 0);
                    $fila = $fila - 2;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["PAGODIRECTOJUICIO"] != "" ? $row["PAGODIRECTOJUICIO"] : 0);
                    $fila = $fila + 2;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["COSTOFIJOJ"] != "" ? $row["COSTOFIJOJ"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["TARIFADEAGUAJ"] != "" ? $row["TARIFADEAGUAJ"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["ALCANTARILLADOJ"] != "" ? $row["ALCANTARILLADOJ"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["COBRANZA"] != "" ? $row["COBRANZA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $row["MORA"] != "" ? $row["MORA"] : 0);
                    $fila = $fila - 2;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $row["ENTRADAJUICIO"] != "" ? $row["ENTRADAJUICIO"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $fila, $row["ABONOJUICIO"] != "" ? $row["ABONOJUICIO"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $row["DOCUMVARIOS"] != "" ? $row["DOCUMVARIOS"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $fila, $row["PERMISOCONEXION"] != "" ? $row["PERMISOCONEXION"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $fila, $row["CERTIFICADEUDAR"] != "" ? $row["CERTIFICADEUDAR"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $fila, $row["CAMBIOTUBERIA"] != "" ? $row["CAMBIOTUBERIA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $fila, $row["ACTIVACIONGUIA"] != "" ? $row["ACTIVACIONGUIA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $row["INACTIVACIONGUIA"] != "" ? $row["INACTIVACIONGUIA"] : 0);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $fila, $row["REIMPRESIONES"] != "" ? $row["REIMPRESIONES"] : 0);
                    $totalindiv = floatval($row["PAGOMENSUAL"]) + floatval($row["PAGODIRECTOJUICIO"]) + floatval($row["ENTRADAJUICIO"]) + floatval($row["ABONOJUICIO"]) + floatval($row["DOCUMVARIOS"]) + floatval($row["PERMISOCONEXION"]) + floatval($row["CERTIFICADEUDAR"]) + floatval($row["CAMBIOTUBERIA"]) + floatval($row["ACTIVACIONGUIA"]) + floatval($row["INACTIVACIONGUIA"]) + floatval($row["REIMPRESIONES"]);
                    $totalrec = $totalrec + $totalindiv;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $totalindiv);
                    $fila++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('B10:S' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $desc = 0.60;
                $total = $totalrec > 0 ? $totalrec - $desc : 0;
                $TOTALREC = new PHPExcel_RichText();
                $objBold = $TOTALREC->createTextRun("TOTAL RECAUDADO");
                $objBold->getFont()->setBold(true);

                if ($params["iduser"] == "") {
                    $DESCBANC = new PHPExcel_RichText();
                    $objBold = $DESCBANC->createTextRun("DESCUENTO POR DEPOSITO BANC.");
                    $objBold->getFont()->setBold(true);
                    $TOTAL = new PHPExcel_RichText();
                    $objBold = $TOTAL->createTextRun("TOTAL A DEPOSITAR");
                    $objBold->getFont()->setBold(true);
                    $fila = $fila + 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $DESCBANC);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $desc);

                    $fila = $fila + 1;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $TOTAL);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $fila, $total);
                }
                $fila = $fila + 2;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(16, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(17, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(18, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyle('S10:S' . $fila)->getNumberFormat()->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 7, "Reporte desde " . date_format(date_create($params["inicio"]), 'Y-m-d') . " - Hasta " . date_format(date_create($params["fin"]), 'Y-m-d') . "");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 8, "Fecha  :  " . date('Y-m-d') . "");
                out_excel("file", $objPHPExcel, $nameDoc);
                break;
        }
        break;
    case "REPORTE.INDIVIDUAL":
        session_start();
        $user = $_SESSION["login"]["user"];
        $objReader = new PHPExcel_Reader_Excel2007();
        $title = $objPHPExcel = NULL;
        $nameDoc = "";
        $params = array(
            "tipo" => $doc,
            "inicio" => $datos["fechas"]["inicio"],
            "fin" => $datos["fechas"]["fin"]
        );
        if (isset($datos["user"])) {
            $params["user"] = $user["id"];
        }
        $datos = SAdminDaoImp::_listDocumentos($params);
        switch ($doc) {
            case "IAG":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/ActivacionInactivacion.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte CA";
                $fila = 10;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $fila)->getCoordinate();
                $num_row = 1;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 7, $user["firma"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 8, date("Y-m-d"));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $total);
                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $fila)->getCoordinate();
                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $fila)->applyFromArray($Firma);
                break;
            case "CA":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/CertificadoAdeudar.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte CA";
                $title = "Reporte - Certificado de No Adeudar";
                $fila = 8;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $fila)->getCoordinate();
                $num_row = 1;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 7, $user["firma"]);
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 8, date("Y-m-d"));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $total);
                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $fila)->getCoordinate();
//                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
//                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $fila)->applyFromArray($Firma);
                break;
            case "RJ":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/RegistroJuicio.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $title = "Reporte - Registro Juicio";
                $nameDoc = "Reporte Registro JC";
                $fila = 8;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $fila)->getCoordinate();
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $row["num"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["fechainiciodeuda"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["fechafindeuda"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["deuda"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["entrada"]);
                    $total += floatval($row["entrada"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $total);
                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $fila)->getCoordinate();
                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $fila)->applyFromArray($Firma);
                break;
            case "AJ":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/ConveniosAbono.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte Convenio Abono";
                $title = "Reporte - Abonos Juicio";
                $fila = 8;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $row["num"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["valor"]);
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $fila)->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $total);
                $fila += 4;

//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $fila)->applyFromArray($Firma);
                break;
            case "PC":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/PermisoConexion.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte Permiso Conexion";
                $title = "Reporte - Permiso de Conexión";
                $fila = 8;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $fila)->getCoordinate();
                $num_row = 1;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["tipoConexion"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $total);

                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $fila)->getCoordinate();
//                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
//                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $fila)->applyFromArray($Firma);
                break;
            case "CT":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/ConexionTuberia.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte Conexión Tuberia";
                $fila = 10;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $fila)->getCoordinate();
                $num_row = 1;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["tipoConexion"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 7, $user["firma"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 8, date("Y-m-d"));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $total);

                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $fila)->getCoordinate();
                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $fila)->applyFromArray($Firma);
                break;
            /*case "PA":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/PermisoAlcantarillado.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte Permiso Alcantarillado";
                $fila = 10;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $fila)->getCoordinate();
                $num_row = 1;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 7, $user["firma"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 8, date("Y-m-d"));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $total);
                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $fila)->getCoordinate();
                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $fila)->applyFromArray($Firma);
                break;*/
            case "RI":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/Reimpresion.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte ReImpresion";
                $title = "Reporte - Reporte ReImpresion";
                $fila = 8;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $fila)->getCoordinate();
                $num_row = 1;
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $num_row++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["codDocumento"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["tipo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["fechaDocumento"]);
                    
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["reimpresion"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $total);
                $fila += 4;
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $fila)->applyFromArray($Firma);

                break;
            case "PM":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/PagoMensual.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte Pagos Mensuales";
                $title = "Reporte - Pago Mensual";
                $fila = 8;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $fila)->getCoordinate();

                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $row["num"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["ccaapp"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["cMes"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["Cod"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["valor"]);

                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila2 = $fila;
                $fila2 += 2;

                $list = SAdminDaoImp::_getDetallePM($params)[0];
//                $frubroName1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $fila2)->getCoordinate();

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila2, "Mora");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila2++, $list["MO"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila2, "Coactiva");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila2++, $list["CO"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila2, "T. Agua");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila2++, $list["ME"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila2, "T. Admin");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila2++, $list["EM"]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila2, "T. Alcant.");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila2++, $list["AL"]);

//                $frubroName2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $fila2)->getCoordinate();
//                $objPHPExcel->getActiveSheet()->getStyle($frubroName1 . ":" . $frubroName2)
//                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $total);

                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $fila)->getCoordinate();
                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $user["nombres"]);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $fila)->applyFromArray($Firma);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $fila)->applyFromArray($Firma);


                break;
            case "DV":
                $objPHPExcel = $objReader->load("../files_excel/Documentos/DocumentosVarios.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $nameDoc = "Reporte Documentos Varios";
                $title = "Reporte - Documentos Varios";
                $fila = 8;
                $fname1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $fila)->getCoordinate();
                $total = 0;
                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $row["num"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["fecha"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["datos"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["recibo"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["valor"]);
                    $total += floatval($row["valor"]);
                    $fila++;
                }
                $fila += 1;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $total);

                $fname2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $fila)->getCoordinate();
                $objPHPExcel->getActiveSheet()->getStyle($fname1 . ":" . $fname2)
                        ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $fila += 4;
                //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $user["nombres"]);
//                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $fila)->applyFromArray($Firma);
//                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $fila)->applyFromArray($Firma);
                break;
        }

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $title);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "F. Inicio: " . date_format(date_create($params["inicio"]), 'Y-m-d') . " hasta F. Fin: " . date_format(date_create($params["fin"]), 'Y-m-d'));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 5, "Fecha Reporte: " . date("Y-m-d"));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 6, "Usuario - Reporte: " . $user["nombres"]);

        out_excel("file", $objPHPExcel, $nameDoc);
        break;
    case "COACTIVA":
        $objReader = new PHPExcel_Reader_Excel2007();

        switch ($doc) {
            case "CV": case "RC":
                $nameDoc = ($doc == "CV" ) ? "Reporte Coactiva Vigente" : "Reporte Registro Convenios";
                $fila = 8;

                $params = array();
                if ($doc == "RC") {
                    $params = array(
                        "inicio" => $datos["fechas"]["inicio"],
                        "fin" => $datos["fechas"]["fin"]
                    );
                }

                $datos = SAdminDaoImp::_listCoactivaVigente($params);
                $objPHPExcel = $objReader->load("../files_excel/Coactiva/CoactivaVigente.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $nameDoc);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, date("Y-m-d"));
                if ($doc == "RC") {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "F. Inicio: " . date_format(date_create($params["inicio"]), 'Y-m-d') . " hasta F. Fin: " . date_format(date_create($params["fin"]), 'Y-m-d'));
                }

                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $row["registro"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["cedula"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["contribuyente"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["ccaapp"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["deuda"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["entrada"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["abonado"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["saldo"]);
                    $fila++;
                }
                break;
            case "HC":
                $nameDoc = "Reporte Habilitados Coactiva";
                $fila = 8;
                $datos = SAdminDaoImp::_listHabilitadosCoactiva();
                $objPHPExcel = $objReader->load("../files_excel/Coactiva/HabilitadoCoactiva.xlsx");
                $objPHPExcel->setActiveSheetIndex(0);

                foreach ($datos as $row) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $row["REGISTRO"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $row["UPAGO"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $row["CEDULA"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $row["CONTRIBUYENTE"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $row["DIRECCION"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $row["CCPREDIO"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $row["CCAAPP"]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $row["MESES"]);
                    $detalle = json_decode($row["detalle"], true);
                    $PAGUA = $row["MESES"] * $detalle["ME"];
                    $PALCANT = $PAGUA * ($detalle["AL"] / 100);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $PAGUA);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $PALCANT);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $fila, $PALCANT + $PAGUA);
                    $fila++;
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, date("Y-m-d"));
                break;
        }
        out_excel("file", $objPHPExcel, $nameDoc);


        break;
    case "delete":
        break;
    case "get":
        break;
}
?>
<script type="text/javascript">
    window.close();
</script>

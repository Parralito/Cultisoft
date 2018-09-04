<?php
require_once "../init.php";
include_once '../MVC/Modelo/GuiasDaoImp.php';
require_once '../recurso/Classes/PHPExcel.php';
require_once '../recurso/Classes/PHPExcel/Reader/Excel2007.php';
require_once '../files_excel/Excel_OUT.php';

/* Encuestas Carrera */


function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

$op = $_GET["op"];
switch ($op) {
    
    case "cultivos":
        $objReader = new PHPExcel_Reader_Excel2007();

        //Cargando el archivo para modificarlo
        $objPHPExcel = $objReader->load("../files_excel/Cultivo.xlsx");
        
         //Set document properties

        $objPHPExcel->setActiveSheetIndex(0);
        $num_row = 1;
        $carreras = GuiasDaoImp::_getRepoGuiasHabCoactiva();
        $fila = 8;
        foreach ($carreras as $carrera) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila,$num_row++);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fila, $carrera["estudiante"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $fila, $carrera["ciudad"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $carrera["parroquia"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $fila, $carrera["direccion"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $carrera["propietario"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $fila, $carrera["textura"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $carrera["maleza"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $fila, $carrera["profundidad"]);
            $fila++;
        }

        out_excel("file", $objPHPExcel, "Cultivo");
        break;
    
}
//http://localhost:8080/seguimiento_graduados/servidor/sExcel.php?op=encuesta_carrera&encuesta=12
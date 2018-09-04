<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Tarifario.php';
include_once 'ModelProcedure.php';

class TarifarioDaoImp extends ModelProcedure {
//    public static function save($tarifario) {
//        $conn = (new C_MySQL())->open();
//        $sql = ($tarifario->Id == 0) ? $tarifario->Insert()  : $tarifario->Update();
//        $bandera = $conn->query($sql);
//        if ($bandera) {
//            if ($tarifario->Id == 0){
//                $tarifario->Id = $conn->insert_id;
//                $sqlaudit=$tarifario->Audit("Ins");
//            }
//            else {
//                $sqlaudit=$tarifario->Audit("Upd");
//            }            
//            $exec = $conn->query($sqlaudit);
//        }        
//        $conn->close();
//        return $bandera;
//    }
    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";
        
        $param = array(
            "sql" =>"select SQL_CALC_FOUND_ROWS * from tarifario where estado = 'ACT' $where  $banderapag ;"
        );

        $dts = C_MySQL::queryListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

//    public function delete($value) {
//        $conn = (new C_MySQL())->open();
//        $sql = $value->Update_Delete();
//        $conn->query($sql);
//        $conn->close();
//    }
}

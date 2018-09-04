<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Modulo.php';
include_once 'ModelProcedure.php';

class ModuloDaoImp extends ModelProcedure {

//    public static function save($modulo) {
//        $conn = (new C_MySQL())->open();
//        $sql = ($modulo->Id == 0) ? $modulo->Insert() : $modulo->Update();
//        $bandera = $conn->query($sql);
//        if ($bandera) {
//            if ($modulo->Id == 0) {
//                $modulo->Id = $conn->insert_id;
//            }
//        }
//        $conn->close();
//        return $bandera;
//    }

    public static function get($idModulo) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from modulo where id = $idModulo ;";

        $modulo = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $modulo;
    }

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $param = array(
            "sql" => "select SQL_CALC_FOUND_ROWS * from modulo where estado = 'ACT' $where  $banderapag ;"
        );

        $dts = C_MySQL::queryListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

    public function listModulosRol($rol) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_ModulosxRol($rol);";
        $result = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $result;
    }

//    public function delete($value) {
//        $conn = (new C_MySQL())->open();
//        $sql = $value->Update_Delete();
//        $conn->query($sql);
//        $conn->close();
//    }

}

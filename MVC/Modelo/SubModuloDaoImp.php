<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/SubModulo.php';
include_once 'ModelProcedure.php';

class SubModuloDaoImp extends ModelProcedure {

    public static function get($idModulo) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from modulo where id = $idModulo ;";

        $subModulo = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $subModulo ;
    }

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $param = array(
            "sql" => "select SQL_CALC_FOUND_ROWS * from viewsubmodulo where estado = 'ACT' $where  $banderapag ;"
        );

        $dts = C_MySQL::queryListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }
    
    public static function listSubModuloxIN($ids) {
        $conn = (new C_MySQL())->open();
        
        $sql = "select * from submodulo where id in($ids) ;";
        
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }
}

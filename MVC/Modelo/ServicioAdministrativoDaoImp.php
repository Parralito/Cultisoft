<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/ServicioAdministrativo.php';
include_once 'ModelProcedure.php';

class ServicioAdministrativoDaoImp extends ModelProcedure {

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $param = array(
            "sql" => "select SQL_CALC_FOUND_ROWS * from servicioadministrativo where estado = 'ACT' $where  $banderapag ;"
        );

        $dts = C_MySQL::queryListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

}

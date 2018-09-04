<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Categoria.php';

class FPagoDaoImp {

    public static function get($id) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from fpago where id = $id;";

        $value = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $value;
    }

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from fpago where estado = 'ACT' $where  $banderapag ;";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => 0
        );
        $conn->close();
        return $dts;
    }

}

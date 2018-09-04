<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Contribuyente.php';
include_once 'ModelProcedure.php';

class ContribuyenteDaoImp extends ModelProcedure {

    public static function get($idContribuyente) {
        $conn = (new C_MySQL())->open();
        $sql = "select * from contribuyente where id = $idContribuyente ;";
        $contribuyente = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $contribuyente;
    }
    public static function getEstadoCuenta($contribuyente) {
         $conn = (new C_MySQL())->open();
        $sql = "call sp_TotalEstadoCuenta($contribuyente)";

        $dts = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dts;
    }   

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? "where (nombres like '%" . $params["buscar"] . "%')" : "";

        $param = array(
            "sql" => "select SQL_CALC_FOUND_ROWS * from usuario $where  $banderapag ;"
        );

        $dts = C_MySQL::queryListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

    public static function _listAuditContrib($params) {
        $conn = (new C_MySQL())->open();
        $param = array(
            "sql" => "select SQL_CALC_FOUND_ROWS a.*,getVal(a.detalleregistro,'usuario')user from auditcontribuyente a where idcontribuyente=" . $params['idContribuyente'] . " order by fecha desc limit " . $params['top'] . "  offset " . $params['pag'] . ";"
        );

        $dts = C_MySQL::queryListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

}

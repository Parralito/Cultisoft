<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';

class RecursoDaoImp {

    public static function _listRecursoxCobroMensual() {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from viewrecursoxcobromensual";

        //$dts = C_MySQL::returnListAsoc($conn, $sql);
        $dts = C_MySQL::returnListJSON($conn, $sql);
        $conn->close();
        return $dts;
    }
    public static function _listDashboard() {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_Dashboard();";

        $dts = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dts;
    }

    public static function _listRecursoxJuicioCoactiva() {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from viewrecursoxjuiciocoactiva";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _getFecha() {
        $conn = (new C_MySQL())->open();
        $sql = "select getFechaServidor() fecha;";
        $dts = C_MySQL::returnListAsoc($conn, $sql)[0]["fecha"];
        $conn->close();
        return $dts;
    }

    public static function _listRecursoxJuicioCoactivaJSON() {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from viewrecursoxjuiciocoactiva_json";
        $dts = C_MySQL::returnListJSON($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _getSAdmin($abr) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT JSON_OBJECT('id',id,'descripcion',descripcion,'valor', valor,'abr', abr) val from servicioadministrativo where abr= '$abr'";
        $dts = C_MySQL::returnJSON($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _getParametro($abr) {
        $conn = (new C_MySQL())->open();
        $sql = "select json_object('descripcion',`parametro`.`descripcion`,'valor',`parametro`.`valor`,'abr',`parametro`.`abr`,'tipo','$') AS `val` from `parametro` where (`parametro`.`abr` = '$abr')";
        $dts = C_MySQL::returnJSON($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _validarABR($abr) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT EXISTS(SELECT * from sadmin where tipo = '$abr') resultado;";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return intval($dts[0]["resultado"]);
    }

}

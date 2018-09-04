<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/PermisoContribuyente.php';
include_once 'ModelProcedure.php';

class PermisoContribuyenteDaoImp extends ModelProcedure {

    public static function PagoPermisoConexion($params) {
        $conn = (new C_MySQL())->open();
        $sql = "CALL sp_PagoPermisoConexion('". $params["datos"] ."','". $params["fpagos"] ."');";
        $dt = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dt;
    }
    
    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $params = array(
            "procedure" => "sp_PermisoContribuyente",
            "params" => json_encode($params)
        );
        $dts = C_MySQL::procedureListAsoc_Total($conn, $params);
        $conn->close();
        return $dts;
    }

}

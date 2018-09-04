<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/CobroMensual.php';
include_once 'ModelProcedure.php';

class CobroMensualDaoImp extends ModelProcedure {

    public static function updateFechaUltimoPago($datos) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_UpdateFechaUltimoPago('$datos')";
        $response = array();
        $bandera = $conn->query($sql);
        if ($bandera) {
            $response = array(
                "action" => "Registro Exitoso",
                "status" => $bandera
            );
        } else {
            $response = array(
                "status" => $bandera,
                "msg" => $conn->error
            );
        }
        $conn->close();
        return json_encode($response);
    }

    public static function get($idCobro) {
        $conn = (new C_MySQL())->open();
        $sql = "call getEncabezadoCM($idCobro);";
        $cobro = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $cobro;
    }

    public static function _getFechaTarifario($idGuia) {
        $conn = (new C_MySQL())->open();
        $sql = "call fecha_tarifario_guia({$idGuia});";
        $cobro = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $cobro;
    }

    public static function _anular($datos) {
        $conn = (new C_MySQL())->open();
        $sql = "update cobromensual set estado = 'ANU', detalleupdate = '" . json_encode($datos["detalleregistro"]) . "' , observacion = '" . $datos["observacion"] . "' where id = " . $datos["id"] . " ;";
        $bandera1 = $conn->query($sql);
        //$sql = "update sadmin set estado = 'ANU'  where idref = ". $datos["id"] ." ;";
        $sql = "update sadmin sa, (SELECT cod, tipo from cobromensual where id = " . $datos["id"] . ") a set sa.estado = 'ANU',  sa.detalleupdate = '" . json_encode($datos["detalleregistro"]) . "' where sa.tipo = a.tipo and a.cod = sa.coddocumento;";
        $bandera2 = $conn->query($sql);
        $conn->close();
        return $bandera1 && $bandera2;
    }

    public static function _listMensualidadRango($fechas) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_FechaRango('" . json_encode($fechas) . "');";

        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _listMensualidadAnual_CM($CM) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_detalleMensualidadAnual_CM($CM);";

        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }
    public static function _listMensualidadAnual($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call " . (($params["completo"] == "true") ? "sp_detalleCompletoMensualidadAnual" : "sp_detalleMensualidadAnual") . "('" . $params["fecha"] . "]');";

        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _listMensualidad($params) {
        $conn = (new C_MySQL())->open();
        $sql = "SET lc_time_names = 'es_EC';";
        $conn->query($sql);
        //$sql = "select id, fecha, if(cMes > 1,UPPER(CONCAT(DATE_FORMAT(DATE_SUB(fechamensualidad,INTERVAL (cMes - 1) MONTH), '%M, %Y' ),' - ',DATE_FORMAT(fechamensualidad,'%M, %Y'))), UPPER(DATE_FORMAT(fechamensualidad,'%M, %Y'))) fechamensualidad, valor, estado, tipo, cMes from cobromensual where idguias= ". $params["guia"] ." and estado <> 'ANU'   ORDER BY fecha desc limit " . $params['pag'] . " , " . $params['top'];
        $sql = "select id, getVal(detalleregistro,'usuario') user, fecha, if(cMes > 1,UPPER(CONCAT(DATE_FORMAT(DATE_SUB(fechamensualidad,INTERVAL (cMes - 1) MONTH), '%M, %Y' ),' - ',DATE_FORMAT(fechamensualidad,'%M, %Y'))), UPPER(DATE_FORMAT(fechamensualidad,'%M, %Y'))) fechamensualidad, valor, estado, tipo, cMes from cobromensual where idguias= " . $params["guia"] . " and estado <> 'ANU'   ORDER BY fecha desc";

        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    } 

    public static function _listMensualidadPM($params) {
        $conn = (new C_MySQL())->open();
        $sql = "SET lc_time_names = 'es_EC';";
        $conn->query($sql);
        $sql = "select id, fecha, if(cMes > 1,UPPER(CONCAT(DATE_FORMAT(DATE_SUB(fechamensualidad,INTERVAL (cMes - 1) MONTH), '%M, %Y' ),' - ',DATE_FORMAT(fechamensualidad,'%M, %Y'))), UPPER(DATE_FORMAT(fechamensualidad,'%M, %Y'))) fechamensualidad, valor, estado, tipo, cMes, Cod from cobromensual where idguias= " . $params["guia"] . " and tipo in ('PM','JP')   ORDER BY fecha desc limit " . $params['pag'] . " , " . $params['top'];

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _listDetalleCM($idCM) {
        $conn = (new C_MySQL())->open();
        $sqls = [
            "call sp_DetalleFechasCM({$idCM});",
            "SELECT * from dtarifario where idcobromensual = {$idCM};"
        ];
        $resultado = C_MySQL::QueryList($conn, $sqls);
        $conn->close();
        return $resultado;
    }
public static function _getCobroMensual($idG) {
        $conn = (new C_MySQL())->open();        
        $sql = 'SELECT id FROM `cobromensual` c where c.estado="ACT" and c.tipo="JG" and idguias='.$idG.'';
        $dts = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dts;
    }

}

<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/SAdmin.php';
include_once 'ModelProcedure.php';

class SAdminDaoImp extends ModelProcedure {

    public static function _get($params) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT * FROM sadmin where id = ". $params["id"] ." ;";
        $resultado = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $resultado;
    }
    
    public static function _getStatusCertNoAdeudar($params) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT 
                    count(*) tguias,
                    getCantPermisoAprobado(g.idcontribuyente) permiso,
                    SUM(fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id))) meses
                from guias g
                where g.idcontribuyente = ". $params["contribuyente"] ."
                GROUP BY g.idcontribuyente;";
        $resultado = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $resultado;
    }
    public static function _getDetallePC_Sadmin($idSa) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT 
                    sa.fecha,
                    sa.coddocumento,
                    sa.valor,
                    sa.multa,
                    pc.direccion,
                    cont.cedula,
                    cont.nombre contribuyente,
                    cont.ciu,
                    tp.descripcion medida
                from sadmin sa
                join permisocontribuyente pc on sa.idref = pc.id
                join contribuyente cont on cont.id = pc.idcontribuyente
                join tipopermiso tp on tp.id = pc.idtipopermiso
                where sa.id = ". $idSa;
        $resultado = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $resultado;
    }
    
    
    

    public static function _listPermisos($params) {
        $conn = (new C_MySQL())->open();
        $param = array(
            "procedure" => "sp_detallePermiso",
            "params" => json_encode($params)
        );        
        $dts = C_MySQL::procedureListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

    public static function _listCertificados($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and nombre like '%" . $params["buscar"] . "%' or coddocumento like '%" . $params["buscar"] . "%' " : "";
        $sql = "select SQL_CALC_FOUND_ROWS * from viewdetallecontcertificados where estado = 'ACT' $where  $banderapag ;";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _listDocVarios($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and datos like '%" . $params["buscar"] . "%'" : "";
        $sql = "select SQL_CALC_FOUND_ROWS * from viewdetallecontdocvarios where estado = 'ACT' $where  $banderapag ;";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _listCambioTub($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and nombre like '%" . $params["buscar"] . "%' or coddocumento like '%" . $params["buscar"] . "%' " : "";
        $tipo = $params["tipo"] == "*" ? $tipo = "" : $tipo = "and tipo='" . $params["tipo"] . "'";
        $sql = "select SQL_CALC_FOUND_ROWS * from viewdetallecontcambiotub where estado = 'ACT' " . $tipo . "  $where  $banderapag ;";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function updateEstadoPermiso($data) {
        $conn = (new C_MySQL())->open();
        $sql = "update sadmin set estado='ANU', detalleupdate='" . $data["detalleupd"] . "' where id=" . $data["id"] . ";";
        $conn->query($sql);
        $conn->close();
    }

    public static function _listDocumentos($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_ReportDocumento('" . json_encode($params) . "');";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }

    public static function _getDetallePM($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_DetallePM('" . json_encode($params) . "');";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }

    public static function _listCoactivaVigente($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_ReportCoactivaVigente('" . json_encode($params) . "');";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }

    public static function _listHabilitadosCoactiva() {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_ReportHabilitadosCoactiva();";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }

    public static function _listValoresGenerales($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call valoresDiario('" . json_encode($params) . "');";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }

    public static function _listRecaudxUser($params) {
        $conn = (new C_MySQL())->open();
        $user = $params["iduser"] != "" ? $params["iduser"] : "null";
        $sql = "CALL `sp_Recaudacion`('" . json_encode($params) . "'," . $user . ")";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }
        public static function _listContribDesc($params) {
        $conn = (new C_MySQL())->open();
        $sql = "CALL `sp_ContribuyentesDesc`('". json_encode($params) ."')";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;             
    }
    public static function _listContrib() {
        $conn = (new C_MySQL())->open();
        $sql = "select 
			c.cedula,c.ciu,c.nombre,c.direccion,c.telefono,c.email, count(g.id) guias,if(getVal(g.detalle,'DESC')>0,getVal(g.detalle,'DESC'),null) porcentdesc
                from 
			contribuyente c
                left join
			guias g on c.id=g.idcontribuyente 
			group by c.id
                order by trim(c.nombre) asc;";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;             
    }
      public static function _listRecaudDesglo($params) {
        $conn = (new C_MySQL())->open();        
        $sql = "CALL `sp_RecaudacionDesglo`('". json_encode($params) ."')";
        $dt = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dt;
    }

}

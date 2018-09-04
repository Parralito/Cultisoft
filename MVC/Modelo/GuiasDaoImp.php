<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Guias.php';
include_once 'ModelProcedure.php';

class GuiasDaoImp extends ModelProcedure {

    public static function _get($id) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from viewencabezadoguia where id = $id ;";
        $result = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $result;
    }
    public static function _listGuiasxContribuyente($idContribuyente) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from viewguiasxcontribuyente where idContribuyente = $idContribuyente ";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $param = array(
            "procedure" => "sp_Guia",
            "params" => json_encode($params)
        );

        $dts = C_MySQL::procedureListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }
    public static function _listDetalleGuiasxContribuyente_2($params) {
        $conn = (new C_MySQL())->open();
        $param = array(
            "procedure" => "sp_detalleGuiaContribuyente",
            "params" => json_encode($params)
        );

        $dts = C_MySQL::procedureListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }
     public static function _listDetalleGuiasxContribuyente_JC($params) {
        $conn = (new C_MySQL())->open();
        $param = array(
            "procedure" => "sp_detalleGuiaContribuyenteJC",
            "params" => json_encode($params)
        );

        $dts = C_MySQL::procedureListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }
     public static function _listDetalleGuiasxContribuyente_G($params) {
        $conn = (new C_MySQL())->open();
        $param = array(
            "procedure" => "sp_detalleGuiaContribuyenteG",
            "params" => json_encode($params)
        );
        $dts = C_MySQL::procedureListAsoc_Total($conn, $param);
        $conn->close();
        return $dts;
    }

    public static function _listGuiasxContribuyenteCoactiva($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $conn->query("SET lc_time_names = 'es_EC';");
        $sql = "    
		SELECT SQL_CALC_FOUND_ROWS 
				g.id ,
				g.idcontribuyente,
				g.ccpredio ,
				g.ccaapp ,
				g.estado ,
				g.fecha,
				g.detalle,
				g.fechacancelacion,
				g.direccion lugar,
				g.AL,
				cat.descripcion categoria,
				sec.alcantarillado alcantarillado,
				getVal(g.detalle, 'DESC') descuento,
				cont.descripcion_descuento,
				fnUltimoPagoMensual(g.id) ultimoPago,
				UPPER(DATE_FORMAT(fnUltimoPagoMensual(g.id),'%M, %Y')) MesUltimoPago,
				fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id)) cMes,
				(fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id)) <= @maxMes) estadoDeuda                           
		from guias g
		join categoria cat on cat.id = g.idcategoria
		join parroquia par on par.id = g.idparroquia
		join ciudad ciu on ciu.id = par.idciudad
		join sector sec on sec.id = g.idsector
		join contribuyente cont on cont.id =g.idcontribuyente
		where g.idcontribuyente = " . $params["id"] . " and (ccaapp like '%" . $params['buscar'] . "%' or ccpredio like '%" . $params['buscar'] . "%') and (SELECT fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id))) > (SELECT valor from parametro where abr= 'MA') and (select count(*) from juiciocoactivo jc where jc.idguias = g.id and jc.estado = 'ACT' )=0 limit " . $params['top'] . "  OFFSET " . $params['pag'] . "";
        //$sql = "CALL sp_GuiaCoactivoContribuyente($idContribuyente)";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }
     public static function _listDetalleGuiasxContribuyenteTodas($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $conn->query("SET lc_time_names = 'es_EC';");
        $sql = "SELECT SQL_CALC_FOUND_ROWS
			g.id ,
			g.idcontribuyente,
			g.ccpredio ,
			g.ccaapp ,
			g.estado ,
			g.fecha,
                        g.idcategoria,
                        g.detalle,
			g.fechacancelacion,
                        g.direccion lugar,
			cat.descripcion categoria,
			sec.alcantarillado alcantarillado,
			cont.descuento,  
			fnUltimoPagoMensual(g.id) ultimoPago,
			UPPER(DATE_FORMAT(fnUltimoPagoMensual(g.id),'%M, %Y')) MesUltimoPago,
			fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id)) cMes,
			(fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id)) <= (SELECT valor from parametro where abr= 'MA')) estadoDeuda,
			(SELECT count(*) from juiciocoactivo jc  where jc.idguias = g.id and jc.estado = 'ACT') jc
			from guias g
			join categoria cat on cat.id = g.idcategoria
			join parroquia par on par.id = g.idparroquia
			join ciudad ciu on ciu.id = par.idciudad
			join sector sec on sec.id = g.idsector
			join contribuyente cont on cont.id = g.idcontribuyente
			where g.idcontribuyente =  " . $params['contribuyente'] . " and g.estado != 'ANU' and (g.ccaapp like '%" . $params['buscar'] . "%' or g.ccpredio like '%" . $params['buscar'] . "%')
                               limit " . $params['top'] . "  OFFSET " . $params['pag'] . ";";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _listGuiasxContribuyenteCoactivaReg($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $conn->query("SET lc_time_names = 'es_EC';");
        $sql = "		SELECT 
				g.id ,
				g.idcontribuyente,
				jc.id idjuicio,
                                jc.Cod cod,
                                jc.fecha fechareg,
				g.ccpredio ccpredio,
                                g.ccaapp ccaapp,
				cat.descripcion categoria,
				g.direccion as lugar,
				sec.alcantarillado alcantarillado,
				fnUltimoPagoMensual(g.id) fechaultimopago,
				UPPER(DATE_FORMAT(fnUltimoPagoMensual(g.id),'%M, %Y')) MesUltimoPago,
				CURDATE() fecha,
				(SELECT  fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id))) cMes,
                                (SELECT if(sum(valor) is null,0,sum(valor))valor from abono ab where ab.idjuiciocoactivo=jc.id and ab.estado='ACT')vabonos,
				jc.estado Estado,
                                getVal(jc.detalleregistro,\"usuario\") user
		from guias g
		join categoria cat on cat.id = g.idcategoria
		join parroquia par on par.id = g.idparroquia
		join ciudad ciu on ciu.id = par.idciudad
		join sector sec on sec.id = g.idsector
		join juiciocoactivo jc on jc.idguias = g.id
		where " . ($params["estado"] ? "jc.estado='ACT' and " : "") . " g.idcontribuyente =" . $params['id'] . " and jc.estado <> 'INA' and (ccaapp like '%" . $params['buscar'] . "%' or ccpredio like '%" . $params['buscar'] . "%') limit " . $params['top'] . "  OFFSET " . $params['pag'] . ";";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _listGuiasxContribuyenteCoactivaMig($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $conn->query("SET lc_time_names = 'es_EC';");
        $sql = "		SELECT 
				g.id ,
				g.idcontribuyente,
				jc.id idjuicio,
                                jc.Cod cod,
                                jc.fecha fechareg,
				g.ccpredio ccpredio,
                                g.ccaapp ccaapp,
				cat.descripcion categoria,
				g.direccion as lugar,
				sec.alcantarillado alcantarillado,
				fnUltimoPagoMensual(g.id) fechaultimopago,
				UPPER(DATE_FORMAT(fnUltimoPagoMensual(g.id),'%M, %Y')) MesUltimoPago,
				CURDATE() fecha,
				(SELECT  fnCantidadMesesDeuda(fnUltimoPagoMensual(g.id))) cMes,
                                (SELECT if(sum(valor) is null,0,sum(valor))valor from abono ab where ab.idjuiciocoactivo=jc.id and ab.estado='ACT')vabonos,
				jc.estado Estado
		from guias g
		join categoria cat on cat.id = g.idcategoria
		join parroquia par on par.id = g.idparroquia
		join ciudad ciu on ciu.id = par.idciudad
		join sector sec on sec.id = g.idsector
		join juiciocoactivo jc on jc.idguias = g.id
		where " . ($params["estado"] ? "jc.estado='ACT' and " : "") . " g.idcontribuyente =" . $params['id'] . " and Cod is null and jc.estado <> 'INA' and (ccaapp like '%" . $params['buscar'] . "%' or ccpredio like '%" . $params['buscar'] . "%') limit " . $params['top'] . "  OFFSET " . $params['pag'] . ";";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _listDetalleGuiasCoactiva($idGuia) {
        $conn = (new C_MySQL())->open();
        $sql = "CALL sp_detalleGuiasCoactiva($idGuia)";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }
    
    public static function _listAuditGuia($params) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS fecha fechaev,getVal(datosgenerales,'fecha') fechaguia,getVal(detalleregistro,'usuario') user,getVal(datosgenerales,'ccaapp') ccaapp,getVal(datosgenerales,'ccpredio') ccpredio,getCat(getVal(datosgenerales,'categoria')) categoria,getVal(localizaciongeo,'direccion') direccion,getPar(getVal(localizaciongeo,'parroquia')) parroquia,getVal(detalle,'ME') mensualidad,getVal(detalle,'AL') alcantarillado,getVal(detalle,'DE') descuento,accion from auditguia where idguia=".$params['guia']." order by fechaev desc limit " . $params['top'] . "  offset " . $params['pag'] . ";";
        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }
    
    public static function _delete($value) {
        $conn = (new C_MySQL())->open();
        $sql = "UPDATE guias SET estado = 'INA', fechacancelacion = curdate(), observacion = '" . $value["observacion"] . "' where id = " . $value["id"] . " ;";
        $bandera = $conn->query($sql);
        if ($bandera) {
            $sql = "INSERT INTO sadmin(fecha, valor, fpagos,estado,detalleregistro,tipo,idref) "
                    . "values(now(), " . $value["costo"] . ",'" . $value["fpagos"] . "','ACT','" . $value["detalleregistro"] . "','IG'," . $value["id"] . " );";
            $conn->query($sql);
        }
        $conn->close();
        return $bandera;
    }
    
    public static function _AnularGuia($prm) {
        $conn = (new C_MySQL())->open();
        $sql = "CALL sp_AnularGuia(". $prm["guia"] .",'". $prm["user"] ."');";
        $bandera = $conn->query($sql);
        $conn->close();
        return $bandera;
    }

    public static function _ActGuia($value) {
        $conn = (new C_MySQL())->open();
        //$value["valorActivacion"]
        $sql = "UPDATE guias SET estado = 'ACT', fechacancelacion = null, observacion = null where id = " . $value["id"] . ";";
        $bandera = $conn->query($sql);
        if ($bandera) {
            $sql = "INSERT INTO sadmin(fecha, valor, fpagos,estado,detalleregistro,tipo,idref) "
                    . "values(now(), " . (floatval($value["tarifaAdmin"]) + floatval($value["reconexion"]) ) . ",'" . $value["fpagos"] . "','ACT','" . $value["detalleregistro"] . "','AG'," . $value["id"] . " );";
            $conn->query($sql);
        }
        $conn->close();
        return $bandera;
    }

    public static function _ChangeGuia($dt) {
        $conn = (new C_MySQL())->open();
        $sql = "CALL sp_CambioGuia(" . $dt["id"] . "," . $dt["idcontribuyente"] . ",'" . json_encode($dt["DetRegistro"]) . "');";
        $bandera = $conn->query($sql);
        $conn->close();
        return $bandera;
    }

    public static function _validarAnulacionGuia($idGuia) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT fnValidarAnulacionGuia($idGuia) bandera;";
        $dts = C_MySQL::returnListAsoc($conn, $sql)[0]["bandera"];
        $conn->close();
        return is_null($dts) ? false : $dts;
    }

    public static function _detallePermisoConexion($idCon) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT * from viewdetallepermisoconexion where id = $idCon;";
        
        $dts = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dts;
    }

    public static function _detalleGuiaCoactiva($idJuicio) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT * from viewdetalleguiacoactiva where idjuicio = $idJuicio ;";
        $dts = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dts;
    }

    public static function _detalleGuiaCoactivaAbono($idAbono) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT * from viewdetalleguiacoactivaabono where idabono = $idAbono ;";
        $dts = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $dts;
    }

    public static function _getRepoGuiasHabCoactiva() {
        $conn = (new C_MySQL())->open();
        $sql = "select 
                         UPPER(u.nombres) estudiante,
			 UPPER(ci.descripcion) ciudad,
			 UPPER(pa.descripcion) parroquia, 
			 UPPER(g.direccion) direccion,
			 UPPER(g.ccpredio) propietario, 
			 UPPER(c.descripcion) textura, 
			 UPPER(s.descripcion) maleza,
			 UPPER(r.descripcion) profundidad
                from 
                        guias g 
                        inner join  usuario u 
                        on g.idcontribuyente=u.id
                        inner join categoria c
                        on c.id=g.idcategoria
                        inner join parroquia pa
                        on pa.id=g.idparroquia
                        inner join ciudad ci
                        on ci.id=pa.idciudad
                        inner join sector s
                        on s.id=g.idsector
                        inner join ruta r
                        on r.id=s.idruta

        ;";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

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

    public static function updateFechaUltimoPagoUP($datos) {
        $conn = (new C_MySQL())->open();
        $sql = "call sp_UpdateFechaUltimoPagoUP('$datos')";
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
}

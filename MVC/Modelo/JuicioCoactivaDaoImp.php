<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/JuicioCoactiva.php';
include_once 'ModelProcedure.php';

class JuicioCoactivaDaoImp extends ModelProcedure {

//    public static function save($juiciocoactiva) {
//        $conn = (new C_MySQL())->open();
//        $sql = ($juiciocoactiva->Id == 0) ? $juiciocoactiva->Insert() : $juiciocoactiva->Update();
//        $bandera = $conn->query($sql);
//        if ($bandera) {
//            if ($juiciocoactiva->Id == 0) {
//                $juiciocoactiva->Id = $conn->insert_id;
//            }
//        }
//        $conn->close();
//        return $bandera;
//    }

    public static function _listMesesJuicio($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call `sp_detalleMesesJuicioCoactiva`('" . $params["fechainicioplazo"] . "', '" . $params["fechafinplazo"] . "');";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _listMesesJuicioAbonado($params) {
        $conn = (new C_MySQL())->open();
        $sql = "call `sp_detalleMesesJuicioCoactivaAbonado`('" . $params["idjuicio"] . "');";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function _listAbonosJuicioCoactiva($params) {
        $conn = (new C_MySQL())->open();
        $sql = "select id,Cod,fecha,getVal(detalleregistro,'usuario')user,valor,estado from abono where idjuiciocoactivo=" . $params["idjuicio"] . " order by fecha desc;";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }

    public static function updateEstadoAbono($data, $user) {
        $conn = (new C_MySQL())->open();
        $sql = "update abono set estado='ANU', descripcion='" . $data["motivo"] . "',detalleupdate='" . $user . "' where id=" . $data["id"] . ";";
        $conn->query($sql);
        $conn->close();
    }

    public static function updateEstadoJuicio($data, $user) {
        $conn = (new C_MySQL())->open();
        $sql = "call `sp_updateestadojuicio`(" . $data . ");";
        $conn->query($sql);
        $conn->close();
    }

}

<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Rol.php';
include_once 'ModelProcedure.php';

class RolDaoImp extends ModelProcedure {

    public static function get($idRol) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from rol where id = $idRol;";

        $rol = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $rol ;
    }

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from rol where estado = 'ACT' $where  $banderapag ;";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }
    public static function _listPermisos() {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * from viewpermisorol;";
        $dts = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $dts;
    }
    public static function _listPermisoRol($idRol) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT getPermisoRol($idRol);";
        $dts = C_MySQL::returnListJSON($conn, $sql)[0];
        $conn->close();
        return $dts;
    }

//    public function delete($value) {
//        $conn = (new C_MySQL())->open();
//        $sql = $value->Update_Delete();
//        $conn->query($sql);
//        $conn->close();
//    }
    
    public static function asignarPermiso($rol, $permisos) {
        $conn = (new C_MySQL())->open();
        $sql = "delete from permisos where idrol = " . $rol;
        $conn->query($sql);
        $sql = "insert into permisos(idrol, idsubmodulo) values";
        if (count($permisos) > 0) {
            $list = array();
            foreach ($permisos as $permiso) {
                array_push($list, "(" . $rol . "," . $permiso . ")");
            }
            $sql .= join(',', $list);
            $conn->query($sql);
        }
        $conn->close();
    }

}

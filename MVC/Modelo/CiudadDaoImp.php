<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Ciudad.php';
include_once 'ModelProcedure.php';

class CiudadDaoImp extends ModelProcedure {

//    public static function save($ciudad) {
//        $conn = (new C_MySQL())->open();
//        $sql = ($ciudad->Id == 0) ? $ciudad->Insert() : $ciudad->Update();
//        $bandera = $conn->query($sql);
//        if ($bandera) {
//            if ($ciudad->Id == 0) {
//                $ciudad->Id = $conn->insert_id;
//            }
//        }
//        $conn->close();
//        return $bandera;
//    }

    public static function get($idCiudad) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from cliente where id = $idCiudad ;";

        $ciudad = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $ciudad;
    }

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from ciudad where estado = 'ACT' $where  $banderapag ;";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

//    public function delete($value) {
//        $conn = (new C_MySQL())->open();
//        $sql = $value->Update_Delete();
//        $conn->query($sql);
//        $conn->close();
//    }

}

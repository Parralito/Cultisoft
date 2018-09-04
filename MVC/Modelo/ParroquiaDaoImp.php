<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Parroquia.php';
include_once 'ModelProcedure.php';

class ParroquiaDaoImp extends ModelProcedure {
//    public static function save($parroquia) {
//        $conn = (new C_MySQL())->open();
//        $sql = ($parroquia->Id == 0) ? $parroquia->Insert() : $parroquia->Update();
//        $bandera = $conn->query($sql);
//        if ($bandera) {
//            if ($parroquia->Id == 0) {
//                $parroquia->Id = $conn->insert_id;
//            }
//        }
//        $conn->close();
//        return $bandera;
//    }

    /*public static function get($idCiudad) {
        $conn = (new C_MySQL())->open();
        $sql = "select SQL_CALC_FOUND_ROWS * from cliente where id = $idCiudad ;";

        $parroquia = C_MySQL::returnListAsoc($conn, $sql)[0];
        $conn->close();
        return $parroquia;
    }*/

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from viewparroquia where estado = 'ACT' $where  $banderapag ;";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }
    public static function _listxCiudad($idCiudad) {
        $conn = (new C_MySQL())->open();

        $sql = "select SQL_CALC_FOUND_ROWS * from parroquia where estado = 'ACT' and idCiudad =  $idCiudad;";

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

<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Parametro.php';
include_once 'ModelProcedure.php';

class ParametroDaoImp extends ModelProcedure {

    /* public static function get($idCiudad) {
      $conn = (new C_MySQL())->open();
      $sql = "select SQL_CALC_FOUND_ROWS * from cliente where id = $idCiudad ;";

      $tarifario = C_MySQL::returnListAsoc($conn, $sql)[0];
      $conn->close();
      return $tarifario;
      } */

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? " and descripcion like '%" . $params["buscar"] . "%' " : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from parametro $where  $banderapag ;";

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

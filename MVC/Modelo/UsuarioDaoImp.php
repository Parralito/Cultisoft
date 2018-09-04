<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Usuario.php';
include_once 'ModelProcedure.php';

class UsuarioDaoImp extends ModelProcedure {

    public static function _list($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? "where (nombres like '%" . $params["buscar"] . "%' or identificacion like '%" . $params["buscar"] . "%' )" : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from viewusuario $where  $banderapag ;";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }
    public static function _listRec($params) {
        $conn = (new C_MySQL())->open();
        $banderapag = ($params["top"] > 0 ) ? "limit " . $params['top'] . " offset " . $params['pag'] : "";
        $where = ($params["buscar"] != NULL) ? "where (nombres like '%" . $params["buscar"] . "%' or identificacion like '%" . $params["buscar"] . "%' )" : "";

        $sql = "select SQL_CALC_FOUND_ROWS * from viewusuariorec $where  $banderapag ;";

        $dts = array(
            "rows" => C_MySQL::returnListAsoc($conn, $sql),
            "total" => C_MySQL::row_count($conn)
        );
        $conn->close();
        return $dts;
    }

    public static function _login($params) {
        $conn = (new C_MySQL())->open();
        $sql = "select count(*) cant from usuario where  upper('" . $params["user"] . "') = upper(username) and pass = encode('" . $params["pass"] . "','sircap');";
        $login = false;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $login = $row["cant"] == 1;
        }
        $conn->close();
        return $login;
    }
    public static function _get($params) {
        $conn = (new C_MySQL())->open();
        $sql = "select id, identificacion, nombres, username,firma,idrol,permiso,coddocumento,(SELECT rol from viewusuario where id = usuario.id) rol from usuario where upper('" . $params["user"] . "') = upper(username) and pass = encode('" . $params["pass"] . "','sircap');";
        $row = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $row[0];
    }
}

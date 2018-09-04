<?php

final class C_MySQL {

    protected $mysqli;

    function __construct() {
        //$this->open();
    }

    public static function row_count($conn) {
        $total = -1;
        $sql = "select FOUND_ROWS() as total;";
        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $total = $row["total"];
            }
            $result->free();
        }
        return $total;
    }

    public static function procedureListAsoc_Total($conn, $params) {
        $list = array();
        $sqls = array(
            "SET @total = 0;",
            "CALL " . $params["procedure"] . "('" . $params["params"] . "',@total);",
            "SELECT @total as total;"
        );
        $conn->multi_query(join($sqls, ""));
        do {
            if ($resultado = $conn->store_result()) {
                array_push($list, $resultado->fetch_all(MYSQLI_ASSOC));
                $resultado->free();
            }
        } while ($conn->more_results() && $conn->next_result());

        $result = array(
            "rows" => $list[0],
            "total" => $list[1][0]["total"]
        );
        return $result;
    }

    public static function QueryList($conn, $sqls) {
        $list = array();
//        $sqls = array(
//            "SET @total = 0;",
//            "CALL " . $params["procedure"] . "('" . $params["params"] . "',@total);",
//            "SELECT @total as total;"
//        );
        $conn->multi_query(join($sqls, ""));
        do {
            if ($resultado = $conn->store_result()) {
                array_push($list, $resultado->fetch_all(MYSQLI_ASSOC));
                $resultado->free();
            }
        } while ($conn->more_results() && $conn->next_result());

        //$result = $list;
        return $list;
    }

    public static function queryListAsoc_Total($conn, $params) {
        $list = array();
        $sqls = array(
            $params["sql"],
            "SELECT FOUND_ROWS() as total;"
        );
        $conn->multi_query(join($sqls, ""));
        do {
            if ($resultado = $conn->store_result()) {
                array_push($list, $resultado->fetch_all(MYSQLI_ASSOC));
                $resultado->free();
            }
        } while ($conn->more_results() && $conn->next_result());

        $result = array(
            "rows" => $list[0],
            "total" => $list[1][0]["total"]
        );
        return $result;
    }

    public static function returnListAsoc($conn, $sql) {
        $list = array();
        if ($resultado = $conn->query($sql)) {
            $list = $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return $list;
    }

    public static function returnListJSON($conn, $sql) {
        $list = array();
        $result = $conn->query($sql);
        foreach ($result->fetch_all(MYSQLI_NUM) as $row) {
            array_push($list, $row[0]);
        }
        return $list;
    }

    public static function returnJSON($conn, $sql) {
        $result = $conn->query($sql);
        return $result->fetch_row()[0];
    }

    public function open() {
        $this->mysqli = new mysqli("localhost", "root", "Parralito94", "cultisoft");
        if ($this->mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
        $this->mysqli->set_charset("utf8");
        return $this->mysqli;
    }

}

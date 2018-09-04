<?php

class ModelProcedure {

    public static function save($obj) {
        if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
        $response = array();
        if ($_SESSION["login"]["user"]["permiso"] == "R_W") {
            $conn = (new C_MySQL())->open();
            $action = ($obj->Id == 0);
            $sql = ($obj->Id == 0) ? $obj->Insert() : $obj->Update();
            $bandera = $conn->query($sql);
            if ($bandera) {
                $obj->Id = ($obj->Id == 0) ? $conn->insert_id : $obj->Id;
                $response = array(
                    "action" => $action ? "Crear" : "Actualizar",
                    "status" => $bandera
                );
            } else {
                $response = array(
                    "status" => $bandera,
                    "msg" => $conn->error
                );
            }
            $conn->close();
        } else {
            $response = array(
                "status" => FALSE,
                "msg" => "No tiene los permisos correspondientes"
            );
        }
        return $response;
    }

    public static function delete($obj) {
        $conn = (new C_MySQL())->open();
        $sql = $obj->Update_Delete();
        $conn->query($sql);
        $conn->close();
    }

}

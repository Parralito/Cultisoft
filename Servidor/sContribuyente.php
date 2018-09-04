<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/ContribuyenteDaoImp.php';
include_once SITE_ROOT . '/MVC/Controlador/JsonMapper.php';

$accion = $_POST["accion"];
$op = strtoupper($_POST["op"]);
$mapper = new JsonMapper();
$resultado = "";

switch ($accion) {
    case "list":
        $params = array(
            "top" => (isset($_POST["limit"])) ? $_POST["limit"] : 0,
            "pag" => (isset($_POST["offset"])) ? $_POST["offset"] : 0,
            "buscar" => (isset($_POST["search"])) ? $_POST["search"] : NULL
        );
        switch ($op) {
            case "CONTRIBUYENTE":
                $resultado = json_encode(ContribuyenteDaoImp::_list($params));
                break;

            case "AUDITCONTRIB":
                $params["idContribuyente"] = $_POST["idContribuyente"];
                $resultado = json_encode(ContribuyenteDaoImp::_listAuditContrib($params));
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        session_start();
        $user = $_SESSION["login"]["user"];
        switch ($op) {
            case "CONTRIBUYENTE":
                $Contribuyente = $mapper->map($json, new Contribuyente());
                $Contribuyente->DetalleRegistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                $resultado = json_encode(ContribuyenteDaoImp::save($Contribuyente));
//                $resultado = json_encode(array(
//                    "status" => ContribuyenteDaoImp::save($Contribuyente),
//                    "Mensaje" => "Registrado Correctamente"
//                ));
                break;
        }
        break;
    case "delete":
        break;
    case "get":
        switch ($op) {
            case "CONTRIBUYENTE":
                $Contribuyente = $_POST["id"];
                $resultado = json_encode(ContribuyenteDaoImp::get($Contribuyente));
                break;
            case "ESTADOCUENTA":
                $resultado = json_encode(ContribuyenteDaoImp::getEstadoCuenta($_POST["id"]));
                break;
        }

        break;
}
echo $resultado;

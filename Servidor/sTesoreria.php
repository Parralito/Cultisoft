<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/TarifarioDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/FPagoDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/ServicioAdministrativoDaoImp.php';
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
            case "TARIFARIO":
                $resultado = json_encode(TarifarioDaoImp::_list($params));
                break;
            case "FPAGO":
                $resultado = json_encode(FPagoDaoImp::_list($params));
                break;
            case "SERVICIOADMINISTRATIVO":
                $resultado = json_encode(ServicioAdministrativoDaoImp::_list($params));
                break;
        }
        break;
    case "save":
        session_start();
        $user = $_SESSION["login"]["user"];
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        switch ($op) {
            case "TARIFARIO":
                $Tarifario = $mapper->map($json, new Tarifario());
                $ServicioAdministativo->DetalleRegistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                $resultado = TarifarioDaoImp::save($Tarifario);
            case "SERVICIOADMINISTRATIVO":
                $ServicioAdministativo = $mapper->map($json, new ServicioAdministrativo());
                $ServicioAdministativo->DetalleRegistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                
                if (RecursoDaoImp::_validarABR($ServicioAdministativo->Abr)) {
                    $resultado = array(
                        "status" => FALSE,
                        "msg" => "Abreviación ya existe..!"
                    );
                } else {
                    $resultado = ServicioAdministrativoDaoImp::save($ServicioAdministativo);
                }
                break;
        }
        break;
    case "delete":
        break;
    case "get":
        break;
}
echo is_array($resultado) ? json_encode($resultado) : $resultado;

<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/CiudadDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/ParroquiaDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/RutaDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/SectorDaoImp.php';
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
            case "CIUDAD":
                $resultado = json_encode(CiudadDaoImp::_list($params));
                break;
            case "PARROQUIA":
                $resultado = json_encode(ParroquiaDaoImp::_list($params));
                break;
            case "RUTA":
                $resultado = json_encode(RutaDaoImp::_list($params));
                break;
            case "SECTOR":
                $resultado = json_encode(SectorDaoImp::_list($params));
                break;
            case "SECTORRUTA":
                $idRuta = $_POST["idRuta"];
                $resultado = json_encode(SectorDaoImp::_listxRuta($idRuta));
                break;
            case "PARROQUIACIUDAD":
                $idCiudad = $_POST["idCiudad"];
                $resultado = json_encode(ParroquiaDaoImp::_listxCiudad($idCiudad));
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        switch ($op) {
            case "CIUDAD":
                $Ciudad = $mapper->map($json, new Ciudad());
                $resultado = json_encode(CiudadDaoImp::save($Ciudad));
                break;
            case "PARROQUIA":
                $Parroquia = $mapper->map($json, new Parroquia());
                $resultado = json_encode(ParroquiaDaoImp::save($Parroquia));
                break;
            case "RUTA":
                $Ruta = $mapper->map($json, new Ruta());
                $resultado = json_encode(RutaDaoImp::save($Ruta));
                break;
            case "SECTOR":
                $Sector = $mapper->map($json, new Sector());
                $resultado = json_encode(SectorDaoImp::save($Sector));
                break;
        }
        break;
    case "delete":
        break;
    case "get":
        break;
}
echo $resultado;
<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/RecursoDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/ModuloDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/SubModuloDaoImp.php';
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
            case "MODULO":
                $resultado = json_encode(ModuloDaoImp::_list($params));
                break;
            case "SUBMODULO":
                $resultado = json_encode(SubModuloDaoImp::_list($params));
                break;
            case "MENU":
                /* Sesion del user */
                session_start();
                $Modulos = ModuloDaoImp::listModulosRol($_SESSION["login"]["user"]["idrol"]);
                for ($i = 0; $i < count($Modulos); $i++) {
                    $catagolo = array(
                        "descripcion" => "Catálogo",
                        "icon" => "folder-open",
                        "sub" => array()
                    );
                    $subModulos = array();
                    $subModulosBruto = SubModuloDaoImp::listSubModuloxIN($Modulos[$i]["subs"]);
                    foreach ($subModulosBruto as $sm) {
                        if ($sm["catalogo"] === "1") {
                            array_push($catagolo["sub"], $sm);
                        } else {
                            array_push($subModulos, $sm);
                        }
                    }

                    //$Modulos[$i]["submodulos"] = json_encode(SubModuloDaoImp::listSubModuloxIN($Modulos[$i]["submodulos"]));
                    //$Modulos[$i]["sub"] = json_encode($subModulos);
                    
                    if(count($catagolo["sub"]) > 0){
                        array_unshift($subModulos, $catagolo);
                    }
                    $Modulos[$i]["sub"] = ($subModulos);
                }
                $resultado = json_encode($Modulos);
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        switch ($op) {
            case "MODULO":
                $Modulo = $mapper->map($json, new Modulo());
                $resultado = json_encode(ModuloDaoImp::save($Modulo));
                break;
            case "SUBMODULO":
                $SubModulo = $mapper->map($json, new SubModulo());
                $resultado = json_encode(SubModuloDaoImp::save($SubModulo));
                break;
        }
        break;
    case "delete":
        break;
    case "get":
        switch ($op) {
            case "FECHA":
                $resultado = RecursoDaoImp::_getFecha();
                break;
        }
        
        
        break;
}
echo $resultado;

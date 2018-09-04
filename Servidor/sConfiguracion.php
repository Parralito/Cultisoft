<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/RolDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/UsuarioDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/ParametroDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/RecursoDaoImp.php';
include_once SITE_ROOT . '/MVC/Controlador/JsonMapper.php';

$accion = $_POST["accion"];
$op = isset($_POST["op"]) ? strtoupper($_POST["op"]) : "";
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
            case "USUARIO":
                $resultado = json_encode(UsuarioDaoImp::_list($params));
                break;
            case "USUARIOREC":
                $resultado = json_encode(UsuarioDaoImp::_listRec($params));
                break;
            case "ROL":
                $resultado = json_encode(RolDaoImp::_list($params));
                break;
            case "PERMISO":
                $resultado = json_encode(RolDaoImp::_listPermisos());
                break;
            case "PERMISOXROL":
                $rol = $_POST["rol"];
                $resultado = (RolDaoImp::_listPermisoRol($rol));
                break;
            case "PARAMETRO":
                $resultado = json_encode(ParametroDaoImp::_list($params));
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        switch ($op) {
            case "ROL":
                $Rol = $mapper->map($json, new Rol());
                $resultado = RolDaoImp::save($Rol);

                if ($resultado["status"]) {
                    $pSubModulos = json_decode($_POST["permisos"]);
                    RolDaoImp::asignarPermiso($Rol->Id, $pSubModulos);
                }
                break;
            case "PARAMETRO":
                $Parametro = $mapper->map($json, new Parametro());
                $resultado = json_encode(array(
                    "status" => ParametroDaoImp::save($Parametro),
                    "Mensaje" => "Registrado Correctamente"
                ));
                break;
            case "USUARIO":
                $Usuario = $mapper->map($json, new Usuario());
                $resultado = json_encode(UsuarioDaoImp::save($Usuario));
                break;
        }
        break;
    case "delete":
        break;
    case "get":
        switch ($op) {
            
        }
        break;
    case "lg":
        $dt = array(
            "user" => $_POST["u"],
            "pass" => $_POST["p"]
        );
        //$output = ;
        if (UsuarioDaoImp::_login($dt)) {
            session_start();

            $_SESSION["login"] = array(
                "status" => true,
                "user" => UsuarioDaoImp::_get($dt),
                "fecha" => RecursoDaoImp::_getFecha()
            );
            $resultado = array(
                "status" => true,
                "location" => "."
            );
        } else {
            $resultado = array(
                "status" => FALSE,
                "mjs" => "Error al autenticar."
            );
        }
        $resultado = json_encode($resultado);
        break;
    case "close":
        session_start();
        $_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }

// Finalmente, destruir la sesión.
        session_destroy();
        break;
}
echo $resultado;

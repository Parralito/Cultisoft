<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/SAdminDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/RecursoDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/TipoPermisoDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/PermisoContribuyenteDaoImp.php';
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
            "buscar" => (isset($_POST["search"])) ? $_POST["search"] : NULL,
            "tipo" => (isset($_POST["tipo"])) ? $_POST["tipo"] : NULL
        );
        switch ($op) {
            case "REPORTEGENERAL":
                $params = array(
                    "inicio" => $_POST["inicio"],
                    "fin" => $_POST["fin"]
                );
                $resultado = json_encode(SAdminDaoImp::_listValoresGenerales($params));
                break;
            case "PERMISOCONTRIBUYENTE":
                $params["contribuyente"] = $_POST["idContribuyente"];
                if (isset($_POST["estado"]))
                    $params["estado"] = $_POST["estado"];
                $resultado = json_encode(PermisoContribuyenteDaoImp::_list($params));
                break;
            case "TIPOPERMISO":

                $resultado = json_encode(TipoPermisoDaoImp::_list($params));
                break;
            case "DETALLEPERMISOS":
                if (isset($_POST["tipo"]))
                    $params["abr"] = $_POST["tipo"];
                if (is_null($params["buscar"]))
                    unset($params["buscar"]);
                $resultado = json_encode(SAdminDaoImp::_listPermisos($params));
                break;
            case "DETALLECERTIFICADOS":
                $resultado = json_encode(SAdminDaoImp::_listCertificados($params));
                break;
            case "DETALLEDOCVARIOS":
                $resultado = json_encode(SAdminDaoImp::_listDocVarios($params));
                break;
            case "DETALLECAMBIOTUB":
                $resultado = json_encode(SAdminDaoImp::_listCambioTub($params));
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        switch ($op) {
            case "P_PERMISOCONTRIBUYENTE":
                session_start();
                $user = $_SESSION["login"]["user"];

                $datos = array(
                    "id" => $_POST["permisocontr"],
                    "dregistro" => array(
                        "id" => $user["id"],
                        "usuario" => $user["username"]
                    )
                );

                $resultado = PermisoContribuyenteDaoImp::PagoPermisoConexion(array(
                    "datos" => json_encode($datos),
                    "fpagos" => $_POST["fpagos"]
                ));
                if(isset($resultado["id"])){
                    $resultado["status"] = TRUE;
                }
                
                break;
            case "PERMISOCONTRIBUYENTE":
                session_start();
                $user = $_SESSION["login"]["user"];
                $PermisoContribuyente = $mapper->map($json, new PermisoContribuyente());
                if ($PermisoContribuyente->Id == 0) {
                    $PermisoContribuyente->DetalleRegistro = array(
                        "id" => $user["id"],
                        "usuario" => $user["username"]
                    );
                } else {
                    $PermisoContribuyente->DetalleUpdate = array(
                        "id" => $user["id"],
                        "usuario" => $user["username"]
                    );
                }
                $resultado = PermisoContribuyenteDaoImp::save($PermisoContribuyente);
                break;
            case "TIPOPERMISO":
                $TipoPermiso = $mapper->map($json, new TipoPermiso());
                //$val = RecursoDaoImp::_validarABR($TipoPermiso->Abr);
                if (RecursoDaoImp::_validarABR($TipoPermiso->Abr)) {
                    $resultado = array(
                        "status" => FALSE,
                        "msg" => "Abreviación ya existe..!"
                    );
                } else {
                    $resultado = TipoPermisoDaoImp::save($TipoPermiso);
                }
                break;
            case "SADMIN":
                session_start();
                $user = $_SESSION["login"]["user"];
                $fpagos = json_decode($_POST["fpagos"]);
                $Sadmin = $mapper->map($json, new SAdmin());
                $Sadmin->Detalleregistro = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"],
                ));
                $Sadmin->fpagos = json_encode($fpagos);
                $resultado = SadminDaoImp::save($Sadmin);
                $resultado["id"] = $Sadmin->Id;
                break;
            case "UPDATEESTADOPERMISO":
                session_start();
                $user = $_SESSION["login"]["user"];
                $data = json_decode($_POST["data"], true);
                $data["detalleupd"] = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                ));
                $resultado = SAdminDaoImp::updateEstadoPermiso($data);
                break;
        }
        break;
    case "delete":
        break;
    case "get":

        switch ($op) {
            case "SADMIN":
                $params["id"] = $_POST["id"];
                $resultado = SAdminDaoImp::_get($params);
                break;
            case "CERTNOADEUDAR":
                $params["contribuyente"] = $_POST["contribuyente"];
                $resultado = SAdminDaoImp::_getStatusCertNoAdeudar($params);
                break;
            case "PERMISO.CONEXION.SA":
                $idSadmin = $_POST["id"];
                $resultado = SAdminDaoImp::_getDetallePC_Sadmin($idSadmin);
                break;
        }
        break;
}
echo is_array($resultado) ? json_encode($resultado) : $resultado;

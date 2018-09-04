<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/CategoriaDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/GuiasDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/ImagenesDaoImp.php';
//include_once SITE_ROOT . '/MVC/Modelo/CobroMensualDaoImp.php';
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
            case "GUIA":
                $resultado = json_encode(GuiasDaoImp::_list($params));
                break;
            case "CATEGORIA":
                $resultado = json_encode(CategoriaDaoImp::_list($params));
                break;
            case "DETALLEGUIASXCONTRIBUYENTE":
                $params["contribuyente"] = $_POST["idContribuyente"];
                if (isset($_POST["estado"])) {
                    $params["estado"] = $_POST["estado"];
                }
                if (is_null($params["buscar"]))
                    unset($params["buscar"]);
                $resultado = json_encode(GuiasDaoImp::_listDetalleGuiasxContribuyente_2($params));
                break;

            case "GUIASXCONTRIBUYENTE":
                $idContribuyente = $_POST["idContribuyente"];
                $resultado = json_encode(GuiasDaoImp::_listGuiasxContribuyente($idContribuyente));
                break;

            case "DETALLEGUIASXCONTRIBUYENTEG":
                $params["contribuyente"] = $_POST["idContribuyente"];
                if (isset($_POST["estado"])) {
                    $params["estado"] = $_POST["estado"];
                }
                if (is_null($params["buscar"]))
                    unset($params["buscar"]);
                $resultado = json_encode(GuiasDaoImp::_listDetalleGuiasxContribuyente_G($params));
                break;
            case "DETALLEGUIASXCONTRIBUYENTEJC":
                $params["contribuyente"] = $_POST["idContribuyente"];
                if (isset($_POST["estado"])) {
                    $params["estado"] = $_POST["estado"];
                }
                if (is_null($params["buscar"]))
                    unset($params["buscar"]);
                $resultado = json_encode(GuiasDaoImp::_listDetalleGuiasxContribuyente_JC($params));
                break;
            case "GUIASXCONTRIBUYENTECOACTIVA":
                //$idContribuyente = $_POST["idContribuyente"];
                $params["id"] = $_POST["idContribuyente"];
                $resultado = json_encode(GuiasDaoImp::_listGuiasxContribuyenteCoactiva($params));
                break;
            case "GUIASXCONTRIBUYENTECOACTIVAREG":
                $params["id"] = $_POST["idContribuyente"];
                $params["estado"] = isset($_POST["estado"]) ? $_POST["estado"] : false;
                $resultado = json_encode(GuiasDaoImp::_listGuiasxContribuyenteCoactivaReg($params));
                break;
            case "GUIASXCONTRIBUYENTECOACTIVAMIG":
                $params["id"] = $_POST["idContribuyente"];
                $params["estado"] = isset($_POST["estado"]) ? $_POST["estado"] : false;
                $resultado = json_encode(GuiasDaoImp::_listGuiasxContribuyenteCoactivaMig($params));
                break;
            case "DETALLEGUIACOACTIVA":
                $idGuia = $_POST["idGuia"];
                $resultado = json_encode(GuiasDaoImp::_listDetalleGuiasCoactiva($idGuia));
                break;
            case "AUDITGUIA":
                $params["guia"] = $_POST["guia"];
                $resultado = json_encode(GuiasDaoImp::_listAuditGuia($params));
                break;
            case "DETALLEGUIASXCONTRIBUYENTETODAS":
                $params["contribuyente"] = $_POST["idContribuyente"];
                $resultado = json_encode(GuiasDaoImp::_listDetalleGuiasxContribuyenteTodas($params));
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $user = $_SESSION["login"]["user"];
        switch ($op) {
            case "CATEGORIA":
                $Categoria = $mapper->map($json, new Categoria());
                $resultado = json_encode(CategoriaDaoImp::save($Categoria));
                break;
            case "ACTIVAR.GUIAS":
                $dt = json_decode($_POST["dt"], TRUE);
                $dt["detalleregistro"] = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                ));

                $dt["fpagos"] = $_POST["fpagos"];


                $resultado = json_encode(array(
                    "status" => GuiasDaoImp::_ActGuia($dt)
                ));
                break;

            case "GUIAS":

                $Guias = $mapper->map($json, new Guias());
                array_push($Guias->exception, "FPAGOS");
                $isNew = $Guias->Id === 0;
                if ($Guias->Id === 0) {
                    $Guias->DetalleRegistro = array(
                        "id" => $user["id"],
                        "usuario" => $user["username"]
                    );
                } else {
                    $Guias->DetalleUpdate = array(
                        "id" => $user["id"],
                        "usuario" => $user["username"]
                    );
                }
                $resultado = GuiasDaoImp::save($Guias);
                if ($resultado["status"]) {
                    $Guias->Directorio = (is_null($Guias->Directorio))? $_POST["directorio"] : $Guias->Directorio;
                    $_global = SITE_ROOT . '\\recurso\\cultivo';
                    // Crear Directorio 
                    if ($isNew) {
                        $directorio = $_global . '\\' . $user["id"] . '\\';
                        if (!file_exists($directorio)) {
                            mkdir($directorio);
                        }
                        $directorio = $_global . '\\' . $user["id"] . '\\' . $Guias->Id . '\\';
                        if (!file_exists($directorio)) {
                            mkdir($directorio);
                        }
                        $Guias->Directorio = 'recurso/cultivo/' . $user["id"] . '/' . $Guias->Id . '/';
                        GuiasDaoImp::updateDirectorio($Guias->Id, $Guias->Directorio);
                    }
                    // Imagenes
                    //$img = $_FILES["input-id"];
                    if (count($_FILES) > 0){
                        $img = $_FILES["input-id"];
                        for ($index = 0; $index < count($img["tmp_name"]); $index++) {
                            $destino = SITE_ROOT . '\\' . $Guias->Directorio . "\\" . $img["name"][$index];
                            move_uploaded_file($img["tmp_name"][$index], $destino);
                            $imagen = new Imagenes();
                            $imagen->Ruta = $img["name"][$index];
                            $imagen->IDGuias = $Guias->Id;
                            ImagenesDaoImp::save($imagen);
                        }
                    }
                }

                break;
        }
        break;
    case "delete":
        session_start();
        $user = $_SESSION["login"]["user"];
        switch ($op) {
            case "GUIAS":
                $dt = json_decode($_POST["dt"], TRUE);
                $resultado = json_encode(array(
                    "status" => GuiasDaoImp::_delete($dt)
                ));

                break;
            case "ANULAR.GUIA":
                $prm = array(
                    "guia" => $_POST["id"],
                    "user" => json_encode(array(
                        "id" => $user["id"],
                        "usuario" => $user["username"]
                    ))
                );
                $resultado = json_encode(array(
                    "status" => GuiasDaoImp::_AnularGuia($prm)
                ));

                break;
            case "INACTIVAR.GUIAS":
                $dt = json_decode($_POST["dt"], TRUE);
                $dt["detalleregistro"] = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                ));

                $dt["fpagos"] = $_POST["fpagos"];

                $resultado = json_encode(array(
                    "status" => GuiasDaoImp::_delete($dt)
                ));
                break;
            case "VALID.GUIAS":
                $id = $_POST["id"];
                $bandera = GuiasDaoImp::_validarAnulacionGuia($id);
                $resultado = json_encode(array(
                    "status" => boolval($bandera)
                ));

                break;
        }
        break;
    case "get":
        switch ($op) {
            case "PERMISOCONEXION":
                $idcon = $_POST["contribuyente"];
                $resultado = json_encode(GuiasDaoImp::_detallePermisoConexion($idcon));
                break;
            case "GUIA":
                $id = $_POST["id"];
                $resultado = json_encode(GuiasDaoImp::_get($id));
                break;
            case "GUIACOACTIVA":
                $id = $_POST["id"];
                $resultado = json_encode(GuiasDaoImp::_detalleGuiaCoactiva($id));
                break;
            case "GUIACOACTIVAABONO":
                $id = $_POST["id"];
                $resultado = json_encode(GuiasDaoImp::_detalleGuiaCoactivaAbono($id));
                break;
            case "IMAGENES":
                $id = $_POST["guia"];
                $resultado = ImagenesDaoImp::_get($id);
                break;
        }
        break;
}
echo is_array($resultado) ? json_encode($resultado) : $resultado;

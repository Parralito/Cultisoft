<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Modelo/RecursoDaoImp.php';
include_once SITE_ROOT . '/MVC/Controlador/JsonMapper.php';

$accion = $_POST["accion"];
$op = strtoupper($_POST["op"]);
$mapper = new JsonMapper();
$resultado = "";

switch ($accion) {
    case "get":
        switch ($op) {
            case "DASH":
                $resultado = RecursoDaoImp::_listDashboard();
                break;
            case "CM":
                $resultado = "[" . join(",", (RecursoDaoImp::_listRecursoxCobroMensual())) . "]";
                break;
            case "JC":
                $resultado = "[" . join(",", (RecursoDaoImp::_listRecursoxJuicioCoactivaJSON())) . "]";
                break;
            case "JUICIOCOACTIVA":
                $resultado = json_encode(RecursoDaoImp::_listRecursoxJuicioCoactiva());
                break;
            case "MAXMES":
                $resultado = json_encode(GuiasDaoImp::_listGuiasxContribuyenteCoactiva($idContribuyente));
                break;
            case "SADMIN":
                $val = $_POST["val"];
                $resultado = RecursoDaoImp::_getSAdmin($val);
                break;
            case "PARAM":
                $val = $_POST["val"];
                $resultado = RecursoDaoImp::_getParametro($val);
                break;
            /*case "FECHA":
                $resultado = json_encode(array(
                    "fecha" => date("Y-m-d"),
                    "hora" => date("H:i:s")
                ));
                break;*/
        }
        break;
}
echo is_array($resultado) ? json_encode($resultado) : $resultado;

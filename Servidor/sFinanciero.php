<?php

require_once __DIR__ . "/../init.php";

include_once SITE_ROOT . '/MVC/Controlador/Calculator.php';
include_once SITE_ROOT . '/MVC/Modelo/JuicioCoactivaDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/AbonoDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/CobroMensualDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/DTarifarioDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/SAdminDaoImp.php';
include_once SITE_ROOT . '/MVC/Modelo/GuiasDaoImp.php';
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
            case "DETALLE.MENSUALIDAD.ANUAL.CM":
                $cm = $_POST["cm"];
                $resultado = json_encode(CobroMensualDaoImp::_listMensualidadAnual_CM($cm));
                break;
            case "DETALLE.CM":
                $cm = $_POST["cm"];
                $resultado = CobroMensualDaoImp::_listDetalleCM($cm);
                break;
            case "DETALLE.MENSUALIDAD.ANUAL":
                $params = array(
                    "fecha" => $_POST["fechaUltimoPago"],
                    "completo" => $_POST["completo"]
                );
                $resultado = json_encode(CobroMensualDaoImp::_listMensualidadAnual($params));
                break;
            case "DETALLE.MESES.JUICIO":
                $params = array(
                    "fechainicioplazo" => $_POST["fechainicioplazo"],
                    "fechafinplazo" => $_POST["fechafinplazo"]
                );
                $resultado = json_encode(JuicioCoactivaDaoImp::_listMesesJuicio($params));
                break;
            case "DETALLE.MESES.JUICIO.ABONADO":
                $params = array(
                    "idjuicio" => $_POST["idjuicio"]
                );
                $resultado = json_encode(JuicioCoactivaDaoImp::_listMesesJuicioAbonado($params));
                break;
            case "DETALLE.ABONOS.JUICIO.COACTIVA":
                $params = array(
                    "idjuicio" => $_POST["idjuicio"]
                );
                $resultado = json_encode(JuicioCoactivaDaoImp::_listAbonosJuicioCoactiva($params));
                break;
            case "DETALLE.PM.GUIA":
                $params["guia"] = $_POST["guia"];
                $resultado = json_encode(CobroMensualDaoImp::_listMensualidad($params));
                break;
            case "DETALLE.PM.RI.GUIA":
                $params["guia"] = $_POST["id"];
                $resultado = json_encode(CobroMensualDaoImp::_listMensualidadPM($params));
                break;
        }
        break;
    case "save":
        if (array_key_exists("datos", $_POST)) {
            $json = json_decode($_POST["datos"]);
        }
        switch ($op) {
            case "JUICIOCOACTIVA":
                session_start();
                    $user = $_SESSION["login"]["user"];
                $fpagos = json_decode($_POST["fpagos"], TRUE);
                $juiciocoactiva = $mapper->map($json, new JuicioCoactiva());
                $juiciocoactiva->Detalleregistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                $juiciocoactiva->fpagos = $fpagos;
                $resultado = JuicioCoactivaDaoImp::save($juiciocoactiva);                
                
                $rows = json_decode($_POST["tarifario"], true);
                $idCM=CobroMensualDaoImp::_getCobroMensual($juiciocoactiva->Idguias);
                foreach ($rows as $row) {
                    $DTarifario = new DTarifario();
                    $DTarifario->IDCobroMensual =$idCM["id"];
                    $DTarifario->Tarifa = $row["detalle"];
                            
                    $DTarifario->Mes = $row["meses"];
                    DTarifarioDaoImp::save($DTarifario);
                }
                $resultado["id"] = $juiciocoactiva->Id;
                break;
            case "JUICIOCOACTIVANO":
                session_start();
                $user = $_SESSION["login"]["user"];
                $fpagos = json_decode($_POST["fpagos"]);
                $juiciocoactiva = $mapper->map($json, new JuicioCoactiva());
                $juiciocoactiva->Estado = "RU";
                $juiciocoactiva->Detalleregistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                $juiciocoactiva->fpagos = json_encode($fpagos);
                $resultado = JuicioCoactivaDaoImp::save($juiciocoactiva);
                if ($resultado["status"]) {
                    $resultado["id"] = $juiciocoactiva->Id;
                }
                break;
            case "COBROMENSUAL":
                session_start();
                $user = $_SESSION["login"]["user"];
                $CMensual = $mapper->map($json, new CobroMensual());
                $CMensual->Fpagos = json_decode($_POST["fpagos"], TRUE);

                $CMensual->DetalleRegistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                $resultado = CobroMensualDaoImp::save($CMensual);


                if ($resultado["status"]) {
                    $resultado["id"] = $CMensual->Id;
                    $rows = json_decode($_POST["tarifario"], true);
                    foreach ($rows as $row) {
                        $DTarifario = new DTarifario();
                        $DTarifario->IDCobroMensual = $CMensual->Id;
                        $DTarifario->Tarifa = $row["detalle"];
                        $DTarifario->Mes = $row["meses"];
                        DTarifarioDaoImp::save($DTarifario);
                    }
                }

                break;
            case "ANULAR.CM":
                session_start();
                $user = $_SESSION["login"]["user"];
                $json = json_decode($_POST["datos"], TRUE);
                $json["detalleregistro"] = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );

                $resultado = json_encode(array(
                    "status" => CobroMensualDaoImp::_anular($json)
                ));

                break;
            case "AJUSTEJUICIO":
                session_start();
                $user = $_SESSION["login"]["user"];
                $juicio = $mapper->map($json, new JuicioCoactiva());
                $juicio->Detalleregistro = array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                );
                $juicio->Fecha = null;
                JuicioCoactivaDaoImp::save($juicio);
                if ($juicio->Id != 0) {
                    $resultado = json_encode(array(
                        "status" => CobroMensualDaoImp::_anular($json)
                    ));
                }
                break;
            case "ABONO":
                session_start();
                $user = $_SESSION["login"]["user"];
                $fpagos = json_decode($_POST["fpagos"]);
                $abono = $mapper->map($json, new Abono());
                $abono->Detalleregistro = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                ));
                $abono->fpagos = json_encode($fpagos);
                $resultado = AbonoDaoImp::save($abono);                 
                $resultado["id"] = $abono->Id;
                break;
            case "UPDATEESTADOABONO":
                session_start();
                $user = $_SESSION["login"]["user"];
                $detalleupd = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                ));
                $data = json_decode($_POST["data"], true);
                $resultado = JuicioCoactivaDaoImp::updateEstadoAbono($data, $detalleupd);
                break;
            case "UPDATEESTADOJUICIO":
                session_start();
                $user = $_SESSION["login"]["user"];
                $detalleupd = json_encode(array(
                    "id" => $user["id"],
                    "usuario" => $user["username"]
                ));
                $data = $_POST["data"];
                $resultado = JuicioCoactivaDaoImp::updateEstadoJuicio($data, $detalleupd);
                break;
        }
        break;
    case "delete":
        break;
    case "get":
        switch ($op) {
            case "DETALLE.PERIODO":
                $id = $_POST["guia"];
                $resultado = CobroMensualDaoImp::_getFechaTarifario($id);
                break;
            case "CONSOLIDADO.DEUDA":
                $id = $_POST["guia"];
                $resultado = [];
                $cont = 0;
                $rows = CobroMensualDaoImp::_getFechaTarifario($id);
                foreach ($rows as $row) {
                    $detalle = json_decode($row["detalle"], TRUE);
                    $fechas = array(
                        "inicio" => $row["fini"],
                        "fin" => $row["ffin"]
                    );
                    if($cont == 0){
                        $fechas["bandera"] = TRUE;
                    }

                    $row["fechas"] = CobroMensualDaoImp::_listMensualidadRango($fechas);
                    $row["tb"] = Calculator::_obtenerPeriodo($detalle, $row["meses"]);
                    array_unshift($resultado, $row);
                    $cont++;
                }

                break;
            case "CALC.DEUDA":
                $datos = json_decode($_POST["datos"], TRUE);
                $tarifario = $datos["tarifario"];
                $mes = $datos["mes"];
                $estado = $datos["estado"];
                $resultado = Calculator::_calcularPeriodo($tarifario, $mes, $estado);
                break;
            case "TOTAL.DEUDA":
                $datos = json_decode($_POST["datos"], TRUE);
                $rows = $datos["rows"];
                $estado = $datos["estado"];
                $total = 0;
                foreach ($rows as $row) {
                    $trows = Calculator::_calcularPeriodo($row["detalle"], $row["meses"], $estado);
                    $total += array_reduce($trows, function($a, $b) {
                        return $a + $b["total"];
                    }, 0);
                }
                $resultado = $total;
                break;
            case "COBROMENSUAL":
                $idCobro = $_POST["cm"];
                $resultado = json_encode(CobroMensualDaoImp::get($idCobro));
                break;
        }
        break;
}
echo is_array($resultado) ? json_encode($resultado) : $resultado;

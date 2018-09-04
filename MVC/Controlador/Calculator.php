<?php

class Calculator {

    public static function _calcularPeriodo($tarifario, $mes, $estado) {
        $resultado = [];
        $subtotal = 0;
        //set @DESC = IF(getVal(tarifario, 'DESC') = 0, 1 , (getVal(tarifario, 'DESC') / 100));
        $DESC = $tarifario["DESC"] = 0 ? 1 : 1 - ($tarifario["DESC"] / 100);

        array_push($resultado, array(
            "descripcion" => "Emisión",
            "valor" => $tarifario["EM"],
            "total" => $tarifario["EM"] * $mes
        ));
        array_push($resultado, array(
            "descripcion" => "Mensualidad",
            "valor" => $tarifario["ME"] * $DESC,
            "total" => ($tarifario["ME"] * $DESC) * $mes
        ));
        array_push($resultado, array(
            "descripcion" => "Alcantarillado",
            "valor" => $tarifario["AL"],
            "total" => (($tarifario["ME"] * $DESC) * $mes) * ( $tarifario["AL"] / 100 )
        ));
        if (!intval($estado)) {
            $subtotal = array_reduce($resultado, function($a, $b) {
                return $a + $b["total"];
            }, 0);
            //sum = dtTableFP.reduce((a, b) => a + b.valor, 0);

            array_push($resultado, array(
                "descripcion" => "Mora",
                "valor" => $tarifario["MO"],
                "total" => ($subtotal) * ( $tarifario["MO"] / 100 )
            ));

            array_push($resultado, array(
                "descripcion" => "Cobranza",
                "valor" => $tarifario["CO"],
                "total" => ($subtotal) * ( $tarifario["CO"] / 100 )
            ));
        }
        return $resultado;
    }

    public static function _obtenerPeriodo($tarifario, $mes) {
        $impuesto = $valores = [];
        $DESC = $tarifario["DESC"] = 0 ? 1 : 1 - ($tarifario["DESC"] / 100);

        array_push($valores, array(
            "descripcion" => "Emisión",
            "valor" => $tarifario["EM"],
            "total" => $tarifario["EM"] * $mes
        ));
        array_push($valores, array(
            "descripcion" => "Mensualidad",
            "valor" => $tarifario["ME"] * $DESC,
            "total" => ($tarifario["ME"] * $DESC) * $mes
        ));
        array_push($valores, array(
            "descripcion" => "Alcantarillado",
            "valor" => $tarifario["AL"],
            "total" => (($tarifario["ME"] * $DESC) * $mes) * ( $tarifario["AL"] / 100 )
        ));
        $subtotal = array_reduce($valores, function($a, $b) {
            return $a + $b["total"];
        }, 0);
        //sum = dtTableFP.reduce((a, b) => a + b.valor, 0);

        array_push($impuesto, array(
            "descripcion" => "Mora",
            "valor" => $tarifario["MO"],
            "total" => ($subtotal) * ( $tarifario["MO"] / 100 )
        ));

        array_push($impuesto, array(
            "descripcion" => "Cobranza",
            "valor" => $tarifario["CO"],
            "total" => ($subtotal) * ( $tarifario["CO"] / 100 )
        ));
        return array(
            "valores" => $valores,
            "impuesto" => $impuesto
        );
    }

}

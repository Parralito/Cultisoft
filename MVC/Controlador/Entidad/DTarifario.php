<?php

include_once 'ModelSQL.php';

class DTarifario extends ModelSQL {

    public $tabla;
    public $Id;
    public $IDCobroMensual;
    public $Tarifa;
    public $Totales;
    public $Mes;

    function __construct() {
        $this->Id = $this->Mes = 0;
        $this->tabla = "dtarifario";
    }

}

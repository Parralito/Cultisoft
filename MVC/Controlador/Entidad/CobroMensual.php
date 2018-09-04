<?php

include_once 'ModelSQL.php';

class CobroMensual extends ModelSQL {

    public $tabla;
    public $Id;
    public $Fecha;
    public $FechaMensualidad;
    public $Valor;
    public $IdGuias;
    public $Fpagos;
    public $CMes;
    public $Tipo;
    public $Estado;
    public $Observacion;
    public $DetalleRegistro;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "cobromensual";
        //$this->Fecha = date("Y-m-d H:i:s");
    }
}

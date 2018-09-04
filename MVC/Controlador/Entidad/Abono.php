<?php
include_once 'ModelSQL.php';

class Abono extends ModelSQL {
    public $tabla;
    public $Id;
    public $Fecha;
    public $Valor;
    public $Idjuiciocoactivo;
    public $Detalleregistro;
    public $fpagos;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Fecha = date("Y-m-d H:i:s");
        $this->tabla = "abono";
        $this->Estado = "ACT";
    }
}

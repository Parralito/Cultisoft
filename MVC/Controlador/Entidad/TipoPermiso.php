<?php
include_once 'ModelSQL.php';
class TipoPermiso extends ModelSQL {
    public $tabla;
    public $Id;
    public $Descripcion;
    public $Abr;
    public $Valor;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Valor = 0;
        $this->Estado = "ACT";
        $this->tabla = "tipopermiso";
    }
}

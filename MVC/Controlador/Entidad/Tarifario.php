<?php
include_once 'ModelSQL.php';

class Tarifario extends ModelSQL {
    public $tabla;
    public $Id;
    public $Descripcion;
    public $DetalleRegistro;
    public $Valor;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Valor = 0;
        $this->Estado = "ACT";
        $this->tabla = "tarifario";
    }
}

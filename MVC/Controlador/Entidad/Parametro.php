<?php
include_once 'ModelSQL.php';

class Parametro extends ModelSQL {
    public $tabla;
    public $Id;
    public $Descripcion;
    public $Observacion;
    public $Valor;

    function __construct() {
        $this->Id = 0;
        $this->tabla = "parametro";
    }
}

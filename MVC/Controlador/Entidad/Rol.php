<?php
include_once 'ModelSQL.php';

class Rol extends ModelSQL {
    public $tabla;
    public $Id;
    public $Descripcion;
    public $Observacion;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "rol";
    }
}

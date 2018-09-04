<?php

include_once 'ModelSQL.php';

class Modulo extends ModelSQL {

    public $tabla;
    public $Id;
    public $Descripcion;
    public $Estado;
    public $Icon;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "modulo";
        $this->Icon = "folder-open";
    }

}
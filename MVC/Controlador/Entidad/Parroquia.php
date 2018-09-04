<?php
include_once 'ModelSQL.php';

class Parroquia extends ModelSQL{
    public $tabla;
    public $Id;
    public $Descripcion;
    public $IdCiudad;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "parroquia";
    }
}

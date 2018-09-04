<?php

include_once 'ModelSQL.php';

class Sector extends ModelSQL {
    public $tabla;
    public $Id;
    public $Descripcion;
    public $IdRuta;
    public $Alcantarillado;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->Alcantarillado = FALSE;
        $this->tabla = "sector";
    }
}

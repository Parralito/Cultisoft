<?php

include_once 'ModelSQL.php';

class Imagenes extends ModelSQL {
    public $tabla;
    public $Id;
    public $Ruta;
    public $IDGuias;
    public $Estado;
    
    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "imagenes";
    }
}

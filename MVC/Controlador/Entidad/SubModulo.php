<?php

include_once 'ModelSQL.php';

class SubModulo extends ModelSQL {
    public $tabla;
    public $Id;
    public $IdModulo;
    public $Descripcion;
    public $Observacion;
    public $Estado;
    public $Ruta;
    public $Icon;
    public $Catalogo;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "submodulo";
        
        $this->Ruta = "";
        $this->Icon = "adjust";
        $this->Catalogo = 0;
        
    }
}

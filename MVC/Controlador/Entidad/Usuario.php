<?php

include_once 'ModelSQL.php';

class Usuario extends ModelSQL {
    public $tabla;
    public $Id;
    public $Identificacion;
    public $Nombres;
    public $Firma;
    public $CodDocumento;
    public $Username;
    public $Pass;
    public $IdRol;
    public $Permiso;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "usuario";
    }
}

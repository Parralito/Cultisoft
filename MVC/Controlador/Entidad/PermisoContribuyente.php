<?php

include_once 'ModelSQL.php';
class PermisoContribuyente extends ModelSQL {
    public $tabla;
    public $Id;
    public $FechaPermiso;
    public $FechaRegistro;
    public $DetalleRegistro;
    public $DetalleUpdate;
    public $Direccion;
    public $Observacion;
    public $Inspeccion;
    public $Multa;
    public $IDTipoPermiso;
    public $IDContribuyente;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "PEN";
        $this->tabla = "permisocontribuyente";
    }
}

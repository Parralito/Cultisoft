<?php

include_once 'ModelSQL.php';

class Guias extends ModelSQL {
    public $tabla;
    public $Id;
    public $IdContribuyente;
    public $IdCategoria;
    public $IdSector;
    public $AL;
    public $IdParroquia;
    public $ccaapp;
    public $ccpredio;
    public $Fecha;
    public $fechaCancelacion;
    public $fpagos;
    public $Estado;
    public $Direccion;
    public $DetalleRegistro;
    public $DetalleUpdate;
    public $Detalle;

    function __construct() {
        $this->Id = 0;
        $this->Fecha = date("Y-m-d H:i:s");
        $this->Estado = "ACT";
        $this->Direccion = "";
        $this->DetalleUpdate = null;
        $this->tabla = "guias";
    }
}

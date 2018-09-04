<?php

include_once 'ModelSQL.php';
class Contribuyente extends ModelSQL {
    public $tabla;
    public $Id;
    public $IdTipoIdentificacion;
    public $Cedula;
    public $Nombre;
    public $Direccion;
    public $Telefono;
    public $Email;
    public $Ciu;
    public $Descuento;
    public $DetalleRegistro;
    public $descripcion_descuento;
    //public $Estado;

    function __construct() {
        $this->Id = 0;
        //$this->Estado = "ACT";
        $this->Descuento = FALSE;
        $this->tabla = "contribuyente";
    }
}

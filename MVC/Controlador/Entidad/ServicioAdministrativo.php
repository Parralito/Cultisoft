<?php
include_once 'ModelSQL.php';

class ServicioAdministrativo extends ModelSQL {
    public $tabla;
    public $Id;
    public $Descripcion;
    public $Valor;
    public $DetalleRegistro;
    public $Abr;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Valor = 0;
        $this->Estado = "ACT";
        $this->tabla = "servicioadministrativo";
    }
}

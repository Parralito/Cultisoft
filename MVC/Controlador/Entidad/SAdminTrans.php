<?php
include_once 'ModelSQL.php';

class SAdminTrans extends ModelSQL {
    public $tabla;
    public $Id;
    public $Valor;
    public $Fpagos;
    public $FechaSAdmin;
    public $DetalleRegistro;
    public $Estado;

    function __construct() {
        $this->Id = 0;
        $this->Estado = "ACT";
        $this->tabla = "sadmintrans";
    }
}

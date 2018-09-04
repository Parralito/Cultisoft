<?php
include_once 'ModelSQL.php';

class SAdmin extends ModelSQL {
    public $tabla;
    public $Id;
    //public $Fecha;
    public $Valor;
    public $Multa;
    public $Fpagos;
    public $Estado;
    public $Detalleregistro;
    public $Detalle;
    public $FechaSadmin;
    public $Tipo;
    public $Coddocumento;    
    public $idref;    
    public $datos;

    function __construct() {
        $this->Id = 0;
        $this->Multa = 0;        
        $this->Estado = "ACT";        
        $this->tabla = "sadmin";
    }
}

<?php
include_once 'ModelSQL.php';

class JuicioCoactiva extends ModelSQL {
    public $tabla;
    public $Id;
    public $Idguias;
    public $Fecha;
    public $Fechainiciodeuda;
    public $Fechafindeuda;    
    public $Deuda;
    public $Entrada;
    public $Abonado;
    public $Saldo;
    public $Fechainicioplazo;
    public $Fechafinplazo;
    public $Fpagos;
    public $Estado;
    public $Detalle;
    public $Detalleregistro;

    function __construct() {
        $this->Id = 0;
        $this->Fecha = date("Y-m-d H:i:s");
        $this->Estado = "ACT";        
        $this->tabla = "juiciocoactivo";
    }
}

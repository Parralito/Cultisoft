<?php
date_default_timezone_set('America/Guayaquil');
abstract class ModelSQL {
    public $exception = array("TABLA","TBAUDIT",  "ID", "EXCEPTION","COD");
    public function Insert() {
        $sql = "";
        $getter_names_attr = (array) $this;
        $attr = array();
        $values = array();
        foreach ($getter_names_attr as $key => $value) {
            $key2 = strtoupper($key);
            $bool = is_bool(array_search(strtoupper($key2), $this->exception)) ? FALSE : TRUE;
            if (isset($value) && !$bool) {
                array_push($attr, $key);
                if (is_bool($value)) {
                    array_push($values, "'" . ($value ? "1" : "0") . "'");
                } elseif(is_object($value) || is_array($value)) {
                    array_push($values, "'" . json_encode($value) . "'");
                } else {
                    array_push($values, "'" . $value . "'");
                }
            }
        }
        $sql = "INSERT INTO " . $getter_names_attr["tabla"] . "(" . join(",", $attr) . ") VALUES(" . join(",", $values) . ")";        
        return $sql;
    }
    public function Audit($accion)
    {        
        $detalletabla= json_encode(array( "Id" => $this->Id,"Descripcion" => $this->Descripcion,"Valor" => $this->Valor,"Estado" => $this->Estado                                        ));                
        $detalleregistro= json_encode(array( "Usuario" => "MPARRALES","Estacion" =>gethostname(),));        
        
        $sql = "INSERT INTO " . $this->tbAudit . "(fecha,accion,detalletabla,detalleregistro) VALUES('". date("Y-m-d H:i:s")."','".$accion."','".$detalletabla."','".$detalleregistro."')";
        return $sql;
    }
    public function Update() {
        $sql = "";
        $getter_names_attr = (array) $this;
        $values = array();
        foreach ($getter_names_attr as $key => $value) {
            $key2 = strtoupper($key);
            $bool = is_bool(array_search(strtoupper($key2), $this->exception)) ? FALSE : TRUE;
            //if (isset($value) && $key != "tabla" && $key != "ID") {
            if (isset($value) && !$bool) {
                if (is_bool($value)) {
                    array_push($values, $key . " = " . "'" . ($value ? "1" : "0") . "'");
                }
                elseif(is_object($value)|| is_array($value)) {
                array_push($values, $key . " = " . "'" . json_encode($value) . "'");
                }
                else {
                    array_push($values, $key . " = " . "'" . $value . "'");
                }
            }
        }
        $sql = "UPDATE " . $getter_names_attr["tabla"] . " SET " . join(",", $values) . " WHERE ID = " . $getter_names_attr["Id"];
        return $sql;
    }

    public function Update_Delete() {
        if (is_array($getter_names_attr["Id"])) {
            $sql = "UPDATE " . $getter_names_attr["tabla"] . " SET estado = 'INA' WHERE ID IN (" . join(',', $getter_names_attr["Id"]) . ")";
        } else {
            $sql = "UPDATE " . $getter_names_attr["tabla"] . " SET estado = 'INA' WHERE ID = " . $getter_names_attr["Id"];
        }

        return $sql;
    }

}

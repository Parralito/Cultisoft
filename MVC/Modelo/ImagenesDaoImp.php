<?php

include_once SITE_ROOT . '/MVC/Controlador/C_MySQL.php';
include_once SITE_ROOT . '/MVC/Controlador/Entidad/Imagenes.php';
include_once 'ModelProcedure.php';

class ImagenesDaoImp extends ModelProcedure {
    public static function _get($idGuias) {
        $conn = (new C_MySQL())->open();
        $sql = "SELECT 
                            img.id
                            ,concat(g.directorio, img.ruta) ruta
                    from 
                            guias g
                            join imagenes img on img.idguias = g.id
                    where g.id = $idGuias";
        $result = C_MySQL::returnListAsoc($conn, $sql);
        $conn->close();
        return $result;
    }
}

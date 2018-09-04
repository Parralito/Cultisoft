<?php
session_start();
$fecha = json_decode($_SESSION["login"]["fecha"], TRUE)["fecha"];
?>
<!DOCTYPE html>
<section class="content-header">
    <h1>
        Sistema de Control y Monitoreo de Cultivos
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 col-md-offset-3">
            <img src="recurso/imagenes/icono.png" width="40%">
            </div>
        </div>
    </div>
</section>
<script src="recurso/Vista/Reportes/Dashboard.js" type="text/javascript"></script>
<script type="text/javascript">
    fecha = fechaMoment('<?php echo $fecha; ?>', fecha_format.save);
    $("b[Mes]").html(fecha.format('MMMM').toUpperCase());
</script>
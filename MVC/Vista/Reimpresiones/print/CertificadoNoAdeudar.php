<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
}

$user = $_SESSION["login"]["user"];

//require_once "init.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php
        include '../../../../MVC/Vista/Recursos/styleComprobante.php';
        include '../../../../MVC/Vista/Recursos/scriptComprobante.php';
        ?>
        <style type="text/css">
            p{
                font-size: 15px;
            }
            h4{
                font-size: 15px;
            }
        </style>

    </head>
    <!--<body class="hold-transition fixed skin-blue sidebar-mini sidebar-collapse">-->
    <body >
        <br>
        <div id="area" class="container" style="max-height: 1123px;width: 600px;">
            <div class="row" >
                <div class="col-xs-12 text-center">
                    <img src="../../../../recurso/imagenes/epmapaq.png" height="120px" width="80%">
                </div>
                <div class="col-xs-12 text-center">
                    <h3 class="bold">CERTIFICADO NO ADEUDAR</h3>
                </div>
                <div class="col-xs-12">
                    <p class=" text-justify" style="padding-top: 20px;">
                        La Gerencia General de la Empresa Pública Municipal de Agua Potable y Alcantarillado del Cantón Quevedo, 
                        en uso de las atribuciones que me concede la Ley, Certifico:
                    </p>
                    <p class="text-justify">
                        Que habiendo revisado los archivos de cuentas de la Empresa, y/o realizada la inspección al sitio, 
                        <span class="bold subrayado">No consta como deudor(a)</span>
                        por concepto de los servicios de agua potable y alcantarillado, el (a) señor (a):
                    </p>
                </div>
                <div class="col-xs-12">
                    <h4 class="bold">CIU: <span class="subrayado" ciu></span></h4>
                    <h4 class="bold">VALOR CERTIFICADO: $<span class="subrayado" valor></span> </h4>
                    <h4 class="bold">CÉDULA / RUC: <span class="subrayado" identificacion></span></h4>
                    <h4 class="bold">CONTRIBUYENTE: <span class="subrayado" contribuyente></span></h4>
                    <h4 class="bold">DIRECCIÓN: <span class="subrayado" direccion></span></h4>
                </div>
                <div class="col-xs-12">
                    <p class="text-justify" style="padding-top: 20px;">
                        La Empresa Pública Municipal de Agua Potable y Alcantarillado del Cantón Quevedo, en el supuesto que existiesen 
                        obligaciones pendientes o detectadas a esta fecha, no implica condonación, 
                        ni renuncia, ni manipulación de plazo; en   cuyo caso la EPMAPAQ se reserva el ejercicio de las <span class="subrayado">obligaciones</span> y acciones legales a que hubiere lugar.
                    </p>
                    <h4 class="bold">ESTE CERTIFICADO ES VALIDO HASTA: El <span fechaCadu class="subrayado">28 de febrero del 2018</span></h4>

                    <h4 class="">Se expide el presente certificado en la ciudad de Quevedo a: <span fechaActual class="bold subrayado">01 (01) día del mes de FEBRERO de 2018</span>. </h4>
                </div>
                <div class="clearfix"></div>
                <div style="display: flex;flex-direction: row;height: 200px;">
                    <div class="col-xs-4 text-center contenedorFirma" >
                        <hr class="firma"  >
                        <h4 >ELABORADO POR</h4>
                        <h4 class="bold"><?php echo strtoupper($user["firma"]); ?></h4>
                    </div>
                    <div class="col-xs-4 text-center contenedorFirma" style="">
                        <hr class="firma">
                        <h4> Ing. Carlos Pinos Murillo</h4>
                        <h4 class="bold">GERENTE</h4>
                    </div>
                    <div class="col-xs-4 text-center">
                        <img src="../../../../recurso/imagenes/logoGerencia.png" height="150px">
                    </div>
                </div>

            </div>
        </div>

    </body>

    <script type="text/javascript">
//        $("span[fechaActual]").html(moment().format("D [día del mes de] MMMM [del] YYYY"));
//        $("span[fechaCadu]").html(moment().add(30, 'days').format("D [de] MMMM [del] YYYY"));
//        moment().add(7, 'days')
        datos = (<?php echo $_POST["datos"]; ?>);
        fecha=formartMoment(datos.fecha,fecha_format.save);
        $("span[fechaActual]").html(fecha.format("D [día del mes de] MMMM [del] YYYY"));
        $("span[fechaCadu]").html(fecha.add(30, 'days').format("D [de] MMMM [del] YYYY"));
        moment().add(7, 'days');

        dt = getJson({
            url: "../../../../" + getURL("_contribuyente"),
            data: {
                accion: "get",
                op: "contribuyente",
                id: datos.contribuyente
            }
        });
        $("span[ciu]").html(dt.ciu);
        //$("span[valor]").html("3.86 (TRES DÓLARES CON 86/00)");
        entero = Math.trunc(datos.CA);
        decimal = ((datos.CA % 1) * 100).toFixed(0);
        $("span[valor]").html(datos.CA + " (" + CifrasEnLetras.convertirNumeroEnLetras(entero).toUpperCase() + " DOLARES CON " + decimal + "/100) ");
        $("span[identificacion]").html(dt.cedula);
        $("span[contribuyente]").html(dt.nombre);
        $("span[direccion]").html(dt.direccion);

        window.print();
        window.close();
    </script>
</html>

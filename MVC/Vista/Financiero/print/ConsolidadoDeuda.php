<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$user = $_SESSION["login"]["user"];
?>
﻿<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php
        include '../../../../MVC/Vista/Recursos/styleComprobante.php';
        include '../../../../MVC/Vista/Recursos/scriptComprobante.php';
        ?>
        <style type="text/css">
            @page 
            {
                size:  auto;   /* auto es el valor inicial */
                margin: 10mm 0;  /* afecta el margen en la configuración de impresión */
                margin-left: 15mm;
                margin-right: 5mm;
            }
            @media print {
                /* indicamos el salto de pagina */
                .saltoDePagina {
                    display: block;
                    page-break-before: always;
                }
            }
            .rhead{
                font-weight: bold;
            }
            #tbDatos td{
                padding-bottom: 1em;
            }
        </style>
    </head>
    <body>
        <br>
        <div inicio></div>
        <div id="area" class="hidden" style="height: 1123px;width: 780px;">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="bold">DETALLE DE LA DEUDA</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-user"></i>
                                Contribuyente
                            </h3>
                        </div>
                        <div class="box-body" Contribuyente style="padding-bottom: 0px;padding-top: 5px;">
                            <table id="tbDatos" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="rhead">Identificación</td>
                                        <td identificacion></td>
                                        <td class="rhead">Contribuyente</td>
                                        <td contribuyente></td>
                                    </tr>
                                    <tr>
                                        <td class="rhead">CIU</td>
                                        <td ciu></td>
                                        <td class="rhead">Categoría</td>
                                        <td categoria></td>
                                    </tr>
                                    <tr>
                                        <td class="rhead">Clave Agua</td>
                                        <td ccaapp></td>
                                        <td class="rhead">Clave Predio</td>
                                        <td ccprecio></td>
                                    </tr>
                                    <tr>
                                        <td class="rhead">Dirección</td>
                                        <td colspan="3" direccion></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-list"></i>
                                PERIODO DE LA DEUDA
                            </h3>
                        </div>
                        <div class="box-body">
                            <table detalle>
                                <thead>
                                    <tr>
                                        <th data-field="año" data-align="center">Año</th>
                                        <th data-field="Meses" data-align="center">Meses</th>
                                        <th data-field="cantMes" data-align="center" class="col-md-1">Cant. Mes</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="box box-info" Cobranza dr="COBROMENSUALJC">
                        <div class="box-body row">
                            <div class="col-xs-12">
                                <table tbValores id="tbValoresFinalesValores" >
                                    <thead>
                                        <tr>
                                            <th data-field="descripcion" >Detalle</th>
                                            <th data-field="valor" data-halign="center" data-align="right" data-formatter="formatInputMaskPersonalizado">V. Unit.</th>
                                            <th data-field="total" data-halign="center" data-align="right" class="col-md-3" data-formatter="formatInputMask">V. Total</th>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                <div class="pull-right">
                                    <div style="display: flex; align-content: flex-end;">
                                        <label for="" class="control-label">Subtotal</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="text" class="form-control input-sm " style="text-align: right;" subtotal readonly>
                                    </div>
                                </div>
                                <br> <br>
                                <table tbImpuesto id="tbValoresFinalesCobranza" >
                                    <thead>
                                        <tr>
                                            <th data-field="descripcion" >-</th>
                                            <th data-field="valor" data-halign="center" data-align="right" data-formatter="formatPorcentVal">V. Unit.</th>
                                            <th data-field="total" data-halign="center" data-align="right" class="col-md-3" data-formatter="formatInputMask">V. Total</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-danger" Cobranza dr="COBROMENSUALJC">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Cant. Meses 
                                <i class="fa fa-slack"></i>
                                <span id="totalMeses"></span>
                            </h3>
                            <span class="box-title pull-right bold" style="color:red;">
                                Total
                                <i class="fa fa-dollar"></i>
                                <span id="totalJC" total></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center;">             
                <span class="" usuario_firma ><b>EMITIDO POR: </b><?php echo $user["nombres"]; ?></span>            
            </div>         

        </div>
    </body>

    <script type="text/javascript">

        function formatInputMaskPersonalizado(value, row, index) {
            if (row.tipo === '$') {
                return formatInputMask(value);
            } else {
                return formatInputMask(value) + " %";
            }
        }

        function formatPorcentVal(value, row, index) {
            return formatInputMask(value) + " %";
        }

        rowActual = <?php echo $_POST["datos"]; ?>;

        rows = getJson({
            data: {
                op: "CONSOLIDADO.DEUDA",
                accion: "get",
                guia: rowActual.id
            },
            url: "../../../../" + getURL("_financiero")
        });

        $.each(rows, function (i, row) {
            console.log(row);
            clone_area = $("#area").clone();
            $(clone_area).removeAttr("id");
            $(clone_area).removeClass("hidden");

            $(clone_area).find("table[tbValores], table[tbImpuesto], table[detalle]").bootstrapTable();
            $(clone_area).find("table[tbValores]").bootstrapTable("load", row.tb.valores);
            $(clone_area).find("table[tbImpuesto]").bootstrapTable("load", row.tb.impuesto);
            $(clone_area).find("table[detalle]").bootstrapTable("load", row.fechas);

            subtotal_1 = row.tb.valores.reduce((a, b) => a + convertFloat(b.total), 0);
            $(clone_area).find("input[subtotal]").val(formatInputMask(subtotal_1));

            subtotal_2 = row.tb.impuesto.reduce((a, b) => a + convertFloat(b.total), 0);

            $(clone_area).find("#totalJC").html(formatInputMask(subtotal_1 + subtotal_2));
            $(clone_area).find("#totalMeses").html(row.meses);

            salto = '<div pag' + i + ' class="saltoDePagina"></div>';
            $("div[inicio]").after(salto);
            $('div[pag' + i + ']').after(clone_area);

        });
        $('div[pag1]').remove();

        dt = (getJson({
            data: {
                op: "GUIA",
                accion: "get",
                id: rowActual.id
            },
            url: "../../../../" + getURL("_guia")
        }));
        for (clave in dt) {
            $("table tbody td[" + clave + "]").html(dt[clave]);
        }

        window.print();
        window.close();
    </script>
</html>
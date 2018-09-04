<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <?php
        include '../../../../MVC/Vista/Recursos/styleComprobante.php';
        include '../../../../MVC/Vista/Recursos/scriptComprobante.php';
        ?>
        <style type="text/css">
            @page {
                size: auto;
                margin-top: 0;
                margin-left: 5mm;
                margin-right: 5mm;
            }

            @media print {
                /* indicamos el salto de pagina */
                .saltoDePagina {
                    display: block;
                    page-break-before: always;
                }
            }

            .flex-row {
                display: flex;
                flex-flow: row nowrap;
                justify-content: space-between;
            }

            table thead th,
            table tbody td {
                text-align: center;
            }
        </style>
    </head>

    <body>
        <!--<div id="area" style="outline: 2px red solid; height: 510px;width: 737px; text-align: center;" class="flex-column">-->
        <div id="area" style="height: 510px;width: 737px;">
            <div menbrete style="height: 145px;"></div>
            <div class="flex-row">
                <div style="width: 45%;"> <span class="bold">Fecha: <small fecha></small> </span>
                    <br> <span class="bold">Cedula: <small cedula ></small> </span>
                    <br> <span class="bold">Contribuyente: <small contribuyente></small> </span>
                    <br> <span class="bold">CCPredio: <small ccpredio></small> </span> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
                    <span class="bold">Clave de Agua: <small ccaapp></small> </span> 
                </div>
                <div style="width: 45%;">
                    <span class="bold">Recibo: <small recibo></small> </span>
                    <br>
                    <span class="bold text-justify">Dirección: <small direccion></small></span>
                </div>
            </div>
            <hr class="style1-mod">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 30%;">Descripción</th>
                        <th style="width: 12%; ">Meses</th>
                        <th>AAPP</th>
                        <th>ALCANT</th>
                        <th>C. FIJO</th>
                        <th class="jc" >Mora</th>
                        <th class="jc">Cobranza</th>
                        <th>VALOR</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <hr class="style1-mod">
            <!--            <div class="flex-row hidden" style="padding: 0 10px;" cobranza>
                            <div style="width: 45%;"> 
                                <span class="bold">Mora  <small mora ></small> </span>
                                <br> 
                                <span class="bold">Cobranza  <small cobranza></small> </span> </div>
                            <div style="width: 45%;text-align: center;padding-top: 25px;"> 
                                <span class="bold" usuario_firma></span>
                            </div>
                            <div style="width: 45%;text-align: end;"> <span class="bold">Subtotal: <small subtotal></small> </span>
                                <br> <span class="bold">Total: <small total></small> </span>
                            </div>
                        </div>-->
            <div class="flex-row " style="padding: 0 36px;" mensual>
                <div style="width: 45%;"> 
                    <span class="bold hidden" jc style="color: red;">Tiene Juicio Cobranza</span>
                </div>
                <div style="width: 45%;text-align: center;padding-top: 25px;"> 
                    <span class="bold" usuario_firma></span>
                </div>
                <div style="width: 45%;text-align: end;"> 
                    <span class="bold">Total: <small total></small> </span>
                </div>
            </div>
        </div>
        <div class="saltoDePagina"></div>
    </body>
    <script type="text/javascript">
        function formatDolar(value) {
            return "$ " + Inputmask.format(value, "myDecimal");
        }
        cm_id = <?php echo $_POST["cm"]; ?>;
        dt = getJson({
            url: "../../../../" + getURL("_financiero"),
            data: {
                accion: "list",
                op: "DETALLE.CM",
                cm: cm_id
            }
        });
        cm = getJson({
            url: "../../../../" + getURL("_financiero"),
            data: {
                accion: "get",
                op: "COBROMENSUAL",
                cm: cm_id
            }
        });
        $("small[cedula]").html(cm.cedula);
        $("small[fecha]").html(cm.fecha);
        $("small[contribuyente]").html(cm.contribuyente);
        $("small[ccpredio]").html(cm.ccpredio);
        $("small[ccaapp]").html(cm.ccaapp);
        $("small[recibo]").html(cm.recibo);
        $("small[direccion]").html(cm.direccion);
        $("small[usuario]").html(cm.usuario);
        $("span[usuario_firma]").html(cm.usuario);
        subtotal = 0;
        
        if (cm.tipo === "PM") {
            $(".jc").hide();
        }
        //console.log(dt);
        for (i = 0; i < dt[0].length; i++) {
            totales = JSON.parse(dt[1][i].totales);
            total = 0;
            for (var clave in totales) {
                total += totales[clave];
            }
            subtotal += total;
            $("table tbody").append(
                    "<tr>" +
                    "<td style='text-align:left;font-size=6px;'>" + (dt[0][i].ini + ' - ' + dt[0][i].fin) + "</td>" +
                    "<td>" + dt[0][i].meses + "</td>" +
                    "<td>" + formatDolar(totales.ME) + "</td>" +
                    "<td>" + formatDolar(totales.AL) + "</td>" +
                    "<td>" + formatDolar(totales.EM) + "</td>" +
                    (cm.tipo === "PM" ? "" : "<td>" + formatDolar(totales.MO) + "</td>") +
                    (cm.tipo === "PM" ? "" : "<td>" + formatDolar(totales.CO) + "</td>") +
                    "<td>" + formatDolar(total) + "</td>" +
                    "</tr>");
        }
        $("small[total]").html(formatDolar(subtotal));
        $("div.saltoDePagina").after($("#area").clone());
        window.print();
        window.close();
    </script>

</html>
<!DOCTYPE html>
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
        </style>
    </head>
    <body>
        <br>
        <div id="area" class="container" style="max-height: 1123px;width: 780px;">
            <!--<div class="row" style="border: blue solid 2px;">
                <div class="col-xs-12 text-center">
                    <img src="../../../../recurso/imagenes/epmapaq.png" height="120px" width="80%">
                </div>
                <div class="col-xs-12">
                    <div class="pull-left">
                        <h4 class="subrayado bold" for="">CÓDIGO N° <span codigo></span></h4>
                    </div>
                    <div class="pull-right">
                        <h4 for="">POR $<span class="bold"  valor></span> </h4>
                    </div>
                    <div class="clearfix"></div>
                    <p class="lead text-justify" style="padding-top: 20px;">
                        Recibí <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span identificacion></span> CIU: 54383, el valor de $<span valor></span> (<span class="bold" valorLetras ></span>) por concepto de 
                        <span class="bold">PERMISO DE CONEXIÓN DE AGUA POTABLE</span>
                        ubicado en la dirección: <span direccion></span>.
                    </p>                    
                    <div class="col-md-6">
                        <span class="bold">Descripción :</span> 
                        <p class="lead text-justify" medida>Conexión de 1/2 pulgada</p>
                    </div>
                    <div class="col-md-6">
                        <p class="bold" multa style="color:red;"></p>
                        <p class="bold" valpermiso></p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="pull-right">
                        <h4>Quevedo, <span fechas>28 de Marzo del 2018</span></h4>
                    </div>
                </div>
                <div class="col-xs-12 text-center" style="padding-top: 50px;">
                    <h4 class="firma" >Eco. Roger Bautista</h4>

                    <h4 class="bold">JEFE DE RECAUDACIÓN</h4>
                </div>

            </div>-->
            <!--<div class="saltoDePagina"></div>-->
            <div class="row"  style="border: blue solid 2px;" clone>
                <div class="col-xs-12 text-center" style="padding-top: 5px;">
                    <img src="../../../../recurso/imagenes/epmapaq - copia.png" height="85px" width="70%">
                </div>
                <div class="col-xs-12">
                    <div class="pull-left">
                        <h4 class="subrayado bold" for="">CÓDIGO N° <span codigo></span></h4>
                    </div>
                    <div class="pull-right">
                        <h4 for="">POR $<span class="bold" valor></span> </h4>
                    </div>
                    <div class="clearfix"></div>
                    <p class="lead text-justify" style="padding-top: 20px;">
                        Recibí <span contribuyente></span>  con CCI: <span identificacion></span> CIU: <span ciu></span>, el valor de $<span valor></span> (<span class="bold" valorLetras ></span>) por concepto de 
                        <span class="bold">PERMISO DE CONEXIÓN DE AGUA POTABLE</span>
                        ubicado en la dirección: <span direccion></span>.
                    </p>                    
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-6">
                    <span class="bold">Descripción :</span> 
                    <p class="lead text-justify" medida></p>
                </div>
                <div class="col-xs-6">
                    <span class="bold" multa style="color:red;"></span>
                    <p class="bold" valpermiso></p>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 text-right">
                    <!--<h4>Quevedo, <span fechas></span></h4>-->
                    <span style="font-size: 15px;font-weight: bold;">Quevedo, <span fechas></span></span>
                </div>
                <div class="col-xs-12 text-center" style="padding-top: 20px;">
                    <h4 class="firma" >Eco. Roger Bautista</h4>

                    <h4 class="bold">JEFE DE RECAUDACIÓN</h4>
                </div>
            </div>
            <div salto style="padding: 5px 0;"></div>

        </div>
    </body>

    <script type="text/javascript">

        datos = <?php echo $_POST["datos"]; ?>;

        dt = getJson({
            url: "../../../../" + getURL("_sadministrativo"),
            data: {
                accion: "get",
                op: "PERMISO.CONEXION.SA",
                id: datos.id
            }
        });
        valor = dt.valor;
        if (dt.multa !== null && dt.multa > 0)
        {
            $("span[multa]").removeClass("hidden");
            $("p[valpermiso]").removeClass("hidden");
            $("span[multa]").html("Valor de multa : " + dt.multa);
            $("p[valpermiso]").html("Valor del permiso: " + dt.valor);
            valor = convertFloat(dt.valor) + convertFloat(dt.multa);
            //valor= valor.toFixed(0);
        } else
        {
            valor = convertFloat(dt.valor);
        }
        $("span[codigo]").html(dt.coddocumento);
        $("span[contribuyente]").html(dt.contribuyente);
        $("span[identificacion]").html(dt.cedula);
        $("span[ciu]").html(dt.ciu);
        $("span[valor]").html(formatInputMask(valor));
        $("span[direccion]").html(dt.direccion);
        fecha = formartMoment(dt.fecha, fecha_format.save);
        $("span[fechas]").html(fecha.format("D [de] MMMM [del] YYYY"));
        valor = CifrasEnLetras.convertirNumeroEnLetras(valor).toUpperCase() + " CON " + ((valor % 1) * 100).toFixed(0) + "/100 DOLARES AMERICANOS";
        $("span[valorLetras]").html(valor);
        $("p[medida]").html(dt.medida);
        $("div[salto]").after($("div[clone]").clone());
        
        window.print();
        window.close();
    </script>
</html>

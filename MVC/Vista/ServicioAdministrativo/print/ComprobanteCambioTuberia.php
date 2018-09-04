<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php
        include '../../../../MVC/Vista/Recursos/styleComprobante.php';
        include '../../../../MVC/Vista/Recursos/scriptComprobante.php';
        ?>

        <style type="text/css">
            @media print{
                /* indicamos el salto de pagina */
                .saltoDePagina{
                    display:block;
                    page-break-before:always;
                }
            }
            @page 
            {
                size:  auto;   /* auto es el valor inicial */
                margin: 10mm 0;  /* afecta el margen en la configuración de impresión */
                margin-left: 15mm;
                margin-right: 5mm;
            }
        </style>

    </head>
    <!--<body class="hold-transition fixed skin-blue sidebar-mini sidebar-collapse">-->
    <body >
        <br>
        <div id="area" class="container" style="max-height: 1123px;width: 780px;">
            <div class="row" style="border: blue solid 2px;">
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
                        Recibí de <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span identificacion></span>, CIU: <span ciu></span>, el valor de $<span valor></span> (<span class="bold" valorLetras ></span>) por concepto de 
                        <span class="bold">PERMISO DE RECONEXIÓN O CAMBIO DE TUBERÍA DE AGUA POTABLE </span>CORRESPONDIENTE A LA GUIA : </span><span class="bold">CCAAPP </span><span ccaapp class="bold"></span>
                        <span>, CON DIRECCIÓN </span><span direccion class="bold"></span><span class="bold">- CCPREDIO: </span><span ccpredio class="bold"></span><span>.</span>
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

            </div>
            <div style="margin: 45px 0;"></div>
            <!--<div class="saltoDePagina"></div>-->
            <!--<div style="margin: 30px 0;"></div>-->
            <div class="row" style="border: blue solid 2px;">
                <div class="col-xs-12 text-center">
                    <img src="../../../../recurso/imagenes/epmapaq.png" height="120px" width="80%">
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
                        Recibí de <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span identificacion></span>, CIU: <span ciu></span>, el valor de $<span valor></span> (<span class="bold" valorLetras ></span>) por concepto de 
                        <span class="bold">PERMISO DE RECONEXIÓN O CAMBIO DE TUBERÍA DE AGUA POTABLE </span>CORRESPONDIENTE A LA GUIA : </span><span class="bold">CCAAPP </span><span ccaapp class="bold"></span>
                        <span>, CON DIRECCIÓN </span><span direccion class="bold"></span><span class="bold">- CCPREDIO: </span><span ccpredio class="bold"></span><span>.</span>
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

            </div>

        </div>
    </body>

    <script type="text/javascript">

        datos = <?php echo $_POST["datos"]; ?>;
        
        data = getJson({
            url: "../../../../" + getURL("_sadministrativo"),
            data: {
                accion: "get",
                op: "sadmin",
                id: datos.id
            }
        });
               
        valor = datos.valor;
        valor = convertFloat(datos.valor);
        $("span[codigo]").html(data.coddocumento);
        $("span[contribuyente]").html(datos.contribuyente);
        $("span[identificacion]").html(datos.cedcontribuyente);
        $("span[ciu]").html(datos.ciucontribuyente);        
        $("span[valor]").html(formatInputMask(valor));
        $("span[direccion]").html(datos.direccion);
        $("span[ccaapp]").html(datos.ccaapp);
        $("span[ccpredio]").html(datos.ccpredio);
        fecha = formartMoment(data.fecha, fecha_format.save);
        $("span[fechas]").html(fecha.format("D [de] MMMM [del] YYYY"));
        valor = CifrasEnLetras.convertirNumeroEnLetras(valor).toUpperCase() + " CON " + ((valor % 1) * 100).toFixed(0) + "/100 DOLARES AMERICANOS";
        $("span[valorLetras]").html(valor);
        $("p[medida]").html(datos.medida);
        window.print();
        window.close();
    </script>
</html>
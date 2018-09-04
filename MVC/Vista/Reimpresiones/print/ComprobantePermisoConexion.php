<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
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
                        <h4 class="subrayado bold" for="">RECIBO N° <span cod>185R</span></h4>
                    </div>
                    <div class="pull-right">
                        <h4 for="">POR $<span class="bold" valor></span> </h4>
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
                        <h4>Quevedo, <span fecha>28 de Marzo del 2018</span></h4>
                    </div>
                </div>
                <div class="col-xs-12 text-center" style="padding-top: 50px;">
                    <h4 class="firma" >Lcdo. Ernesto Moncayo</h4>
                    <h4 class="bold">ASISTENTE DE GERENCIA</h4>
                </div>

            </div>
            <div class="saltoDePagina"></div>
            <!--<div style="margin: 30px 0;"></div>-->
            <div class="row" style="border: blue solid 2px;">
                <div class="col-xs-12 text-center">
                    <img src="../../../../recurso/imagenes/epmapaq.png" height="120px" width="80%">
                </div>
                <div class="col-xs-12">
                    <div class="pull-left">
                        <h4 class="subrayado bold" for="">RECIBO N° 185R</h4>
                    </div>
                    <div class="pull-right">
                        <h4 for="">POR $<span class="bold" valor></span> </h4>
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
                        <h4>Quevedo, <span fecha>28 de Marzo del 2018</span></h4>
                    </div>
                </div>
                <div class="col-xs-12 text-center" style="padding-top: 50px;">
                    <h4 class="firma" >Lcdo. Ernesto Moncayo</h4>
                    <h4 class="bold">ASISTENTE DE GERENCIA</h4>
                </div>

            </div>

        </div>
    </body>

    <script type="text/javascript">
        
        datos = <?php echo $_POST["datos"]; ?>;
        
        dt = getJson({
            url: "../../../../" + getURL("_guia"),
            data: {
                accion: "get",
                op: "PermisoConexion",
                contribuyente: datos.contribuyente 
            }
        });
        console.log(dt);
        console.log(datos);
        valor=datos.valor;
        if(datos.multa!==null)
        {
            $("p[multa]").removeClass("hidden");
            $("p[valpermiso]").removeClass("hidden");
            $("p[multa]").html("Valor de multa : "+datos.multa);                                
            $("p[valpermiso]").html("Valor del permiso: "+datos.valor);                                            
            valor = convertFloat(datos.valor)+convertFloat(datos.multa);
            valor= valor.toFixed(0);
        }
        else
        {
            valor = convertFloat(datos.valor);
            valor= valor.toFixed(0);
        }
        
        $("span[contribuyente]").html(dt.contribuyente);
        $("span[identificacion]").html(dt.identificacion);
        $("span[valor]").html(valor);        
        $("span[direccion]").html(datos.direccion);
        $("span[fecha]").html(moment().format("D [de] MMMM [del] YYYY"));        
        valor = CifrasEnLetras.convertirNumeroEnLetras(valor).toUpperCase() + " CON " + ((valor % 1) * 100).toFixed(0) + "/100 DOLARES AMERICANOS";
        $("span[valorLetras]").html(valor);
        $("p[medida]").html(datos.medida);
        window.print();
        window.close();
    </script>
</html>
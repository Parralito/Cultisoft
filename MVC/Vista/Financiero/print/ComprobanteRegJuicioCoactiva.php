

﻿<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->       
        <?php include '../../../../MVC/Vista/Recursos/styleComprobante.php';
        include '../../../../MVC/Vista/Recursos/scriptComprobante.php'; ?>        
        <?php //        include SITE_ROOT . '/MVC/Vista/Recursos/stylePrint.php';//        include SITE_ROOT . '/MVC/Vista/Recursos/scriptPrint.php';         ?>        
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
    <!--<body class="hold-transition fixed skin-blue sidebar-mini sidebar-collapse">-->    
    <body >
        <br>        
        <div id="area" class="container" style="max-height: 1123px;width: 780px;">
            <div class="row" style="border: blue solid 2px;">
                <div class="col-xs-12 text-center">                    <img src="../../../../recurso/imagenes/epmapaq.png" height="100px" width="80%">                </div>
                <div class="col-xs-12">
                    <div class="" style="text-align:center;">
                        <h4 class="bold" for="">ABONO INICIAL DE CONVENIO</h4>
                    </div>
                    <div class="pull-left">
                        <h4 class="subrayado bold" for="">CÓDIGO N° <span codigo></span></h4>
                    </div>
                    <div class="pull-right">
                        <h4 class="subrayado bold" for="">$ <span class="bold" valor></span></h4>
                    </div>
                    <div class="clearfix"></div>
                    <p class="lead text-justify" style="padding-top: 20px;font-size:16px;">                        Recibí de <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span class="bold" identificacion></span> CIU: <span class="bold" ciu></span>, el valor de entrada de <span class="bold" valor></span> dólares americanos por concepto de                         <span class="bold">DEUDA VENCIDA DE </span><span cMes class="bold"></span><span> MESES POR EL SERVICIO DE AGUA BRINDADO Y QUE SE BASA EN UNA TARIFA ESTABLECIDA, CORRESPONDIENTE A LA GUIA : </span><span class="bold">CCAAPP </span><span ccaapp class="bold"></span>                        <span>, CON DIRECCIÓN </span><span direccion class="bold"></span><span class="bold">- CCPREDIO: </span><span ccpredio class="bold"></span><span>.</span>                    </p>
                    <div class="col-xs-6">                                                <span class="bold">DETALLE DEL CONVENIO</span><br>                        <span>Deuda Total: <b>$</b></span><span deuda class="bold"></span><br>                        <span>Valor de entrada: <b>$</b></span><span valor class="bold"></span><br>                        <span>Saldo: <b>$</b></span><span saldo class="bold"></span><br>                    </div>
                    <!--                    <div class="col-xs-6">                                                                <span class="bold">PLAN DE PAGOS </span><br>                                                                <span>Fecha inicio plazo: </span><span fechainicioplazo class="bold"></span><br>                                                                <span>Fecha fin plazo: </span><span fechafinplazo class="bold"></span><br>                                                                                        <span>N° meses a pagar: </span><span nmeses class="bold"></span><br>                                                                                    </div>-->                    
                    <div class="clearfix"></div>
                    <div class="pull-right">
                        <h4>Quevedo, <span fechas>28 de Marzo del 2018</span></h4>
                    </div>
                </div>
                <div class="col-xs-12 text-center" style="padding-top: 30px;">
                    <h4 class="firma" >Eco. Roger Bautista</h4>
                    <h4 class="bold">JEFE DE RECAUDACIÓN</h4>
                </div>
            </div>
            <div style="margin: 23px 0;"></div>
            <br>            
            <div class="row" style="border: blue solid 2px;">
                <div class="col-xs-12 text-center">                    <img src="../../../../recurso/imagenes/epmapaq.png" height="100px" width="80%">                </div>
                <div class="col-xs-12">
                    <div class="" style="text-align:center;">
                        <h4 class="bold" for="">ABONO INICIAL DE CONVENIO</h4>
                    </div>
                    <div class="pull-left">
                        <h4 class="subrayado bold" for="">CÓDIGO N° <span codigo></span></h4>
                    </div>
                    <div class="pull-right">
                        <h4 class="subrayado bold" for="">$ <span class="bold" valor></span></h4>
                    </div>
                    <div class="clearfix"></div>
                    <p class="lead text-justify" style="padding-top: 20px;font-size:16px;">                        Recibí de <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span class="bold" identificacion></span> CIU: <span class="bold" ciu></span>, el valor de entrada de <span class="bold" valor></span> dólares americanos por concepto de                         <span class="bold">DEUDA VENCIDA DE </span><span cMes class="bold"></span><span> MESES POR EL SERVICIO DE AGUA BRINDADO Y QUE SE BASA EN UNA TARIFA ESTABLECIDA, CORRESPONDIENTE A LA GUIA : </span><span class="bold">CCAAPP </span><span ccaapp class="bold"></span>                        <span>, CON DIRECCIÓN </span><span direccion class="bold"></span><span class="bold">- CCPREDIO: </span><span ccpredio class="bold"></span><span>.</span>                    </p>
                    <div class="col-xs-6">                                                <span class="bold">DETALLE DEL CONVENIO </span><br>                        <span>Deuda Total:  <b>$</b></span><span deuda class="bold"></span><br>                        <span>Valor de entrada:  <b>$</b></span><span valor class="bold"></span><br>                        <span>Saldo:<b>$</b></span><span saldo class="bold"></span><br>                    </div>
                    <!--                    <div class="col-xs-6">                                                                <span class="bold">PLAN DE PAGOS </span><br>                                                                <span>Fecha inicio plazo: </span><span fechainicioplazo class="bold"></span><br>                                                                <span>Fecha fin plazo: </span><span fechafinplazo class="bold"></span><br>                                                                                        <span>N° meses a pagar: </span><span nmeses class="bold"></span><br>                                                                                    </div>-->                    
                    <div class="clearfix"></div>
                    <div class="pull-right">
                        <h4>Quevedo, <span fechas>28 de Marzo del 2018</span></h4>
                    </div>
                </div>
                <div class="col-xs-12 text-center" style="padding-top: 30px;">
                    <h4 class="firma" >Eco. Roger Bautista</h4>
                    <h4 class="bold">JEFE DE RECAUDACIÓN</h4>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        dt = getJson({
            url: "../../../../" + getURL("_guia"),
            data: {
                accion: "get",
                op: "GUIACOACTIVA",
                id: <?php echo $_POST["idjuicio"]; ?>
            }
        });
        console.log(dt);
        fecha = dt.fechareg;
        $("span[fechas]").html(moment(fecha).format("D [de] MMMM [del] YYYY"));
        $("span[codigo]").html(dt.cod);
        $("span[contribuyente]").html(dt.nombre);
        $("span[ciu]").html(dt.ciu);
        $("span[identificacion]").html(dt.cedula);
        $("span[valor]").html(formatInputMask(dt.entrada));
        $("span[cMes]").html(dt.cMes);
        $("span[ccaapp]").html(dt.ccaapp);
        $("span[direccion]").html(dt.lugar);
        $("span[ccpredio]").html(dt.ccpredio);
        $("span[deuda]").html(formatInputMask(dt.deuda));
        $("span[nmeses]").html(dt.nmeses);
        $("span[fechainicioplazo]").html(dt.fechainicioplazo);
        $("span[fechafinplazo]").html(dt.fechafinplazo);
        $("span[saldo]").html(formatInputMask(dt.deuda - dt.entrada));
        window.print();
        window.close();
    </script>
</html>


<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->        
       <?php       
       include '../../../../MVC/Vista/Recursos/styleComprobante.php';        
       include '../../../../MVC/Vista/Recursos/scriptComprobante.php';        ?>        
       <?php//        include SITE_ROOT . '/MVC/Vista/Recursos/stylePrint.php';//        include SITE_ROOT . '/MVC/Vista/Recursos/scriptPrint.php';        ?>        
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
            <div class="col-xs-12 text-center">                    <img src="../../../../recurso/imagenes/epmapaq.png" height="120px" width="80%">                </div>
            <div class="col-xs-12">
               <div class="" style="text-align:center;">
                  <h4 class="bold" for="">ABONO MENSUAL DE CONVENIO</h4>
               </div>
               <div class="pull-left">
                  <h4 class="subrayado bold" for="">CÓDIGO N° <span codigo></span></h4>
               </div>
               <div class="pull-right">
                  <h4 class="subrayado bold" for="">$ <span class="bold" valor></span></h4>
               </div>
               <div class="clearfix"></div>
               <p class="lead text-justify" style="padding-top: 20px;font-size:18px;">Recibí de <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span class="bold" identificacion></span> CIU: <span class="bold" ciu></span>, el valor de <span class="bold" valor></span> dólares americanos </span> por concepto de                         <span class="bold">ABONO AL CONVENIO DE FACILIDAD DE PAGO SUSCRITO POR LA DEUDA PENDIENTE CON ESTA EMPRESA</span><span>, CORRESPONDIENTE A LA GUIA : </span><span class="bold">CCAAPP </span><span ccaapp class="bold"></span>                        <span>, CON DIRECCIÓN </span><span direccion class="bold"></span><span class="bold">- CCPREDIO: </span><span ccpredio class="bold"></span><span>.</span>                    </p>
               <br>                    
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
         <div style="margin: 30px 0;"></div>
         <br>            
         <div class="row" style="border: blue solid 2px;">
            <div class="col-xs-12 text-center">                    
                <img src="../../../../recurso/imagenes/epmapaq.png" height="120px" width="80%">                </div>
            <div class="col-xs-12">
               <div class="" style="text-align:center;">
                  <h4 class="bold" for="">ABONO MENSUAL DE CONVENIO</h4>
               </div>
               <div class="pull-left">
                  <h4 class="subrayado bold" for="">CÓDIGO N° <span codigo></span></h4>
               </div>
               <div class="pull-right">
                  <h4 class="subrayado bold" for="">$ <span class="bold" valor></span></h4>
               </div>
               <div class="clearfix"></div>
               <p class="lead text-justify" style="padding-top: 20px;font-size:18px;">Recibí de <span contribuyente>PLUA CRUZ NARDA LILIANA</span>  con CCI: <span class="bold" identificacion></span> CIU: <span class="bold" ciu></span>, el valor de <span class="bold" valor></span> dólares americanos </span> por concepto de                         <span class="bold">ABONO AL CONVENIO DE FACILIDAD DE PAGO SUSCRITO POR LA DEUDA PENDIENTE CON ESTA EMPRESA</span><span>, CORRESPONDIENTE A LA GUIA : </span><span class="bold">CCAAPP </span><span ccaapp class="bold"></span>                        <span>, CON DIRECCIÓN </span><span direccion class="bold"></span><span class="bold">- CCPREDIO: </span><span ccpredio class="bold"></span><span>.</span>                    </p>
               <br>                    
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
       datos = (<?php echo $_POST["data"]; ?>);       
       dt = getJson({            
           url: "../../../../" + getURL("_guia"),            
           data: {               
               accion: "get",                
               op: "GUIACOACTIVAABONO",                
               id: datos.idabono            
           }        
       });        
       console.log(dt);   
       $("span[fechas]").html(formatView(dt.fechabono));        
       $("span[valor]").html(formatInputMask(dt.valor));        
       $("span[contribuyente]").html(dt.nombre);        
       $("span[codigo]").html(dt.cod);        
       $("span[identificacion]").html(dt.cedula);        
       $("span[ciu]").html(dt.ciu);        
       $("span[cMes]").html(dt.cMes);        
       $("span[ccaapp]").html(dt.ccaapp);       
       $("span[direccion]").html(dt.lugar);        
       $("span[ccpredio]").html(dt.ccpredio);        
       window.print();       
       window.close();   
  </script>
</html>


<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reimpresión Certificado de No Adeudar
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro >
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">

                    <!-- /.box-header -->   
                    <div class="box-body" Listado>
                        <table
                            class="table table-striped table-bordered table-hover"
                            init
                            data-toolbar="#toolbar"
                            data-ajax="tbDetalleCertificados"
                            data-response-handler="responseHandlerSelect"
                            >
                            <thead>
                                <tr>
                                    <th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>                                                                        
                                    <th data-field="coddocumento">Cod. Documento</th>
                                    <th data-field="cedula">Cédula</th>
                                    <th data-field="nombre">Nombre</th>      
                                    <th data-field="ciu">CIU</th>      
                                    <th data-field="datos">Dirección</th>                                                                        
                                    <th data-field="fechasadmin">Fecha</th>                                    
                                    <th data-field="valor" >Valor</th>
                                    <th data-field="descripcion" >Descripción</th>
                                    <th class="col-md-1" data-formatter="btnAccion" data-events="evtSelect" data-align="center">Acción</th>                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row hidden" new>

        </div>
    </div>
</div>
</section>



<script src="recurso/Vista/Reimpresiones/ReimpresionCertificadoNoAdeudar.js" type="text/javascript"></script>

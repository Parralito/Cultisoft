<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reimpresión Cambio de Tubería
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro >
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="col-md-4">
                        <div class="form-group form-group-sm">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fa fa-arrow-circle-down"></i>
                                    Tipo de Permiso
                                </h3>                        
                            </div>                            
                            <select class="form-control selectpicker" name="documentos">                            
                            </select>
                        </div>                        
                    </div>

                    <!-- /.box-header -->   
                    <div class="box-body" Listado>
                        <table
                            class="table table-striped table-bordered table-hover"
                            init
                            data-toolbar="#toolbar"
                            data-ajax="tbDetalleCambioTub"
                            data-query-params="fnparams"
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
                                    <th data-field="fecha"  data-formatter="formatViewComp">Fecha</th>                                    
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

<script src="recurso/Vista/Reimpresiones/ReimpresionCambioTuberia.js" type="text/javascript"></script>

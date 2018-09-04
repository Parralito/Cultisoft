<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reimpresión Permiso de Conexión
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
                            data-ajax="tbDetallePermisos"
                            data-query-params="fnparams"
                            data-response-handler="responseHandlerSelect"
                            >
                            <thead>
                                <tr>
                                    <!--<th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>-->                                                                        
                                    <th data-field="fecha" data-formatter="defaultFecha">Fecha</th>                                    
                                    <th data-field="coddocumento">Cod. Documento</th>
                                    <th data-field="cedula">Cédula</th>
                                    <th data-field="nombre">Nombre</th>      
                                    <!--<th data-field="ciu">CIU</th>-->      
                                    <th data-field="direccion">Dirección</th>                                                                        
                                    <th data-field="valor" >Valor</th>
                                    <th data-field="descripcion" >Descripción</th>
                                    <th class="col-md-1" data-formatter="btnAccion" data-events="evtSelect" data-align="center">Reimprimir</th>                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>  
            <div Permisos class="col-md-6 col-md-offset-3 hidden">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-dollar-sign"></i>
                                Reimprimir Permiso Cod:
                            </h3>
                            <label class="box-title" name="codigo"></label>
                            <span class="box-title pull-right bold" style="color:red;">
                                VALOR REIMPRESIÓN($) <span id="totalimp"></span>
                            </span>
                        </div>
                        <div class="box-body">
                            <table id="tbFormaPago">
                                <thead>
                                    <tr>
                                        <th data-field="descripcion">Forma de Pago</th>
                                        <th data-field="valor" data-formatter="imask" data-events="event_input" data-align="center" class="col-md-3">Valor</th>
                                        <th data-field="detalle" class="col-md-2" data-formatter="defaultInput" data-events="event_input_default">N° Comprobante</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                         <div class="modal-footer">
                             <button reimprimir type="button" class="btn btn-info"><i class="fa fa-print"></i> Reimprimir</button>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row hidden" new>

        </div>
    </div>
</div>
</section>



<script src="recurso/Vista/GestionServiciosAdmin/ReimpresionPermisosCon.js" type="text/javascript"></script>

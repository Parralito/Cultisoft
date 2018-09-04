<!DOCTYPE html>
<section class="content-header">
    <h1>
        Documentos Varios
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro class="row">
        <div class="col-md-12">
                <div class="box box-info">

                    <!-- /.box-header -->   
                    <div class="box-body" Listado>
                        <div id="toolbar">
                                <button id="newDoc" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                         </div>
                        <table
                            class="table table-striped table-bordered table-hover"
                            init
                            data-toolbar="#toolbar"
                            data-ajax="tbDetalleDocVarios"
                            >
                            <thead>
                                <tr>
                                    <!--<th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>-->                                                                        
                                    <th data-field="cod">Código</th> 
                                    <th data-field="datos">Descripción</th>                                                                        
                                    <th data-field="fecha">Fecha</th>                                    
                                    <th data-field="valor" data-halign="center" data-align="right">Valor</th>
                                    <th class="col-md-1" data-formatter="btnAccion" data-events="evtSelect" data-align="center">Anular</th>                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>            
    </div>
    <div class="row hidden" new>
        <div Anular class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa fa-file-alt "></i>
                        Descripción del documento
                    </h3>
                    <label class="box-title" name="abono"></label>
                </div>                      
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group form-group-sm">
                        <textarea motivo class="form-control" name="direccion" required cols="30" rows="1" maxlength="68" style="resize: none;" placeholder="Ingrese la descripción del documento al que se le va a registrar el pago"></textarea>                        
                    </div>
                </div>
            </div>
        </div>        
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-dollar-sign"></i>
                        Detalle Pago
                    </h3>
                    <span class="box-title pull-right bold" style="color:red;">
                        TOTAL ($) <span id="total" total></span>
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
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="pull-right">
                <button clean type="button" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Cancelar
                </button>
                <button generar type="button" class="btn btn-primary">
                    <i class="fa fa-file-pdf"></i> Generar
                </button>
            </div>
        </div>

    </div>

</section>


<div class="modal fade in" id="modal-contribuyente" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="fa fa-search"></i> Buscar Contribuyente</h4>
            </div>
            <div class="modal-body">
                <table
                    id="tbContribuyente"
                    class="table table-striped table-bordered table-hover"
                    init
                    data-ajax="tbContribuyentes">
                    <thead>
                        <tr>
                            <th data-field="nombre">Nombre</th>
                            <th data-field="cedula">Identificación</th>
                            <th data-field="direccion" data-formatter="reducirText">Dirección</th>
                            <th data-formatter="btnSelect" data-events="evtSelect">Selec.</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="recurso/Vista/ServicioAdministrativo/DocumentosVarios.js" type="text/javascript"></script>
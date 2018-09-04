<!DOCTYPE html>
<section class="content-header">
    <h1>
        Permisos de conexión
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-user"></i>
                            Contribuyente
                        </h3>
                    </div>
                    <div class="box-body" Contribuyente>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Identificación</label>
                                    <div class="searchComponent">
                                        <input name="id" type="text" class="hidden" readonly>
                                        <input name="detalleContribuyente" type="text" class="form-control" required readonly style="width: 90%;margin-right:10px;">
                                        <button type="button" class="btn btn-info btn-sm" style="margin-right:5px;" data-toggle="modal" data-target="#modal-contribuyente">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button clear type="button" class="btn btn-danger btn-sm">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <table Permisos
                                       data-ajax="loadPermisoContribuyente"
                                       data-query-params="fn_query">
                                    <thead>
                                        <tr>
                                            <th data-field="fechapermiso" data-formatter="defaultFecha" data-align="center" class="col-md-1">Fecha</th>
                                            <th data-field="permiso" class="col-md-2">Tipo Permiso</th>
                                            <th data-field="direccion" class="col-md-4">Dirección</th>
                                            <th data-field="estado" class="col-md-1" data-align="center" data-formatter="getEstado">Estado</th>
                                            <th data-field="multa" class="col-md-1" data-align="center">Multa</th>
                                            <th class="col-md-1" data-formatter="btnAccion" data-events="evtSelect" data-align="center">Acción</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-info hidden" new>
        <div class="box-header with-border">
            <h3 class="box-title" tipo>
                <i class="fa fa-tint"></i> Datos Permiso                     
            </h3>
            <h3 class="box-title pull-right bold" style="color:red">                        
                TOTAL ($) <span id="total"></span>
            </h3>
        </div>
        <div class="box-body row vdivide">
            <div class="col-md-6" DetallePermiso>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Tipo Permiso</label>
                            <input type="text" name="permiso" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Valor</label>
                            <input type="text" name="valor" class="form-control" myDecimal readonly>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Multa</label>
                            <input type="text" name="multa" class="form-control" myDecimal readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Dirección</label>
                            <textarea class="form-control" name="direccion" rows="2" readonly ></textarea>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
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
        <div class="box-footer">
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
    </div>
</div>

<script src="recurso/Vista/ServicioAdministrativo/PermisosdeConexion.js" type="text/javascript"></script>
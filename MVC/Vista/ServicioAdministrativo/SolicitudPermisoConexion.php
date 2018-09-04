<!DOCTYPE html>
<section class="content-header">
    <h1>
        Solicitud - Permiso de Conexión
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
                    <div class="box-body row" Contribuyente>
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
                            <div id="toolbar">
                                <button id="newPermiso" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                            <table Permisos
                                   data-ajax="loadPermisoContribuyente"
                                   data-query-params="fn_query"
                                   data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="fechapermiso" data-formatter="defaultFecha" data-align="center" class="col-md-1">Fecha</th>
                                        <th data-field="permiso" class="col-md-2">Tipo Permiso</th>
                                        <th data-field="direccion" class="col-md-4">Dirección</th>
                                        <th data-field="estado" class="col-md-1" data-align="center" data-formatter="getEstado">Estado</th>
                                        <th data-field="multa" class="col-md-1" data-halign="center" data-align="right">Multa</th>
                                        <th class="col-md-1" data-formatter="BtnAccion" data-events="evtSelect" data-align="center">Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row hidden" new>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title" > <i class="fa fa-address-book"></i> Información Básica </h3>
                </div>
                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label">Fecha</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="fechapermiso" data-tipo="day" dt-tipo="day" readonly required>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Dirección</label>
                            <textarea direccion class="form-control" name="direccion" required cols="30" rows="1" maxlength="68" style="resize: none;" placeholder="Dirección del domicilio."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Tipo Permiso</label>
                            <select name="idtipopermiso" data-fn="cboTipoPermiso" class="selectpicker form-control"></select>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Estado</label>
                            <select name="estado" class="selectpicker form-control">
                                <option value="PEN">Pendiente</option>
                                <option value="APR">Aprobado</option>
                                <option value="ANU">Anulado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title bold" >   
                        <i class="fa fa-list"></i> Detalle 
                    </h3>
                </div>   
                <div class="box-body">
                    <div class="form-group form-group-sm">
                        <label for="" class="control-label" >Multa ($)</label>
                        <input name='multa' data-tipo="myDecimal" type="text" class="form-control">
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="" class="control-label">Observación</label>
                        <textarea direccion class="form-control" name="observacion" cols="30" rows="2" maxlength="200" placeholder="Descripción de la inspección"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="pull-right">
                <button clean type="button" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Cancelar
                </button>
                <button save type="button" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar
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

<script src="recurso/Vista/ServicioAdministrativo/SolicitudPermisoConexion.js" type="text/javascript"></script>
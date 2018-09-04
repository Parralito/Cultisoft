<!DOCTYPE html>
<section class="content-header">
    <h1>
        Certificado - No Adeudar
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
                    <!-- /.box-header -->

                    <div class="box-body" Contribuyente>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Identificación</label>
                                    <div class="searchComponent">
                                        <input name="id" type="text" class="hidden" readonly>
                                        <input name="detalleContribuyente" type="text" class="form-control" required readonly style="width: 60%;margin-right:10px;">
                                        <button type="button" class="btn btn-info btn-sm" style="margin-right:5px;" data-toggle="modal" data-target="#modal-contribuyente">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button clear type="button" class="btn btn-danger btn-sm">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" table>
                            <div class="col-md-7">
                                <table 
                                    id="tbDetalleGuia"
                                    data-ajax="tbDetalleGuiasxContribuyente"
                                    data-query-params="fn_query">
                                    <thead>
                                        <tr>
                                            <th data-field="lugar">Localización</th>
                                            <!--<th data-field="categoria">Categoría</th>-->
                                            <th data-field="MesUltimoPago" class="col-md-2" data-align="center">Mes Último Pago</th>
                                            <th data-field="ccpredio" class="col-md-1" data-align="center">Clave Predio</th>
                                            <th data-field="cMes" class="col-md-1" data-align="center">Cant. Mes (es)</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table Permisos
                                       data-ajax="loadPermisoContribuyente"
                                       data-query-params="fn_queryPermiso"
                                       data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="fechapermiso" data-formatter="defaultFecha" data-align="center" class="col-md-2">Fecha</th>
                                            <th data-field="permiso" class="col-md-2">Tipo Permiso</th>
                                            <th data-field="direccion" class="col-md-4">Dirección</th>
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
    <div class="row hidden" new>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-star"></i>
                        Estado del Contribuyente
                    </h3>
                </div>
                <div detalle class="box-body hidden">
                    <h4 >El Contribuyente tiene <span class="bold" meses></span> Mes(es) Mora.</h4>
                    <h4 >El Contribuyente tiene <span class="bold" permiso></span> Permiso(s) Mora.</h4>
                </div>
                <div class="box-footer">
                    <span class="box-title pull-right bold hidden" noHabil style="color:red;">
                        Contribuyente no Hábil para Certificado
                    </span>
                    <span class="box-title pull-right bold hidden" Habil style="color:#008d4c;">
                        Contribuyente Hábil para Certificado
                    </span>
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
                <button generar type="button" class="btn btn-primary hidden">
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

<script src="recurso/Vista/ServicioAdministrativo/CertificadoNoAdeudar.js" type="text/javascript"></script>
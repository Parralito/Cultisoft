<!DOCTYPE html>
<section class="content-header">
    <h1>
        Anulación Guía
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
                                        <input name="cedula" type="text" class="form-control" required readonly style="width: 60%;margin-right:10px;">
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

                        <div table>
                            <table 
                                id="tbDetalleGuia"
                                data-ajax="tbDetalleGuiasxContribuyente"
                                data-query-params="fn_query">
                                <thead>
                                    <tr>
                                        <th data-field="ccaapp" class="col-md-1">Clave Agua</th>
                                        <th data-field="fecha" data-formatter="defaultFecha" data-align="center" class="col-md-1">Fecha</th>
                                        <th data-field="fechacancelacion" data-formatter="defaultFecha" data-align="center" class="col-md-1">Fecha Cancelación</th>
                                        <th data-field="lugar">Localización</th>
                                        <th data-field="categoria" class="col-md-2">Categoría</th>
                                        <th data-field="ccpredio">Clave Predio</th>
                                        <!--<th data-field="cMes" class="col-md-1" data-align="center">Cant. Mes (es)</th>-->
                                                                                <!--<th class="col-md-1" data-formatter="btnEditarGuia" data-events="evtSelect" data-align="center">Acción</th>-->
                                        <th class="col-md-1" data-formatter="BtnAnular" data-events="evtSelect" data-align="center">Anular</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
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

<script src="recurso/Vista/Guia/AnulacionGuia.js" type="text/javascript"></script>

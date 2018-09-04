<!DOCTYPE html>
<section class="content-header">
    <h1>
        Cultivos - Estudiantes
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
                            Estudiante
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
                                data-query-params="fn_query"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <!--<th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>-->                                        
                                        <th data-field="fecha" data-formatter="defaultFecha" data-align="center" class="col-md-1">Fecha de Siembra</th>
                                        <th data-field="lugar">Localización</th>
                                        <th data-field="categoria">Textura</th>
                                        <!--<th data-field="ciu">CIU</th>-->
                                        <th data-field="ccpredio">Propietario</th>
                                        <th data-field="ccaapp" class="col-md-1">Celular Propietario</th>
                                        <!--<th data-field="cMes" class="col-md-1" data-align="center">Cant. Mes (es)</th>-->
                                                                                <!--<th class="col-md-1" data-formatter="btnEditarGuia" data-events="evtSelect" data-align="center">Acción</th>-->
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
        <form id="frm" savePersonalizado action="_guia" role="guias" class="center-block">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-pencil-alt"></i>
                            Datos Generales
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Fecha de Siembra</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" name="fecha" data-tipo="day" dt-tipo="day" readonly required>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Nombre Propietario</label>
                                    <input type="text" name="ccpredio" class="form-control" required>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Celular</label>
                                    <input type="text" name="ccaapp" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" detalle>
                            <div class="col-md-4">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Hectáreas</label>
                                    <input type="text" mensualidad data-tipo="myDecimal" class="form-control" required>
                                </div>
                                <div class="form-group form-group-sm hidden">
                                    <label for="" class="control-label">Descuento</label>
                                    <input type="text" descuento data-tipo="myPorcentaje" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-globe"></i>
                            Datos del Terreno
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Ciudad</label>
                                    <div class="inputComponent" init dt-fn="cboCiudad">
                                        <select name="idciudad" class="form-control selectpicker" data-size="5" required></select>
                                        <button refresh type="button" class="btn btn-success btn-sm hidden"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Parroquia</label>
                                    <select name="idparroquia" class="form-control selectpicker" data-size="5" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Profundidad del Suelo</label>
                                    <div class="inputComponent" init dt-fn="cboRuta">
                                        <select name="idruta" class="form-control selectpicker" data-size="5" required ></select>
                                        <button refresh type="button" class="btn btn-success btn-sm hidden"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Maleza</label>
                                    <select name="idsector" class="form-control selectpicker" data-size="5" required></select>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Textura</label>
                                    <div class="inputComponent" init dt-fn="cboCategoria">
                                        <select name="idcategoria" class="form-control selectpicker" data-width="75%" required></select>
                                        <div>
                                            <!--<button type="button" class="btn btn-info btn-sm" style="margin-right: 3px;"><i class="fa fa-plus"></i></button>-->
                                            <button refresh type="button" class="btn btn-success btn-sm"><i class="fa fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Dirección</label>
                                    <textarea name="direccion" rows="1" maxlength="80" style="resize: none" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">     
                            <div class="col-md-12">
                                <input id="input-id" name="input-id[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
                            </div>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>

        </form>
    </div>
    
</section>


<div class="modal fade in" id="modal-inactivar" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="fa fa-times-circle"></i> INACTIVAR</h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-group-sm">
                    <label for="" class="control-label">Motivo de la inactivación</label>
                    <textarea name="observacion" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button id="btnInactivarGuia" class="btn btn-danger">INACTIVAR</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade in" id="modal-contribuyente" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="fa fa-search"></i> Buscar Estudiante</h4>
            </div>
            <div class="modal-body">
                <table
                    id="tbContribuyente"
                    class="table table-striped table-bordered table-hover"
                    init
                    data-ajax="tbUsuario">
                    <thead>
                        <tr>
                            <th data-field="identificacion">Identificación</th>
                            <th data-field="nombres">Nombre</th>                            
                            <th data-field="username">Usuario</th>
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

<script src="recurso/Vista/Guia/GuiaContribuyente.js" type="text/javascript"></script>
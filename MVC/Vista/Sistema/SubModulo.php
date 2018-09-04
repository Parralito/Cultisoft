<!DOCTYPE html>
<section class="content-header">
    <h1>
        SubMódulos
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Listado>
        <div id="toolbar" class="btn-group">
            <button initRegistro type="button" name="btn_add" class="btn btn-sm btn-success">
                <i class="glyphicon glyphicon-plus"></i> Agregar
            </button>
            <button type="button" name="btn_del" class="btn btn-sm btn-danger">
                <i class="glyphicon glyphicon-trash"></i> Eliminar
            </button>
        </div>
        <table
            class="table table-striped table-bordered table-hover"
            init
            data-toolbar="#toolbar"
            data-ajax="tbSubModulo"
            data-response-handler="responseHandlerSelect"
            >
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="descripcion">Descripción</th>
                    <th data-field="icon" data-formatter="formatIcon" data-align="center">Icono</th>
                    <th data-field="modulo">Módulo</th>
                    <th data-field="estado" data-formatter="getEstado">Estado</th>
                    <th data-field="accion" class="col-md-1" data-align="center" data-formatter="defaultBtnAccion" data-events="defaultEvent" >Acción</th>
                </tr>
            </thead>
        </table>
    </div>
    <div Registro class="hidden">
        <form save action="_sistema" role="submodulo">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-pencil-alt"></i> Datos Generales</h3>
                </div>
                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Icono</label>
                                    <select id="cboIcon" class="form-control selectpicker" data-live-search="true" data-size="7" required>
                                        <?php
                                        include '../Recursos/Icons.php';
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <i  id="icono" class="fa fa-folder-open fa-4x" ></i>
                                <input type="hidden" name="icon" value="folder-open" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Módulo</label>
                                    <div tipo  data-fn="selectModulo"  >
                                        <div class="selectpickerComponent">
                                            <select name="idmodulo" data-fn="cboModulo" class="form-control selectpicker" required></select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Estado</label>
                                    <select name="estado" class="form-control selectpicker" required>
                                        <option value="ACT">Activo</option>
                                        <option value="INA">Inactivo</option>
                                        <option value="BLO">Bloqueado</option>
                                        <option value="ELI">Eliminado</option>
                                    </select>
                                </div>



                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Ruta / Formulario</label>
                            <input type="text" name="ruta" class="form-control" required>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group  form-group-sm">
                            <label for="" class="control-label">Observación</label>
                            <textarea rows="4" name="observacion" class="form-control"></textarea>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">
                                <!--Discapacidad-->
                                <div class="material-switch pull-left">
                                    <span style="font-weight: bold;">Catálogo</span>   &nbsp;&nbsp;
                                    <input id="catalogo" name="catalogo" type="checkbox" data-tipo="checkbox"/>
                                    <label for="catalogo" class="label-primary"></label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <button type="reset" class="btn btn-danger">
                            <i class="fa fa-reply"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="recurso/Vista/Sistema/SubModulo.js" type="text/javascript"></script>
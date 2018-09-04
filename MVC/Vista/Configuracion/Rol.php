<!DOCTYPE html>
<section class="content-header">
    <h1>
        Roles
    </h1>
    <hr class="style8"> 
</section>
<section class="content container-fluid">
    <div Listado>
        <div id="toolbar" class="btn-group">
            <button viewReset type="button" name="btn_add" class="btn btn-sm btn-success">
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
            data-ajax="tbRol"
            data-response-handler="responseHandlerSelect"
            >
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="descripcion">Descripción</th>
                    <th data-field="estado" data-formatter="getEstado">Estado</th>
                    <th data-field="accion" class="col-md-1" data-align="center" data-formatter="defaultBtnAccion" data-events="defaultEvent" >Acción</th>
                </tr>
            </thead>
        </table>
    </div>
    <div Registro class="hidden">
        <form save_fn action="_configuracion" role="rol" class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <i class="fa fa-pencil-alt"></i> Datos Generales</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Descripción</label>
                            <input name="descripcion" type="text" class="form-control" required>
                        </div>

                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Estado</label>
                            <select name="estado" class="form-control selectpicker" required>
                                <option value="ACT">Activo</option>
                                <option value="INA">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Descripción</label>
                            <textarea name="observacion" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <i class="fa fa-pencil-alt"></i> Asignar Permisos</h3>
                    </div>
                    <div class="box-body">
                        <table
                            id="tbPermisoRol"
                            data-ajax="tbPermisoRol"
                            data-show-refresh="true"
                            data-click-to-select="true">
                            <thead>
                                <tr>
                                    <th data-field="state" data-checkbox="true"></th>
                                    <th data-field="modulo">Módulo</th>
                                    <th data-field="grupo">Grupo</th>
                                    <th data-field="descripcion">Descripción</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
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
        </form>
    </div>
</section>

<script src="recurso/Vista/Configuracion/Rol.js" type="text/javascript"></script>
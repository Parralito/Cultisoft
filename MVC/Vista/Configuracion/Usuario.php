<!DOCTYPE html>
<section class="content-header">
    <h1>
        Usuario
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Listado>
        <div id="toolbar" class="btn-group">
            <button type="button" name="btn_add" class="btn btn-sm btn-success">
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
            data-ajax="tbUsuario"
            data-response-handler="responseHandlerSelect"
            >
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="identificacion">Identificación</th>
                    <th data-field="nombres">Nombres</th>
                    <th data-field="rol">Rol</th>
                    <th data-field="username">Usuario</th>
                    <th data-field="accion" class="col-md-1" data-align="center" data-formatter="defaultBtnAccion" data-events="defaultEvent" >Acción</th>
                </tr>
            </thead>
        </table>
    </div>
    <div Registro class="hidden row">
        <form save action="_configuracion" role="usuario" class="col-md-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-pencil-alt"></i> Datos Generales</h3>
                </div>
                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Identificación</label>
                                    <input name="identificacion" type="text" class="form-control solo-numero" maxlength="10" placeholder="Cédula del Usuario" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-xs-offset-2">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Permiso</label>
                                    <select name="permiso" class="form-control selectpicker" >
                                        <option value="R">Lectura</option>
                                        <option value="R_W">Lectura y Escritura</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Nombres</label>
                                    <input name="nombres" type="text" class="form-control" placeholder="Apellidos y Nombres Completos" required>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Celular</label>
                                    <input name="firma" type="text" class="form-control" placeholder="Celuar" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Rol</label>
                                    <select name="idrol" class="form-control selectpicker" data-fn="cboRol"></select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Edad</label>
                                    <input name="coddocumento" type="text" class="form-control" placeholder="Edad." required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Username</label>
                                    <input name="username" type="text" class="form-control" placeholder="Nombre de Usuario" required>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Password</label>
                                    <input name="pass" type="password" class="form-control" placeholder="Contraseña de Usuario" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <button type="reset" class="btn btn-danger">
                    <i class="fa fa-reply"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</section>

<script src="recurso/Vista/Configuracion/Usuario.js" type="text/javascript"></script>
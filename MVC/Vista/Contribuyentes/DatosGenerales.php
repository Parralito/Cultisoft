<!DOCTYPE html>
<section class="content-header">
    <h1>
        Datos Generales
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Listado>
        <div id="toolbar" class="btn-group">
            <button type="button" name="btn_add" class="btn btn-sm btn-success">
                <i class="glyphicon glyphicon-plus"></i> Agregar
            </button>
            <!--            <button type="button" name="btn_del" class="btn btn-sm btn-danger">
                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                        </button>-->
        </div>
        <table
            class="table table-striped table-bordered table-hover"
            init
            data-toolbar="#toolbar"
            data-ajax="tbContribuyentes"
            data-response-handler="responseHandlerSelect"
            >
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="nombre">Nombre</th>
                    <th data-field="cedula" >Identificación</th>
                    <th data-field="direccion">Dirección</th>
                    <th data-field="telefono">Teléfono</th>
                    <th data-field="email">Email</th>
                    <th data-field="accion" class="col-md-1" data-align="center" data-formatter="defaultBtnAccion" data-events="defaultEvent" >Acción</th>
                </tr>
            </thead>
        </table>
    </div>
    <div Registro class="hidden">
        <form save_fn action="_contribuyente" role="contribuyente">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-pencil-alt"></i> Datos Generales</h3>
                </div>
                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Tipo Identificación</label>
                            <select name="idtipoidentificacion" class="form-control selectpicker" required>
                                <option value="1">Cédula</option>
                                <option value="2">RUC</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Identificación</label>
                                    <input type="text" class="form-control solo-numero" maxlength="10" name="cedula" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">CIU</label>
                                    <input type="text" class="form-control" name="ciu" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Nombres</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="row">
                            <!--                            <div class="col-md-4">
                                                            <div class="form-group form-group-sm">
                                                                <label for="" class="control-label">Descuento</label>
                                                                <input name="descuento" data-tipo="myPorcentaje" type="text" value="0" class="form-control input-sm" placeholder="% Descuento" >
                                                            </div>
                                                        </div>-->
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Teléfono</label>
                                    <input type="text" class="form-control" maxlength="10" name="telefono">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6">

                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Dirección</label>
                            <textarea name="direccion" rows="1" maxlength="80" style="resize: none" class="form-control"></textarea>
                        </div>


                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">
                                <!--Discapacidad-->
                                <div class="material-switch pull-left">
                                    <span style="font-weight: bold;">Descuento</span>   &nbsp;&nbsp;
                                    <input id="descuento" name="descuento" type="checkbox" data-tipo="checkbox"/>
                                    <label for="descuento" class="label-primary"></label>
                                </div>
                            </label>
                        </div>
                        <div class="form-group form-group-sm">
                            <!--<label for="" class="control-label">Descripción Descuento</label>-->
                            <textarea name="descripcion_descuento"  placeholder="Descripción Descuento" rows="1" maxlength="80" style="resize: none" class="form-control"></textarea>
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

<script src="recurso/Vista/Contribuyentes/DatosGenerales.js" type="text/javascript"></script>
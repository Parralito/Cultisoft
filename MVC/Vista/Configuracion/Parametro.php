<!DOCTYPE html>
<section class="content-header">
    <h1>
        Parámetro
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
            data-ajax="tbParametro"
            data-response-handler="responseHandlerSelect"
            >
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="descripcion">Descripción</th>
                    <th data-field="valor">Valor</th>
                    <th data-field="accion" class="col-md-1" data-align="center" data-formatter="defaultBtnAccion" data-events="defaultEvent" >Acción</th>
                </tr>
            </thead>
        </table>
    </div>
    <div Registro class="hidden row">
        <form save action="_configuracion" role="parametro" class="col-md-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-pencil-alt"></i> Datos Generales</h3>
                </div>
                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Descripción</label>
                            <input name="descripcion" type="text" class="form-control" required>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Valor</label>
                            <input name="valor" type="text" class="form-control" value="0" required data-tipo="myDecimal">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Descripción</label>
                            <textarea name="observacion" rows="4" class="form-control"></textarea>
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

<script src="recurso/Vista/Configuracion/Parametro.js" type="text/javascript"></script>
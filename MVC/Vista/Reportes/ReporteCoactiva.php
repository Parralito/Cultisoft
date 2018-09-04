<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reportes Cobranzas
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid flex-row">
    <div class="box box-info" style="width: 40%;">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="fa fa-file-excel"></i> Reporte</h3>
        </div>
        <div class="box-body row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label for="" class="control-label">Tipo</label>
                    <div class="inputComponent"  >
                        <select name="tipo" class="selectpicker form-control" data-width='80%'></select>
                    </div>
                </div>
                <div fecha class="form-group  form-group-sm">
                    <label>Escoger rango:</label>

                    <div class="input-group">
                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                            <span>
                                <i class="fa fa-calendar"></i> Fechas
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button id="generarReporte" class="btn btn-primary btn-sm"><i class="fa fa-file-excel"></i> Generar </button>
            </div>
        </div>
    </div>
</section>

<script src="recurso/Vista/Reportes/ReporteCoactiva.js" type="text/javascript"></script>
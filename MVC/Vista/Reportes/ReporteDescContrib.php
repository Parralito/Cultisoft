<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reportes de Contribuyentes 
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div class="row">        
        <div class="col-md-4 col-md-offset-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-file-excel"></i> Reporte Contribuyentes</h3>                               
                </div>
                <div class="box-body row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">Documentos</label>
                            <div class="inputComponent"  >
                                <select name="documentos" class="selectpicker form-control" data-width='80%'></select>
                            </div>
                        </div>

                        <div class="form-group hidden  form-group-sm" fechasrango>
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
                <div class="box-header with-border text-center">
                    <button id="generarReporte" class="btn btn-primary btn-sm"><i class="fa fa-file-excel"></i> Generar </button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.modal-content -->
<!-- /.modal-dialog -->


<script src="recurso/Vista/Reportes/ReporteContrib.js" type="text/javascript"></script>
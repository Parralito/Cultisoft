<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reportes Recaudación Total Diaria
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid flex-row">
    <div class="box box-info" style="width: 40%;">
        <div class="box-header with-border">
            <h3 class="box-title"> <i class="fa fa-file-excel"></i> Reporte Consolidado</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <!-- /.box-header -->
                    <div class="box-body" Contribuyente>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <!--<label for="" class="control-label">Identificación</label>-->
                                    <label for="" class="control-label"><i class="fa fa-user"></i> Usuario </label>
                                    <div class="searchComponent">
                                        <input name="id" type="text" class="hidden" readonly>
                                        <input type="text" class="form-control" name="nombres" readonly>                                        
                                    </div>                                    
                                </div>
                                <div class="form-group  form-group-sm">
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
<div class="modal fade in" id="modal-contribuyente" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="fa fa-search"></i> Buscar Usuario</h4>
            </div>
            <!--            <div class="modal-body">
                            <table
                                id="tbUsuario"
                                class="table table-striped table-bordered table-hover"
                                init
                                data-ajax="">
                                <thead>
                                    <tr>
                                        <th data-field="identificacion">Identificación</th>
                                        <th data-field="nombres">Nombre</th> 
                                         <th data-field="coddocumento">Cod.Documento</th> 
                                        <th data-formatter="btnSelect" data-events="evtSelect">Selec.</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>-->
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>-->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script src="recurso/Vista/Reportes/ReporteRecaudUsuario.js" type="text/javascript"></script>
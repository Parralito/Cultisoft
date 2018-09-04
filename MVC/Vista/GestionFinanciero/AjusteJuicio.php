<!DOCTYPE html>
<section class="content-header">
    <h1>
        Ajuste Juicio Coactiva
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro >
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-user"></i>
                            Contribuyente
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body" Contribuyente>
                        <div class="row">
                            <div class="col-md-6">
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
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Nombres</label>
                                    <input type="text" class="form-control" name="nombre" readonly>
                                </div>
                            </div>
                        </div>
                        <table id="tbDetalleGuia"
                               data-toolbar="#toolbar"
                               data-ajax="tbGuiasxContribuyenteCoactivaMig"
                               data-query-params="fn_query">
                            <thead>
                                <tr>
                                    <th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>                                                                        
                                    <th data-field="lugar">Lugar</th>
                                    <th data-field="categoria">Categoría</th>     
                                    <th data-field="ccaapp">Clave Agua</th>      
                                    <th data-field="ccpredio">Clave Predio</th>
                                    <!--<th data-field="cMes" >Cant.Meses</th>-->
                                    <th class="col-md-1" data-formatter="btnEditarGuia" data-events="evtSelect" data-align="center">Editar Juicio</th>                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row hidden" new>
            <form savePersonalizado action="_financiero" role="AJUSTEJUICIO">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-info" GuiaJuicio>
                        <div class="box-header with-border">
                            <input name="idjuiciocoactivo" type="text" class="hidden" readonly>
                            <h3 class="box-title">
                                <i class="fa fa-calendar"></i>
                                Datos del juicio
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" DatosDeuda>
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm">
                                        <label for="" class="control-label">
                                            Total de la deuda
                                        </label>
                                        <div style="display: flex; flex-flow: row; justify-content: flex-start;"  >                                            
                                            <input type="text" name="deuda" data-tipo="myDecimal" class="form-control input-sm" placeholder=""  required="">
                                        </div>
                                    </div>                                    
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm">
                                        <label for="" class="control-label">
                                            Total de Entrada
                                        </label>
                                        <div style="display: flex; flex-flow: row; justify-content: flex-start;"  >                                            
                                            <input pagoentrada name="entrada" data-tipo="myDecimal" type="text" class="form-control input-sm" placeholder=""  required="">
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm">
                                        <label for="" class="control-label">
                                            Total Abonado
                                        </label>
                                        <div style="display: flex; flex-flow: row; justify-content: flex-start;"  >                                            
                                            <input name="abonado" type="text" data-tipo="myDecimal" class="form-control input-sm" placeholder=""  required="">
                                        </div>
                                    </div>          
                                </div>      
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm">
                                        <label for="" class="control-label">
                                            Saldo
                                        </label>
                                        <div style="display: flex; flex-flow: row; justify-content: flex-start;"  >                                            
                                            <input name="saldo" type="text"  style="text-align: right;" class="form-control input-sm" placeholder=""  required="" readonly>
                                        </div>
                                    </div>          
                                </div>  
                            </div>
                            <div class="col-md-5">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Fecha Inicio Plazo:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control " name="fechainicioplazo" data-tipo="fechaView" readonly required>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-md-5">  
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Fecha Fin Plazo:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control " name="fechafinplazo" data-tipo="fechaView" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">N° meses</label>
                                    <input type="number" class="form-control solo-numero" min="1" max="24" name="nmeses" value="1">                                    
                                </div>      
                            </div>     
                            <div class="form-group form-group-sm text-center">
                                <label for="" class="control-label"></label>
                                <button calcular type="button" class="btn btn-info">
                                    <i class="fa fa-calculator"></i> Calcular
                                </button>
                            </div>  
                        </div>
                        <div class="box-footer with-border">
                            <div class="form-group form-group-sm text-right">
                                <label for="" class="control-label"></label>
                                <button guardar type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            </div>  
                        </div>                        
                    </div>
                </div>
            </form>
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
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>-->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="recurso/Vista/GestionFinanciero/AjusteJuicio.js" type="text/javascript"></script>
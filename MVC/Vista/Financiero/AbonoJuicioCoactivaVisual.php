<!DOCTYPE html>
<section class="content-header">
    <h1>
        Abono Juicio Coactiva
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
                               data-ajax="tbGuiasxContribuyenteCoactivaReg"
                               data-query-params="fn_query">
                            <thead>
                                <tr>
                                    <th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>                                                                        
                                    <th data-field="lugar">Lugar</th>
                                    <th data-field="categoria">Categoría</th>     
                                    <th data-field="ccaapp">Clave Agua</th>      
                                    <th data-field="ccpredio">Clave Predio</th>
                                    <!--<th data-field="cMes" >Cant.Meses</th>-->
                                    <th class="col-md-1" data-formatter="btnEditarGuia" data-events="evtSelect" data-align="center">Abonar Juicio</th>                                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row hidden" new>
            <form savePersonalizado action="_financiero" role="ABONO">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box box-info">

                            <div class="box-header with-border">
                                <input name="idjuiciocoactivo" type="text" class="hidden" readonly>
                                <input name="idguias" type="text" class="hidden" readonly>
                                <h3 class="box-title">
                                    <i class="fa fa-calendar"></i>
                                    Datos de la deuda
                                </h3>
                                <h3 class="box-title pull-right" style="color:red">
                                    <b>TOTAL ($)</b>
                                    <label cl name="lbtotal"></label>
                                    <input type="hidden" name="deuda">
                                </h3>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" DatosDeuda>
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm">
                                        <label class="control-label">Fecha Inicio Deuda:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control " name="fechainiciodeuda" data-tipo="fechaView" readonly required>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm">
                                        <label class="control-label">Fecha Fin Deuda:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control " name="fechafindeuda" data-tipo="fechaView" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                
                        </div>
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fa fa-dollar-sign"></i>
                                    Entrada
                                </h3>     
                                <h3 jeditvalor class="box-title pull-right" style="color:green">
                                    <b>TOTAL ($)</b>
                                    <label cl name="lbentrada"></label>
                                </h3>
                            </div>
                        </div>                        
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-calendar-alt"></i>
                                        Plan de Pagos
                                    </h3>               
                                    <h3 jeditvalor class="box-title pull-right" style="color:green">
                                        <b>DEUDA DIFERIDA($)</b>
                                        <label cl name="lbdeudaentrada"></label>
                                    </h3>
                                </div>                                
                            </div>
                            <div class="box-body">
                                <div class="col-md-6">
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
                                <div class="col-md-6">  
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
                                <div class="col-md-6 hidden">
                                    <div class="form-group form-group-sm">
                                        <label for="" class="control-label">N° meses</label>
                                        <input type="text" class="form-control solo-numero" min="1" name="nmeses" readonly>
                                    </div>
                                </div>                               
                                <div class="col-md-6 hidden">
                                    <div class="form-group form-group-sm">
                                        <label for="" class="control-label">Mensualidad</label>
                                        <input type="text" class="form-control" name="mensual" readonly required>
                                    </div>
                                </div>
                            </div>           
                        </div>          
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fa fa-dollar-sign"></i>
                                    Abonos
                                </h3>     
                                <h3 jeditvalor class="box-title pull-right" style="color:green">
                                    <b>TOTAL ($)</b>
                                    <label cl name="lbabonado"></label>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="col-md-6">
                    <div class="box box-info">                                     
                        <div class="box-header with-border">
                            <h3 jeditvalor class="box-title pull-right" style="color:green">
                                <b>SALDO ($)</b>
                                <label cl name="lbsaldo"></label>
                            </h3>
                        </div>

                        <div class="box box-info">
                            <!--                            <div class="box-header with-border">
                                                            <h3 class="box-title">
                                                                <i class="fa fa-dollar-sign"></i>
                                                                Desglozado
                                                            </h3>
                                                            <h3 jeditvalor class="box-title pull-right" style="color:green">
                                                                <b>SALDO ($)</b>
                                                                <label cl name="lbsaldo"></label>
                                                            </h3>
                                                        </div>-->
                            <div class="box-body row vdivide">
                                <div class="col-md-12   ">
                                    <table  id="tbValoresFinalesValores" >
                                        <thead>
                                            <tr>
                                                <th data-field="meses" data-tipo="fechaView" data-align="center">Meses</th>
                                                <th data-field="mensualidad" data-formatter="formatInputMask" data-align="center">Mensualidad</th>
                                                <th data-field="total" data-align="center" data-formatter="formatInputMask">Abonado</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <br>
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
                        </div>
                    </div>
            </form>
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

<script src="recurso/Vista/Financiero/AbonoJuicioCoactiva.js" type="text/javascript"></script>

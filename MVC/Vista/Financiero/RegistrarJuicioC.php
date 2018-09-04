<!DOCTYPE html>
<section class="content-header">
    <h1>
        Registrar Convenio de Cobranzas
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro class="">
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
                            <div class="col-md-5">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Identificación</label>
                                    <div class="searchComponent">
                                        <input name="id" type="text" class="hidden" readonly>
                                        <input name="detalleContribuyente" type="text" class="form-control" required readonly style="width: 60%;margin-right:10px;">
                                        <button type="button" class="btn btn-info btn-sm" style="margin-right:5px;" data-toggle="modal" data-target="#modal-contribuyente">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button clear type="button" class="btn btn-danger btn-sm">
                                            <i class="fa fa-times"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div table>
                            <table 
                                id="tbDetalleGuia"
                                
                                data-ajax="tbGuiasxContribuyenteCoactiva"
                                data-query-params="fn_query">
                                <thead>
                                    <tr>
                                        <th data-field="lugar">Localización</th>
                                        <th data-field="ccaapp">CCAAPP</th>
                                        <th data-field="categoria" class="col-md-1">Categoría</th>
                                        <th data-field="descuento" data-formatter="formatNumPorcent" data-align="center" class="col-md-1">Descuento</th>
                                        <th data-field="MesUltimoPago" class="col-md-2" data-align="center">Mes Ultimo Pago</th>

                                        <th data-field="ccpredio" class="col-md-1" data-align="center">CPredio</th>
                                        <th data-field="cMes" class="col-md-1" data-align="center" data-formatter="cMesformat">Cant. Meses</th>
                                        <th data-field="jc" class="col-md-1" data-formatter="estadoJC" data-events="evtSelect" data-align="center">Juicio Cobranza</th>
                                        <th data-field="estadoDeuda" class="col-md-1" data-align="center" data-formatter="btnPagoMensual" data-events="evtSelect" >Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="row hidden" new>
        <!--<div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-user"></i>
                        Detalle Mensualidad
                    </h3>
                </div>
                <div class="box-body">
                    <table 
                        id="tbDetalleMensualidadAnual"
                        data-height="280">
                        <thead>
                            <tr>
                                <th data-field="año" data-align="center" class="col-md-2">Año</th>
                                <th data-field="Meses" data-align="center">Meses</th>
                                <th data-field="cantMes" data-align="center" class="col-md-1">Cant. Mes</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>-->

        <div class="col-md-4">
            <div class="box box-info" Mensualidad>
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-dollar-sign"></i>
                        Detalle Pago
                    </h3>
                    <span class="box-title pull-right bold" style="color:red;">
                        TOTAL ($) <span total></span>
                    </span>
                </div>
                <div class="box-body row vdivide">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group form-group-sm" pm>
                                    <label for="" class="control-label">Meses a pagar</label>
                                    <input type="number" name="cantMes" min="1" value="1" class="form-control">
                                </div>
                                <div class="form-group form-group-sm" jp>
                                    <label for="" class="control-label">T. Parcial</label>
                                    <select name="tiempos" class="selectpicker form-control" data-width="250px"></select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="pull-right">
                                    <a href="#" title="Editar Porcentajes" data-toggle="modal" data-target="#modal_edit" style="color: red;"><i class="fa fa-edit"></i></a>
                                </div>
                            </div>
                        </div>
                        <table id="tbValoresFinales" >
                            <thead>
                                <tr>
                                    <th data-field="descripcion" data-align="center">Descripción</th>
                                    <th data-field="valor" data-align="center" class="col-md-3" data-formatter="formatInputMask">Valor</th>
                                    <th data-field="total" data-align="center" class="col-md-3" data-formatter="formatInputMask">Total</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-arrow-circle-up"></i>
                        Entrada
                    </h3>
                </div>                                             
                <!-- /.box-header -->
                <div class="box-body" FechaPlazo>
                    <div class="row">  
                        <div class="col-md-12">
                            <table id="tbFormaPago">
                                <thead>
                                    <tr>
                                        <th data-field="descripcion">Forma de Pago</th>
                                        <th data-field="valor" data-formatter="imask" data-events="event_input" data-align="center" class="col-md-3">Valor</th>
                                        <th data-field="detalle" class="col-md-2" data-formatter="defaultInput" data-events="event_input_default">N Comprobante</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-calendar-alt"></i>
                            Plan de Pagos
                        </h3>               
                        <h3 jeditvalor class="box-title pull-right" style="color:green">
                            <b>VALOR A DIFERIR ($)</b>
                            <label cl name="lbdiferido"></label>
                            <input type="hidden" name="saldo">
                        </h3>
                    </div>                                
                </div>
                <div class="box-body">
                    <div class="col-md-4">
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
                    <div class="col-md-4">  
                        <div class="form-group form-group-sm">
                            <label class="control-label">Fecha Fin Plazo:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="fechafinplazo" data-tipo="fechaView" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-sm">
                            <label for="" class="control-label">N° meses</label>
                            <input type="number" class="form-control solo-numero" min="1" max="24" name="nmeses" value="1">
                        </div>
                    </div>                               
                    <div class="box-body row vdivide">
                        <div class="col-md-12   ">
                            <table  id="tbValoresFinalesValores" data-height="300" >
                                <thead>
                                    <tr>
                                        <th data-field="meses" data-tipo="fechaView" data-align="center">Meses</th>
                                        <th data-field="mensualidad" data-formatter="formatInputMask" data-align="center">Mensualidad</th>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                        </div>
                    </div>
                    <div class="box box-success">
                        <div class="box-header with-border">                                    
                            <div class="form-group form-group-sm text-center">
                                <label for="" class="control-label"></label>
                                <button calcular type="button" class="btn btn-primary">
                                    <i class="fa fa-calculator"></i> Calcular
                                </button>
                            </div>       
                        </div>
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
                <button save type="button" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</section>

<div class="modal fade in" id="modal-abono" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">
                    <i class="fa fa-user"></i>
                    Detalle abonos
                </h4>
            </div>
            <div class="modal-body">
                <table id="tbGeneraAbonos"
                       data-height="400">
                    <thead>
                        <tr>
                            <th data-field="Cod">Código</th>
                            <th data-field="fecha" data-formatter="formatViewComp">Fecha</th>
                            <th data-field="valor">Valor</th>                                    
                            <th data-field="estado" data-formatter="getEstado">Estado</th>                                                                        
                        </tr>
                    </thead>    
                </table>   
            </div>
        </div>
    </div>
</div>
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
                            <th data-formatter="btnSelect" data-events="evtSelect" class="col-md-1">Selec.</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade in" id="modal_edit" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="fa fa-dollar-sign"></i> Editar Porcentaje</h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-group-sm">
                    <label for="" class="control-label">Porcentaje de Cobranza</label>
                    <input type="text" p_cobranza data-tipo="myPorcentajeCobranza" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <!--<button class="btn btn-sm btn-danger"><i class="fa fa-reply"></i> Cancelar</button>-->
                    <button class="btn btn-sm btn-primary" change_porcentaje><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="recurso/Vista/Financiero/RegistrarJuicioC.js" type="text/javascript"></script>
<!DOCTYPE html>
<section class="content-header">
    <h1>
        Estado de Cuenta Contribuyente
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro>
        <div class="row">
            <div class="col-md-9">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-user"></i>
                            Contribuyente
                        </h3>
                    </div>
                    <div class="box-body" Contribuyente>
                        <div class="row">
                            <div class="col-md-12">
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
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-dollar-sign"></i>
                            Total a Pagar
                        </h3>
                        <h1 totalpagar style="color:#DD1144;text-align: center;font-size: 50px;font-weight: bold;"><b></b></h1>
                    </div>                                    
                </div>
            </div>
        </div>        
    </div>  
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-info"></i>
                        Planilla Mensual
                    </h3>
                </div>
                <div table>
                    <table 
                        id="tbDetalleGuia"
                        data-ajax="tbDetalleGuiasxContribuyenteG"
                        data-query-params="fn_query">
                        <!--data-response-handler="fn_response">-->
                        <thead>
                            <tr>
                                <th data-field="lugar">Localización</th>
                                <th data-field="ccaapp">CCAAPP</th>
                                <th data-field="categoria" class="col-md-1">Categoría</th>
                                <th data-field="ccpredio" class="col-md-1" data-align="center">CPredio</th>
                                <!--<th data-field="MesUltimoPago" class="col-md-2" data-align="center">Mes Ultimo Pago</th>-->                                
                                <th data-field="cMes" class="col-md-1" data-align="center" data-formatter="cMesformat">Cant. Meses</th>
                                <!--<th data-field="estadoDeuda" class="col-md-1" data-align="center" data-formatter="lblEstado" data-events="evtSelect" >Estado</th>-->
                                <th data-field="deuda" class="col-md-1" data-align="center" data-formatter="formatInputMask" >Deuda</th>                            

<!--<th data-field="" class="col-md-1" data-align="center" data-formatter="btnDetalle" data-events="evtSelect" >Detalle</th>-->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-balance-scale"></i>
                        Juicios Vigentes
                    </h3>
                </div>
                <div table>
                    <table 
                        id="tbDetalleGuiaJC"
                        data-ajax="tbDetalleGuiasxContribuyenteJC"
                        data-query-params="fn_queryJC">
                        <thead>
                            <tr>
                                <th data-field="lugar">Localización</th>
                                <th data-field="ccaapp">CCAAPP</th>
                                <th data-field="categoria" class="col-md-1">Categoría</th>
                                <th data-field="ccpredio" class="col-md-1" data-align="center">CPredio</th>
                                <th data-field="inicioplazo" data-align="center">Inicio Plazo</th>
                                <th data-field="finplazo" data-align="center">Fin Plazo</th>                                
                                <th data-field="deuda" class="col-md-1" data-align="center" data-formatter="">Deuda</th>
                                <th data-field="entrada" class="col-md-1" data-align="center" data-formatter="">Entrada</th>                            
                                <th data-field="abonado" class="col-md-1" data-align="center" data-formatter="">Abonado</th>                            
                                <th data-field="estado" class="col-md-1" data-align="center" data-formatter="lbEstado" data-events="evtSelect" >Estado</th>
                                <th data-field="saldo" class="col-md-1" data-align="center" data-formatter="formatInputMask">Saldo</th>                            

<!--<th data-field="" class="col-md-1" data-align="center" data-formatter="btnDetalle" data-events="evtSelect" >Detalle</th>-->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-tint fa-fw"></i> 
                        Permisos de conexión
                    </h3>
                </div>
                <table Permisos
                       data-ajax="loadPermisoContribuyente"
                       data-query-params="fn_queryPM">
                    <thead>
                        <tr>
                            <!--<th data-field="fechapermiso" data-formatter="defaultFecha" data-align="center" class="col-md-1">Fecha</th>-->
                            <th data-field="permiso" class="col-md-2">Tipo Permiso</th>                            
                            <th data-field="direccion" class="col-md-4">Dirección</th>
                            <th data-field="multa" class="col-md-1" data-align="center">Multa</th>
                            <th data-field="valor" class="col-md-1" data-align="center">Valor</th>                            
                            <th data-field="estado" class="col-md-1" data-align="center" data-formatter="lbEstado">Estado</th>    
                            <th data-field="total" class="col-md-1" data-align="center" data-formatter="lbTotalPermiso">Total</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="row hidden" new>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-user"></i>
                        Detalle Mensualidad
                    </h3>
                </div>
                <div class="box-body">
                    <table 
                        data-toolbar="#toolbar"
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
        </div>
        <div class="col-md-4">
            <div class="box box-info" Mensualidad dr="COBROMENSUAL">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-dollar-sign"></i>
                        Detalle Pago
                    </h3>
                    <span class="box-title pull-right bold" style="color:red;">
                        TOTAL ($) <span id="totalPM" total></span>
                    </span>
                </div>
                <div class="box-body row vdivide">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group form-group-sm">
                                    <label for="" class="control-label">Meses a pagar</label>
                                    <input type="number" name="cantMes" min="1" value="1" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="control-label" style="color:red;">Descuento</label>
                                <input type="text" descripcion_descuento class="form-control input-sm" disabled="true">
                            </div>
                        </div>
                        <table id="tbValoresFinales">
                            <thead>
                                <tr>
                                    <th data-field="descripcion" data-align="center">Descripción</th>
                                    <th data-field="valor" data-align="center" class="col-md-3" data-formatter="formatNumTipo">Valor</th>
                                    <th data-field="total" data-align="center" class="col-md-3" data-formatter="formatInputMask">Total</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-info" Cobranza dr="COBROMENSUALJC">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-dollar-sign"></i>
                        Detalle Cobranza
                    </h3>
                    <span class="box-title pull-right bold" style="color:red;">
                        TOTAL ($) <span id="totalJC" total></span>
                    </span>
                </div>
                <div class="box-body row vdivide">
                    <div class="col-md-6">
                        <label for="" class="control-label">Valores</label>
                        <table  id="tbValoresFinalesValores" >
                            <thead>
                                <tr>
                                    <th data-field="descripcion" data-align="center">Valores</th>
                                    <th data-field="valor" data-align="center" data-formatter="formatInputMask">$</th>
                                    <th data-field="total" data-align="center" class="col-md-3" data-formatter="formatInputMask">Valor</th>
                                </tr>
                            </thead>
                        </table>     
                    </div>  
                    <div class="col-md-6">
                        <label for="" class="control-label">Impuestos</label>
                        <table  id="tbValoresFinalesCobranza" >
                            <thead>
                                <tr>
                                    <th data-field="descripcion" data-align="center">Impuesto</th>
                                    <th data-field="valor" data-align="center" data-formatter="formatInputMask">%</th>
                                    <th data-field="total" data-align="center" class="col-md-3" data-formatter="formatInputMask">Valor</th>
                                </tr>
                            </thead>
                        </table>
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


<script src="recurso/Vista/Contribuyentes/EstadoCuenta.js" type="text/javascript"></script>
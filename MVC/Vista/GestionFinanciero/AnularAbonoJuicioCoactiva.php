<!DOCTYPE html>
<section class="content-header">
    <h1>
        Anular Abono Juicio Coactiva
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
                               data-ajax="tbGuiasxContribuyenteCoactivaReg"
                               data-query-params="fn_query">
                            <thead>
                                <tr>
                                    <th class="col-md-1" data-formatter="rowCount" data-align="center" >N°</th>                                                                        
                                    <th data-field="lugar">Lugar</th>
                                    <th data-field="categoria">Categoría</th>                                    
                                    <th data-field="ccaapp">Clave Agua</th>      
                                    <th data-field="ccpredio">Clave Predio</th>      
                                    <th data-field="MesUltimoPago">Mes Último pago</th>                                                                        
                                    <th data-field="Estado" data-formatter="getEstado">Estado</th>
                                    <th class="col-md-1"    data-formatter="btnEditarGuia" data-events="evtSelect" data-align="center">Listar abonos</th>                                    
                                </tr>
                                <input name="idguia" type="text" class="hidden" readonly>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row hidden" new>
            <form savePersonalizado action="_financiero" role="ABONO">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-calendar"></i>
                                Abonos realizados
                            </h3>
                        </div>                      
                        <input name="idjuicio" type="text" class="hidden" readonly>                        
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="tbGeneraAbonos"
                                   data-height="400"
                                   data-toolbar="#toolbar"
                                   >
                                <thead>
                                    <tr>
                                        <th data-field="Cod">Código</th>    
                                        <th data-field="user">Usuario Reg.</th>    
                                        <th data-field="fecha" data-formatter="formatViewComp">Fecha</th>
                                        <th data-field="valor">Valor</th>                                    
                                        <th data-field="estado" data-formatter="getEstado">Estado</th>                                                                        
                                        <th class="col-md-1" data-formatter="BtnAccion" data-events="evtSelect" data-align="center">Acción</th>                                 
                                    </tr>
                                    <input name="Cod" type="text" class="hidden" readonly>
                                    <input name="idabono" type="text" class="hidden" readonly>
                                    <input name="fechaabono" type="text" class="hidden" readonly>
                                </thead>    
                            </table>    
                        </div>
                    </div>
                </div>
                <div Anular class="col-md-6 hidden">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa fa-trash-alt"></i>
                                Anular Abono de ($)
                            </h3>
                            <label class="box-title" name="abono"></label>
                        </div>                      
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group form-group-sm">
                                <label for="" class="control-label">Descripción</label>
                                <textarea motivo class="form-control" name="direccion" required cols="30" rows="1" maxlength="68" style="resize: none;" placeholder="Ingrese el motivo por el cual se realiza la anulación del abono"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button anular type="button" class="btn btn-danger">Anular</button>
                        </div>
                    </div>
                </div>
                <div Reimprimir class="col-md-6 hidden">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-dollar-sign"></i>
                                Reimprimir abono de ($)
                            </h3>
                            <label class="box-title" name="abono"></label>
                            <span class="box-title pull-right bold" style="color:red;">
                                VALOR REIMPRESIÓN($) <span id="totalimp"></span>
                            </span>
                        </div>
                        <div class="box-body">
                            <table id="tbFormaPago">
                                <thead>
                                    <tr>
                                        <th data-field="descripcion">Forma de Pago</th>
                                        <th data-field="valor" data-formatter="imask" data-events="event_input" data-align="center" class="col-md-3">Valor</th>
                                        <th data-field="detalle" class="col-md-2" data-formatter="defaultInput" data-events="event_input_default">N° Comprobante</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                         <div class="modal-footer">
                            <button reimprimir type="button" class="btn btn-info">Reimprimir</button>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
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

<script src="recurso/Vista/GestionFinanciero/AnularAbonoJuicioCoactiva.js" type="text/javascript"></script>
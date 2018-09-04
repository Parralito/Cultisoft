<!DOCTYPE html>
<section class="content-header">
    <h1>
        Auditoría Contribuyente
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro>
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
                            <div class="col-md-5">
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <div new class="row hidden" >
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-user"></i>
                        Historial de cambios
                    </h3>
                </div>
                <div class="box-body">
                    <table 
                        id="tbDetalleMensualidad"
                        data-ajax="tbDetalleAuditContrib"
                        data-query-params="fn_queryaudit"
                        data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="fecha" data-align="center" data-formatter="formatViewComp">Fecha de evento</th>
                                <th data-field="user" data-align="center" >Usuario</th>
                                <th data-field="cedula" data-align="center" >Cédula</th>
                                <th data-field="nombre" data-align="center">Nombre</th>
                                <th data-field="direccion" data-align="center">Dirección</th>
                                <th data-field="telefono" data-align="center" >Teléfono</th>
                                <th data-field="email" data-align="center">Email</th>
                                <th data-field="ciu" data-align="center">CIU</th>
                                <th data-field="descuento" data-formatter="BoolDescuento" data-align="center">Desc.</th>
                                <th data-field="descripcion_descuento" data-align="center">Motivo Desc.</th>
                                <th data-field="fecharegdesc"  data-align="center">Descuento desde</th>                                
                                <th data-field="accion" data-formatter="Accionuser" data-align="center">Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button clean type="button" class="btn btn-danger">
                                <i class="fa fa-reply"></i> Cancelar
                            </button>

                        </div>
                    </div>
                </div>
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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="recurso/Vista/Auditoria/Contribuyente.js" type="text/javascript"></script>
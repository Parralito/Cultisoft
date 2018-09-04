<!DOCTYPE html>
<section class="content-header">
    <h1>
        Guía
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div Registro>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
<!--                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-user"></i>
                            Contribuyente
                        </h3>
                    </div>-->
                    <div class="box-body" Contribuyente>
                        <div table>
                            <div id="toolbar">
                            </div>
                            <table 
                                data-ajax="tbGuia"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="fecha" data-formatter="defaultFecha" class="col-md-1">Fecha</th>
                                        <th data-field="cedula">Cédula</th>
                                        <th data-field="contribuyente" >Contribuyente</th>
                                        <th data-field="direccion">Localización</th>
                                        <th data-field="ccaapp" class="col-md-1">Clave Agua</th>
                                        <th data-field="ccpredio" class="col-md-1">Clave Predio</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="recurso/Vista/Guia/Guia.js" type="text/javascript"></script>
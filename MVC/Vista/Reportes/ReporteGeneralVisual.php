<!DOCTYPE html>
<section class="content-header">
    <h1>
        <i class="fa fa-dollar-sign" ></i> Valores General
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div class="flex-row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-dollar-sign"></i>
                        Información
                    </h3>
                    <span class="box-title pull-right bold" style="color:red;">
                        TOTAL ($) <span total></span>
                    </span>
                </div>
                <div class="box-body">
                    <table id="valores" >
                        <thead>
                            <tr>
                                <th data-field="descripcion" class="col-md-10">DESCRIPCIÓN</th>
                                <th data-field="valor" class="col-md-2" data-align="right" data-formatter="formatInputMask">TOTAL INDIVIDUAL</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <div class="row" reporte>  
        <div example class="col-md-3 hidden">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 valor>65</h3>
                    <p class="bold" descripcion>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar-sign" style="font-size: 60px;"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="recurso/Vista/Reportes/ReporteGeneralVisual.js"></script>

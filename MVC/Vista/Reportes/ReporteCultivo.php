<!DOCTYPE html>
<section class="content-header">
    <h1>
        Reporte de Cultivos
    </h1>
    <hr class="style8">
</section>
<section class="content container-fluid">
    <div class="row">        
        <div class="col-md-4 col-md-offset-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-file-excel"></i> Reporte</h3>            
                                </div>

                <div class="box-header with-border text-center">
                    <button generar id="" class="btn btn-primary btn-sm"><i class="fa fa-file-excel"></i> Generar </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!--<script src="recurso/Vista/Guia/Categoria.js" type="text/javascript"></script>-->
<script>

    $("button[generar]").click(function (e) {
        url = "servidor/sExcel.php?op=cultivos";
        window.open(url, '_blank');
    });
</script>
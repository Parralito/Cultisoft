table = $("div[Listado] table");
selections = [];
fPago = cboFPago();
PA = null;
rowActual = null;

options = {
    uploadUrl: getURL('_guia'),
    //theme: 'explorer-fa',
    initialPreviewAsData: true,
    overwriteInitial: false,
    uploadAsync: false,
    language: 'es',
    initialPreview: [],
    initialPreviewConfig: [],
    uploadExtraData: function (previewId, index) {
        var info = {
            accion: "save",
            op: "guias",
            directorio: (rowActual !== undefined) ? rowActual.directorio : null,
            datos: getInformacion()
        };
        return info;
    },
    allowedFileExtensions: ['png', 'jpg']
};

function showR() {
    $("div[table]").fadeOut();
    $("div[table]").addClass("hidden");

    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
}

function hideR() {
    $("div[new]").fadeOut();
    $("div[new], div[activar], div[inactivar]").addClass("hidden");
    rowActual = null;

    $("div[table]").fadeIn("slow");
    $("div[table]").removeClass("hidden");

    $('#input-id').fileinput('destroy');

    $("form[savePersonalizado]").clear();
}

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = "all";
    return params;
}

$(function () {
    //$("#input-id").fileinput();


    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbFormaPago").bootstrapTable();
    $("div[detalle] input[alcantarillado]").setPorcent(0);
    $("div[detalle] input[mensualidad]").setFloat(0);

    $("#newGuia").click(function (e) {
        if ($('input[name="cedula"]').val() !== "") {
            // Fecha 
            $("input[name='fecha']")
                    .attr("data-tipo", "fecha")
                    .initDate("2008-12-01");
            //initFecha();
            $("input[name='fecha']").datepicker("update", new Date());

            desc = parseInt($("div[Contribuyente]").data("desc"));
            $("div[detalle] input[descuento]").attr("disabled", !desc);


            iniciar();

            showR();
            $("div[PermisoConexion]").removeClass("hidden");
            limpiarTbFormaPago("#tbFormaPago");
            $("input[name='multa']").setFloat(0);
        }
    });

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("#tbDetalleGuia").bootstrapTable("removeAll");

    });

    $("div[Contribuyente]").clear();

    $("button[clean]").click(function () {
        hideR();
    });

    $("div[inactivar] button[clean],div[activar] button[clean]").click(function () {
        reloadGuiaxContribuyente();
        hideR();
    });

    $('select[name="idruta"]').on('changed.bs.select', function () {
        id = $(this).selectpicker("val");
        loadCbo(cboSectorRuta(id), $('select[name="idsector"]'));
    });

    $('select[name="idciudad"]').on('changed.bs.select', function () {
        id = $(this).selectpicker("val");
        loadCbo(cboParroquiaxCiudad(id), $('select[name="idparroquia"]'));
    });

    $("form[savePersonalizado]").submit(function (e) {
        e.preventDefault();
        $('#input-id')
                .fileinput('upload')
                .fileinput('clear');
        ;
        $("#tbDetalleGuia").bootstrapTable("refresh");
        hideR();
    });

//    $("#input-id").fileinput({
//        uploadUrl: getURL('_guia'),
//        initialPreviewAsData: true,
//        overwriteInitial: false,
//        uploadAsync: false,
//        language: 'es',uploadExtraData: function (previewId, index) {
//            var info = {
//                accion: "save",
//                op: "guias",
//                datos: getInformacion()
//            };
//            return info;
//        },
//        allowedFileExtensions: ['png', 'jpg']
//    });
});


function iniciar() {
    //$("input[name='fecha']").val(formatView(moment()));

    $("textarea[name='direccion']").val("");
    $("div[init].inputComponent button[refresh]").click();

    id = $('select[name="idciudad"]').selectpicker("val");
    loadCbo(cboParroquiaxCiudad(id), $('select[name="idparroquia"]'));

    id = $('select[name="idruta"]').selectpicker("val");
    loadCbo(cboSectorRuta(id), $('select[name="idsector"]'));

}
var imagenes = "";

function getBase64(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        imagenes = imagenes + (String(reader.result)) + " ";
    };
}
function getInformacion() {
    form = "#frm";
    datos = $(form).serializeObject_KBSG(true);
    datos.idContribuyente = $("div[Contribuyente] input[name='id']").val();
    datos.detalle = {
        ME: $(form).find("div[detalle] input[mensualidad]").getFloat(),
        DESC: $(form).find("div[detalle] input[descuento]").getFloat()
    };
    return datos;
}

function btnEditarGuia(value) {
    return "<button edit type='button' class='btn btn-info btn-sm'><i class='fa fa-external-link-square-alt'></i></button>";
}

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='cedula']").val(row.identificacion + " - " + row.nombres);
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente]").data("desc", row.descuento);
        hideR();
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    },
    "click button[up]": function (e, value, row, index) {
        $("div[activar]").removeClass("hidden");
        rowActual = row;
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable();
        $("#tbDetalleGuia").bootstrapTable("load", [rowActual]);

        $("div[activar] input[name='reconexion']").setFloat(0);
        PA = getJson({
            url: getURL("_recurso"),
            data: {
                accion: "get",
                op: "param",
                val: "EM"
            }
        });
        f = getJson({
            url: getURL("_sistema"),
            data: {
                accion: "get",
                op: "FECHA"
            }
        });
        fechaRow = (formartMoment(row.ultimoPago, fecha_format.save));
        fechaComparar = formartMoment(f.fecha, fecha_format.save);
        fechaComparar = fechaComparar.subtract(1, 'months');
        diffFechas = (fechaComparar.diff(fechaRow, 'months'));
        PA.valor = PA.valor * diffFechas;

        $("div[activar] input[name='tarifaAdmin']").val(formatInputMask(PA.valor));
        $("div[activar] span[total]").html(formatInputMask(PA.valor));

        limpiarTbFormaPago("div[activar] table");
    },
    "click li[down]": function (e, value, row, index) {
        e.preventDefault();

        $.post(getURL("_guia"), {
            id: row.id,
            accion: "delete",
            op: "valid.guias"
        }, function (response) {
            if (response.status) {
                rowActual = row;
                $("#tbDetalleGuia").bootstrapTable("destroy");
                $("#tbDetalleGuia").bootstrapTable();
                $("#tbDetalleGuia").bootstrapTable("load", [rowActual]);
                $("div[inactivar]").removeClass("hidden");
                $("div[inactivar] input[name='costo']").setFloat(0);
                $("div[inactivar] span[total]").html(formatInputMask(0));
                $("div[inactivar] table").bootstrapTable();
                limpiarTbFormaPago("div[inactivar] table");
            } else {
                MsgError({
                    title: "ERROR AL INACTIVAR",
                    content: "Inactivar la Guía no es posible por cuestiones de DEUDA"
                });
            }
        }, "json");
    },
    "click li[edit]": function (e, value, row, index) {
        e.preventDefault();

        rowActual = row;

        dt = getJson({
            url: getURL('_guia'),
            data: {
                op: "IMAGENES",
                accion: "get",
                guia: row.id
            }
        });
        options.initialPreview = dt.map((data) => {
            return data.ruta;
        });

        $("#input-id").fileinput(options);

        $("input[name='fecha']").datepicker("destroy");
        $("input[name='fecha']").attr("data-tipo", "fechaView");

        desc = parseInt($("div[Contribuyente]").data("desc"));
        $("div[detalle] input[descuento]").attr("disabled", !desc);


        detalle = JSON.parse(row.detalle);
        if (!$.isEmptyObject(detalle)) {
            $("div[detalle] input[mensualidad]").setFloat(detalle.ME);
//            $("div[detalle] input[alcantarillado]").setFloat(detalle.AL);
            $("div[detalle] input[descuento]").setFloat(detalle.DESC);
        }


        iniciar();
        showR();
        $("form[savePersonalizado]").edit(row);
        $("textarea[name='direccion']").val(row.lugar);
    }
};
window.event_input = {
    "change input[myDecimal]": function (e, value, row, index) {
        valor_update = convertFloat($(e.target).val());
        table = $(this).closest("table");// "#tbFormaPago";

        acumulador = valor_update;
        $.each($(table).bootstrapTable("getData"), function (i, rw) {
            if (index !== i)
                acumulador += convertFloat(rw.valor);
        });
        input = $(this).closest("div[init]").find("span[total]");// "#totalPA";
        totalDeuda = convertFloat($(input).html());

        bandera = !(totalDeuda - acumulador < 0);
        if (bandera) {
            row.valor = valor_update;
            $(table).bootstrapTable('updateRow', {
                index: index,
                row: row
            });
        } else {
            row.valor = 0;
            $(table).bootstrapTable('updateRow', {
                index: index,
                row: row
            });
        }
    },
    'focus input[myDecimal]': function (e, value, row, index) {
        $(this).inputmask("myDecimal");
        $(this).select();
    }
};

function limpiarTbFormaPago(table) {
    $(table).bootstrapTable("load", fPago.rows.map(function (row) {
        return {
            idfpago: row.id,
            descripcion: row.descripcion,
            valor: 0,
            detalle: ""
        };
    }));
}

function BtnAccion(value, rowData, index) {
    if (!$.isEmptyObject(rowData.fechacancelacion)) {
        return '<button up type="button" class="btn btn-success btn-sm"> <i class="fa fa-fw fa-check-circle"></i> Activar </button>';
    }
    return '<div class="btn-group" name="shows">' +
            '<button type="button" class="btn btn-default dropdown-toggle btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            ' <i class="fa fa-fw fa-align-justify"></i>' +
            '</button>' +
            '<ul class="dropdown-menu dropdown-menu-left" >' +
            '<li edit><a href="#"> <i class="fa fa-edit"></i> Ver</a></li>' +
            '</ul>' +
            '</div>';
}

function reloadGuiaxContribuyente() {
    $("#tbDetalleGuia").bootstrapTable("destroy");
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
}
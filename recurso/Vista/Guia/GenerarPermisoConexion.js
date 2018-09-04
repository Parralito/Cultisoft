var rowActual = null;
$(function () {
    $("#tbDetalleGuia").bootstrapTable();
    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideUpdate();
        $("#tbDetalleGuia").bootstrapTable("removeAll");
    });
    $("button[clean]").click(function (e) {
        hideUpdate();
        idContribuyente = $('div[Contribuyente] input[name="id"]').val();
        datos = tbDetalleGuiasxContribuyente(idContribuyente);
        $("#tbDetalleGuia").bootstrapTable("load", datos.rows);
    });
    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });
//    $("button[save]").click(function () {
//        datos = JSON.parse(($("div[update]").serializeObject_KBSG()));
//        datos["idguias"] = rowActual.id;
//        datos["fechaUdp"] = formartMoment($("#fUpd").val(), fecha_format.viewMonth).format("YYYY-MM-01");
//        dt = {
//            url: getURL("_financiero"),
//            dt: {
//                accion: "save",
//                op: "UpdateFechaUltimoPago",
//                datos: JSON.stringify(datos)
//            }
//        };
//        response = saveGlobal(dt);
//        idContribuyente = $('div[Contribuyente] input[name="id"]').val();
//        datos = tbDetalleGuiasxContribuyente(idContribuyente);
//        $("#tbDetalleGuia").bootstrapTable("load", datos.rows);
//        hideUpdate();
//    });
});
function showUpdate() {
    $("div[update]").fadeIn("slow");
    $("div[update]").removeClass("hidden");
}
function hideUpdate() {
    $("div[update]").fadeOut("slow");
    $("div[update]").addClass("hidden");
    $('input[data-tipo="fecha"]').datepicker('destroy');
}

function btnAccion() {
    return '<button update class="btn btn-info" > <i class="fa fa-calendar-plus"></i> </button>';
}

function initFechaDoc(ultimoPago) {
    ultimoPago = MPrimera(fechaViewFormat(ultimoPago, fecha_format.viewMonth));
    // Validar Máxima Fecha
    input = 'input[data-tipo="fecha"]';
    config = getParamsFecha($(input).attr("dt-tipo"));
    config = $.extend(config, {
        startDate: ultimoPago,
        endDate: MPrimera(fechaViewFormat(moment(),fecha_format.viewMonth ))
    });
    $(input).datepicker(config);
    $(input).datepicker("update", ultimoPago);
}

window.evtSelect = {
    "click button[update]": function (e, value, row, index) {
        rowActual = row;
        $("div[update]").edit(row);
        initFechaDoc(row.ultimoPago);
        showUpdate();
        $("#tbDetalleGuia").bootstrapTable("load", [row]);
    },
    "click button[select]": function (e, value, row, index) {

        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        datos = tbDetalleGuiasxContribuyente(row.id);
        $("#tbDetalleGuia").bootstrapTable("load", datos.rows);
    }
};
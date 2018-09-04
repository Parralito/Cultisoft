var rowActual = null;

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = 'down';
    return params;
}


$(function () {
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    
    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideUpdate();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });
    
    $("button[clean]").click(function (e) {
        hideUpdate();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });
    
    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });
    
    $("button[save]").click(function () {
        datos = JSON.parse(($("div[update]").serializeObject_KBSG()));
        datos["idguias"] = rowActual.id;
        datos["fechaUdp"] = $("#fUpd").getFecha();
        dt = {
            url: getURL("_guia"),
            dt: {
                accion: "save",
                op: "UpdateFechaUltimoPago",
                datos: JSON.stringify(datos)
            }
        };
        response = saveGlobal(dt);
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
        hideUpdate();
    });
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
    $(input).initDate("2008-12-01");
    $(input).datepicker("setEndDate", moment().subtract(1,'months').toDate());
    $(input).datepicker("update", ultimoPago);
}

window.evtSelect = {
    "click button[update]": function (e, value, row, index) {
        rowActual = row;
        $("div[update]").edit(row);
        initFechaDoc(row.ultimoPago);
        showUpdate();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable();
        $("#tbDetalleGuia").bootstrapTable("load", [rowActual]);
    },
    "click button[select]": function (e, value, row, index) {

        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    }
};
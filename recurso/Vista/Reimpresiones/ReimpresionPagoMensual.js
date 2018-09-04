var rowActual = null;

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}

$(function () {
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbFormaPago").bootstrapTable();

    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("#tbDetalleGuia").bootstrapTable("removeAll");

    });

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });


});

function showR() {
    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
    $("#tbDetalleMensualidadAnual").bootstrapTable("resetView");
}

function hideR() {
    $("div[new]").fadeOut("slow");
    $("div[new]").addClass("hidden");
    rowActual = null;
    $("form[savePersonalizado]").clear();
}

function fnParams(params) {
    params.id = rowActual.id;
    return params;
}

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {

        $("div[Contribuyente] button[clear]").click();

        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    },
    "click button[detalle]": function (e, value, row, index) {
        showR();
        rowActual = row;
        $("#tbDetalleMensualidad").bootstrapTable("destroy");
        tbPag = $.extend({}, TablePagination, {
            pageSize: 10,
            height: 400
        });
        $("#tbDetalleMensualidad").bootstrapTable(tbPag);
        $("div[exec]").addClass("hidden");
    },
    "click button[reimpreme]": function (e, value, row, index) {
        form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = "MVC/Vista/Financiero/print/ComprobantePagoMensualidad.php"; //"Servidor/sFinanciero.php";
        form.style.display = "none";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "cm";
        input.value = row.id;
        form.appendChild(input);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
};


function estadoJC(value, row, index) {
    return parseInt(value) ? "<span class='red bold'>Activo</span>" : "-";
}

function btnDetalle(value, row, index) {
    return '<button detalle class="btn btn-success btn-sm"> <i class="fa fa-list-alt" ></i> </button>';
}
    
function btnAccion(value, row, index) {
    if (row.estado !== "ACT")
        return "Anulado";
    return '<button reimpreme class="btn btn-success btn-sm"> <i class="fa fa-print" ></i> </button>';
}

function fnTipo(value, row, index) {
    result = "-";
    switch (value) {
        case "R":
            result = "Registro Guía";
            break;
        case "UF":
            result = "Actualizacion de Fecha";
            break;
        case "JP":
            result = "Pago de Juicio Directo";
            break;
        case "PM":
            result = "Pago Mensual";
            break;
        case "JG":
            result = "Registro de Juicio C.";
            break;
    }
    return result;
}
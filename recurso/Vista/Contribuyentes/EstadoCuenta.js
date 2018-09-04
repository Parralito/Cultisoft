var rowActual = null;
var btnSave = null;
var totalpagar = null;
fPago = cboFPago();
opciones = $.extend({}, TablePaginationDefault, {
    search: false
});
function showR() {
    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
    $("#tbDetalleMensualidadAnual").bootstrapTable("resetView");
}

function hideR() {
    $("div[new]").fadeOut("slow");
    $("div[new]").addClass("hidden");
    $("#totalPM, #totalJC").html(formatInputMask(0));
    btnSave = rowActual = null;
    $("div[Mensualidad], div[Cobranza],div[detallejuicio]").addClass("hidden");
    $("#tbDetalleMensualidadAnual, #tbValoresFinales, #tbValoresFinalesValores, #tbValoresFinalesCobranza").bootstrapTable("removeAll");
    $("form[savePersonalizado]").clear();
}

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}

function fn_queryJC(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}

function fn_queryPM(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = "APR";
    return params;
}


$(function () {

    $("#tbDetalleGuia").bootstrapTable(opciones);
    $("#tbDetalleGuiaJC").bootstrapTable(opciones);
    $("table[Permisos]").bootstrapTable(opciones);
    $("h1[totalpagar]").html("0.00");
    $("#tbGeneraAbonos").bootstrapTable();
    $("#tbDetalleMensualidadAnual, #tbValoresFinales,#tbValoresFinalesValores, #tbValoresFinalesCobranza").bootstrapTable();
    $("#tbFormaPagoCM, #tbFormaPagoJC").bootstrapTable();
    initSelect();
    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(opciones);
        $("#tbDetalleGuiaJC").bootstrapTable("destroy");
        $("#tbDetalleGuiaJC").bootstrapTable(opciones);
        $("table[Permisos]").bootstrapTable("destroy");
        $("table[Permisos]").bootstrapTable(opciones);
        $("h1[totalpagar]").html("0.00");
        totalpagar = 0;
    });
    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });
    $("button[clean]").click(function (e) {
        hideR();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(opciones);
    });
});
function TotalGeneral()
{   
    dt = getJson({
        url: getURL("_contribuyente"),
        data: {
            accion: "get",
            op: "ESTADOCUENTA",
            id: $("div[Contribuyente] input[name='id']").val()
        }
    });
    $("h1[totalpagar]").html(formatInputMask(dt.total));

}

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
        $("#tbDetalleGuiaJC").bootstrapTable("refresh");
        $("table[Permisos]").bootstrapTable("refresh");
        TotalGeneral();
    }
};
function btnDetalle(value, row, index) {
    if (parseInt(row.estadoDeuda)) {
        if (row.cMes > 0)
            return '<button pago class="btn btn-sm btn-info"><i class="fa fa-arrow-down"></i> </button>';
    } else {
        return '<button cobranza class="btn btn-sm btn-info"><i class="fa fa-arrow-down"></i> </button>';
    }

}

function lbEstado(value, row, index)
{
    if (row.estado == 'ACT')
    {
        return '<label style="color:green;">Activo</label>';
    } else if (row.estado == 'PAG')
    {
        return '<label style="color:red;">Pagado</label>';
    } else if (row.estado == 'APR')
    {
        return '<label style="color:green;">Aprobado</label>';
    }
}
function lbTotalPermiso(value, row, index)
{
    totalrw = convertFloat(row.valor) + convertFloat(row.multa)
    return formatInputMask(totalrw);
}

function lblEstado(value, row, index)
{
    if (parseInt(value)) {
        if (row.cMes > 0)
            return '<label style="color:green;">Pago Mensual</label>';
    } else {
        return '<label style="color:red;">Hab. Coactiva</label>';
    }
}
function formatNumTipo(value, row, index) {
    if (row.tipo === "%")
        return formatInputMask(value) + ' ' + row.tipo;
    return row.tipo + ' ' + formatInputMask(value);
}
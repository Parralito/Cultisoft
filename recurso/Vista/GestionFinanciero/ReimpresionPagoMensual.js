var rowActual = null;
fPago = cboFPago();

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
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault);
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    $("button[cleanReimpresion]").click(function () {
        $(this).closest("div[exec]").addClass("hidden");
        $("#totalRI").html(formatInputMask(0));
    });


    $("button[print]").click(function (e) {
        row = $("button[print]").data("id");
        datos = {
            idref: row.id,
            valor: RI.valor,
            tipo: 'RI',
            detalle: row.tipo + "-" + row.Cod,
            fechasadmin: row.fecha
        };

        valor = convertFloat($("div[Reimpresion] span[total]").html());
        table = "#tbFormaPago";
        dtTableFP = $(table).bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        if (sum !== valor) {
            MsgError({
                title: "Error <small>Pago insuficiente</small>",
                content: ["Total: <strong>" + valor + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
            return;
        }

        dt = {
            url: getURL("_sadministrativo"),
            dt: {
                accion: "save",
                op: "SADMIN",
                datos: JSON.stringify(datos),
                fpagos: JSON.stringify(dtTableFP)
            }
        };
        response = saveGlobal(dt);

        if (!$.isEmptyObject(response)) {

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



            MsgSuccess({
                title: "Pago Mensual",
                content: "Se realizo correctamente el pago."
            });
            $("#tbDetalleGuia").bootstrapTable("refresh");
            hideR();
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
//        $("#tbDetalleGuia").bootstrapTable("destroy");
//        $("#tbDetalleGuia").bootstrapTable();
//        $("#tbDetalleGuia").bootstrapTable("load",[rowActual]);

        $("#tbDetalleMensualidad").bootstrapTable("destroy");
        tbPag = $.extend({}, TablePagination, {
            pageSize: 10,
            height: 400
        });
        $("#tbDetalleMensualidad").bootstrapTable(tbPag);
        $("div[exec]").addClass("hidden");
    },
    "click button[reimpreme]": function (e, value, row, index) {
        limpiarTbFormaPago("#tbFormaPago");
        RI = getJson({
            url: getURL("_recurso"),
            data: {
                accion: "get",
                op: "sadmin",
                val: "RI"
            }
        });
        $("button[print]").data("id", row);
        $("#totalRI").html(formatInputMask(RI.valor));
        $("div[Reimpresion]").removeClass("hidden");
    }
};


function estadoJC(value, row, index) {
    return parseInt(value) ? "<span class='red bold'>Activo</span>" : "-";
}

function btnDetalle(value, row, index) {
    return '<button detalle class="btn btn-success btn-sm"> <i class="fa fa-list-alt" ></i> </button>';
}
function btnAccion(value, row, index) {
    if(row.estado !== "ACT")
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

window.event_input = {
    "change input[myDecimal]": function (e, value, row, index) {
        valor_update = convertFloat($(e.target).val());
        table = "#tbFormaPago";

        acumulador = valor_update;
        $.each($(table).bootstrapTable("getData"), function (i, rw) {
            if (index !== i)
                acumulador += convertFloat(rw.valor);
        });
        input = "#totalRI";
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

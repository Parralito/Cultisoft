var rowActual = null;
fPago = cboFPago();

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}


$(function () {
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbFormaPago, #tbDetalleMensualidad").bootstrapTable();


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

    $("button[cleanAnular], button[cleanReimpresion]").click(function () {
        $(this).closest("div[exec]").addClass("hidden");
    });
    $("div[Anular] button[save]").click(function () {
        if ($("div[Anular]").validate()) {

            $.confirm({
                theme: "modern",
                escapeKey: "cancelAction",
                title: 'Anular Pago?',
                content: 'Esta seguro de anular el pago',
                autoClose: 'cancelAction|8000',
                buttons: {
                    PagoTotal: {
                        text: 'Anular',
                        //keys: ['enter'],
                        action: function () {

                            dt = {
                                url: getURL("_financiero"),
                                dt: {
                                    accion: "save",
                                    op: "ANULAR.CM",
                                    datos: $("div[Anular]").serializeObject_KBSG()
                                }
                            };
                            response = saveGlobal(dt);
                            if (response.status) {
                                MsgSuccess({
                                    title: "Pago Mensual - Eliminado",
                                    content: "Se realizo correctamente la anulación del pago."
                                });
                                loadTbDetMensualidad();
                                $("div[Anular]").addClass("hidden");
                                $("div[Anular]").clear();
                            }
                        }
                    },
                    cancelAction: {
                        text: "Cancelar",
                        action: function () {
                            //$.alert('action is canceled');
                        }
                    }
                }
            });




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


window.evtSelect = {
    "click button[select]": function (e, value, row, index) {

        $("div[Contribuyente] button[clear]").click();

        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
//        datos = tbDetalleGuiasxContribuyente(row.id);
//        $("#tbDetalleGuia").bootstrapTable("load", datos.rows);
        $("#tbDetalleGuia").bootstrapTable("refresh");

    },
    "click button[detalle]": function (e, value, row, index) {
        showR();
        rowActual = row;
        loadTbDetMensualidad();
        $("div[exec]").addClass("hidden");
    },
    "click button[anular]": function (e, value, row, index) {
        $("div[Anular]").removeClass("hidden");
        $("div[Anular]").data("id", row.id);
    }
};


function estadoJC(value, row, index) {
    return parseInt(value) ? "<span class='red bold'>Activo</span>" : "-";
}

function btnDetalle(value, row, index) {
    return '<button detalle class="btn btn-success btn-sm"> <i class="fa fa-list-alt" ></i> </button>';
}

function btnAccion(value, row, index) {
    if ((row.tipo === "PM" || row.tipo === "JP") && row.estado === "ACT") {
        return '<button anular class="btn btn-danger btn-sm"> <i class="fa fa-times" ></i> </button>';
    } else {
        return "-";
    }
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

function loadTbDetMensualidad() {
    json_data = {
        data: {
            op: "DETALLE.PM.GUIA",
            accion: "list",
            guia: rowActual.id
        },
        url: getURL("_financiero")
    };
    $("#tbDetalleMensualidad").bootstrapTable("load", getJson(json_data));
}
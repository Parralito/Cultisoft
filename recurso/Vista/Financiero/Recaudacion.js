var rowActual = null;
var btnSave = null;
fPago = cboFPago();
detalle_periodo = null;

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

function getDetallePeriodo(guia) {
    detalle_periodo = getJson({
        url: getURL("_financiero"),
        data: {
            accion: "get",
            op: "DETALLE.PERIODO",
            guia: guia
        }
    });
    detalle_periodo = detalle_periodo.map(function (row) {
        row.detalle = JSON.parse(row.detalle);
        return row;

    });
    $("select[name='tiempos']").html("");
    $.each(detalle_periodo, (i, row) => {
        option = document.createElement("option");
        $(option).attr("value", row.id);
        $(option).html(fechaViewFormat(row.fini, fecha_format.viewMonth) + " - " + fechaViewFormat(row.ffin, fecha_format.viewMonth));
        $("select[name='tiempos']").append(option);
    });
    $("select[name='tiempos']").selectpicker("refresh");
}

function calcular(mes = null) {
    id = $("select[name='tiempos']").val();
    result = $(detalle_periodo).search("id", id).rw;
    mes = (mes === null) ? result.meses : mes;

    datos = getJson({
        url: getURL("_financiero"),
        data: {
            accion: "get",
            op: "CALC.DEUDA",
            datos: JSON.stringify({
                tarifario: result.detalle,
                mes: mes,
                estado: rowActual.estadoDeuda
            })
        }
    });
    //console.log(datos);
    $("#tbValoresFinales").bootstrapTable("load", datos);

}

function calcularTotal() {
    $.post(getURL("_financiero"), {
        accion: "get", op: "TOTAL.DEUDA", datos: JSON.stringify({
            rows: detalle_periodo,
            estado: rowActual.estadoDeuda
        })
    }, (data) => {
        $("span[total]").html(formatInputMask(data));
    });
}

$(function () {
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbFormaPago, #tbGeneraAbonos, #tbDetalleMensualidadAnual, #tbValoresFinales").bootstrapTable();
    $(".selectpicker").selectpicker();
    initSelect();

    $("#tbValoresFinales").on("pre-body.bs.table", function (e, data) {
        if (rowActual !== null)
            if (!parseInt(rowActual.estadoDeuda)) {
                calcularTotal();
            } else {
                total = data.reduce((a, b) => a + b.total, 0);
                $("span[total]").html(formatInputMask(total));
            }
    });

    $("select[name='tiempos']").change(function (e) {
        calcular();
    });

    $("button[change_porcentaje]").click(function () {
        $("#modal_edit").modal("toggle");
        p_cobranza = $("input[p_cobranza]").getFloat();

        $.each(detalle_periodo, (i, row) => {
            row.detalle.CO = p_cobranza;
        });
        limpiarTbFormaPago("#tbFormaPago");
        $("select[name='tiempos']").change();

    });

    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });

    $("input[name='cantMes']").change(function (e) {
        cantMes = $(this).val();
        limpiarTbFormaPago("#tbFormaPago");
        calcular(cantMes);
    });

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    $("#modal_edit").on({
        'show.bs.modal': function () {
            /* Valores de Cobranza por defecto */
            $("input[p_cobranza]").val(25);
            $("input[p_cobranza]").inputmask("myPorcentajeCobranza");
        }
    });

    $("button[clean]").click(function (e) {
        hideR();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });

    $("button[save]").click(function (e) {

        //datos = $(form).serializeObject_KBSG(false);
        datos = {};
        datos.cMes = (btnSave === "JP") ? rowActual.cMes : $("input[name='cantMes']").val();
        datos.tipo = btnSave;
        datos.idguias = rowActual.id;
        datos.valor = convertFloat($("span[total]").html());

        // Suma de las formas de pagos
        dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        if (sum !== datos.valor) {
            //Mensaje
            MsgError({
                title: "Error <small>Pago insuficiente</small>",
                content: ["Total: <strong>" + formatInputMask(datos.valor) + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
            return;
        }

        dt = {
            url: getURL("_financiero"),
            dt: {
                accion: "save",
                op: "COBROMENSUAL",
                datos: JSON.stringify(datos),
                fpagos: JSON.stringify(dtTableFP),
                tarifario: JSON.stringify(detalle_periodo)
            }
        };
        response = saveGlobal(dt);
        if (response.status) {

            form = document.createElement("form");
            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/Financiero/print/ComprobantePagoMensualidad.php";
            form.style.display = "none";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "cm";
            input.value = response.id;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            MsgSuccess({
                title: "Pago Mensual",
                content: "Se realizo correctamente el pago."
            });
            $("#tbDetalleGuia").bootstrapTable("destroy");
            $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
            hideR();
        }


    });
});

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    },

    "click button[cobranza]": function (e, value, row, index) {
        rowActual = row;

        $.confirm({
            theme: "modern",
            escapeKey: "cancelAction",
            title: 'Acción a realizar?',
            content: 'La guia en cuestión esta en mora.',
            autoClose: 'cancelAction|5000',
            buttons: {
                PagoTotal: {
                    text: 'Pago Directo',
                    action: function () {
                        btnSave = "JP";
                        limpiarTbFormaPago("#tbFormaPago");
                        getDetallePeriodo(rowActual.id);
                        $("div[Mensualidad]").removeClass("hidden");
                        $("div[jp]").removeClass("hidden");
                        $("div[pm]").addClass("hidden");

                        $("select[name='tiempos']").change();

                        $("#tbDetalleGuia").bootstrapTable("destroy");
                        $("#tbDetalleGuia").bootstrapTable();
                        $("#tbDetalleGuia").bootstrapTable("load", [rowActual]);
                        detMensualidad();
                        showR();
                    }
                },
                Consolidado: {
                    text: "Consolidado de la Deuda",
                    //keys: ['enter'],
                    action: function () {
                        form = document.createElement("form");

                        form.target = "_blank";
                        form.method = "POST";
                        form.action = "MVC/Vista/Financiero/print/ConsolidadoDeuda.php";
                        form.style.display = "none";

                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "datos";
                        input.value = JSON.stringify(rowActual);
                        form.appendChild(input);

                        document.body.appendChild(form);
                        form.submit();
                        document.body.removeChild(form);
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
    },
    "click button[detalle]": function (e, value, row, index) {
        $("#modal-abono").modal("show");
        $("#tbGeneraAbonos").bootstrapTable("load", tbDetAbonosJuicioCoactiva(row.jc));
    },
    "click button[pago]": function (e, value, row, index) {
        // Asignar Row Actual
        rowActual = row;
        btnSave = "PM";
        limpiarTbFormaPago("#tbFormaPago");
        getDetallePeriodo(row.id);
        $("div[Mensualidad]").removeClass("hidden");
        $("div[pm]").removeClass("hidden");
        $("div[jp]").addClass("hidden");

        $("select[name='tiempos']").change();

        $("input[type='number']")
                .attr("max", row.cMes)
                .val(row.cMes);

        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable();
        $("#tbDetalleGuia").bootstrapTable("load", [rowActual]);

        detMensualidad();
        showR();
    }
};

function btnPagoMensual(value, row, index) {
    if (parseInt(value)) {
        if (row.cMes > 0)
            return '<button pago class="btn btn-sm btn-success"><i class="fa fa-dollar-sign"></i> </button>';
    } else {
        return '<button cobranza class="btn btn-sm btn-danger"><i class="fa fa-balance-scale "></i> </button>';
    }

}

function detMensualidad() {
    rows = getJson({
        data: {
            op: "Detalle.Mensualidad.Anual",
            accion: "list",
            fechaUltimoPago: rowActual.ultimoPago,
            completo: true
        },
        url: getURL("_financiero")
    });
    $("#tbDetalleMensualidadAnual").bootstrapTable("load", rows);
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
        input = "span[total]";
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

function estadoJC(value, row, index) {
    return parseInt(value) ? "<button detalle class='btn btn-sm btn-info' class='red'>Activo</button>" : "-";
}

/*function formatNumTipo(value, row, index) {
 if (row.tipo === "%")
 return formatInputMask(value) + ' ' + row.tipo;
 return row.tipo + ' ' + formatInputMask(value);
 }*/

/*$("#detalleCompleto").change(function (e) {
 rows = getJson({
 data: {
 op: "Detalle.Mensualidad.Anual",
 accion: "list",
 fechaUltimoPago: rowActual.ultimoPago,
 completo: true
 },
 url: getURL("_financiero")
 });
 $("#tbDetalleMensualidadAnual").bootstrapTable("load", rows);
 });*/
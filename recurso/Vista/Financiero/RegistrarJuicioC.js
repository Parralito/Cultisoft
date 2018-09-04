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
    $("span[total]").html(formatInputMask(0));
    btnSave = rowActual = null;

    $("div[Mensualidad], div[Cobranza],div[detallejuicio]").addClass("hidden");
    $("#tbValoresFinales").bootstrapTable("removeAll");
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
$("button[calcular]").click(function ()
{
    fpagossum = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
    entrada = fpagossum.reduce((a, b) => a + b.valor, 0);
    total = $("span[total]").html();
    saldo = convertFloat(total) - convertFloat(entrada);
    nmeses = $("input[name='nmeses']").getFloat();
    fechainicioplazo = fechaMoment($("input[name='fechainicioplazo']").val(), fecha_format.view);
    fechafinplazo = fechainicioplazo.add(nmeses, 'month').subtract(1, 'day');
    $("input[name='fechafinplazo']").val(MPrimera(fechafinplazo.format(fecha_format.view)));
    mensualidad = convertFloat(saldo / nmeses);
    $("label[name='lbdiferido']").html(formatInputMask(saldo));
    TablaDetalleAbono($("input[name='fechainicioplazo']").getFecha(), formatSave(fechafinplazo), mensualidad, saldo);
});
$(function () {
    $("#tbValoresFinalesValores").bootstrapTable();
    fecha = formatView(formatIni(formatSave(moment().add(1, 'month'))));
    $("input[name='fechainicioplazo']").val(fecha);
    $("input[name='fechafinplazo']").val(fecha);

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
        $("button[calcular]").click();
        datos = {};
        datos.idguias = rowActual.id;
        datos.fechainiciodeuda = formatSave(fechaMoment(rowActual.ultimoPago, fecha_format.save).add(1, 'month'));
        datos.fechafindeuda = formatSave(fechaMoment(rowActual.ultimoPago, fecha_format.save).add(rowActual.cMes, 'month').add(1, 'month').subtract(1, 'day'));
        datos.deuda = convertFloat($("span[total]").html());
        datos.entrada = convertFloat(fpagossum.reduce((a, b) => a + b.valor, 0));
        datos.saldo = convertFloat($("span[total]").html()) - convertFloat(fpagossum.reduce((a, b) => a + b.valor, 0));
        datos.abonado = convertFloat(0);
        datos.fechainicioplazo = formatSave($("input[name='fechainicioplazo']").val());
        datos.fechafinplazo = formatSave($("input[name='fechafinplazo']").val());
        dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);

        dt = {
            url: getURL("_financiero"),
            dt: {
                accion: "save",
                op: "JUICIOCOACTIVA",
                datos: JSON.stringify(datos),
                fpagos: JSON.stringify(dtTableFP),
                tarifario: JSON.stringify(detalle_periodo)
            }
        };      
        response = saveGlobal(dt);        
        if (response.id > 0) 
        {            
            idContribuyente = $("div[Contribuyente] input[name='id']").val();           
            $("#tbDetalleGuia").bootstrapTable("destroy");
            $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
            form = document.createElement("form");

            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/Financiero/print/ComprobanteRegJuicioCoactiva.php"; //"Servidor/sFinanciero.php";
            form.style.display = "none";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "idjuicio";
            input.value = JSON.stringify(response.id);
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);  
            
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
        $("button[calcular]").click();
        detMensualidad();
        showR();


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
function TablaDetalleAbono(fechainicioplazo, fechafinplazo, mensualidad, deuda)
{
    residuo = 0;
    cont = 0;
    dtmesesjuicio = getJson({
        data: {
            op: "Detalle.Meses.Juicio",
            accion: "list",
            fechainicioplazo: fechainicioplazo,
            fechafinplazo: fechafinplazo
        },
        url: getURL("_financiero")
    });
    mensualidad = roundNumber(convertFloat(mensualidad), 2);
    meses = $("input[name='nmeses']").val();
    deuda2 = meses * mensualidad;
    dif = roundNumber(deuda, 2) - roundNumber(deuda2, 2);

    $("#tbValoresFinalesValores").bootstrapTable("load", dtmesesjuicio.map(function (rw, i) {
        if (i === (dtmesesjuicio.length - 1))
            rw.mensualidad = mensualidad + dif;
        else
            rw.mensualidad = mensualidad;
        return rw;
    }));
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
        totalDeuda = convertFloat($(input).html())-0.01;

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
fPago = cboFPago();
CA = null;

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}
function fn_queryPermiso(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = "APR";
    return params;
}

function showR() {
    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
}

function hideR() {
    $("div[new]").fadeOut();
    $("div[new]").addClass("hidden");
    $("span[Habil], span[noHabil], div[detalle]").addClass("hidden");
    $("button[generar]").addClass("hidden");
}

$(function () {

    CA = getJson({
        url: getURL("_recurso"),
        data: {
            accion: "get",
            op: "sadmin",
            val: "CA"
        }
    });

    $("#tbDetalleGuia, table[Permisos]").bootstrapTable($.extend({}, TablePaginationDefault, {
        search: false
    }));

    $("#tbFormaPago").bootstrapTable();
    $("#total").html(formatInputMask(CA.valor));

    $("div[Contribuyente] button[clear], button[clean]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("#tbDetalleGuia").bootstrapTable("removeAll");
        $("#tbFormaPago").bootstrapTable("removeAll");
    });

    $("button[generar]").click(function () {
        input = "#total";
        fecha = moment().format(fecha_format.save);
        totalDeuda = convertFloat($(input).html());
        // Suma de las formas de pagos
        dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        if (sum !== totalDeuda) {
            //Mensaje
            MsgError({
                title: "Error <small>Pago insuficiente</small>",
                content: ["Total: <strong>" + totalDeuda + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
        } else {
            idcontribuyente = $("div[Contribuyente] input[name='id']").val();
            datos = {
                valor: sum,
                idref: idcontribuyente,
                Tipo: CA.abr
            };
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
            if (response.status) {
                // Generar el Permiso de Conexion
                form = document.createElement("form");
                form.target = "_blank";
                form.method = "POST";
                form.action = "MVC/Vista/ServicioAdministrativo/print/CertificadoNoAdeudar.php"; //"Servidor/sFinanciero.php";
                form.style.display = "none";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "datos";
                input.value = JSON.stringify({
                    id: response.id
                });
//                input.value = JSON.stringify({
//                    fecha: fecha,
//                    contribuyente: $("div[Contribuyente] input[name='id']").val(),
//                    CA: CA.valor
//                });
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
                $("div[Contribuyente] button[clear]").click();
            }
        }
    });

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault);
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });
});


window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        $("#tbDetalleGuia, table[Permisos]").bootstrapTable("refresh");
        showR();
        validarEstado(row.id);
    }
};

function validarEstado(id) {
    dt = getJson({
        url: getURL("_sadministrativo"),
        data: {
            accion: "get",
            op: "CertNoAdeudar",
            contribuyente: id
        }
    });

    if ((dt.meses + dt.permiso) > 0) {
        $("span[meses]").html(dt.meses);
        $("span[permiso]").html(dt.permiso);

        $("span[noHabil], div[detalle]").removeClass("hidden");
    } else {
        $("span[Habil]").removeClass("hidden");
        $("button[generar]").removeClass("hidden");
        limpiarTbFormaPago("#tbFormaPago");
    }

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
        input = "#total";
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
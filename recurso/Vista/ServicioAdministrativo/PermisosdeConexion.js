fPago = cboFPago();
rowActual = null;
function showR() {
    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
}
function hideR() {
    $("div[new]").fadeOut();
    $("div[new]").addClass("hidden");
}

$(function () {
    $("#tbFormaPago").bootstrapTable();

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    resetTable(1);

    $("button[clean]").click(function () {
        hideR();
        $("div[DetallePermiso]").clear();
        resetTable(1);
    });
    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("table[Permisos]").bootstrapTable("removeAll");
        $("#tbFormaPago").bootstrapTable("removeAll");
    });

    $("button[generar]").click(function () {
        input = "#total";
        totalDeuda = convertFloat($(input).html());
        // Suma de las formas de pagos
        dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        direccion = $("textarea[direccion]").val();
        if (sum !== totalDeuda) {
            //Mensaje
            MsgError({
                title: "Valores Erróneos",
                content: ["Total: <strong>" + totalDeuda + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
        } else {
            dt = {
                url: getURL("_sadministrativo"),
                dt: {
                    accion: "save",
                    op: "P_PERMISOCONTRIBUYENTE",
                    permisocontr: rowActual.id,
                    fpagos: JSON.stringify(dtTableFP)
                }
            };
            data = saveGlobal(dt);
            if (data.status) {
                form = document.createElement("form");
                form.target = "_blank";
                form.method = "POST";
                form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobantePermisoConexion.php";
                form.style.display = "none";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "datos";
                input.value = JSON.stringify({
                    id: data.id
                });
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
                $("button[clean]").click();
            }
        }
    });

});

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = "APR";
    return params;
}

function btnAccion(value, row, index) {
    return '<button pago class="btn btn-sm btn-danger"><i class="fa fa-dollar-sign"></i></button>';
}

window.evtSelect = {
    "click button[pago]": function (e, value, row, index) {
        rowActual = row;
        showR();
        $("div[DetallePermiso]").edit(row);
        limpiarTbFormaPago("#tbFormaPago");
        total = formatInputMask(convertFloat(row.valor) + convertFloat(row.multa));
        $("#total").html(total);
        resetTable(2);
    },
    "click button[select]": function (e, value, row, index) {
        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        $("table[Permisos]").bootstrapTable("refresh");
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

function resetTable(op) {
    table = "table[Permisos]";
    $(table).bootstrapTable("destroy");

    switch (op) {
        case 1:
            $(table).bootstrapTable($.extend({}, TablePaginationDefault, {
                search: false
            }));
            break;
        case 2:
            $(table).bootstrapTable();
            $(table).bootstrapTable("load", [rowActual]);
            break;
    }
}
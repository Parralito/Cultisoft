table = $("div[Listado] table");
selections = [];
fPago = cboFPago();
rowActual = null;

function fnparams(params) {
    params.tipo = $('select[name="documentos"]').selectpicker("val");
    return  params;
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
$(function () {
    documentos = cboTipoPermiso();
    documentos.rows = documentos.rows.map(function (row) {
        return {id: row.abr, descripcion: row.descripcion};
    });
    documentos.rows.unshift({id: "*", descripcion: "Todos"});

    $("select[name='documentos']").selectpicker();
    loadCbo(documentos, "select[name='documentos']");
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
});
function btnAccion(value, row) {
    return (row.estado === 'ANU') ? 'Anulado' : "<button reimp type='button' class='btn btn-info btn-sm'><i class='fa fa-print'></i></button>";
}
$("button[reimprimir]").click(function () {
    totalDeuda = convertFloat($("span[id='totalimp'").html());
    dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
    sum = dtTableFP.reduce((a, b) => a + b.valor, 0);

    if (sum !== totalDeuda) {
        //Mensaje
        MsgError({
            title: "Error <small>Pago insuficiente</small>",
            content: ["Total: <strong>" + totalDeuda + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
        });
    } else
    {
        datos = {
            valor: sum,
            FechaSadmin: rowActual.fecha,
            Tipo: "RI",
            detalle: rowActual.tipo + "-" + rowActual.coddocumento
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
            form = document.createElement("form");
            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobantePermisoConexion.php"; //"Servidor/sFinanciero.php";
            form.style.display = "none";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "datos";
            input.value = JSON.stringify({
                id: rowActual.id
            });
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            $("div[Permisos]").addClass("hidden");
        }
    }
});
// Eventos---------------------------------------------------------------------------------------
window.evtSelect = {
    "click button[reimp]": function (e, value, row, index) {
        $("div[Permisos]").removeClass("hidden");
        $("#tbFormaPago").bootstrapTable();
        limpiarTbFormaPago("#tbFormaPago");
        RI = getJson({
            url: getURL("_recurso"),
            data: {
                accion: "get",
                op: "sadmin",
                val: "RI"
            }
        });
        rowActual = row;
        $("label[name='codigo'").html(row.coddocumento);
        $("span[id='totalimp'").html(formatInputMask(RI.valor));
    }
};
$("select[name='documentos']").on('change', function () {
    $("div[Listado] table").bootstrapTable('refresh');
    $("div[Permisos]").addClass("hidden");
});

window.event_input = {
    "change input[myDecimal]": function (e, value, row, index) {
        valor_update = convertFloat($(e.target).val());
        table = "#tbFormaPago";

        acumulador = valor_update;
        $.each($(table).bootstrapTable("getData"), function (i, rw) {
            if (index !== i)
                acumulador += convertFloat(rw.valor);
        });
        input = "#totalimp";
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
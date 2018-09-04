fPago = cboFPago();

$(function () {

    $("#tbFormaPago").bootstrapTable();
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
    limpiarTbFormaPago("#tbFormaPago");
    fecha = moment().format(fecha_format.save);

    $("button[generar]").click(function () {
        motivo = $("textarea[motivo]").val();
        dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        fecha = moment().format(fecha_format.save);
        if (motivo !== "") {
            if (sum > 0) {
                datos = {
                    valor: sum,
                    Tipo: "DV",
                    datos: motivo
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
                //data = saveGlobal(dt).Clase;
                data = saveGlobal(dt);
                if (data.status)
                {
                    form = document.createElement("form");
                    form.target = "_blank";
                    form.method = "POST";
                    form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobanteDocumentosVarios.php"; //"Servidor/sFinanciero.php";
                    form.style.display = "none";

                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "datos";
                    input.value = JSON.stringify({
                        id: data.id
                    });
                    /*input.value = JSON.stringify({
                     valor: sum,
                     datos: motivo,
                     fecha: data.Fecha,
                     cod: data.Coddocumento
                     });*/
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                    $("button[clean]").click();
                }
            } else {
                MsgError({
                    title: "Error <small></small>",
                    content: ["Ingrese un valor"]
                });
            }
        } else {
            MsgError({
                title: "Error <small></small>",
                content: ["Ingrese una descripción"]
            });
        }
    });
    $("button[id='newDoc']").click(function () {
        $("#total").html("");
        $("div[new]").removeClass("hidden");
        $("div[Registro]").addClass("hidden");
        motivo = $("textarea[motivo]").val("");
        limpiarTbFormaPago("#tbFormaPago");
    });
    $("button[clean]").click(function () {
        $("#total").html("");
        $("div[new]").addClass("hidden");
        $("div[Registro]").removeClass("hidden");
        motivo = $("textarea[motivo]").val("");
        limpiarTbFormaPago("#tbFormaPago");
    });
});


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

function btnAccion(value) {
    return '<div class="btn-group" name="shows">' +
            '<button type="button" class="btn btn-default dropdown-toggle btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            ' <i class="fa fa-fw fa-align-justify"></i>' +
            '</button>' +
            '<ul class="dropdown-menu dropdown-menu-left" >' +
            '<li anular><a href="#"> <i class="fa fa-trash-alt"></i> Anular Certificado</a></li>' +
            ' <li reimprimir><a href="#"> <i class="fa fa-print"></i> Reimpresión de Certificado</a></li>' +
            '</ul>' +
            '</div>';
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
        totalDeuda = convertFloat($(input).html(formatInputMask(acumulador)));
        row.valor = valor_update;
        $(table).bootstrapTable('updateRow', {
            index: index,
            row: row
        });
    },
    'focus input[myDecimal]': function (e, value, row, index) {
        $(this).inputmask("myDecimal");
        $(this).select();
    }
};
window.evtSelect = {
    "click li[anular]": function (e, value, row, index) {
        data = {
            id: row.id
        };
        $.confirm({
            theme: "modern",
            escapeKey: "cancelAction",
            title: 'ANULAR DOCUMENTO',
            autoClose: 'cancelAction|8000',
            type: "orange",
            content: 'Está seguro de anular el documento con descripción : <br>' + row.datos + '',
            buttons: {
                Aceptar: {
                    text: 'Aceptar',
                    //keys: ['enter'],

                    action: function () {
                        $.post(getURL("_sadministrativo"), {
                            data: JSON.stringify(data),
                            op: "UPDATEESTADOPERMISO",
                            accion: "save"
                        });
                        $("div[Listado] table").bootstrapTable('refresh');
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
    "click li[reimprimir]": function (e, value, row, index) {
        form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobanteDocumentosVarios.php"; //"Servidor/sFinanciero.php";
        form.style.display = "none";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "datos";
        input.value = JSON.stringify({
            id: row.id
        });
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
};
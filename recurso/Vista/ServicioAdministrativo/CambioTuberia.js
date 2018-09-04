table = $("div[Listado] table");
selections = [];
fPago = cboFPago();
PA = null;
rowCont = null;
rowGuia = null;


function showR() {
    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
}
function hideR() {
    $("div[new]").fadeOut();
    $("div[new], div[activar], div[inactivar]").addClass("hidden");
    rowCont = null;
    rowGuia = null;

    $("div[table]").fadeIn("slow");
    $("div[table]").removeClass("hidden");

    $("form[savePersonalizado]").clear();
}
function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}
$(function () {
    $("#tbFormaPago").bootstrapTable();
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();        
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);

    });
    $("div[Contribuyente]").clear();

    $("button[clean]").click(function () {
        hideR();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });

    $("button[generar]").click(function () {
        input = "#total";
        totalDeuda = convertFloat($(input).html());
        //fecha = moment().format(fecha_format.save);
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
            datos = {
                valor: totalDeuda,
                idref: rowGuia.id,
                Tipo: Tipo
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
            if (data.status) {
                form = document.createElement("form");
                form.target = "_blank";
                form.method = "POST";
                form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobanteCambioTuberia.php";
                form.style.display = "none";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "datos";
                input.value = JSON.stringify({
                    id: data.id,
                    contribuyente: rowCont.nombre,
                    cedcontribuyente: rowCont.cedula,
                    ciucontribuyente: rowCont.ciu,
                    valor: totalDeuda,
                    direccion: rowGuia.direccion,
                    medida: $("h3[tipo]").html(),
                    //fecha: data.Fecha,
                    //cod: data.Coddocumento,
                    ccaapp: rowGuia.ccaapp,
                    ccpredio: rowGuia.ccpredio
                });
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
                $("div[Contribuyente] button[clear]").click();
            }
        }
    });

});

function Sadmin(abr) {
    json = getJson({
        url: getURL("_recurso"),
        data: {
            accion: "get",
            op: "sadmin",
            val: abr
        }
    });
    return json;
}

Tipo = "";
function PreguntarAccion() {
    $.confirm({
        theme: "modern",
        escapeKey: "cancelAction",
        title: 'Acción a realizar?',
        content: 'Permiso de para :',
        //autoClose: 'cancelAction|8000',
        buttons: {
            "1/2 Pulgada": {
                text: 'Conexión de 1/2 pulgada',
                //keys: ['enter'],
                action: function () {
                    showR();
                    Tipo = "CT1";
                    $("h3[tipo]").html("Medida : 1/2 (pulgada)");
                    $("#totalre").val(formatInputMask(Sadmin(Tipo).valor));
                    $("#total").html(formatInputMask(Sadmin(Tipo).valor));
                }
            },
            "3/4 Pulgada": {
                text: 'Conexión de 3/4 pulgada',
                action: function () {
                    showR();
                    Tipo = "CT2";
                    $("h3[tipo]").html("Medida : 3/4 (pulgadas)");
                    $("#totalre").val(formatInputMask(Sadmin(Tipo).valor));
                    $("#total").html(formatInputMask(Sadmin(Tipo).valor));
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

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='cedula']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");

        hideR();
        /* Cargar Guias */
        //reloadGuiaxContribuyente(row.id);
        rowCont = row;
    },
    "click button[edit]": function (e, value, row, index) {
        e.preventDefault();
        PreguntarAccion();
        $("#tbFormaPago").removeClass("hidden");
        limpiarTbFormaPago("#tbFormaPago");
        rowGuia = row;
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable();
        $("#tbDetalleGuia").bootstrapTable("load", [rowGuia]);
    }

};

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

function BtnAccion(value, rowData, index) {
    return "<button edit type='button' class='btn btn-info btn-sm'><i class='fa fa-tint'></i></button>";
}

function reloadGuiaxContribuyente(idContribuyente = $('input[name="id"]').val()) {
    datos = tbGuiasxContribuyente(idContribuyente);
    $("#tbDetalleGuia").bootstrapTable("load", datos.rows);
}
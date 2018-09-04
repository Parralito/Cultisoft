table = $("div[Listado] table");
selections = [];
fPago = cboFPago();

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}

$(function () {
    initialComponents();
    $("input[data-tipo='myDecimal']").inputmask("myDecimal");
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
    $("#tbDetalleJuicio").bootstrapTable();
    $("#tbContribuyente").bootstrapTable(TablePaginationDefault);
    $("div[Contribuyente] button[clear]").click(function () {
        $("label[cl]").html("");
        $("div[Contribuyente]").clear();
        $("#tbDetalleGuia").bootstrapTable("removeAll");
        $("form[save]").clear();
        $("div[new]").addClass("hidden");
    });
    $("div[Contribuyente]").clear();
    iniciar();
    $("button[clean]").click(function () {
        $("form[save]").clear();
        iniciar();
    });
});
// Funciones----------------------------------------------------------------------------------
function iniciar() {
    $("div[init].inputComponent button[refresh]").click();
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbGeneraAbonos").bootstrapTable();
    $("#tbFormaPago").bootstrapTable();
}

function btnEditarGuia(value) {
    return "<button edit type='button' class='btn btn-info btn-sm'><i class='fa fa-list-ul'></i></button>";
}
function MuestraDivNew()
{
    $("div[new]").removeClass("hidden");
    $("div[new]").fadeIn();
}
function OcultaDivNew()
{
    $("div[new]").addClass("hidden");
    $("div[new]").fadeOut();
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

// Eventos--------------------------------------------------------------------------------------
window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("#modal-contribuyente").modal("hide");
        $("label[cl]").html("");
        $("div[new]").addClass("hidden");
        $("div[Contribuyente]").edit(row);
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("#tbDetalleGuia").bootstrapTable("refresh");

        //$("input[name='idguia']").val(row.id);
    },
    "click button[edit]": function (e, value, row, index) {
        $("#tbGeneraAbonos").bootstrapTable("load", tbDetAbonosJuicioCoactiva(row.idjuicio));
        $("input[name='idjuicio']").val(row.idjuicio);
        $("input[name='idguia']").val(row.id);
        MuestraDivNew();
    },
    "click button[reimprimir]": function (e, value, row, index) {
        e.preventDefault();
        form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = "MVC/Vista/Financiero/print/ComprobanteAbonoJuicioCoactiva.php"; //"Servidor/sFinanciero.php";
        form.style.display = "none";
        data = {
            idabono: row.id
        };
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "data";
        input.value = JSON.stringify(data);

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
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

function BtnAccion(value, rowData, index) {
    if (rowData.estado === "ACT")
        return '<button reimprimir class="btn btn-success btn-sm"> <i class="fa fa-print" ></i> </button>';
}

$("form[savePersonalizado]").submit(function (e) {
    e.preventDefault();
    $("button[abonar]").click();
    datos = getDatos(this);
    saveGlobal(datos);
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    OcultaDivNew();
    $("#tbDetalleGuia").bootstrapTable("load", tbGuiasxContribuyenteCoactivaReg(idContribuyente).rows);
});
function getDatos(form) {
    datos = JSON.parse($(form).serializeObject_KBSG());
    fpagossum = $("#tbFormaPagoAJC").bootstrapTable("getData").filter(row => row.valor > 0);
    datos.valor = fpagossum.reduce((a, b) => a + b.valor, 0);
    datos["detalleregistro"] =
            {
                usuario: 'MPARRALES',
                estacion: 'Parralito-PC'
            };
    if ($.isEmptyObject(datos.idjuiciocoactivo)) {
        MsgError({
            title: "Advertencia",
            content: "Debe seleccionar un Juicio"
        });
    } else {
        dt = {
            url: getURL($(form).attr("action")),
            dt: {
                accion: "save",
                op: $(form).attr("role"),
                datos: JSON.stringify(datos),
                fpagos: JSON.stringify(fpagossum)
            }
        };
        return dt;
    }
    return undefined;
}


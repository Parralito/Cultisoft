table = $("div[Listado] table");
selections = [];
rowActual = null;
/*Datos del juicio coactiva*/
subtotal = 0;
impuestos = 0;
abonado = 0;
entrada = 0;
saldobase = 0;
residuo = 0;
/*Tarifario y Parámetros*/
Recurso = [];
edit = 0;
validar = 0;

/* Formas de pago*/
fPago = cboFPago();

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = "ACT";
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
        idContribuyente = $("div[Contribuyente] input[name='id']").val();
        OcultaDivNew();
        $("#tbDetalleGuia").bootstrapTable("refresh");
    });

    $("button[reimprimir]").click(function () {

        input = "#totalimp";
        totalDeuda = convertFloat($(input).html());
        dtTableFP = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        if (sum !== totalDeuda) {
            //Mensaje
            MsgError({
                title: "<small>Error! Pago insuficiente</small>",
                content: ["Total: <strong>" + totalDeuda + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
        } else
        {            
            fpagossum = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);            
            datos =
                    {
                        valor: totalDeuda, 
                        FechaSadmin: rowActual.fechareg,
                        Tipo: "RI",
                        //Coddocumento: "",
                        detalle: "RJ-" + rowActual.cod
                    };
            dt = {
                url: getURL("_sadministrativo"),
                dt: {
                    accion: "save",
                    op: "SADMIN",
                    datos: JSON.stringify(datos),
                    fpagos: JSON.stringify(fpagossum)
                }
            };
            saveGlobal(dt);
            //Generar el Permiso de Conexion
            form = document.createElement("form");

            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/Financiero/print/ComprobanteRegJuicioCoactiva.php"; //"Servidor/sFinanciero.php";
            form.style.display = "none";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "idjuicio";
            input.value = JSON.stringify(rowActual.idjuicio);
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            $("div[Reimprimir]").addClass("hidden");
        }
    });
});
// Funciones----------------------------------------------------------------------------------
function iniciar() {
    $("div[init].inputComponent button[refresh]").click();
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbFormaPago").bootstrapTable();
}

function btnEditarGuia(value) {
    return "<button edit type='button' class='btn btn-info btn-sm'><i class='fa fa-dollar-sign'></i></button>";
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
    },
    "click button[reimprimir]": function (e, value, row, index) {
        e.preventDefault();
        rowActual=row;
        RI = getJson({
            url: getURL("_recurso"),
            data: {
                accion: "get",
                op: "sadmin",
                val: "RI"
            }
        });
        limpiarTbFormaPago("#tbFormaPago");
        $("div[Reimprimir]").removeClass("hidden");
        $("span[id='totalimp']").html(formatInputMask(RI.valor));
        
    }
};
function BtnAccion(value, rowData, index) {
    return '<button reimprimir class="btn btn-success btn-sm"> <i class="fa fa-print" ></i> </button>';
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
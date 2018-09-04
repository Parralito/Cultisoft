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
    $("button[reimprimir]").click(function () {
        input = "#totalimp";
        totalDeuda = convertFloat($(input).html());
        fecha = $("input[name='fechaabono']").val();
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
            // Generar el reimpresion
            idabono = $("input[name='idabono']").val();
            idguia = $("input[name='idguia']").val();
            valor = $("label[name='abono']").html();
            valorimpresion = $("span[id='totalimp']").html();
            codigo=$("input[name='Cod']").val();
            fpagossum = $("#tbFormaPago").bootstrapTable("getData").filter(row => row.valor > 0);            
            
            datos =
                    {                        
                        valor: valorimpresion,
                        FechaSadmin: fecha,
                        Tipo: "RI",
                        Coddocumento:"",
                        detalle:"AJ-"+codigo
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
            form = document.createElement("form");
            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/Financiero/print/ComprobanteAbonoJuicioCoactiva.php"; //"Servidor/sFinanciero.php";
            form.style.display = "none";
            data =
                    {
                        idabono: idabono,
                        valor: valor,
                        fecha: fecha
                    };

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "data";
            input.value = JSON.stringify(data);

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            $("div[Reimprimir]").addClass("hidden");
        }
    });
    $("button[anular]").click(function () {
        valor = $("label[name='abono']").html();
        idabono = $("input[name='idabono']").val();
        idjuicio = $("input[name='idjuicio']").val();
        motivo = $("textarea[motivo]").val();
        if (motivo !== "")
        {
            data = {
                id: idabono,
                motivo: motivo
            };
            $.confirm({
                theme: "modern",
                escapeKey: "cancelAction",
                title: 'ANULAR PAGO',
                autoClose: 'cancelAction|8000',
                content: 'Está seguro de anular el abono de ' + valor + ' dólares?',
                buttons: {
                    Aceptar: {
                        text: 'Aceptar',
                        //keys: ['enter'],

                        action: function () {
                            $.post(getURL("_financiero"), {
                                data: JSON.stringify(data),
                                op: "UPDATEESTADOABONO",
                                accion: "save"
                            });                            
                            $("#tbGeneraAbonos").bootstrapTable("load", tbDetAbonosJuicioCoactiva(idjuicio));
                            $("div[new]").addClass("hidden");
                            $("textarea[motivo]").val("");
                            $("#tbDetalleGuia").bootstrapTable("refresh");
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
        } else
        {
            MsgError({
                title: "Error",
                content: ["Ingrese el motivo por el cual anula el abono"]
            });
        }
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
        $("div[Anular]").addClass("hidden");
        $("#tbGeneraAbonos").bootstrapTable("load", tbDetAbonosJuicioCoactiva(row.idjuicio));
        $("input[name='idjuicio']").val(row.idjuicio);
        $("input[name='idguia']").val(row.id);
        MuestraDivNew();
    },
    "click button[anular]": function (e, value, row, index) {
        e.preventDefault();
        $("textarea[motivo]").val("");
        $("div[Reimprimir]").addClass("hidden");
        $("div[Anular]").removeClass("hidden");
        $("input[name='idabono']").val(row.id);
        $("input[name='fechaabono']").val(row.fecha);
        $("label[name='abono']").html(row.valor);
        $("#tbDetalleGuia").bootstrapTable("refresh");

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
    {
        return '<button anular class="btn btn-danger btn-sm"> <i class="fa fa-times" ></i> </button>';
    }
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


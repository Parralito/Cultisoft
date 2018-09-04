table = $("div[Listado] table");
selections = [];

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
    console.log(params);
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
    $("button[calcular]").click(function ()
    {
        deuda = $("input[name='deuda']").getFloat();
        entrada = $("input[name='entrada']").getFloat();
        abonado = $("input[name='abonado']").getFloat();
        saldo = $("input[name='saldo']").getFloat();

        if (entrada < deuda)
        {
            if (abonado <= (deuda - entrada))
            {
                $("input[name='saldo']").val(formatInputMask(deuda - entrada - abonado));
                fechainicioplazo = fechaMoment($("input[name='fechainicioplazo']").val(), fecha_format.view);
                nmeses = $("input[name='nmeses']").getFloat();
                fechafinplazo = fechainicioplazo.add(nmeses, 'month').subtract(1, 'day');
                var dates = [
                    {"type": "date", "name": "fechafinplazo", "valor": fechafinplazo}
                ];
                Asigna(dates);
                validar = 0;
            } else
            {
                $.dialog({
                    title: 'Advertencia!',
                    content: 'El total de abonado excede lo permitido'
                });
                validar = 1;
            }
        } else
        {
            $.dialog({
                title: 'Advertencia!',
                content: 'La entrada debe ser menor que la deuda'
            });
            validar = 1;
        }
    });
});
// Funciones----------------------------------------------------------------------------------
function iniciar() {
    $("div[init].inputComponent button[refresh]").click();
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    $("#tbFormaPagoAJC").bootstrapTable();
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
    "click button[edit]": function (e, value, row, index) {
        MuestraDivNew();
        DetalleGuiaCoactiva = tbDetalleGuiaCoactiva(row.id);
        if (DetalleGuiaCoactiva.rows.length > 0)
        {
            DetalleGuiaCoactiva = (DetalleGuiaCoactiva.rows[0]);
            console.log(DetalleGuiaCoactiva);
            $("div[new]").edit(DetalleGuiaCoactiva);
            saldobase = DetalleGuiaCoactiva.saldo;
            cMes = (DetalleGuiaCoactiva.cMes);
            abonado = (DetalleGuiaCoactiva.abonado);
            saldo = (DetalleGuiaCoactiva.saldo);
            entrada = DetalleGuiaCoactiva.entrada;
            deuda = DetalleGuiaCoactiva.deuda;
            nmeses = DetalleGuiaCoactiva.nmeses;
            // Extraer impuestos-----------------------------------------------------------------

        }
        var inputs = [
            {"type": "input", "name": "entrada", "valor": entrada},
            {"type": "input", "name": "saldo", "valor": saldo},
            {"type": "asign", "name": "idjuiciocoactivo", "valor": DetalleGuiaCoactiva.id}
        ];
        Asigna(inputs);
    }
};

$("form[savePersonalizado]").submit(function (e) {
    e.preventDefault();
    $("button[calcular]").click();
    if (validar === 0)
    {
        datos = getDatos(this);
        save = saveGlobal(datos);
        OcultaDivNew();
        $("#tbDetalleGuia").bootstrapTable("refresh");
    }
});
function getDatos(form) {
    datos = JSON.parse($(form).serializeObject_KBSG());
    datos.id=$("input[name='idjuiciocoactivo']").val();
    datos.fechainicioplazo=$("input[name='fechainicioplazo']").getFecha();
    datos.fechafinplazo=$("input[name='fechafinplazo']").getFecha();
    dt = {
        url: getURL($(form).attr("action")),
        dt: {
            accion: "save",
            op: $(form).attr("role"),
            datos: JSON.stringify(datos)
        }
    };
    return dt;
}
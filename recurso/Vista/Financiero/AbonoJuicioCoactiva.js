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
var rowActual = null;

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    params.estado = "ACT";
    return params;
}


$(function () {
    initialComponents();
    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

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
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });
    $("button[abonar]").click(function () {
        fechainicioplazo = $("input[name='fechainicioplazo']").getFecha();
        fechafinplazo = $("input[name='fechafinplazo']").getFecha();
        fpagossum = $("#tbFormaPagoAJC").bootstrapTable("getData").filter(row => row.valor > 0);
        abono = fpagossum.reduce((a, b) => a + b.valor, 0);
        if (abono > 0)
        {
            validar = 1;
            abonado = $("label[name='lbabonado']").html();            
            mensual = $("input[name='mensual']").val();            
            abonototal = formatInputMask(convertFloat(abonado) + convertFloat(abono));            
            TablaDetalleAbono(fechainicioplazo, fechafinplazo, mensual, abonototal);
        } else
        {
            $.dialog({
                title: 'Advertencia!',
                content: 'Ingrese un valor para abonar'
            });
            validar = 0;
        }
    });
    $("#tbValoresFinalesValores").bootstrapTable();
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

function TablaDetalleAbono(fechainicioplazo, fechafinplazo, mensualidad, abonado)
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
    mensualidad = convertFloat(mensualidad);
    deuda =convertFloat($("label[name='lbdeudaentrada']").html());
    meses = $("input[name='nmeses']").val();
    deuda2 = meses * mensualidad;
    dif = roundNumber(deuda, 2) - roundNumber(deuda2, 2);
    ab = abonado;
    $("#tbValoresFinalesValores").bootstrapTable("load", dtmesesjuicio.map(function (rw, i) {
        if (i === (dtmesesjuicio.length - 1))
        {
            rw.mensualidad = mensualidad + dif;
        } else
        {
            rw.mensualidad = mensualidad;
        }
        rw.total = ab - rw.mensualidad > 0 ? rw.mensualidad : ab;
        ab = ab - rw.mensualidad;
        return rw; 
    }));
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

function DetalleMesesPagados() {
    dtmesesjuicioabonado = getJson({
        data: {
            op: "Detalle.Meses.Juicio.Abonado",
            accion: "list",
            idjuicio: DetalleGuiaCoactiva.id
        },
        url: getURL("_financiero")
    });
    return dtmesesjuicioabonado;
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
        limpiarTbFormaPago("#tbFormaPagoAJC");
        if (DetalleGuiaCoactiva.rows.length > 0)
        {
            $("input[name='entrada']").attr("readonly", true);
            DetalleGuiaCoactiva = (DetalleGuiaCoactiva.rows[0]);
            console.log(DetalleGuiaCoactiva);
            cMes = DetalleGuiaCoactiva.cMes;
            abonado = DetalleGuiaCoactiva.abonado!=null?DetalleGuiaCoactiva.abonado:0;
            saldo = DetalleGuiaCoactiva.saldo;
            entrada = DetalleGuiaCoactiva.entrada;
            deuda = DetalleGuiaCoactiva.deuda; 
            nmeses = DetalleGuiaCoactiva.nmeses;
            mensualidad = formatInputMask((deuda - entrada) / nmeses);            
        }
        var labels = [
            {"type": "label", "name": "lbsaldo", "valor": saldo},
            {"type": "label", "name": "lbabonado", "valor": abonado},
            {"type": "label", "name": "lbentrada", "valor": entrada},
            {"type": "label", "name": "lbdeudaentrada", "valor": deuda - entrada},                      
            {"type": "label", "name": "lbtotal", "valor": deuda},
            {"type": "input", "name": "nmeses", "valor": nmeses},            
            {"type": "input", "name": "mensual", "valor": mensualidad},
            {"type": "asign", "name": "idjuiciocoactivo", "valor": DetalleGuiaCoactiva.id}
        ];        
        
        $("input[name='fechainicioplazo']").val(formatView(DetalleGuiaCoactiva.fechainicioplazo));
        $("input[name='fechafinplazo']").val(formatView(DetalleGuiaCoactiva.fechafinplazo));
        $("input[name='fechainiciodeuda']").val(formatView(DetalleGuiaCoactiva.fechainiciodeuda));
        $("input[name='fechafindeuda']").val(formatView(DetalleGuiaCoactiva.fechafindeuda));
        
        Asigna(labels);           
        TablaDetalleAbono(DetalleGuiaCoactiva.fechainicioplazo, DetalleGuiaCoactiva.fechafinplazo, mensualidad,abonado);

        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable();
        $("#tbDetalleGuia").bootstrapTable("load", [row]);
    }
};
window.event_input = {
    "change input[myDecimal]": function (e, value, row, index) {
        valor_update = convertFloat($(e.target).val());
        table = "#tbFormaPagoAJC";
        acumulador = valor_update;
        $.each($(table).bootstrapTable("getData"), function (i, rw) {
            if (index !== i)
                acumulador += convertFloat(rw.valor);
        });
        totalDeuda = convertFloat($("label[name='lbsaldo']").html());
        bandera = !(totalDeuda - acumulador < 0);
        if (bandera) {
            row.valor = valor_update;
            $(table).bootstrapTable('updateRow', {
                index: index,
                row: row
            });
        } else
        {
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
$("form[savePersonalizado]").submit(function (e) {
    e.preventDefault();
    $("button[abonar]").click();
    if (validar == 1)
    {
        datos = getDatos(this);
        console.log(datos);
        save = saveGlobal(datos);
        
        if (save.id > 0)
        {
            $("#tbDetalleGuia").bootstrapTable("destroy");
            $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
            idContribuyente = $("div[Contribuyente] input[name='id']").val();
            idguia = $("input[name='idguias']").val();
            OcultaDivNew();
            form = document.createElement("form");
            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/Financiero/print/ComprobanteAbonoJuicioCoactiva.php"; 
            form.style.display = "none";
            data =
            {
                idabono: save.id
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

    }
});
function getDatos(form) {
    datos = JSON.parse($(form).serializeObject_KBSG());
    fpagossum = $("#tbFormaPagoAJC").bootstrapTable("getData").filter(row => row.valor > 0);
    datos.valor =fpagossum.reduce((a, b) => a + b.valor, 0); 
    datos.valor=(convertFloat(datos.valor));    
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

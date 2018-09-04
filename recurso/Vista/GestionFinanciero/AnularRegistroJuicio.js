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
    "click button[anular]": function (e, value, row, index) {
        $.confirm({
            theme: "modern",
            escapeKey: "cancelAction",
            title: 'ANULAR JUICIO',
            autoClose: 'cancelAction|8000',
            content: '¿Está seguro de anular el juicio?',
            buttons: {
                Aceptar: {
                    text: 'Aceptar',
                    action: function () {
                        $.post(getURL("_financiero"), {
                            data: row.idjuicio,
                            op: "UPDATEESTADOJUICIO",
                            accion: "save"
                        },
                                function (response) {
                                    $("#tbDetalleGuia").bootstrapTable("refresh");
                                }
                        );

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
};
function BtnAccion(value, rowData, index) {
    return ((rowData.vabonos > 0) ? '' : '<button anular class="btn btn-danger btn-sm"> <i class="fa fa-times" ></i> </button>');
}

var rowActual = null;

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}


$(function () {
    $("#tbDetalleGuia").bootstrapTable();

    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideUpdate();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });

    $("button[clean]").click(function (e) {
        hideUpdate();
        $("#tbDetalleGuia").bootstrapTable("destroy");
        $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    });

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault);
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    $("#modal-contribuyenteAsignar").on({
        'show.bs.modal': function () {
            $(this).find("table[tbContribuyente]").bootstrapTable(TablePaginationDefault);
        },
        'hidden.bs.modal': function () {
            $(this).find("table[tbContribuyente]").bootstrapTable("destroy");
        }
    });

    $("form[savePersonalizado]").submit(function (e) {
        e.preventDefault();
        if ($(this).validate()) {
            datos = JSON.parse($(this).serializeObject_KBSG());
            dt = {
                url: getURL($(this).attr("action")),
                dt: {
                    accion: "save",
                    op: $(this).attr("role"),
                    datos: $(this).serializeObject_KBSG()
                }
            };
            response = saveGlobal(dt);
            if (response.status) {
                MsgSuccess({
                    title: "Traspaso de Guía",
                    content: "Se realizo correctamente el traspaso."
                });
                $("button[clean]").click();
            }
        }
    });
});

function showUpdate() {
    $("div[update]").fadeIn("slow");
    $("div[update]").removeClass("hidden");
}

function hideUpdate() {
    $("div[update]").fadeOut("slow");
    $("div[update]").addClass("hidden");
    $("div[update]").clear();
}

function btnAccion() {
    return '<button update class="btn btn-danger" > <i class="fa fa-exchange-alt"></i> </button>';
}
function btnAsignar() {
    return '<button asignar class="btn btn-danger" > <i class="fa fa-arrow-alt-circle-right" ></i> </button>';
}

window.evtSelect = {
    "click button[update]": function (e, value, row, index) {
        $.post(getURL("_guia"), {
            id: row.id,
            accion: "delete",
            op: "valid.guias"
        }, function (response) {
            if (response.status) {
                rowActual = row;
                showUpdate();
                $("form[savePersonalizado]").data("id", row.id);
                $("#tbDetalleGuia").bootstrapTable("destroy");
                $("#tbDetalleGuia").bootstrapTable();
                $("#tbDetalleGuia").bootstrapTable("load", [rowActual]);
            } else {
                MsgError({
                    title: "ERROR",
                    content: "EL TRASPASO DE LA GUIA NO ES POSIBLE POR CUESTIONES DE DEUDA"
                });
            }
        }, "json");
    },
    "click button[asignar]": function (e, value, row, index) {
        $("#modal-contribuyenteAsignar").modal("hide");
        $("div[update] input[name='idcontribuyente']").val(row.id);
        $("div[update] input[contribuyente]").val(row.cedula + " - " + row.nombre);
    },
    "click button[select]": function (e, value, row, index) {

        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    }
};
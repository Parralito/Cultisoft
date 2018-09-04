rowActual = null;
$(function () {
    initialComponents();
    $("select").selectpicker();
    resetTable(1);
//    $("table[Permisos]").bootstrapTable(TablePaginationDefault);
    initSelect();

    $("#newPermiso").click(function (e) {
        $("input[name='fechapermiso']")
                .attr("data-tipo", "fecha")
                .initDate();

        $("input[name='fechapermiso']")
                .datepicker("update", new Date())
                .datepicker("setEndDate", new Date());
        showR();
        $("input[name='multa']").setFloat(0);
    });

    $("button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        hideR();
        $("table[Permisos]").bootstrapTable("removeAll");
    });
    $("button[clean]").click(function () {
        resetTable(1);
        hideR();
    });
    $("button[save]").click(function () {
        if ($("div[new]").validate()) {
            datos = $("div[new]").serializeObject_KBSG(false);
            datos.idcontribuyente = $("div[Contribuyente] input[name='id']").val();
            data = {
                url: getURL("_sadministrativo"),
                dt: {
                    accion: "save",
                    op: "PERMISOCONTRIBUYENTE",
                    datos: JSON.stringify(datos)
                }
            };
            result = saveGlobal(data);
            if (result.status) {
                MsgSuccess({
                    title: "Registro Exitoso.",
                    content: ""
                });
            }
            $("button[clean]").click();
        }else{
            MsgError({
                title: "Información Imcompleta",
                content: ""
            });
        }


    });

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });
});

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}

function BtnAccion(value, rowData, index) {
    return (rowData.estado === 'PAG') ? '' : '<button edit class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editar</a></li></button>';
}

function showR() {
    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
}
function hideR() {
    $("div[new]").fadeOut();
    $("div[new]").addClass("hidden");

}

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("div[Contribuyente] button[clear]").click();
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente] input[name='detalleContribuyente']").val(row.cedula + " - " + row.nombre);
        $("table[Permisos]").bootstrapTable("refresh");
    },
    "click button[edit]": function (e, value, row, index) {
        // Fecha
        $("input[name='fechapermiso']").datepicker("destroy");
        $("input[name='fechapermiso']").attr("data-tipo", "fechaView");

        showR();

        $("div[new]").edit(row);
        rowActual = row;
        resetTable(2);
    }
};

function resetTable(op) {
    table = "table[Permisos]";
    $(table).bootstrapTable("destroy");

    switch (op) {
        case 1:
            $(table).bootstrapTable($.extend({}, TablePaginationDefault, {
                search: false
            }));
            break;
        case 2:
            $(table).bootstrapTable();
            $(table).bootstrapTable("load", [rowActual]);
            break;
    }
}
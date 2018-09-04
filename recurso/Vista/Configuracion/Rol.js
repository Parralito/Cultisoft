table = $("div[Listado] table");
selections = [];
$(function () {
    $(table).bootstrapTable(TablePaginationDefault);
    $("#tbPermisoRol").bootstrapTable({
        height: 400
    });

    $("button[viewReset]").click(function () {
        setTimeout(function () {
            $("#tbPermisoRol").bootstrapTable("refresh");
        }, 200);
    });


});
function getDatos(form) {
    permisos = $("#tbPermisoRol").bootstrapTable("getSelections").map(row => row.id);
    datos = {
        url: getURL($(form).attr("action")),
        dt: {
            accion: "save",
            op: $(form).attr("role"),
            datos: $(form).serializeObject_KBSG(),
            permisos: JSON.stringify(permisos)
        }
    };
    //$("#tbPermisoRol").bootstrapTable("refresh");
    selections = [];
    return datos;
    
}

function edit(datos) {
    $("form[save_fn]").edit(datos);
    $("#tbPermisoRol").bootstrapTable("refresh");
    dt = {
        url: getURL("_configuracion"),
        data: {
            accion: "list",
            op: "PERMISOxROL",
            rol: datos.id
        }
    };
    datos = getJson(dt);
    _ids = $.isArray(datos) ? datos.map(row => row.id.toString()) : [];

    $("#tbPermisoRol").bootstrapTable("checkBy", {
        field: "id", values: _ids
    });

}

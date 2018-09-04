table = $("div[Listado] table");
selections = [];
$(function () {
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
    
    $("textarea[name='descripcion_descuento']").attr("disabled",true);

    $("#descuento").change(function () {
        $("textarea[name='descripcion_descuento']")
                .attr("disabled",!$(this).prop("checked"))
                .val("");
    });
    
    $("select[name='idtipoidentificacion']").change(function () {
        $("input[name='cedula']").val("");
        switch ($(this).val()) {
            case "1":
                $("input[name='cedula']").attr("maxlength", 10);
                break;
            case "2":
                $("input[name='cedula']").attr("maxlength", 13);
                break;
        }
    });
});

function initRegistro(){
    $("textarea[name='descripcion_descuento']").attr("disabled",true);
}

function getDatos(form) {

    datos = {
        url: getURL($(form).attr("action")),
        dt: {
            accion: "save",
            op: $(form).attr("role"),
            datos: $(form).serializeObject_KBSG() // $(form).serializeObject_KBSG()
        }
    };
    return datos;
}


function edit(datos) {
    form = "form[save_fn]";
    $(form).edit(datos);
    $("textarea[name='descripcion_descuento']").attr("disabled",!(parseInt(datos.descuento)));
}
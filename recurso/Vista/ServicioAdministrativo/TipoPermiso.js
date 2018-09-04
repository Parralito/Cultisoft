//table = $("div[Listado] table");
selections = [];
$(function () {
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);


    $("form[savePersonalizado] button[type='reset']").click(function () {
        $(this).trigger("reset");
        $.each($(this).find('select'), function (i, select) {
            $(select).selectpicker('refresh');
            $(select).change();
        });
        $("input[name='abr']").prop("readonly", false);
        $("input[name='abr']").removeAttr("exclud");
        hideRegistro();
    });
    $("form[savePersonalizado]").submit(function (e) {
        e.preventDefault();
        dt = {
            url: getURL($(this).attr("action")),
            dt: {
                accion: "save",
                op: $(this).attr("role"),
                datos: $(this).serializeObject_KBSG()
            }
        };
        dt = saveGlobal(dt);
        if (dt.status) {
            MsgSuccess({
                title: "Registro Exitoso",
                content: ""
            });
            $("input[name='abr']").prop("readonly", false);
            $("input[name='abr']").removeAttr("exclud");
            hideRegistro();
            $(this).trigger("reset");
        }
    });
});

function edit(datos) {
    $("form[savePersonalizado]").edit(datos);
    $("input[name='abr']").prop("readonly", true);
    $("input[name='abr']").attr("exclud", "");
}
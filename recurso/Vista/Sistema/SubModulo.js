table = $("div[Listado] table");
selections = [];
$(function () {
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);

    initSelect();

    $("#cboIcon").change(function () {
        icon = $(this).selectpicker("val");
        $("#icono").removeAttr("class");
        $("input[name='icon']").val(icon);
        $("#icono").attr("class", "fa fa-4x fa-" + icon);
    });
//    $("button[initRegistro]").click(function () {
//        $("#cboIcon").selectpicker("val", "folder-open");
//        $("#cboIcon").change();
//    });

//    $("button[reset]").click(function () {
//        $("form[save]").trigger("reset");
//        $('select').selectpicker('refresh');
//        $('select').change();
//        
//        //alert($('select[name="idmodulo"]').selectpicker("val"));
//        //alert();
//
//    });



});

function edit(datos) {
    $("form[save]").edit(datos);
    $("#cboIcon").selectpicker("val", datos.icon);
    $("#cboIcon").change();
}
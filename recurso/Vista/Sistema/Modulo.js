table = $("div[Listado] table");
selections = [];
$(function(){
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
    
    
    
    $("#cboIcon").change(function () {
        icon = $(this).selectpicker("val");
        $("#icono").removeAttr("class");
        $("input[name='icon']").val(icon);
        $("#icono").attr("class", "fa fa-4x fa-" + icon);
    });
    $("#cboIcon").selectpicker("val", "folder-open").change();
    
});

function edit(datos){
    $("form[save]").edit(datos);
    $("#cboIcon").selectpicker("val", datos.icon).change();
}
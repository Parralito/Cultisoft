table = $("div[Listado] table");
selections = [];
$(function(){
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
});

function edit(datos){
    $("form[save]").edit(datos);
}


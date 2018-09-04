table = $("div[Listado] table");
selections = [];
$(function () {
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
    initSelect();
    
});

function edit(datos) {
    $("form[save]").edit(datos);
}

function getAlcantarillado(valor) {
    return parseInt(valor) ? "Si" : "No";
}
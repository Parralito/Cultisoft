table = $("div[Listado] table");
selections = [];


function fnparams(params) {
    params.tipo = $('select[name="documentos"]').selectpicker("val");
    return  params;
}
$(function () {
    documentos = cboTipoPermiso();
    documentos.rows = documentos.rows.map(function(row){
        return { id: row.abr, descripcion: row.descripcion };
    });
    documentos.rows.unshift({id: "*", descripcion: "Todos"});

    $("select[name='documentos']").selectpicker();
    loadCbo(documentos, "select[name='documentos']");
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
});
function btnAccion(value, row) {
    return  (row.estado === 'ANU')? 'Anulado':'<button reimprimir class="btn btn-success btn-sm"> <i class="fa fa-print" ></i> </button>';
}
// Eventos---------------------------------------------------------------------------------------
window.evtSelect = {
    "click button[reimprimir]": function (e, value, row, index) {
        form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobantePermisoConexion.php";
        form.style.display = "none";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "datos";
        input.value = JSON.stringify({
            id: row.id
        });
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
};
$("select[name='documentos']").on('change', function () {
    $("div[Listado] table").bootstrapTable('refresh');
});

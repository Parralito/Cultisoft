table = $("div[Listado] table");
selections = [];

documentos = {
    rows: [
        {id: "*", descripcion: "Todos"},
        {id: "CT1", descripcion: "Permiso ReConexión 1/2"},
        {id: "CT2", descripcion: "Permiso ReConexión 3/4"}
    ]
};

function fnparams(params) {
    params.tipo = $('select[name="documentos"]').selectpicker("val");
    return  params;
}
$(function () {
//    initialComponents();    
    //$("div[Listado] table").bootstrapTable(TablePaginationDefault);    
    $("select[name='documentos']").selectpicker();
    loadCbo(documentos, "select[name='documentos']");
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
});
function btnAccion(value) {
    return '<button reimprimir class="btn btn-success btn-sm"> <i class="fa fa-print" ></i> </button>';
}
// Eventos---------------------------------------------------------------------------------------
window.evtSelect = {
    "click button[reimprimir]": function (e, value, row, index) {
        form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = "MVC/Vista/ServicioAdministrativo/print/ComprobanteCambioTuberia.php"; //"Servidor/sFinanciero.php";
        form.style.display = "none";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "datos";
        input.value = JSON.stringify({
            id: row.id,
            contribuyente:row.nombre,
            cedcontribuyente:row.cedula,            
            valor: row.valor,
            direccion: row.datos,
            medida: row.descripcion,
//            cod: row.coddocumento,
//            fecha: row.fechasadmin,
            ccaapp:row.ccaapp,
            ccpredio:row.ccpredio
        });
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        //$("div[Permisos]").addClass("hidden");
    }
};
$("select[name='documentos']").on('change', function () {
    $("div[Listado] table").bootstrapTable('refresh');
});

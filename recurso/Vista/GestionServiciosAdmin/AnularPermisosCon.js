table = $("div[Listado] table");
selections = [];

//documentos = {
//    rows: [
//        {id: "*", descripcion: "Todos"},
//        {id: "PC1", descripcion: "Permiso Conexión 1/2"},
//        {id: "PC2", descripcion: "Permiso Conexión 3/4"},
//        {id: "PA", descripcion: "Permiso Conexión Alcantarillado"}
//    ]
//};

function fnparams(params) {
    params.tipo = $('select[name="documentos"]').selectpicker("val");
    return  params;
}
$(function () {
    /* Cargar Permiso */
    documentos = cboTipoPermiso();
    documentos.rows = documentos.rows.map(function(row){
        return { id: row.abr, descripcion: row.descripcion };
    });
    documentos.rows.unshift({id: "*", descripcion: "Todos"});
    
    $("select[name='documentos']").selectpicker();
    loadCbo(documentos, "select[name='documentos']");
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
});
function btnAccion(value, row, index) {
    return (row.estado === 'ANU')? 'Anulado':'<button anular class="btn btn-danger btn-sm"> <i class="fa fa-times" ></i> </button>';
}
// Eventos---------------------------------------------------------------------------------------
window.evtSelect = {
    "click button[anular]": function (e, value, row, index) {
        data = {
            id: row.id
        };
        $.confirm({
            theme: "modern",
            escapeKey: "cancelAction",
            title: 'ANULAR PERMISO',
            autoClose: 'cancelAction|8000',
            type: "orange",
            content: 'Está seguro de anular : <br> Permiso : ' + row.descripcion + ' <br>Código : ' + row.coddocumento + '',
            buttons: {
                Aceptar: {
                    text: 'Aceptar',
                    //keys: ['enter'],

                    action: function () {
                        $.post(getURL("_sadministrativo"), {
                            data: JSON.stringify(data),
                            op: "UPDATEESTADOPERMISO",
                            accion: "save"
                        });
                        $("div[Listado] table").bootstrapTable('refresh');
                    }
                },
                cancelAction: {
                    text: "Cancelar",
                    action: function () {
                        //$.alert('action is canceled');
                    }
                }
            }
        });
    }
};
$("select[name='documentos']").on('change', function () {
    $("div[Listado] table").bootstrapTable('refresh');
});

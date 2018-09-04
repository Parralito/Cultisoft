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
    return '<button anular class="btn btn-danger btn-sm"> <i class="fa fa-times" ></i> </button>';
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
                        },
                                function (response) {
                                    $("div[Listado] table").bootstrapTable('refresh');
                                }
                        );
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

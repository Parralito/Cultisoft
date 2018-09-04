rowActual = null;
$(function () {
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);

    $("#modal-contribuyente").on({
        'show.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable(TablePaginationDefault)
        },
        'hidden.bs.modal': function () {
            $("#tbContribuyente").bootstrapTable("destroy");
        }
    });

    $("div[Contribuyente] button[clear]").click(function () {
        $("div[Contribuyente]").clear();
        $("#tbDetalleGuia").bootstrapTable("removeAll");
    });
});

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='cedula']").val(row.cedula + " - " + row.nombre);
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente]").data("desc", row.descuento);
        //hideR();
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    },
    "click button[anular]": function (e, value, row, index) {
        e.preventDefault();

        $.post(getURL("_guia"), {
            id: row.id,
            accion: "delete",
            op: "valid.guias"
        }, function (response) {
            if (response.status) {
                /* Mensaje de Anulacion */

                $.confirm({
                    theme: "modern",
                    escapeKey: "cancelAction",
                    title: 'Anular Guía',
                    type: 'red',
                    content: 'Está seguro de anular la guia con código CCAAPP: ' + row.ccaapp,
                    autoClose: 'cancelAction|8000',
                    buttons: {
                        Anular: {
                            text: 'Anular',
                            btnClass: 'btn-danger',
                            keys: ['enter'],
                            action: function () {
                                rs = saveGlobal({
                                    url: getURL('_guia'),
                                    dt: {
                                        accion: "delete",
                                        op: "ANULAR.GUIA",
                                        id: row.id
                                    }
                                });
                                if(rs){
                                    $("#tbDetalleGuia").bootstrapTable("refresh");
                                    MsgSuccess({
                                        title : "Operacion Exitosa",
                                        content : ""
                                    });
                                }else{
                                    MsgError({
                                        title : "Error en la operación",
                                        content : "Verifique e intentelo de nuevo."
                                    });
                                }
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
                /* Mensaje de Anulacion */

            } else {
                MsgError({
                    title: "ERROR AL INACTIVAR",
                    content: "Inactivar la Guía no es posible por cuestiones de DEUDA"
                });
            }
        }, "json");
    }
};

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}
function BtnAnular() {
    return '<button class="btn btn-sm btn-danger" anular><i class="fa fa-trash"></i></button>';
}
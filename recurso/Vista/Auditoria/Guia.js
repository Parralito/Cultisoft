table = $("div[Listado] table");
selections = [];
fPago = cboFPago();
PA = null;
rowActual = null;

function showR() {
    $("div[table]").fadeOut();
    $("div[table]").addClass("hidden");

    $("div[new]").fadeIn("slow");
    $("div[new]").removeClass("hidden");
}
function hideR() {
    $("div[new]").fadeOut();
    $("div[new], div[activar], div[inactivar]").addClass("hidden");
    rowActual = null;

    $("div[table]").fadeIn("slow");
    $("div[table]").removeClass("hidden");

    $("form[savePersonalizado]").clear();    
}

function fn_query(params) {
    idContribuyente = $("div[Contribuyente] input[name='id']").val();
    params.idContribuyente = $.isEmptyObject(idContribuyente) ? 0 : idContribuyente;
    return params;
}
function fn_queryaudit(params) {    
    params.guia = rowActual== null ? 0 : rowActual.id;
    return params;
}
$(function () {
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
    opciones=$.extend({},TablePaginationDefault,{
        search: false
    });
    
    $("#tbDetalleMensualidad").bootstrapTable(opciones);    
    $("div[detalle] input[alcantarillado]").setPorcent(0);
    $("div[detalle] input[mensualidad]").setFloat(0);

    $("#newGuia").click(function (e) {
        if ($('input[name="cedula"]').val() !== "") {
            // Fecha 
            $("input[name='fecha']")
                    .attr("data-tipo", "fecha")
                    .initDate("2008-12-01");
            //initFecha();
            $("input[name='fecha']").datepicker("update", new Date());

            desc = parseInt($("div[Contribuyente]").data("desc"));
            $("div[detalle] input[descuento]").attr("disabled", !desc);


            iniciar();

            showR();
            $("div[PermisoConexion]").removeClass("hidden");
            limpiarTbFormaPago("#tbFormaPago");
            $("input[name='multa']").setFloat(0);
        }
    });

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
        hideR();
        $("#tbDetalleGuia").bootstrapTable("removeAll");

    });

    $("div[Contribuyente]").clear();

    $("button[clean]").click(function () {
        hideR();
    });

    $("div[inactivar] button[clean],div[activar] button[clean]").click(function () {
        reloadGuiaxContribuyente();
        hideR();
    });

    $('select[name="idruta"]').on('changed.bs.select', function () {
        id = $(this).selectpicker("val");
        loadCbo(cboSectorRuta(id), $('select[name="idsector"]'));
    });

    $('select[name="idciudad"]').on('changed.bs.select', function () {
        id = $(this).selectpicker("val");
        loadCbo(cboParroquiaxCiudad(id), $('select[name="idparroquia"]'));
    });

    $("form[savePersonalizado]").submit(function (e) {
        e.preventDefault();
        datos = getInformacion(this);
//        return;
        if (!$.isEmptyObject(datos)) {
            response = saveGlobal(datos);
            $("#tbDetalleGuia").bootstrapTable("refresh");
            hideR();
        }
    });

    $("div[inactivar] form").submit(function (e) {
        e.preventDefault();
        datos = JSON.parse($(this).serializeObject_KBSG());
        datos.id = rowActual.id;

        if (datos.costo <= 0) {
            MsgError({
                title: "ERROR",
                content: ["Valor de Costo invalido."]
            });
            return;
        }


        input = $("div[inactivar] span[total]");
        totalDeuda = convertFloat($(input).html());

        dtTableFP = $("div[inactivar] table").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        if (sum === totalDeuda) {
            $.post(
                    getURL($(this).attr("action")),
                    {
                        dt: JSON.stringify(datos),
                        accion: "delete",
                        op: $(this).attr("role"),
                        fpagos: JSON.stringify(dtTableFP)
                    }, function (response) {
                if (response.status) {
                    MsgSuccess({
                        title: "EXITO AL INACTIVAR GUIA",
                        content: ""
                    });
                    //$("#tbDetalleGuia").bootstrapTable("refresh");
                    reloadGuiaxContribuyente();
                    hideR();
                }
            }, "json");

        } else {
            MsgError({
                title: "Error <small>Pago Incorrecto</small>",
                content: ["Total: <strong>" + formatInputMask(totalDeuda) + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
        }
    });

    $("div[activar] form").submit(function (e) {
        e.preventDefault();
        datos = JSON.parse($(this).serializeObject_KBSG());
        datos.id = rowActual.id;

        if (datos.reconexion <= 0) {
            MsgError({
                title: "ERROR",
                content: ["Valor de Reconexión invalido."]
            });
            return;
        }

        input = $("div[activar] span[total]");
        totalDeuda = convertFloat($(input).html());

        dtTableFP = $("div[activar] table").bootstrapTable("getData").filter(row => row.valor > 0);
        sum = dtTableFP.reduce((a, b) => a + b.valor, 0);
        if (sum === totalDeuda) {
            $.post(
                    getURL($(this).attr("action")),
                    {
                        dt: JSON.stringify(datos),
                        accion: "save",
                        op: $(this).attr("role"),
                        fpagos: JSON.stringify(dtTableFP)
                    }, function (response) {
                if (response.status) {
                    MsgSuccess({
                        title: "EXITO AL ACTIVAR GUIA",
                        content: ""
                    });
                    //$("#tbDetalleGuia").bootstrapTable("refresh");
                    reloadGuiaxContribuyente();
                    hideR();
                }
            }, "json");

        } else {
            MsgError({
                title: "Error <small>Pago Incorrecto</small>",
                content: ["Total: <strong>" + formatInputMask(totalDeuda) + "</strong>", "Valor a pagar: <strong>" + formatInputMask(sum) + "</strong>"]
            });
        }
    });

    $("div[inactivar] input[name='costo']").change(function () {
        valor = $(this).getFloat();
        $("div[inactivar] span[total]").html(formatInputMask(valor));
        limpiarTbFormaPago("div[inactivar] table");
    });

    $("div[activar] input[name='reconexion']").change(function () {
        valor = PA.valor + $(this).getFloat();
        $("div[activar] span[total]").html(formatInputMask(valor));
        limpiarTbFormaPago("div[activar] table");
    });

});


function iniciar() {
    //$("input[name='fecha']").val(formatView(moment()));

    $("textarea[name='direccion']").val("");
    $("div[init].inputComponent button[refresh]").click();

    id = $('select[name="idciudad"]').selectpicker("val");
    loadCbo(cboParroquiaxCiudad(id), $('select[name="idparroquia"]'));

    id = $('select[name="idruta"]').selectpicker("val");
    loadCbo(cboSectorRuta(id), $('select[name="idsector"]'));

}

function getInformacion(form) {
//    $(form).validate();
    datos = JSON.parse($(form).serializeObject_KBSG());
    datos.fecha = ($("input[name='fecha']").attr("data-tipo") === "fechaView") ? formatSave(datos.fecha) : datos.fecha;
    datos["idContribuyente"] = $("div[Contribuyente] input[name='id']").val();
    datos.detalle = {
        ME: $(form).find("div[detalle] input[mensualidad]").getFloat(),
        AL: $(form).find("div[detalle] input[alcantarillado]").getFloat(),
        DESC: $(form).find("div[detalle] input[descuento]").getFloat()
    };

    dt = {
        url: getURL($(form).attr("action")),
        dt: {
            accion: "save",
            op: $(form).attr("role"),
            datos: JSON.stringify(datos)
        }
    };
    return dt;
}

function btnEditarGuia(value) {
    return "<button edit type='button' class='btn btn-info btn-sm'><i class='fa fa-external-link-square-alt'></i></button>";
}

window.evtSelect = {
    "click button[select]": function (e, value, row, index) {
        $("#modal-contribuyente").modal("hide");
        $("div[Contribuyente] input[name='cedula']").val(row.cedula + " - " + row.nombre);
        $("div[Contribuyente] input[name='id']").val(row.id);
        $("div[Contribuyente]").data("desc", row.descuento);
        hideR();
        /* Cargar Guias */
        $("#tbDetalleGuia").bootstrapTable("refresh");
    },
    "click button[historial]": function (e, value, row, index) {
        e.preventDefault();
        rowActual=row;
        $("div[new]").removeClass("hidden");
        $("div[new]").fadeIn();
        $("#tbDetalleMensualidad").bootstrapTable("refresh");
    }
};

function limpiarTbFormaPago(table) {
    $(table).bootstrapTable("load", fPago.rows.map(function (row) {
        return {
            idfpago: row.id,
            descripcion: row.descripcion,
            valor: 0,
            detalle: ""
        };
    }));
}
function BtnAccion(value, rowData, index) {
    if (rowData.id > 0) {
        return '<button historial type="button" class="btn btn-success btn-sm"></i>Historial</button>';
    }
}

function Accionuser(value, rowData, index) {
    if(rowData.accion=='UPD')
    {
        return 'Actualización';
    }
    if(rowData.accion=='INS')
    {
        return 'Registro';
    }
    
}


function reloadGuiaxContribuyente() {
    $("#tbDetalleGuia").bootstrapTable("destroy");
    $("#tbDetalleGuia").bootstrapTable(TablePaginationDefault);
}

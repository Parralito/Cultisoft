function defaultBtnAccion(value, rowData, index) {
    return '<div class="btn-group" name="shows">' +
            '<button type="button" class="btn btn-default dropdown-toggle btn-sm"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            ' <i class="fa fa-fw fa-align-justify"></i>' +
            '</button>' +
            '<ul class="dropdown-menu dropdown-menu-left" >' +
            '<li name="edit"><a href="#"> <i class="fa fa-edit"></i> Editar</a></li>' +
            ' <li name="delete" ><a href="#"> <i class="fa fa-trash"></i> Eliminar</a></li>' +
            '</ul>' +
            '</div>';
}

window.defaultEvent = {
    'click li[name="edit"]': function (e, value, row, index) {
        showRegistro();
        edit(row);
    },
    'click li[name="delete"]': function (e, value, row, index) {
        alertEliminarRegistros(row.id);
    }
};

function formatIcon(value) {
    return '<i class="fa fa-' + value + '"></i>';
}

function cMesformat(value, row, index) {
    if (parseInt(value) < 0)
        return 0;
    return value;
}
function getEstado(value) {
    switch (value) {
        case "ACT":
            return "Activo";
            break;
        case "APR":
            return "Aprobado";
            break;
        case "PEN":
            return "Pendiente";
            break;
        case "INA":
            return "Inactivo";
            break;
        case "ANU":
            return "Anulado";
            break;
        case "PAG":
            return "Pagado";
            break;
    }
}
function reducirText(value) {
    return  $.isEmptyObject(value) ? "" : value.substr(0, 30) + "...";
}

function btnSelect(value) {
    return '<button select class="btn btn-success btn-sm" type="button"> Seleccionar <i class="fa fa-arrow-circle-right"></i> </button>';
}

/* Formato Presentacion Fecha */
function defaultFecha(value, rowData, index) {
    return $.isEmptyObject(value) ? "-" : MPrimera(formatView(value));
}

///* Fecha inicio de cobro*/
//function defaultFecha(value, rowData, index) {
//    if(value ===null)
//    {
//        value="2009-01-01";
//    }
//    return MPrimera(formatView(value));
//}

/* Formato Generar N° Filas */
function rowCount(value, row, index) {
    return index + 1;
}

/* Formato para Texto */
function defaultInput(value, rowData, index) {
    return '<input text data-field="' + this.field + '" class="form-control input-sm" type="text" value="' + value + '">';
}

/* Formato para Cajas de Numeros Decimales */
function imask(value, rowData, index) {
    //value = $.isEmptyObject(value) ? 0 : value;
    value = value !== undefined ? value : 0;
    return '<input myDecimal field="' + this.field + '" type="text" class="form-control input-sm" value="' + formatInputMask(value) + '">';
}

window.event_input_default = {
    "change input[text]": function (e, value, row, index) {
        //field = $(this).attr("field");
        field = $(this).attr("data-field");
        row[field] = $(e.target).val();
        table = $(this).closest("table");
        $(table).bootstrapTable('updateRow', {
            index: index,
            row: row
        });
    },
    "change input[myDecimal]": function (e, value, row, index) {
        input = $(e.target);
        field = $(input).attr("field");
        row[field] = $(input).getFloat();//.val();
        table = $(input).closest("table");
        $(table).bootstrapTable('updateRow', {
            index: index,
            row: row
        });
    },
    "click input[text]": function (e, value, row, index) {
        $(this).focus();
    },
    'focus input[myDecimal]': function (e, value, row, index) {
        $(this).inputmask("myDecimal");
        $(this).select();
    }
};

function formatNumPorcent(value, row, index) {
    if ($.isEmptyObject(value)) {
        return "-";
    }
    return formatInputMask(value) + "%";
}
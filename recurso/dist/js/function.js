/* Select Inicializar */
$.fn.initSelect = function () {
    fnc = $(this).attr("dt-fn");
    datos = self[fnc]();
    loadCbo(datos, this);
};

/* */
$.fn.loadSelect = function(rows){
    $(this).html(""); 
    $.each(rows, function (i, row) {
        option = document.createElement("option");
        $(option).attr("value", row.id);
        $(option).html(row.descripcion);
        $(this).append(option);
    });
    $(this).selectpicker("refresh");
};

/* Obtener Fecha*/
$.fn.getFecha = function () {
    tipo = $(this).attr("dt-tipo");
    fecha = fechaMoment($(this).val(), fecha_format.view);
    switch (tipo) {
        case "year":
            fecha = moment({year: fecha.year(), month: 0, day: 0});
            break;
        case "month":
            fecha = moment({year: fecha.year(), month: fecha.month(), day: 0});
            break;
    }
    return formatSave(fecha);
    //return fecha;
};

/* Fecha Utilidades */
function fechaMoment(data, format) {
    return moment(data, format);
}

/* DatePicker Inicializar */
$.fn.initDate = function (_defaultF = "2009-01-01", bandera = true) {
    dt = $(this).attr("dt-tipo");
    _default = formartMoment(_defaultF, fecha_format.save);
    init_fecha = {
        autoclose: true,
        orientation: "bottom auto",
        language: "es"
    };
    switch (dt) {
        case "year":
            $.extend(init_fecha, {
                minViewMode: 2,
                format: 'yyyy'
            });
            break;
        case "month":
            $.extend(init_fecha, {
                minViewMode: 1,
                format: 'MM, yyyy'
            });
            break;
        case "day":
            $.extend(init_fecha, {
                todayBtn: true,
                todayHighlight: true,
                format: 'MM dd, yyyy'
            });
            break;
    }
    $(this).datepicker(init_fecha);
    $(this).datepicker("setStartDate", _default.toDate());
    if (bandera)
        $(this).datepicker("setEndDate", moment().add(1, 'd').toDate());
};

/* Formatos fechas para inicializar DATEPICKER */
function getParamsFecha(dt) {
//    _default = "2009-01-01";
//    start_default = formatView()


    init_fecha = {
        autoclose: true,
        orientation: "bottom auto",
        startDate: "Enero 1, 2009",
        language: "es"
    };
    switch (dt) {
        case "year":
            return $.extend({}, init_fecha, {
                minViewMode: 2,
                format: 'yyyy'
            });
            break;
        case "month":
            return $.extend({}, init_fecha, {
                minViewMode: 1,
                format: 'MM, yyyy'
            });
            break;
        case "day":
            return $.extend({}, init_fecha, {
                todayBtn: true,
                todayHighlight: true,
                format: 'MM dd, yyyy'
            });
            break;
    }
}

/* Function en fn */
$.fn.getFloat = function () {
    return parseFloat($(this).val().toString().replace(/[^\d\.\-]/g, ""));// $(component).val();
};

$.fn.setFloat = function (value) {
    $(this).inputmask('remove');
    $(this).val(value);
    $(this).inputmask("myDecimal");
};
$.fn.setPorcent = function (value) {
    $(this).inputmask('remove');
    $(this).val(value);
    $(this).inputmask("myPorcentaje");
};

$.fn.clear = function () {
    $(this).removeData("id");
    $(this).find("select").selectpicker("val", -1);
    $(this).find("input:not([data-tipo='myDecimal'])").val("");
    $(this).find("input[data-tipo='myDecimal']").setFloat(0);
    $(this).find("input[data-tipo='myPorcentaje']").setPorcent(0);

};

$.fn.edit = function (datos) {
    claves = JSON_Clave(datos);
    $(this).data("id", datos.id);
    $.each($(this).find("[name]"), function (i, component) {
        name = $(component).attr("name");
        if ($.inArray(name, claves)) {
            tagName = $(component).prop("tagName");
            switch (tagName) {
                case "SELECT":
                    $(component).selectpicker("val", datos[name]);
                    $(component).change();
                    break;
                case "TEXTAREA":
                    val = $(component).val(datos[name]);
                    break;
                case "INPUT":
                    tipo = $(component).attr("data-tipo");
                    switch (tipo) {
                        case "myDecimal":
                            $(component).setFloat(datos[name]);
                            break;
                        case "myPorcentaje":
                            $(component).setFloat(datos[name]);
                            break;
                        case "fechaView":
                            $(component).val(formatView(datos[name]));
                            break;
                        case "fecha":
                            $(component).datepicker("update", fechaMoment(datos[name]).toDate());
                            break;
                        case "checkbox":
                            $(component).prop('checked', parseInt(datos[name]));
                            //$(component).change();
                            break;
                        default:
                            $(component).val(datos[name]);
                            break;
                    }
                    break;
            }

        }
    });
};

$.fn.serializeObject_KBSG = function (bandera = true) {
    value = {};
    //components = $(this).find("[name]");
    components = $(this).find("[name]:not([exclud])");
    value["id"] = ($.isEmptyObject($(this).data("id"))) ? 0 : $(this).data("id");
    $.each(components, function (i, component) {
        tagName = $(component).prop("tagName");
        name = $(component).attr("name");
        val = "";
        switch (tagName) {
            case "SELECT":
                val = $(component).selectpicker("val");
                break;
            case "TEXTAREA":
                val = $(component).val();
                break;
            case "INPUT":
                tipo = $(component).attr("data-tipo");
                switch (tipo) {
                    case "myDecimal":
                        val = $(component).getFloat();
                        break;
                    case "fechaView": 
                        val = formatSave($(component).val());
                        break;
                    case "fecha":
                        val = $(component).getFecha();
                        break;
                    case "checkbox":
                        //val = ($(component).val() === "on");
                        val = $(component).prop("checked");
                        break;
                    default:
                        val = $(component).val();
                        break;
                }
                break;
        }
        value[name] = val;
    });
    //console.log(value);
    return (bandera)? JSON.stringify(value): value;
};

$.fn.validate = function () {
    bandera = true;
    $.each($(this).find("[required]"), function (i, input) {
        if (bandera) {
            switch ($(input).prop("tagName")) {
                case "SELECT":
                    bandera = $(input).selectpicker("val") !== null;
                    break;
                case "TEXTAREA":
                    bandera = $(input).val() !== "";
                    break;
                case "INPUT":
                    tipo = $(input).attr("data-tipo");
                    switch (tipo) {
                        case "myDecimal":
                        case "mymyPorcentaje":
                            val = $(input).getFloat();
                            bandera = val > 0;
                            break;
                        case "fecha":
                            bandera = $(input).val() !== "";
                            break;
                        default:
                            bandera = $(input).val() !== "";
                            break;
                    }
                    break;
            }
        }
    });
    return bandera;
};

/* FIN */

/* Function Utiles */

/* Dar Formato a  Decimal (Inputmask)*/
function formatInputMask(value) {
    return Inputmask.format(value, "myDecimal");
}

/* Parse Float */
function convertFloat(valor) {
    value = parseFloat(valor.toString().replace(/[^\d\.\-]/g, ""));
    return value;
}


/* Array Claves JSON */
function JSON_Clave(obj) {
    claves = [];
    for (var clave in obj) {
        claves.push(clave);
    }
    return claves;
}

/* Cargar Datos a un select */
function loadCbo(data, select) {
    $(select).html("");
    $.each(data.rows, function (i, row) {
        option = document.createElement("option");
        $(option).attr("value", row.id);
        $(option).html(row.descripcion);
        $(select).append(option);
    });

    $(select).selectpicker("refresh");
}

/* Obtener un array JSON */
function getJson(params) {
    result = {};
    $.ajax({
        url: params.url,
        async: false,
        type: 'POST',
        dataType: 'json',
        data: params.data,
        success: function (response) {
            result = response;
        }
    });
    return result;
}

/* Envio de datos para guardar */
function saveGlobal(datos) {
    result = null;
    $.ajax({
        url: datos.url,
        beforeSend: function () {
            waitingDialog.show('Procesando solicitud...');
        },
        complete: function () {
            waitingDialog.hide();
        },
        cache: false,
        type: 'POST',
        async: false,
        dataType: 'json',
        data: datos.dt,
        success: function (response) {
            claves = JSON_Clave(response);
            if($.inArray("msg", claves) !== -1){
                MsgError({
                    title: "Operación fallida",
                    content: response.msg
                });
            }
            result = response;
        }
    });
    return result;
}


/* Function Mostrar Registro */
function showRegistro() {
    $("div[Listado]").fadeOut();
    $("div[Listado]").addClass("hidden");

    $("div[Registro]").fadeIn("slow");
    $("div[Registro]").removeClass("hidden");
    $("div[Registro] .selectpicker").selectpicker();
    $("div[tipo] button[refresh]").click();

    $("input[data-tipo='myDecimal']").inputmask("myDecimal");
    $("input[data-tipo='myPorcentaje']").inputmask("myPorcentaje");

}
/* Function Ocultar Registro */
function hideRegistro() {
    $("div[Registro]").fadeOut();
    $("div[Registro]").addClass("hidden");

    $("div[Listado]").fadeIn("slow");
    $("div[Listado] table").bootstrapTable("refresh");
    $("div[Listado] table").bootstrapTable("resetView");
    $("div[Listado]").removeClass("hidden");
    $("div[Registro] form").removeData("id");
}

/* Function Fechas */
function formatView(data) {
    fecha = moment(data, "YYYY-MM-DD HH:mm:ss");
    fechafor = fecha.format('MMMM D, YYYY');
    return MPrimera(fechafor);
}
function formatMonth(data) {
    fecha = moment(data, "YYYY-MM-DD HH:mm:ss");
    fechafor = fecha.format('MMMM, YYYY');
    return MPrimera(fechafor);
}
function formatViewComp(data) {
    fecha = moment(data, "YYYY-MM-DD HH:mm:ss");
    fechafor = fecha.format('MMMM D, YYYY - HH:mm:ss');
    return MPrimera(fechafor);
}
function roundNumber(num, scale) {
    if (!("" + num).includes("e")) {
        return +(Math.round(num + "e+" + scale) + "e-" + scale);
    } else {
        var arr = ("" + num).split("e");
        var sig = ""
        if (+arr[1] + scale > 0) {
            sig = "+";
        }
        return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
    }
}
function Asigna(array)
{
    $.each(array, function (index, arr)
    {
        if (arr.type == "label")
        {
            valor = formatInputMask(convertFloat(arr.valor));
            $("" + arr.type + "[name='" + arr.name + "']").html(valor);
        } else if (arr.type == "input")
        {
            valor = formatInputMask(convertFloat(arr.valor));
            $("" + arr.type + "[name='" + arr.name + "']").val(valor);
        } else if (arr.type == "date")
        {
            valor = MPrimera(arr.valor.format(fecha_format.view));
            $("input[name='" + arr.name + "']").val(valor);
        } else if (arr.type == "asign")
        {
            $("input[name='" + arr.name + "']").val(arr.valor);
        }
    });
}
function formartMoment(date, format) {
    return moment(date, format);
}

function fechaViewFormat(date, format) {
    return moment(date, fecha_format.save).format(format);
}



function DiasdelMes(mes, year) {
    return new Date(year || new Date().getFullYear(), mes, 0).getDate();
}
/*Convierte la primera letra en mayúscula*/
function MPrimera(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function Ndecimal(val, num)
{
    return val.toFixed(num);
}
function formatSave(data) {
    fecha = moment(data, 'MMMM D, YYYY');
    return fecha.format("YYYY-MM-DD HH:mm:ss");
}

function formatIni(data) {
    fecha = moment(data, "YYYY-MM-DD HH:mm:ss");
    return fecha.format("YYYY-MM");
}
/*function defaultFecha(value, rowData, index) {
 return formatView(value).toUpperCase();
 }*/


function initialComponents() {
    initFecha();
}

$.fn.search = function (clave, val) {
    value = null;
    $(this).each(function (i, row) {
        if (row[clave] === val) {
            value = {
                index: i,
                rw: row
            };
            return;
        }
    });
    return value;
};

function recorrerModulos(rows) {

    if ($.isArray(rows)) {
        op = '';
        $.each(rows, function (i, row) {
            clave = JSON_Clave(row);
            if ($.inArray("sub", clave) !== -1) {
                if ($.isArray(row.sub)) {
                    op += '<li class="treeview">' +
                            '<a href="#">' +
                            '<i class="fa fa-' + row.icon + '"></i> <span>' + row.descripcion + '</span>' +
                            '<span class="pull-right-container"> <i class="fa fa-angle-left pull-right loco"></i> </span>' +
                            '</a>' +
                            '<ul class="treeview-menu">' + recorrerModulos(row.sub) + '</ul>' +
                            '</li>';
                }
            } else {
                op += '<li><a href="' + row.ruta + '"><i class="fa fa-' + row.icon + ' fa-fw"></i> ' + row.descripcion + '</a></li>';
            }
        });
        return op;
    } else {
        return '<li><a href="' + rows.ruta + '"><i class="fa fa-' + rows.icon + ' fa-fw"></i> ' + rows.descripcion + '</a></li>';
    }
}

function genMenu() {
    dt = {
        url: getURL("_sistema"),
        data: {
            accion: "list",
            op: "Menu"
        }
    };
    return recorrerModulos(getJson(dt));
}

//function MsgError(data) {
//    $.alert({
//        title: data.title,
////        backgroundDismiss: true,
//        icon: 'fa fa-exclamation-triangle ',
//        type: 'orange',
//        content: $.isArray(data.content) ? data.content.join("<br>") : data.content
//    });
//}

// Array, Text
function MsgError(data) {
    $.alert({
        title: data.title,
        backgroundDismiss: true,
        icon: 'fa fa-exclamation-triangle',
        type: 'orange',
        content: $.isArray(data.content) ? data.content.join("<br>") : data.content
    });
}

function MsgSuccess(data) {
    $.alert({
        title: data.title,
        backgroundDismiss: true,
        icon: 'fa fa-check-square',
        type: 'green',
        content: $.isArray(data.content) ? data.content.join("<br>") : data.content
    });
}

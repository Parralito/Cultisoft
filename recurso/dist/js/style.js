//var selections = [];
moment.locale("es");

/* Formato en fechas*/
var fecha_format = {
    year: "YYYY",
    month: "MM, YYYY",
    day: "MM dd, yyyy",
    view: "MMMM D, YYYY",
    save: "YYYY-MM-DD HH:mm:ss",
    viewMonth: "MMMM, YYYY"
};

Inputmask.extendAliases({
    'myDecimal': {
        alias: "numeric",
        groupSeparator: ',',
        autoGroup: true,
        digits: 2,
        min: 0,
        digitsOptional: false,
        placeholder: '0'
    },
    'myPorcentaje': {
        alias: "numeric",
        groupSeparator: ',',
        autoGroup: true,
        digits: 2,
        min: 0,
        max: 100,
        digitsOptional: false,
        placeholder: '0'
    },
    'myPorcentajeCobranza': {
        alias: "numeric",
        groupSeparator: ',',
        autoGroup: true,
        digits: 2,
        min: 0,
        max: 25,
        digitsOptional: false,
        placeholder: '0'
    }
});

myDecimalMinMax = {
    alias: "numeric",
    groupSeparator: ',',
    autoGroup: true,
    digits: 2,
    min: 0,
    digitsOptional: false,
    placeholder: '0'
};

var TableSearchDefault = {
    search: true,
    showRefresh: true,
    cache: false,
    height: 300
};

var TablePaginationDefault = {
    //height: 400,
    pageSize: 5,
    search: true,
    pageList: [5, 10, 15, 20],
    cache: false,
    pagination: true,
    searchTimeOut: 250,
    showRefresh: true,
    sidePagination: "server",
    searchOnEnterKey: true
};
var TablePagination = {
    //height: 400,
    pageSize: 5,
    pageList: [5, 10, 15, 20],
    cache: false,
    pagination: true,
    searchTimeOut: 250,
    showRefresh: true,
    sidePagination: "server",
    searchOnEnterKey: true
};


function alertEliminarRegistros(row = selections) {
    values = !$.isArray(row) ? [row] : row;
    bandera = $.isArray(row);
    $.confirm({
        theme: "modern",
        escapeKey: "cancelAction",
        title: bandera ? 'Eliminar Registros?' : 'Eliminar Registro?',
        content: 'Estás seguro de continuar?',
        autoClose: 'cancelAction|8000',
        buttons: {
            deleteUser: {
                text: bandera ? 'Eliminar Registros' : 'Eliminar Registro',
                keys: ['enter'],
                action: function () {
                    deletes(values);
                    //$("div[Listado] table").bootstrapTable("refresh");
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

function deletes(values) {
    $.ajax({
        url: url_Local,
        type: "POST",
        async: false,
        data: {
            accion: "delete",
            op: op,
            ids: values
        }
    });
    selections = [];
    $("div[Listado] table").bootstrapTable("refresh");
}

$(function () {

    dt = getJson({
        url: getURL("_sistema"),
        data: {
            accion: "get",
            op: "FECHA"
        }
    });
    $("span[fecha]").html(formatView(dt.fecha));

    $("#cerrarSesion").click(function (e) {
        e.preventDefault();
        $.post(getURL("_configuracion"), {accion: "close"}, function () {
            location.href = "login.php";
        });
    });


    $("span[refreshMenu]").click(function () {
        $("ul.sidebar-menu li:not(.header)").remove();
        $("ul.sidebar-menu").append(genMenu());
    });

    $("span[refreshMenu]").click();

    /* Menú */

    $(document).on("click", ".sidebar a", function (e) {
        e.preventDefault();
        url = $(this).attr("href");
        if (url !== "#") {
            $("#containPages").load(url);
            // Estilo
            $(".sidebar li").removeClass("active");
            $(this).closest("li").addClass("active");
        }
    });



    $(document).on("keypress", "input[type='number']", function (e) {
        //e.preventDefault();
        var charCode = window.Event ? e.which : e.keyCode;
        return (charCode === 0);
    });




    $(document).on('focus', 'input[data-tipo="myDecimalMinMax"]', function (e) {
        max = $(this).attr("d-max");
        $(this).inputmask($.extend({}, myDecimalMinMax, {max: max}));
        $(this).select();
    });

    /**/
    $(document).on("keypress", ".solo-numero", function (e) {
        var charCode = window.Event ? e.which : e.keyCode;
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    });

    /* Boton Eliminar */

    $(document).on("click", "button[name='btn_del']", function (e) {
        console.log(selections);
        if (selections.length > 0) {
            alertEliminarRegistros();
        }
    });

    /* Seleccionar diferentes registros*/
    $(document).on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function (e, rows) {
        var ids = $.map(!$.isArray(rows) ? [rows] : rows, row => row.id);
        if ($.inArray(e.type, ['check', 'check-all']) > -1) {
            //Add
            $.each(ids, function (i, id) {
                if ($.inArray(id, selections) === -1)
                    selections.push(id);
            });

        } else {
            //Delete
            $.each(ids, function (i, id) {
                if ($.inArray(id, selections) > -1) {
                    selections.splice($.inArray(id, selections), 1);
                }
            });
        }
    });



    $(document).on("click", "input[data-tipo='myPorcentaje'], input[data-tipo='myDecimal']", function (e) {
        $(this).select();
    });

    $(document).on("click", "button[name='btn_add']", function (e) {
        showRegistro();
        if (typeof window.initRegistro === 'function') {
            initRegistro();
        }
    });

    $(document).on("click", "form[modal-save] button[type='reset']", function (e) {
        $(this).closest(".modal").modal("hide");
    });
    $(document).on("click", "form[save] button[type='reset'], form[save_fn] button[type='reset']", function (e) {
        form = $(this).closest("form");
        $(form).trigger("reset");
        $.each($(form).find('select'), function (i, select) {
            $(select).selectpicker('refresh');
            $(select).change();
        });

        hideRegistro();
    });

    $(document).on("submit", "form[save]", function (e) {
        e.preventDefault();
        datos = {
            url: getURL($(this).attr("action")),
            dt: {
                accion: "save",
                op: $(this).attr("role"),
                datos: $(this).serializeObject_KBSG()
            }
        };
        saveGlobal(datos);
        $(this).trigger("reset");
        hideRegistro();
    });
    $(document).on("submit", "form[save_fn]", function (e) {
        e.preventDefault();
        datos = getDatos(this);
        saveGlobal(datos);
        $(this).trigger("reset");
        hideRegistro();
    });
    $(document).on("submit", "form[modal-save]", function (e) {
        e.preventDefault();
        datos = {
            url: getURL($(this).attr("action")),
            dt: {
                accion: "save",
                op: $(this).attr("role"),
                datos: $(this).serializeObject_KBSG()
            }
        };
        saveGlobal(datos);
        $(this).closest(".modal").modal("hide");
    });

    var dropdownMenu;
    $(window).on('show.bs.dropdown', function (e) {
        if (!$.isEmptyObject($(e.target).attr("name"))) {
            dropdownMenu = $(e.target).find('.dropdown-menu');
            $('body').append(dropdownMenu.detach());
            var eOffset = $(e.target).offset();
            dropdownMenu.css({
                'display': 'block',
                'top': eOffset.top + $(e.target).outerHeight(),
                'left': eOffset.left + $(e.target).outerWidth() - $(dropdownMenu).width()
            });
        }
    });

    $(window).on('hide.bs.dropdown', function (e) {
        if (!$.isEmptyObject(dropdownMenu)) {
            $(e.target).append(dropdownMenu.detach());
            dropdownMenu.hide();
            dropdownMenu = null;
        }
    });

    /*$(document).on("click", "div[tipo] button[refresh]", function (e) {
     div = $(this).closest("div[tipo]");
     fnc = $(div).attr("data-fn");
     select = $(div).find("select");
     datos = self[fnc]();
     loadCbo(datos, select);
     });*/
    $(document).on("click", "div.inputComponent button[refresh]", function (e) {

        div = $(this).closest("div.inputComponent");
        fnc = $(div).attr("dt-fn");
        select = $(div).find("select");
        datos = self[fnc]();
        loadCbo(datos, select);
    });
}
);

function deleteIndividual(tableSelect) {
    state = $(tableSelect).bootstrapTable("getSelections").map(row => row.state);
    $(tableSelect).bootstrapTable("remove", {field: 'state', values: state});
}

function openWindowWithPost(url, data) {
    var form = document.createElement("form");
    form.target = "_blank";
    form.method = "POST";
    form.action = url;
    form.style.display = "none";


    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "datos";
    input.value = JSON.stringify(data);
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function initModalNew(dataUrl) {
    html = "";
    $.ajax({
        url: dataUrl,
        async: false,
        dataType: 'html',
        success: function (html2) {
            div = $(html2).find("div[Registro]");
            $(div).removeClass("hidden");
            $(div).removeAttr("id");
            $(div).find("form").removeAttr("save");
            $(div).find("form").attr("modal-save", "");
            $(div).find('.selectpicker').selectpicker();
            html = div;
        }
    });
    return html;
}

function initFecha() {
    $.each($('input[data-tipo="fecha"]'), function (i, input) {
        config = getParamsFecha($(input).attr("dt-tipo"));
        console.log(config);
        $(input).datepicker(config);
        //$(input).datepicker('update', $(input).getFecha());
    });
}

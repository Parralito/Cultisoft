function initSelect() {
    $("select[data-fn]").each(function (i, select) {
        fnc = $(select).attr("data-fn");
        datos = self[fnc]();
        loadCbo(datos, select);
    });

}

function cboTipoPermiso(){
    data = {
        op: "TIPOPERMISO",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_sadministrativo")
    });
}

function cboTipoIdentificacion() {
    data = {
        op: "TipoIdentificacion",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_")
    });
}

function cboRuta() {
    data = {
        op: "ruta",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_localizacion")
    });
}

function cboFPago() {
    data = {
        op: "fpago",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_tesoreria")
    });
}
function cboCiudad() {
    data = {
        op: "ciudad",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_localizacion")
    });
}

function cboModulo() {
    data = {
        op: "modulo",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_sistema")
    });
}
function cboRol() {
    data = {
        op: "rol",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_configuracion")
    });
}

function cboCategoria() {
    data = {
        op: "categoria",
        accion: "list"
    };
    return getJson({
        data: data,
        url: getURL("_guia")
    });
}

function cboSectorRuta(ruta){
    data = {
        op: "sectorRuta",
        accion: "list",
        idRuta: ruta
    };
    return getJson({
        data: data,
        url: getURL("_localizacion")
    });
}
function cboParroquiaxCiudad(ciudad){
    data = {
        op: "parroquiaCiudad",
        accion: "list",
        idCiudad: ciudad
    };
    return getJson({
        data: data,
        url: getURL("_localizacion")
    });
}

/* Aplicar el TRUE check rows  */
function responseHandlerSelect(res) {
    $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.id, selections) !== -1;
    });
    return res;
}

function getURL(url) {
    switch (url) {
        case "_localizacion":
            return "Servidor/sLocalizacion.php";
            break;
        case "_contribuyente":
            return "Servidor/sContribuyente.php";
            break;
        case "_guia":
            return "Servidor/sGuia.php";
            break;
        case "_sistema":
            return "Servidor/sSistema.php";
            break;
        case "_configuracion":
            return "Servidor/sConfiguracion.php";
        case "_tesoreria":
            return "Servidor/sTesoreria.php";
            break;
        case "_financiero":
            return "Servidor/sFinanciero.php";
            break;
        case "_recurso":
            return "Servidor/sRecurso.php";
            break;
        case "_sadministrativo":
            return "Servidor/sServicioAdministrativo.php";
            break;
        case "_reporte":
            return "Servidor/sReportes.php";
            break;
    }
}

function loadPermisoContribuyente(params){
    data = $.extend({}, {
        op: "PERMISOCONTRIBUYENTE",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sadministrativo")
    };
    params.success(getJson(json_data));
}
function tbDetalleGuiasxContribuyenteTodas(params) {
    data = $.extend({}, {
        op: "DETALLEGUIASXCONTRIBUYENTETODAS",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
}

function tbTipoPermiso(params) {
    data = $.extend({}, {
        op: "TIPOPERMISO",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sadministrativo")
    };
    params.success(getJson(json_data));
}
function tbGuia(params) {
    data = $.extend({}, {
        op: "GUIA",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
}
function tbRecurso() {
    data = {
        op: "JUICIOCOACTIVA",
        accion: "get"
    };
    return getJson({
        data: data,
        url: getURL("_recurso")
    });
}
function tbDetalleGuiaCoactiva(Guia) {
    data = {
        op: "DETALLEGUIACOACTIVA",
        accion: "list",
        idGuia: Guia
    };
    return getJson({
        data: data,
        url: getURL("_guia")
    });
}
function tbDetallePermisos(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "DETALLEPERMISOS",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sadministrativo")
    };
    params.success(getJson(json_data));
}
function tbDetalleCambioTub(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "DETALLECAMBIOTUB",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sadministrativo")
    };
    params.success(getJson(json_data));
}
function tbDetalleDocVarios(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "DETALLEDOCVARIOS",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sadministrativo")
    };
    params.success(getJson(json_data));
}
function tbDetalleCertificados(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "DETALLECERTIFICADOS",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sadministrativo")
    };
    params.success(getJson(json_data));
}
function tbGuiasxContribuyenteCoactiva(params) {
    
     data = $.extend({}, {
        op: "GUIASXCONTRIBUYENTECOACTIVA",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
         url: getURL("_guia")
    };
    params.success(getJson(json_data));    
//    data = {
//        op: "GUIASXCONTRIBUYENTECOACTIVA",
//        accion: "list",
//        idContribuyente: Guia
//    };
//    return getJson({
//        data: data,
//        url: getURL("_guia")
//    });
}
function tbGuiasxContribuyente(Contribuyente) {
    data = {
        op: "GUIASxCONTRIBUYENTE",
        accion: "list",
        idContribuyente: Contribuyente
    };
    return getJson({
        data: data,
        url: getURL("_guia")
    });
}

function tbGuiasxContribuyenteCoactivaReg(params) {
    
     data = $.extend({}, {
        op: "GUIASXCONTRIBUYENTECOACTIVAREG",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
         url: getURL("_guia")
    };
    params.success(getJson(json_data));
}
function tbGuiasxContribuyenteCoactivaMig(params) {
    
     data = $.extend({}, {
        op: "GUIASXCONTRIBUYENTECOACTIVAMIG",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
         url: getURL("_guia")
    };
    params.success(getJson(json_data));
}

function tbDetAbonosJuicioCoactiva(idjuicio) {
    data = {
        op: "DETALLE.ABONOS.JUICIO.COACTIVA",
        accion: "list",
        idjuicio: idjuicio
    };
    return getJson({
        data: data,
        url: getURL("_financiero")
    });
}

function tbDetalleGuiasxContribuyente(params) {
    data = $.extend({}, {
        op: "DETALLEGUIASXCONTRIBUYENTE",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
}
function tbDetalleGuiasxContribuyenteG(params) {
    data = $.extend({}, {
        op: "DETALLEGUIASXCONTRIBUYENTEG",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
}
function tbDetalleGuiasxContribuyenteJC(params) {
    data = $.extend({}, {
        op: "DetalleGUIASxCONTRIBUYENTEJC",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
}

function tbDetalleAuditContrib(params) {
    data = $.extend({}, {
        op: "AUDITCONTRIB",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_contribuyente")
    };
    params.success(getJson(json_data));
}

function tbDetalleAudit(params) {
    data = $.extend({}, {
        op: "AUDITGUIA",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
}

function tbDetalleGuiasHabFechaDownxContribuyente(params) {
//    data = {
//        op: "GUIASXCONTRIBUYENTE_HABFECHADOWN",
//        accion: "list",
//        idContribuyente: Contribuyente
//    };
//    return getJson({
//        data: data,
//        url: getURL("_guia")
//    });
    data = $.extend({}, {
        op: "GUIASXCONTRIBUYENTE_HABFECHADOWN",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    params.success(getJson(json_data));
    
}

function tbCiudad(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "ciudad",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_localizacion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbRuta(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "ruta",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_localizacion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbSector(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "sector",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_localizacion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbServicioAdministrativo(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "servicioadministrativo",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_tesoreria")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbParametro(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "parametro",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_configuracion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbUsuarioRec(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "usuariorec",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_configuracion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbUsuario(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "usuario",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_configuracion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbParroquia(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "parroquia",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_localizacion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbTarifario(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "tarifario",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_tesoreria")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbUser(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "contribuyente",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_contribuyente")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbCategoria(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "categoria",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_guia")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbModulo(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "modulo",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sistema")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbRol(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "rol",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_configuracion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbPermisoRol(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "permiso",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_configuracion")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}

function tbSubModulo(params) {
    // Agrega mas elementos al JSON
    data = $.extend({}, {
        op: "submodulo",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_sistema")
    };
    // GetJson devuelve un [] de JSON
    // params.success => Metodo del TableBootstrap
    params.success(getJson(json_data));
}
function tbDetMensualidad(params) {
    data = $.extend({}, {
        op: "DETALLE.PM.RI.GUIA",
        accion: "list"
    }, params.data);

    json_data = {
        data: data,
        url: getURL("_financiero")
    };
    params.success(getJson(json_data));
}
//function tbDetMensualidad(params) {
//    data = $.extend({}, {
//        op: "DETALLE.PM.GUIA",
//        accion: "list"
//    }, params.data);
//
//    json_data = {
//        data: data,
//        url: getURL("_financiero")
//    };
//    params.success(getJson(json_data));
//}

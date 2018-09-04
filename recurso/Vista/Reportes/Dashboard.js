$(function () {
    dt = getJson({
        url: getURL("_recurso"),
        data: {
            op: "DASH",
            accion: "get"
        }
    });
    /* Asignar */
    $("span[contribuyente]").html(dt.contribuyente);
    $("span[contribuyente_jc]").html(dt.contribuyente_jc);
    $("span[guias]").html(dt.guias);
    $("span[jc]").html(dt.jc);
    $("span[jc_mes_actual]").html(dt.jc_mes_actual);
    $("span[sol_pconexion]").html(dt.sol_pconexion);
    
    
});
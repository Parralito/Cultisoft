$(function () {
    dt = getJson({
        url: getURL("_sadministrativo"),
        data: {
            op: "REPORTEGENERAL",
            accion: "list",
            inicio: formatSave(moment()),
            fin: formatSave(moment())
        }
    });

    $("#valores").bootstrapTable();
    $("#valores").bootstrapTable("load", dt);
    sum = dt.reduce((a, b) => a + convertFloat(b.valor), 0);
    $("span[total]").html(formatInputMask(sum));
});

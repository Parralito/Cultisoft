table = $("div[Listado] table");
selections = [];

$(function () {
//    initialComponents();    
    //$("div[Listado] table").bootstrapTable(TablePaginationDefault);    
    $("select[name='documentos']").selectpicker();
    $("div[Listado] table").bootstrapTable(TablePaginationDefault);
});
function btnAccion(value) {
      return '<button reimprimir class="btn btn-success btn-sm"> <i class="fa fa-print" ></i> </button>';
}
// Eventos---------------------------------------------------------------------------------------
window.evtSelect = {
    "click button[reimprimir]": function (e, value, row, index) {
            form = document.createElement("form");
            form.target = "_blank";
            form.method = "POST";
            form.action = "MVC/Vista/ServicioAdministrativo/print/CertificadoNoAdeudar.php"; //"Servidor/sFinanciero.php";
            form.style.display = "none";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "datos";
            input.value = JSON.stringify({
                id: row.id
            });
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
    }
};

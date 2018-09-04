tipos = {
    rows: [
        {id: "RC", descripcion: "Contribuyente - Registro Convenios"},
        {id: "CV", descripcion: "Contribuyente - Convenios Vigentes"},
        {id: "HC", descripcion: "Contribuyente - Habilitados Convenios"}
    ]
};
$(function () {
    $("select[name='tipo']").selectpicker();
    
    $("select[name='tipo']").change(function(){
       if($(this).selectpicker("val") === "RC"){
           $("div[fecha]").show();
       }else{
           $("div[fecha]").hide();
       }
    });
    
    loadCbo(tipos, "select[name='tipo']");

    $("#generarReporte").click(function () {

        form = document.createElement("form");

        form.target = "_blank";
        form.method = "POST";
        form.action = getURL("_reporte");
        form.style.display = "none";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "datos";
        dt = {
            op: "COACTIVA",
            doc: $("select[name='tipo']").selectpicker("val"),
            fechas: $('#daterange-btn span').data("fecha")
        };
        input.value = JSON.stringify(dt);
        form.appendChild(input);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimo 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimo 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(MPrimera(start.format('MMMM D, YYYY')) + ' - ' + MPrimera(end.format('MMMM D, YYYY')));
                $('#daterange-btn span').data("fecha", {
                    inicio: start.format(fecha_format.save),
                    fin: end.format(fecha_format.save)
                });
            }
    );
});
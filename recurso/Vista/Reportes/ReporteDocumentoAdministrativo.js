documentos = {
    rows: [
        {id: "CA", descripcion: "Certificado de No Adeudar"},
        {id: "PM", descripcion: "Pago Mensual - Directo"},
        {id: "PC", descripcion: "Permiso Conexión"},
        //{id: "CT", descripcion: "Cambio de Tubería"},
        {id: "AJ", descripcion: "Convenios Abonos"},
        //{id: "RI", descripcion: "Reimpresión"},
        {id: "RJ", descripcion: "Registro Juicio Cobranza"},
        {id: "DV", descripcion: "Documentos Varios"}
        //{id: "IAG", descripcion: "Activación e Inactivación Guía"}
    ]
};
$(function () {
    $("select[name='documentos']").selectpicker();
    loadCbo(documentos, "select[name='documentos']");

    $("#generarReporte").click(function () {
        if ($.isEmptyObject($('#daterange-btn span').data("fecha"))) {
            return;
        }

        form = document.createElement("form");

        form.target = "_blank";
        form.method = "POST";
        form.action = getURL("_reporte");
        form.style.display = "none";

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "datos";
        dt = {
            op: "reporte.individual",
            doc: $("select[name='documentos']").selectpicker("val"),
            fechas: $('#daterange-btn span').data("fecha")
        };
        input.value = JSON.stringify(dt);
//        input.value = JSON.stringify($.extend({}, dt, {
//            fechas: $('#daterange-btn span').data("fecha")
//        }));
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    $('#daterange-btn').daterangepicker({
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
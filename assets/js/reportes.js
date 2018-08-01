//Date range picker
    /* $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' }) */ 

// Para saber si viene variable localStorage

if(localStorage.getItem("capturarRango") != null) {

  $('#daterange-btn span').html(localStorage.getItem("capturarRango"))


} else {

  $('#daterange-btn span').html('<i class="fa fa-calendar"></i> Rango de fecha')
          
}


    //Rango de fechas
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 Días' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {

        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

        var fechaInicial = start.format('YYYY-MM-DD')
        var fechaFinal = end.format('YYYY-MM-DD')

        var capturarRango =  $('#daterange-btn span').html()

        localStorage.setItem("capturarRango", capturarRango)

        window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal

      }

    )

    // cancelar Rango de fechas

$(document).on('click', ".daterangepicker.opensleft .range_inputs .cancelBtn", function(){

    localStorage.removeItem("capturarRango");
    localStorage.clear();
    window.location = "ventas";


})

// Capturar Hoy

$('.daterangepicker.opensleft .ranges li').on("click", function() {


  var textoHoy = $(this).attr("data-range-key")

  if(textoHoy == "Hoy") {

      var d = new Date(); 
      var dia = d.getDate();
      var mes = d.getMonth() + 1;
      var year = d.getFullYear();

      var fechaInicial = year+"-"+mes+"-"+dia;
      var fechaFinal = year+"-"+mes+"-"+dia;

    if(mes < 10){

      var fechaInicial = year+"-0"+mes+"-"+dia;

      var fechaFinal = year+"-0"+mes+"-"+dia;

    }else if(dia < 10){

      var fechaInicial = year+"-"+mes+"-0"+dia;

      var fechaFinal = year+"-"+mes+"-0"+dia;


    }else if(mes < 10 && dia < 10){

      var fechaInicial = year+"-0"+mes+"-0"+dia;

      var fechaFinal = year+"-0"+mes+"-0"+dia;

    }else{

      var fechaInicial = year+"-"+mes+"-"+dia;

      var fechaFinal = year+"-"+mes+"-"+dia;

    }

      localStorage.setItem("capturarRango", "Hoy")
      window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal

  }


})

/* Página de reportes */ 

  if(localStorage.getItem("capturarRangoReportes") != null) {

  $('#daterange-btnreportes span').html(localStorage.getItem("capturarRangoReportes"))


} else {

  $('#daterange-btnreportes span').html('<i class="fa fa-calendar"></i> Rango de fecha')
          
}


//Rango de fechas
    $('#daterange-btnreportes').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 Días' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {

        $('#daterange-btnreportes span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

        var fechaInicial = start.format('YYYY-MM-DD')
        var fechaFinal = end.format('YYYY-MM-DD')

        var capturarRangoReportes =  $('#daterange-btnreportes span').html()

        localStorage.setItem("capturarRango", capturarRangoReportes)

        window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal

      }

    )

 $(document).on('click', ".daterangepicker.opensright .range_inputs .cancelBtn", function(){

    localStorage.removeItem("capturarRangoReportes");
    localStorage.clear();
    window.location = "reportes";


})

$('.daterangepicker.opensright .ranges li').on("click", function() {


  var textoHoy = $(this).attr("data-range-key")

  if(textoHoy == "Hoy") {

      var d = new Date(); 
      var dia = d.getDate();
      var mes = d.getMonth() + 1;
      var year = d.getFullYear();

      var fechaInicial = year+"-"+mes+"-"+dia;
      var fechaFinal = year+"-"+mes+"-"+dia;

    if(mes < 10){

      var fechaInicial = year+"-0"+mes+"-"+dia;

      var fechaFinal = year+"-0"+mes+"-"+dia;

    }else if(dia < 10){

      var fechaInicial = year+"-"+mes+"-0"+dia;

      var fechaFinal = year+"-"+mes+"-0"+dia;


    }else if(mes < 10 && dia < 10){

      var fechaInicial = year+"-0"+mes+"-0"+dia;

      var fechaFinal = year+"-0"+mes+"-0"+dia;

    }else{

      var fechaInicial = year+"-"+mes+"-"+dia;

      var fechaFinal = year+"-"+mes+"-"+dia;

    }

      localStorage.setItem("capturarRangoReportes", "Hoy")
      window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal

  }


})

/* Gráficos Morris */ 
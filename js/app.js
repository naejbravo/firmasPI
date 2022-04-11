$(document).ready(function () {
  //Container2 es la clase del div que contiene el inicio de sesion
  $(".container2").hide();
  $(".container3").hide();
  $(".container4").hide();
  $(".container5").hide();
  //Llama a la funcion que carga los profesores que tienen actividades en el dia actual
  fetchProfesores();
  //Cuando hace click en la clase iniciarSesion ejecuta la siguiente funcion, oculta el div con clase container1 que es la tabla con los profesores y muestra el container2 que
  //el formulario de inicio de sesion
  $(".iniciarSesion").on("click", function () {
    $(".container1").hide();
    $(".nav-link").text("");
    //$('.container5').hide();
    $(".container2").show();
    $("#events3").removeClass("d-none").show();
    $(document).on("click", ".close", function () {
      $("#events3").hide();
      location.reload();
    });
  });

  $(".cargaXml").on("click", function () {
    $(".container1").hide();
    $(".container4").hide();
    $(".container5").hide();
    $(".container3").show();
    $("#events4").removeClass("d-none").show();
    $(document).on("click", ".close", function () {
      $("#events4").hide();
      location.reload();
    });
  });

  $(".informes").on("click", function () {
    $(".container1").hide();
    $(".container3").hide();
    $(".container5").hide();
    $(".container4").show();

    $("#profesor").keyup(function () {
      var valor = $(this).val();

      $.ajax({
        type: "POST",
        data: { valor: valor },
        url: "./models/ModelFetch.php",
        success: function (response) {
          //console.log(response);
          $("#browsers").html(response);
        },
      });
    });
    $("#profesor").on("change", function () {
      var profesor = $("#profesor").val();
      var fecha = $("#fecha").val();
      console.log(profesor, fecha);
      //alert(profesor);

      //console.log(profesor, fecha);

      $.ajax({
        type: "post",
        data: {
          profesor,
          fecha,
        },
        url: "./models/informes.php",
        success: function (response) {
          //console.log(response);
        },
      });
    });

    $("#profesor2").keyup(function () {
      var valor = $(this).val();

      $.ajax({
        type: "POST",
        data: { valor: valor },
        url: "./models/ModelFetch.php",
        success: function (response) {
          //console.log(response);
          $("#browsers2").html(response);
        },
      });
    });

    $("#profesor2").on("change", function () {
      console.log($("#mes").val());
    });
    /*$('#buscar').on('click', function(){
			
		})*/

    $("#profesor4").keyup(function () {
      var valor = $(this).val();

      $.ajax({
        type: "POST",
        data: { valor: valor },
        url: "./models/ModelFetch.php",
        success: function (response) {
          //console.log(response);
          $("#browsers4").html(response);
        },
      });
    });
    $("#profesor4").on("change", function () {
      var profesor = $("#profesor4").val();
      var fecha = $("#fecha3").val();
      console.log(profesor, fecha);
      //alert(profesor);

      //console.log(profesor, fecha);

      $.ajax({
        type: "post",
        data: {
          profesor,
          fecha,
        },
        url: "./models/informes.php",
        success: function (response) {
          //console.log(response);
        },
      });
    });
    $("#profesor5").keyup(function () {
      var valor = $(this).val();

      $.ajax({
        type: "POST",
        data: { valor: valor },
        url: "./models/ModelFetch.php",
        success: function (response) {
          //console.log(response);
          $("#browsers5").html(response);
        },
      });
    });
    $("#profesor5").on("change", function () {
      var profesor = $("#profesor5").val();
      var fecha = $("#mes2").val();
      console.log(profesor, fecha);
      //alert(profesor);

      //console.log(profesor, fecha);

      $.ajax({
        type: "post",
        data: {
          profesor,
          fecha,
        },
        url: "./models/informes4.php",
        success: function (response) {
          //console.log(response);
        },
      });
    });
  });

  $(".firmar2").on("click", function () {
    $(".container1").hide();
    $(".container3").hide();
    $(".container4").hide();
    $(".container5").show();
    $("#profesor3").keyup(function () {
      var valor = $(this).val();

      $.ajax({
        type: "POST",
        data: { valor: valor },
        url: "./models/ModelFetch.php",
        success: function (response) {
          //console.log(response);
          $("#browsers3").html(response);
          $("#buscar3").on("click", function () {
            let nombreProfesor = $("#browsers3")[0].children[0].value;
            let fecha = $("#fecha2")[0].value;
            $("#tablaHorario2").removeClass("d-none");
            //console.log(idProfesor);
            $.post(
              "./models/ModelHorario2.php",
              { nombre: nombreProfesor, date: fecha },
              function (response) {
                var horarios2 = JSON.parse(response);
                console.log(horarios2);
                $("#tablaHorario2").DataTable().destroy();
                var table2 = $("#tablaHorario2").DataTable({
                  dom: "Bfrtip",
                  ordering: "false",
                  data: horarios2,
                  select: {
                    style: "multi",
                  },
                  buttons: [
                    {
                      text: "Firmar",
                      className: "btn btn-outline-dark btn-block mb-2 mt-2",
                      action: function () {
                        var rows2 = table2
                          .rows({ selected: true })
                          .data()
                          .toArray();
                        console.log(rows2);
                        if (rows2.length == 0) {
                          alert("Debes seleccionar porlomenos un horario");
                          location.reload();
                        } else {
                          $(document).on("click", ".dt-button", function () {
                            $("#events2").removeClass("d-none").show();
                            var signaturePad = new SignaturePad(
                              document.getElementById("signature-pad2"),
                              {
                                backgroundColor: "rgba(255, 255, 255, 0)",
                                penColor: "rgb(0, 0, 0)",
                              }
                            );
                            //console.log("hola");
                            var saveButton = document.getElementById("save2");
                            var cancelButton = document.getElementById(
                              "clear2"
                            );

                            saveButton.addEventListener(
                              "click",
                              function (event) {
                                var data2 = signaturePad.toDataURL("image/png");

                                // Send data to server instead...
                                window.open(data2);
                              }
                            );

                            cancelButton.addEventListener(
                              "click",
                              function (event) {
                                signaturePad.clear();
                              }
                            );

                            $(".contenido").html(
                              "<button class='firmar'>Firmar</a>"
                            );
                            $(document).on("click", ".firmar", function () {
                              if (signaturePad.isEmpty()) {
                                alert("No ha firmado.");
                              } else {
                                var data2 = signaturePad.toDataURL();

                                //console.log(json_rows);
                                $.ajax({
                                  type: "POST",
                                  url: "./models/ModelFirma2.php",
                                  data: {
                                    result: JSON.stringify(rows2),
                                    result2: JSON.stringify(data2),
                                    result3: fecha,
                                  },
                                  success: function (response) {
                                    console.log(response);
                                    alert("Ha firmado correctamente");
                                    location.reload();
                                  },
                                });
                              }
                            });
                            $(document).on("click", ".close", function () {
                              $("#events2").hide();
                            });
                          });
                        }
                      },
                    },
                  ],
                  columns: [
                    {
                      data: "id",
                    },
                    {
                      data: "profesor",
                    },
                    {
                      data: "asignatura",
                    },
                  ],
                  columnDefs: [
                    {
                      targets: 0,
                      checkboxes: {
                        selectRow: true,
                      },
                    },
                  ],
                  language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sInfo:
                      "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty:
                      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sSearch: "Buscar:",
                    sInfoThousands: ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                      sFirst: "Primero",
                      sLast: "Último",
                      sNext: "Siguiente",
                      sPrevious: "Anterior",
                    },
                    oAria: {
                      sSortAscending:
                        ": Activar para ordenar la columna de manera ascendente",
                      sSortDescending:
                        ": Activar para ordenar la columna de manera descendente",
                    },
                    buttons: {
                      copy: "Copiar",
                      colvis: "Visibilidad",
                    },
                  },
                });
              }
            );
          });
        },
      });
    });
  });

  //Funcion cargar profesores
  function fetchProfesores() {
    $.ajax({
      url: "./models/ModelProfesor.php",
      type: "GET",
      success: function (response) {
        var profesores = JSON.parse(response);
        var table = $("#tablaProfesor").DataTable({
          bLengthChange: false,
          bPaginate: true,
          bInfo: true,
          bFilter: true,

          ordering: false,
          data: profesores,
          columns: [
            {
              data: "id_profesor",
            },
            {
              data: "nombre",
            },
            {
              data: null,
              className: "center",
              defaultContent:
                "<a href='#' class='ver-horario'>Ver horarios</a>",
            },
          ],
          rowId: "id_profesor",
          language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
              "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty:
              "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
              sFirst: "Primero",
              sLast: "Último",
              sNext: "Siguiente",
              sPrevious: "Anterior",
            },
            oAria: {
              sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
              sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
            },
            buttons: {
              copy: "Copiar",
              colvis: "Visibilidad",
            },
          },
        });
      },
    });
  }

  $(document).on("click", ".ver-horario", function () {
    let element = $(this)[0].parentElement.parentElement;
    let idProfesor = $(element).attr("id");
    $("#tablaProfesor").hide();
    $("#tablaProfesor_wrapper").hide();
    $("#tablaHorario").removeClass("d-none");
    //$('#events').removeClass('d-none').show();
    $.post("./models/ModelHorario.php", { idProfesor }, function (response) {
      var horarios = JSON.parse(response);
      console.log(horarios);
      var table = $("#tablaHorario").DataTable({
        dom: "Bfrtip",
        select: {
          style: "multi",
        },
        buttons: [
          {
            text: "Firmar",
            className: "btn btn-outline-dark btn-block mb-2 mt-2",
            action: function () {
              var rows = table.rows({ selected: true }).data().toArray();
              if (rows.length == 0) {
                alert("Debes seleccionar porlomenos un horario");
                location.reload();
              } else {
                $(document).on("click", ".dt-button", function () {
                  $("#events").removeClass("d-none").show();
                  var signaturePad = new SignaturePad(
                    document.getElementById("signature-pad"),
                    {
                      backgroundColor: "rgba(255, 255, 255, 0)",
                      penColor: "rgb(0, 0, 0)",
                    }
                  );
                  //console.log("hola");
                  var saveButton = document.getElementById("save");
                  var cancelButton = document.getElementById("clear");

                  saveButton.addEventListener("click", function (event) {
                    var data = signaturePad.toDataURL("image/png");

                    // Send data to server instead...
                    window.open(data);
                  });

                  cancelButton.addEventListener("click", function (event) {
                    signaturePad.clear();
                  });

                  $(".contenido").html("<button class='firmar'>Firmar</a>");
                  $(document).on("click", ".firmar", function () {
                    if (signaturePad.isEmpty()) {
                      alert("No ha firmado.");
                    } else {
                      var data = signaturePad.toDataURL();

                      //console.log(json_rows);
                      $.ajax({
                        type: "POST",
                        url: "./models/ModelFirma.php",
                        data: {
                          result: JSON.stringify(rows),
                          result2: JSON.stringify(data),
                        },
                        success: function (response) {
                          console.log(response);
                          alert("Ha firmado correctamente");
                          location.reload();
                        },
                      });
                    }
                  });
                  $(document).on("click", ".close", function () {
                    $("#events").hide();
                  });
                });
              }
            },
          },
        ],
        ordering: "false",
        data: horarios,
        columns: [
          {
            data: "id",
          },
          {
            data: "asignatura",
          },
          {
            data: "aula",
          },
          {
            data: "inicio",
          },
          {
            data: "final",
          },
        ],
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },
        ],
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo:
            "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty:
            "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sSearch: "Buscar:",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
          },
          oAria: {
            sSortAscending:
              ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
              ": Activar para ordenar la columna de manera descendente",
          },
          buttons: {
            copy: "Copiar",
            colvis: "Visibilidad",
          },
        },
      });
    });
  });
});
//Pregunta si quiere importar los datos a la base de datos. Con el fichero xml mas reciente que se haya subido
$(function () {
  $("a.importar").click(function (e) {
    if (window.confirm("¿Deseas importar los datos?")) {
      window.open($(this).attr("href"), "_self");
    }
    e.preventDefault();
  });
});

//Pregunta si se quieren borrar todos los datos guardados en la base de datos.
$(function () {
  $("a.delete").click(function (e) {
    if (window.confirm("¿Desea borrar todos los datos?")) {
      window.open($(this).attr("href"), "_self");
    }
    e.preventDefault();
  });
});

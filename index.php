<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Inicio</title>
  <!-- Enlace bootstrap 4.5.2 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- Enlace Datatables 1.10.22 -->
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <!-- Enlace estilos Datatables (Checkboxes) 1.2.12 -->
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
  <!-- Enlace a los estilos propios de los modales utilizados -->
  <link rel="stylesheet" type="text/css" href="./css/modal.css">
</head>

<body>
  <!-- Comienza if que verifica si existe el id de sesion -->
  <!-- Si la variable id existe nos mostrara los enlaces a los que solo el usuario admin puede ver y acceder -->
  <?php if (isset($_SESSION['id'])) : ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item cargaXml">
          <a class="nav-link" href="#">Cargar datos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link delete" href="./controllers/ControllerDelete.php">Borrar datos</a>
        </li>
        <li class="nav-item informes">
          <a class="nav-link" href="#">Informes</a>
        </li>
        <li class="nav-item firmar2">
          <a class="nav-link" href="#">Firmar</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="./controllers/ControllerLogout.php">Cerrar sesión</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
  <!-- Termina if que verifica si existe el id se sesion -->

  <!-- Comienza if que verifica si no existe el id de sesion -->
  <!-- Si la variable id no existe, solo nos enseñara el enlace para poder iniciar sesion. Esto solo en el apartado del menu o nav -->
  <?php if (!isset($_SESSION['id'])) : ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item iniciarSesion">
          <a class="nav-link" href="#">Iniciar sesión</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
  <!-- Termina if que verifica si no existe el id de sesion -->
  <!-- El div con clase container2, se encarga de mostrar el formulario para iniciar sesion -->
  <!-- Inicio container2 -->
  <div class="container-fluid container2 mt-2">
    <div class="row">
      <div class="col-md-12">

        <?php if (isset($_SESSION['id'])) : ?>
          <?php echo "Ya has iniciado sesion"; ?>
        <?php else : ?>
          <?php
          if (isset($_SESSION['error'])) {
            //echo $_SESSION['error'];
          }
          ?>
          <div id="events3" class="d-none">
            <div class="modal-content">
              <div class="wrapper mx-auto">
                <form method="post" action="./controllers/ControllerLogin.php" name="login">
                  <div class="form-element">
                    <label class="col-10 col-form-label col-form-label-sm d-block">Usuario</label>
                    <input class="col-10 form-control form-control-sm" type="text" name="username" pattern="[a-zA-Z0-9]+" required />
                  </div>
                  <div class="form-element">
                    <label class="col-10 col-form-label col-form-label-sm d-block">Contraseña</label>
                    <input class="col-10 form-control form-control-sm" type="password" name="password" required />
                  </div>
                  <button class="col-10 btn btn-outline-dark btn-block mt-2" type="submit" name="login" value="login">Entrar </button>
                </form>

              </div>

              <span class="contenido"></span>
              <span class="close">&times;</span>


            </div>
          </div>

        <?php endif ?>
      </div>
    </div>
  </div>
  <!-- Fin de container2 -->
  <!-- Div con clase container3 es el encargado de enseñar el formulario para subir fichero xml de horarios y almacenarlo en su respectivo directorio -->
  <!-- Inicio de container3 -->
  <div class="container-fluid container3 mt-2">
    <div class="row">
      <div class="col-md-12">
        <?php if (isset($_SESSION['id'])) : ?>
          <div id="events4" class="d-none">
            <div class="modal-content">
              <div class="wrapper mx-auto">
                <form enctype="multipart/form-data" action="./controllers/ControllerFile.php" method="POST">
                  <!--<label for="file" class="col-10 col-form-label">Enviar este fichero: </label>-->
                  <label for="fechaInicio" class="col-10 col-form-label">Fecha Inicio:</label>
                  <input class="col-10 form-control" name="fechaInicio" type="date" required />
                  <label for="fechaFin" class="col-10 col-form-label">Fecha final:</label>
                  <input class="col-10 form-control mb-2" name="fechaFin" type="date" required />
                  <input class="col-10 mb-2 form-control-file" name="file" type="file" required />
                  <input class="col-10 btn btn-outline-dark btn-block" type="submit" value="Enviar fichero" />
                </form>
              </div>
              <span class="close">&times;</span>
            </div>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
  <!-- Fin de container3 -->

  <!-- Div con calse container4 se encarga de cargar los formularios para ver los informes de horarios firmados y no firmados del profesor -->
  <!-- Inicio de container 4 -->
  <div class="container-fluid container4 mt-2">
    <div class="row">
      <div class="col-md-12">
        <h3>Informe diario de horarios</h3>
        <form action="./models/informes.php" method="POST">
          <div class="form-group row">
            <label for="fecha" class="col-2 col-form-label mb-2">Fecha</label>
            <div class="col-10 mb-2">
              <input class="form-control" type="date" id="fecha" name="fecha">
            </div>
            <label for="profesor" class="col-2 col-form-label">Profesor</label>
            <div class="col-10">
              <input class="form-control" id="profesor" list="browsers" name="profesor">
              <datalist id="browsers">

              </datalist>

            </div>

            <button type="submit" class="btn btn-outline-dark btn-block mt-2 ml-3 mr-3" id="buscar">Buscar</button>
          </div>
        </form>
      </div>
      <div class="col-md-12">
        <h3>Informe mensual de horarios</h3>
        <form action="./models/informes2.php" method="POST">
          <div class="form-group row">
            <label for="mes" class="col-2 col-form-label mb-2">Mes</label>
            <div class="col-10 mb-2">
              <input class="form-control" type="month" id="mes" name="mes">
            </div>
            <label for="profesor2" class="col-2 col-form-label">Profesor</label>
            <div class="col-10">
              <input class="form-control" id="profesor2" list="browsers2" name="profesor2">
              <datalist id="browsers2">

              </datalist>

            </div>

            <button type="submit" class="btn btn-outline-dark btn-block mt-2 ml-3 mr-3" id="buscar2">Buscar</button>
          </div>
        </form>
      </div>
      <div class="col-md-12">
        <h3>Informe mensual de profesores sin firmar</h3>
        <form action="./models/informes3.php" method="POST">
          <div class="form-group row">
            <label for="mes2" class="col-2 col-form-label mb-2">Mes</label>
            <div class="col-10 mb-2">
              <input class="form-control" type="month" id="mes2" name="mes2">
            </div>
            <button type="submit" class="btn btn-outline-dark btn-block mt-2 ml-3 mr-3" id="buscar4">Buscar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Fin de container 4 -->

  <!-- Div container5, se encarga de mostrar el formulario para elegir el dia y profesor del cual deseamos firmar un horario. solo puede hacerlo el usuario admin -->
  <!-- Inicio de container 5 -->
  <div class="container-fluid container5 mt-2">
    <div class="row">
      <div class="col-md-12">
        <h3>Firma de horarios</h3>
        <form action="javascript:void(0);" method="POST">
          <div class="form-group row">
            <label for="fecha2" class="col-2 col-form-label mb-2">Fecha</label>
            <div class="col-10 mb-2">
              <input class="form-control" type="date" id="fecha2" name="fecha2">
            </div>
            <label for="profesor3" class="col-2 col-form-label">Profesor</label>
            <div class="col-10">
              <input class="form-control" id="profesor3" list="browsers3" name="profesor3">
              <datalist id="browsers3">

              </datalist>

            </div>

            <button type="submit" class="btn btn-outline-dark btn-block mt-2 ml-3 mr-3" id="buscar3">Buscar</button>
          </div>
        </form>

        <table id="tablaHorario2" class="table table-hover d-none" style="width: 100%">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Profesor</th>
              <th scope="col">Asignatura</th>
            </tr>
          </thead>
          <tbody id="horarios2">

          </tbody>
        </table>
        <div id="events2" class="d-none">
          <div class="modal-content">
            <div class="wrapper mx-auto">

              <canvas id="signature-pad2" class="signature-pad" width=400 height=200></canvas>
            </div>
            <div class="mx-auto">
              <button id="save2" class="d-none">Save</button>
              <button id="clear2">Borrar</button>
              <span class="contenido"></span>
            </div>

            <span class="close">&times;</span>


          </div>
        </div>


      </div>
    </div>
  </div>
  <!-- Fin de container 5 -->

  <!-- Div container1, se encarga de mostrar la lista de profesores que tienen clase para el dia actual, en un datatable -->
  <!-- Inicio de container1 -->
  <div class="container-fluid container1 mt-2">
    <div class="row">
      <div class="col-md-12">
        <script>
          var f = new Date();
          document.write(f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear());
        </script>



        <table id="tablaProfesor" class="table table-hover display" style="width: 100%">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Nombre</th>
              <th class="center"></th>
            </tr>
          </thead>
          <tbody id="profesores">

          </tbody>
        </table>
        <div id="events" class="d-none">
          <div class="modal-content">
            <div class="wrapper mx-auto">

              <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
            </div>
            <div class="mx-auto">
              <button id="save" class="d-none">Save</button>
              <button id="clear">Borrar</button>
              <span class="contenido"></span>
            </div>

            <span class="close">&times;</span>


          </div>
        </div>
        <table id="tablaHorario" class="table table-hover d-none" style="width: 100%">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Asignatura</th>
              <th scope="col">Aula</th>
              <th scope="col">Hora inicio</th>
              <th scope="col">Hora final</th>
            </tr>
          </thead>
          <tbody id="horarios">

          </tbody>
        </table>


      </div>
    </div>
  </div>
  <!-- Fin de container 1 -->

  <!-- Enlaces con diferentes script para funcionalidades usadas en la pagina: jquery, signature_pad, datables, datatables(select), datatables(buttons), datatables(checkboxes), download js, app(funciones propias) -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>
  <script type="text/javascript" src="./js/app.js"></script>

</body>

</html>
<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('./funciones/loginRequerido.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Crear Incidencia</title>
</head>

<body>
  <header>
    <nav id="navegador" class="navbar navbar-expand-md navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href='rolApp.php'>
          <img src="../images/logoJulioVerne.png">
          <span>
            <?php
            // Conectamos con la Base de Datos
            require_once('./funciones/conexion.php');
            try {
              // Consulta para mostrar el nombre para mostrar en el cliente: Bienvenido 'Usuario Logueado'
              // Aqui pongo donde el email sea ? para seleccionar al usuario que se haya logueado con el mail
              $consultaNombre = "SELECT Nombre, Apellidos FROM usuario where Email = ?";
              $mostrarNombre = $db->prepare($consultaNombre);
              // Lo mismo, la sesion del email porque inicia con el email
              $mostrarNombre->execute(array($_SESSION['email']));
              // Recorremos las filas de la consulta
              foreach ($mostrarNombre as $nombre) {
                // Mostramos el mensaje de Bienvenida con el nombre de usuario
                echo "Bienvenido " . $nombre["Nombre"] . " " . $nombre["Apellidos"];
              }
            } catch (PDOException $e) {
              echo "Error con la base de datos: " . $e->getMessage();
            }
            ?>
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="#">Incidencias</a></li>
          </ul>

          <hr class="text-white-50">
          <i class="bi bi-person-circle"></i>
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="submenu" role="button" data-bs-toggle="dropdown" href="#" style="margin-right: 100px;">Perfil</a>
              <ul class="dropdown-menu bg-light">
                <li><a class="dropdown-item" href="../selectorPuente.php">Volver</a></li>
                <hr>
                <li><a class="dropdown-item" href="../logpuente.php">Salir</a></li>
              </ul>
            </li>
          </ul>
          <hr class="text-white-50">
        </div>
      </div>
    </nav>
  </header>

  <section>
    <article>
      <div class="container px-4 py-5" id="editarPerfil">
        <h2 class="pb-2 border-bottom">Crear Incidencia</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="row">
            <div class="col-md-6 p-3 ">
              <label for="niveltarea" class="form-label">Nivel de la tarea</label>
              <input type="text" class="form-control" id="niveltarea1" name="niveltarea" required>
            </div>

            <div class="col-md-6 p-3 ">
              <label for="localizacion" class="form-label">Localización</label>
              <input type="text" class="form-control" id="localizacion" name="localizacion" required>
            </div>
          </div>

          <!-- <div class="row">
            <div class="col-md-6 p-3 ">
              <label for="tipoIncidencia" class="form-label">Tipo de Incidencia</label>
              <select class="form-select" aria-label="Seleccionar Tipo de Incidencia" name="tipo_Incidencia" required>
                <option>Selecciona una opción</option>
                <option value="informatica">Incidencia Informática</option>
                <option name = "centro2" value="centro">Incidencia de centro</option>
              </select>
            </div> -->
          <!-- 
            <div class="col-md-6 p-3 ">
              <label for="tipoIncidencia" class="form-label">Asignar Profesor</label>
              <select class="form-select" aria-label="Seleccionar Tipo de Incidencia" name="asignarProfesor" required>
                <option selected>Selecciona una opción</option>
                <option value="informatica">Incidencia Informática</option>
                <option value="centro">Incidencia de centro</option>
              </select>
            </div> -->

          <?php
          require_once('./funciones/conexion.php');

          // $consultaProfesor = "SELECT COD_USUARIO, NOMBRE FROM usuario WHERE DEPARTAMENTO = 1";
          // $mostrarProfesor = $db->query($consultaProfesor);

          // // Mostramos los resultados de la consulta en un select
          // echo "<div class='col-md-6 p-3'>
          //     <label for='tipoIncidencia' class='form-label'>Asignar Profesor</label>
          //     <select class='form-select' aria-label='Seleccionar Tipo de Incidencia' name='asignar_profesor' required>
          //     <option selected>Selecciona un profesor</option>";
          // $asignar_profesor=$_POST['asignar_profesor'];
          // foreach ($mostrarProfesor as $row) {
          //   $nombre = $row["NOMBRE"];
          //   $codigo2 = $row["COD_USUARIO"];
          //   echo "<option>" . $nombre . "</option>";
          // }
          // echo "</select></div>";
          ?>

          <div class="row">
            <div class="col-md-6 p-3 ">
              <label for="fechaini" class="form-label">Fecha Inicio</label>
              <input type="date" class="form-control" id="fechaini" name="fechaini" required>
            </div>

            <div class="col-md-6 p-3 ">
              <label for="estado" class="form-label">Estado</label>
              <input type="text" class="form-control" id="estado" name="estado" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 p-3 d-flex justify-content-center">
              <textarea placeholder="Comentario" class="w-100 h-100" name="comentario" required></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 p-3">
              <button class="btn btn-secondary" name="crearInci" type="submit">Crear Incidencia</button>
            </div>
          </div>

        </form>

        <?php
        error_reporting(E_ALL ^ E_WARNING);

        $nvl_Tarea = $_POST['niveltarea'];
        $localizacion = $_POST['localizacion'];
        // $tipo_Incidencia = $_POST['tipo_Incidencia'];
        $imagen = $_POST['imagen'];
        $fechaini = $_POST['fechaini'];
        $estado = $_POST['estado'];
        $comentario = $_POST['comentario'];

        require_once('./funciones/conexion.php');

        $consultaCod = "SELECT COD_USUARIO FROM usuario where Email = ?";
        $mostrarCod = $db->prepare($consultaCod);
        // Lo mismo, la sesion del email porque inicia con el email
        $mostrarCod->execute(array($_SESSION['email']));
        // Recorremos las filas de la consulta
        foreach ($mostrarCod as $cod) {
          $codigo = $cod['COD_USUARIO'];
        }

        if (isset($_POST["crearInci"])) {

          try {
            // var_dump($codigo2);
            // $gest = $codigo2;
            $insert = 'insert into tareas(ESTADO, NIVEL_TAREA, COMENTARIO, LOCALIZACION, FECHA_INICIO, COD_USUARIO_CREA)
              values(?,?,?,?,?,?);';
            $insert2 = $db->prepare($insert);
            $insert2->execute(array(
              $estado, $nvl_Tarea, $comentario, $localizacion,
              $fechaini, $codigo
            ));

            if ($insert2) {
              print "
                <script>
                    alert('Tarea añadida correctamente.');
                    window.location = 'admin.php';
                </script>";
            }
          } catch (PDOException $e) {
            echo "Error en la base de datos " . $e->getMessage();
          }
        }
        ?>
      </div>
    </article>
  </section>
  <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
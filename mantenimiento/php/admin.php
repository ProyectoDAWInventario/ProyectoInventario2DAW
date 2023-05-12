<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('funciones/loginRequerido.php');
require 'funciones/controlroles.php';
controlarrol(0);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Administrador</title>
</head>
<body>
  <header>
        <nav id="navegador" class="navbar navbar-expand-md navbar-light bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href='funciones/rolApp.php'>
              <img src="../images/logoJulioVerne.png">
              <span>
                    <?php
                      // Conectamos con la Base de Datos
                      require_once('funciones/conexion.php');
                      try{
                            // Consulta para mostrar el nombre para mostrar en el cliente: Bienvenido 'Usuario Logueado'
                        // Aqui pongo donde el email sea ? para seleccionar al usuario que se haya logueado con el mail
                        $consultaNombre = "SELECT Nombre, Apellidos FROM usuario where Email = ?";
                        $mostrarNombre = $db->prepare($consultaNombre);
                        // Lo mismo, la sesion del email porque inicia con el email
                        $mostrarNombre->execute(array($_SESSION['email']));
                        // Recorremos las filas de la consulta
                      foreach($mostrarNombre as $nombre){
                          // Mostramos el mensaje de Bienvenida con el nombre de usuario
                          echo "Bienvenido ".$nombre["Nombre"]." ". $nombre["Apellidos"];
                      }
                      }catch(PDOException $e){
                          echo "Error con la base de datos: " . $e->getMessage();
                      }
                    ?>
              </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link dropdown-toggle" id="submenu" role="button" data-bs-toggle="dropdown"
                      href="#" style="margin-right: 100px;">Perfil</a>
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
    
      <article>
        <section>
            <div class="container px-4 py-5" id="Incidencias">
                <h2 class="pb-2 border-bottom">Incidencias</h2>
                <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                    <?php
                        // Mostramos la tabla con todas las Incidencias
                        require_once('funciones/conexion.php');
                        $contador = 0;
                        try{
                            $incidencias = "SELECT * FROM tareas";
                            $incidencias = $db->query($incidencias);
                            
                            echo ('<table class="table table-striped table-hover text-center">');
                            echo ("<thead>
                                  <tr>
                                    <th scope='col'>#</th>
                                    <td>Código de la Tarea</td>
                                    <td>Estado de la Tarea</td>
                                    <td>Nivel de la Tarea</td>
                                    <td>Localización</td>
                                    <td>Fecha Inicio</td>
                                    <td>Fecha Fin</td>
                                    <td>Imagen</td>
                                    <td>Comentario</td>
                                    <td>cod_usuario_gestion</td>
                                    <td>cod_usuario_crea</td>
                                    <td>Tipo Incidencia</td>

                                  </tr>
                            </thead>");
                            foreach($incidencias as $row){
                                // Sacamos todos los elementos de la tabla Tareas
                                $estadoTarea = $row["ESTADO"];
                                $cod_Tarea = $row["COD_TAREA"];
                                $nivel_tarea = $row["NIVEL_TAREA"];
                                $comentario = $row["COMENTARIO"];
                                $imagen = $row["IMAGEN"];
                                $localizacion = $row["LOCALIZACION"];
                                $fecha_inicio  = $row["FECHA_INICIO"];
                                $fecha_fin = $row["FECHA_FIN"];
                                $cod_usuario_gestion = $row["COD_USUARIO_GESTION"];
                                $cod_usuario_crea = $row["COD_USUARIO_CREA"];
                                $tipo_inci=$row["TIPO_INCIDENCIA"];
                                $contador++;

                                echo "
                                <tbody>
                                  <tr>
                                  <th scope='row'>$contador</th>
                                    <td>$cod_Tarea</td>
                                    <td>$estadoTarea</td>
                                    <td>$nivel_tarea</td>
                                    <td>$localizacion</td>
                                    <td>$fecha_inicio</td>
                                    <td>$fecha_fin</td>
                                    <td>$imagen</td>
                                    <td>$comentario</td>
                                    <td>$cod_usuario_gestion</td>
                                    <td>$cod_usuario_crea</td>
                                    <td>$tipo_inci</td>
                                  </tr>
                                </tbody>";
                            }
                            echo "</table>";
                        }catch(PDOException $e){
                            echo 'Error con la base de datos '.$e->getMessage();
                        }
                    ?>
                </div>
                 <a href="crearInci.php"><button type="button" class="btn btn-secondary">Crear Incidencia</button></a>
            </div>
        </section>
      </article>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
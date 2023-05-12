<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('loginRequerido.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Editar Perfil</title>
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>
<body class="gradient-custom">
    <header>
        <nav id="navegador" class="navbar navbar-expand-md">
          <div class="container-fluid">
            <a class="navbar-brand">
              <span class="text-light">
                   <?php
                    // Conectamos con la Base de Datos
                    require_once('conexion.php');
                    try{
                         // Consulta para mostrar el nombre para mostrar en el cliente: Bienvenido 'Usuario Logueado'
                    // Aqui ponemos donde el email sea ? para seleccionar al usuario que se haya logueado con el mail
                    $consultaNombre = "SELECT Nombre, Apellidos FROM usuario where Email = ?";
                    $mostrarNombre = $db->prepare($consultaNombre);
                    // Lo mismo, la sesion del email porque inicia con el email
                    $mostrarNombre->execute(array($_SESSION['usuario_login']['EMAIL']));
                    // Recorremos las filas de la consulta
                    foreach($mostrarNombre as $nombre){
                        // Mostramos el mensaje de Bienvenida con el nombre de usuario
                        echo "Bienvenido ".$nombre["Nombre"]." ".$nombre["Apellidos"];
                    }
                    }catch(PDOException $e){
                        echo "Error con la base de datos: " . $e->getMessage();
                    }
                    ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
              <ul class="navbar-nav me-auto"></ul>
              <hr class="text-white-50">
              <i class="bi bi-person-circle"></i>
              <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="submenu" role="button" data-bs-toggle="dropdown"
                      href="#" style="margin-right: 100px;">Perfil</a>
                    <ul class="dropdown-menu bg-light">
                      <li><a class="dropdown-item" href="selector.php">Volver</a></li>
                      <hr>
                      <li><a class="dropdown-item" href="../login.php">Salir</a></li>
                    </ul>
                  </li>
              </ul>
              <hr class="text-white-50">
            </div>
            </div>
        </nav>
    </header>
    <!-- TODOS LOS USUARIOS -->
    <?php
      if($_SESSION['usuario_login']['ROL'] == 0){

        require_once('conexion.php');
        $contador = 0;
        try {
          // Mostramos los usuarios que no estan autorizados en la app
          $usuarios = 'SELECT * FROM Usuario';
          $usuarios = $db->query($usuarios);
          echo ('<div class="container-fluid">');
          echo ('<table class="table text-light">');
          echo ("<thead>
              <tr>
                <th scope='col'>#</th>
                <td>Nombre</td>
                <td>Apellidos</td>
                <td>Email</td>
                <td>Acción</td>
              </tr>
            </thead>");

          foreach ($usuarios as $row) {
            $Cod_Usuario = $row['COD_USUARIO'];
            $rol = $row['ROL'];
            $nombre = $row['NOMBRE'];
            $apellidos = $row['APELLIDOS'];
            $email = $row['EMAIL'];
            $contador++;

            // Ocultamos en los input las variables obtenidas de los usuarios seleccionados para poder autorizarles denegarles o hacer administradores
            echo "
            <form method='POST' action='actualizarUsuario.php?idusuario=$Cod_Usuario'>
              <tbody>
                <tr>
                  <th scope='row'>$contador</th>
                    <td>$nombre</td>
                    <td>$apellidos</td>
                    <td>$email</td>
                    <td>
                      <input type='hidden' name='idUsuario' value='$Cod_Usuario'>
                      <input type='hidden' name='rolUsuario' value='$rol'> 
                      <button class='btn btn-secondary' name='editar'>Editar</button>
                      <a href='borrarUsuario.php?cod=$Cod_Usuario' class='btn btn-danger' name='eliminar' id='eliminar'>Eliminar</a>
                    </td>
                </tr>
                </tbody>
                </form>";
          }
          echo "</table></div>";
        } catch (PDOException $e) {
          echo 'Error con la base de datos ' . $e->getMessage();
      }

      } else {
        header ("Location: actualizarUsuario.php?idusuario=".$_SESSION['usuario_login']['COD_USUARIO']."");
      }
    ?>
    <!-- FIN TODOS LOS USUARIOS -->

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
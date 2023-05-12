<?php
  session_start();

  require_once('loginRequerido.php');
  require_once('conexion.php');
  try {
    $consultaRol = "SELECT ROL FROM usuario where Email = ?";
    $mostrarRol = $db->prepare($consultaRol);
    // Lo mismo, la sesion del email porque inicia con el email
    $mostrarRol->execute(array($_SESSION['usuario_login']['email']));
    // Recorremos las filas de la consulta
    foreach ($mostrarRol as $rol) {
      $_SESSION['usuario_login']['ROL'] = $rol['ROL'];
    }
  } catch (PDOException $e) {
    echo "Error con la base de datos: " . $e->getMessage();
  }

  switch ($_SESSION['usuario_login']['ROL']) {
    case 0:
      header("Location: ../admin.php");
      break;
    case 1:
      header("Location: ../profesor.php");
      break;
    case 2:
      header("Location: ../operario.php");
      break;
}

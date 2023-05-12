<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('loginRequerido.php');
?>

<?php
require_once("conexion.php");
// Función para autorizar el acceso a la aplicación
if (isset($_POST['autorizar'])) {
    $Cod_Usuario = $_POST['idUsuario'];
    $upd = 'UPDATE USUARIO SET VALIDAR = "si" WHERE COD_USUARIO = "'.$Cod_Usuario.'" AND VALIDAR = "no"';
    $result = $db->query($upd);

    //comprobar error
    if ($result && $result->rowCount() > 0) {
      echo "<script>alert('Usuario autorizado')</script>";
    } else print_r($db->errorinfo());
  }

// Función para denegar el acceso a la aplicación
if (isset($_POST['denegar'])) {
    $Cod_Usuario = $_POST['idUsuario'];
    $upd = 'UPDATE USUARIO SET VALIDAR = "no" WHERE COD_USUARIO = "'.$Cod_Usuario.'" AND VALIDAR = "no"';
    $result = $db->query($upd);

    //comprobar error
    if ($result) {
      echo "<script>alert('Usuario denegado')</script>";
    } else print_r($db->errorinfo());
  }

// Función para Hacer Administrador al Usuario 
  if (isset($_POST['efectuar'])) {
    $Cod_Usuario = $_POST['idUsuario'];
    $rol = $_POST['rolUsuario'];
    $upd = 'UPDATE USUARIO SET ROL = 0, VALIDAR = "si" WHERE COD_USUARIO = "'.$Cod_Usuario.'" AND ROL = "'.$rol.'" AND VALIDAR = "no"';
    $result = $db->query($upd);

    //comprobar error
    if ($result) {
      echo "<script>alert('Administrador Efectuado con éxito')</script>";
    } else print_r($db->errorinfo());
  }

  header("Location: gestionUsuariosAdmin.php");
?>
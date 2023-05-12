<?php
    session_start();
    require_once('conexion.php');
    require_once('loginRequerido.php');
    require_once('verRol.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/selector.css">
  <title>Usuarios</title>
</head>
<body>
  <header></header>
  <section class="d-flex justify-content-center">
      <a href="gestionUsuariosAdmin.php" id="acceso_admin">
        Acceso Admin
        <img src="../images/admin1.jpg" alt="Admin1">
        <img src="../images/admin2.png" alt="Admin2">
      </a>

      <a href="editarPerfil.php" id="acceso_usuario">
        Acceso Usuario
        <img src="../images/usuario1 (2).jpg" alt="Usuario1">
        <img src="../images/usuario22.png" alt="Usuario2">
      </a>

      <!-- Si el usuario que hizo login no es administrador, se le oculta el campo de Acceso admin
      ya que no podra validar, rechazar o hacer admin a cualquier otro usuario -->
      <?php
        if($_SESSION['usuario_login']['ROL'] != 0){
          print '<script>
            document.getElementById("acceso_admin").style.display="none";
          </script>';
        }
      ?>
</section>
  <script type="text/javascript" src="..js/bootstrap.bundle.min.js"></script>
</body>
</html>
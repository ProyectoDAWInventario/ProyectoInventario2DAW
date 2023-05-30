<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
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
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../css/selector.css">
</head>
<body>
    <header class="header">
        <div class="contendor">
            <h1 class="titulo">GESTIÓN IES JULIO VERNE</h1>
        </div>
    </header>

    <section>

      <a href="../mantenimiento/php/funciones/rolApp.php" id="mantenimiento">
        Mantenimiento
        <img src="../images/Mantenimiento1.jpg" alt="Mantenimiento1">
        <img src="../images/mantenimiento2.png" alt="Mantenimiento2">
      </a>

      <a href="../inventario/index.php" id="inventario">
        Inventario
        <img src="../images/inventario1.jpg" alt="imagen Inventario1">
        <img src="../images/inventario2.png" alt="imagen Inventario2">
      </a>

      <a href="../gestion_practicas/index.html" id="practicas">
        Gestión de Prácticas
        <img src="../images/practicas1.jpg" alt="Imagen GestionPracticas1">
        <img src="../images/practicas2.png" alt="Imagen GestionPracticas2">
      </a>

      <a href="adminUsuario.php" id="usuarios">
        Gestión de Usuarios
        <img src="../images/usuario1.jpg" alt="Imagen GestionUsuarios1">
        <img src="../images/usuario2.png" alt="Imagen GestionUsuarios2">
      </a>
    </section>
    <?php
         if($_SESSION["usuario_login"]["ROL"] == 2){
          print '<script>
          document.getElementById("mantenimiento").style.display="block";
          document.getElementById("inventario").style.display="none";
          document.getElementById("practicas").style.display="none";
          document.getElementById("usuarios").style.display="block";
          </script>';
        }
      ?>
</body>
</html>
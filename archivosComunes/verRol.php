<?php
    require_once('conexion.php');
      try{
        $consultaRol = "SELECT ROL FROM usuario where Email = ?";
        $mostrarRol = $db->prepare($consultaRol);
         // Lo mismo, la sesion del email porque inicia con el email
         $mostrarRol->execute(array($_SESSION['usuario_login']['EMAIL']));
         // Recorremos las filas de la consulta
         foreach($mostrarRol as $rol){
          $_SESSION['ROL'] = $rol['ROL'];
          }
      }catch(PDOException $e){
        echo "Error con la base de datos: " . $e->getMessage();
      }
      echo $_SESSION['ROL'];
  ?>
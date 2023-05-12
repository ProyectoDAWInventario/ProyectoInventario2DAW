<?php
// LUIS ESTE ARCHIVO OBLIGA DIRECTAMENTE A INICIAR SESION, EN LOS DEMAS PHP CON LLAMAR A ESTE FICHERO CON: require_once('loginRequerido.php'); serviria
// Condicional en el que obliga al usuario a iniciar sesion para entrar a otros ficheros.
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../login.php?redirigido=true");
    }
?>
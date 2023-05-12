<?php
    session_start(); //Nos unimos a la sesion
    $_SESSION = array(); 
    session_destroy(); //elimiinamos la sesion
    header("Location: ../logpuente.php"); //volvemos a la pagina de login
?>
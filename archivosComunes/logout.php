<?php
    session_start(); // el script se une a la sesión

    /* para cerrar la sesión es necesario borrar todas las variables de la
    sesión, para ello se inicializa el array $_SESSION: */
    $_SESSION = array();
    /* además, se debe utilizar la función session_destroy(): */
    session_destroy();
    /* por último, se debe de eliminar la cookie: */
    setcookie(session_name(),"",time()-1000);
    // session_name devuelve el nombre de la sesión actual

    /* finalmente el script lleva d enuevo el login: */
    header("Location: ../login.php");
?>
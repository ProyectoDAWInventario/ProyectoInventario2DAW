<?php
    function controlarrol($rango){
        error_reporting(E_ALL ^ E_NOTICE);
        session_start();
        if($rango != $_SESSION["ROL"]){
            header("Location: ../../archivosComunes/selector.php");
        }
    }
?>
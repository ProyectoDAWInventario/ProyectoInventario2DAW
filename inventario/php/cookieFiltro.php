<?php
    session_start();
    require_once('../../archivosComunes/conexion.php');

    $filtro_departamento = $_POST['filtro_departamento'];

    if($_SESSION['usuario_login']['ROL'] == 0){
        if($_POST['filtro'] == "todos" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=todos");
        } else if($_POST['filtro'] == "todos" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=todos&codigo=".$filtro_departamento);
        } else if($_POST['filtro'] == "fungibles" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=fungibles");
        } else if($_POST['filtro'] == "fungibles" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=fungibles&codigo=".$filtro_departamento);
        } else if($_POST['filtro'] == "fungiblespedir" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=fungiblespedir");
        } else if($_POST['filtro'] == "fungiblespedir" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=fungiblespedir&codigo=".$filtro_departamento);
        } else if($_POST['filtro'] == "nofungibles" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=nofungibles");
        } else if($_POST['filtro'] == "nofungibles" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=nofungibles&codigo=".$filtro_departamento);
        } 
        
    } else if ($_SESSION['usuario_login']['ROL'] == 1) {
        if($_POST['filtro'] == "todos"){
            header("Location: lista.php?filtro=todos");
        } else if($_POST['filtro'] == "fungibles" ){
            header("Location: lista.php?filtro=fungibles");
        } else if($_POST['filtro'] == "fungiblespedir"){
            header("Location: lista.php?filtro=fungiblespedir");
        } else if($_POST['filtro'] == "nofungibles" ){
            header("Location: lista.php?filtro=nofungibles");
        } 
    }
    
?>
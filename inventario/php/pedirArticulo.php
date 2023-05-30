<?php
    require_once('../../archivosComunes/conexion.php');
    session_start();
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../login.php?redirigido=true");
    };
    $consulta = "SELECT * FROM fungible WHERE CODIGO = ?";
    $consulta = $db->prepare($consulta);
    $consulta->execute(array($_GET['cod']));
    foreach ($consulta as $key) {
        $pedir = $key['PEDIR'];
    }

    if ($pedir == 'no'){
        $query = "UPDATE fungible SET PEDIR = ? WHERE codigo = ?";
        $query = $db->prepare($query);
        $query->execute(array('si', $_GET['cod']));
    } else if ($pedir == 'si') {
        $query = "UPDATE fungible SET PEDIR = ? WHERE codigo = ?";
        $query = $db->prepare($query);
        $query->execute(array('no', $_GET['cod']));
    }

header ("Location: lista.php?pedir=".$pedir);
?>
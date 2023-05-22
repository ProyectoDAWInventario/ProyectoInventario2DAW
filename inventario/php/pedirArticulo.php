<?php
    require_once('../../archivosComunes/conexion.php');
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
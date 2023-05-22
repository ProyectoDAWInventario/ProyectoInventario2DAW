<?php
require_once('../../archivosComunes/conexion.php');

$filtro_departamento = $_POST['filtro_departamento'];

if ($filtro_departamento == "0") {
    header("Location: lista.php?filtro=todos");
    exit;
} else {
    $consulta = "SELECT a.* FROM articulo a
                INNER JOIN tiene t ON a.CODIGO = t.COD_ARTICULO
                INNER JOIN departamento d ON t.COD_DEPARTAMENTO = d.codigo
                WHERE d.codigo = :COD_DEPARTAMENTO";
    $pre = $db->prepare($consulta);
    $pre->bindParam(':COD_DEPARTAMENTO', $filtro_departamento, PDO::PARAM_INT);
    $pre->execute();
    $resultado = $pre->fetchAll();

    // if (count($resultado) == 0) {
    //     echo "No se encontraron artículos para el departamento seleccionado.";
    //     exit;
    // } else {
        header("Location: lista.php?filtro=departamento&codigo=$filtro_departamento");
    //     exit;
    // }
}
?>
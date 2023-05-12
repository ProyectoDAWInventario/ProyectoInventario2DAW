<?php
$db = require_once('conexion.php');

//Hago una consulta a la base de datos para obtener la informacion del articulo seleccionado
$query = 'select * from articulo where CODIGO = ' . $_GET["cod"];
$articulos = $db->query($query);
foreach ($articulos as $articulo) {
    $codigo = $articulo["CODIGO"];
    $nombre = $articulo['NOMBRE'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Borrado</title>
</head>
<body>
<?php
    echo "<h3>¿Estás seguro de eliminar el articulo: " . $nombre . " ?</h3>";  
    echo '<a href="borrarMaterial.php?cod='.$codigo.'">Borrar definitivamente</a>';
    echo '<a href="lista.php">Volver atrás</a>';  
?>
</body>
</html>
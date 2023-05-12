<?php
    require_once("conexion.php");

    $consulta = 'SELECT * FROM usuario WHERE COD_USUARIO = '.$_GET["cod"].';';
    $usuario = $db->query($consulta);
    $usuario = $usuario->fetch();

    if($usuario['EMAIL'] == 'incidencias@iesbargas.com') {
        print('<script>
            alert("Este usuario no se puede eliminar");
        </script>');
    } else {
        $consulta2 = 'DELETE FROM usuario WHERE COD_USUARIO = '.$_GET["cod"].';';
        $borrar = $db->query($consulta2);
    }

    header("Location: editarPerfil.php");

?>
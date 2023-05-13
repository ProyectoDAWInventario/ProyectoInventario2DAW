<?php
    if($_POST['filtro'] == "todos"){
        header("Location: lista.php?filtro=todos");
    } else if($_POST['filtro'] == "fungibles") {
        header("Location: lista.php?filtro=fungibles");
    } else {
        header("Location: lista.php?filtro=nofungibles");
    }
?>
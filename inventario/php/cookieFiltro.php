<?php
    if($_POST['filtro'] == "todos"){
        header("Location: lista.php?filtro=todos");
    } else if($_POST['filtro'] == "fungibles") {
        header("Location: lista.php?filtro=fungibles");
    } else if ($_POST['filtro'] == "nofungibles") {
        header("Location: lista.php?filtro=nofungibles");
    } else {
        header("Location: lista.php");
    }
?>
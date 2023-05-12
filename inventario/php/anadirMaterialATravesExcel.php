<?php
require_once "interpretarExcel.php";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["btn-cargar"]) && isset($_FILES["fichero"]) && !empty($_FILES['fichero']['tmp_name'])) {
        $excelFile = $_FILES["fichero"]["tmp_name"];

        header("Location: lista.php");
        if (!validarExcel($excelFile)) {
            echo 'error';
        } else {
            interpretarExcel($excelFile);            
            exit();
        }
        
    } else {
        header("Location: cargarExcel.php");
    }
    
}
?>
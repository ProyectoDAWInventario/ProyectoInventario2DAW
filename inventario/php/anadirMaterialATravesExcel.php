<?php
require_once "interpretarExcel.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../../login.php?redirigido=true");
};

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
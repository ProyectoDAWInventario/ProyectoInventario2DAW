<?php
session_start();
if(!isset($_SESSION["usuario_login"])){
	header("Location: ../../login.php?redirigido=true");
};
require_once "interpretarExcel.php";
//Indicamos el fichero excel que vamos abrir
$defaultFileName = '../../excel/Inventario-informatica.xlsx';
interpretarExcel($defaultFileName)
?>
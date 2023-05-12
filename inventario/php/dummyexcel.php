<?php
require_once "interpretarExcel.php";
//Indicamos el fichero excel que vamos abrir
$defaultFileName = '../../excel/Inventario-informatica.xlsx';
interpretarExcel($defaultFileName)
?>
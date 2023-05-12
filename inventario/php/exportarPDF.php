<?php

require_once('../../vendor/autoload.php');
require_once('../../archivosComunes/conexion.php');

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
// Cogemos el contenido del css que deseamos poner a la tabla
$stylesheet = file_get_contents('../css/tablaPDF.css');
// Insertamos la linea de css en nuestro PDF
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

$mpdf->WriteHTML('<h1>ARTICULOS NO FUNGIBLES</h1>');
$mpdf->WriteHTML('<table>
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Fecha Alta</th>
                            <th scope="col">Número de Serie</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Unidades</th>
                            <th scope="col">Localización</th>
                            <th scope="col">Procedencia</th>
                            <th scope="col">Motivo de baja</th>
                            <th scope="col">Fecha de baja</th>
                        </tr>
                    </thead>
                    <tbody>');

    $sql = "SELECT * FROM articulo;";
    //Preparo la consulta
    $preparada = $db->prepare($sql);
    $preparada->execute();
    $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultados as $row){
        $mpdf->WriteHTML('<tr><td>'. $row["CODIGO"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["FECHA_ALTA"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["NUM_SERIE"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["NOMBRE"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["DESCRIPCION"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["UNIDADES"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["LOCALIZACION"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["PROCEDENCIA_ENTRADA"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["MOTIVO_BAJA"] .'</td>');
        $mpdf->WriteHTML('<td>'. $row["FECHA_BAJA"] .'</td></tr>');
        
    }
$mpdf->WriteHTML('</tbody>
                </table>');
// PRIMER PARAMETRO: nombre que se dara al fichero al darle a guardar por defecto
// SEGUNDO PARAMETRO: accion que realiza al pulsar el boton
//      - I -> abre el pdf en otra pestaña con la opcion de descargarlo
//      - D -> descarga el pdf directamente sin mostrarle
//      - F -> guarda el fichero en local
$mpdf->Output('articulos.pdf', 'I');
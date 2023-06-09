<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Articulos No Fungibles</title>
</head>
<body>
<?php

    // INSTALAR composer require mdpf/mdpf
    session_start();
    require_once('../../vendor/autoload.php');
    require_once('../../archivosComunes/conexion.php');
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../login.php?redirigido=true");
    };
    

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
    // Cogemos el contenido del css que deseamos poner a la tabla
    $stylesheet = file_get_contents('../css/tablaPDF.css');
    // Insertamos la linea de css en nuestro PDF
    $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    if($_SESSION['usuario_login']['ROL'] == 0){
    // Obtenemos el nombre del departamento
    $departamento = '';
    if (isset($_GET['codDepartamento']) && $_GET['codDepartamento'] !== "todos") {
        $codDepartamento = $_GET['codDepartamento'];
        $query = 'SELECT NOMBRE FROM departamento WHERE CODIGO = ?';
        $pre = $db->prepare($query);
        $pre->execute([$codDepartamento]);
        $departamento = $pre->fetchColumn();
    }

    $titulo = 'ARTICULOS NO FUNGIBLES';
    if (!empty($departamento)) {
        $titulo .= ' DEL ' . $departamento;
    }
    $titulo = 'ARTICULOS NO FUNGIBLES';
    }
    else if($_SESSION['usuario_login']['ROL'] == 1) {
        $titulo = 'ARTICULOS NO FUNGIBLES';
        $codigoDepartamento = $_SESSION['usuario_login']['DEPARTAMENTO'];
        $query = 'SELECT NOMBRE FROM departamento WHERE CODIGO = ?';
        $pre = $db->prepare($query);
        $pre->execute([$codigoDepartamento]);
        $departamento = $pre->fetchColumn();
    } else {
        $titulo = 'ARTICULOS NO FUNGIBLES';
        $departamento = '';
        if (isset($_GET['codDepartamento']) && $_GET['codDepartamento'] !== "todos") {
            $codDepartamento = $_GET['codDepartamento'];
            $query = 'SELECT NOMBRE FROM departamento WHERE CODIGO = ?';
            $pre = $db->prepare($query);
            $pre->execute([$codDepartamento]);
            $departamento = $pre->fetchColumn();
        }
    }

    if (!empty($departamento)) {
        $titulo .= ' DEL ' .  mb_strtoupper($departamento);
    }

    $mpdf->WriteHTML('<h1>' . $titulo . '</h1>');

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

        // $mes_Actual = date('m');
        // $año_Actual = date('Y');

        // if($mes_Actual >= 9 && $mes_Actual <= 12){
        //     $fecha_inicio = $año_Actual.'-09-01';
        //     $fecha_fin = ($año_Actual+1).'-08-31';
        // } else if ($mes_Actual <= 8 && $mes_Actual > 0){
        //     $fecha_inicio = ($año_Actual-1).'-09-01';
        //     $fecha_fin = $año_Actual.'-08-31';
        // }
        
        // consulta principal
        // $consulta = 'SELECT * FROM articulo WHERE fecha_alta BETWEEN ? AND ?';
        if($_SESSION['usuario_login']['ROL'] == 0){
            if($_GET['codDepartamento'] == "todos") {
                $consulta = 'SELECT a.CODIGO, d.NOMBRE, a.FECHA_ALTA, a.NUM_SERIE, a.NOMBRE, a.DESCRIPCION, a.UNIDADES, a.LOCALIZACION, a.PROCEDENCIA_ENTRADA, a.MOTIVO_BAJA, a.FECHA_BAJA 
                FROM departamento d, articulo a, tiene t, NoFungible nf 
                WHERE d.CODIGO = t.COD_DEPARTAMENTO 
                AND t.COD_ARTICULO = a.CODIGO 
                AND a.CODIGO = nf.CODIGO;';    
            } else {
                $departamento = $_GET['codDepartamento'];
                $consulta = "SELECT a.CODIGO, d.NOMBRE, a.FECHA_ALTA, a.NUM_SERIE, a.NOMBRE, a.DESCRIPCION, a.UNIDADES, a.LOCALIZACION, a.PROCEDENCIA_ENTRADA, a.MOTIVO_BAJA, a.FECHA_BAJA 
                FROM departamento d, articulo a, tiene t, nofungible nf 
                WHERE d.CODIGO = t.COD_DEPARTAMENTO 
                AND t.COD_ARTICULO = a.CODIGO 
                AND a.CODIGO = nf.CODIGO
                AND t.COD_DEPARTAMENTO = $departamento;";
            }
        } else if ($_SESSION['usuario_login']['ROL'] == 1) {
            $departamento = $_SESSION['usuario_login']['DEPARTAMENTO'];
            $consulta = "SELECT a.CODIGO, d.NOMBRE, a.FECHA_ALTA, a.NUM_SERIE, a.NOMBRE, a.DESCRIPCION, a.UNIDADES, a.LOCALIZACION, a.PROCEDENCIA_ENTRADA, a.MOTIVO_BAJA, a.FECHA_BAJA 
            FROM departamento d, articulo a, tiene t, nofungible nf 
            WHERE d.CODIGO = t.COD_DEPARTAMENTO 
            AND t.COD_ARTICULO = a.CODIGO 
            AND a.CODIGO = nf.CODIGO
            AND t.COD_DEPARTAMENTO = $departamento;";
        }
        
        //Preparo la consulta
        $preparada = $db->prepare($consulta);
        $preparada->execute(array());
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
?>
</body>
</html>
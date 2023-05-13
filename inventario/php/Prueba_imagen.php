<?php

    function anadir_img($nombre, $numero, $descripcion, $localizacion, 
    $unidades, $procedencia, $motivo_bj, $fecha_bj, $img){

        
    	require "./conexion.php";

        try {
            $db = new PDO($conexion, $usuario, $contrasena);
            $datos = $db->prepare("INSERT INTO articulo (FECHA_ALTA, NUM_SERIE, NOMBRE, DESCRIPCION, UNIDADES, 
           	LOCALIZACION, PROCEDENCIA_ENTRADA, MOTIVO_BAJA, FECHA_BAJA, RUTA_IMAGEN) VALUES     (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $datos->bindParam(1, $numero);
            $datos->bindParam(2, $nombre);
            $datos->bindParam(3, $descripcion);
            $datos->bindParam(4, $unidades);
            $datos->bindParam(5, $localizacion);
            $datos->bindParam(6, $procedencia);
            $datos->bindParam(7, $motivo_bj);
            $datos->bindParam(8, $fecha_bj);
            $datos->bindParam(9, $img, PDO::PARAM_LOB);
            $datos->execute();
            $db = null;
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    function actualizarDatos($nombre, $descripcion, $localizacion, $motivo_bj, $numero, $unidades, $fecha_bj, $img, $codigo){
        require "./conexion.php";
        $db = new PDO($conexion, $usuario, $contrasena);
        $updateQuery = $db->prepare("UPDATE articulo SET NOMBRE = ?, NUM_SERIE = ?, DESCRIPCION = ?, LOCALIZACION = ?, MOTIVO_BAJA = ?, UNIDADES = ?, FECHA_BAJA = ?, RUTA_IMAGEN = ? WHERE CODIGO = ?;");
        $updateQuery->bindParam(1, $nombre);
        $updateQuery->bindParam(2, $numero);
        $updateQuery->bindParam(3, $descripcion);
        $updateQuery->bindParam(4, $localizacion);
        $updateQuery->bindParam(5, $motivo_bj);
        $updateQuery->bindParam(6, $unidades);
        $updateQuery->bindParam(7, $fecha_bj);
        $updateQuery->bindParam(8, $img, PDO::PARAM_LOB);
        $updateQuery->bindParam(9, $codigo);
        $updateQuery->execute();
    }

    function actualizarDatos2($nombre, $descripcion, $localizacion, $motivo_bj, $numero, $unidades, $fecha_bj, $codigo){
        require "./conexion.php";
        $db = new PDO($conexion, $usuario, $contrasena);
        $updateQuery = $db->prepare("UPDATE articulo SET NOMBRE = ?, NUM_SERIE = ?, DESCRIPCION = ?, LOCALIZACION = ?, MOTIVO_BAJA = ?, UNIDADES = ?, FECHA_BAJA = ? WHERE CODIGO = ?;");
        $updateQuery->bindParam(1, $nombre);
        $updateQuery->bindParam(2, $numero);
        $updateQuery->bindParam(3, $descripcion);
        $updateQuery->bindParam(4, $localizacion);
        $updateQuery->bindParam(5, $motivo_bj);
        $updateQuery->bindParam(6, $unidades);
        $updateQuery->bindParam(7, $fecha_bj);
        $updateQuery->bindParam(8, $codigo);
        $updateQuery->execute();
    }

    function consultarDatos($consulta){
        require "./conexion.php";
        try {
            $db = new PDO($conexion, $usuario, $contrasena);
            // $sql = "SELECT * FROM articulo;";
            //Preparo la consulta
            $preparada = $db->prepare($consulta);
            $preparada->execute();

            /*Utilizamos el método fetchAll() para obtener todos los
            resultados de la consulta como un arreglo. 
            Después, se recorre el arreglo utilizando el foreach
            para mostrar los resultados en forma de imágenes. 
            
            PDO::FETCH_ASSOC se pueden obtener los resultados de la 
            consulta de manera más legible y fácil de manejar*/
            $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultados as $row){
                
                echo "<tr>
                <th scope=\"row\">";
                ?>
                    <!-- Condicional para que cuando no tenga imagen no se pase de binario a foto -->
                    <?php
                        if($row['RUTA_IMAGEN'] != NULL){
                    ?>
                            <img src=data:image/jpg;base64,<?php echo base64_encode($row["RUTA_IMAGEN"])?>  style="width: 50px;"/>
                    <?php
                        }
                    ?>
                   
                <?php 
                echo "</th>
                <td>". $row["CODIGO"] ."</td>
                <td>". $row["FECHA_ALTA"] ."</td>
                <td>". $row["NUM_SERIE"] ."</td>
                <td>". $row["NOMBRE"] ."</td>
                <td>". $row["DESCRIPCION"] ."</td>
                <td>". $row["UNIDADES"] ."</td>
                <td>". $row["LOCALIZACION"] ."</td>
                <td>". $row["PROCEDENCIA_ENTRADA"] ."</td>
                <td>". $row["MOTIVO_BAJA"] ."</td>
                <td>". $row["FECHA_BAJA"] ."</td>";
                echo '<td><a href="editarMaterial.php?cod='.$row["CODIGO"].'" class="text-decoration-none p-1"><i class="bi bi-pencil-square"></i></a></td>
                <td><a href="confirmarDelete.php?cod='.$row["CODIGO"].'" class="text-decoration-none p-1"><i class="bi bi-trash3"></i></a></td>
                </tr>';
            }
            return TRUE;
        } catch (PDOException $e) {
            echo "Error en la base de datos " . $e->getMessage();
            return FALSE;
        }
    }
?>

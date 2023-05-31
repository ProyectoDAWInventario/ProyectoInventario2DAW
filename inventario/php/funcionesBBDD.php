<?php

    function anadir_img($nombre, $numero, $descripcion, $localizacion, $unidades, $procedencia, $motivo_bj, $fecha_bj, $img){

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
    
    function actualizarDatos($nombre, $descripcion, $localizacion, $motivo_bj, $numero, $unidades, $fecha_bj, $img, $codigo, $procedencia, $departamento){
        require "./conexion.php";
        $db = new PDO($conexion, $usuario, $contrasena);
        $updateQuery = $db->prepare("UPDATE articulo SET NOMBRE = ?, NUM_SERIE = ?, DESCRIPCION = ?, LOCALIZACION = ?, MOTIVO_BAJA = ?, UNIDADES = ?, FECHA_BAJA = ?, RUTA_IMAGEN = ?, PROCEDENCIA_ENTRADA = ?,  WHERE CODIGO = ?;");
        $updateQuery->bindParam(1, $nombre);
        $updateQuery->bindParam(2, $numero);
        $updateQuery->bindParam(3, $descripcion);
        $updateQuery->bindParam(4, $localizacion);
        $updateQuery->bindParam(5, $motivo_bj);
        $updateQuery->bindParam(6, $unidades);
        $updateQuery->bindParam(7, $fecha_bj);
        $updateQuery->bindParam(8, $img, PDO::PARAM_LOB);
        $updateQuery->bindParam(9, $procedencia);
        $updateQuery->bindParam(10, $codigo);
        $updateQuery->execute();

        $queryDepartamento = $db->prepare("select * from DEPARTAMENTO where NOMBRE = ?");
        $queryDepartamento->execute(array($departamento));

        foreach ($queryDepartamento as $codigoDept) {
            $updateDepartamento = $db->prepare("UPDATE tiene SET COD_DEPARTAMENTO = ? WHERE COD_ARTICULO = ?");
            $updateDepartamento->bindParam(1, $codigoDept['codigo']);
            $updateDepartamento->bindParam(2, $codigo);
            $updateDepartamento->execute();
        }
    }

    function actualizarDatos2($nombre, $descripcion, $localizacion, $motivo_bj, $numero, $unidades, $fecha_bj, $codigo, $procedencia, $departamento){
        require "./conexion.php";
        $db = new PDO($conexion, $usuario, $contrasena);
        $updateQuery = $db->prepare("UPDATE articulo SET NOMBRE = ?, NUM_SERIE = ?, DESCRIPCION = ?, LOCALIZACION = ?, MOTIVO_BAJA = ?, UNIDADES = ?, FECHA_BAJA = ?, PROCEDENCIA_ENTRADA = ? WHERE CODIGO = ?;");
        $updateQuery->bindParam(1, $nombre);
        $updateQuery->bindParam(2, $numero);
        $updateQuery->bindParam(3, $descripcion);
        $updateQuery->bindParam(4, $localizacion);
        $updateQuery->bindParam(5, $motivo_bj);
        $updateQuery->bindParam(6, $unidades);
        $updateQuery->bindParam(7, $fecha_bj);
        $updateQuery->bindParam(8, $procedencia);
        $updateQuery->bindParam(9, $codigo);
        $updateQuery->execute();

        $queryDepartamento = $db->prepare("select * from DEPARTAMENTO where NOMBRE = ?");
        $queryDepartamento->execute(array($departamento));

        foreach ($queryDepartamento as $codigoDept) {
            $updateDepartamento = $db->prepare("UPDATE tiene SET COD_DEPARTAMENTO = ? WHERE COD_ARTICULO = ?");
            $updateDepartamento->bindParam(1, $codigoDept['codigo']);
            $updateDepartamento->bindParam(2, $codigo);
            $updateDepartamento->execute();
        }
    }

    function consultarDatos($consulta,$numeroPagina=0){
        require "./conexion.php";
        try {
            $db = new PDO($conexion, $usuario, $contrasena);
        
            $itemsPagina = 10;
            $consultaFinal=$consulta. ' LIMIT '.$itemsPagina.' OFFSET ' . $numeroPagina * $itemsPagina;
           
            // $sql = "SELECT * FROM articulo;";
            //Preparo la consulta
            $preparada = $db->prepare($consultaFinal);
            $preparada->execute();
            
            /*Utilizamos el método fetchAll() para obtener todos los
            resultados de la consulta como un arreglo. 
            Después, se recorre el arreglo utilizando el foreach
            para mostrar los resultados en forma de imágenes. 
            
            PDO::FETCH_ASSOC se pueden obtener los resultados de la 
            consulta de manera más legible y fácil de manejar*/
            $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);
            $preparada->closeCursor();

            $hayResultados = !empty($resultados); // Variable para verificar si hay resultados

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
                echo '<td>
                        <a href="editarMaterial.php?cod='.$row["CODIGO"].'" class="text-decoration-none p-1"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    <td>
                        <a href="confirmarDelete.php?cod='.$row["CODIGO"].'" class="text-decoration-none p-1"><i class="bi bi-trash3"></i></a>
                    </td>';
                    // FUNCIÓN PARA PONER ICONO DE PEDIR O NO PEDIR
                    // SOLO PARA ARTICULOS FUNGIBLES
                    $consulta = "SELECT articulo.CODIGO FROM articulo INNER JOIN fungible WHERE articulo.CODIGO = fungible.CODIGO;";
                    $consulta = $db->query($consulta);
                    foreach ($consulta as $row01) {
                        if($row01['CODIGO'] == $row['CODIGO']) {
                            // CONSULTA PARA SABER SI EN LA BASE DE DATOS ESTA PEDIR A SI O PEDIR A NO
                            $consulta = "SELECT * FROM fungible WHERE CODIGO = ?";
                            $consulta = $db->prepare($consulta);
                            $consulta->execute(array($row01['CODIGO']));
                            foreach ($consulta as $key) {
                                $pedir = $key['PEDIR'];
                            }
                            // SI EN LA BASE DE DATOS SE ENCUENTRA EN NO SE PONDRA EL ICONO DE NO PEDIDO
                            if($pedir == 'no') {
                                echo '<td>
                                    <a href="pedirArticulo.php?cod='.$row01['CODIGO'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue;" id="nopedido" name="nopedido"><i class="bi bi-cart-dash"></i></a>
                                    <a href="pedirArticulo.php?cod='.$row01['CODIGO'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue; display: none;" id="pedido" name="pedido"><i class="bi bi-cart-check"></i></a>';
                                echo '</td>'; 
                            // SI EN LA BASE DE DATOS SE ENCUENTRA EN SI SE PONDRA EL ICONO DE PEDIDO
                            } else if ($pedir == 'si') {
                                echo '<td>
                                    <a href="pedirArticulo.php?cod='.$row01['CODIGO'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue; display: none;" id="nopedido" name="nopedido"><i class="bi bi-cart-dash"></i></a>
                                    <a href="pedirArticulo.php?cod='.$row01['CODIGO'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue; " id="pedido" name="pedido"><i class="bi bi-cart-check"></i></a>';
                                echo '</td>'; 
                            }
                            
                        }
                    }

                    // SI SE ENCUENTRA INICIALIZADO A TRAVES DEL METODO GET 'PEDIR' Y A LA VEZ ES IGUAL A NO
                    // EL ICONO DE NO PEDIDO DESAPARECE Y EL DE PEDIDO APARECE
                    if(isset($_GET['pedir']) && $_GET['pedir'] == 'no') {
                    ?>
                        <script type='text/javascript'> 
                            document.getElementById('nopedido').style.display = 'none';
                            document.getElementById('pedido').style.display = 'block';
                        </script>
                    <?php
                    // SI SE ENCUENTRA INICIALIZADO A TRAVES DEL METODO GET 'PEDIR' Y A LA VEZ ES IGUAL A SI
                    // EL ICONO DE NO PEDIDO APARECE Y EL DE PEDIDO DESAPARECE
                    } else if (isset($_GET['pedir']) && $_GET['pedir'] == 'si') {
                    ?>
                        <script type='text/javascript'> 
                            document.getElementById('nopedido').style.display = 'block';
                            document.getElementById('pedido').style.display = 'none';
                        </script>
                    <?php
                    }
                echo '</tr>';
                
            }
            // echo $count;
            // echo $numeroPagina;

            if (!$hayResultados) {
                echo '
                    <tr>
                        <td colspan="13">
                            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    No se encontró ningún resultado
                                </div>
                            </div>
                        </td>
                    </tr>
                ';
            }
          
            return TRUE;
        } catch (PDOException $e) {
            echo "Error en la base de datos " . $e->getMessage();
            return FALSE;
        }
    }
    
    function pintarPaginador($consultaCount,$filtro,$numeroPagina=0,$dpto_seleccionado=0){
        require "./conexion.php";
        try {
            $db = new PDO($conexion, $usuario, $contrasena);
            $preparadaCount = $db->prepare($consultaCount);
            $preparadaCount->execute();
            $count=0;

            // $preparadaCount->bindParam(':cuenta',$count);
            if($preparadaCount->rowCount() > 0) {
                
                $count = $preparadaCount->fetch()[0];
            }
            
            $preparadaCount->closeCursor();
            $itemsPagina = 10;
            $page_count = ($count -1)/$itemsPagina;
            echo '<div class="block-27" style="margin-top: 50px; margin-bottom: 50px; display: flex; justify-content: center;">
                <ul class="pagination" id="paginador" style="padding: 0; margin: 0;">';

             for ($i = 0; $i < $page_count; $i++) {

                if ($i == $numeroPagina) { // esta es la pagina actual
                    if($dpto_seleccionado != 0) {
                        echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a  href="lista.php?filtro='.$filtro.'&codigo='.$dpto_seleccionado.'&page=' . ($i) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                            display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                                display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                                box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">'.($i+1).'</span></a></li>';
                    } else {
                    echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a  href="lista.php?filtro='.$filtro.'&page=' . ($i) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                            display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                                display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                                box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">'.($i+1).'</span></a></li>';
                    }
                } else { // mostrar enlace a otra página
                    if($dpto_seleccionado != 0){
                    echo '<li style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a href="lista.php?filtro='.$filtro.'&codigo='.$dpto_seleccionado.'&page=' .($i) . '" class="page_link" style="text-align: center;
                            margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">'.($i+1).'</span>
                            </a>
                        </li>';
                    } else {
                        echo '<li style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a href="lista.php?filtro='.$filtro.'&page=' .($i) . '" class="page_link" style="text-align: center;
                            margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">'.($i+1).'</span>
                            </a>
                        </li>';
                    }
                    // echo '<a href="lista.php?filtro='.$filtro.'&page=' . $i . '">Page ' . $i . '</a><br>';
                }
             }

             echo '</ul> <div>';

            return TRUE;
        } catch (PDOException $e) {
            echo "Error en la base de datos " . $e->getMessage();
            return FALSE;
        }
    }
?>




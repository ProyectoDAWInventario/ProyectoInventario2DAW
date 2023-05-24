<?php
    session_start(); 

    //Si ha accedido directamente sin pasar por el login le redirigimos
    require_once('../../archivosComunes/loginRequerido.php');
    require_once('../../archivosComunes/conexion.php');
    if(isset($_POST['boton_buscar'])){
        $buscar = $_POST["buscar"];
        $codigo = array();
        $consultaBuscar = "SELECT * FROM articulo WHERE NOMBRE LIKE '%".$buscar."%' OR DESCRIPCION LIKE '%".$buscar."%'";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador Inventario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../inventario/css/index.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
		.gradient-custom {
			/* fallback for old browsers */
			background: #6a11cb;

			/* Chrome 10-25, Safari 5.1-6 */
			background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

			/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
		}

		html {
			min-height: 100%;
			position: relative;
			box-sizing: border-box;
		}

		footer {
			position: absolute;
			bottom: 0;
			width: 100%;
		}

		.shadow-blue {
			box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2) !important;
		}

		.row {
			padding: 40px;
		}

		footer {
			font-size: 20px;
		}

		ul{
			list-style: none;
		}

		input#aplicar_filtros{
			margin-left: 30px;
		}

		fieldset{
			margin-top: 20px;
			font-weight: bold;
		}

		@media screen and (max-width: 768px) {
			.texto-footer {
				font-size: 16px;
			}

			/* .texto-table {
				font-size: 16px;
			} */
		}		
	</style>
</head>
<body>
    <header class="gradient-custom">
        <nav class="navbar navbar-expand-md navbar-light p-3 ms-4 me-4">
            <a class="navbar-brand text-light" href="../index.html">Inventario</a>
            <form class="d-flex justify-content-center flex-grow-1 w-25" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input class="form-control me-2 w-25" type="search" id="buscar" name="buscar" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-light" type="submit" id="boton_buscar" name="boton_buscar"><i class="bi bi-search"></i></button>
            </form>
            <ul class="navbar-nav flex-row flex-wrap text-light ms-auto">
                <li class="nav-item dropdown">
                    <i id="iniciar_sesion" class="bi bi-person nav-link dropdown text-light" role="button" data-bs-toggle="dropdown" style="text-align: right;"> Mi cuenta</i>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="../../archivosComunes/adminUsuario.php">Gestionar cuenta</a>
                        <a class="dropdown-item" href="../../archivosComunes/logout.php">Cerrar sesión</a>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div>
		<form method="post" action="cookieFiltro.php">
			<fieldset name="filtro" id="filtro">
				<ul>
					<li>
						<input type="radio" name="filtro" value="todos"> TODOS
					</li>
					<li>
						<input type="radio" name="filtro" value="fungibles"> FUNGIBLES
					</li>
					<li>
						<input type="radio" name="filtro" value="nofungibles"> NO FUNGIBLES
					</li>
				</ul>
				
				<input class="btn gradient-custom shadow" style="color: white" name="aplicar_filtros" id="aplicar_filtros" type="submit" value="Aplicar filtro">
			</fieldset>
		</form>
		<br>
		<?php
			if($_SESSION['usuario_login']['ROL'] == 0){
		?>
		<form method="post" action="filtroAdmin.php">
			<select class="form-control" id="filtro_departamento" name="filtro_departamento">
				<option value="0">Todos</option>
				<?php 
				require_once('../../archivosComunes/conexion.php');
				$consulta = "SELECT * FROM departamento";
				$resultado = $db->query($consulta);

				foreach ($resultado as $row) {
					echo '<option value="'.$row['codigo'].'">'.$row['NOMBRE'].'</option>';
				}
				?>
			</select>
			<input type="submit" value="Filtrar">
			<?php
				if(isset($_GET['codigo'])){
			?>
			<input type="hidden" name="filtro_dpto" id="filtro_dpto" value="<?php echo $_GET['codigo'] ?>">
			<?php } ?>
		</form><br>
		<?php } ?>		

	</div>
    <div class="container-fluid" style="padding-bottom: 150px;" id="tablaArticulos">
		<div class="table-responsive ">
			<table class="table p-4 m-4">
				<thead>
					<tr class="texto-table">
						<th scope="col">Imagen</th>
						<th scope="col">Codigo</th>
						<th scope="col">Fecha Alta</th>
						<th scope="col">Número de Serie</th>
						<th scope="col">Nombre</th>
						<th scope="col">Descripción</th>
						<th scope="col">Unidades</th>
						<th scope="col">Localización</th>
						<th scope="col">Procedencia</th>
						<th scope="col">Motivo baja</th>
						<th scope="col">Fecha baja</th>
						<th scope="col">
							<?php
								if($_SESSION['usuario_login']['ROL'] == 0){
							?>
							<a href='exportarPDF.php?codDepartamento=<?php if(isset($_GET['codigo'])){echo $_GET['codigo']; } else { echo "todos"; } ?>' target="_blank">
								<!-- <i class="bi bi-box-arrow-in-down"></i> -->
								<i class="bi bi-filetype-pdf"></i>
							</a>
							<?php 
								} else if($_SESSION['usuario_login']['ROL'] == 1){
							?>
							<a href='exportarPDF.php' target="_blank">
								<!-- <i class="bi bi-box-arrow-in-down"></i> -->
								<i class="bi bi-filetype-pdf"></i>
							</a>
							<?php 
								} 
							?>
						</th>
					</tr>
				</thead>
				<tbody id="tbodyy">
					<?php

                        require "./conexion.php";
                        try {
                            $preparada = $db->prepare($consultaBuscar);
                            $preparada->execute();
                            
                            $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);
                            $preparada->closeCursor();

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
                        
                            return TRUE;
                        } catch (PDOException $e) {
                            echo "Error en la base de datos " . $e->getMessage();
                            return FALSE;
                        }

                    ?>
				</tbody>
			</table>
		</div>
	</div>

    <footer class="gradient-custom p-3 ">
        <nav class="navbar navbar-expand-md navbar-light text-light d-flex justify-content-center mt-0">
            <div class="texto-footer" style="text-align:center;">IES JULIO VERNE Curso(2022-2023)<br> Creado por Brenda, Daniel, Javier, Nerea y Raúl  &#169;</div>
        </nav>
    </footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	<script src="../js/exportarPDF.js"></script>
	<script src="../js/html2pdf.bundle.min.js"></script>
</body>
</html>
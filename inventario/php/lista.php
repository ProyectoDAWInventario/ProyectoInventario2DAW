<?php
    session_start(); 
	if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../login.php?redirigido=true");
    };
    require_once('../../archivosComunes/conexion.php');
    if(isset($_POST['boton_buscar'])){
        $buscar = $_POST["buscar"];
        $codigo = array();
        $consultaBuscar = "SELECT * FROM articulo WHERE NOMBRE LIKE '%".$buscar."%' OR DESCRIPCION LIKE '%".$buscar."%'";
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inventario con Bootstrap</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<!-- <link rel="stylesheet" type="text/css" href="../inventario/css/index.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	
	<style>
        
        .form-label {
            margin-bottom: 0;
            margin-top: 10px;
        }

        input {
            margin-top: 0;
        }

        .shadow-blue {
            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2) !important;
        }

        input[type="file"]::-webkit-file-upload-button {
            background-color: #0d6efd;
            color: white;

        }

        input[type="file"]:hover {
            color: #0d6efd !important;
            background-color: white;
        }

        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        .btn {
            width: 100px;
            height: 40px;
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
            font-size: 20px;
        }
		.container-fluid{
			padding: 0px!important;
		}

        .main-content {
            min-height: calc(100vh - 100px);
            /* Resta el tamaño del footer al alto total de la ventana */
            padding-bottom: 100px;
            /* Asegura que el contenido no tape con el footer */
        }

        .main-form {
        min-height: calc(100vh - 180px); /* Resta el tamaño del footer al alto total de la ventana */
        }

		form fieldset {
			display: flex;
		}

		form fieldset ul{
			list-style: none;
			display: flex;
		}

		form fieldset select {
			height: 40px;
			margin-top: 10px;
		}

		form fieldset ul li {
			margin-right: 10px;
			margin-top: 20px;
		}

		form fieldset .btn {
			margin-left: 10px;
			margin-top: 10px;
		}

		.buscador input {
			width: 600px;
		}

		footer .row {
            padding: 0;
        }
        footer p {
            margin-bottom: 0;
        }

        @media screen and (max-width: 768px) {
            .texto-footer {
                font-size: 14px;
            }

			.btn-container {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .btn-container .btn {
                margin-bottom: 10px;
                width: 100%;
            }

			.main-form{
				padding-bottom: 100px;
			}
        }

        
    </style>
</head>

<body>
<header class="gradient-custom">
	<nav class="navbar navbar-expand navbar-light p-3 ms-4 me-4">
		<a class="navbar-brand text-light" href="../index.php">Inventario</a>
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


	<!-- cuerpo -->
	<div class="container-fluid main-content ">
		<!-- filtros -->
		<div class="main-form">
					<form method="post" action="cookieFiltro.php">
	
						<fieldset name="filtro" id="filtro">
						<div class="row w-75">
							<div class="col-md-6">		
								<!-- FILTRO FUNGIBLE -->
								<ul>
									<li>
										<input type="radio" name="filtro" value="todos" <?php if(!isset($_GET['filtro']) || (isset($_GET['filtro']) && $_GET['filtro'] == "todos")) echo 'checked'; ?>> Todos
									</li>
									<li>
										<input type="radio" name="filtro" value="fungibles" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "fungibles") echo 'checked'; ?>> Fungibles
									</li>
									<li>
										<input type="radio" name="filtro" value="fungiblespedir" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "fungiblespedir") echo 'checked'; ?>> Pedir Fungibles
									</li>
									<li>
										<input type="radio" name="filtro" value="nofungibles" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "nofungibles") echo 'checked'; ?>> No Fungibles
									</li>
								</ul>
								
							</div>
							<div class="col-md-6 d-flex align-items-center">		
								<!-- FILTRO DEPARTAMENTO -->
								<?php
									// session_start();
									if($_SESSION['usuario_login']['ROL'] == 0){
								?>
									<select class="form-control" id="filtro_departamento" name="filtro_departamento" style="width: 300px; margin-left: 2rem;">
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
									<?php
										if(isset($_GET['codigo'])){
									?>
										<input type="hidden" name="filtro_dpto" id="filtro_dpto" value="<?php echo $_GET['codigo'] ?>">
									<?php } ?>
								<?php } ?>
								
								<input class="btn gradient-custom shadow" style="color: white" name="aplicar_filtros" id="aplicar_filtros" type="submit" value="Filtrar">
							</div>
						</div>
						</fieldset>
					</form>
				
			
			<div class="row container">
				<div class="col-12" style="padding-left: 2rem;">
					<form class="buscador d-flex mt-3 w-25" method="POST" action="buscar.php">
						<input class="form-control me-2" type="search" id="buscar" name="buscar" placeholder="Buscar" aria-label="Buscar">
						<button class="btn btn-outline-light gradient-custom shadow" type="submit" id="boton_buscar" name="boton_buscar"><i class="bi bi-search"></i></button>
					</form>
				</div>
			</div>
			
			
			<!-- tabla -->
			<div  style="padding-left:10px; padding-right: 10px;"  id="tablaArticulos" >
				<div class="table-responsive">
					<table class="table">
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
							require_once "./funcionesBBDD.php";
							$pagina = isset($_GET['page'])?$_GET['page']:0;

							if($_SESSION['usuario_login']['ROL'] == 0){
								if (isset($_GET['filtro']) && $_GET['filtro'] == "todos" && isset($_GET['codigo'])) {
									$codigo_departamento = $_GET['codigo'];
									consultarDatos('SELECT a.* FROM articulo a
													INNER JOIN tiene t ON a.CODIGO = t.COD_ARTICULO
													INNER JOIN departamento d ON t.COD_DEPARTAMENTO = d.codigo
													WHERE d.codigo = '.$codigo_departamento, $pagina);
								} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && !isset($_GET['codigo'])) {
									consultarDatos('SELECT a.* FROM ARTICULO a, FUNGIBLE f WHERE a.CODIGO = f.CODIGO', $pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && isset($_GET['codigo'])){
									$codigo_departamento = $_GET['codigo'];
										consultarDatos('SELECT * FROM articulo 
														INNER JOIN tiene 
														ON articulo.CODIGO = tiene.COD_ARTICULO 
														INNER JOIN fungible
														ON articulo.CODIGO = fungible.CODIGO
														WHERE tiene.COD_DEPARTAMENTO = '.$codigo_departamento, $pagina);
								} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && !isset($_GET['codigo'])) {
									consultarDatos('SELECT * FROM articulo 
														INNER JOIN tiene 
														ON articulo.CODIGO = tiene.COD_ARTICULO 
														INNER JOIN fungible
														ON articulo.CODIGO = fungible.CODIGO
														WHERE fungible.PEDIR = "si"', $pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && isset($_GET['codigo'])){
									$codigo_departamento = $_GET['codigo'];
										consultarDatos('SELECT * FROM articulo 
														INNER JOIN tiene 
														ON articulo.CODIGO = tiene.COD_ARTICULO 
														INNER JOIN fungible
														ON articulo.CODIGO = fungible.CODIGO
														WHERE fungible.PEDIR = "si"
														AND tiene.COD_DEPARTAMENTO = '.$codigo_departamento, $pagina);
								} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && !isset($_GET['codigo'])) {
									consultarDatos('SELECT a.* FROM ARTICULO a, NOFUNGIBLE f WHERE a.CODIGO = f.CODIGO', $pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && isset($_GET['codigo'])){
									$codigo_departamento = $_GET['codigo'];
									consultarDatos('SELECT * FROM articulo 
														INNER JOIN tiene 
														ON ARTICULO.CODIGO = TIENE.COD_ARTICULO 
														INNER JOIN nofungible
														ON articulo.CODIGO = nofungible.CODIGO
														WHERE tiene.COD_DEPARTAMENTO = '.$codigo_departamento, $pagina);
								} else {
									consultarDatos('SELECT * FROM articulo',$pagina);
								}
							} else if($_SESSION['usuario_login']['ROL'] == 1) {
								// consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
								if(!isset($_GET['filtro'])){
									consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],$pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'todos'){
									consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],$pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
									consultarDatos('SELECT * FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN fungible ON articulo.CODIGO = fungible.CODIGO WHERE tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],$pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir') {
									consultarDatos('SELECT * FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN fungible ON articulo.CODIGO = fungible.CODIGO WHERE fungible.PEDIR = "si" AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],$pagina);
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
									consultarDatos('SELECT * FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN nofungible ON articulo.CODIGO = nofungible.CODIGO WHERE tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],$pagina);
								}
							}
							?>
						</tbody>
					</table>	
				</div>
				<!-- paginador -->
				<div style="padding-bottom: 200px;">
					<?php
						require_once "./funcionesBBDD.php";
						$pagina = isset($_GET['page'])?$_GET['page']:0;
						if($_SESSION['usuario_login']['ROL'] == 0){
							if (isset($_GET['filtro']) && $_GET['filtro'] == "todos" && isset($_GET['codigo'])) {
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(a.codigo) FROM articulo a 
												INNER JOIN tiene t 
												ON a.CODIGO = t.COD_ARTICULO 
												INNER JOIN departamento d 
												ON t.COD_DEPARTAMENTO = d.codigo 
												WHERE d.codigo = '.$codigo_departamento, 'todos', $pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'todos' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(*) FROM articulo','todos',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && isset($_GET['codigo'])){
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo 
												INNER JOIN tiene 
												ON ARTICULO.CODIGO = TIENE.COD_ARTICULO 
												INNER JOIN fungible
												ON articulo.CODIGO = fungible.CODIGO
												WHERE tiene.COD_DEPARTAMENTO = '.$codigo_departamento.';','fungibles',$pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(a.codigo) FROM ARTICULO a, FUNGIBLE f WHERE a.CODIGO = f.CODIGO','fungibles',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && isset($_GET['codigo'])){
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo 
												INNER JOIN tiene 
												ON articulo.CODIGO = tiene.COD_ARTICULO 
												INNER JOIN fungible
												ON articulo.CODIGO = fungible.CODIGO
												WHERE fungible.PEDIR = "si"
												AND tiene.COD_DEPARTAMENTO = '.$codigo_departamento,'fungiblespedir',$pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo 
												INNER JOIN tiene 
												ON articulo.CODIGO = tiene.COD_ARTICULO 
												INNER JOIN fungible
												ON articulo.CODIGO = fungible.CODIGO
												WHERE fungible.PEDIR = "si"','fungiblespedir',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && isset($_GET['codigo'])){
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo 
												INNER JOIN tiene 
												ON ARTICULO.CODIGO = TIENE.COD_ARTICULO 
												INNER JOIN nofungible
												ON articulo.CODIGO = nofungible.CODIGO
												WHERE tiene.COD_DEPARTAMENTO = '.$codigo_departamento.';','nofungibles',$pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(a.codigo) FROM ARTICULO a, NOFUNGIBLE f WHERE a.CODIGO = f.CODIGO','nofungibles',$pagina);
							} else {
								pintarPaginador('SELECT COUNT(*) FROM articulo','todos',$pagina);
							}
						} else if($_SESSION['usuario_login']['ROL'] == 1) {
							// consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
							if(!isset($_GET['filtro'])){
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],'todos', $pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'todos'){
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],'todos',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
								pintarPaginador('SELECT COUNT(articulo.codigo)  FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN fungible ON articulo.CODIGO = fungible.CODIGO WHERE tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],'fungibles',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir') {
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN fungible ON articulo.CODIGO = fungible.CODIGO WHERE fungible.PEDIR = "si" AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],'fungiblespedir',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
								pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN nofungible ON articulo.CODIGO = nofungible.CODIGO WHERE tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],'nofungibles', $pagina);
							} 
						}
					?>
				</div>
			</div>
		</div>
	</div>

	
	<!-- <footer class=" gradient-custom p-3 ">
        <nav class="navbar navbar-expand-md navbar-light text-light d-flex justify-content-center">
		<div class="row d-flex">
            <div class="texto-footer" style="text-align:center;"> Curso(2022-2023) &#169;</div>
			
				<div clas>
					Creado por: <br> Brenda Serafin Camara <br> Daniel 
				</div>
				<div>
					Javier Díaz Marcos <br> Nera Dominguez Alcaide <br> Raúl Gómez Hernández
				</div>

			</div>
        </nav>
    </footer> -->

	<footer class="gradient-custom p-3">
		<div class="container text-light">
			<div class="row">
				<div class="col-12 text-center">
					<p>IES JULIO VERNE <br>Curso(2022-2023)&#169;</p>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-md-6">
					<p>Creado por: <br> Brenda Serafín Camara <br> Daniel Andrés Bravo</p>
				</div>
				
				<div class="col-md-6">
					<p>Javier Díaz Marcos <br> Nera Domínguez Alcalde <br> Raúl Gómez Hernández</p>
				</div>
			</div>
		</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" 
		crossorigin="anonymous"></script>
	<script src="../js/exportarPDF.js"></script>
</body>

</html>
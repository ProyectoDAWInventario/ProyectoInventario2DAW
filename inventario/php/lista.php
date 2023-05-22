<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inventario con Bootstrap</title>
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
		<form class="d-flex justify-content-center flex-grow-1 w-25">
			<input class="form-control me-2 w-25" type="search" placeholder="Buscar" aria-label="Buscar">
			<button class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i></button>
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


	<!-- FILTROS -->
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
				
				<input class="btn gradient-custom shadow" style="color: white" id="aplicar_filtros" type="submit" value="Aplicar filtro">
			</fieldset>
		</form>
		<br>
		<?php
			session_start();
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
		</form><br>
		<?php } ?>		

	</div>

	<!-- <button type="button" class="btn btn-warning"><a href="exportarPDF.php" target="_blank">Descargar PDF</a></button> -->
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
							<a href="exportarPDF.php" target="_blank">
								<!-- <i class="bi bi-box-arrow-in-down"></i> -->
								<i class="bi bi-filetype-pdf"></i>
							</a>
						</th>
					</tr>
				</thead>
				<tbody id="tbodyy">
					<?php
					require_once "./Prueba_imagen.php";
					// consultarDatos('SELECT * FROM articulo;');
					
					if($_SESSION['usuario_login']['ROL'] == 0){
						// if(!isset($_GET['filtro'])){
						// 	consultarDatos('SELECT * FROM articulo;');
						// } else if(isset($_GET['filtro']) && $_GET['filtro'] == 'todos'){
						// 	consultarDatos('SELECT * FROM articulo;');
						// } else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
						// 	consultarDatos('SELECT a.* from ARTICULO a, FUNGIBLE f where a.CODIGO = f.CODIGO;');
						// } else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
						// 	consultarDatos('SELECT a.* from ARTICULO a, NOFUNGIBLE f where a.CODIGO = f.CODIGO;');
						// }
						if (isset($_GET['filtro']) && $_GET['filtro'] == 'departamento') {
							$codigo_departamento = $_GET['codigo'];
							consultarDatos('SELECT a.* FROM articulo a
											INNER JOIN tiene t ON a.CODIGO = t.COD_ARTICULO
											INNER JOIN departamento d ON t.COD_DEPARTAMENTO = d.codigo
											WHERE d.codigo = '.$codigo_departamento.';');
						} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'todos') {
							consultarDatos('SELECT * FROM articulo;');
						} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
							consultarDatos('SELECT a.* FROM ARTICULO a, FUNGIBLE f WHERE a.CODIGO = f.CODIGO;');
						} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
							consultarDatos('SELECT a.* FROM ARTICULO a, NOFUNGIBLE f WHERE a.CODIGO = f.CODIGO;');
						} else {
							consultarDatos('SELECT * FROM articulo;');
						}
					} else if($_SESSION['usuario_login']['ROL'] == 1) {
						// consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
						if(!isset($_GET['filtro'])){
							consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
						} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'todos'){
							consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
						} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
							consultarDatos('SELECT * FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN fungible ON articulo.CODIGO = fungible.CODIGO WHERE tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
						} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
							consultarDatos('SELECT * FROM articulo INNER JOIN tiene ON ARTICULO.CODIGO = TIENE.COD_ARTICULO INNER JOIN nofungible ON articulo.CODIGO = nofungible.CODIGO WHERE tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	
	<footer class=" gradient-custom p-3 ">
            <nav class="navbar navbar-expand-md navbar-light text-light d-flex justify-content-center mt-0">
                <div class="texto-footer" style="text-align:center;">IES JULIO VERNE Curso(2022-2023)<br> Creado por Brenda, Daniel, Javier, Nerea y Raúl  &#169;</div>
            </nav>
        </footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	<script src="../js/exportarPDF.js"></script>
	<script src="../js/html2pdf.bundle.min.js"></script>
</body>

</html>
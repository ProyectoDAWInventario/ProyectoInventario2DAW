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
		<form class="d-flex justify-content-center flex-grow-1 w-25" method="POST" action="buscar.php">
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


	<!-- FILTROS -->
	<div>
		<form method="post" action="cookieFiltro.php">
			<fieldset name="filtro" id="filtro">
				<!-- FILTRO FUNGIBLE -->
				<ul>
					<li>
						<input type="radio" name="filtro" value="todos" <?php if(!isset($_GET['filtro']) || (isset($_GET['filtro']) && $_GET['filtro'] == "todos")) echo 'checked'; ?>> TODOS
					</li>
					<li>
						<input type="radio" name="filtro" value="fungibles" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "fungibles") echo 'checked'; ?>> FUNGIBLES
					</li>
					<li>
						<input type="radio" name="filtro" value="fungiblespedir" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "fungiblespedir") echo 'checked'; ?>> FUNGIBLES A PEDIR
					</li>
					<li>
						<input type="radio" name="filtro" value="nofungibles" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "nofungibles") echo 'checked'; ?>> NO FUNGIBLES
					</li>
				</ul>
				
				<!-- FILTRO DEPARTAMENTO -->
				<?php
					session_start();
					if($_SESSION['usuario_login']['ROL'] == 0){
				?>
					<select class="form-control" id="filtro_departamento" name="filtro_departamento" style="width: 300px;">
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
				<br>
				<input class="btn gradient-custom shadow" style="color: white" name="aplicar_filtros" id="aplicar_filtros" type="submit" value="Aplicar filtro">
			</fieldset>
		</form>
		<br>
	</div>

	<!-- <button type="button" class="btn btn-warning"><a href="exportarPDF.php" target="_blank">Descargar PDF</a></button> -->
	<div class="container-fluid" id="tablaArticulos">
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
					require_once "./Prueba_imagen.php";
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
	</div>
	<div class="container-fluid" style="padding-bottom: 100px;">
		<?php
			require_once "./Prueba_imagen.php";
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
					pintarPaginador('SELECT * FROM articulo 
									INNER JOIN tiene 
									ON articulo.CODIGO = tiene.COD_ARTICULO 
									INNER JOIN fungible
									ON articulo.CODIGO = fungible.CODIGO
									WHERE fungible.PEDIR = "si"
									AND tiene.COD_DEPARTAMENTO = '.$codigo_departamento,'fungiblespedir',$pagina, $codigo_departamento);
				} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && !isset($_GET['codigo'])) {
					pintarPaginador('SELECT * FROM articulo 
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
					pintarPaginador('SELECT COUNT(articulo.codigo) FROM articulo INNER JOIN tiene WHERE ARTICULO.CODIGO = TIENE.COD_ARTICULO AND tiene.COD_DEPARTAMENTO = '.$_SESSION['usuario_login']['DEPARTAMENTO'],NULL, $pagina);
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
	<footer class=" gradient-custom p-3 ">
        <nav class="navbar navbar-expand-md navbar-light text-light d-flex justify-content-center mt-0">
            <div class="texto-footer" style="text-align:center;">IES JULIO VERNE Curso(2022-2023)<br> Creado por Brenda, Daniel, Javier, Nerea y Raúl &#169;</div>
        </nav>
    </footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	<script src="../js/exportarPDF.js"></script>
	<script src="../js/html2pdf.bundle.min.js"></script>
</body>

</html>
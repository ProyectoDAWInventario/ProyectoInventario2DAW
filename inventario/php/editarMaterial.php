<?php
//conexion con la base de datos
$db = require_once('conexion.php');

//Hago una consulta a la base de datos para obtener la informacion del articulo seleccionado
$query = 'select * from articulo where CODIGO = ' . $_GET["cod"];
$articulos = $db->query($query);
foreach ($articulos as $articulo) {
    $codigo = $articulo["CODIGO"];
    $nombre = $articulo['NOMBRE'];
    $numSerie = $articulo["NUM_SERIE"];
    $descripcion = $articulo["DESCRIPCION"];
    $localizacion = $articulo["LOCALIZACION"];
    $unidades = $articulo["UNIDADES"];
    $motivBaja = $articulo["MOTIVO_BAJA"];
    $fechaBaja = $articulo["FECHA_BAJA"];
    $rutaImagen = $articulo["RUTA_IMAGEN"];
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inventario con Bootstrap</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<style>
        .row{
            padding: 15px;
        }
        .form-label{
            margin-bottom: 0;
            margin-top: 10px;
        }
        input{
            margin-top: 0;
        }
        .shadow-blue {
            box-shadow: 0 .5rem 1rem rgba(0,123,255,.2)!important;
        }
        input[type="file"]::-webkit-file-upload-button {
            background-color: #0d6efd;
            color: white;
            
        }
        input[type="file"]:hover{
            color: #0d6efd !important; 
           background-color: white ;
        }

        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        .btn{
            width: 100px;
            height: 40px;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
<header class="gradient-custom">
    <nav class="navbar navbar-expand-md navbar-light p-3">
        <a class="navbar-brand text-light" href="../index.html">Inventario</a>
        <ul class="navbar-nav flex-row flex-wrap text-light ms-auto">
            <li class="nav-item dropdown"><i id="iniciar_sesion" class="bi bi-person 
                nav-link dropdown text-light"
                role="button" data-bs-toggle="dropdown"> Mi cuenta</i>
                <ul class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">Gestionar cuenta</a>
                        <a class="dropdown-item" href="../../archivosComunes/logout.php">Cerrar sesión</a>
                </ul>
            </li>
        </ul> 
    </nav>
</header> 
	<div class="container">
		<form action="actualizar.php?cod=<?php echo $codigo ?>" method="POST" enctype="multipart/form-data">
			<div class="col-12">
                <div class="row datos">
                    <div class="col-md-8 col-12" >
                      <div class="card shadow bg-white rounded shadow-blue" >
                        <div class="row">
                          <div class="col-sm-12">
                                <label class="form-label" for="nombre">NOMBRE</label>
                                <?php echo '<input type="text" id="nombre" name="nombre" class="form-control form-control-lg" placeholder="Nombre" value="'.$nombre.'" required/>';?>
                          </div>           
                          <div class="col-sm-12">
                                <label class="form-label" for="nombre">DESCRIPCIÓN</label>
                                <?php echo '<input type="text" id="descripcion" name="descripcion" class="form-control form-control-lg" placeholder="Descripción" value="'.$descripcion.'" required/>';?>
                            </div>
                            <div class="col-sm-12 ">
				                <label class="form-label" for="nombre">LOCALIZACIÓN</label>
                                <?php echo '<input type="text" id="localizacion" name="localizacion" class="form-control form-control-lg" placeholder="Localización" value="'.$localizacion.'" required/>';?>
                            </div>
                            <div class="col-sm-12 ">
			                    <label class="form-label" for="nombre">MOTIVO DE BAJA</label>
                                <?php echo '<input type="text" id="motivo-bj" name="motivo_bj" class="form-control form-control-lg" placeholder="Motivo de baja" value="'.$motivBaja.'"/>';?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12" >
                        <div class="card shadow bg-white rounded shadow-blue" >
                            <div class="row">
                                <div class="col-sm-12 ">
				                    <label class="form-label" for="nombre">NÚMERO DE SERIE</label>
                                    <?php echo '<input type="text" id="numero" name="numero" class="form-control form-control-lg" placeholder="Número de serie" value="'.$numSerie.'" required/>';?>
                                </div>
                                <div class="col-sm-12">
				                    <label class="form-label" for="nombre">UNIDADES</label>
                                    <?php echo '<input type="number" id="unidades" name="unidades" class="form-control form-control-lg" placeholder="UNIDADES" value="'.$unidades.'" required/>';?>
                                </div>
                                <div class="col-sm-12">
			                        <label class="form-label" for="nombre">FECHA DE BAJA</label>
                                    <?php echo '<input type="date" id="fecha_bj" name="fecha_bj" class="form-control form-control-lg" placeholder="FECHA DE BAJA" value="'.$fechaBaja.'"/>';?>
                                </div>
                                <div class="col-sm-12 ">
                                    <label for="imagen">Imagen</label>
			                        <input type="file" class="form-control-file" id="imagen" name="imagen" value="'.<?php $ruta_imagen ?>.'">
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="col-12 p-5 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary shadow " style="margin-right: 50px;" name="Aceptar" value="Aceptar">Guardar</button>
                        <a href="lista.php" id="btn-salir" type="button" class="btn btn-primary shadow">Volver</a>
                    </div>
                </div>
            </div>
		</form>
	</div>
    <footer class="gradient-custom">
		<nav class="navbar navbar-expand-md navbar-light text-light p-4 d-flex justify-content-between">
			<div>Brenda</div>
			<div>Daniel</div>
			<div>Javier</div>
			<div>Nerea</div>
			<div>Raul</div>
		</nav>

	</footer>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
//conexion con la base de datos
$db = require_once('conexion.php');

session_start();
if(!isset($_SESSION["usuario_login"])){
	header("Location: ../../login.php?redirigido=true");
};

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
    $procedencia = $articulo['PROCEDENCIA_ENTRADA'];
}
//Hago una consulta a la base de datos para obtener el codigo del articulo fungible
$query2 = 'select * from fungible where CODIGO = ' . $_GET["cod"];
$articulos2 = $db->query($query2);
foreach ($articulos2 as $articulo) {
    $codigofungible = $articulo["CODIGO"];
}

//Hago una consulta a la base de datos para obtener el codigo del articulo fungible
$query3 = 'select * from nofungible where CODIGO = ' . $_GET["cod"];
$articulos3 = $db->query($query3);
foreach ($articulos3 as $articulo) {
    $codigonofungible = $articulo["CODIGO"];
}


//Hago una consulta a la base de datos para obtener el codigo del departamento
$email =  $_SESSION["usuario_login"]["EMAIL"];
$query4 = "select DEPARTAMENTO from usuario where EMAIL= '$email'";
$departamentos = $db->query($query4);
foreach ($departamentos as $departamento) {
    $codigodepartamentos = $departamento["DEPARTAMENTO"];
}

//Hago una consulta a la base de datos para obtener el nombre del codigo del departamento
$query5 = "select NOMBRE from departamento where codigo='$codigodepartamentos'";
$nombres = $db->query($query5);
foreach ($nombres as $nom) {
    $nombredepartamento = $nom["NOMBRE"];
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventario con Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .row {
            padding: 15px;
        }

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

        .main-content {
            min-height: calc(100vh - 100px);
            /* Resta el tamaño del footer al alto total de la ventana */
            padding-bottom: 100px;
            /* Asegura que el contenido no tape con el footer */
        }

        .main-form {
            min-height: calc(100vh - 180px);
            /* Resta el tamaño del footer al alto total de la ventana */


        }

        footer .row {
			padding: 0;
		}
		footer p {
			margin-bottom: 0;
		}

        @media (max-width: 767px) {
            .btn-container {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .btn-container .btn {
                margin-bottom: 10px;
                width: 100%;
            }

            .texto-footer {
                font-size: 14px;
            }

            .main-form{
                padding-bottom: 100px;
            }

            
        }

        /* Estilos personalizados para ocultar el input de tipo file */
        .input-file {
            display: none;
        }

        /* Estilos para el botón personalizado */
        .custom-button {
            background-color: blue;
            color: #fff;
            padding: 7px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <header class="gradient-custom">
        <nav class="navbar navbar-expand navbar-light p-3 ms-4 me-4">
            <a class="navbar-brand text-light " href="../index.php">Inventario</a>
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


    <div class="container-fluid main-content" style="padding-bottom: 200px;">
        <form action="actualizar.php?cod=<?php echo $codigo ?>" method="POST" enctype="multipart/form-data" class="main-form d-flex justify-content-center align-items-center">
            <div class="row">
                <div class="col-12 ">
                    <div class="row datos ">
                        <div class="col-md-8 col-12 mb-4 ">
                            <div class="card shadow bg-white rounded shadow-blue">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo $nombre ?>" required />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="descripcion" class="form-label">Descripcion</label>
                                        <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" value="<?php echo $descripcion ?>" required />
                                    </div>
                                    <div class="col-sm-12 ">
                                        <label for="localizacion" class="form-label">Localizacion</label>
                                        <input type="text" id="localizacion" name="localizacion" class="form-control" placeholder="Localización" value="<?php echo $localizacion ?>" required />
                                    </div>
                                    <div class="col-sm-12 ">
                                        <label for="procedencia" class="form-label">Procedencia</label>
                                        <input type="text" id="procedencia" name="procedencia" class="form-control" placeholder="Procedencia" value="<?php echo $procedencia ?>" required />
                                    </div>

                                    <div class="col-sm-12 ">
                                        <label for="baja" class="form-label">Motivo de Baja</label>
                                        <input type="text" id="motibo_bj" name="motivo_bj" class="form-control" placeholder="Motivo de la baja" value="<?php echo $motivBaja ?>" />
                                    </div>

                                    <div class="col-sm-12 ">
                                        <label for="imagen" class="form-label img">Imagen</label>
                                        <input type="file" class="form-control" id="imagen" name="imagen">
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card shadow bg-white rounded shadow-blue">
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <label for="numero" class="form-label">Nº de serie</label>
                                        <input type="text" id="numero" name="numero" class="form-control" placeholder="Nº de serie" value="<?php echo $numSerie ?>" required />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="unidades" class="form-label">Unidades</label>
                                        <input type="number" id="unidades" name="unidades" class="form-control" placeholder="Unidades" value="<?php echo $unidades ?>" required />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="fungible" class="form-label">Fungible</label>
                                        <select class="form-control" id="fungible" name="fungible" value="<?php echo $codigofungible ?>" required>
                                            <?php
                                            if ($codigo == $codigofungible) {
                                                echo '<option value="1">Si</option>';
                                                echo '<option value="0">No</option>';
                                            } else {
                                                echo '<option value="0">No</option>';
                                                echo '<option value="1">Si</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php
                                            print "<script>
                                                document.getElementById('fungible').disabled = true;
                                            </script>";
                                        ?>
                                    </div>

                                    <div class="col-sm-12 col-md-12" id="departamento" name="departamento">
                                        <label for="departamento" class="form-label">Departamento</label>
                                        <select class="form-control" id="selectDepartamento" name="selectDepartamento">
                                            <option name="dpto_no_valido" id="dpto_no_valido">- Seleccione su departamento -</option>
                                            <?php
                                            require_once('../../archivosComunes/conexion.php');
                                            $consulta = "SELECT * FROM departamento";
                                            $consulta = $db->query($consulta);
                                            foreach ($consulta as $row) {
                                                if($row['NOMBRE'] == $nombredepartamento){
                                                    echo '<option selected>' . $row['NOMBRE'] . '</option>';
                                                } else {
                                                    echo '<option>' . $row['NOMBRE'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php 
                                            if($_SESSION['usuario_login']['ROL'] != 0){
                                                print "<script>
                                                    document.getElementById('selectDepartamento').disabled = true;
                                                </script>";
                                            }
                                        ?>
                                    </div>
                                    <script>
                                        let selector = document.getElementById('selectDepartamento');
                                        for (let i = 0; i < selector.length; i++) {
                                            if (selector[i].value == "<?php echo $dpto_usuario ?>") {
                                                selector[i].selected = true;
                                            }
                                        }
                                    </script>

                                    <div class="col-sm-12">
                                        <label for="fecha" class="form-label">Fecha de baja</label>
                                        <input type="date" class="form-control" id="fecha_bj" name="fecha_bj">
                                    </div>


                                    <label for="opciones" class="form-label" style="visibility: hidden">Hola </label><br>
                                    <div class="col-sm-12 d-flex btn-container">
                                        <div class="col-sm-6 text-center">
                                            <input id="btn-guardar" type="submit" class="btn gradient-custom shadow" style="color: white" name="btn-guardar" value="Guardar">
                                        </div>
                                        <div class="col-sm-6 text-center">
                                            <a href="lista.php" id="btn-salir" class="btn gradient-custom shadow" style="color: white" name="salir" value="Salir">Salir</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
<?php
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
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Borrado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../inventario/css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/confirmarDelete.css">
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        a{
            text-decoration: none; 
            color: black;
            font-weight: bold;
        }

        button{
            margin: 0 25px 0 25px;
        }
    </style>
</head>
<body>

<body class="gradient-custom">
    
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mt-md-4 pb-5">
                                <?php
                                    echo "<h3>¿Estás seguro de eliminar " . $nombre . "?</h3>";
                                ?>

                            </div>

                            <div>
                            <button type="button" class="btn btn-light" data-dismiss="modal">
                                <?php
                                    echo '<a href="lista.php">Cancelar</a>';
                                ?>
                            </button>
                            <a href="borrarMaterial.php?cod=<?php echo $codigo; ?>" class="btn btn-danger">Eliminar</a>

    
                            
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
      </section>

    <!-- Libreria bootstrap -->
    <script type="text/javascript" src="js/bootstrap.bundle.min.js">
    </script>
</body>
</body>
</html>
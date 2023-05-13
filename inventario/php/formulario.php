<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('conexion.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Formulario</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	
	<link rel="stylesheet" type="text/css" href="../inventario/css/index.css">
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
@media screen and (max-width: 768px) {
			.texto-footer {
				font-size: 14px;
			}
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
}
	</style>
</head>
    <body>
        <header class="gradient-custom">
            <nav class="navbar navbar-expand-md navbar-light p-3 ms-4 me-4">
                <a class="navbar-brand text-light " href="../index.html">Inventario</a>
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
        
        <div class="container-fluid" style="padding-bottom: 100px;">
            <form action="anadirMaterial.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 ">
                        <div class="row datos " >
                            <div class="col-md-8 col-12 mb-4" >
                                <div class="card shadow bg-white rounded shadow-blue" >
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>   
                                        <div class="col-sm-12">
                                            <label for="descripcion" class="form-label">Descripcion</label>
                                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                                        </div>
                                        <div class="col-sm-12 ">
                                            <label for="localizacion" class="form-label">Localizacion</label>
                                            <input type="text" class="form-control" id="localizacion" name="localizacion" required>
                                        </div>
                                        <div class="col-sm-12 ">
                                            <label for="procedencia" class="form-label">Procedencia</label>
                                            <input type="text" class="form-control" id="procedencia" name="procedencia" required>
                                        </div>
                                
                                        <div class="col-sm-12 ">
                                            <label for="baja" class="form-label">Motivo de Baja</label>
                                            <input type="text" class="form-control" id="motivo_bj" name="motivo_bj" >
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
                                                        echo '<option>'.$row['NOMBRE'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-12" style="color: red; font-weight: bold;">
                                            <?php
                                                if(isset($_GET['error'])){
                                                    echo "Seleccione el departamento";
                                                }
                                            ?>
                                        </div>
                                        
                                        <?php
                                            require_once('../../archivosComunes/conexion.php');
                                            if($_SESSION["usuario_login"]["ROL"] != 0){
                                                $departamento = $_SESSION["usuario_login"]["DEPARTAMENTO"];
                                                $consulta = "SELECT * FROM departamento WHERE codigo = ?";
                                                $consulta = $db->prepare($consulta);
                                                $consulta->execute(array($departamento));
                                                $consulta_departamento = $consulta->fetch();
                                                $dpto_usuario = $consulta_departamento['NOMBRE'];
                                                print "<script>
                                                    document.getElementById('selectDepartamento').disabled = true;
                                                </script>";
                                                
                                            }
                                            
                                            if($_SESSION['usuario_login']['ROL'] == 1){
                                        ?>
                                            <input type="hidden" name="nombreDepartamento" id="nombreDepartamento" value="<?php echo $dpto_usuario?>">
                                        <?php } ?>
                                        <script>
                                            let selector = document.getElementById('selectDepartamento');
                                            for(let i = 0; i < selector.length; i++){
                                                if(selector[i].value == "<?php echo $dpto_usuario?>"){
                                                    selector[i].selected = true;
                                                }
                                            }
                                        </script>
                                
                                    </div>
                                </div>
                            </div>
                
                             <div class="col-md-4 col-12 " >
                                 <div class="card shadow bg-white rounded shadow-blue" >
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <label for="numero" class="form-label">Nº de serie</label>
                                            <input type="number" class="form-control" id="numero" name="numero" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="unidades" class="form-label">Unidades</label>
                                            <input type="number" class="form-control" id="unidades" name="unidades" value="unidades" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fungible" class="form-label">Fungible</label>
                                            <select class="form-control" id="fungible" name="fungible" required>
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                            
                                        </div>
                                        <div class="col-sm-12 ">
                                            <label for="imagen" class="form-label img">Imagen</label>
                                            <input type="file" class="form-control" id="imagen" name="imagen">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fecha" class="form-label">Fecha de baja</label>
                                            <input type="date" class="form-control" id="fecha_bj" name="fecha_bj">
                                        </div>
                                   
                                        
                                        <label for="opciones" class="form-label" style="visibility: hidden">Hola </label><br>
                                        <div class="col-sm-12 d-flex btn-container">
                                            <div class="col-sm-6 text-center">
                                                <input id="btn-guardar" type="submit" class="btn gradient-custom shadow" style="color: white"  name="btn-guardar" value="Guardar">
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <a href="../index.html" id="btn-salir" class="btn gradient-custom shadow" style="color: white" name="salir" value="Salir">Salir</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        <footer class=" gradient-custom p-3 ">
            <nav class="navbar navbar-expand-md navbar-light text-light d-flex justify-content-center mt-0">
                <div class="texto-footer" style="text-align:center;">IES JULIO VERNE Curso(2022-2023)<br> Creado por Brenda, Daniel, Javier, Nerea y Raúl  &#169;</div>
            </nav>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>    
</html>

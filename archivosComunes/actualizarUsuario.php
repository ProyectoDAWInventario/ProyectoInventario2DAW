<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('loginRequerido.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
        
        label{
            margin-top: 10px;
        }
    </style>
</head>
<body class="gradient-custom">
    <?php
        // Recuperamos los datos del usuario logueado de la base de datos
        require_once('conexion.php');

        // Seleccionamos todo del usuario que se envia en input del formulario como tipo hidden
        $select = "SELECT * FROM usuario WHERE COD_USUARIO = ".$_GET['idusuario']."";
        $resul = $db->query($select);
        // Guardamos los datos de la consulta anterior en una session.
        $_SESSION["usu_editar"] = $resul->fetch();
    ?>
    <section>
        <article>
            <div class="container px-4 py-5" id="editarPerfil">
                <h2 class="pb-2 border-bottom text-light">Editar Perfil</h2>
                <!-- Este formulario al dar a enviar lleva al archivo actualizar.php pasando por el metodo GET
                el id del usuario -->
                <form method="POST" class="text-light" action="actualizar.php?idusuario=<?php echo $_SESSION['usu_editar']['COD_USUARIO'] ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validacionEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="validacionEmail" placeholder="Introduce email " name="validacionEmail"  value='<?php echo $_SESSION["usu_editar"]["EMAIL"] ?>'>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder=" Introduce contraseña" name="password" value='<?php echo $_SESSION["usu_editar"]["CLAVE"] ?>'>
                        </div>
                        <!-- El administrador no debe cambiar ni ver la contraseña de otros usuarios -->
                        <?php
                            /* Cuando el email del usuario que se va a editar sea distinto al email con el que se hizo login
                            el input de contraseña se vuelve de solo lectura, al ser input de tipo password no se ve ni deja copiar
                            el valor que tiene el campo */
                            if($_SESSION["usu_editar"]["EMAIL"] != $_SESSION["usuario_login"]["EMAIL"]){
                                print "<script>
                                    document.getElementById('password').readOnly = true;
                                </script>";
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="validacionNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="validacionNombre" placeholder="Introduce Nombre" name="validacionNombre" value='<?php echo $_SESSION["usu_editar"]["NOMBRE"] ?>'>
                        </div>

                        <div class="col-md-6">
                            <label for="validacionApellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="validacionApellidos" placeholder="Introduce Apellidos" name="validacionApellidos" value='<?php echo $_SESSION["usu_editar"]["APELLIDOS"] ?>'>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="validacionDni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="validacionDni" placeholder="Introduce DNI" name="validacionDni" value='<?php echo $_SESSION["usu_editar"]["DNI"] ?>'>
                        </div>

                        <div class="col-md-6">
                            <label for="validacionDepartamento" class="form-label">Departamento</label>
                            <?php
                                require_once('conexion.php');
                                if($_SESSION["usu_editar"]["DEPARTAMENTO"] != null){
                                    $departamento = $_SESSION["usu_editar"]["DEPARTAMENTO"];
                                    $consulta = "SELECT * FROM departamento WHERE codigo = ?";
                                    $consulta = $db->prepare($consulta);
                                    $consulta->execute(array($departamento));
                                    $consulta_departamento = $consulta->fetch();
                                    $dpto_usuario = $consulta_departamento['NOMBRE'];
                                }
                            ?>

                            <select name="validacionDepartamento" id="validacionDepartamento" class="form-control form-control-lg">
                                <option name="dpto_no_valido" id="dpto_no_valido">- Seleccione su departamento -</option>
                                <option>DPTO Francés</option>
                                <option>DPTO Inglés</option>
                                <option>DPTO Tecnología</option>
                                <option>DPTO Religión</option>
                                <option>DPTO Matemáticas</option>
                                <option>DPTO Educación Física</option>
                                <option>DPTO Dibujo</option>
                                <option>DPTO Informática</option>
                                <option>DPTO Lengua</option>
                                <option>DPTO Filosofía</option>
                                <option>DPTO Geografía e Historia</option>
                                <option>DPTO Orientación</option>
                                <option>DPTO Física y Química</option>
                                <option>DPTO Música</option>
                                <option>DPTO Biología y Geología</option>
                                <option>DPTO Griego</option>
                                <option>DPTO Economía</option>
                            </select>

                            <script>
                                let selector = document.getElementById('validacionDepartamento');
                                for(let i = 0; i < selector.length; i++){
                                    if(selector[i].value == "<?php echo $dpto_usuario?>"){
                                        selector[i].selected = true;
                                    }
                                }
                            </script>
                        </div>
                        <?php
                            /* Si el usuario no es profesor no tiene departamento entonces ese campo es de solo lectura */
                            /* MIRAR ESTO PORQUE NO SE SI UN USUARIO QUE ANTES ERA PROFESOR CAMBIA A ADMINISTRADOR SIGUE CON SU DEPARTAMENTO */
                            if($_SESSION["usu_editar"]["ROL"] != 1){
                                print "<script>
                                    document.getElementById('validacionDepartamento').disabled = true;
                                </script>";
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12 p-3 d-flex justify-content-center">
                            <button class="btn btn-success" name="actualizar" type="submit">Actualizar Perfil</button>
                        </div>
                    </div>

                    
                 </form>   
            </div>
        </article>
    </section>
</body>
</html>
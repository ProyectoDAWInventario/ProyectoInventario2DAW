<?php
    /* Funcion para comprobar si el usuario esta en la base de datos*/
    function comprobar_usuario($email, $clave){        
        try {
            //Hago la conexion a la base de datos
            $db = require_once('archivosComunes/conexion.php');
            //Consulta seleccionando todo de la base de datos donde el email y la clave son los que se ingresa en el formulario
            $sql = "SELECT * FROM usuario where email=? and clave=?;";
            //Preparo la consulta
            $consulta = $db->prepare($sql);
            //Pasar a traves de un array los valores escritos en el formulario
            //Los valores se recogen por parametros en la función
            $consulta->execute(array($email, $clave));

            //si la consulta devuelve algo, es que todo va bien
            if ($consulta->rowCount() > 0){
                // Como solo va a devolver una linea la consulta ya que el email es unique usamos fetch
                $us = $consulta->fetch();
                //Retornar a traves de un array todos los valores del usuario que hizo login
                return $us;
            //Si no me devuelve nada al hacer la consulta retornar FALSE
            } else return FALSE;
        } catch (PDOException $e) {
            echo "Error en la base de datos ".$e->getMessage();
        }
    }

    //Si el formulario envia los datos en metodo POST
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        //Guardar en una variable el valor que retorna la funcion al comprobar el usuario
        $usu = comprobar_usuario($_POST["typeEmailX"], $_POST["typePasswordX"]);
        //Si retorna la funcion un false es que hay algun error por lo tanto se inicializa
        // la variable err a true que se usara despues para mostrar un mensaje de error
        if ($usu == FALSE){
            $err = TRUE;
            //Guardar en una variable el email que puso para que se le mantenga escrito y no tenga que volver a escribirlo
            $usuario = $_POST["typeEmailX"];
        //Si todo esta bien, se inicia una sesion
        } else if ($usu['VALIDAR'] == 'no') {
            $errValidar = true;
        } else {
            //Inicio de la sesion
            session_start();
            //Se crea una session nueva con los datos del usuario
            $_SESSION["usuario_login"] = $usu;

            header("Location: archivosComunes/selector.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ICONO DE LA PESTAÑA DEL NAVEGADOR -->
    <link rel="shortcut icon" href="/img/icono.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Inventario</title>
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>
<body class="gradient-custom">
    
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Iniciar Sesión</h2>
                                <p class="text-white-50 mb-5">Por favor, inserte su usuario y contraseña</p>
                                <form method="POST" class="form-group">
                                    
                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="email" name="typeEmailX" class="form-control" placeholder="EMAIL" required/>
                                        <label class="form-label" for="typeEmailX">Email</label>
                                    </div>
                    
                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="password" name="typePasswordX" class="form-control" placeholder="CONTRASEÑA" required/>
                                        <label class="form-label" for="typePasswordX">Contraseña</label>
                                    </div>
                                    <button name="enviar" id="enviar" class="btn btn-outline-light btn-lg px-5" type="submit">Iniciar Sesión</button>
                                    <?php
                                        /*Si se intenta acceder a principal.php directamente,
                                        ese script te redirigirá a este mediante metodo GET y dando a la clave
                                        "rederigido" el valor true. Si esto ocurre, el siguiente if se cumpliria
                                        y pondría el mensaje "Haga login para continuar" */
                                        if(isset($_GET["redirigido"])){
                                            echo "<p style='padding-top: 10px;'>Haga login para continuar</p>";
                                        }
                                    ?>

                                    <?php
                                        //Si la variable err esta inicializada y a parte esta en true 
                                        // se enviara un mensaje para que revise el usuario y la contraseña
                                        if(isset($err) and $err == true){
                                            echo "<p style='padding-top: 10px;'>Revise usuario y contraseña</p>";
                                        } else if (isset($errValidar) and $errValidar == true){
                                            echo "<p style='padding-top: 10px;'>El usuario no tiene permisos para iniciar sesión</p>";
                                        }
                                    ?>
                                </form>
                            </div>
                            <div>
                                <p class="mb-0">¿No tiene cuenta? <a href="archivosComunes/registrar.php" class="text-white-50 fw-bold">Registrar</a></p>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
      </section>

    <!-- Libreria bootstrap -->
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ICONO DE LA PESTAÑA DEL NAVEGADOR -->
    <link rel="shortcut icon" href="../img/icono.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
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
    
    <section>
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mt-md-2 pb-4">
                                <h2 class="fw-bold mb-4 text-uppercase">REGISTRARSE</h2>
                                <form method="post">
                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="text" id="dni" name="dni" class="form-control form-control-lg" placeholder="DNI" required/>
                                        <label class="form-label" for="dni">DNI</label>
                                    </div>
                    
                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="text" id="nombre" name="nombre" class="form-control form-control-lg" placeholder="Nombre" required/>
                                        <label class="form-label" for="nombre">NOMBRE</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="text" id="apellidos" name="apellidos" class="form-control form-control-lg" placeholder="Apellidos" required/>
                                        <label class="form-label" for="apellidos">APELLIDOS</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="EMAIL" required/>
                                        <label class="form-label" for="email">EMAIL</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="password" id="clave" name="clave" class="form-control form-control-lg" placeholder="Contraseña" required/>
                                        <label class="form-label" for="clave">CONTRASEÑA</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-white">
                                    <input type="radio" id="personalRadio" name="personal" value="MANTENIMIENTO" class="mb-3">MANTENIMIENTO<br>
                                        <input type="radio" id="profesorRadio" name="personal" value="PROFESOR" checked>PROFESOR<br>
                                        <div class="selectPersonal form-floating form-white mb-2 text-dark">
                                            <select name="selectPersonal" id="selectPersonal" class="selectPersonal form-control form-control-lg">
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
                                            <label class="form-label" for="selectPersonal">DEPARTAMENTO</label>
                                        </div>
                                        
                                        
                                    </div>

                                    <button name="enviar" id="enviar" class="btn btn-outline-light btn-lg px-5" type="submit">Registrar</button>
                                    
                                </form> 
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                    
                                    if(isset($_POST["enviar"])){
                                        $rol = null;
                                        try {
                                            $db = require_once('conexion.php');
                                            $rol = null;
                                            if($_POST['personal'] == 'PROFESOR'){
                                                $rol = 1;
                                            } else if($_POST['personal'] == 'MANTENIMIENTO'){
                                                $rol = 2;
                                            } else {
                                                $rol = 0;
                                            }

                                            
                                            if($rol == 1 && $_POST["selectPersonal"] == "- Seleccione su departamento -"){
                                                echo "Seleccione su departamento";
                                            } else {
                                                if($rol == 2){
                                                    $insert = 'insert into usuario(DNI,NOMBRE, APELLIDOS, EMAIL, CLAVE, ROL, VALIDAR)
                                                    values(?,?,?,?,?,?,?);';
                                                    $insert2 = $db->prepare($insert);
                                                    $insert2->execute(array($_POST['dni'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['clave'], $rol, 'no'));
                                                } else {
                                                    $consulta = "select * from departamento where nombre = ?";
                                                    $departamento = $db->prepare($consulta);
                                                    $departamento->execute(array($_POST['selectPersonal']));
                                                                                                
                                                    foreach ($departamento as $key) {
                                                        $dpto = $key['codigo'];
                                                    }

                                                    $insert = 'insert into usuario(DNI,NOMBRE, APELLIDOS, EMAIL, CLAVE, ROL, VALIDAR, DEPARTAMENTO)
                                                            values(?,?,?,?,?,?,?,?);';
                                                    $insert2 = $db->prepare($insert);
                                                    $insert2->execute(array($_POST['dni'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['clave'], $rol, 'no', $dpto));
                                                }

                                            // // //     //MANDAR CORREO AL ADMINISTRADOR, SERAN LOS DE ROL 0
                                                
                                                if($insert2){
                                                    print "
                                                    <script>
                                                        alert('Usuario registrado correctamente.');
                                                        window.location = '../login.php';
                                                    </script>";
                                                }
                                                
                                            }
                                            
                                        }catch (PDOException $e) {
                                            echo "Error en la base de datos ".$e->getMessage();
                                        }
                                        
                                    }
                                }
                            ?>                             
                            </div>
                            
                            <div>
                                <p class="mb-0">¿Ya tiene cuenta? <a href="../login.php" class="text-white-50 fw-bold">Iniciar Sesión</a></p>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
      </section>

    <!-- Libreria bootstrap -->
    <script src="../js/rolUsuarios.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
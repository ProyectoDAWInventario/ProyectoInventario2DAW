<?php
    // Iniciamos la sesion
    session_start();
    // Recuperamos los datos del usuario logueado de la base de datos
    require_once('conexion.php');
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    require_once('loginRequerido.php');
    //$usuario_id = $_SESSION['usuario_login']['EMAIL'];
    $select = "SELECT * FROM usuario WHERE COD_USUARIO = ".$_GET['idusuario']."";
    $resul = $db->query($select);
    // Guardamos los datos de la consulta anterior en una variable.
    $usuario = $resul->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['actualizar'])) {
        // Recuperar los nuevos valores ingresados en los campos
        $email = $_POST['validacionEmail'];
        $password = $_POST['password'];
        $nombre = $_POST['validacionNombre'];
        $apellidos = $_POST['validacionApellidos'];
        $dni = $_POST['validacionDni'];
        $departamento = $_POST['validacionDepartamento'];

        $consulta = "SELECT * FROM departamento where NOMBRE = ?";
        $departamento = $db->prepare($consulta);
        $departamento->execute(array($_POST['validacionDepartamento']));
        $dpto = $departamento->fetch();
        $dpto_actualizado = $dpto['codigo'];

        // Si los campos están vacios, no deja actualizar
        if($email == "" || $password == "" || $nombre == "" || $apellidos == "" || $dni == ""){
            echo "<script>alert('Rellene los campos para actualizar el perfil')</script>";
            
        } else {
            // Actualizar los datos del usuario en la base de datos
            if($usuario['ROL'] == 1){
                $update = "UPDATE usuario SET DNI = '$dni', DEPARTAMENTO = '$dpto_actualizado', EMAIL = '$email', CLAVE = '$password', NOMBRE = '$nombre', APELLIDOS = '$apellidos' WHERE COD_USUARIO = '".$_GET['idusuario']."'";
                $result = $db->query($update);
            } else {
                $update = "UPDATE usuario SET DNI = '$dni', EMAIL = '$email', CLAVE = '$password', NOMBRE = '$nombre', APELLIDOS = '$apellidos' WHERE COD_USUARIO = '".$_GET['idusuario']."'";
                $result = $db->query($update);
            }
            

            // Comprobar errores
            if ($result) {
                echo '<script>alert("Perfil Actualizado")</script>';
                // Actualizar los datos existentes del usuario con los nuevos valores ingresados
                $usuario['Email'] = $email;
                $usuario['Clave'] = $password;
                $usuario['Nombre'] = $nombre;
                $usuario['Apellidos'] = $apellidos;
                // Igualamos la sesion iniciada al nuevo email actualizado
                $_SESSION['email'] = $email;

                // Vuelve a editarPerfil.php donde se encuentran los usuarios
                if($_SESSION['usuario_login']['ROL'] == 0){
                    header ("Location: editarPerfil.php");
                } else {
                    header ("Location: selector.php");
                }
                
            } else {
                print_r($db->errorinfo());
            }
        }
    }
?>
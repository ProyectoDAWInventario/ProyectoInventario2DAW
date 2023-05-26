<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        session_start();
        require("Prueba_imagen.php"); 
        require_once('../../archivosComunes/conexion.php');
        require_once('../../archivosComunes/loginRequerido.php');
        if(isset($_POST["btn-guardar"])){
            if($_SESSION["usuario_login"]['ROL'] == 1){
                $nombreDepartamento = $_POST['nombreDepartamento'];
            } else {
                $nombreDepartamento = $_POST['selectDepartamento'];
            }

            if($nombreDepartamento == '- Seleccione su departamento -'){
                header("Location: formulario.php?error=true");
            } else {
                if($_POST["fecha_bj"] == ''){
                    $_POST["fecha_bj"] = null;
                }

                if($_POST["motivo_bj"] == ''){
                    $_POST["motivo_bj"] = null;
                }

                if(isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])){
                    $img = file_get_contents($_FILES["imagen"]["tmp_name"]);
                } else {
                    $img = null;
                }

                anadir_img($_POST["nombre"], $_POST["numero"], $_POST["descripcion"], $_POST["localizacion"], 
                $_POST["unidades"], $_POST["procedencia"], $_POST["motivo_bj"],  $_POST["fecha_bj"], $img);

                // INSERT EN LA TABLA "TIENE", TABLA INTERMEDIA ENTRE ARTICULO Y DEPARTAMENTO
                $consultaArticulo = "SELECT MAX(CODIGO) as id FROM articulo";
                $consultaArticulo = $db->query($consultaArticulo);
                $codigoArticulo = $consultaArticulo->fetch();

                // Se coge el valor que se encuentra en id ya que al hacer la consulta devuelve dos valores
                $codArticulo = $codigoArticulo['id'];

                if($_SESSION['usuario_login']['ROL'] != 0){
                    $codigoDepartamento = $_SESSION['usuario_login']['DEPARTAMENTO'];
                    $consulta = "INSERT INTO tiene(COD_ARTICULO,COD_DEPARTAMENTO) VALUES (?,?);";
                    $consulta = $db->prepare($consulta);
                    $consulta->execute(array($codArticulo, $codigoDepartamento));
                    header("Location: lista.php");
                } else {                    
                        $consulta = "SELECT * FROM departamento WHERE NOMBRE = ?;";
                        $consulta = $db->prepare($consulta);
                        $consulta->execute(array($nombreDepartamento));
                        foreach($consulta as $row) {
                            $codigoDepartamento = $row['codigo'];
                        }

                        $consultaInsert = "INSERT INTO tiene(COD_ARTICULO,COD_DEPARTAMENTO) VALUES (?,?);";
                        $consultaInsert = $db->prepare($consultaInsert);
                        $consultaInsert->execute(array($codArticulo, $codigoDepartamento));
                        header("Location: lista.php");
                    }

                // FUNGIBLES
                if($_POST['fungible'] == 1){
                    $consultaFungibles = "INSERT INTO fungible(CODIGO, PEDIR) VALUES (?,?);";
                    $consultaFungibles = $db->prepare($consultaFungibles);
                    $consultaFungibles->execute(array($codArticulo, 'no'));
                } // NO FUNGIBLES
                else {
                    $consultaNoFungibles = "INSERT INTO nofungible(CODIGO, FECHA) VALUES (?,?);";
                    $consultaNoFungibles = $db->prepare($consultaNoFungibles);
                    $consultaNoFungibles->execute(array(($codArticulo+1), date('Y')));
                }
            }
        }
    }
?>
<?php
	//print_r($_POST);
	//print_r($_FILES);
	if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once("Prueba_imagen.php"); 

        if(isset($_POST["btn-guardar"])){
            if($_POST["fecha_bj"] == ''){
                $_POST["fecha_bj"] = null;
            }

            if($_POST["motivo_bj"] == ''){
                $_POST["motivo_bj"] = null;
            }

		if (isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])) {
			//echo 'tengo imagen';
            $img = file_get_contents($_FILES["imagen"]["tmp_name"]);
            actualizarDatos($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["motivo_bj"], $_POST["numero"], $_POST["unidades"], $_POST["fecha_bj"], $img, $_GET['cod'], $_POST['procedencia'], $_POST['fungible'], $_POST['selectDepartamento']);
		} else {
			//echo 'no tengo imagen';
            actualizarDatos2($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["motivo_bj"], $_POST["numero"], $_POST["unidades"], $_POST["fecha_bj"], $_GET['cod'], $_POST['procedencia'], $_POST['fungible'], $_POST['selectDepartamento']);
        }

        header("Location: lista.php");
        }
        
    }
?>

<!-- Funcion para añadir el material del Excel a la base de datos. -->
<?php
    require_once 'materialInstituto.php';


    function anadirMaterial(MaterialInstituto $material){

        
        require "./conexion.php";
        try {
            $db = new PDO($conexion, $usuario, $contrasena);
            $datos = $db->prepare("INSERT INTO articulo (FECHA_ALTA, NUM_SERIE, NOMBRE, DESCRIPCION, UNIDADES, 
            LOCALIZACION, PROCEDENCIA_ENTRADA, MOTIVO_BAJA, FECHA_BAJA) VALUES     (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // No se permite pasar una referencia a bindParam, por eso tenemos
            // que crear una variable con cada get
            //En cada una de estas llamadas se invoca al getter para pasar un atributo a una variable.En
            //el caso de las fechas;hay que pasarlas a formato año/mes/dia.
            $fechaAlta = $material->getFechaAlta()->format('Y/m/d');
            $isbn = $material->getIsbn();
            $nombre = $material->getNombre();
            $descripcion =  $material->getDescripcion();
            $unidades =  $material->getUnidades();
            $localizacion =  $material->getLocalizacion();
            $procedencia = $material->getProcedencia();
            $motivoBaja = $material->getMotivoBaja();
            //En el caso de que la fecha sea nula debemos indicar que la fecha es nula.
            //si fuera nula y accedieramos a ella nos daría un error; puesto que no podríamos formatearla.
            if ($material->getFechaBaja() == null) {
                $fechaBaja = null;
            } else {
                $fechaBaja = $material->getFechaBaja()->format('Y/m/d');
            }


            // a cada ? del insert que hemos preparado arriba, le asignamos el valor que pone en la variable.
            // Si hacemos un bindParam con un 3, se busca la tercera ? y se sustituye
            $datos->bindParam(1, $fechaAlta);
            $datos->bindParam(2, $isbn);
            $datos->bindParam(3, $nombre);
            $datos->bindParam(4, $descripcion);
            $datos->bindParam(5, $unidades);
            $datos->bindParam(6, $localizacion);
            $datos->bindParam(7, $procedencia);
            $datos->bindParam(8, $motivoBaja);
            $datos->bindParam(9, $fechaBaja);

            $datos->execute();
            $db = null;
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
?>

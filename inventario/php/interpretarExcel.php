<!-- Prueba para interpretar un archivo excel
Es necesario descagar en la terminal el paquete: composer require phpoffice/phpspreadsheet -->
<?php
require_once '../../vendor/autoload.php';
require_once 'materialInstituto.php';
require_once 'materialBBDD.php';
session_start();
if(!isset($_SESSION["usuario_login"])){
	header("Location: ../../login.php?redirigido=true");
};


//Se utiliza por defecto Spreadsheet sin tener que indicar la ruta completa
use PhpOffice\PhpSpreadsheet\Spreadsheet;


function validarExcel($inputFileName) 
{
    $testAgainstFormats = [
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS,
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLSX
    ];
    
    /** Load $inputFileName to a Spreadsheet Object  **/

    try {
        \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName, 0, $testAgainstFormats);
        return true;
    } catch (PhpOffice\PhpSpreadsheet\Reader\Exception) {
        return false;
    }
}

function interpretarExcel($inputFileName) {
    $spreadsheet = new Spreadsheet();


    $inputFileType = 'Xlsx';
    /**  Create a new Reader of the type defined in $inputFileType  **/
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    

    /**  Advise the Reader to load all Worksheets  **/
    $reader->setLoadAllSheets();
    $spreadsheet = $reader->load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();

    //Recoge todos los nombres de las hojas del fichero excel en un array:"wotsheetData"
    $worksheetData = $reader->listWorksheetInfo($inputFileName);

    //Recorremos las hojas
    foreach ($worksheetData as $worksheetBasicData) {

        //Recogemos el nombre de la hoja
        $sheetName = $worksheetBasicData['worksheetName'];
        
        //Nos posicionamos en la hoja que tiene el nombre sheetName
        $worksheet = $spreadsheet->getSheetByName($sheetName);

        

        //Si el nombre de la hoja es inventario; hacemos el siguiente proceso.
        if ($sheetName == "Inventario") {

            $foundTitle = FALSE;
            $material = null;
            //echo '<table>' . PHP_EOL;
            foreach ($worksheet->getRowIterator() as $row) {
                //echo '<tr>' . PHP_EOL;
                $cellIterator = $row->getCellIterator();
                //Iteramos solo las celdas que tienen contenido
                $cellIterator->setIterateOnlyExistingCells(TRUE); // This loops through all cells,
                                                                //    even if a cell value is not set.
                                                                // For 'TRUE', we loop through cells
                                                                //    only when their value is set.
                                                                // If this method is not called,
                                                            //    the default value is 'false'.
                //Solo cuando ya ha pasado de las cabeceras (th) creo el objeto materialInstituto
                if ($foundTitle == TRUE) {
                    $material = new MaterialInstituto();
                }
                foreach ($cellIterator as $cell) {
                    //Tengo que seguir este proceso para que no aparezca la formula de la celda;sino el valor.
                    //Dependiendo de la celda a veces funciona con getOldCalculatedValue() y otras veces
                    //debemos usar getCalculatedValue().
                    $cellValue = $cell->getOldCalculatedValue();
                    if ($cellValue == null) {
                        $cellValue = $cell->getCalculatedValue();
                    }
                    //Se cuando he llegado a la fila donde me pone las cabeceras porque la primera es departamento.
                    if ($cellValue == "Departamento") {
                        $foundTitle = TRUE;
                        // me da igual toda la fila de los titulos donde pone "Departamento"
                        break;
                    }
                    
                    if ($foundTitle == TRUE) {
                        // Ya he encontrado los titulos y estoy creando objetos con la informacion
                        // de la fila de cada objeto
                        $columnId = $cell->getColumn();
                        //Si la columna es la C; definimos el valor codigo de nuestro objeto. (En todas las C estan
                        //los codigos del objeto)
                        if($columnId == "A") {
                            $material->setDepartamento($cellValue);
                        }
                        if ($columnId == "C") {
                            $material->setCodigo($cellValue);
                        }
                        //Para un tipo fecha; tenemos que comprobar que efectivamente se trata de una fecha.
                        if ($columnId == "D" && \PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
                            $dateFromExcel = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue);
                            $material->setFechaAlta($dateFromExcel);
                        }
                        if ($columnId == "E") {
                            $material->setIsbn($cellValue);
                        }
                        if ($columnId == "F") {
                            $material->setNombre($cellValue);
                        }
                        if ($columnId == "G") {
                            $material->setDescripcion($cellValue);
                        }
                        if ($columnId == "H") {
                            $material->setUnidades($cellValue);
                        }
                        if ($columnId == "I") {
                            $material->setLocalizacion($cellValue);
                        }
                        if ($columnId == "J") {
                            $material->setProcedencia($cellValue);
                        }
                        if ($columnId == "K") {
                            $material->setMotivoBaja($cellValue);
                        }
                        if ($columnId == "L" && \PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
                            $dateFromExcel = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue);
                            $material->setFechaBaja($dateFromExcel);
                        }
                    } else {
                        // Ni he encontrado departamento (titulos) ni estoy viendo cada objeto 
                        // del inventario. Sigo
                        continue;
                    }
                    //echo '<td>' . $cellValue . '</td>' . PHP_EOL;
                }
                //echo '</tr>' . PHP_EOL . '<br>';
                if ($material != null) {
                    //print_r($material);
                    //Lo ingresamos en la base de datos
                    anadirMaterial($material);
                }
            }
            //PHP_EOL se utiliza para poner el \n \r .
            //echo '</table>' . PHP_EOL;
        }
    }


}
?>

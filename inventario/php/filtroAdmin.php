<?php
require_once('../../archivosComunes/conexion.php');

$filtro_departamento = $_POST['filtro_departamento'];
$filtro_fungibles = $_POST['filtro_fungible'];

if ($filtro_departamento == "0") {
    header("Location: lista.php?filtro=todos");
    exit;
} else {
    $consulta = "SELECT a.* FROM articulo a
                INNER JOIN tiene t ON a.CODIGO = t.COD_ARTICULO
                INNER JOIN departamento d ON t.COD_DEPARTAMENTO = d.codigo
                WHERE d.codigo = :COD_DEPARTAMENTO";
    $pre = $db->prepare($consulta);
    $pre->bindParam(':COD_DEPARTAMENTO', $filtro_departamento, PDO::PARAM_INT);
    $pre->execute();
    $resultado = $pre->fetchAll();

    // if (count($resultado) == 0) {
    //     echo "No se encontraron artículos para el departamento seleccionado.";
    //     exit;
    // } else {
        header("Location: lista.php?filtro=departamento&codigo=$filtro_departamento");
    //     exit;
    // }
}
?>


<?php
			session_start();
			if($_SESSION['usuario_login']['ROL'] == 0){
		?>
		<div class="container">
			<form method="post" action='filtroAdmin.php'>
				<select class="form-control" id="filtro_departamento" name="filtro_departamento">
					<option value="0">Todos</option>
					<?php 
					require_once('../../archivosComunes/conexion.php');
					$consulta = "SELECT * FROM departamento";
					$resultado = $db->query($consulta);

					foreach ($resultado as $row) {
						echo '<option value="'.$row['codigo'].'">'.$row['NOMBRE'].'</option>';
					}
					?>
				</select>
				<input type="submit" value="Filtrar">
				<?php
					if(isset($_GET['codigo'])){
				?>
				<input type="hidden" name="filtro_dpto" id="filtro_dpto" value="<?php echo $_GET['codigo'] ?>">
				<?php } ?>
			</form>
		</div>
		<br>
		<?php } ?>
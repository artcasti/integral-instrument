<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Novedades";



$actividad = $_GET['actividad'];

//echo $actividad;

if ($actividad==2) {
	$result=cargar_novedad($_GET['idnovedad']);
	$row = mysql_fetch_row($result);
//	print_r($row);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>OMG | Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>




<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-4">
						<h1>ABM de Novedades</h1>
						<form role="form" enctype="multipart/form-data" action="graba_novedades.php" method="POST">
							<div class="form-group">
								 
								<label for="tituloNovedad">
									Titulo Principal
								</label>
								<input type="text" class="form-control" id="tituloNovedad" name="titulo" 
									<?php 
									if ($actividad==2) {
										echo "value='".$row[1]."'";
									}
									?>
								>
							</div>
							<div class="form-group">
								 
								<label for="copeteNovedad">
									Copete Novedad
								</label>
								<textarea class="form-control" id="copeteNovedad" name="copete">
									<?php 
									if ($actividad==2) {
										echo $row[2];
									}
									?>

								</textarea>
							</div>

							<div class="form-group">
								 
								<label for="desarrolloNovedad">
									Desarrollo
								</label>
								<textarea class="form-control" id="desarrolloNovedad" name="desarrollo">
									<?php 
									if ($actividad==2) {
										echo $row[4];
									}
									?>
									
								</textarea>
							</div>
							<div class="form-group">
								 
								<label for="fechaVigencia">
									Fecha Vencimiento
								</label>
								<input type="date" class="form-control" id="fechaVigencia" name="vigencia"
									<?php 
									if ($actividad==2) {
										echo "value=".$row[6];
									}
									?>
								>
							</div>

							<div class="form-group">
								 
								<label for="exampleInputFile">
									Imagen Asociada
								</label>
								<input type="text" id="exampleInputFile" name="fotonovedad"
									<?php 
									if ($actividad==2) {
										echo "value='".$row[3]."'";
									}
									?>
								>
							</div>
							<div class="checkbox">
								 
								<label>
									<input type="checkbox" name="habilitado" 
									<?php 
									if ($actividad==2) {
										if($row['8']==1){
											echo 'value="1" checked="checked"';//HABILITADO
											}else {
											echo 'value="0" ';//DESABILITADO
											}				 
									}
									?>
									> Habilitada
								</label>
							</div> 
							<button type="submit" class="btn btn-default">
								Guardar
							</button>
						</form>
		</div>
		<div class="col-md-3">
		</div>
	</div>


</div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Auditoria";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>OMG | Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>


<script type="text/javascript">

function traedatos()
{
	desd = document.getElementById('desde').value;
	user = document.getElementById('user').value+'%';

	if (desd ==''){
		desde = <?php echo date('Ymd');?>;
	}else{
		cab=desd.split('-');
		desde = cab[0]+cab[1]+cab[2];
	}

	$('div#registros').html('<p><img src="images/loading_async_big.gif" ></p>');
	$("#registros").load("auditoria_detalle.php?desde="+desde+"&user="+user,null,function(){$("#registros table").tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager")});}); 
	// {$("#registros table").tablesorter( {dateFormat : "ddmmyyyy", sortList: [[3,1]],headers:{4:{sorter:false}} ,theme: 'default', widgets: [ "zebra" , "resizable" ],widthFixed: false})});
}


</script>

</script>

 <script type="text/javascript">
window.onload = function(){
traedatos();
}
</script>

</head>

<body>

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>


    <div id="content">

 <h1 align="center">Auditoría</h1>

<div id="inputs" align="center">
	<article align="center">
		<label for="fechadesde">Desde</label>
		<input type="date" id="desde"/>
		<label for="user">Usuario</label>
		<input type="text" id="user" placeholder="indice usuario"/>	
		<input type="button" name="filtro" value="Filtrar" onclick="traedatos()"/>
	</article>
</div>


<div id="registros" align="center">
	
</div>

<div id="pager" align="center">
	<form>
		<img src="img/first.png" class="first"/>
		<img src="img/prev.png" class="prev"/>
		<input type="text" class="pagedisplay"/>
		<img src="img/next.png" class="next"/>
		<img src="img/last.png" class="last"/>
		<select class="pagesize">
			<option selected="selected"  value="40">40</option>
			<option value="80">80</option>
			<option value="100">100</option>
			<option  value="500">500</option>
		</select>
	</form>	
</div>


	</div><!--fin DIV contenedor-->
	
	<!--carga el menu-->
  <div id="footer"></div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
$_SESSION['modifica']=0;
$_SESSION['modulo']="Usuarios";

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

</head>

<body>



<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>
	
	</div>  <div id="content">
    		
		<h1 align="center">Usuarios</h1>
		  
		<form id="form_usuario" name="form_usuario" method="post" action="graba_usuarios.php">  
		  
		<table align="center" class="tabla">
		<thead>
		<tr>
		<td>Id</td>
		<td>Usuario</td>
		<td>Contraseña</td>
		<td>Nombre</td>
		<td>Apellido</td>
		<td>E-Mail</td>
		<td>Perfil</td>
		<td></td><!--Para el check de Habilitado-->
		<td></td><!--Para boton Grabar-->
		</tr>
		</thead>
        <tr><td></td><!--Para el id-->
		
          <td><input type="text" name="usuario" id="usuario" /></td>
    
          <td><input type="password" name="clave" id="clave" /></td>
        
          <td><input type="text" name="nombre" id="nombre" /></td>
        
          <td><input type="text" name="apellido" id="apellido" /></td>
        
          <td><input type="text" name="email" id="email" /></td>
        
			<td>
			<select NAME="perfiles" id='perfiles'>
				<option>Seleccione una Opción...</option>
				<?php
					if (!$conexion) {
					die('No se puede conectar: ');
					}
					$con="SELECT idperfil,perfil FROM perfiles";
					$res=@$conexion->query($con);
					if(!$res){
					echo " fallo";
					}
					else{
					while ($fila=$res->fetch_array()){
					echo "<option value=".$fila['idperfil']." id='idperfil'>".$fila['perfil']."</option>";
					}
					echo "</select>";
					}
				?>
			</td>
		
            <td><input name="habilitado" type="checkbox" id="habilitado" value="1" checked="checked" /></td>
		  
			<td><input type="submit" name="btn_enviar" id="btn_enviar" value="Grabar" class="modificar" /></td>
        </form>
		</tr>
  

			<?php
			$sql = '
			SELECT u.idusuario
			,u.usuario
			,u.password
			,u.nombre
			,u.apellido
			,u.email
			,p.perfil
			,u.habilitado
			FROM usuarios u left join perfiles p on u.idperfil = p.idperfil
			                ';
			$result = $conexion->query($sql);
			?>


<?php
while ($row = mysqli_fetch_row($result)){
?>
<tr>
<td>
<a href="mod_usuarios.php?id=<?php echo $row[0];?>" class="modificar"><?php echo $row[0];?></a>
</td>
<td><?php echo $row[1];?></td>
<td><?php echo $row[2];?></td>
<td><?php echo $row[3];?></td>
<td><?php echo $row[4];?></td>
<td><?php echo $row[5];?></td>
<td><?php echo $row[6];?></td>


<td><?php
if($row[7]==1){
?>
<input name="habilitado" type="checkbox" id="habilitado" value="1" checked="checked" /><?php
}else{?>
<input name="habilitado" type="checkbox" id="habilitado" value="0" /><?php
}?>
</td>

<td>
	<a href="baja_usuario.php?id=<?php echo $row[0];?>" class="eliminar"> Eliminar </a>
</td>

</tr>
<?php
};
?>

</table>
<?php

mysqli_free_result($result);
$conexion->close();
			
// registra_log($_SESSION['modulo'],'Accede a Usuarios');	
?>

  </div>

  <div id="footer"></div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

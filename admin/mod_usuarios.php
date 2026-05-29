<?php session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}
include "functions.php";
include "conexion.php";
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


  <div id="content">
    	
		<form id="form_usuario" name="form_usuario" method="post" action="graba_usuarios.php">  
		
<!--TRAIGO LOS DATOS DEL USUARIO DE LA BD Y LO GUARDO EN LA VARIABLE "$FILA"-->
<?php $fila= modifica_usuario($_GET['id']); 
$_SESSION['modifica']=$fila[0];

?>  
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
		
          <td><input type="text" name="usuario" id="usuario" value="<?php echo $fila[1]?>"/></td>
    
          <td><input type="password" name="clave" id="clave" value="<?php echo base64_decode($fila[2])?>"/></td>
        
          <td><input type="text" name="nombre" id="nombre" value="<?php echo $fila[3]?>"/></td>
        
          <td><input type="text" name="apellido" id="apellido" value="<?php echo $fila[4]?>"/></td>
        
          <td><input type="text" name="email" id="email" value="<?php echo $fila[5]?>"/></td>
        
			<td>
			<select NAME="perfiles" id='perfiles'>
				<option>Seleccione una Opción...</option>
				<?php
					if (!$conexion) {
					die('No se puede conectar: ' . mysql_error());
					}
					$con="SELECT idperfil,perfil FROM perfiles";  
					$res=@mysql_query($con,$conexion);
					
					if(!$res){
						die('No se puede conectar: ' . mysql_error());
					}
					else{
										
						while ($perfil=mysql_fetch_array($res)){
						    //SETEO EN 'SELECTED' EL PERFIL DEL USUARIO
						    if($perfil['idperfil'] == $fila['idperfil'])
						    {
							echo "<option selected='selected' value='".$perfil['idperfil']." id='idperfil'>".$perfil['perfil']."</option>";
						    }
						    else
						    {
							echo "<option value='".$perfil['idperfil']."'>".$perfil['perfil']."</option>";
						    }//end IF
						}//end WHILE
					}//end IF
				?>
			</td>
		

          <!--CONTROLO SI EL USUARIO SE ENCUENTRA HABILITADO O NO-->
          <?php 
	  if($fila['habilitado']==1){          
		echo"<td><input name='habilitado' type='checkbox' id='habilitado' value=1 checked='checked' /></td>";//HABILITADO
	}else {
	     echo"<td><input name='habilitado' type='checkbox' id='habilitado' value=0 /></td>";//DESABILITADO
	  }

	  //CONTROLO SI EL USUARIO CAMBIÓ EL VALOR DEL CHECKBOX ASÍ LO GUARDO
	  
          
	?>
	<td><input type="submit" name="btn_enviar" id="btn_enviar" value="Grabar" class="modificar" /></td>
	</tr>
    </form>

  <h1 align="center">Usuarios</h1>
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
			$result = mysql_query($sql, $conexion);
			?>


<?php
while ($row = mysql_fetch_row($result)){
if($fila[0]!=$row[0]){ //FILTRO EL USUARIO QUE ESTOY MODIFICANDO
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
} //FIN IF
}; //FIN WHILE
?>

</table>
<?php
mysql_free_result($result);
mysql_close();
?>

  </div>

  <div id="footer"></div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
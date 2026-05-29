<?php include "php/header.inc" ?>

<?php
include("conexion.php");
?>
	<h1 align="center">Menues Aplicacion</h1>
  
    <form id="form_menu" name="form_menu" method="post" action="menu_padre_procesa.php">
      <table align="center" class="tablareducida">
		<tr>
		<td>IdPadre</td>
		<td>Label</td>
		<td>Orden</td>
		<td></td>
		</tr>
        <tr>
          <td><input type="text" name="idpadre" id="idpadre" /></td>
        
          <td><input type="text" name="label" id="label" /></td>
       
          <td><input type="text" name="orden" id="orden" /></td>
        
      
          <td colspan="4" align="center"><input type="submit" name="btn_enviar" value="Grabar" class="modificar" />
        </tr>

    </form>
  
<?php
$result = mysql_query("SELECT * FROM menupadre order by idpadre", $conexion);
?>


<?php
while ($row = mysql_fetch_row($result)){
?>
<tr>
<td>
<a href="menu_padre_mod.php?id=<?php echo $row[0];?>" class="modificar"><?php echo $row[0];?></a>
</td>
<td><?php echo $row[1];?></td>
<td><?php echo $row[2];?></td>
<td>
	<a href="baja_menu.php?id=<?php echo $row[0];?>" class="eliminar"> Eliminar </a>
</td>

</tr>
<?php
};
?>

</table>
<?php
mysql_free_result($result);
mysql_close();
?>

  </div>

  <div id="footer"></div>
</div>
</body>
</html>
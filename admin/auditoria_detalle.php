<?php
session_start();
if (!isset($_SESSION['k_username'])){
header("Location: login.html");
}

include("conexion.php");
include "functions.php";


 
 $fecha = $_GET['desde'];
 $user = $_GET['user'];

      $consulta="SELECT usuario, modulo, actividad, fecha, hora, minutos, segundos, ip FROM logs where fecha>=$fecha and usuario like '$user' order by fecha desc, hora desc, minutos desc";
      $datos=mysql_query($consulta,$conexion);
    ?>

<table class="tablesorter tabla" >
<thead>
<tr>
<td>id</td>
<td>Usuario</td>
<td>Modulo</td>
<td>Actividad</td>
<td>Fecha</td>
<td>IP</td>
</tr>
</thead>
<tbody>

    <?php
    if(!$datos){
    //SI FALLA LA CONSULTA MUESTRO ERROR
    die('Invalid query: ' . mysql_error());
    }
    else
    {

    $id = 1;

    while ($row = mysql_fetch_row($datos))
    { 
    $hora = $row[3].':'.$row[4].':'.$row[5];
    ?>
    <tr>
    <td align="center"><?php echo $id;?></td>
    <td align="left"><?php echo utf8_encode($row[0]);?></td>
    <td align="left"><?php echo utf8_encode($row[1]);?></td>
    <td align="left"><?php echo utf8_encode($row[2]);?></td>
    <td align="left"><?php echo $row[3].' '.$hora;?></td>
    <td align="center"><?php echo $row[7];?></td>
    </tr>

    <?php
    $id++;
    }};
    ?>
</tbody>
</table>
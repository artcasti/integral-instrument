<?php
session_start();

include "functions.php";
require_once("class/filereader.php");

  $path = $_GET['path'];
  $lineBreak = $_GET['corte'];
  $size = $_GET['size'];
//echo $path;
?> 

<h1>Carpeta de Imagenes</h1>
<table class="tabla" border=1 align="center">
<thead>
<tr>
<td colspan="<?php echo $lineBreak;?>" align="center">Imagenes Disponibles</td>
</tr>
</thead>
<tbody>
<?php

$dir = new filereader($path);
$hoy = date('Ymd');
?>

<?php 

    set_time_limit(120);
$lista = $dir->LeerDirectorio(); 
for($i=0;$i<count($lista);$i++){
  if ($i === 0 || $i % $lineBreak === 0) { 
    echo "<tr>"; 
      } 
?>

<td align="center"><img src='<?php echo $path."/".$lista[$i];?>' height="<?php echo $size;?>" width="<?php echo $size;?>"><input type="checkbox" id=<?php echo 'img_'.$i; ?> name="imagenes[]"  value = <?php echo $lista[$i];?> > </td>

<?php

};
?>
</tbody>
</table>
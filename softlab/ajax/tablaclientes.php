<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$filtro = $_GET['filtro'];

  $resultado = $cm->getListaClientes($filtro);
  while ($row=$resultado->fetch_array()){ 
  ?>
<tr class="active">
  <th scope="row"><?php echo $row[21];?></th>
  <td><?php echo $row[2];?></td>
  <td><?php echo $row[3];?></td>
  <td><?php echo $row[19];?></td>
  <td><?php echo $row[6];?></td>
  <td><?php echo $row[14];?></td>
  <td><a href="form_clientes.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
  <a href="form_documentos.php?id=<?php echo $row[0];?>&tipo=2"><i class="fa fa-file-pdf-o nav_icon" title="Documentos Asociados"></i></a>
  <a href="#" data-href="class/manager_abms.php?accion=eliminacliente&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o nav_icon" title="Eliminar"></i></a>

  </td>
</tr>

<?php } ?>
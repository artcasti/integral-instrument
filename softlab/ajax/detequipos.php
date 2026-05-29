						<table class="table">
						  <thead>
							<tr>
							  <th>Nombre</th>
							  <th>Familia</th>
							  <th>Subfamilia</th>
							  <th>Marca</th>
							  <th>Modelo</th>							  
							  <th>Nro de Serie</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                          require_once("../class/clases.php");
                              $cm = new ConfigurationManager();
                              $filtro=$_GET['filtro'];
                           
                              $resultado = $cm->getListaEquipos($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <td><?php echo $row['nombre'];?></td>
							  <td><?php echo $row['familia'];?></td>
							  <td><?php echo $row['subfamilia'];?></td>							  
							  <td><?php echo $row['marca'];?></td>
							  <td><?php echo $row['modelo'];?></td>
							  <td><?php echo $row['nroserie'];?></td>
							  <td><a href="form_equipos.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                              <a href="form_documentos.php?id=<?php echo $row[0];?>&tipo=3"><i class="fa fa-file-pdf-o nav_icon" title="Documentos Asociados"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminaequipo&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o nav_icon" title="Eliminar"></i></a>
                              
							  </td>
							</tr>
							
							<?php } ?>
							<tr>
						  </tbody>
						</table>
                           

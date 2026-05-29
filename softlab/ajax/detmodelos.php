
						<table class="table">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Marca</th>
							  <th>Modelo</th>
							  <th>Imagen</th>
							  <th>Sitio Web</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                              require_once("../class/clases.php");
                              $cm = new ConfigurationManager();
                              $idmarca=$_GET['idmarca'];
                              $resultado = $cm->getListaModelos($idmarca);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><?php echo $row[2];?></td>
							  <td><img src="images/modelos/<?php echo $row[3];?>" width="50px" alt=""></td>
							  <td><a href="<?php echo $row[4];?>" target="_blank"><?php echo $row[4];?></a></td>
							  <td><a href="form_modelos.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminamodelo&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o" title="Eliminar"></i></a>
                              <a href="#"><i class="fa fa-file-pdf-o" title="Documentos Asociados"></i></a>
							  </td>
							</tr>
							
							<?php } ?>
							<tr>
						  </tbody>
						</table>
						
					
				
			
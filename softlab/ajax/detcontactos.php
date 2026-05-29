					
						<table class="table">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Cliente</th>
							  <th>Contacto</th>
							  <th>Email</th>
							  <th>Teléfono</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                              require_once("../class/clases.php");
                              $cm = new ConfigurationManager();
                              $idcliente=$_GET['idcliente'];
                           
                              $resultado = $cm->getListaContactos($idcliente);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[21];?></td>
							  <td><?php echo $row[1];?></td>
							  <td><?php echo $row[4];?></td>
							  <td><?php echo $row[3];?></td>
							  <td><a href="form_contactos.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminacontacto&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o nav_icon" title="Eliminar"></i></a>
							  </td>
							</tr>
							
							<?php } ?>
							<tr>
						  </tbody>
						</table>
				
			
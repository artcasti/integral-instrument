						<table class="table">
						  <thead>
							<tr>
							  <th>Id</th>
							  <th>Familia</th>
							  <th>Subfamilia</th>
							  <th>Acciones</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
                          require_once("../class/clases.php");
                              $cm = new ConfigurationManager();
                              $idfamilia=$_GET['idfamilia'];
                           
                              $resultado = $cm->getListaSubfamilias($idfamilia);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[0];?></th>
							  <td><?php echo $row[4];?></td>
							  <td><?php echo $row[1];?></td>
							  <td><a href="form_subfamilias.php?id=<?php echo $row[0];?>" ><i class="fa fa-edit nav_icon" title="Editar"></i></a>
                              <a href="#" data-href="class/manager_abms.php?accion=eliminasubfamilia&id=<?php echo $row[0];?>" data-toggle="modal" data-target="#myModalConfirm"><i class="fa fa-trash-o nav_icon" title="Eliminar"></i></a>
							  </td>
							</tr>
							
							<?php } ?>
						  </tbody>
						</table>			
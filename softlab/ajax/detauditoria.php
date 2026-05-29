						<table class="table">
						  <thead>
							<tr>
							  <th>Fecha y Hora</th>
							  <th>Módulo</th>
							  <th>Actividad</th>
							  <th>Usuario</th>
							  <th>Dirección IP</th>							  
							</tr>
						  </thead>
						  <tbody>
						  <?php
                          require_once("../class/clases.php");
                              $cm = new ConfigurationManager();
                              $filtro=$_GET['filtro'];
                           
                              $resultado = $cm->getListaEventos($filtro);
                              while ($row=$resultado->fetch_array()){ 
                              ?>
							<tr class="active">
							  <th scope="row"><?php echo $row[3];?></th>
							  <td><?php echo $row[1];?></td>
							  <td><?php echo $row[2];?></td>
							  <td><?php echo $row[4];?></td>
							  <td><?php echo $row[5];?></td>
							</tr>
							
							<?php } ?>
							<tr>
						  </tbody>
						</table>

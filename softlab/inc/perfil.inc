					<li class="dropdown">
		              <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown"><span class=" name-caret"><?php echo $_SESSION['nombre'];?><i class="caret"></i></span><img src="images/<?php echo $_SESSION['imagen'];?>" width="60px"></a>
		              <ul class="dropdown-menu " role="menu">
		                <li><a href="#"><i class="fa fa-user"></i>Editar Perfil</a></li>
		                <li><a href="#"><i class="fa fa-envelope"></i>Inbox</a></li>
		                <li><a href="#"><i class="fa fa-clipboard"></i>Tareas</a></li>
                        <li><a href="logout.php"><i class="fa fa-power-off"></i>Cerrar Sesión</a></li>
		              </ul>
		            </li>
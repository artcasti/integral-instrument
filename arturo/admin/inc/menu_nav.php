	<div class="row">
		<div class="col-md-1 fondo-gris">
		</div>
			<div class="row">

				<div class="col-md-10">
					<nav class="navbar navbar-default navbar-inverse" role="navigation">
							
							<div class="navbar-header">
								 
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
									</button> <a class="navbar-brand" href="index.php"><strong>Panel General</strong></a>
							</div>
							
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<?php 
								crear_menu_padre_bst($_SESSION['idperfil']);
								 ?> 

								 <ul class="nav navbar-nav navbar-right">
    	    						<li><a href="logout.php">Salir</a></li>
    	    					</ul>
							</div>
					</nav>
				</div>
			</div>
		<div class="col-md-1">
	</div> 
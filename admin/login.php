<?php 
header('Content-Type: text/html; charset=utf-8'); 
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Integral Instrument | Iniciar Sesión</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles.css">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="../img/favicon.ico">
</head>
<body>
	<div class="wrapper login">
		
		<div class="contain content">
			<header class="header">
				<div class="contain">
                    <div class="logo_texto_admin">
                    Integral Instrument
                    </div>
				</div>
			</header>
			<form class="form" id="form_usuario" name="form_categ" method="post" action="autenticausuario.php">
				<fieldset>
					<div class="col">
						<label>USUARIO <span class="tooltip">?</span></label>
						<input type="text" name="usuario">

						<label>CONTRASEÑA <span class="tooltip">?</span></label>
						<input type="password" name="clave">
					</div>
				</fieldset>

				<input type="submit" value="LOGIN">

			</form>
		</div>
	</div>
	
</body>
</html>
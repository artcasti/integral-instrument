<?php 
header('Content-Type: text/html; charset=utf-8'); 

session_start();

if (!isset($_SESSION['k_username'])){
header("Location: login.php");
}
include "functions.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/logo_ico.ico">

<title>Panel de Control</title>
   
    <link href="css/bootstrap.min.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/jquery-ui.js"></script>

</head>
<body>

<div class="container-fluid">

<?php  include("inc/menu_nav.php");?>


	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
		

		
	 	</div>
	 	<div class="col-md-1">
		</div>
	</div>

	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
					<div id="movs" align="center"></div>
		</div>
	 	<div class="col-md-1">
		</div>
	</div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
 
</body>
</html>


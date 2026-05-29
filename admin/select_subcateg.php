<?php
include "functions.php";

$cat = $_GET['categ'];
$seleccionado = $_GET['item'];

?>
<select id='subcategoria' name='subcategoria' >
<option value=''>Seleccione...</option>	
<?php
carga_selected("subcategorias",$seleccionado,$cat);

?>
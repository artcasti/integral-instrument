<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();
$combo=$_GET['combo'];
$opcion=$_GET['opcion'];
$id=$_GET['id'];
?>
  <option value="0">Seleccione...</option>
  <?php

 $cm->carga_selected($combo,$opcion,$id); 


?>
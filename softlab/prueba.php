
<?php
require_once("class/clases.php");
require_once("class/AppException.php");

try
{
    echo "Inicializando el sistema...";
$db= new conectar;
$conn = $db->con_mysql();    
}
catch (Exception $ex)
{
    echo "Algo no le gusto";
}

/* Consultas de selección que devuelven un conjunto de resultados */

if ($resultado= mysqli_query("SELECT * FROM menupadre",$conn))
{
    echo '<pre>';
    var_dump($resultado->fetch_array());
    printf("La selección devolvió filas.\n");
}

?>
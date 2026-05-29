<?php
require_once("../class/clases.php");
$cm = new ConfigurationManager();

$tipodoc=$_GET['tipodoc'];
$nrodoc=$_GET['nrodoc'];

$infoitem=$cm->getDoc($tipodoc,$nrodoc); 

if($infoitem[0]==0)
{
	echo 'OK';
}
else
{
	echo 'NO';
}

?>
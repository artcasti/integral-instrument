<?php 

class filereader 
{

//atributos
	var $_ruta = "";
	private $_listafiles=array();



public function __construct($path){

	$this->_ruta = $path;
}




//function LeerDirectorio($path) : Devuelve el contenido del directorio
public function LeerDirectorio()
{
 
$directorio = opendir($this->_ruta); //ruta actual

while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (!is_file($archivo) )//verificamos si es o no un directorio
    {
        if ($archivo == '.' || $archivo == '..') { 
            continue; 
        }else{ 
        $this->_listafiles[]=$archivo;}
    }


 }
  return $this->_listafiles;
}

}

?>
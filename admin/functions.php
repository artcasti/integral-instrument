<?php

function get_client_ip() {
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if($_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if($_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if($_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if($_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';
     return $ipaddress; 
}




function crear_menu_padre_bst($perfil){
include("conexion.php");
if ($perfil==1){
$peticion = "SELECT * FROM `menupadre` order by orden";}else{
$peticion = "SELECT * FROM `menupadre` WHERE idpadre in (select idpadre from menu where idmenu in (select idmenu from menuperfil where idperfil =".$perfil.")) order by orden;";
}
$result = $conexion->query($peticion);
//echo "<ul>";
echo "<ul class='nav navbar-nav'>";
while ($fila = $result->fetch_array()){
//echo "<li class='nivel1'><a href=".'#'." class='nivel1'>".utf8_encode($fila[1])."</a>";
echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.mb_convert_encoding($fila[1], 'UTF-8', 'ISO-8859-1').'</a>';
crear_menu($perfil,$fila[0]);
}
echo "</li></ul>";
}

function crear_menu_flex($perfil){
include("conexion.php");
if ($perfil==1){
$peticion = "SELECT * FROM `menu` order by orden";}else{
$peticion = "SELECT * FROM `menu` where idmenu in (select idmenu from menuperfil where idperfil=".$perfil.") order by orden;";
}
$result = $conexion->query($peticion);
while ($fila = $result->fetch_array()){
echo '<a href="'.$fila[2].'" class="menues">'.utf8_encode($fila[1]).'</a>';
}
}


function crear_menu($perfil,$padre){
include("conexion.php");

if ($perfil==1){
$peticion = "SELECT * FROM `menu` where idpadre =".$padre." order by orden";}else{
$peticion = "SELECT * FROM `menu` where idmenu in (select idmenu from menuperfil where idperfil=".$perfil.") and idpadre =".$padre." order by orden;";
}
$result = $conexion->query($peticion);
//echo "<ul class='nivel2'>";
echo '<ul class="dropdown-menu">';
while ($fila = $result->fetch_array()){
echo "<li><a href=".$fila[2].">".$fila[1]."</a>";
if ($fila[2]=='')
	{
	crear_menu($perfil,$fila[0]);

	}
	echo "</li>";
}
echo "</ul>";
}

function modifica_menu($id){
include("conexion.php");

$peticion = "SELECT * FROM `menu` WHERE idmenu =".$id.";";
$result = $conexion->query($peticion);
$fila = $result->fetch_array();

return $fila;

$conexion->close();		

}

function carga_combo_perfil(){
include("conexion.php");

$peticion = "SELECT * FROM campaus.perfiles;";
$result = $conexion->query($peticion);
$fila = $result->fetch_array();

echo"<SELECT NAME='perfiles'>
<option>Seleccione...</option>";
while ($fila){
echo'<OPTION VALUE="'.$row['idperfil'].'">'.$row['perfil'].'</OPTION>';
}
echo"</SELECT>";
$conexion->close();		

}

function carga_permiso($menu, $perfil){
include("conexion.php");
$consulta = "INSERT INTO `campaus`.`menuperfil` (`idmenu`, `idperfil`) VALUES ('$menu', '$perfil');";

$result = $conexion->query($consulta);
if($result){
	//echo "Se ha creado el menu";
//echo $idmenu." ".$consulta;
	header("Location: alta_permiso.php");
	} else{
echo $consulta;
	echo "<br> no se pudo insertar el menu por: " ;

}
}

function carga_select($select,$opcion){
include("conexion.php");

	if (!$conexion) {die('No se puede conectar: '  );}

switch ($select) {	
    case "perfiles":
			$con="SELECT idperfil,perfil FROM perfiles";
			$res=@$conexion->query($con);
			if(!$res){
			echo " fallo";
			}
			else{
			while ($fila=$res->fetch_array()){
			echo "<option value=".$fila['idperfil']." id='idperfil'>".$fila['perfil']."</option>";
			}
			echo "</select>";
			}
        break;
	 case "perfiles2":
			$con="SELECT idperfil,perfil FROM perfiles order by perfil";
			$res=@$conexion->query($con);
			if(!$res){
			echo " fallo";
			}
			else{
			while ($fila=$res->fetch_array()){
			echo "<tr><td>".$fila['perfil']."</td><td> <input type='checkbox' name='perfiles[]'value=".$fila['idperfil']." id='idperfil' ></td></tr>";
			}
			
			}
        break;
	 case "menues2":
			$con="SELECT idmenu, label FROM `menu` order by label";;
			$res=@$conexion->query($con);
			if(!$res){
			echo " fallo";
			}
			else{
			while ($fila=$res->fetch_array()){
			echo "<tr><td>".$fila['label']."</td><td> <input type='checkbox' name='menues[]' value=".$fila['idmenu']." id='idmenu'></td></tr>";
			}
			
			}
        break;	
    case "menues":
			$con="SELECT idmenu, label FROM `menu` order by orden";;
			$res=@$conexion->query($con);
			if(!$res){
			echo " fallo";
			}
			else{
			while ($fila=$res->fetch_array()){
			echo "<option value=".$fila['idmenu']." id='idmenu'>".$fila['label']."</option>";
			}
			echo "</select>";
			}
        break;
	    case "meses":
			$con="SELECT idmes, mes FROM `meses` order by idmes";;
			$res=@$conexion->query($con);
			if(!$res){
			echo " fallo";
			}
			else{
			while ($fila=$res->fetch_array()){
			echo "<option value=".$fila['idmes']." id='idmes'>".$fila['mes']."</option>";
			}
			echo "</select>";
			}
        break;	
	
	}
}

	
function mes($id){

switch ($id) {
    case "1":
			$texto = "Enero";
        break;	
    case "2":
			$texto = "Febrero";
        break;	
    case "3":
			$texto = "Marzo";
        break;	
    case "4":
			$texto = "Abril";
        break;	
    case "5":
			$texto = "Mayo";
        break;	
    case "6":
			$texto = "Junio";
        break;	
    case "7":
			$texto = "Julio";
        break;	
    case "8":
			$texto = "Agosto";
        break;	
    case "9":
			$texto = "Septiembre";
        break;	
    case "10":
			$texto = "Octubre";
        break;	
    case "11":
			$texto = "Noviembre";
        break;	
    case "12":
			$texto = "Diciembre";
        break;	
		}
return $texto;	
}	



function registra_log($modulo,$actividad)
{
	//datos para establecer la conexion con la base de mysql
	include("conexion.php");
	//almacena solo fecha
	$fecha_log = date('Ymd');
	
	//almacena fecha y tiempo por unidad
	$anio = date('Y');
	$mes = date('m');
	$dia = date('d');
	//$hora = date('G') - 4;	//Reajusto la hora para corregir el huso horario de Argentina
	$hora = date('G');	
	$minutos = date('i');
	$segundos = date('s');
	
	$usuario = $_SESSION["k_username"];
	@$ip = get_client_ip();		//utilizo la funcion para obtener la IP del cliente
	@$browser = $_SERVER["HTTP_USER_AGENT"];									
	
	$conexion->query('INSERT INTO logs (modulo,actividad, anio, mes, dia, hora, minutos, segundos, browser, fecha, usuario,ip) values (\''.$modulo.'\',\''.$actividad.'\', \''.$anio.'\',\''.$mes.'\',\''.$dia.'\',\''.$hora.'\',\''.$minutos.'\',\''.$segundos.'\',\''.$browser.'\',\''.$fecha_log.'\',\''.$usuario.'\', \''.$ip.'\')');
	
	$conexion->close();
}



function modifica_usuario($idusuario){
include("conexion.php");

$peticion = "SELECT * FROM usuarios WHERE idusuario =".$idusuario.";";
$result = $conexion->query($peticion);
$fila = $result->fetch_array();

return $fila;

$conexion->close();		

}

//FUNCION PARA SEPARAR UNA CADENA CON EL CARACTER DESEADO
function separa_cadena($id, $caracter){

//FUNCION EXPLODE PARA DIVIDIR CADENA DE TEXTO
$cadena = explode($caracter,$id);

/*echo $cadena[0];
echo $cadena[1];
echo $cadena[2]; */

return $cadena;
}

function modifica_menu_padre($id){
include("conexion.php");

$peticion = "SELECT * FROM `menupadre` WHERE idpadre =".$id.";";
$result = $conexion->query($peticion);
$fila = $result->fetch_array();

return $fila;

$conexion->close();		

}

function modifica_perfil($id){
include("conexion.php");

$peticion = "SELECT * FROM `perfiles` WHERE idperfil =".$id.";";
$result = $conexion->query($peticion);
$fila = $result->fetch_array();

return $fila;

$conexion->close();		

}


function carga_selected($select,$opcion_seleccionada,$id){
include("conexion.php");

	switch($select){
		case "categorias":
			$sql = "select * from categorias where habilitado=1 order by descripcion";

			$res=@$conexion->query($sql);
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='categoria' selected='selected'>".utf8_decode($fila[1])."</option>";
					}else{
					echo "<option value=".$fila[0]." id='categoria'>".utf8_decode($fila[1])."</option>";
					}
				}
			echo "</select>";

			}
		break;
		case "galerias":
			$sql = "select * from galerias order by nombre";

			$res=@$conexion->query($sql);
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='selgaleria' selected='selected'>".utf8_decode($fila[1])."</option>";
					}else{
					echo "<option value=".$fila[0]." id='selgaleria'>".utf8_decode($fila[1])."</option>";
					}
				}
			echo "</select>";

			}
		break;
		case "subcategorias":
			$sql = "select * from subcategorias where idcategoria = '$id' order by descripcion";

			$res=@$conexion->query($sql);
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='subcategoria' selected='selected'>".utf8_decode($fila[1])."</option>";
					}else{
					echo "<option value=".$fila[0]." id='subcategoria'>".utf8_decode($fila[1])."</option>";
					}
				}
			echo "</select>";

			}
		break;
		case "imagenesdisponibles":
			require_once("class/filereader.php");

    		$path = $id;
			$dir = new filereader($path);
			$lista = $dir->LeerDirectorio(); 

				for($i=0;$i<count($lista);$i++){
					if ($lista[$i]==$opcion_seleccionada){
					echo "<option value=".$lista[$i]." id='imagendisp' selected='selected'>".utf8_decode($lista[$i])."</option>";
					}else{
					echo "<option value=".$lista[$i]." id='imagendisp'>".utf8_decode($lista[$i])."</option>";
					}
				}
			echo "</select>";
		break;		
	}
}

function listar_usuarios(){
include("conexion.php");

$peticion = "
			SELECT u.idusuario
			,u.usuario
			,u.password
			,u.nombre
			,u.apellido
			,u.email
			,p.perfil
			,u.habilitado
			, if(s.nom_sucursal >=0,s.nom_sucursal,'Todas')
			,u.vdorid
			FROM usuarios u left join perfiles p on u.idperfil = p.idperfil
			                left join sucursales s on u.nro_suc = s.nro_suc
			                where u.habilitado =1;       ";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		

}

function listar_novedades($estado){
include("conexion.php");

$peticion = "
			SELECT  `idNovedad` 
			,  `titulo` 
			,  `copete` 
			,  `imagen` 
			,  `fechaalta` 
			,  `habilitado`
			FROM  `novedades` 
			WHERE  `habilitado` in (".$estado.")
			AND  `fechavigencia` > NOW( ) 
			order by idNovedad desc
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		
}

function listar_servicios($estados){
include("conexion.php");
		if ($estados=='*') {
		$estado='"0","1"';
		}else{
		$estado=$estados;	
		}
$peticion = "
			SELECT s.idservicio,
					s.nombre,
			        s.idcategoria,
			       c.descripcion,
			        s.idsubcategoria,
			        sc.descripcion,
			        s.imagen,
			        s.idgaleria,
			        g.nombre,
			        s.habilitado,
                    s.destacado
			FROM `servicios` as s left join `categorias` as c  on s.idcategoria = c.idcategoria
								left join `subcategorias` as sc  on s.idsubcategoria = sc.idsubcategoria 
			                    left join `galerias` as g  on s.idgaleria = g.idgaleria 
			WHERE s.habilitado in (".$estado.")			
			order by s.idservicio desc
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		
}


function listar_articulos_publicados($categoria){
include("conexion.php");
$peticion = "
			SELECT s.idservicio,
					s.nombre,
			        s.idcategoria,
   			        c.descripcion,
			        s.idsubcategoria,
			        sc.descripcion,
			        s.imagen,
			        s.idgaleria,
			        g.nombre,
			        s.habilitado,
                    s.destacado,
                    s.descripcion
			FROM `servicios` as s left join `categorias` as c  on s.idcategoria = c.idcategoria
								left join `subcategorias` as sc  on s.idsubcategoria = sc.idsubcategoria 
			                    left join `galerias` as g  on s.idgaleria = g.idgaleria 
			WHERE s.idcategoria = ".$categoria."			
			order by s.idservicio desc
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		
}

function listar_articulos_subcategorias($subcategoria){
include("conexion.php");
$peticion = "
			SELECT s.idservicio,
					s.nombre,
			        s.idcategoria,
   			        c.descripcion,
			        s.idsubcategoria,
			        sc.descripcion,
			        s.imagen,
			        s.idgaleria,
			        g.nombre,
			        s.habilitado,
                    s.destacado,
                    s.descripcion
			FROM `servicios` as s left join `categorias` as c  on s.idcategoria = c.idcategoria
								left join `subcategorias` as sc  on s.idsubcategoria = sc.idsubcategoria 
			                    left join `galerias` as g  on s.idgaleria = g.idgaleria 
			WHERE s.idsubcategoria = ".$subcategoria."			
			order by s.idservicio desc
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		
    
}

function listar_articulos_busqueda($categoria,$cadena){
include("conexion.php");
$peticion = "SELECT s.idservicio, 
                    s.nombre, 
                    s.idcategoria, 
                    c.descripcion, 
                    s.idsubcategoria, 
                    sc.descripcion, 
                    s.imagen, 
                    s.idgaleria, 
                    g.nombre, 
                    s.habilitado, 
                    s.destacado, 
                    s.descripcion 
                    FROM `servicios` as s left join `categorias` as c on s.idcategoria = c.idcategoria 
                                            left join `subcategorias` as sc on s.idsubcategoria = sc.idsubcategoria 
                                            left join `galerias` as g on s.idgaleria = g.idgaleria 
                    WHERE s.nombre LIKE '%".$cadena."%' 
                        and s.idcategoria = ".$categoria."
        
                    order by s.idservicio desc";
    
$result = $conexion->query($peticion);


return $result;

$conexion->close();		
    
}


function listar_todas_novedades(){
include("conexion.php");

$peticion = "
			SELECT *
			FROM  `novedades` 
			order by idNovedad desc
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		

}


function cargar_novedad($idnovedad){
include("conexion.php");

$peticion = "
			SELECT  *
			FROM  `novedades` 
			WHERE  `idnovedad` =".$idnovedad."
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		

}

function get_ultimo_servicio(){
include("conexion.php");
$peticion = "SELECT max(idservicio) FROM `servicios`";

$result = $conexion->query($peticion);
$fila = $result->fetch_array();
return $fila[0];
}

function listar_guias($estados){
include("conexion.php");
		if ($estados=='*') {
		$estado='"0","1"';
		}else{
		$estado=$estados;	
		}
$peticion = "
			SELECT idguia,
                    titulo,
                    descripcionguia,
                    habilitado
			FROM `ayuda` 
			WHERE habilitado in (".$estado.")			
			order by idguia 
			";
$result = $conexion->query($peticion);

return $result;

$conexion->close();		
}

function get_texto($id){
    include("conexion.php");
    
    $peticion = "
			SELECT * FROM `texto_sitio` WHERE `idtexto`=".$id."
			";
    
$result = $conexion->query($peticion);
    
$fila = $result->fetch_array();    
return $fila[1];

$conexion->close();    
}

function armar_parrafos($cadena){
$order   = array("\n", "\r");
$replace = '<br>';

// Processes \r\n's first so they aren't converted twice.

    $newstr = str_replace($order, $replace, $cadena);

return $newstr;    
}

?>
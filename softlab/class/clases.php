<?php
//header('Content-Type: text/html; charset=utf-8'); 
require_once("AppException.php");
require_once("mysql.class.php");
/*
Descripcion: Clase para conexion con motor de base de datos
Autor: Arturo Castillo

*/
class conectar
{

    private $myServer;
    private $myUser;
    private $myPass;
    private $myDB;

    private function LoadConfigValues()
    {
        try
        {
            $config = parse_ini_file("appconfig.ini",1);
            $this->myUser = $config['mysql_base']['db_username'];
            $this->myPass = $config['mysql_base']['db_password'];
            $this->myDB = $config['mysql_base']['database'];
            $this->myServer = $config['mysql_base']['db_host'];
            
            if ($this->myUser === null OR $this->myPass === null OR $this->myDB === null OR $this->myServer === null)
            {
                throw new ConfigurationException("No se pueden leer los valores de configuracion");
            }
        }
        
        catch(ConfigurationException $ex)
        {
            throw $ex;
        }
        
        catch(Exception $ex)
        {
            throw $ex;
        }
    }     
    
public function con_mysql()
    {

        $this->LoadConfigValues();
        $conexion=new mysqli($this->myServer, $this->myUser, $this->myPass, $this->myDB) ;
        $conexion->set_charset("utf8");
        
/* $conexion=new mysqli("localhost:3306", "omg_admin", "proser_admin", "laboratorio") ;
  $conexion->set_charset("utf8");
*/  
        return $conexion;
    }
    
public function close($conexion)
    {
     mysql_close($conexion); 
    }    
}

class LoginUsuario{
    
    //Metodos
    public function ValidaCredenciales($user, $pass)
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT * FROM usuarios WHERE usuario='$user'");
        
        if($resultado){
            if (!$resultado)
            {
                return 'e';//No existe el usuario
            }
            else
            {

                $reg = $resultado->fetch_array();
                //echo var_dump($reg[1]);
                if ($reg[7]==0)
                {
                    return 'd'; //Usuario Deshabilitado 
                }
                else
                {
                    if ($reg[2]==$pass)
                    {
                        return $reg[0];//Credenciales validas
                    }
                    else
                    {
                        return 'p'; //Contraseña invalida
                    }
                }
                
            }
            
        }else{
            echo "<br> no se pudo ejecutar la consulta: ";
        }    
        $$conn->close();
        
    }
    
        public function GetDatosUsuario($id)
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT * FROM usuarios WHERE idusuario=$id");
            return $resultado->fetch_array();
        $$conn->close();    
    }

}


class ConfigurationManager{
    
    public function get_client_ip() {
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
    
    public function registra_log($modulo,$actividad)
    {
        $db= new conectar;
        $conn = $db->con_mysql(); 
        
        //almacena solo fecha
		date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha_log = date("Y-m-d H:i:s");

        $usuario = $_SESSION["username"];
        @$ip = $this->get_client_ip();		//utilizo la funcion para obtener la IP del cliente
        @$browser = $_SERVER["HTTP_USER_AGENT"];						        
        $resultado= $conn->query("INSERT INTO auditoria (`identrada`,`modulo`,`actividad`,`fechalog`,`username`,`ipcliente`,`browser`) VALUES ('','$modulo','$actividad','$fecha_log','$usuario','$ip','$browser')");

        return $resultado;
        $conn->close();			

    }
    
    //Metodos
    public function getListaMenu()
    {

        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT * FROM menu" );

        return $resultado;
         $conn->close();

    }
    
        public function getMenu($id)
    {

        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT * FROM menu WHERE idmenu=$id" );

        return $resultado->fetch_array();
        $conn->close();

    }
        
    public function grabaMenu($label,$href,$icono,$idmenupadre,$orden)
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $peticion = "INSERT INTO `menu` (`idmenu`,`menu`,`href`,`icono`,`idmenupadre`,`orden`) VALUES ('','$label','$href','$icono',$idmenupadre,$orden)";
        
        $resultado= $conn->query($peticion );
        if($resultado){
        $this->registra_log('Menu','Se ha creado el menu:'.$label);
        return TRUE;
        }else{
            echo "<br> no se pudo ejecutar la consulta: " ;
        }    
        $conn->close();
    }

        public function getUltimoIDMenu()
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT MAX(idmenu) FROM menu" );
        if($resultado){
            $result = $resultado->fetch_array();
        return $result[0];
        }else{
            return 0;
        }    
        $conn->close();
    }

        public function eliminaMenu($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("DELETE FROM menu WHERE idmenu = $id" );
            if($resultado){
                    $this->registra_log('Menu','Se ha eliminado el menu:'.$id);    
            return TRUE;
            }else{
                return 0;
            }    
            $conn->close();
        }

    public function actualizaMenu($id, $menu,$href, $icono,$idmenupadre,$orden)
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $peticion = "UPDATE `menu` SET `menu`= '$menu',`href`= '$href',`icono` = '$icono' ,`idmenupadre` = '$idmenupadre',`orden` = '$orden' WHERE `idmenu`= $id";
        $resultado= $conn->query($peticion );
        if($resultado){
                    $this->registra_log('Menu','Se ha actualizado el menu:'.$menu);
        return TRUE;
        }else{
            echo "<br> no se pudo ejecutar la consulta: " ;
        }    
        $conn->close();
    }
    
    
    
    function carga_selected($select,$opcion_seleccionada,$id){
        $db= new conectar;
        $conn = $db->con_mysql();    
        
	switch($select){
		case "menupadre":
			$sql = "SELECT * FROM menupadre ORDER BY menupadre";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='menupadre' selected='selected'>".utf8_decode($fila[1])."</option>";
					}else{
					echo "<option value=".$fila[0]." id='menupadre'>".$fila[1]."</option>";
					}
				}
			echo "</select>";

			}
		break;

        case "marcas":
			$sql = "SELECT * FROM marcas ORDER BY marca";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='marca'  selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='marca'>".$fila[1]."</option>";
					}
				}
			echo "</select>";

			}
		break;
            
        case "tipodoc":
			$sql = "SELECT * FROM tipodocclientes ORDER BY idtdoc";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='tipodoc' selected='selected'>".utf8_decode($fila[1])."</option>";
					}else{
					echo "<option value=".$fila[0]." id='tipodoc'>".utf8_decode($fila[1])."</option>";
					}
				}
			echo "</select>";
			}
		break;            
        case "condiva":
			$sql = "SELECT * FROM condicioniva ORDER BY idcondiva";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='condiva' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='condiva'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;
        case "familia":
			$sql = "SELECT idfamilia, familia FROM familias ORDER BY familia";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='familia' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='familia'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;            
        case "cliente":
			$sql = "SELECT * FROM clientes ORDER BY nombre";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='cliente' selected='selected'>".utf8_decode($fila[3])."</option>";
					}else{
					echo "<option value=".$fila[0]." id='cliente'>".utf8_decode($fila[3])."</option>";
					}
				}
			echo "</select>";
			}
		break;
        case "modelo":
			$sql = "SELECT * FROM modelos WHERE idmarca = $id ORDER BY modelo";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='modelo' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='modelo'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;
        case "provincia":
			$sql = "SELECT * FROM provincias ORDER BY idprovincia";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='provincia' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='provincia'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;                        
        case "pais":
			$sql = "SELECT * FROM paises ORDER BY idpais";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='pais' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='pais'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;                        
        case "contacto":
			$sql = "SELECT * FROM contactos WHERE idcliente = $id ORDER BY contacto";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='contacto' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='contacto'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;
            
        case "transporte":
			$sql = "SELECT * FROM transportes ORDER BY transporte";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='transporte' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='transporte'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break; 
        case "subfamilia":
			$sql = "SELECT * FROM subfamilias WHERE idfamilia = $id ORDER BY subfamilia";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='subfamilia' selected='selected'>".$fila[1]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='subfamilia'>".$fila[1]."</option>";
					}
				}
			echo "</select>";
			}
		break;    
        case "empresa":
			$sql = "SELECT * FROM empresas ORDER BY nombre";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='empresa' selected='selected'>".$fila[3]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='empresa'>".$fila[3]."</option>";
					}
				}
			echo "</select>";
			}
		break;
        case "equiposcliente":
			$sql = "SELECT eq.idequipo, fam.familia, mar.marca, mo.modelo,  eq.nroserie, eq.observaciones FROM `equipos` AS eq JOIN familias AS fam ON eq.idfamilia = fam.idfamilia  JOIN marcas AS mar ON eq.idmarca = mar.idmarca JOIN modelos AS mo ON eq.idmodelo = mo.idmodelo WHERE idcliente = $id ORDER BY idequipo";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='equipo' selected='selected'>".$fila[2].'-'.$fila[3].'-'.$fila[4]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='equipo'>".$fila[2].'-'.$fila[3].'-'.$fila[4]."</option>";
					}
				}
			echo "</select>";
    			}
			break;
        case "itemscotizacion":
			$sql = "SELECT * FROM `itemscotizacion` ORDER BY iditemcotizacion";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='itemcotizacion' selected='selected'>".$fila[1].'-$'.$fila[2]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='itemcotizacion'>".$fila[1].'-$'.$fila[2]."</option>";
					}
				}
			echo "</select>";
    			}
			break;
			case "equipospatron":
			$sql = "SELECT eq.idequipo, fam.familia, mar.marca, mo.modelo,  eq.nroserie, eq.observaciones FROM `equipos` AS eq JOIN familias AS fam ON eq.idfamilia = fam.idfamilia  JOIN marcas AS mar ON eq.idmarca = mar.idmarca JOIN modelos AS mo ON eq.idmodelo = mo.idmodelo WHERE eq.idfamilia = $id AND eq.espatron = 1 ORDER BY idequipo";

			$res=@$conn->query($sql );
			if(!$res){
			echo " fallo";
			}
			else{
				while ($fila=$res->fetch_array()){
					if ($fila[0]==$opcion_seleccionada){
					echo "<option value=".$fila[0]." id='patron' selected='selected'>".$fila[2].'-'.$fila[3].'-'.$fila[4]."</option>";
					}else{
					echo "<option value=".$fila[0]." id='patron'>".$fila[2].'-'.$fila[3].'-'.$fila[4]."</option>";
					}
				}
			echo "</select>";
    			}
			break;
			
    }
	}
    
        function crear_menu_padre_bst(){
        $db= new conectar;
        $conn = $db->con_mysql();    

//        if ($perfil==1){
        $peticion = "SELECT * FROM `menupadre` order by orden";
//        }else{
//        $peticion = "SELECT * FROM `menupadre` WHERE idpadre in (select idpadre from menu where idmenu in (select idmenu from menuperfil where idperfil =".$perfil.")) order by orden;";
//        }
        $result = $conn->query($peticion );
        //echo "<ul>";
        echo '<ul class="nav" id="side-menu">';
        echo '<li>
                <a href="index.php" class=" hvr-bounce-to-right"><i class="fa fa-dashboard nav_icon "></i><span class="nav-label">Dashboards</span> </a>
            </li>';    
        while ($fila = $result->fetch_array()){
        //echo "<li class='nivel1'><a href=".'#'." class='nivel1'>".utf8_encode($fila[1])."</a>";
        echo '<li><a href="#" class=" hvr-bounce-to-right"><i class="fa '.$fila[2].' nav_icon"></i> <span class="nav-label">'.$fila[1].'</span><span class="fa arrow"></span></a>';
        $this->crear_menu($fila[0]);
        }
        echo "</li></ul>";
        }    
    

        function crear_menu($padre){
        $db= new conectar;
        $conn = $db->con_mysql();    

//        if ($perfil==1){
        $peticion = "SELECT * FROM `menu` where idmenupadre =".$padre." order by orden";
//        }else{
//        $peticion = "SELECT * FROM `menu` where idmenu in (select idmenu from menuperfil where idperfil=".$perfil.") and idpadre =".$padre." order by orden;";
//        }
        $result = $conn->query($peticion );
        //echo "<ul class='nivel2'>";
        echo '<ul class="nav nav-second-level">';
        while ($fila = $result->fetch_array()){
        echo '<li><a href="'.$fila[2].'" class=" hvr-bounce-to-right"> <i class="fa '.$fila[3].' nav_icon"></i>'.$fila[1].'</a></li>';
        }
        echo "</ul>";
        }


        public function getListaUsuarios()
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM usuarios" );

            return $resultado;
            $conn->close();

        }

        public function grabaUsuario($idusuario, $nombre, $apellido, $email, $username, $clave, $imagen, $habilitado)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($idusuario==0)
            {
            $peticion = "INSERT INTO `usuarios` (`idusuario`,`usuario`,`clave`,`nombre`,`apellido`,`mail`,`imagen`,`habilitado`) VALUES ('','$username','$clave','$nombre','$apellido','$email','$imagen','$habilitado')";    
                $actividad = 'Se ha creado el usuario: ';
            }
            else
            {
            $peticion = "UPDATE `usuarios` SET `usuario`='$username' ,`clave`='$clave',`nombre`='$nombre',`apellido`='$apellido',`mail`='$email',`imagen`='$imagen',`habilitado`='$habilitado'  WHERE `idusuario`=$idusuario";
                $actividad = 'Se ha actualizado el usuario: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Usuarios',$actividad.$username);    
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }

        public function getUsuario($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM usuarios WHERE idusuario=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }
    
        public function getParametros($empresa)
        {

            $db= new conectar;
            $conn = $db->con_mysql();   
            if ($empresa==0)
            { 
                $resultado= $conn->query("SELECT * FROM parametrosgenerales limit 1" );
            }
            else
            {
                $resultado= $conn->query("SELECT * FROM parametrosgenerales WHERE idempresa=$empresa" );
            }

            return $resultado->fetch_array();
            $conn->close();

        }
	

	
        public function getListaMarcas()
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM marcas" );

            return $resultado;
            $conn->close();

        }    

        public function getMarca($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM marcas WHERE idmarca=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }  

        public function grabaMarca($id, $marca, $imagen, $urlmarca, $observaciones)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `marcas` (`idmarca`,`marca`,`imagen`,`urlmarca`,`texto`) VALUES ('','$marca','$imagen','$urlmarca','$observaciones')";
                $actividad='Se ha creado la marca: ';
            }
            else
            {
            $peticion = "UPDATE `marcas` SET `marca`='$marca' ,`imagen`='$imagen',`urlmarca`='$urlmarca',`texto`='$observaciones'  WHERE `idmarca`=$id";
                $actividad='Se ha actualizado la marca';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Equipos',$actividad.$marca);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }    

        public function eliminaMarca($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `marcas` WHERE `idmarca`=$id";

            $resultado= $conn->query($peticion );
                if($resultado){
                    $this->registra_log('Equipos','Se ha eliminado la marca: '.$id);  
                return TRUE;
                }else{
                return $conn->error;
                }    
            $conn->close();
        }    
    
        public function getListaModelos($marca)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
            if ($marca==0)
            {
             $peticion = "SELECT mo.idmodelo, ma.marca, mo.modelo, mo.imagen, mo.urlmodelo FROM `modelos` mo LEFT JOIN `marcas` ma ON mo.idmarca = ma.idmarca";    
            }
            else
            {
             $peticion = "SELECT mo.idmodelo, ma.marca, mo.modelo, mo.imagen, mo.urlmodelo FROM  `modelos` mo LEFT JOIN `marcas` ma ON mo.idmarca = ma.idmarca WHERE mo.idmarca=$marca";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();

        } 
    
        public function getModelo($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM modelos WHERE idmodelo=$id" );

            return $resultado->fetch_array();
            $conn->close();

        } 
    
		public function getCantModelos($id)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM modelos WHERE idmarca=$id" );

            return $resultado->fetch_array();
            $conn->close();
			
		}
  	
        public function getCantSubfamilias($id)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM subfamilias WHERE idfamilia=$id" );

            return $resultado->fetch_array();
            $conn->close();
			
		}
		
		public function getCantEqSubfamilias($id)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM equipos WHERE idsubfamilia=$id" );

            return $resultado->fetch_array();
            $conn->close();
			
		}

		public function getCantEqClientes($id)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM equipos WHERE idcliente=$id" );

            return $resultado->fetch_array();
            $conn->close();
			
		}

		public function getCantCotEquipo($id)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM cotizadet WHERE idequipo=$id" );
            return $resultado->fetch_array();
            $conn->close();
			
		}

		public function getCantIngEquipo($id)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM ingresodet WHERE idequipo=$id" );
            return $resultado->fetch_array();
            $conn->close();
			
		}	
	
	
            public function getInfoModelo($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT mo.idmodelo, ma.marca, mo.modelo, mo.imagen, mo.urlmodelo FROM  `modelos` mo LEFT JOIN `marcas` ma ON mo.idmarca = ma.idmarca WHERE  mo.idmodelo=$id" );

            return $resultado->fetch_array();
            $conn->close();

        } 

        public function grabaModelo($id, $modelo, $imagen, $urlmodelo, $observaciones, $idmarca)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `modelos` (`idmodelo`,`modelo`,`imagen`,`urlmodelo`,`descripcion`, `idmarca`) VALUES ('','$modelo','$imagen','$urlmodelo','$observaciones',$idmarca)";
            $actividad='Se ha creado el modelo: ';
            }
            else
            {
            $peticion = "UPDATE `modelos` SET `modelo`='$modelo' ,`imagen`='$imagen',`urlmodelo`='$urlmodelo',`descripcion`='$observaciones', `idmarca`=$idmarca  WHERE `idmodelo`=$id";
            $actividad='Se ha actualizado el modelo: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Equipos',$actividad.$modelo);  
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }      

        public function eliminaModelo($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `modelos` WHERE `idmodelo`=$id";

            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Equipos','Se ha eliminado el Modelo: '.$id);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }  
    
        public function grabaDocumento($tipodoc, $id, $nombre, $urldocumento)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "INSERT INTO `documentos` (`iddocumento`,`nombredoc`,`urldocumento`,`tipodocumento`,`idpadre`) VALUES ('','$nombre','$urldocumento',$tipodoc,$id)";
            $resultado= $conn->query($peticion );
                if($resultado){
                $this->registra_log('Documentos','Se ha subido el documento: '.$nombre.' al padre: '.$id);            
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            
        }
    
        public function getListaDocumentos($tipo, $id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `documentos` WHERE tipodocumento = $tipo AND idpadre = $id";    
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();

        } 

        public function getDocumento($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `documentos` WHERE iddocumento = $id";    
            $resultado= $conn->query($peticion );

            return $resultado->fetch_array();
            $conn->close();

        }    
    
        public function eliminaDocumento($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `documentos` WHERE `iddocumento`=$id";
            $archivo = $this->getDocumento($id);
            
             rename("../documentos/".$archivo[2],"../documentos/trash/".$archivo[2]);
            
            $resultado= $conn->query($peticion );
                if($resultado){
                $this->registra_log('Documentos','Se ha eliminado el documento: '.$archivo[2]);
                return $archivo[2];
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }        

        public function getListaClientes($filtro)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
			switch($filtro){
				case "":
					 $peticion = "SELECT * FROM `clientes` LEFT JOIN `condicioniva` ON clientes.condiva = condicioniva.idcondiva LEFT JOIN `tipodocclientes` ON clientes.tipodoc=tipodocclientes.idtdoc LEFT JOIN `provincias` ON clientes.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON clientes.idpais = paises.idpais";    
				break;
				case "incompleto":
					 $peticion = "SELECT * FROM `clientes` LEFT JOIN `condicioniva` ON clientes.condiva = condicioniva.idcondiva LEFT JOIN `tipodocclientes` ON clientes.tipodoc=tipodocclientes.idtdoc LEFT JOIN `provincias` ON clientes.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON clientes.idpais = paises.idpais WHERE (`clientes`.`tipodoc` = 0) OR (`clientes`.`nrodoc`='') OR (`clientes`.`domicilio`='') OR(`clientes`.`localidad`='') OR (`clientes`.`idprovincia`=0) OR (`clientes`.`idpais`=0) OR (`clientes`.`telefono`='') OR (`clientes`.`contactoppal` ='')";
				break;
				default:
					 $peticion = "SELECT * FROM `clientes` LEFT JOIN `condicioniva` ON clientes.condiva = condicioniva.idcondiva LEFT JOIN `tipodocclientes` ON clientes.tipodoc=tipodocclientes.idtdoc LEFT JOIN `provincias` ON clientes.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON clientes.idpais = paises.idpais WHERE clientes.nombre LIKE '%".$filtro."%' OR clientes.contactoppal LIKE '%".$filtro."%' OR clientes.nrodoc LIKE '%".$filtro."%'";    

				break;	
			}
            $resultado= $conn->query($peticion );
//            return $peticion;
            return $resultado;
            $conn->close();

        } 
            public function getCliente($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `clientes` LEFT JOIN `condicioniva` ON clientes.condiva = condicioniva.idcondiva LEFT JOIN `tipodocclientes` ON clientes.tipodoc=tipodocclientes.idtdoc LEFT JOIN `provincias` ON clientes.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON clientes.idpais = paises.idpais WHERE clientes.idcliente=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }     
    
            public function grabaCliente($id, $tipodoc, $nrodoc, $nombre, $condiva, $domicilio, $localidad, $telefono, $cpostal,$contactoppal, $email, $habilitado, $observaciones,$provincia,$pais,$clasificacion,$idtransporte)
            {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `clientes` (`idcliente`,`tipodoc`,`nrodoc`,`nombre`,`condiva`, `domicilio`, `localidad`, `telefono`, `cpostal`, `contactoppal`, `email`, `habilitado`, `observaciones`,`idprovincia`,`idpais`,`clasificacion`,`idtransporte`) VALUES ('',$tipodoc, '$nrodoc', '$nombre', $condiva, '$domicilio', '$localidad', '$telefono', '$cpostal','$contactoppal' , '$email', $habilitado, '$observaciones',$provincia,$pais,$clasificacion,$idtransporte)";
                $actividad = 'Se ha creado el cliente: ';
            }
            else
            {
            $peticion = "UPDATE `clientes` SET `tipodoc`=$tipodoc,`nrodoc`='$nrodoc',`nombre`='$nombre',`condiva`=$condiva, `domicilio`='$domicilio', `localidad`='$localidad', `telefono`='$telefono', `cpostal`='$cpostal', `contactoppal`='$contactoppal', `email`='$email', `habilitado`=$habilitado, `observaciones`='$observaciones', `idprovincia`=$provincia, `idpais`=$pais, `clasificacion`= $clasificacion, `idtransporte` = $idtransporte WHERE `idcliente`=$id";
                $actividad='Se ha actualizado el cliente: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                            $this->registra_log('Clientes',$actividad.$nombre);                  
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            }

	
    
       public function getListaContactos($filtro)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='' || $filtro==0)
            {
             $peticion = "SELECT contactos.*, provincias.provincia, paises.pais, clientes.* FROM `contactos` LEFT JOIN `provincias` ON contactos.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON contactos.idpais = paises.idpais LEFT JOIN `clientes` ON contactos.idcliente = clientes.idcliente ORDER BY clientes.nombre, contactos.contacto";    
            }
            else
            {
             $peticion = "SELECT contactos.*, provincias.provincia, paises.pais, clientes.* FROM `contactos` LEFT JOIN `provincias` ON contactos.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON contactos.idpais = paises.idpais LEFT JOIN `clientes` ON contactos.idcliente = clientes.idcliente  WHERE contactos.contacto LIKE '%".$filtro."%' OR clientes.contactoppal LIKE '%".$filtro."%' OR clientes.nombre LIKE '%".$filtro."%' ";    
            }
            $resultado= $conn->query($peticion );
//            return $peticion;
            return $resultado;
            $conn->close();

        } 
	
       public function getListaContactosCliente($idcliente)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT contactos.*, provincias.provincia, paises.pais, clientes.* FROM `contactos` LEFT JOIN `provincias` ON contactos.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON contactos.idpais = paises.idpais LEFT JOIN `clientes` ON contactos.idcliente = clientes.idcliente WHERE contactos.idcliente = $idcliente ORDER BY clientes.nombre, contactos.contacto";    
            $resultado= $conn->query($peticion );
//            return $peticion;
            return $resultado;
            $conn->close();

        } 
	
            public function getContacto($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT contactos.*, provincias.provincia, paises.pais, clientes.* FROM `contactos` LEFT JOIN `provincias` ON contactos.idprovincia = provincias.idprovincia LEFT JOIN `paises` ON contactos.idpais = paises.idpais LEFT JOIN `clientes` ON contactos.idcliente = clientes.idcliente WHERE contactos.idcontacto=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }     
    
            public function grabaContacto($id, $contacto, $idcliente, $domicilio, $localidad,$provincia,$pais, $telefono, $cpostal, $email, $idtransporte, $clasificacion, $habilitado,  $imagen, $observaciones)
            {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `contactos` (`idcontacto`, `contacto`, `idcliente`, `telefono`, `email`, `domicilio`, `localidad`, `idprovincia`, `idpais`, `cpostal`, `idtransporte`, `clasificacion`, `imagen`, `observaciones`, `habilitado`) VALUES ('','$contacto', $idcliente, '$telefono', '$email', '$domicilio', '$localidad',$provincia,$pais, '$cpostal',$idtransporte,$clasificacion,'$imagen' ,  '$observaciones',$habilitado)";
                $actividad = 'Se ha creado el contacto: ';
            }
            else
            {
            $peticion = "UPDATE `contactos` SET `contacto`='$contacto',`idcliente`=$idcliente, `domicilio`='$domicilio', `localidad`='$localidad', `telefono`='$telefono', `cpostal`='$cpostal',  `email`='$email', `habilitado`=$habilitado, `observaciones`='$observaciones', `idprovincia`=$provincia, `idpais`=$pais, `clasificacion`= $clasificacion, `imagen`='$imagen', `idtransporte`=$idtransporte WHERE `idcontacto`=$id";
                $actividad='Se ha actualizado el contacto: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                            $this->registra_log('Clientes',$actividad.$nombre);                  
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            }
    

        public function eliminaContacto($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `contactos` WHERE `idcontacto`=$id";

            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Contactos','Se ha eliminado el Contacto: '.$id);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }  


    
        public function getListaFamilias()
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `familias` ORDER BY familia";    
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();

        }
    
        public function grabaFamilia($id, $familia)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `familias` (`idfamilia`,`familia`) VALUES ('','$familia')";
                $actividad='Se ha creado la familia: ';
            }
            else
            {
            $peticion = "UPDATE `familias` SET `familia`='$familia' WHERE `idfamilia`=$id";
                $actividad='Se ha actualizado la familia: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                $this->registra_log('Equipos',$actividad.$familia);                  
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            
        }
    
        public function eliminaFamilia($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `familias` WHERE `idfamilia`=$id";

            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Equipos','Se ha eliminado la familia: '.$id);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }  

        public function getListaSubfamilias($familia)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
            if ($familia==0)
            {
             $peticion = "SELECT * FROM `subfamilias` JOIN `familias` ON subfamilias.idfamilia = familias.idfamilia ORDER BY familia";
            }
            else
            {
             $peticion = "SELECT * FROM `subfamilias` JOIN `familias` ON subfamilias.idfamilia = familias.idfamilia WHERE subfamilias.idfamilia = $familia ORDER BY familia";                
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();

        }
    
        public function grabaSubfamilia($id, $subfamilia, $familia)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `subfamilias` (`idsubfamilia`,`subfamilia`,`idfamilia`) VALUES ('','$subfamilia',$familia)";
                $actividad='Se ha creado la subfamilia: ';
            }
            else
            {
            $peticion = "UPDATE `subfamilias` SET `subfamilia`='$subfamilia', `idfamilia`=$familia WHERE `idsubfamilia`=$id";
                $actividad='Se ha actualizado la subfamilia: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                $this->registra_log('Equipos',$actividad.$subfamilia);                  
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            
        }
    
        public function eliminaSubfamilia($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `subfamilias` WHERE `idsubfamilia`=$id";

            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Equipos','Se ha eliminado la subfamilia: '.$id);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }  
    
        public function getSubfamilia($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `subfamilias` JOIN `familias` ON subfamilias.idfamilia = familias.idfamilia WHERE subfamilias.idsubfamilia = $id";    
            $resultado= $conn->query($peticion );

            return $resultado->fetch_array();
            $conn->close();

        }    
        public function getFamilia($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `familias` WHERE idfamilia = $id";    
            $resultado= $conn->query($peticion );

            return $resultado->fetch_array();
            $conn->close();

        }     
	
        public function getSubfamiliaEquipo($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `subfamilias` WHERE idsubfamilia = (SELECT idsubfamilia FROM equipos WHERE idequipo = $id) ";    
            $resultado= $conn->query($peticion );

            return $resultado->fetch_array();
            $conn->close();

        }    
    
        public function getListaEquipos($filtro)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='')
            {
             $peticion = "SELECT * FROM `equipos` JOIN familias ON equipos.idfamilia = familias.idfamilia JOIN marcas ON equipos.idmarca = marcas.idmarca JOIN modelos ON equipos.idmodelo = modelos.idmodelo JOIN clientes ON equipos.idcliente = clientes.idcliente JOIN subfamilias ON equipos.idsubfamilia = subfamilias.idsubfamilia ORDER BY clientes.nombre, familias.familia ";    
            }
            else
            {
             $peticion = "SELECT * FROM `equipos` JOIN familias ON equipos.idfamilia = familias.idfamilia JOIN marcas ON equipos.idmarca = marcas.idmarca JOIN modelos ON equipos.idmodelo = modelos.idmodelo JOIN clientes ON equipos.idcliente = clientes.idcliente JOIN subfamilias ON equipos.idsubfamilia = subfamilias.idsubfamilia  
             WHERE clientes.nombre LIKE '%".$filtro."%' OR clientes.contactoppal LIKE '%".$filtro."%' OR clientes.nrodoc LIKE '%".$filtro."%' OR familias.familia LIKE '%".$filtro."%' OR marcas.marca LIKE '%".$filtro."%' OR equipos.nroserie LIKE '%".$filtro."%' 
             ORDER BY clientes.nombre, familias.familia";    
            }
            $resultado= $conn->query($peticion );
//            return $peticion;
            return $resultado;
            $conn->close();

        } 

        public function getListaEquiposCliente($idcliente)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `equipos` JOIN familias ON equipos.idfamilia = familias.idfamilia LEFT JOIN marcas ON equipos.idmarca = marcas.idmarca LEFT JOIN modelos ON equipos.idmodelo = modelos.idmodelo LEFT JOIN clientes ON equipos.idcliente = clientes.idcliente LEFT JOIN subfamilias ON equipos.idsubfamilia = subfamilias.idsubfamilia WHERE equipos.idcliente = $idcliente ORDER BY clientes.nombre, familias.familia ";    
            $resultado= $conn->query($peticion );
//            return $peticion;
            return $resultado;
            $conn->close();

        } 

	
            public function getEquipo($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `equipos` JOIN familias ON equipos.idfamilia = familias.idfamilia JOIN marcas ON equipos.idmarca = marcas.idmarca JOIN modelos ON equipos.idmodelo = modelos.idmodelo JOIN clientes ON equipos.idcliente = clientes.idcliente JOIN subfamilias ON equipos.idsubfamilia = subfamilias.idsubfamilia WHERE equipos.idequipo=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }      
    
            public function grabaEquipo($idequipo,$idfamilia,$idmarca,$idmodelo,$nroserie, $idcliente, $imagen,  $observaciones,$subfamilia,$espatron)
            {
            $db= new conectar;
            $conn = $db->con_mysql();
                
            if ($idequipo==0)
            {
            $fechaalta=$fechamod=date("Y-m-d H:i:s");    
            $peticion = "INSERT INTO `equipos` (`idequipo`,`idfamilia`,`idmarca`,`idmodelo`,`nroserie`,`imagen`,`idcliente`,`observaciones`,`fechaalta`,`fechamod`,`idsubfamilia`,`espatron`) VALUES ('',$idfamilia,$idmarca,$idmodelo,'$nroserie', '$imagen', $idcliente, '$observaciones','$fechaalta','$fechamod',$subfamilia,$espatron)";
                $actividad='Se ha creado el equipo: ';
            }
            else
            {
            $fechamod=date("Y-m-d H:i:s");    
            $peticion = "UPDATE `equipos` SET `idfamilia`='$idfamilia',`idmarca`='$idmarca',`idmodelo`='$idmodelo',`nroserie`='$nroserie',`imagen`='$imagen',`idcliente`='$idcliente',`observaciones`='$observaciones',`fechamod`='$fechamod', `idsubfamilia`= $subfamilia, `espatron`=$espatron WHERE `idequipo`=$idequipo";
                $actividad='Se ha actualizado el equipo: ';
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Equipos',$actividad.$idequipo);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();                
            }
    
			public function eliminaEquipo($id)
			{
				$db= new conectar;
				$conn = $db->con_mysql();    
				$peticion = "DELETE FROM `equipos` WHERE `idequipo`=$id";

				$resultado= $conn->query($peticion );
					if($resultado){
							$this->registra_log('Equipos','Se ha eliminado el equipo: '.$id);
					return TRUE;
					}else{
					return $conn->error;	
					//echo "<br> no se pudo ejecutar la consulta: ".
					}    
				$conn->close();
			}

			public function eliminaCliente($id)
			{
				$db= new conectar;
				$conn = $db->con_mysql();    
				$peticion = "UPDATE `clientes` SET habilitado = 0 WHERE `idcliente`=$id";

				$resultado= $conn->query($peticion );
					if($resultado){
							$this->registra_log('Clientes','Se ha deshabilitado el cliente: '.$id);
					return TRUE;
					}else{
					return $conn->error;
					}    
				$conn->close();
			}  


			public function reactivaCliente($id)
			{
				$db= new conectar;
				$conn = $db->con_mysql();    
				$peticion = "UPDATE `clientes` SET habilitado = 1 WHERE `idcliente`=$id";

				$resultado= $conn->query($peticion );
					if($resultado){
							$this->registra_log('Clientes','Se ha reactivado el cliente: '.$id);
					return TRUE;
					}else{
					return $conn->error;
					}    
				$conn->close();
			}  


	
        public function getListaEmpresas()
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `empresas` JOIN `condicioniva` ON empresas.condiva = condicioniva.idcondiva JOIN `tipodocclientes` ON empresas.tipodoc=tipodocclientes.idtdoc JOIN `provincias` ON empresas.idprovincia = provincias.idprovincia JOIN `paises` ON empresas.idpais = paises.idpais";    
            $resultado= $conn->query($peticion );
//            return $peticion;
            return $resultado;
            $conn->close();

        } 
            public function getEmpresa($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `empresas` JOIN `condicioniva` ON empresas.condiva = condicioniva.idcondiva JOIN `tipodocclientes` ON empresas.tipodoc=tipodocclientes.idtdoc JOIN `provincias` ON empresas.idprovincia = provincias.idprovincia JOIN `paises` ON empresas.idpais = paises.idpais WHERE empresas.idempresa=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }
	
	   public function getTipoDocCliente($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT tipodocumento FROM `tipodocclientes` WHERE idtdoc=$id" );
            return $resultado->fetch_array();
            $conn->close();

        }

	   public function getCondicionIVA($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT condiva FROM `condicioniva` WHERE idcondiva=$id" );
            return $resultado->fetch_array();
            $conn->close();

        }	

	   public function getProvincia($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT provincia FROM `provincias` WHERE idprovincia=$id" );
            return $resultado->fetch_array();
            $conn->close();

        }	
	
	
            public function grabaEmpresa($id, $tipodoc, $nrodoc, $nombre, $condiva, $domicilio, $localidad, $telefono, $cpostal, $email, $observaciones,$provincia,$pais)
            {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `empresas` (`idempresa`,`tipodoc`,`nrodoc`,`nombre`,`condiva`, `domicilio`, `localidad`, `telefono`, `cpostal`, `email`, `observaciones`,`idprovincia`,`idpais`) VALUES ('',$tipodoc, '$nrodoc', '$nombre', $condiva, '$domicilio', '$localidad', '$telefono', '$cpostal','$email', '$observaciones',$provincia,$pais)";
            }
            else
            {
            $peticion = "UPDATE `empresas` SET `tipodoc`=$tipodoc,`nrodoc`='$nrodoc',`nombre`='$nombre',`condiva`=$condiva, `domicilio`='$domicilio', `localidad`='$localidad', `telefono`='$telefono', `cpostal`='$cpostal', `email`='$email', `observaciones`='$observaciones',`idprovincia`=$provincia, `idpais`=$pais  WHERE `idempresa`=$id";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            }
    
        public function getListaTransportes()
        {

            $db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT * FROM `transportes`ORDER BY transporte";    
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();
        }
        
        public function grabaTransporte($id, $transporte, $domicilio, $localidad,$provincia,$pais, $telefono, $cpostal, $email,$observaciones)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
            $peticion = "INSERT INTO `transportes` (`idtransporte`,`transporte`, `telefono`, `email`,`domicilio`, `localidad`,`idprovincia`,`idpais`, `cpostal`, `observaciones`) VALUES ('','$transporte', '$telefono','$email', '$domicilio', '$localidad',$provincia,$pais , '$cpostal', '$observaciones')";
            }
            else
            {
            $peticion = "UPDATE `transportes` SET `transporte`='$transporte', `domicilio`='$domicilio', `localidad`='$localidad', `telefono`='$telefono', `cpostal`='$cpostal', `email`='$email', `observaciones`='$observaciones',`idprovincia`=$provincia, `idpais`=$pais  WHERE `idtransporte`=$id";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
            
        }
            public function getTransporte($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `transportes` WHERE idtransporte=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }

        	public function getListaEventos($filtro)
        {

            $db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='')
            {
             $peticion = "SELECT * FROM `auditoria` ORDER BY identrada DESC";    
            }
            else
            {
             $peticion = "SELECT * FROM `auditoria` WHERE actividad LIKE '%".$filtro."%' ORDER BY identrada DESC";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();

        }
	
			public function grabaIngreso($id, $empresa, $fechaingreso, $idcliente, $idcontacto, $nombrecertificado, $entregadopor, $username)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
			$cantequipos=1;
			$costo=0;
			$estado=1;	
			$nro = $this->getUltimoIngreso()+1;	
            $peticion = "INSERT INTO `ingresocab` (`nroingreso`,`fechaingreso`, `idempresa`, `idcliente`,`idcontacto`, `nombrecertificado`,`entregadopor`,`useralta`, `cantequipos`, `costototal`,`estado`) VALUES ($nro,'$fechaingreso', $empresa,$idcliente, $idcontacto, '$nombrecertificado', '$entregadopor','$username', $cantequipos, $costo, $estado )";
            }
            else
            {
			$nro=$id;	
            $peticion = "UPDATE `ingresocab` SET `fechaingreso`='$fechaingreso', `idcliente`=$idcliente, `idcontacto`=$idcontacto, `nombrecertificado`='$nombrecertificado', `entregadopor` = '$entregadopor', `idempresa`=$empresa  WHERE `nroingreso`=$nro";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                return $nro;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
			}

			public function grabaCabeceraCotizacion($id, $empresa, $fechacotizacion, $referencia, $idcliente, $idcontacto, $email, $encabezado, $condiciones ,$useralta)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
			$estado=1;	
			$date=date_create($fechacotizacion);
			date_add($date,date_interval_create_from_date_string("15 days"));
			$fechavencimiento = date_format($date,"Y-m-d");	
			//$fechavencimiento = date($fechacotizacion, strtotime("+15 days"));
				
            $peticion = "INSERT INTO `cotizacab` (`idempresa`,`fechacotizacion`, `fechavencimiento`, `referencia`, `idcliente`,`idcontacto`, `emailenvio`,`encabezado`,`condicionescomerciales`, `estado`, `useralta`) VALUES ($empresa,'$fechacotizacion','$fechavencimiento', '$referencia',$idcliente, $idcontacto, '$email', '$encabezado','$condiciones', $estado, '$useralta' )";
            }
            else
            {
			$date=date_create($fechacotizacion);
			date_add($date,date_interval_create_from_date_string("15 days"));
			$fechavencimiento = date_format($date,"Y-m-d");	

            $peticion = "UPDATE `cotizacab` SET `idempresa` = $empresa,`fechacotizacion`= '$fechacotizacion', `fechavencimiento`='$fechavencimiento', `referencia`='$referencia', `idcliente`=$idcliente,`idcontacto`=$idcontacto, `emailenvio`='$email',`encabezado`='$encabezado',`condicionescomerciales`='$condiciones'  WHERE `idcotizacion`=$id";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
				 if ($id==0){	
                return $conn->insert_id();
				 }else{
				return $id;	 
				 }
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
			}
	
			public function grabaItemCotizacion( $idcotizacion, $iditem, $txtitemcotizacion, $cantidad, $preciounitario, $idequipo, $bonificado)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if (!$this->existeItem($idcotizacion,$iditem))
            {
			
            $peticion = "INSERT INTO `cotizadet` (`idcotizacion`,`iditemcotizacion`, `txtitemcotizacion`, `cantidad`, `preciounitario`,`idequipo`, `bonificado`) VALUES ($idcotizacion,$iditem,'$txtitemcotizacion', $cantidad,$preciounitario, $idequipo, $bonificado)";
            }
            else
            {

            $peticion = "UPDATE `cotizadet` SET `txtitemcotizacion` = '$txtitemcotizacion',`cantidad`= $cantidad, `preciounitario`=$preciounitario, `idequipo`=$idequipo, `bonificado`=$bonificado WHERE `idcotizacion`=$idcotizacion AND `iditemcotizacion` = $iditem";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                return $iditem;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
				
			}
			public function existeItem($idcotizacion,$iditem)
			{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `cotizadet`  WHERE `idcotizacion`=$idcotizacion AND `iditemcotizacion` = $iditem" );
			$resul = $resultado->num_rows;
			
            if($resul>0){
				return TRUE;
			}else{
				return FALSE;
			}
            $conn->close();
			}

			public function existeConfiguracion($idempresa)
			{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `parametrosgenerales`  WHERE `idempresa`=$idempresa " );
			$resul = $resultado->num_rows;
			
            if($resul>0){
				return TRUE;
			}else{
				return FALSE;
			}
            $conn->close();
			}	
	
		public function grabaParametros($id, $nrocotizacion, $lugarcotizacion, $campode, $textoheader, $encabezadocotizacion,$condicionescomerciales,$imagen,$usuario)
		{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if (!$this->existeConfiguracion($id))
            {
			$fecha = date('Y-m-d');
            $peticion = "INSERT INTO `parametrosgenerales`(`idempresa`, `fechatrabajo`, `nrocotizacion`, `lugarcotizacion`, `encabezadocotizacion`, `condicionescomerciales`, `logocotizacion`, `campo_de`, `texto_header`) VALUES ($id,'$fecha',$nrocotizacion, '$lugarcotizacion', '$encabezadocotizacion','$condicionescomerciales','$imagen', '$campode', '$textoheader')";
            }
            else
            {

            $peticion = "UPDATE `parametrosgenerales` SET `nrocotizacion` = $nrocotizacion,`lugarcotizacion`= '$lugarcotizacion', `encabezadocotizacion`='$encabezadocotizacion', `condicionescomerciales`='$condicionescomerciales', `logocotizacion`='$imagen', `campo_de` = '$campode', `texto_header`='$textoheader' WHERE `idempresa`=$id";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                return TRUE;
					$this->registra_log('Parametros','Se han actualizado los paramtros de la empresa: '.$id);
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
			
		}	
			public function ActualizaContadorCotizacion($empresa,$id){
			$db= new conectar;
            $conn = $db->con_mysql();
				if($id==0){
				$peticion = "
						UPDATE `parametrosgenerales` SET `nrocotizacion`=$id WHERE `idempresa` = $empresa
						";
				}else{
				$peticion = "
						UPDATE `parametrosgenerales` SET `nrocotizacion`=`nrocotizacion`+1 WHERE `idempresa` = $empresa
						";					
				}

			$result = $conn->query($peticion );

			if($result){    
			return TRUE;
			}else{
			return $conn->error;	
			}
	            $conn->close();
			}

        public function eliminaCotizacion($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();
			$cabecera=$this->getCotizacion($id);
			
			$path='../cotizaciones/';
			$filename = 'P'.trim($cabecera['referencia']).'.pdf';
			
			if(file_exists($path.$filename))
			{
				unlink($path.$filename);
			}
			
			
            $peticion = "DELETE FROM `cotizadet` WHERE `idcotizacion`=$id";
            $resultado= $conn->query($peticion );
                if($resultado){
						$peticion = "DELETE FROM `cotizacab` WHERE `idcotizacion`=$id";
						$resultado2= $conn->query($peticion );
						if($resultado2){
                        $this->registra_log('Laboratorio','Se ha eliminado el un equipo del formulario de ingreso: '.$id);
                return TRUE;}else{
//				return $filename;}else{			
                echo "<br> no se pudo ejecutar la consulta: " ;
                }
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }	
				
            public function getUltimoIngreso()
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT MAX(`nroingreso`) FROM `ingresocab`" );
			$resul = $resultado->fetch_array();
			
            return $resul[0];
            $conn->close();

        }
			public function grabaIngresoDetalle( $res, $nrolinea, $equipo, $calibra, $repara, $cargador, $valija, $interfase, $bomba, $copa, $baterias,$vtocertificado, $imagen, $observaciones,$user )
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if ($nrolinea==0)
            {
			$linea= $this->getLineaIngreso($res)+1;
			$estado=1;
			$fechamod= date('Y-m-d');	
            $peticion = "INSERT INTO `ingresodet` (`nroingreso`, `nrolinea`, `idequipo`, `calibra`, `repara`, `cargador`, `valija`, `interfase`, `bomba`, `copa`, `baterias`, `vtocertificado`,`imagen`, `observaciones`, `estado`, `fechamod`, `usermod`)VALUES ($res,$linea, $equipo, $calibra, $repara, $cargador, $valija, $interfase, $bomba, $copa, $baterias,$vtocertificado, '$imagen', '$observaciones',$estado,'$fechamod','$user' )";
            }
            else
            {
			$fechamod= date('Y-m-d');	
            $peticion = "UPDATE `ingresodet` SET `calibra`= $calibra, `repara`=$repara, `cargador`=$cargador, `valija`=$valija, `interfase`=$interfase, `bomba`=$bomba, `copa`=$copa, `baterias`=$baterias, `vtocertificado`=$vtocertificado,`imagen`='$imagen', `observaciones`='$observaciones',`fechamod`='$fechamod', `usermod`='$user' WHERE `nroingreso`=$res AND `nrolinea` = $nrolinea";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ."Valor Linea:".$linea."Valor NroLinea:".$nrolinea;
                }    
            $conn->close();				
			}
            public function getLineaIngreso($nroingreso)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT IFNULL(MAX(`nrolinea`),0) FROM `ingresodet` WHERE `nroingreso` = $nroingreso" );
			$resul=$resultado->fetch_array();
			return $resul[0];    
            
            $conn->close();

        }
			public function getListaLaboratorio($filtro)
			{
			            $db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='')
            {
             $peticion = "select cab.nroingreso, cli.nombre, CONCAT(mar.marca,'-',mo.modelo) as equip, det.calibra,det.repara, CONVERT(cab.fechaingreso,DATE) as fechaingreso, cab.cantequipos, cab.estado, fa.familia   
FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso 
						 JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente 
                         JOIN `equipos` AS  eq ON det.idequipo = eq.idequipo
                         JOIN `marcas` AS mar ON eq.idmarca = mar.idmarca
                         JOIN `modelos` AS mo ON eq.idmodelo = mo.idmodelo 
						 JOIN `familias` AS fa ON eq.idfamilia = fa.idfamilia 
						 ORDER BY cab.nroingreso";    
            }
            else
            {
             $peticion = "select cab.nroingreso, cli.nombre, CONCAT(mar.marca,'-',mo.modelo) as equip, det.calibra,det.repara, CONVERT(cab.fechaingreso,DATE) as fechaingreso, cab.cantequipos, cab.estado, fa.familia   
FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso 
						 JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente 
                         JOIN `equipos` AS  eq ON det.idequipo = eq.idequipo
                         JOIN `marcas` AS mar ON eq.idmarca = mar.idmarca
                         JOIN `modelos` AS mo ON eq.idmodelo = mo.idmodelo
						 JOIN `familias` AS fa ON eq.idfamilia = fa.idfamilia
						 WHERE cli.nombre LIKE '%".$filtro."%' ORDER BY cab.nroingreso";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}
	
			public function getOrdenesIngreso($estado)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
            if ($estado=='' || $estado==0)
            {
             $peticion = "select cab.nroingreso, cli.nombre, CONVERT(cab.fechaingreso,DATE) AS fechaingreso, cab.estado , COUNT(det.idequipo) AS CantEquipos FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente GROUP BY cab.nroingreso, cli.nombre,cab.fechaingreso, cab.estado ORDER BY cab.nroingreso";    
            }
            else
            {
             $peticion = "select cab.nroingreso, cli.nombre, CONVERT(cab.fechaingreso,DATE) AS fechaingreso, cab.estado , COUNT(det.idequipo) AS CantEquipos FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente WHERE cab.estado = $estado
			 GROUP BY cab.nroingreso, cli.nombre,cab.fechaingreso, cab.estado ORDER BY cab.nroingreso";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}	
	
				public function getOrdenesIngresoBusqueda($filtro)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='')
            {
             $peticion = "select cab.nroingreso, cli.nombre, CONVERT(cab.fechaingreso,DATE) AS fechaingreso, cab.estado , COUNT(det.idequipo) AS CantEquipos FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente GROUP BY cab.nroingreso, cli.nombre,cab.fechaingreso, cab.estado ORDER BY cab.nroingreso";    
            }
            else
            {
             $peticion = "select cab.nroingreso, cli.nombre, CONVERT(cab.fechaingreso,DATE) AS fechaingreso, cab.estado , COUNT(det.idequipo) AS CantEquipos FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente WHERE cli.nombre LIKE '%".$filtro."%' 
			 GROUP BY cab.nroingreso, cli.nombre,cab.fechaingreso, cab.estado ORDER BY cab.nroingreso";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}	
	

			public function getOrdenesIngresoEquipo($id)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "select cab.nroingreso, cli.nombre, CONVERT(cab.fechaingreso,DATE) AS fechaingreso, cab.estado , COUNT(det.idequipo) AS CantEquipos FROM `ingresocab` AS cab JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente WHERE det.idequipo = $id GROUP BY cab.nroingreso, cli.nombre,cab.fechaingreso, cab.estado  ORDER BY cab.nroingreso";    
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}	
	
	
			public function getIngreso($nroingreso)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `ingresocab` WHERE nroingreso=$nroingreso" );

            return $resultado->fetch_array();
            $conn->close();	
			}

			public function getIngresoDetalle($nroingreso)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `ingresodet` WHERE nroingreso=$nroingreso" );

            return $resultado;
            $conn->close();	
			}
	
			public function getLineaDetalle($nroingreso,$nrolinea)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `ingresodet` WHERE nroingreso=$nroingreso and nrolinea=$nrolinea" );

            return $resultado->fetch_array();
            $conn->close();	
			}
	
        public function eliminaIngreso($id,$linea)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $peticion = "DELETE FROM `ingresodet` WHERE `nroingreso`=$id and `nrolinea`=$linea";

            $resultado= $conn->query($peticion );
                if($resultado){
                        $this->registra_log('Laboratorio','Se ha eliminado el un equipo del formulario de ingreso: '.$id);
                return TRUE;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();
        }

	public function getKPIEquiposIngresados()
	{
		$db= new conectar;
        $conn = $db->con_mysql();    
		$peticion='SELECT COUNT(DISTINCT(idequipo)) as CantEquipos FROM `ingresodet` WHERE estado = 1';
        $resultado= $conn->query($peticion );
		$resul=$resultado->fetch_array();
		$equiposingresados = $resul[0];
		$peticion='SELECT COUNT(idequipo) as CantEquipos FROM `equipos`';
        $resultado= $conn->query($peticion );
		$resul=$resultado->fetch_array();
		$equipostotales = $resul[0];
		
		$kpi[0]=$equiposingresados;
		$kpi[1]=($equiposingresados/$equipostotales)*100;
		
		return $kpi;
		$conn->close();
	}
	
	public function getKPIClientesIncompletos()
	{
		$db= new conectar;
        $conn = $db->con_mysql();    
		$peticion='SELECT COUNT(*) as CantClientes FROM `clientes` WHERE habilitado = 1';
        $resultado= $conn->query($peticion );
		$resul=$resultado->fetch_array();
		$clientestotales = $resul[0];
		$peticion="SELECT COUNT(*) as ClientesIncompletos FROM `clientes` WHERE (`tipodoc` = 0) OR (`nrodoc`='') OR (`domicilio`='') OR(`localidad`='') OR (`idprovincia`=0) OR (`idpais`=0) OR (`telefono`='') OR (`contactoppal` ='')";
        $resultado= $conn->query($peticion );
		$resul=$resultado->fetch_array();
		$clientesincompletos = $resul[0];
		
		$kpi[0]=$clientestotales;
		$kpi[1]=($clientesincompletos/$clientestotales)*100;
		$kpi[2]=$clientesincompletos;
		
		return $kpi;
		$conn->close();
	}

			public function getListaCotizaciones($filtro)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='')
            {
             $peticion = "SELECT cab.idcotizacion, cab.fechacotizacion, cab.fechavencimiento, cab.referencia, cab.estado, cab.idcliente, cli.nombre as nombrecli, cab.idcontacto, con.contacto as nombrecon, emp.nombre as nombreemp, est.estadotxt FROM `cotizacab` AS cab LEFT JOIN clientes AS cli ON cab.idcliente = cli.idcliente LEFT JOIN contactos AS con ON cab.idcontacto = con.idcontacto LEFT JOIN empresas AS emp ON cab.idempresa = emp.idempresa LEFT JOIN cotizaest AS est ON cab.estado = est.idestadocotizacion ORDER BY cab.idcotizacion";	
            }
            else
            {
             $peticion = "SELECT cab.idcotizacion, cab.fechacotizacion, cab.fechavencimiento, cab.referencia, cab.estado, cab.idcliente, cli.nombre as nombrecli, cab.idcontacto, con.contacto as nombrecon, emp.nombre as nombreemp, est.estadotxt FROM `cotizacab` AS cab LEFT JOIN clientes AS cli ON cab.idcliente = cli.idcliente LEFT JOIN contactos AS con ON cab.idcontacto = con.idcontacto LEFT JOIN empresas AS emp ON cab.idempresa = emp.idempresa LEFT JOIN cotizaest AS est ON cab.estado = est.idestadocotizacion  
											WHERE cli.nombre LIKE '%".$filtro."%'
											OR con.contacto LIKE '%".$filtro."%'
											ORDER BY cab.idcotizacion	";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}

			public function getListaCotizacionesCliente($idcliente)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT cab.idcotizacion, cab.fechacotizacion, cab.fechavencimiento, cab.referencia, cab.estado, cab.idcliente, cli.nombre as nombrecli, cab.idcontacto, con.contacto as nombrecon, emp.nombre as nombreemp, est.estadotxt FROM `cotizacab` AS cab LEFT JOIN clientes AS cli ON cab.idcliente = cli.idcliente LEFT JOIN contactos AS con ON cab.idcontacto = con.idcontacto LEFT JOIN empresas AS emp ON cab.idempresa = emp.idempresa LEFT JOIN cotizaest AS est ON cab.estado = est.idestadocotizacion WHERE cab.idcliente = $idcliente ORDER BY cab.idcotizacion";	
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}
	
			public function getListaCotizacionesEquipo($idequipo)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT cab.idcotizacion, cab.fechacotizacion, cab.fechavencimiento, cab.referencia, cab.estado, cab.idcliente, cli.nombre as nombrecli, cab.idcontacto, con.contacto as nombrecon, emp.nombre as nombreemp, est.estadotxt FROM `cotizacab` AS cab LEFT JOIN clientes AS cli ON cab.idcliente = cli.idcliente LEFT JOIN contactos AS con ON cab.idcontacto = con.idcontacto LEFT JOIN empresas AS emp ON cab.idempresa = emp.idempresa LEFT JOIN cotizaest AS est ON cab.estado = est.idestadocotizacion WHERE cab.idcotizacion IN (SELECT DISTINCT(idcotizacion) FROM `cotizadet` WHERE idequipo = $idequipo) ORDER BY cab.idcotizacion";	
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}
	
	
            public function getItemCotizacion($id)
        {

            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `itemscotizacion` WHERE iditemcotizacion=$id" );

            return $resultado->fetch_array();
            $conn->close();

        }  	
			public function getCotizacion($nrocotizacion)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT cab.idcotizacion, cab.fechacotizacion, cab.fechavencimiento, cab.referencia, cab.estado, cab.idcliente, cli.nombre as nombrecli, cli.contactoppal, cab.idcontacto, con.contacto as nombrecon,cab.idempresa, emp.nombre as nombreemp, cab.emailenvio, cab.encabezado, cab.condicionescomerciales FROM `cotizacab` AS cab LEFT JOIN clientes AS cli ON cab.idcliente = cli.idcliente LEFT JOIN contactos AS con ON cab.idcontacto = con.idcontacto LEFT JOIN empresas AS emp ON cab.idempresa = emp.idempresa WHERE cab.idcotizacion=$nrocotizacion" );

            return $resultado->fetch_array();
            $conn->close();	
			}

			public function getCotizacionDetalle($nrocotizacion)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `cotizadet` AS det LEFT JOIN `equipos` AS eq ON det.idequipo = eq.idequipo WHERE idcotizacion=$nrocotizacion" );

            return $resultado;
            $conn->close();	
			}
	
			public function ActualizaEstadoCotizacion($idcotizacion,$estado,$usuario)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("UPDATE `cotizacab` SET estado=$estado WHERE idcotizacion=$idcotizacion" );
			if($resultado){
            $this->registrocambioestado(2,$idcotizacion,$estado,$usuario);
			}
            $conn->close();	

			}

			public function registrocambioestado($idtipodoc,$iddoc,$estado,$usuario)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
			$fecha=date('Y-m-d H:i:s');	
            $resultado= $conn->query("INSERT INTO `cambiosestado` (`idtipodocumento`,`iddocumento`,`idestado`,`fechacambio`,`usercambio`) VALUES ($idtipodoc,$iddoc,$estado,'$fecha','$usuario')" );
			if($resultado){
            return TRUE;
			}
            $conn->close();	
			}
	
			public function getDoc($tipodoc,$nrodoc)
			{
			$db= new conectar;
			$conn = $db->con_mysql();    
			$resultado= $conn->query("SELECT count(*) FROM clientes WHERE tipodoc = $tipodoc AND nrodoc='$nrodoc'" );
			return $resultado->fetch_array();
			$conn->close();

			}	
	
			public function getListaCalibraciones($filtro)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
            if ($filtro=='')
            {
             $peticion = "SELECT cc.id, CONVERT(cc.fechaalta, DATE) as fechaalta, cc.idfamilia, f.familia, cc.estado, cc.nombrecal, COUNT(ce.idequipo) as CantEquipos FROM `calibracioncab` AS cc LEFT JOIN `familias` AS f ON cc.idfamilia = f.idfamilia LEFT JOIN `calibracionequipos` AS ce ON cc.id = ce.idcalibracion
				GROUP BY cc.id, cc.fechaalta, cc.idfamilia, f.familia, cc.estado, cc.nombrecal
				ORDER BY cc.id";	
            }
            else
            {
             $peticion = "SELECT cc.id, CONVERT(cc.fechaalta, DATE) as fechaalta, cc.idfamilia, f.familia, cc.estado, COUNT(ce.idequipo) as CantEquipos FROM `calibracioncab` AS cc LEFT JOIN `familias` AS f ON cc.idfamilia = f.idfamilia LEFT JOIN `calibracionequipos` AS ce ON cc.id = ce.idcalibracion
											WHERE cc.estado LIKE '%".$filtro."%'
											OR f.familia LIKE '%".$filtro."%'
											GROUP BY cc.id, cc.fechaalta, cc.idfamilia, f.familia, cc.estado
											ORDER BY cc.id	";    
            }
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}

			public function getListaCalibracionesEquipo($idequipo)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "SELECT cc.id, CONVERT(cc.fechaalta, DATE) as fechaalta, cc.idfamilia, f.familia, cc.estado, cc.nombrecal, COUNT(ce.idequipo) as CantEquipos FROM `calibracioncab` AS cc LEFT JOIN `familias` AS f ON cc.idfamilia = f.idfamilia LEFT JOIN `calibracionequipos` AS ce ON cc.id = ce.idcalibracion
				WHERE cc.id IN(SELECT DISTINCT(idcalibracion) FROM `calibracionequipos` WHERE idequipo = $idequipo)
				GROUP BY cc.id, cc.fechaalta, cc.idfamilia, f.familia, cc.estado, cc.nombrecal
				ORDER BY cc.id";	
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}
	
	
			public function getListaEquiposCalibraciones($familia)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "select cab.nroingreso, cli.nombre, CONVERT(cab.fechaingreso,DATE) AS fechaingreso, det.idequipo, det.estado,eq.nroserie, mar.marca, mo.modelo, fa.familia, sf.subfamilia FROM `ingresocab` AS cab LEFT JOIN `ingresodet` AS det ON cab.nroingreso = det.nroingreso LEFT JOIN `clientes` AS cli ON cab.idcliente = cli.idcliente LEFT JOIN `equipos` AS eq ON det.idequipo = eq.idequipo LEFT JOIN `marcas` AS mar ON eq.idmarca = mar.idmarca LEFT JOIN `modelos` AS mo ON eq.idmodelo = mo.idmodelo LEFT JOIN `familias` AS fa ON eq.idfamilia = fa.idfamilia LEFT JOIN `subfamilias` AS sf ON eq.idsubfamilia = sf.idsubfamilia WHERE eq.idfamilia = $familia and det.estado = 1 ORDER BY cab.fechaingreso	";    
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}
			
			public function getValoresCalibracion($familia)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "select * FROM `valoresnominales` WHERE idfamilia = $familia ORDER BY id	";    
            $resultado= $conn->query($peticion );

            return $resultado;
            $conn->close();	
				
			}

			public function getListaValoresCalibracion()
			{
			$db= new conectar;
            $conn = $db->con_mysql();
			$matriz = array();
			$registro = array();	
			$familias = $this->getListaFamilias();
				while ($familia=$familias->fetch_array()){ 
			$peticion = "select * FROM `valoresnominales` WHERE idfamilia =".$familia['idfamilia']." ORDER BY id	";    
            $resultado= $conn->query($peticion );
			
			$registro['idfamilia'] = $familia['idfamilia'];
			$registro['familia'] = $familia['familia'];	
			$cadena ="";
			$unidad = "";		
			if($resultado){		
				while($res=$resultado->fetch_array()){
					$cadena.=$res['valornominal'].'/';
					$unidad = $res['unidad'];
				}
				$cadena = substr($cadena,0,-1);
			}else{
				$cadena ='entra por false';
			}	
			$registro['valores']=$cadena;
			$registro['unidad']=$unidad;	
					
			array_push($matriz,$registro);	
			}
             

            return $matriz;
            $conn->close();	
				
			}	
	
	
			public function getCalibracion($nrocalibracion)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `calibracioncab` WHERE id = $nrocalibracion" );

            return $resultado->fetch_array();
            $conn->close();	
			}

			public function getCalibracionEquipos($nrocalibracion)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `calibracionequipos` WHERE idcalibracion = $nrocalibracion" );

            return $resultado;
            $conn->close();	
			}
	
			public function getValorNominal($id)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `valoresnominales` WHERE id = $id" );

            return $resultado->fetch_array();
            $conn->close();	
			}


			public function grabaCabeceraCalibracion($id, $fechaingreso, $familia, $patron,$cadena,$useralta,$nombrecal)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if ($id==0)
            {
			$estado='Nueva';	
            $peticion = "INSERT INTO `calibracioncab` (`fechaalta`, `idfamilia`, `idpatron`, `valores`,`estado`,`useralta`,`nombrecal`) VALUES ('$fechaingreso',$familia, $patron,'$cadena','$estado','$useralta','$nombrecal' )";
            }
            else
            {
			$cadena_original = $this->getCadenaValores($id);
				if($cadena!='') {
			$valores_final = $cadena_original[0].'/'.$cadena;
					}else{
			$valores_final = $cadena_original[0];		
				}
            $peticion = "UPDATE `calibracioncab` SET `fechaalta`= '$fechaingreso', `idfamilia`=$familia, `idpatron`=$patron, `valores`='$valores_final', `nombrecal` = '$nombrecal' WHERE `id`=$id";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
				 if ($id==0){	
                return $conn->insert_id();
				 }else{
				return $id;	 
				 }
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
			}

			public function grabaValoresNominales($idfamilia, $idvalor, $valor, $unidad)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            if ($idvalor==0)
            {
            $peticion = "INSERT INTO `valoresnominales` (`idfamilia`, `valornominal`, `unidad`) VALUES ($idfamilia, '$valor','$unidad')";
            }
            else
            {
            $peticion = "UPDATE `valoresnominales` SET `valornominal`= '$valor', `unidad`='$unidad' WHERE `id`=$idvalor";
            }            
            $resultado= $conn->query($peticion );
                if($resultado){
				 if ($id==0){	
                return $conn->insert_id();
				 }else{
				return $id;	 
				 }
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
			}
	
			public function generaChequeoEquipos($idcalibracion, $idequipo)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
			
			$peticion ="INSERT INTO `chequeoequipos` (`idcalibracion`,`idequipo`,`iditemchequeo`, `itemchequeo`, `repara`, `ok`, `observaciones`)SELECT $idcalibracion AS idcalibracion ,$idequipo AS idequipo , id, nombre, 0 as repara, 0 as ok, '' as texto  FROM `itemschequeo` AS i";	
			
            $resultado= $conn->query($peticion );
            if($resultado){
				return 1;
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
			}

			public function generaCalibracionEquipos($idcalibracion, $idequipo, $nroingreso)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
			$existe = $this->existeCalibracionEquipos($idcalibracion, $idequipo, $nroingreso);
				
            $peticion = "INSERT INTO `calibracionequipos` (`idcalibracion`, `idequipo`, `nroingreso`, `flagfalla`,`observaciones`) VALUES ($idcalibracion,$idequipo, $nroingreso,0,'')";

            if ($existe[0]==0)
            {	
			$resultado= $conn->query($peticion );
                if($resultado){	
                return 1;
				 }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            	
			}else{
				return 0;
			}
			$conn->close();	
			}
	
			public function existeCalibracionEquipos($idcalibracion, $idequipo, $nroingreso)
			{
			$db= new conectar;
			$conn = $db->con_mysql();    
			$resultado= $conn->query("SELECT count(*) FROM calibracionequipos WHERE idcalibracion=$idcalibracion AND idequipo = $idequipo AND nroingreso=$nroingreso" );

			return $resultado->fetch_array();
			$conn->close();

			}

			public function generaCalibracionMediciones($idcalibracion, $idequipo, $valores)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
			
			$sep = explode('/',$valores);
			foreach ($sep as $val)
			{
			
			
			$existe = $this->existeCalibracionMediciones($idcalibracion, $idequipo, $val[0]);
			if ($existe[0]==0){	
            $peticion = "INSERT INTO `calibracionmediciones` (`idcalibracion`, `idequipo`, `valornominal`, `medpatron`, `medsinajuste`, `medajustado`, `observaciones`) VALUES ($idcalibracion,$idequipo, $val[0],0,0,0,'')";

			$resultado= $conn->query($peticion );
			}				

			}
			$conn->close();	
			}
	
			public function existeCalibracionMediciones($idcalibracion, $idequipo, $valornominal)
			{
			$db= new conectar;
			$conn = $db->con_mysql();    
			$resultado= $conn->query("SELECT count(*) FROM calibracionmediciones WHERE idcalibracion=$idcalibracion AND idequipo = $idequipo AND valornominal=$valornominal" );

			return $resultado->fetch_array();
			$conn->close();

			}
	
        public function eliminaCalibracion($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();

			$peticion = "DELETE FROM `calibracioncab` WHERE `id`=$id";
            $resultado= $conn->query($peticion );
                if($resultado){
                $this->registra_log('Laboratorio','Se ha eliminado la calibracion id: '.$id);
                return TRUE;}else{
//				return $filename;}else{			
//                echo "<br> no se pudo ejecutar la consulta: " ;
				return "<br> no se pudo ejecutar la consulta: " ;	
                }
                    
            $conn->close();
        }

		public function eliminaValorNominal($idvalor)
		{
            $db= new conectar;
            $conn = $db->con_mysql();

			$peticion = "DELETE FROM `valoresnominales` WHERE `id`=$idvalor";
            $resultado= $conn->query($peticion );
                if($resultado){
                return TRUE;}else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }
                    
            $conn->close();
		
		}
	
        public function eliminaValorCalibracion($idcalibracion, $idvalor)
        {
            $db= new conectar;
            $conn = $db->con_mysql();

			$peticion = "DELETE FROM `calibracionmediciones` WHERE `idcalibracion`=$idcalibracion AND `valornominal`= $idvalor";
            $resultado= $conn->query($peticion );
                if($resultado){
				$this->actualizaValoresCalibracion($idcalibracion, $idvalor);	
                $this->registra_log('Laboratorio','Se ha eliminado el valor id: '.$idvalor.' de la calibracion id: '.$idcalibracion);
                return TRUE;}else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }
                    
            $conn->close();
        }	
		public function eliminaEquipoCalibracion($idcalibracion, $idequipo)
		{
            $db= new conectar;
            $conn = $db->con_mysql();

			$peticion = "DELETE FROM `calibracionmediciones` WHERE `idcalibracion`=$idcalibracion AND `idequipo`= $idequipo";
            $resultado= $conn->query($peticion );
                if($resultado){
				$peticion2 = "DELETE FROM `calibracionequipos` WHERE `idcalibracion`=$idcalibracion AND `idequipo`= $idequipo";
				$resultado2= $conn->query($peticion2 );
					if($resultado2){
					$peticion3 = "DELETE FROM `chequeoequipos` WHERE `idcalibracion`=$idcalibracion AND `idequipo`= $idequipo";
					$resultado3= $conn->query($peticion3 );
					}
				}
                if($resultado2){
				                $this->registra_log('Laboratorio','Se ha eliminado el equipo id: '.$idequipo.' de la calibracion id: '.$idcalibracion);
	
				return TRUE;
				}else{
					return FALSE;
				}	
                
                    
            $conn->close();
        }	
	
			public function actualizaEstadoIngresoDetalle($nroingreso,$idequipo,$estado)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("UPDATE `ingresodet` SET estado=$estado WHERE nroingreso=$nroingreso AND idequipo = $idequipo" );
			if($resultado){
                $this->registra_log('Ingresos','Se ha cambiado el estado del equipo id: '.$idequipo.' del ingreso nro: '.$nroingreso);
			}
            $conn->close();	

			}	
	
			public function actualizaValoresCalibracion($idcalibracion, $idvalor)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
				
			$cadena_original = $this->getCadenaValores($idcalibracion);

				
			$val = explode('/',$cadena_original[0]);
			$valores_final = '';	
			foreach ($val as $valor)
			{
				if($valor!=$idvalor){
					$valores_final .= $valor.'/';
				}
			}	
			$valores_final = substr($valores_final,0,-1);

				
            $peticion = "UPDATE `calibracioncab` SET `valores`='$valores_final' WHERE `id`=$idcalibracion";
            $resultado= $conn->query($peticion );
                if($resultado){
				return true;	 
                }else{
                echo "<br> no se pudo ejecutar la consulta: " ;
                }    
            $conn->close();	
			}
	
			public function getCadenaValores($idcalibracion)
			{
			$db= new conectar;
			$conn = $db->con_mysql();    
			$resultado= $conn->query("SELECT valores FROM calibracioncab WHERE id=$idcalibracion" );

			return $resultado->fetch_array();
			$conn->close();

			}	
		public function getCantCalEquipo($idcalibracion)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM calibracionequipos WHERE idcalibracion=$idcalibracion" );
            return $resultado->fetch_array();
            $conn->close();
		}	
	
			public function getCantValoresCalibracion($idvalor)
		{
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT count(*) FROM calibracionmediciones WHERE valornominal=$idvalor" );
            return $resultado->fetch_array();
            $conn->close();
		}
			public function getUnidadMedida($familia)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
             $peticion = "select unidad FROM `valoresnominales` WHERE idfamilia = $familia limit 1	";    
            $resultado= $conn->query($peticion );

            if ($resultado->num_rows>0) {
            	return $resultado->fetch_array();
            } else {
            	return " ";
            }
            
            
            $conn->close();	
				
			}
	
			public function getItemsChequeo($idcalibracion,$idequipo)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("SELECT * FROM `chequeoequipos` WHERE idcalibracion = $idcalibracion AND idequipo= $idequipo ORDER BY iditemchequeo" );

            return $resultado;
            $conn->close();	
			}	

			public function actualizaChequeoEquipo($idcalibracion, $idequipo,$iditemchequeo, $ok, $rep, $obs )
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
			$resultado= $conn->query("UPDATE `chequeoequipos` SET `repara`=$rep, `ok`=$ok , `observaciones` = '$obs' WHERE idcalibracion = $idcalibracion AND idequipo= $idequipo AND  iditemchequeo= $iditemchequeo" );
				
            return true;
            $conn->close();		
				
			}

			public function actualizaEstadoChequeoEquipo($idcalibracion, $idequipo,$estado)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
			$resultado= $conn->query("UPDATE `calibracionequipos` SET `chequeo`=$estado WHERE idcalibracion = $idcalibracion AND idequipo= $idequipo " );

            return true;
            $conn->close();		
				
			}

			public function actualizaEstadoCargaEquipo($idcalibracion, $idequipo,$estado)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
			$resultado= $conn->query("UPDATE `calibracionequipos` SET `cargavalores`=$estado WHERE idcalibracion = $idcalibracion AND idequipo= $idequipo " );
            return true;
            $conn->close();		
				
			}	
			public function getCalibracionMediciones($idcalibracion,$idequipo,$idvalor)
			{
			$db= new conectar;
            $conn = $db->con_mysql();
				if($idequipo==0){
            $resultado= $conn->query("SELECT * FROM `calibracionmediciones` WHERE idcalibracion = $idcalibracion AND valornominal= $idvalor ORDER BY idequipo" );
			}else{
			$resultado= $conn->query("SELECT * FROM `calibracionmediciones` WHERE idcalibracion = $idcalibracion AND valornominal= $idvalor AND idequipo = $idequipo " );		
			}
            return $resultado;
            $conn->close();	
			}		


			public function actualizaCargaValores($idcalibracion, $ide, $idvalor, $valorpatron, $vsa, $vaj, $obs )
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
			$resultado= $conn->query("UPDATE `calibracionmediciones` SET `medpatron`=$valorpatron, `medsinajuste`=$vsa , `medajustado`=$vaj , `observaciones` = '$obs' WHERE idcalibracion = $idcalibracion AND idequipo= $ide AND  valornominal= $idvalor" );
				
            return true;
            $conn->close();		
				
			}
			public function getMedidaPatron($idcalibracion, $idvalor, $idequipo)
			{
			$db= new conectar;
            $conn = $db->con_mysql();    
				if($idequipo==0){
            $resultado= $conn->query("SELECT medpatron FROM `calibracionmediciones` WHERE `idcalibracion` = $idcalibracion AND `valornominal` = $idvalor limit 1" );
					}else{
			$resultado= $conn->query("SELECT medpatron FROM `calibracionmediciones` WHERE `idcalibracion` = $idcalibracion AND `idequipo` = $idequipo  AND `valornominal` = $idvalor limit 1" );		
				}
            return $resultado->fetch_array();
            $conn->close();
			}

public function getListaItemsCotizacion() {
	$db= new conectar;
    $conn = $db->con_mysql();  
    $query = "SELECT * FROM itemscotizacion";
    return $conn->query($query);
}



public function agregarItemCotizacion($descripcion, $precio, $idcapitulo) {
	$db= new conectar;
    $conn = $db->con_mysql();  
    $query = "INSERT INTO itemscotizacion (txtitemcotizacionlista, preciolista, idcapitulo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdi", $descripcion, $precio, $idcapitulo);
    return $stmt->execute();
}

public function actualizarItemCotizacion($id, $descripcion, $precio, $idcapitulo) {
	$db= new conectar;
    $conn = $db->con_mysql();  
    $query = "UPDATE itemscotizacion SET txtitemcotizacionlista = ?, preciolista = ?, idcapitulo = ? WHERE iditemcotizacion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdii", $descripcion, $precio, $idcapitulo, $id);
    return $stmt->execute();
}

public function eliminarItemCotizacion($id) {
	$db= new conectar;
    $conn = $db->con_mysql();  
    $query = "DELETE FROM itemscotizacion WHERE iditemcotizacion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

}



class MenuPadre
{
    var $_id;
    var $_label;
    var $_icono;
    
    
    public function __construct($label,$icono,$orden)
    {
        if($label!='')
        {
            $this->_id = $this->getUltimoIDMenuPadre() + 1;
            $this->_label = $label;
            $this->_icono = $icono;
            $this->_icono = $orden;
        }
        else
        {
            $this->_id=0;
        }
    }
    
    public function getListaMenuPadre()
    {

        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT * FROM menupadre" );

        return $resultado;
        $conn->close();

    }
    
        public function getMenuPadre($id)
    {

        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT * FROM menupadre WHERE idmenupadre=$id" );

        return $resultado->fetch_array();
        $conn->close();

    }
        
    public function grabaMenuPadre()
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $peticion = "INSERT INTO `menupadre` (`idmenupadre`,`menupadre`,`icono`,`orden`) VALUES ('','$this->_label','$this->_icono','$this->_orden')";
        $resultado= $conn->query($peticion );
        if($resultado){
        return TRUE;
        }else{
            echo "<br> no se pudo ejecutar la consulta: " ;
        }    
        $conn->close();
    }

        public function getUltimoIDMenuPadre()
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $resultado= $conn->query("SELECT MAX(idmenupadre) FROM menupadre" );
        if($resultado){
            $result = $resultado->fetch_array();
        return $result[0];
        }else{
            return 0;
        }    
        $conn->close();
    }

        public function eliminaMenuPadre($id)
        {
            $db= new conectar;
            $conn = $db->con_mysql();    
            $resultado= $conn->query("DELETE FROM menupadre WHERE idmenupadre = $id" );
            if($resultado){
            return TRUE;
            }else{
                return 0;
            }    
            $conn->close();
        }

    public function actualizaMenuPadre($id, $menupadre, $icono, $orden)
    {
        $db= new conectar;
        $conn = $db->con_mysql();    
        $peticion = "UPDATE `menupadre` SET `menupadre`= '$menupadre',`icono` = '$icono',`orden` = '$orden' WHERE `idmenupadre`= $id";
        $resultado= $conn->query($peticion );
        if($resultado){
        return TRUE;
        }else{
            echo "<br> no se pudo ejecutar la consulta: " ;
        }    
        $conn->close();
    }
    



}

?>
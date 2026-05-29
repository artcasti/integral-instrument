<?php
class conectar
{

public static function con_mysql()
    {
        $conexion=mysql_connect("localhost", "campo", "austral");
        mysql_query("SET NAMES 'utf8'"); 
        mysql_select_db("campaus");
        return $conexion;
    }


public static function conecta_sucursal($nro){

    $sql="SELECT * FROM sucursales WHERE nro_suc=".$nro.";";
    $res=mysql_query($sql,conectar::con_mysql());
    
    if($row = mysql_fetch_array($res)){
        
                $serverName = $row[3];   //serverName\instanceName
                $connectionInfo = array("Database"=>"$row[4]", "UID"=>"pdc", "PWD"=>"killpdc");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);

                if( !$conn ) {
                        echo "Conexión no se pudo establecer.<br />";
                        echo "ServerName :".$serverName."Database :".$connectionInfo['Database']."UID :".$connectionInfo['UID']."PWD :".$connectionInfo['PWD'];
                     die( print_r( sqlsrv_errors(), true));
                }else{
                return $conn;
                }
    
        }else{
        echo 'error de conexion.';
        return 0;
        }
}



}

//////////////////////////////////////////////////////////////////////////////

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
    if (!is_file($archivo) and strtoupper(substr($archivo, 0,3)) == "ORD")//verificamos si es o no un directorio
    {
        
        $this->_listafiles[]=$archivo.$this->Datos_File($archivo);
    }

    if (!is_file($archivo) and strtoupper(substr($archivo, 0,6)) == "RECADV")//verificamos si es o no un directorio y si es recadv
    {
        
        $this->_listafiles[]=$archivo.$this->Datos_File($archivo);
    }

 }
  return $this->_listafiles;
}

//function Datos_File($archivo) : Devuelve los datos del archivo para mostrar en select/tabla
public function Datos_File($file)
{

$cadena = explode('_',$file);

if(strtoupper(substr($file, 0,6)) == "RECADV"){
$result = '+'.$cadena[2];//substr($file, 4,13); 
 
 switch ($result) {
     case '7795254000007':
         $result .= ' - Cencosud-Jumbo-Disco-Vea';
         break;
 
    case '7798032710006':
         $result .= ' - INC-Carrefour';
         break;

    case '7799001000012':
         $result .= ' - La Anonima';
         break;

    case '7799011000003':
         $result .= ' - Walmart';
         break;

    case '7798039600003':
         $result .= ' - COTO';
         break;

 
     default:
         $result .= ' - ESPECIFICAR CLIENTE EN SWITCH';
         break;
 }

$result .= '+'.$cadena[1];
$result .= '+'.date("d/m/Y H:i:s", filemtime($this->_ruta.'/'.$file));

}else{
$result = '+'.$cadena[1];//substr($file, 4,13); 
 
 switch ($result) {
     case '7795254000007':
         $result .= ' - Cencosud-Jumbo-Disco-Vea';
         break;
 
    case '7798032710006':
         $result .= ' - INC-Carrefour';
         break;

    case '7799001000012':
         $result .= ' - La Anonima';
         break;

    case '7799011000003':
         $result .= ' - Walmart';
         break;

    case '7798039600003': 
         $result .= ' - COTO';
         break;

    case '7798023690003': 
         $result .= ' - VITAL';
         break;

    case '7791102000007': 
         $result .= ' - COOP OBRERA Ltda.';
         break;

    case '7798103000005':
         $result .= ' - NINI';
         break;

    case '7798022220003':
         $result .= ' - YAGUAR';
         break;

    case '7798130250008':
         $result .= ' - DIA%';
         break;

    case '7798085990004':
         $result .= ' - DIARCO';
         break; 
 

     default:
         $result .= ' - ESPECIFICAR CLIENTE EN SWITCH';
         break;
 }

$result .= '+'.$cadena[2];
$result .= '+'.date("d/m/Y H:i:s", filemtime($this->_ruta.'/'.$file));
}


    return $result;

}




public function LeerArchivo($file)
{
 
$archivo = $this->_ruta."/".$file; //ruta actual

$gestor = @fopen($archivo, "r");

if(strtoupper(substr($file, 0,6)) == "RECADV"){

    if ($gestor) {
        while (($bufer = fgets($gestor)) !== false) {
            echo $bufer."\n";
            echo "Subcadena de 3 = ".strtoupper(substr($bufer,0,3));
            echo "<hr>";
            $tipoline=$this->ObtieneTipoLinea(strtoupper(substr($bufer,0,3)));
            $this->SepararLinea($bufer,$tipoline);

        }
        if (!feof($gestor)) {
            echo "Error: fallo inesperado de fgets()\n";
        }
        fclose($gestor);
    }
}else{

    if ($gestor) {
         $i=1;
        while (($bufer = fgets($gestor)) !== false) {
            echo $bufer."\n";
            echo "Subcadena de 4 = ".strtoupper(substr($bufer,0,4));
            echo "<hr>";
            if($i==1)
                {
                    $this->SepararLinea($bufer,'1');
                    $i++;
                }
                else
                {
                    if (strtoupper(substr($bufer,0,4)=='LINE'))
                        {
                        $this->SepararLinea($bufer,'2');
                        }else
                        {
                        $this->SepararLinea($bufer,'3');
                        }
                }
        }
        if (!feof($gestor)) {
            echo "Error: fallo inesperado de fgets()\n";
        }
        fclose($gestor);
    }
}

}

public function MoverArchivo($file,$carpetaorigen,$carpetadestino){

$archivo = $carpetaorigen."/".$file; //ruta actual

$nuevo_archivo =$carpetadestino."/".$file;


        if (copy($archivo, $nuevo_archivo)) {
            unlink($archivo);
        }else{
            echo "Error al copiar $archivo:".$archivo;    
        }

}

public function ImportarArchivo($file,$user)
{
 
$archivo = $this->_ruta."/".$file; //ruta actual

$nuevo_archivo =$this->_ruta."/procesados/".$file;

$archivo_conflicto =$this->_ruta."/conflictos/".$file;

//echo '<br>'.$archivo.'<br>';

if(strtoupper(substr($file, 0,6)) == "RECADV"){

   $nroreg = $this->ImportarRecadv($file,$user);

}else{
        $consplit=$this->chequeasplit($file);

        if ($consplit=='S') {
            
            $nroreg = $this->ImportarArchivoConSplit($file,$user);

        }else {

                    $gestor = @fopen($archivo, "r");
                    if ($gestor) {

                             $nroreg = $this->GetUltimoPedido();
                        //echo '<br>'.$nroreg.'<br>';     
                            while (($bufer = fgets($gestor)) !== false) {
                                $tipolinea = strtoupper(substr($bufer,0,4));


                                switch($tipolinea){
                                    case "HEAD":
                                        try{
                                            $eancomprador=$this->InsertarHead($bufer,$nroreg,$file,$user);
                                            }catch (Exception $e){
                                                    fclose($gestor);
                                                    if (copy($archivo, $archivo_conflicto)) {
                                                    unlink($archivo);
                                                }else{
                                                    echo "Error al copiar $archivo:".$archivo;    
                                                }
                                                throw $e;
                                            }
                                    break;
                                    case "LINE":
                                        $lin=$this->InsertarLine($bufer,$nroreg,$eancomprador);
                                    break;
                                    case "SPLI":
                                        $this->InsertarSplit($bufer,$nroreg,$lin);
                                    break;

                                }
                            }

                                    if (!feof($gestor)) {
                                        echo "Error: fallo inesperado de fgets()\n";
                                    }
                                fclose($gestor);

                                if (copy($archivo, $nuevo_archivo)) {
                                    unlink($archivo);
                                }else{
                                    echo "Error al copiar $archivo:".$archivo;    
                                }

                        }else{
                            echo "No pude abrir el archivo";
                        }
            }
    }    
return $nroreg;
}

public function ImportarRecadv($file,$user){

$archivo = $this->_ruta."/".$file; //ruta actual
$nuevo_archivo =$this->_ruta."/importados/".$file;
$archivo_conflicto =$this->_ruta."/conflictos/".$file;

$nroreg = $this->GetUltimoRecadv();

$resuc=$renro=$pcnro=$ivsuc=$ivnro=0;

  $FileName=$file;
  $Estado='I';
  $FechaCarga=date('Ymd');
  $UserCarga=$user;
  $obs="";

$cantrecibida=$cantrecyacep=$cantuxc=0;

        $gestor = @fopen($archivo, "r");
        if ($gestor) {

                while (($bufer = fgets($gestor)) !== false) {
                    $tipoline=$this->ObtieneTipoLinea(strtoupper(substr($bufer,0,3)));
                    switch (substr($bufer,0,3)) {
                                        case '000':
                                            $camposfile=$this->GetArrayLinea($bufer,$tipoline);
                                            $glnemisor=$camposfile[2];
                                            break;
                                        case '010':
                                            $camposfile=$this->GetArrayLinea($bufer,$tipoline);
                                            $nrorecadv=$camposfile[1];
                                            $codrecadv=$camposfile[2];
                                            $fecharecadv=trim($camposfile[3]);
                                            break;
                                        case '020':
                                            $camposfile=$this->GetArrayLinea($bufer,$tipoline);
                                             switch ($camposfile[1]) {
                                                case 'RE':
                                                    $resuc=intval($camposfile[2]);
                                                    $renro=intval($camposfile[3]);
                                                    break;
                                                case 'PC':
                                                    $pcnro=$camposfile[3];
                                                    break;
                                                case 'IV':
                                                    $ivsuc=intval($camposfile[2]);
                                                    $ivnro=intval($camposfile[3]);
                                                    break;                                                
                                            }
                                            break;
                                        case '050':
                                            $camposfile=$this->GetArrayLinea($bufer,$tipoline);
                                            $glnboca=$camposfile[1];
                                            $datoscliente=$this->ObtenerDatosCliente($glnboca);
                                            $cliid=$datoscliente[0]['clivtaid'];
                                            $clinom=$datoscliente[0]['clinomred'];
                                            $cliidmatriz=$datoscliente[0]['empmazid'];
                                            //Busco la información de los comprobantes relacionados a la recepcion (remito y factura)
                                            if ($resuc!=0) {
                                                $cpbte=$this->BuscaComprobanteRelacionado($cliid,$resuc,$renro);
                                                //print_r($cpbte[0]);
                                            }else{
                                                $cpbte=$this->BuscaComprobanteRelacionado($cliid,$ivsuc,$ivnro);
                                                 //print_r($cpbte[0]);
                                            }

                                                if (sizeof($cpbte)>1) { //chequeo si hay mas de un registro encontrado (suc 49 puede ser)
                                                    $Estado='N';
                                                }else{
                                                    if ($cpbte[0]['rtosuc']!=0) {
                                                        $resuc=$cpbte[0]['rtosuc'];
                                                        $renro=$cpbte[0]['rtonrodef'];
                                                        $ivsuc=$cpbte[0]['rtofacsuc'];
                                                        $ivnro=$cpbte[0]['rtofacnrod'];
                                                        $Estado='C';
                                                    }
                                                }
                                            $this->InsertRecadvCAB($nroreg,$glnemisor,$nrorecadv,$codrecadv,$fecharecadv,$resuc,$renro,$pcnro,$ivsuc,$ivnro,$glnboca,$cliid,$clinom,$cliidmatriz,$obs,$FileName,$Estado,$FechaCarga,$UserCarga);
                                            //echo "Cabecera separada por mases:".$datoscliente[0]['cliprcnro']."+".$nroreg."+".$glnemisor."+".$nrorecadv."+".$codrecadv."+".$fecharecadv."+".$resuc."+".$renro."+".$pcnro."+".$ivsuc."+".$ivnro."+".$glnboca."+".$cliid."+".$clinom."+".$cliidmatriz."<br>";
                                            break;  
                                            //Empiezo a Armar el detalle
                                        case '110':
                                            $camposfile=$this->GetArrayLinea($bufer,$tipoline);
                                            $nrolinea=$camposfile[1];
                                                if (substr(trim($camposfile[2]),0,2)=='00'){
                                                    $prod=intval(trim($camposfile[2]));
                                                }else{
                                                    if (substr(trim($camposfile[2]),0,1)=='0'){
                                                    $prod=trim(substr($camposfile[2],1));    
                                                    }else{                                                    
                                                    $prod=trim($camposfile[2]);
                                                    }
                                                }

                                            $datosproducto=$this->ObtenerDatosProducto($prod, $datoscliente[0]['cliprcnro']); 
                                            $eanarticulo=$camposfile[2];
                                            $descripcion=$camposfile[5];
                                            $preciorecadv=substr($camposfile[6],0,11).'.'.substr($camposfile[6],11,4);
                                            $prdid=$datosproducto[0]['prdid']; 
                                            $prdtxt=$datosproducto[0]['prdtxt']; 
                                            $precioca=$datosproducto[0]['prcsalfab'];
                                                        $cantfac=0;
                                                        $prcitem=0;
                                                        $prcinfitem=0;
                                            break;  
                                        case '111':
                                            $camposfile=$this->GetArrayLinea($bufer,$tipoline);
                                            switch ($camposfile[2]) {
                                                case '48':
                                                    $cantrecibida=substr($camposfile[3],0,10).'.'.substr($camposfile[3],10,5);
                                                    
                                                    if ($cpbte[0]['rtosuc']!=0){

                                                    $datositem=$this->BuscaInfoItem($resuc, $cpbte[0]['rtonro'], $ivsuc, $cpbte[0]['rtofacnro'], $prdid);//$rsuc, $rnro, $fsuc, $fnro, $prdid
                                                    $cantfac=$datositem[0]['facprdcnt'];
                                                    $prcitem=$datositem[0]['facprdimpb'];
                                                    $prcinfitem=$datositem[0]['facprdprci'];
                                                    }
                                            
                                            $this->InsertRecadvDet($nroreg,intval($nrolinea),$eanarticulo,$descripcion,floatval($preciorecadv),floatval($cantrecibida),$prdid,$prdtxt,$precioca,$cantfac,$prcitem,$prcinfitem);
                                            //echo "Linea separada por mases:".$nroreg."+".intval($nrolinea)."+".$eanarticulo."+".$descripcion."+".floatval($preciorecadv)."+".$prdid."+".$prdtxt."+"."++".$precioca."++".floatval($cantrecibida)."+"."<br>";        
                                                    break;
                                            }
                                            
                                            break;  
        
                                    }
                    }
                }

                    fclose($gestor);

                                if (copy($archivo, $nuevo_archivo)) {
                                    unlink($archivo);
                                }else{
                                    echo "Error al copiar $archivo:".$archivo;    
                                }
return $nroreg;
}

public function InsertRecadvCAB($nroreg,$glnemisor,$nrorecadv,$codrecadv,$fecharecadv,$resuc,$renro,$pcnro,$ivsuc,$ivnro,$glnboca,$cliid,$clinom,$cliidmatriz,$obs,$archivo,$estado,$fechacarga,$user){

$sql="
INSERT INTO [GACI35].[Campo].[RecadvCab]
 ([idrecadv],[glnemisor] ,[nrorecadv] ,[codrecadv] ,[fecharecadv] ,[resuc] ,[renro] ,[pcnro] ,[ivsuc] ,[ivnro]
 ,[glnboca] ,[cliid] ,[clinom] ,[cliidmatriz] ,[observaciones] ,[FileName] ,[Estado] ,[FechaCarga] ,[UserCarga])
     VALUES
           (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
";

$params=array($nroreg,$glnemisor,$nrorecadv,$codrecadv,$fecharecadv,$resuc,$renro,$pcnro,$ivsuc,$ivnro,$glnboca,$cliid,$clinom,$cliidmatriz,$obs,$archivo,$estado,$fechacarga,$user );


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $nroreg;

}


public function InsertRecadvDet($nroreg,$nrolinea,$eanarticulo,$descripcion,$preciorecadv,$cantrecibida,$prdid,$prdtxt,$precioca,$cantfac,$prcitem,$prcinfitem){

$sql="
INSERT INTO [GACI35].[Campo].[RecadvDet]
  ([idrecadv],[nrolinea] ,[eanarticulo] ,[descripcion] ,[preciorecadv] ,[cantrecibida] ,[prdid] ,[prdtxt] ,[precioca],[cantfacturada],[preciofactura],[precioinffact])
     VALUES
           (?,?,?,?,?,?,?,?,?,?,?,?)
";

$params=array($nroreg,$nrolinea,$eanarticulo,$descripcion,$preciorecadv,$cantrecibida,$prdid,$prdtxt,$precioca,$cantfac,$prcitem,$prcinfitem);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $nroreg;

}

public function BuscaComprobanteRelacionado($cliid, $suc, $numero)
{

    $sql="
        exec [dbo].[Sel_BuscaComprobante] ?,?,?
    ";

    $params =array($cliid,$suc,$numero);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }
    if (!isset($result)) {
        $result[0]['rtosuc']=0;
    }

return $result;
sqlsrv_close($conexion);
}

public function BuscaInfoItem($rsuc, $rnro, $fsuc, $fnro, $prdid){

    $sql="
        select rd.rtoprdid, rd.rtoprdvtau, rd.rtoprdcnt, fd.facprdcnt, fd.facprdprcf, fd.facprdprci,fd.facprdimpb, fd.facimpprd --  * 
        from ven35.rtodet rd (nolock) left join  ven35.facdet fd (nolock) on rd.rtoprdid = fd.facprdid
        where rd.rtosuc = ? and rd.rtonro = ?
        and fd.facsuc = ? and fd.facnro = ?
        and rd.rtoprdid = ?

    ";

    $params =array($rsuc, $rnro, $fsuc, $fnro, $prdid);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }

    if (!isset($result)) {
        $result[0]['facprdcnt']=0;
        $result[0]['facprdimpb']=0;
        $result[0]['facprdprci']=0;
    }


return $result;
sqlsrv_close($conexion);

}


public function ImportarArchivoConSplit($file, $user){

$archivo = $this->_ruta."/".$file; //ruta actual


        $gestor = @fopen($archivo, "r");
        if ($gestor) {
                while (($bufer = fgets($gestor)) !== false) {
                    if(strtoupper(substr($bufer,0,4))=="HEAD"){
                    $textocabecera = $bufer;
                    }
                    if(strtoupper(substr($bufer,0,4))=="LINE"){
                    $textoline[substr($bufer,10,14)] = $bufer;
                    }                     
                    if(strtoupper(substr($bufer,0,4))=="SPLI"){
                        $camposfile=$this->GetArrayLinea($bufer,'3');
                        $datospedidos[$camposfile[3]][$camposfile[1]]=$camposfile[4];

                    }

                    }
                }

                    fclose($gestor);


for ($i=0; $i < sizeof($datospedidos); $i++) { 
 
$nroreg = $this->GetUltimoPedido();
$suc = key($datospedidos);
$this->InsertarHeadConSplit($textocabecera,$nroreg,$file,$user,$suc);
    for ($i=0; $i < sizeof($datospedidos[$suc]); $i++) {
    $eansplit=key($datospedidos[$suc]); 
      //  print_r($textoline);   
    $this->InsertarLineConSplit($textoline[$eansplit],$nroreg,$suc,$datospedidos[$suc][$eansplit]);
    next($datospedidos[$suc]);
    }

next($datospedidos);
/*
echo '<br>';
print_r(key($datospedidos));
echo '<br>';
print_r(key($datospedidos[key($datospedidos)]));
echo '<br>';
next($datospedidos);    
*/
}

return $nroreg;
}



public function chequeasplit($file){

$archivo = $this->_ruta."/".$file; //ruta actual

$result = 'N';

        $gestor = @fopen($archivo, "r");
        if ($gestor) {
                while (($bufer = fgets($gestor)) !== false) {
                 
                    if(strtoupper(substr($bufer,0,4))=="SPLI"){
                        $result='S';
                        break;
                    }

                    }
                }

                    fclose($gestor);
return $result;
}


public function InsertarHeadConSplit($texto,$nroreg,$archivo,$user,$glnsplit)
{
    $camposfile=$this->GetArrayLinea($texto,'1');
try{
    if ($camposfile[1]=='7799001000012'){
    $datoscliente=$this->ObtenerDatosClienteLA($camposfile[22],$camposfile[3]);
}else{
    $datoscliente=$this->ObtenerDatosCliente($glnsplit);    
}

$succod = 1;
$fchvto = $camposfile[15];
$pedser = "";
$genfch = $camposfile[13];
$movtpo = "N";
$cliid = $datoscliente[0]['clivtaid'];
$expmca = $datoscliente[0]['cliexp'];
$trmvta = $datoscliente[0]['CliTrmVtaI'];
$bongrl = '';
$obser1 = "";
$lprsuc = 1;
$lprnro = $datoscliente[0]['cliprcnro'];
$lprfch = $datoscliente[0]['prcfchvig'];
$monid = 1;
if ($datoscliente[0]['cliexp']=='S'){
$vtatpo = 2; }else {
$vtatpo = 1;    
}
// tipos en select * from ven34.tpovta
$dpsemp = 1; 
$dpscod = $datoscliente[0]['clidpsaso'];
$vensuc = 1;
$vencod = $datoscliente[0]['clivdorid'];
$entfch = $camposfile[14];
$totimp = 0;
if ($datoscliente[0]['cliexp']=='S'){
$plaexp = "E";}else{
$plaexp = "P";    
}
$prcfch = $camposfile[14];
$prchor = "";
$lugent = $datoscliente[0]['CliLugItem'];
$errcod = "";
$nrodef = 0;
$flgrpr = "S";
$pedtpo = "N"; //select * from ven35.tpoped (m es sin cargo)
$orinro = 0;
$clidat = $datoscliente[0]['clinomred'];
$discod = $datoscliente[0]['clidiscod'];
  if ($camposfile[1]=='7798032710006'){
$ordcmp = substr(trim($camposfile[30]),-12);}else{
$ordcmp = $camposfile[30];    
}
$pricod = 50;
$intnro = 0;
$boncli = '';
$asgman = "S";
$acomca = "N";
$obsimp = "S";
$leycod = 0;
$obser2 = "";
$obser3 = "Importado Krikos";
$obser4 = "";
$lugeni = $datoscliente[0]['CliLugItem'];
$emptpo = "";
$clisfi = $datoscliente[0]['Clisitfisr'];
$aplgen = "";
$mrcpen = "";
$pedaco = 0;
$estado = "I";
$fechacarga = date('Ymd');


$sql =
"
INSERT INTO [GACI35].[Campo].[BPVCAB]
([BPVCNroReg],[BPVCSucCod],[BPVCFchVto],[BPVCPedSer],[BPVCGenFch],[BPVCMovTpo],[BPVCCliId],[BPVCExpMca],[BPVCTrmVta],[BPVCBonGrl],[BPVCObser1]
,[BPVCLPrSuc],[BPVCLPrNro],[BPVCLPrFch],[BPVCMonId],[BPVCVtaTpo],[BPVCDpsEmp],[BPVCDpsCod],[BPVCVenSuc],[BPVCVenCod],[BPVCEntFch],[BPVCTotImp],[BPVCPlaExp]
,[BPVCPrcFch],[BPVCPrcHor],[BPVCLugEnt],[BPVCErrCod],[BPVCNroDef],[BPVCFlgRpr],[BPVCPedTpo],[BPVCOriNro],[BPVCCliDat],[BPVCDisCod],[BPVCOrdCmp],[BPVCPriCod]
,[BPVCIntNro],[BPVCBonCli],[BPVCAsgMan],[BPVCAcoMca],[BPVCObsImp],[BPVCLeyCod],[BPVCObser2],[BPVCObser3],[BPVCObser4],[BPVCLugEnI],[BPVCEmpTpo],[BPVCCliSFi]
,[BPVCAplGen],[BPVCMrcPen],[BPVCPedAco],[BPVCFileName],[BPVCEstado],[BPVCFechaCarga],[BPVCUserCarga])
     VALUES
(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
";
$params=array($nroreg,$succod,$fchvto,$pedser,$genfch,$movtpo,$cliid,$expmca,$trmvta,$bongrl,$obser1,$lprsuc,$lprnro,$lprfch,$monid,$vtatpo,$dpsemp,$dpscod
,$vensuc,$vencod,$entfch,$totimp,$plaexp,$prcfch,$prchor,$lugent,$errcod,$nrodef,$flgrpr,$pedtpo,$orinro,$clidat,$discod,$ordcmp,$pricod,$intnro,$boncli,$asgman
,$acomca,$obsimp,$leycod,$obser2,$obser3,$obser4,$lugeni,$emptpo,$clisfi,$aplgen,$mrcpen,$pedaco,$archivo,$estado,$fechacarga,$user );


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $camposfile[3];

    
}catch (Exception $e){
    throw $e;
}


}

public function InsertarLineConSplit($texto,$nroreg,$cliente,$cantsplit)
{
  //  echo 'entre InsertarLineConSplit:'.$cantsplit.'<br>';
  //  print_r($texto);
    $camposfile=$this->GetArrayLinea($texto,'2');
try{
    $datoscliente=$this->ObtenerDatosCliente($cliente);
    
    }catch (Exception $e){
    echo 'Excepción capturada: ',$e->getMessage(),'\n';
    }

    $datosproducto = $this->ObtenerDatosProducto($camposfile[2], $datoscliente[0]['cliprcnro']); 

$Item = $camposfile[1];
$PrdId = $datosproducto[0]['prdid']; 
$rdNv1 = '';
$PrdNv2 = '';
$PrdNv3 = '';
$PrdNv4 = '';
$PrdNv5 = '';
$PrdCla = $datosproducto[0]['prdclaid'];
$PrdVtU = $datosproducto[0]['prdidunivt']; 

switch ($datoscliente[0]['empmazid']) {
    case '30018000':
        $PrdCnt = ($cantsplit*$camposfile[13]);
        break;
    case '30003030':
        $PrdCnt = $this->Cantidad_Redondeo($datosproducto[0]['prdid'],$cantsplit);
        break;
    default:
        $PrdCnt = $cantsplit;    
        break;
}

$PrdPrc = $datosproducto[0]['prcsalfab']; 
$PrdPrI = $camposfile[18];
$ImpNto  = $camposfile[20];
$ItmFlg = '';
$ItmCod = '';
$CntBon = 0;
$CntUm2 = 0;
$Um1 = '';
$CntUm1 = 0;
if (strtoupper(substr($datosproducto[0]['prdtxt'],0,4))=='NO E'){
$BPCDObsIt = $datosproducto[0]['prdtxt'].'+'.$camposfile[10].'+'.$camposfile[5];
}else{
$BPCDObsIt = '';    
}

$datosline[0]=$Item;
$datosline[1]=$PrdId;

$sql =
"
INSERT INTO [GACI35].[Campo].[BPVDET]
([BPVCNroReg],[BPVDItem],[BPVDPrdId],[BPVDPrdNv1],[BPVDPrdNv2],[BPVDPrdNv3],[BPVDPrdNv4],[BPVDPrdNv5],[BPVDPrdCla],[BPVDPrdVtU],[BPVDPrdCnt],[BPVDPrdPrc]
,[BPVDPrdPrI],[BPVDImpNto],[BPVDItmFlg],[BPVDItmCod],[BPVDCntBon],[BPVDCntUm2],[BPVDUm1],[BPVDCntUm1],[BPCDObsIt])
VALUES
(?, ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?)
";

$params=array($nroreg, $Item ,$PrdId ,$rdNv1 ,$PrdNv2 ,$PrdNv3 ,$PrdNv4 ,$PrdNv5 ,$PrdCla,$PrdVtU,$PrdCnt,$PrdPrc,$PrdPrI,$ImpNto,$ItmFlg,$ItmCod,$CntBon,$CntUm2,$Um1,$CntUm1,$BPCDObsIt);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $datosline;

}



public function InsertarHead($texto,$nroreg,$archivo,$user)
{
    $camposfile=$this->GetArrayLinea($texto,'1');
try{
    if ($camposfile[1]=='7799001000012'){
    $datoscliente=$this->ObtenerDatosClienteLA($camposfile[22],$camposfile[3]);
}else{
    $cat='';
    $categoria=$this->ObtenerCategoriaPedido($archivo);
    if (strtoupper(substr(@$categoria[0]['prdnv1cod'],0,2))=='FR'){$cat='6';}
    //$datoscliente=$this->ObtenerDatosCliente($camposfile[3]);    
    $datoscliente=$this->ObtenerDatosClienteConCategoria($camposfile[3],$cat); 
}

$succod = 1;
$fchvto = $camposfile[15];
$pedser = "";
$genfch = $camposfile[13];
$movtpo = "N";
$cliid = $datoscliente[0]['clivtaid'];
$expmca = $datoscliente[0]['cliexp'];
$trmvta = $datoscliente[0]['CliTrmVtaI'];
$bongrl = '';
$obser1 = "";
$lprsuc = 1;
$lprnro = $datoscliente[0]['cliprcnro'];
$lprfch = $datoscliente[0]['prcfchvig'];
$monid = 1;
if ($datoscliente[0]['cliexp']=='S'){
$vtatpo = 2; }else {
$vtatpo = 1;    
}
// tipos en select * from ven34.tpovta
$dpsemp = 1; 
$dpscod = $datoscliente[0]['clidpsaso'];
$vensuc = 1;
$vencod = $datoscliente[0]['clivdorid'];
$entfch = $camposfile[14];
$totimp = 0;
if ($datoscliente[0]['cliexp']=='S'){
$plaexp = "E";}else{
$plaexp = "P";    
}
$prcfch = $camposfile[14];
$prchor = "";
$lugent = $datoscliente[0]['CliLugItem'];
$errcod = "";
$nrodef = 0;
$flgrpr = "S";
$pedtpo = "N"; //select * from ven35.tpoped (m es sin cargo)
$orinro = 0;
$clidat = $datoscliente[0]['clinomred'];
$discod = $datoscliente[0]['clidiscod'];
  if ($camposfile[1]=='7798032710006'){
$ordcmp = substr(trim($camposfile[30]),-12);}else{
$ordcmp = $camposfile[30];    
}
$pricod = 50;
$intnro = 0;
$boncli = '';
$asgman = "S";
$acomca = "N";
$obsimp = "S";
$leycod = 0;
$obser2 = "";
$obser3 = "Importado Krikos";
$obser4 = "";
$lugeni = $datoscliente[0]['CliLugItem'];
$emptpo = "";
$clisfi = $datoscliente[0]['Clisitfisr'];
$aplgen = "";
$mrcpen = "";
$pedaco = 0;
$estado = "I";
$fechacarga = date('Ymd');


$sql =
"
INSERT INTO [GACI35].[Campo].[BPVCAB]
([BPVCNroReg],[BPVCSucCod],[BPVCFchVto],[BPVCPedSer],[BPVCGenFch],[BPVCMovTpo],[BPVCCliId],[BPVCExpMca],[BPVCTrmVta],[BPVCBonGrl],[BPVCObser1]
,[BPVCLPrSuc],[BPVCLPrNro],[BPVCLPrFch],[BPVCMonId],[BPVCVtaTpo],[BPVCDpsEmp],[BPVCDpsCod],[BPVCVenSuc],[BPVCVenCod],[BPVCEntFch],[BPVCTotImp],[BPVCPlaExp]
,[BPVCPrcFch],[BPVCPrcHor],[BPVCLugEnt],[BPVCErrCod],[BPVCNroDef],[BPVCFlgRpr],[BPVCPedTpo],[BPVCOriNro],[BPVCCliDat],[BPVCDisCod],[BPVCOrdCmp],[BPVCPriCod]
,[BPVCIntNro],[BPVCBonCli],[BPVCAsgMan],[BPVCAcoMca],[BPVCObsImp],[BPVCLeyCod],[BPVCObser2],[BPVCObser3],[BPVCObser4],[BPVCLugEnI],[BPVCEmpTpo],[BPVCCliSFi]
,[BPVCAplGen],[BPVCMrcPen],[BPVCPedAco],[BPVCFileName],[BPVCEstado],[BPVCFechaCarga],[BPVCUserCarga])
     VALUES
(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
";
$params=array($nroreg,$succod,$fchvto,$pedser,$genfch,$movtpo,$cliid,$expmca,$trmvta,$bongrl,$obser1,$lprsuc,$lprnro,$lprfch,$monid,$vtatpo,$dpsemp,$dpscod
,$vensuc,$vencod,$entfch,$totimp,$plaexp,$prcfch,$prchor,$lugent,$errcod,$nrodef,$flgrpr,$pedtpo,$orinro,$clidat,$discod,$ordcmp,$pricod,$intnro,$boncli,$asgman
,$acomca,$obsimp,$leycod,$obser2,$obser3,$obser4,$lugeni,$emptpo,$clisfi,$aplgen,$mrcpen,$pedaco,$archivo,$estado,$fechacarga,$user );


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $camposfile[3];

    
}catch (Exception $e){
    throw $e;
}


}


public function InsertarLine($texto,$nroreg,$cliente)
{
    
    $camposfile=$this->GetArrayLinea($texto,'2');
try{
    $datoscliente=$this->ObtenerDatosCliente($cliente);
    

    }catch (Exception $e){
    echo 'Excepción capturada: ',$e->getMessage(),'\n';
    }

    $datosproducto = $this->ObtenerDatosProducto($camposfile[2], $datoscliente[0]['cliprcnro']); 

$Item = $camposfile[1];
$PrdId = $datosproducto[0]['prdid']; 
$rdNv1 = '';
$PrdNv2 = '';
$PrdNv3 = '';
$PrdNv4 = '';
$PrdNv5 = '';
$PrdCla = $datosproducto[0]['prdclaid'];
$PrdVtU = $datosproducto[0]['prdidunivt']; 

switch ($datoscliente[0]['empmazid']) {
    case '30018000':
        $PrdCnt = ($camposfile[16]*$camposfile[13]);
        break;
    case '30008000':
        $PrdCnt = ($camposfile[17]*$camposfile[13]);
        break;    
    case '30003030':
        $PrdCnt = $this->Cantidad_Redondeo($datosproducto[0]['prdid'],$camposfile[16]);
        break;
    case '20295000':
        $PrdCnt = $this->Cantidad_X_Caja($datosproducto[0]['prdid'],$camposfile[13]);
        break;
    case '30040000':
        $PrdCnt = $this->Cantidad_X_Yaguar($datosproducto[0]['prdid'],$camposfile[13]);
        break;
   case '30009000':
        $PrdCnt = $this->Cantidad_X_Yaguar($datosproducto[0]['prdid'],$camposfile[13]);
        break;


    default:
        $PrdCnt = $camposfile[16];    
        break;
}

$PrdPrc = $datosproducto[0]['prcsalfab']; 
$PrdPrI = $camposfile[18];
$ImpNto  = $camposfile[20];
$ItmFlg = '';
$ItmCod = '';
$CntBon = 0;
$CntUm2 = 0;
$Um1 = '';
$CntUm1 = 0;
if (strtoupper(substr($datosproducto[0]['prdtxt'],0,4))=='NO E'){
$BPCDObsIt = $datosproducto[0]['prdtxt'].'+'.$camposfile[10].'+'.$camposfile[5];
}else{
    if ($datosproducto[0]['rcnt']>1) {
        $BPCDObsIt = 'Existen mas opciones de productos para este item';
  }else {
  $BPCDObsIt = '';
  }    
}

$datosline[0]=$Item;
$datosline[1]=$PrdId;

$sql =
"
INSERT INTO [GACI35].[Campo].[BPVDET]
([BPVCNroReg],[BPVDItem],[BPVDPrdId],[BPVDPrdNv1],[BPVDPrdNv2],[BPVDPrdNv3],[BPVDPrdNv4],[BPVDPrdNv5],[BPVDPrdCla],[BPVDPrdVtU],[BPVDPrdCnt],[BPVDPrdPrc]
,[BPVDPrdPrI],[BPVDImpNto],[BPVDItmFlg],[BPVDItmCod],[BPVDCntBon],[BPVDCntUm2],[BPVDUm1],[BPVDCntUm1],[BPCDObsIt])
VALUES
(?, ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?)
";

$params=array($nroreg, $Item ,$PrdId ,$rdNv1 ,$PrdNv2 ,$PrdNv3 ,$PrdNv4 ,$PrdNv5 ,$PrdCla,$PrdVtU,$PrdCnt,$PrdPrc,$PrdPrI,$ImpNto,$ItmFlg,$ItmCod,$CntBon,$CntUm2,$Um1,$CntUm1,$BPCDObsIt);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $datosline;

}


public function InsertarSplit($texto,$nroreg,$linea)
{
    
    $camposfile=$this->GetArrayLinea($texto,'3');

$Item = $linea[0];
$PrdId = $linea[1];
$GLNLUG = $camposfile[3];
$PrdCnt = $camposfile[4];
$Fecha = $camposfile[5];

$sql =
"
INSERT INTO [GACI35].[Campo].[BPVSPLIT]
([BPVCNroReg], [BPVDItem],[BPVDPrdId],[BPVSGLNLUG],[BPVSPrdCnt],[BPVSFecha])
     VALUES
(?, ?,  ?,  ?,  ?,  ?)
";
$params=array($nroreg, $Item ,$PrdId ,$GLNLUG ,$PrdCnt,$Fecha);

$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}


public function ModificaCliente($nroreg,$nuevocliente,$user)
{
    try{
        $datoscliente=$this->ObtenerDatosClienteID($nuevocliente);
    } catch (Exception $e){
    throw $e;}


$cliid = $datoscliente[0]['clivtaid'];
$expmca = $datoscliente[0]['cliexp'];
$trmvta = $datoscliente[0]['CliTrmVtaI'];
$lprnro = $datoscliente[0]['cliprcnro'];
$lprfch = $datoscliente[0]['prcfchvig'];
if ($datoscliente[0]['cliexp']=='S'){
$vtatpo = 2; }else {
$vtatpo = 1;    
}
$dpscod = $datoscliente[0]['clidpsaso'];
$vencod = $datoscliente[0]['clivdorid'];
if ($datoscliente[0]['cliexp']=='S'){
$plaexp = "E";}else{
$plaexp = "P";    
}
$lugent = 1;
$clidat = $datoscliente[0]['clinomred'];
$discod = $datoscliente[0]['clidiscod'];
$lugeni = 1;
$clisfi = $datoscliente[0]['Clisitfisr'];


$sql =
"
UPDATE [GACI35].[Campo].[BPVCAB]
SET [BPVCCliId] = ?, [BPVCExpMca]= ?,[BPVCTrmVta]= ?,[BPVCLPrNro]= ?,[BPVCLPrFch]= ?,[BPVCVtaTpo]= ?,[BPVCDpsCod]= ?,[BPVCVenCod]= ?,[BPVCPlaExp]= ?,[BPVCCliDat]= ?,[BPVCDisCod]= ?,[BPVCCliSFi]= ?,[BPVCUserCarga]= ?
WHERE [BPVCNroReg] = ?
";
$params=array($cliid,$expmca,$trmvta,$lprnro,$lprfch,$vtatpo,$dpscod,$vencod,$plaexp,$clidat,$discod,$clisfi,$user,$nroreg);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $nroreg;

    
}

public function ModificaItemPedido($nroreg,$nroitem,$cant,$netolinea,$obs)
{


$sql =
"
Update [GACI35].[Campo].[BPVDET]
Set BPVDPrdCnt = ?, BPVDImpNto = ?, BPCDObsIt = ?    
where BPVCNroReg = ? and BPVDItem = ?
";

$params=array($cant,$netolinea,$obs,$nroreg, $nroitem);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $nroitem;

}


public function ReprocesaLinea($nroreg,$nroitem,$lista,$codigoexterno)
{
    
    $datosproducto = $this->ObtenerDatosProducto($codigoexterno, $lista); 

$Item = $nroitem;
$PrdId = $datosproducto[0]['prdid']; 
$PrdCla = $datosproducto[0]['prdclaid'];
$PrdVtU = $datosproducto[0]['prdidunivt']; 
$PrdPrc = $datosproducto[0]['prcsalfab']; 
$BPCDObsIt = $datosproducto[0]['prdtxtamp'];    

$sql =
"
Update [GACI35].[Campo].[BPVDET]
Set BPVDPrdId = ?, BPVDPrdCla = ?, BPVDPrdVtU = ?, BPVDPrdPrc = ?, BPCDObsIt = ?    
where BPVCNroReg = ? and BPVDItem = ?
";

$params=array($PrdId,$PrdCla,$PrdVtU,$PrdPrc,$BPCDObsIt, $nroreg, $nroitem);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $nroitem;

}

public function ReprocesaLineaMasivo($codigoexterno)
{
    
$sql =
"
select c.bpvcnroreg, d.bpvditem, c.bpvclprnro
from campo.bpvcab c join campo.bpvdet d on c.bpvcnroreg = d.bpvcnroreg
where d.bpvdprdid = ?
";

$params=array($codigoexterno);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

$cant=0;

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)){
$this->ReprocesaLinea($row[0],$row[1],$row[2],$codigoexterno);
$cant++;
}

sqlsrv_close($conexion);

return $cant;

}


public function ReprocesaLineaPedido($nroreg)
{
    
$sql =
"
select c.bpvcnroreg, d.bpvditem, c.bpvclprnro, d.bpvdprdid
from campo.bpvcab c join campo.bpvdet d on c.bpvcnroreg = d.bpvcnroreg
where c.bpvcnroreg = ?
";

$params=array($nroreg);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

$cant=0;

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)){
$this->ReprocesaLinea($row[0],$row[1],$row[2],$row[3]);
$cant++;
}

sqlsrv_close($conexion);

return $cant;

}




//Toma como parámetros la línea de texto leída más el tipo de línea (idtipolinea) para ver la definición de la misma, luego lo muestro por pantalla
public function SepararLinea($linea,$tipolinea)
{

  $defs = $this->ObtenerDefinicion($tipolinea);

    for($i=0;$i<sizeof($defs);$i++)
        {
    
        if ($defs[$i]['anchofijo']==1) {
            echo $i."-".$defs[$i]['descripcion'].": ".strtoupper(substr($linea,$defs[$i]['inicio'],$defs[$i]['tamanio']))."<br/>";
        }else{
                $sep=split($defs[$i]['separador'], $linea);   
                for($i=0;$i<sizeof($sep);$i++)
                {
                echo $i."-".$defs[$i]['descripcion'].": ".$sep[$i]."<br/>";
                }
                break;
        }
    }
     echo "<hr>";
}



//Toma como parámetro el tipo de línea y devuelve una matriz con las división de campos de esa línea
public function ObtenerDefinicion($tipo)
{
    //$sql="SELECT  `orden` ,  `descripcion` ,  (`inicio` -1) as inicio,  (`fin` -1) as fin ,  `tamanio` FROM  `pl_definicioncampos` WHERE tipolinea =$tipo ORDER BY orden";
    $sql=
        "
        SELECT  dc.`orden` ,  dc.`descripcion` ,  (dc.`inicio` -1) as inicio,  (dc.`fin` -1) as fin ,  `tamanio` , tl.anchofijo, tl.separador
        FROM  `pl_definicioncampos` as dc join `pl_tipolineas` as tl on dc.tipolinea = tl.idlinea  
        WHERE dc.tipolinea =$tipo 
        ORDER BY orden
        ";
    $res=mysql_query($sql,conectar::con_mysql());

    while ($reg=mysql_fetch_assoc($res))
    {
        $result[]=$reg;
    }

    return $result;
}

//Toma como parámetro los tres caracteres de la línea del archivo y devuelve el id de esa línea para obtener la definicion de los campos luego
public function ObtieneTipoLinea($tipo)
{
    $sql=" SELECT  `idlinea` FROM  `pl_tipolineas` WHERE descripcion = '$tipo' ;";

    $res=mysql_query($sql,conectar::con_mysql());

    while ($reg = mysql_fetch_array($res))
    {
        $result=$reg[0];
    }

    return $result;
}

public function ObtenerDatosClienteConCategoria($ean,$categoria)
{


    $sql="
 SELECT vta.clivtaid, vta.clinomred, vta.CliTrmVtaI, vta.clidpsaso, vta.Clisitfisr,lug.*, emp.cliprcnro, lpr.prcfchvig , lpr.prcfchalta,vta.cliexp,emp.clivdorid,emp.clidiscod, maz.empmazid
           FROM [Gaci35].[VEN35].[clivta] vta (nolock) left join [Gaci35].[VEN35].[clilug] lug (nolock) on vta.clivtaid = lug.clivtaid
           left join  [Gaci35].[VEN35].[cliemp] emp (nolock) on vta.clivtaid = emp.clivtaid
           left join [Gaci35].[VEN35].[lstpr2] lpr (nolock) on emp.cliprcnro = lpr.prcnro and lpr.prcfchinha = '17530101'
           left join [Gaci35].[adm35].[empmaze] maz (nolock) on vta.clivtaid = maz.empmazempi
           inner join [Gaci35].[ven35].[vengln]  gln (nolock) on vta.clivtaid = gln.glncli
           where gln.glngln = ?
           and lug.clilugitem = (SELECT top 1 glnlug  FROM [Gaci35].[ven35].[vengln]  where glngln = ?)
           and vta.clinrosalp = ?
    ";

    $params =array($ean,$ean, $categoria);
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params, $options);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row_count=sqlsrv_num_rows($stmt);
//    echo "cantidad de lineas:".$row_count."<br>";
    if ($row_count==0){
            throw new Exception('El EAN:'.$ean.' no corresponde a ningun cliente');
   }else{
    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }
return $result;
}
sqlsrv_close($conexion);
}

//Con el parámetro ean busca información de cliente en la base de GACI
public function ObtenerDatosCliente($ean)
{


    $sql="
    SELECT vta.clivtaid, vta.clinomred, vta.CliTrmVtaI, vta.clidpsaso, vta.Clisitfisr,lug.*, emp.cliprcnro, lpr.prcfchvig , lpr.prcfchalta,vta.cliexp,emp.clivdorid,emp.clidiscod, maz.empmazid
           FROM [Gaci35].[VEN35].[clivta] vta (nolock) left join [Gaci35].[VEN35].[clilug] lug (nolock) on vta.clivtaid = lug.clivtaid
           left join  [Gaci35].[VEN35].[cliemp] emp (nolock) on vta.clivtaid = emp.clivtaid
           left join [Gaci35].[VEN35].[lstpr2] lpr (nolock) on emp.cliprcnro = lpr.prcnro and lpr.prcfchinha = '17530101'
           left join [Gaci35].[adm35].[empmaze] maz (nolock) on vta.clivtaid = maz.empmazempi
           where vta.clivtaid in (SELECT top 1 glncli  FROM [Gaci35].[ven35].[vengln]  where glngln = ?)
           and lug.clilugitem = (SELECT top 1 glnlug  FROM [Gaci35].[ven35].[vengln]  where glngln = ?) 
    ";

    $params =array($ean,$ean);
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params, $options);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row_count=sqlsrv_num_rows($stmt);
//    echo "cantidad de lineas:".$row_count."<br>";
    if ($row_count==0){
            throw new Exception('El EAN:'.$ean.' no corresponde a ningun cliente');
   }else{
    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }
return $result;
}
sqlsrv_close($conexion);
}

public function ObtenerDatosClienteLA($eancli, $eanlug)
{



    $sql="
SELECT vta.clivtaid, vta.clinomred, vta.CliTrmVtaI, vta.clidpsaso, vta.Clisitfisr,lug.*, emp.cliprcnro, lpr.prcfchvig , lpr.prcfchalta,vta.cliexp,emp.clivdorid,emp.clidiscod, maz.empmazid
           FROM [Gaci35].[VEN35].[clivta] vta (nolock) left join [Gaci35].[VEN35].[clilug] lug (nolock) on vta.clivtaid = lug.clivtaid
           left join  [Gaci35].[VEN35].[cliemp] emp (nolock) on vta.clivtaid = emp.clivtaid
           left join [Gaci35].[VEN35].[lstpr2] lpr (nolock) on emp.cliprcnro = lpr.prcnro and lpr.prcfchinha = '17530101'
           left join [Gaci35].[adm35].[empmaze] maz (nolock) on vta.clivtaid = maz.empmazempi
            right join (select *    from ven35.vengln
            where glncli = (select glncli
            from ven35.vengln
            where glngln = ? and glnlug=1
            ) and 
            glngln = ? and glnlug <> 1) as dl on vta.clivtaid = dl.glncli and lug.clilugitem = dl.glnlug
    ";

    $params =array($eancli,$eanlug);
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params, $options);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row_count=sqlsrv_num_rows($stmt);
//    echo "cantidad de lineas:".$row_count."<br>";
    if ($row_count==0){
            throw new Exception('El EAN:'.$eancli.' no corresponde a ningun cliente');
   }else{
    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }
return $result;
}
sqlsrv_close($conexion);
}

//Con el parámetro ean busca información de cliente en la base de GACI
public function ObtenerDatosClienteID($id)
{


    $sql="
    SELECT vta.clivtaid, vta.clinomred, vta.CliTrmVtaI, vta.clidpsaso, vta.Clisitfisr,lug.*, emp.cliprcnro, lpr.prcfchvig , lpr.prcfchalta,vta.cliexp,emp.clivdorid,emp.clidiscod, maz.empmazid
           FROM [Gaci35].[VEN35].[clivta] vta (nolock) left join [Gaci35].[VEN35].[clilug] lug (nolock) on vta.clivtaid = lug.clivtaid
           left join  [Gaci35].[VEN35].[cliemp] emp (nolock) on vta.clivtaid = emp.clivtaid
           left join [Gaci35].[VEN35].[lstpr2] lpr (nolock) on emp.cliprcnro = lpr.prcnro and lpr.prcfchinha = '17530101'
           left join [Gaci35].[adm35].[empmaze] maz (nolock) on vta.clivtaid = maz.empmazempi
           where vta.clivtaid = ? 
    ";

    $params =array($id);
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params, $options);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row_count=sqlsrv_num_rows($stmt);
//    echo "cantidad de lineas:".$row_count."<br>";
    if ($row_count==0){
            throw new Exception('El ID:'.$id.' no corresponde a ningun cliente');
   }else{
    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }
return $result;
}
sqlsrv_close($conexion);
}

//Con el parámetro ean busca información de cliente en la base de GACI
public function ObtenerDatosProducto($prod, $lpr)
{

    $sql="
            exec [dbo].[ObtieneInfoProducto] ?,?
    ";

    $params =array($prod, $lpr);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
 //   echo "ID Cliente: ".$row['clivtaid']."<br />";
 //   echo "Nombre: ".$row['clinomred']."<br />";
 //   echo "Termino de Pago: ".$row['CliTrmVtaI']."<br />";
    }
return $result;
sqlsrv_close($conexion);
}


public function Cantidad_Redondeo($prod, $cant)
{

    $sql="
            exec [dbo].[Sel_Producto_Redondeo] ?,?
    ";

    $params =array($prod, $cant);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);
}

public function Cantidad_X_Caja($prod, $cant)
{

    $sql="
            exec  [dbo].[Sel_Producto_X_Caja] ?,?
    ";

    $params =array($prod, $cant);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);
}

public function Cantidad_X_Yaguar($prod, $cant)
{

    $sql="
            exec  [dbo].[Sel_Producto_X_Yaguar] ?,?
    ";

    $params =array($prod, $cant);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);
}




public function GetArrayLinea($linea,$tipolinea)
{
    $defs = $this->ObtenerDefinicion($tipolinea);

//    for($i=0;$i<sizeof($defs);$i++)
//    {
//        $res[$i]= strtoupper(substr($linea,$defs[$i]['inicio'],$defs[$i]['tamanio']));
//        echo "bucle for:".$i."<br>";
//        print_r($res[$i]);
//    }

    for($i=0;$i<sizeof($defs);$i++)
        {
    
        if ($defs[$i]['anchofijo']==1) {
        $res[$i]= strtoupper(substr($linea,$defs[$i]['inicio'],$defs[$i]['tamanio']));
        }else{
                $res=split($defs[$i]['separador'], $linea);   
                break;
        }
    }





    return $res;
}


public function GetUltimoPedido(){

    $sql="
      select isnull(max (bpvcnroreg)+1,1)
      FROM [GACI35].[Campo].[BPVCAB]
      ";

    $params =array();
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}

public function GetUltimoRecadv(){

    $sql="
      select isnull(max (idrecadv)+1,1)
      FROM [GACI35].[Campo].[RecadvCAB]
      ";

    $params =array();
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}


public function ObtenerGLNEmisorRecadv($file)
{
// echo "entro en obtenercabecera con este parametro:".$file."<br>";
$archivo = $this->_ruta."/".$file; //ruta actual

$gestor = @fopen($archivo, "r");
if ($gestor) 
    {
        $bufer = fgets($gestor);
     while (($bufer = fgets($gestor)) !== false) {
            if(substr($bufer,0,3)=='050'){

            $tipoline=$this->ObtieneTipoLinea(strtoupper(substr($bufer,0,3)));
            $campos=$this->GetArrayLinea($bufer,$tipoline);
            }
        }

        return $campos;
    }
         fclose($gestor);   
}



public function ObtenerArrayCabecera($file)
{
// echo "entro en obtenercabecera con este parametro:".$file."<br>";
$archivo = $this->_ruta."/".$file; //ruta actual

$gestor = @fopen($archivo, "r");
if ($gestor) 
    {
        $bufer = fgets($gestor);
 //       echo "entro en if:".$bufer."<br>";
        $campos=$this->GetArrayLinea($bufer,'1');

        return $campos;


    }
         fclose($gestor);   
}


public function ObtenerCategoriaPedido($file)
{
$archivo = $this->_ruta."/".$file; //ruta actual

$gestor = @fopen($archivo, "r");
if ($gestor) 
    {
        $bufer = fgets($gestor);
            while (($bufer = fgets($gestor)) !== false) {

            if(strtoupper(substr($bufer,0,4))=='LINE'){

            $tipoline=$this->ObtieneTipoLinea(strtoupper(substr($bufer,0,4)));
            $campos=$this->GetArrayLinea($bufer,$tipoline);
            break;
            }
        }
        $datosproducto = $this->ObtenerCategoriaProducto($campos[2]); 
        return $datosproducto;
    }
         fclose($gestor);     
}

public function ObtenerCategoriaProducto($prod)
{

    $sql="
            exec [dbo].[ObtieneCategoriaProducto] ?
    ";

    $params =array($prod);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
 //   echo "ID Cliente: ".$row['clivtaid']."<br />";
 //   echo "Nombre: ".$row['clinomred']."<br />";
 //   echo "Termino de Pago: ".$row['CliTrmVtaI']."<br />";
    }
return $result;
sqlsrv_close($conexion);
}

}


class ordersmanager 
{

//atributos
    var $_usuario = "";
//    private $_listafiles=array();



public function __construct($user){

    $this->_usuario = $user;
}


public function subir_a_bandeja($pedido){

    $sql="
        exec [dbo].[INS_Bandeja] ? 
      ";

    $params =array($pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
    
    return $row[0];

sqlsrv_close($conexion);

}

public function subir_a_bandeja_twins($pedido){

    $sql="
        exec [dbo].[INS_Bandeja_Twins] ? 
      ";

    $params =array($pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
    
    return $row[0];

sqlsrv_close($conexion);

}

public function ReemplazaItemPedidoPorCodigo($nroreg,$codigo,$codigonuevo)
{
    
    $lista = $this->ObtenerListaPrecios($nroreg);
    $datosproducto = $this->ObtenerDatosProducto($codigonuevo, $lista); 

//$Item = $nroitem;
$PrdId = $datosproducto[0]['prdid']; 
$PrdCla = $datosproducto[0]['prdclaid'];
$PrdVtU = $datosproducto[0]['prdidunivt']; 
$PrdPrc = $datosproducto[0]['prcsalfab']; 
//$BPCDObsIt = $datosproducto[0]['prdtxtamp'];    

$sql =
"
Update [GACI35].[Campo].[BPVDET]
Set BPVDPrdId = ?, BPVDPrdCla = ?, BPVDPrdVtU = ?, BPVDPrdPrc = ? , BPCDObsIt = '' 
where BPVCNroReg = ? and BPVDPrdId = ?
";

$params=array($PrdId,$PrdCla,$PrdVtU,$PrdPrc, $nroreg, $codigo);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $codigonuevo;

}


public function ObtenerListaPrecios($pedido){

    $sql="
        select BPVCLPrNro 
        from campo.bpvcab (nolock)
        where bpvcnroreg = ?
      ";

    $params =array($pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}



public function cambiar_estado($pedido,$estado_nuevo){

    $sql="
        update campo.bpvcab
        set bpvcestado = ?, bpvcfechacarga = getdate()
        where bpvcnroreg = ?
      ";

    $params =array($estado_nuevo,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}


public function cambiar_fecha_entrega($pedido,$fecha_nueva){

    $sql="
        update campo.bpvcab
        set bpvcentfch = ?
        where bpvcnroreg = ?
      ";

    $params =array($fecha_nueva,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function cambiar_lugar_entrega($pedido,$lugar){

    $sql="
        update campo.bpvcab
        set BPVCLugEnt = ?, BPVCLugEnI = ?
        where bpvcnroreg = ?
      ";

    $params =array($lugar,$lugar,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function cambiar_fecha_oc($pedido,$fecha_nueva){

    $sql="
        update campo.bpvcab
        set BPVCGenFch = ?
        where bpvcnroreg = ?
      ";

    $params =array($fecha_nueva,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function cambiar_observaciones($pedido,$observaciones){

    $sql="
        update campo.bpvcab
        set BPVCObser1 = ?
        where bpvcnroreg = ?
      ";

    $params =array($observaciones,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function cambiar_oc($pedido,$oc){

    $sql="
        update campo.bpvcab
        set BPVCOrdcmp = ?
        where bpvcnroreg = ?
      ";

    $params =array($oc,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function GetUltimoPedido(){

    $sql="
      select isnull(max (bpvcnroreg)+1,1)
      FROM [GACI35].[Campo].[BPVCAB]
      ";

    $params =array();
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}

public function ObtenerDatosCliente($id)
{


    $sql="
    select vta.clivtaid, vta.clinomred, vta.clilimcre, vta.clilimcrep, vta.clitrmvtai, emp.clivdorid, emp.clicanalid, emp.cliprcnro, lpr.prcfchvig, vdor.vdortxt, can.canaltxt, vta.clidpsaso, vta.clisitfisr, vta.cliexp, emp.clidiscod
        from ven35.clivta  vta (nolock)left join ven35.cliemp emp (nolock) on vta.clivtaid = emp.clivtaid and emp.cliemp= 1 and emp.clivdorsuc = 1 
        left join ven35.vdor01 vdor (nolock) on emp.clivdorsuc = vdor.vdorsuc and emp.clivdorid = vdor.vdorid
        left join ven35.canvta can (nolock) on emp.clicanalid = can.canalid 
        join ven35.lstpr2 lpr (nolock) on emp.cliprcnro = lpr.prcnro and lpr.prcfchinha = '17530101'
        where vta.clivtaid = ?
    ";

    $params =array($id);
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params, $options);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    $row_count=sqlsrv_num_rows($stmt);
//    echo "cantidad de lineas:".$row_count."<br>";
    if ($row_count==0){
            throw new Exception('El EAN:'.$ean.' no corresponde a ningun cliente');
   }else{
    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }
return $result;
}
sqlsrv_close($conexion);
}




public function InsertarHead($idcliente, $idlugarentrega, $fechaentrega,$fechavto,$ordcm, $observaciones, $tipopedido, $user)
{

try{
    $datoscliente=$this->ObtenerDatosCliente($idcliente);


$succod = 1;
$fchvto = $fechavto;
$pedser = "A";
$genfch = date('Ymd');
$movtpo = "N";
$cliid = $datoscliente[0]['clivtaid'];
$expmca = $datoscliente[0]['cliexp'];
$trmvta = $datoscliente[0]['clitrmvtai'];
$bongrl = '';
$obser1 = $observaciones; //lo carga en linea 3 del pedido (por trigger se manda a obs general)
$lprsuc = 1;
$lprnro = $datoscliente[0]['cliprcnro'];
$lprfch = $datoscliente[0]['prcfchvig'];
$monid = 1;
if ($datoscliente[0]['cliexp']=='S'){
$vtatpo = 2; }else {
$vtatpo = 1;    
}
$dpsemp = 1;
$dpscod = $datoscliente[0]['clidpsaso'];
$vensuc = 1;
$vencod = $this->_usuario;
$entfch = $fechaentrega;
$totimp = 0;

if ($datoscliente[0]['cliexp']=='S'){
$plaexp = "E";}else{
$plaexp = "P";    
}
$prcfch = $fechaentrega;
$prchor = "";
$lugent = $idlugarentrega;
$errcod = "";
$nrodef = 0;
$flgrpr = "S";
$pedtpo = $tipopedido;
$orinro = 0;
$clidat = $datoscliente[0]['clinomred'];
$discod = $datoscliente[0]['clidiscod'];
$ordcmp = $ordcm;
$pricod = 50;
$intnro = 0;
$boncli = '';
$asgman = "S";
$acomca = "N";
$obsimp = "S";
$leycod = 0;
$obser2 = "";//lo carga en linea 2 del pedido
$obser3 = "Alta PDC";//lo carga en linea 4 del pedido
$obser4 = ""; //NO lo carga en el pedido
$lugeni = 1;
$emptpo = "";
$clisfi = $datoscliente[0]['clisitfisr'];
$aplgen = "";
$mrcpen = "";
$pedaco = 0;
$estado = "N";
$fechacarga = date('Ymd h:i:s');
$archivo = "Carga Online";

  $nroreg = $this->GetUltimoPedido();

$sql =
"
INSERT INTO [GACI35].[Campo].[BPVCAB]
([BPVCNroReg],[BPVCSucCod],[BPVCFchVto],[BPVCPedSer],[BPVCGenFch],[BPVCMovTpo],[BPVCCliId],[BPVCExpMca],[BPVCTrmVta],[BPVCBonGrl],[BPVCObser1]
,[BPVCLPrSuc],[BPVCLPrNro],[BPVCLPrFch],[BPVCMonId],[BPVCVtaTpo],[BPVCDpsEmp],[BPVCDpsCod],[BPVCVenSuc],[BPVCVenCod],[BPVCEntFch],[BPVCTotImp],[BPVCPlaExp]
,[BPVCPrcFch],[BPVCPrcHor],[BPVCLugEnt],[BPVCErrCod],[BPVCNroDef],[BPVCFlgRpr],[BPVCPedTpo],[BPVCOriNro],[BPVCCliDat],[BPVCDisCod],[BPVCOrdCmp],[BPVCPriCod]
,[BPVCIntNro],[BPVCBonCli],[BPVCAsgMan],[BPVCAcoMca],[BPVCObsImp],[BPVCLeyCod],[BPVCObser2],[BPVCObser3],[BPVCObser4],[BPVCLugEnI],[BPVCEmpTpo],[BPVCCliSFi]
,[BPVCAplGen],[BPVCMrcPen],[BPVCPedAco],[BPVCFileName],[BPVCEstado],[BPVCFechaCarga],[BPVCUserCarga])
     VALUES
(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
";
$params=array($nroreg,$succod,$fchvto,$pedser,$genfch,$movtpo,$cliid,$expmca,$trmvta,$bongrl,$obser1,$lprsuc,$lprnro,$lprfch,$monid,$vtatpo,$dpsemp,$dpscod
,$vensuc,$vencod,$entfch,$totimp,$plaexp,$prcfch,$prchor,$lugent,$errcod,$nrodef,$flgrpr,$pedtpo,$orinro,$clidat,$discod,$ordcmp,$pricod,$intnro,$boncli,$asgman
,$acomca,$obsimp,$leycod,$obser2,$obser3,$obser4,$lugeni,$emptpo,$clisfi,$aplgen,$mrcpen,$pedaco,$archivo,$estado,$fechacarga,$user );


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $nroreg;

    
}catch (Exception $e){
    throw $e;
}


}


public function InsertarLine($nroreg,$producto, $lista,$cantidad, $precioinformado, $observacion)
{
    
    $datosproducto = $this->ObtenerDatosProducto($producto, $lista); 
    $tipo = $this->GetTipoPedido($nroreg);

$Item = $this->GetUltimoItem($nroreg);
$PrdId = $datosproducto[0]['prdid']; 
$rdNv1 = '';
$PrdNv2 = '';
$PrdNv3 = '';
$PrdNv4 = '';
$PrdNv5 = '';
$PrdCla = $datosproducto[0]['prdclaid'];
$PrdVtU = $datosproducto[0]['prdidunivt'];

//if (trim($tipo) == 'M'){
//$PrdCnt = 0.01;
//$CntBon = $cantidad;
//} else {
$PrdCnt = $cantidad;
$CntBon = 0;    
//}

$PrdPrc = $datosproducto[0]['prcsalfab']; 
$PrdPrI = $precioinformado;
$ImpNto  = 0;
$ItmFlg = '';
$ItmCod = '';
$CntUm2 = 0;
$Um1 = '';
$CntUm1 = 0;
$BPCDObsIt = $observacion;

$datosline[0]=$Item;
$datosline[1]=$PrdId;

$sql =
"
INSERT INTO [GACI35].[Campo].[BPVDET]
([BPVCNroReg],[BPVDItem],[BPVDPrdId],[BPVDPrdNv1],[BPVDPrdNv2],[BPVDPrdNv3],[BPVDPrdNv4],[BPVDPrdNv5],[BPVDPrdCla],[BPVDPrdVtU],[BPVDPrdCnt],[BPVDPrdPrc]
,[BPVDPrdPrI],[BPVDImpNto],[BPVDItmFlg],[BPVDItmCod],[BPVDCntBon],[BPVDCntUm2],[BPVDUm1],[BPVDCntUm1],[BPCDObsIt])
VALUES
(?, ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?,  ?)
";

$params=array($nroreg, $Item ,$PrdId ,$rdNv1 ,$PrdNv2 ,$PrdNv3 ,$PrdNv4 ,$PrdNv5 ,$PrdCla,$PrdVtU,$PrdCnt,$PrdPrc,$PrdPrI,$ImpNto,$ItmFlg,$ItmCod,$CntBon,$CntUm2,$Um1,$CntUm1,$BPCDObsIt);


$suc=-1;
$conexion = conectar::conecta_sucursal($suc);
$stmt = sqlsrv_query($conexion, $sql, $params);
if( $stmt === false ) {
             die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

return $datosline;

}

public function EliminarLine($pedido,$item,$user){

    $sql="
            update [GACI35].[Campo].[BPVDET] set bpvdhabilitado = 0, bpvdfechabaja = ? , bpvduserbaja = ? where BPVCNroReg = ? and BPVDItem = ?
      ";

    $fechabaja = date('Ymd');

    $params =array($fechabaja,$user,$pedido,$item);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function GetNumeroItem($pedido,$producto){

    $sql="
            select bpvditem
             FROM [GACI35].[Campo].[BPVDET]
            where bpvcnroreg = ?
            and bpvdprdid = ?
      ";

    $params =array($pedido,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}

public function GetUltimoItem($pedido){

    $sql="

            select isnull(max (bpvditem)+1,1)
      FROM [GACI35].[Campo].[BPVDET]
      where bpvcnroreg = ?
      ";

    $params =array($pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}


public function GetTipoPedido($nro){

    $sql="
      select BPVCPedTpo
      FROM [GACI35].[Campo].[BPVCAB]
      where bpvcnroreg = ?
      ";

    $params =array($nro);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

    while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) 
    {
        $result=$row[0];
    }
return $result;
sqlsrv_close($conexion);

}

//Con el parámetro prdid/ean/codmatch busca información de producto en la base de GACI
public function ObtenerDatosProducto($prod, $lpr)
{

    $sql="
            exec [dbo].[ObtieneInfoProducto] ?,?
    ";

    $params =array($prod, $lpr);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
 //   echo "ID Cliente: ".$row['clivtaid']."<br />";
 //   echo "Nombre: ".$row['clinomred']."<br />";
 //   echo "Termino de Pago: ".$row['CliTrmVtaI']."<br />";
    }
return $result;
sqlsrv_close($conexion);
}

public function ObtenerItemsPedidosFacturados($vendedor,$desde)
{

    $sql="
        SELECT  ped.PedCliId as CodCliente,
            ped.PedCliRNom as Cliente,
            ped.PedNroDef as Pedido,
            CONVERT(varchar, ped.PedFch, 103) as FechaPedido,
            CASE ped.PedStatus 
                WHEN 'G' THEN 'G-ASIGNADO'
                WHEN 'R' THEN 'R-RETENIDO'
                WHEN 'T' THEN 'T-TERMINADO'
                WHEN 'A' THEN 'A-AUTORIZADO'
                WHEN 'D' THEN 'D-C/DIFERENCIAS'
                WHEN 'C' THEN 'C-CUMPLIDO'
                WHEN 'B' THEN 'B-BAJA'
                WHEN 'P' THEN 'P-PENDIENTE'
                ELSE ped.PedStatus 
            END AS Status,
    CASE WHEN (Rcab.rtoacp = 'S' AND Rcab.RtoFlgFac = 'N' AND Rcab.RtoStatus <> 'A' AND Rcab.RtoFlgAnul <> 'S' AND Rcab.RtoSucCia = 1) THEN 
        Rcab.RtoTpo + '-' + Rcab.RtoSer + '-' +  RIGHT(('0000' + (CONVERT(varchar(4), Rcab.RtoSuc, 101))), 4) + ' ' + RIGHT(('00000000' + (CONVERT(varchar(8), Rcab.RtoNroDef, 101))), 8)
    ELSE
        cab.FacTpo + '-' + cab.FacSer + '-' +  RIGHT(('0000' + (CONVERT(varchar(4), cab.FacSuc, 101))), 4) + ' ' + RIGHT(('00000000' + (CONVERT(varchar(8), cab.FacNroDef, 101))), 8) 
    END as Comprobante,
    CASE WHEN cab.FacFch is null THEN
        CONVERT(varchar, Rcab.RtoFch, 103) 
    ELSE
        CONVERT(varchar, cab.FacFch, 103) 
    END AS FechaCbte,
            Ped.PedOrdCmp as OC,
            isnull(bcab.bpvcnroreg,0) as NroPDC,
            isnull(bcab.bpvcestado,'-') as EstadoPDC,
        CASE WHEN (Rcab.rtoacp = 'S' AND Rcab.RtoFlgFac = 'N' AND Rcab.RtoStatus <> 'A' AND Rcab.RtoFlgAnul <> 'S' AND Rcab.RtoSucCia = 1) THEN 
        Rcab.RtoTpo + '-' + Rcab.RtoSer + '-' +  RIGHT(((CONVERT(varchar(2), Rcab.RtoSuc, 101))), 4) + '-' + RIGHT(((CONVERT(varchar(8), Rcab.RtoNroDef, 101))), 8)
    ELSE
        cab.FacTpo + '-' + cab.FacSer + '-' +  RIGHT(((CONVERT(varchar(2), cab.FacSuc, 101))), 4) + '-' + RIGHT(((CONVERT(varchar(8), cab.FacNroDef, 101))), 8) 
    END as ComprobantePDF
        from ven35.pedvta Ped (nolock) 
            LEFT OUTER JOIN ven35.FACCAB AS cab (NOLOCK) ON cab.facfch >= ped.pedfch and cab.FacSer = Ped.PedSer AND Cab.FacPed = Ped.PedNroDef
            LEFT OUTER JOIN ven35.CliEmp as E (nolock) ON (ped.PedCliId = E.CliVtaId and E.Cliemp = 1) and ped.PedVdorSuc = e.CliVdorSuc  and ped.PedVdorId = e.CliVdorId
            LEFT OUTER JOIN ven35.RTOCAB AS Rcab (NOLOCK) ON rcab.rtofch >= ped.pedfch and Rcab.RtoSer = Ped.PedSer AND RCab.Rtoped = Ped.PedNroDef 
            left outer join campo.bpvcab as bcab (nolock) on bcab.bpvcnrodef = ped.pednrodef
        where ped.PedFch >=  ?
        and Ped.PedVdorId = ?
        and Ped.PedSuc = 1
        AND Ped.PedNroDef <> 0
        AND ped.PedStatus <> 'B'
    ";


    $params =array($desde, $vendedor);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

$cant=0;
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
        $cant++;
    }

if ($cant>0)
    {return $result;
    }else
    {return 0;
    }
sqlsrv_close($conexion);

}

public function CabeceraPedidoVsFacturado($vendedor,$pedido, $fechapedido)
{

    $sql="
        SELECT  ped.PedCliId as CodCliente,
            ped.PedCliRNom as Cliente,
            ped.PedNroDef as Pedido,
            CONVERT(varchar, ped.PedFch, 103) as FechaPedido,
            CASE ped.PedStatus 
                WHEN 'G' THEN 'G-ASIGNADO'
                WHEN 'R' THEN 'R-RETENIDO'
                WHEN 'T' THEN 'T-TERMINADO'
                WHEN 'A' THEN 'A-AUTORIZADO'
                WHEN 'D' THEN 'D-C/DIFERENCIAS'
                WHEN 'C' THEN 'C-CUMPLIDO'
                WHEN 'B' THEN 'B-BAJA'
                WHEN 'P' THEN 'P-PENDIENTE'
                ELSE ped.PedStatus 
            END AS Status,
    CASE WHEN (Rcab.rtoacp = 'S' AND Rcab.RtoFlgFac = 'N' AND Rcab.RtoStatus <> 'A' AND Rcab.RtoFlgAnul <> 'S' AND Rcab.RtoSucCia = 1) THEN 
        Rcab.RtoTpo + '-' + Rcab.RtoSer + '-' +  RIGHT(('0000' + (CONVERT(varchar(4), Rcab.RtoSuc, 101))), 4) + ' ' + RIGHT(('00000000' + (CONVERT(varchar(8), Rcab.RtoNroDef, 101))), 8)
    ELSE
        cab.FacTpo + '-' + cab.FacSer + '-' +  RIGHT(('0000' + (CONVERT(varchar(4), cab.FacSuc, 101))), 4) + ' ' + RIGHT(('00000000' + (CONVERT(varchar(8), cab.FacNroDef, 101))), 8) 
    END as Comprobante,
    CASE WHEN cab.FacFch is null THEN
        CONVERT(varchar, Rcab.RtoFch, 103) 
    ELSE
        CONVERT(varchar, cab.FacFch, 103) 
    END AS FechaCbte,
            isnull(Ped.PedOrdCmp,'-') as OC,
            isnull(bcab.bpvcnroreg,0) as NroPDC,
            isnull(bcab.bpvcestado,'-') as EstadoPDC
        from ven35.pedvta Ped (nolock) 
            LEFT OUTER JOIN ven35.FACCAB AS cab (NOLOCK) ON cab.facfch >= ped.pedfch and cab.FacSer = Ped.PedSer AND Cab.FacPed = Ped.PedNroDef
            LEFT OUTER JOIN ven35.CliEmp as E (nolock) ON (ped.PedCliId = E.CliVtaId and E.Cliemp = 1) and ped.PedVdorSuc = e.CliVdorSuc  and ped.PedVdorId = e.CliVdorId
            LEFT OUTER JOIN ven35.RTOCAB AS Rcab (NOLOCK) ON rcab.rtofch >= ped.pedfch and Rcab.RtoSer = Ped.PedSer AND RCab.Rtoped = Ped.PedNroDef 
            left outer join campo.bpvcab as bcab (nolock) on bcab.bpvcnrodef = ped.pednrodef
        where ped.PedFch =  ?
        and Ped.PedVdorId = ?
        and Ped.PedSuc = 1
        AND Ped.PedNroDef = ?
        AND ped.PedStatus <> 'B'
    ";


    $params =array($fechapedido, $vendedor,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

$cant=0;
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
        $cant++;
    }

if ($cant>0)
    {return $result;
    }else
    {return 0;
    }
sqlsrv_close($conexion);

}





public function DetallePedidoVsFacturado($vendedor,$pedido, $fechapedido)
{

    $sql="


SELECT  ltrim(rtrim(det.PedPrdId)) as Codigo, 
    p.PrdTxt as Producto,
    CASE WHEN ((Det.PedPrdVtaU ='UN') ) THEN 
        round((Det.PedPrdCnt * isnull(uni.PrdFtrCvs,1)),2)
    ELSE
        round(Det.PedPrdCnt,2)
    END as CantPed,
    CASE WHEN ((Det.PedPrdVtaU ='UN') ) THEN 
        round((Det.PedPrdCntB * isnull(uni.PrdFtrCvs,1)),2)
    ELSE
        round(Det.PedPrdCntB,2)
    END as CantBonif,
    CASE WHEN (Fdet.FacPrdVtaU is null) THEN
        CASE WHEN ((RDet.RtoPrdVtaU ='UN') ) THEN 
            round((isnull(RDet.RtoPrdCnt,0) * isnull(uni.PrdFtrCvs,1)),2)
        ELSE
            round(isnull(RDet.RtoPrdCnt,0),2)
        END 
    ELSE
        CASE WHEN ((FDet.FacPrdVtaU ='UN') ) THEN 
            round((isnull(FDet.FacPrdCnt,0) * isnull(uni.PrdFtrCvs,1)),2)
        ELSE
            round(isnull(FDet.FacPrdCnt,0),2)
        END 
    END as CantFact,
    'KG' as UM,
    CASE WHEN ped.PedSer in ('A', 'E') 
    THEN
            isnull((round(Fdet.FacImpPrdR,2)) /  
            nullif((CASE WHEN (Fdet.FacPrdVtaU is null) THEN
                CASE WHEN ((RDet.RtoPrdVtaU ='UN') ) THEN 
                    round((isnull(RDet.RtoPrdCnt,0) * isnull(uni.PrdFtrCvs,1)),2)
                ELSE
                    round(isnull(RDet.RtoPrdCnt,0),2)
                END 
            ELSE
                CASE WHEN ((FDet.FacPrdVtaU ='UN') ) THEN 
                    round((isnull(FDet.FacPrdCnt,0) * isnull(uni.PrdFtrCvs,1)),2)
                ELSE
                    round(isnull(FDet.FacPrdCnt,0),2)
                END 
            END),0),0)
    ELSE 
            isnull(round(((round(Fdet.FacImpPrdR,2)) /  
            nullif((CASE WHEN (Fdet.FacPrdVtaU is null) THEN
                CASE WHEN ((RDet.RtoPrdVtaU ='UN') ) THEN 
                    round((isnull(RDet.RtoPrdCnt,0) * isnull(uni.PrdFtrCvs,1)),2)
                ELSE
                    round(isnull(RDet.RtoPrdCnt,0),2)
                END 
            ELSE
                CASE WHEN ((FDet.FacPrdVtaU ='UN') ) THEN 
                    round((isnull(FDet.FacPrdCnt,0) * isnull(uni.PrdFtrCvs,1)),2)
                ELSE
                    round(isnull(FDet.FacPrdCnt,0),2)
                END 
            END),0) / 1.21),2),0)
    END as PrecioUnitario,
    isnull(FacIvaRedI,0) as IVA,
    round(isnull(Fdet.FacImpPrdR,0),2)  as Total,
    Bdet.bpvdprdcnt as CantPedPDC,
    Bdet.bpvcnroreg as NroPDC
from ven35.pedvta Ped (nolock) 
    INNER JOIN ven35.pedvt1 Det (nolock) ON ped.PedSuc = det.PedSuc AND ped.PedNro = det.PedNro
    INNER JOIN ven35.prd P (nolock) ON Det.PedPrdId = P.prdid
    INNER JOIN ven35.VDOR01 AS ven (NOLOCK) ON ped.PedVdorSuc = ven.VdorSuc AND ped.PedVdorId = ven.VdorId 
    LEFT OUTER JOIN ven35.FACDET AS FDet (NOLOCK) ON Fdet.FacPedSuc = ped.PedSuc AND Fdet.FacPedNro = ped.PedNro AND Fdet.FacPedNroD = ped.PedNroDef and fdet.FacPrdId = Det.PedPrdId  
    LEFT OUTER JOIN ven35.FACCAB AS cab (NOLOCK) ON cab.FacTpo = FDet.FacTpo AND cab.FacSer = FDet.FacSer AND cab.FacSuc = FDet.FacSuc AND Cab.FacNro = FDet.FacNro
    LEFT OUTER JOIN ven35.CliEmp as E (nolock) ON (ped.PedCliId = E.CliVtaId and E.Cliemp = 1) and ped.PedVdorSuc = e.CliVdorSuc  and ped.PedVdorId = e.CliVdorId
    LEFT OUTER JOIN ven35.CANVTA AS Can (nolock) ON (can.CanalId = E.CliCanalId and E.Cliemp = 1) 
    LEFT OUTER JOIN ven35.RTODET AS RDet (NOLOCK) ON Rdet.RtoPedSuc = ped.PedSuc AND Rdet.RtoPedNro = ped.PedNro AND Rdet.RtoPedNroD = ped.PedNroDef and Rdet.RtoPrdId = Det.PedPrdId
    LEFT OUTER JOIN ven35.RTOCAB AS Rcab (NOLOCK) ON Rcab.RtoTpo = RDet.RtoTpo AND Rcab.RtoSer = RDet.RtoSer AND Rcab.RtoSuc = RDet.RtoSuc AND RCab.RtoNro = RDet.RtoNro 
    LEFT OUTER JOIN STK35.PRDTOL as uns (nolock) ON  (Det.PedPrdId = uns.prdid and uns.PrdTolUnd <> Det.PedPrdVtaU)
    LEFT OUTER JOIN STK35.PRDUND as uni (nolock) ON  (Det.PedPrdId = uni.prdid and uns.PrdTolUnd = uni.prdidund)
    left outer join campo.bpvcab as bcab (nolock) on bcab.bpvcnrodef = ped.pednrodef
    left outer join campo.bpvdet as bdet (nolock) on bcab.bpvcnroreg = bdet.bpvcnroreg and  bdet.bpvdprdid = Det.PedPrdId and bdet.bpvdhabilitado = 1
where ped.PedFch =  ?
and Ped.PedVdorId = ?
and Ped.PedSuc = 1
AND Ped.PedNroDef =?
AND ped.PedStatus <> 'B'
order by 1, 5


    ";


    $params =array($fechapedido, $vendedor,$pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

$cant=0;
 while ($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $result[]=$row;
    }

return $result;
sqlsrv_close($conexion);

}



public function recuperar_pedido_bandeja($pedido){

    $sql="
        exec [dbo].[recuperapedido]  ?
      ";

    $params =array($pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}  



public function recuperar_pedido_bandeja_twins($pedido){

    $sql="
        exec [dbo].[recuperapedidoTWINS]  ?
      ";

    $params =array($pedido);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}  

}

class productmanager 
{

//atributos
    var $_usuario = "";
//    private $_listafiles=array();



public function __construct($user){

    $this->_usuario = $user;
}


public function cambiar_vidautil($producto,$vu){

    $sql="
        update campo.pesosprd
        set vidautil = ?
        where prdid = ?
      ";

    $params =array($vu,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function cambiar_pesoxunidad($producto,$peso){

    $sql="
        update campo.pesosprd
        set pesoxun = ? 
        where prdid = ?
      ";

    $params =array($peso,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}


public function cambiar_unixcaja($producto,$unixcaja){

    $sql="
        update campo.pesosprd
        set unxcaja = ?
        where prdid = ?
      ";

    $params =array($unixcaja,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}


public function cambiar_pesoxcaja($producto,$pesoxcaja){

    $sql="
        update campo.pesosprd
        set pesoxcaja = ?
        where prdid = ?
      ";

    $params =array($pesoxcaja,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}


public function cambiar_redondeo($producto,$redondeo){

    $sql="
        update campo.pesosprd
        set redondeo = ?
        where prdid = ?
      ";

    $params =array($redondeo,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}



public function cambiar_habilitacion($producto,$habilitacion){

    $sql="
        update campo.pesosprd
        set habilitado = ?
        where prdid = ?
      ";

    $params =array($habilitacion,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}


public function cambiar_informacion_producto($producto,$vu,$pxu,$uxc,$pxc,$redo,$hab){

    $sql="
        update campo.pesosprd
        set vidautil = ?,  pesoxun = ? , unxcaja = ?,  pesoxcaja = ?, redondeo = ?, habilitado = ?
        where prdid = ?
      ";

    $params =array($vu,$pxu,$uxc,$pxc,$redo,$hab,$producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}

sqlsrv_close($conexion);

}

public function agregar_producto($producto){

    $sql="
insert into campo.pesosprd 
select prdid, prdidunivt,0,0,0,0,0 ,cast (prddiasvto as char(3)) + ' días' ,1 as Habilitado
from ven35.prd
where prdmrcfact = 'S'
and prdid = ?
      ";

    $params =array($producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 $result = 0;
               }else{
                $result = $producto;
               }

return $result;
sqlsrv_close($conexion);

}

public function chequea_producto($producto){

    $sql="
      select prdid, prdtxt, prdtxtamp, prdidunivt, prdclaid, prddiasvto 
      from ven35.prd
      where prdmrcfact = 'S'
      and prdid = ?
      ";

    $params =array($producto);
    $suc=-1;
    $conexion = conectar::conecta_sucursal($suc);
    $stmt = sqlsrv_query($conexion, $sql, $params);
    if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));}


    if (!sqlsrv_has_rows($stmt)){
            $result='Error+El Codigo: '.$producto.' no corresponde a ningun producto facturable.';
   }else{
        while ($fila=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC))
        {
        $result= $fila[0]."+".$fila[1]."+".$fila[2]."+".$fila[3]."+".$fila[4]."+".$fila[5];
        }
}

return $result;

sqlsrv_close($conexion);




}

}

?>
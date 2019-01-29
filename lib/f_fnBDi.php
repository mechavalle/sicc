<?php 
#ver 10.1 27FEB2016
#270216 no 'user' field in function loguea (insert section)
#090216 add hits function


#ver 10.1 26MAY2016
#09022016 add hits function
#26052016 espasado function

#ver 11  08ENE2017
#compatible php5


function Existe($BD,$CampoBD,$Dato) 
{ 
global $conexio;
$con = "SELECT * FROM `$BD` WHERE `$CampoBD`='$Dato'";
#echo $con;
$resu = mysqli_query($conexio,$con) or die(mysqli_error());

if($valo=mysqli_fetch_array($resu))  {
	return "SE";
	} 
else {
   	return "NE"; 
	} 
mysqli_free_result($resu);
}


function Existe2($BD,$Sentencia) 
{ 
global $conexio;
$con = "SELECT count(*) as c FROM `$BD` WHERE $Sentencia";
$resu = mysqli_query($conexio,$con);

if($valo=mysqli_fetch_array($resu))
	{
	if($valo['c']>0)
		return "SE";
	else
		return "NE";
	} 
else {
   	return "NE"; 
	} 
mysqli_free_result($resu);
}


function NextID($BD,$CampoID) 
{ 
global $conexio;
$con = "SELECT MAX(  `$CampoID`  ) FROM `$BD`";
$resu = mysqli_query($conexio,$con) or die(mysqli_error());

if($valo=mysqli_fetch_array($resu))  {
	$Back=$valo[0]+1;
	} 
else {
   	$Back="0";
	} 
mysqli_free_result($resu);
return $Back;

}

function nextid2($BD1,$CampoID1,$BD2,$CampoID2)
{ 

if(NextID($BD1,$CampoID1)>NextID($BD2,$CampoID2))
	return NextID($BD1,$CampoID1);
else
	return NextID($BD2,$CampoID2);
}

function nextcustom($BD,$CampoNext,$Campo,$Valor) 
{ 
global $conexio;
$con = "SELECT MAX(  `$CampoNext`  ) FROM `$BD` WHERE `$Campo`='$Valor'";
$resu = mysqli_query($conexio,$con) or die(mysqli_error());

if($valo=mysqli_fetch_array($resu))  {
	$Back=$valo[0]+1;
	} 
else {
   	$Back="0";
	} 
mysqli_free_result($resu);
return $Back;

}

function llevadato($BD,$CampoID,$ValorID,$NumID,$Campo,$Valor,$Num)
{
global $conexio;
if($NumID=="S")
	if($Num=="S")		
		$csql = "UPDATE `$BD` SET `$Campo` = $Valor WHERE `$CampoID` = $ValorID;";
		
	else
		$csql = "UPDATE `$BD` SET `$Campo` = '$Valor' WHERE `$CampoID` = $ValorID;";	
else
	if($Num=="S")	
		$csql = "UPDATE `$BD` SET `$Campo` = $Valor WHERE `$CampoID` = '$ValorID';";
	else
		$csql = "UPDATE `$BD` SET `$Campo` = '$Valor' WHERE `$CampoID` = '$ValorID';";
	
#echo $csql;
mysqli_query($conexio,$csql);

if(mysqli_error()=="")
	return "OK";
else
	return mysqli_error();

}



function traedato($BD,$CampoID,$ValorID,$NumID,$Campo)
{
global $conexio;
if($NumID=="S")		
	$csql = "SELECT `$Campo` from `$BD` WHERE `$CampoID` = $ValorID;";		
else
	$csql = "SELECT `$Campo` from `$BD` WHERE `$CampoID` = '$ValorID';";

#echo $csql;	
$res2 = mysqli_query($conexio,$csql);
	
if($val5=mysqli_fetch_array($res2))
	$Back=$val5[0];		
else 
	$Back="-1";

mysqli_free_result($res2);

if($Back=="")
	$Back="-1";

return $Back;

}


function traedato2($Sentencia,$Campo)
{
global $conexio;
#echo $Sentencia;
$res2 = mysqli_query($conexio,$Sentencia);
	
if($valn=mysqli_fetch_array($res2))
	$Back=$valn[$Campo];		
else 
	$Back="-1";

mysqli_free_result($res2);

if($Back=="")
	$Back="-1";


return $Back;

}


function cuenta($BD,$Campo,$Filtro)
{
global $conexio;
$csql = "SELECT COUNT(`$Campo`) from `$BD`";

#echo $csql;
if($Filtro!="") {
	$csql=$csql." WHERE $Filtro;"; }
else {
	$csql=$csql.";"; }

$res2 = mysqli_query($conexio,$csql);
	
if($valn=mysqli_fetch_array($res2))
	$Back=$valn[0];		
else 
	$Back="0";

mysqli_free_result($res2);


return $Back;

}

function cuenta2($sentencia)
{
global $conexio;
#echo $sentencia;
#exit();

$res2 = mysqli_query($conexio,$sentencia);
	
if($valn=mysqli_fetch_array($res2))
	$Back=$valn[0];		
else 
	$Back="0";

mysqli_free_result($res2);

settype($Back,"double");
return $Back;

}


function suma($BD,$Campo,$Filtro)
{
global $conexio;
$csql = "SELECT IFNULL(SUM(`$Campo`),0) from `$BD`";


if($Filtro!="") {
	$csql=$csql." WHERE $Filtro;"; }
else {
	$csql=$csql.";"; }
#echo $csql;
$res2 = mysqli_query($conexio,$csql);
	
if($valn=mysqli_fetch_array($res2))
	$Back=$valn[0];		
else 
	$Back="0";

mysqli_free_result($res2);

return $Back;

}


function maximo($BD,$Campo,$Filtro)
{
global $conexio;
$csql = "SELECT MAX(`$Campo`) from `$BD`";


if($Filtro!="") {
	$csql=$csql." WHERE $Filtro;"; }
else {
	$csql=$csql.";"; }

$res2 = mysqli_query($conexio,$csql);
	
if($valn=mysqli_fetch_array($res2))
	$Back=$valn[0];		
else 
	$Back="-1";

mysqli_free_result($res2);

return $Back;

}

function subearchivo($campoarchivo,$archivo)
{

if (strlen($archivo)==0)
	return "No se especifico el archivo";

if (move_uploaded_file($_FILES[$campoarchivo]['tmp_name'], $archivo))
	return "OK";
else 
	return "ERROR";
}


function borra($BD,$id,$CampoID)
{
global $conexio;
$csql = "DELETE FROM `$BD` WHERE `$CampoID`='$id'";
mysqli_query($conexio,$csql);
if(mysqli_error()!="")
	return "ERROR: "."Error al grabar el registro. ".mysqli_error()."-> $csql";
else
	return "OK";

}


function fixfecha($fecha1)
	{

	$lenfecha=strlen($fecha1);
	if($lenfecha<=0)
		return $fecha1;
	
	if(strpos($fecha1,"/"))
		return $fecha1;	

	$esfecha=strtotime($fecha1);
        if ($esfecha=="-1" || $esfecha=="" || $esfecha==" ")
                {
                #echo "too bad";
                return $fecha1;
                }
        else{

	
	if($lenfecha>0)
		{
		if($lenfecha>10)
			{
			$fechaa=substr($fecha1,0,10);
			$fechab=substr($fecha1,($lenfecha-10)*-1);
			$fechan=strftime("%d/%b/%Y", mktime(0, 0, 0, substr($fechaa,5,2), substr($fechaa,-2), substr($fechaa,0,4)));
			return $fechan." ".$fechab;
			}
		else{
			if($fecha1=="0000-00-00")
				return "-";
			else
				return strftime("%d/%b/%Y", mktime(0, 0, 0, substr($fecha1,5,2), substr($fecha1,-2), substr($fecha1,0,4)));
			
			}
		}
	else
		return "-";		
	
	}
}


function fixfecha2($fecha1)
	{

	$lenfecha=strlen($fecha1);
	if($lenfecha<=0)
		return $fecha1;
	
	if(strpos($fecha1,"/"))
		return $fecha1;	

	$esfecha=strtotime($fecha1);
        if ($esfecha=="-1" || $esfecha=="" || $esfecha==" ")
                {
                #echo "too bad";
                return $fecha1;
                }
        else{

	
	if($lenfecha>0)
		{
		if($lenfecha>10)
			{
			$fechaa=substr($fecha1,0,10);
			$fechab=substr($fecha1,($lenfecha-10)*-1);
			$fechan=strftime("%A %d de %B de %Y", mktime(0, 0, 0, substr($fechaa,5,2), substr($fechaa,-2), substr($fechaa,0,4)));
			return $fechan." ".$fechab;
			}
		else{
			if($fecha1=="0000-00-00")
				return "-";
			else
				return strftime("%A %d de %B de %Y", mktime(0, 0, 0, substr($fecha1,5,2), substr($fecha1,-2), substr($fecha1,0,4)));
			
			}
		}
	else
		return "-";		
	
	}
}

function fixfechaSF($fecha1)
{
	if($fecha1=="0000-00-00")
		return "";
	else
		return $fecha1;
}

function fixmonto($monto)
{
if(is_numeric($monto))
	return "$".number_format($monto,'2','.',',');
	#return sprintf("$%01.2f", $monto);
else
	return $monto;
#return money_format('%(#2n', $monto);
}

function fixmontosin($monto)
{
if(is_numeric($monto))
	return number_format($monto,'2');
	#return sprintf("$ %01.2f", $monto);
else
	return $monto;
#return money_format('%(#2n', $monto);
}

function fixmontodec($monto)
{
if(is_numeric($monto))
	return "$ ".number_format($monto);	
else
	return $monto;
}

function fixporcentaje($monto)
{
if(is_numeric($monto))
	return $monto."%";
else
	return $monto;
}

function extension($archivo)
{
$pos=strlen($archivo)-strrpos($archivo,".")-1;
return substr($archivo,-1*$pos);
}



function pasado($fecha)
	{
	if(substr($fecha,6,1)=="-")
		$mes=substr($fecha,5,1);
	else
		$mes=substr($fecha,5,2);

	if(substr(substr($fecha,-2),0,1)=="-")
		$dia=substr($fecha,-1);
	else
		$dia=substr($fecha,-2);

	if(mktime(0, 0, 0, $mes, $dia, substr($fecha,0,4))<mktime(0, 0, 0, date("m"), date("d"), date("Y")))
		return 1;
	else
		return 0;
	} 


function espasado($referencia,$fecha)
	{
	$mes=substr($referencia,5,2);
	$dia=substr($referencia,8,2);
	$anio=substr($referencia,0,4);
	$hora=substr($referencia,11,2);
	$min=substr($referencia,14,2);
	$sec=substr($referencia,17,2);
	settype($mes,"integer");
	settype($dia,"integer");
	settype($anio,"integer");
	settype($hora,"integer");
	settype($min,"integer");
	settype($sec,"integer");

	$ref=mktime($hora,$min,$sec,$mes,$dia,$anio);

	$mes=substr($fecha,5,2);
	$dia=substr($fecha,8,2);
	$anio=substr($fecha,0,4);
	$hora=substr($fecha,11,2);
	$min=substr($fecha,14,2);
	$sec=substr($fecha,17,2);
	settype($mes,"integer");
	settype($dia,"integer");
	settype($anio,"integer");
	settype($hora,"integer");
	settype($min,"integer");
	settype($sec,"integer");

	$fec=mktime($hora,$min,$sec,$mes,$dia,$anio);
	
	if($fec<$ref)
		return 1;
	else
		return 0;

	}


function dias($inicio,$fin)
{
$int_nodias = floor(abs(strtotime($inicio) - strtotime($fin))/86400);
return $int_nodias;
}

function anios($inicio,$fin)
{
$inicio=substr($inicio,0,4);
settype($inicio,"int");
$fin=substr($fin,0,4);
settype($fin,"int");

$int_anios = abs($inicio-$fin);
return $int_anios;
}

function calcular_edad($fecha){
$dias = explode("-", $fecha,3);
$dias = mktime(0,0,0,$dias[1],$dias[2],$dias[0]);
$edad = (int)((time()-$dias)/31556926 );
return $edad;
}

function chkempty($texto)
{
if($texto=="")
	return "(ninguno)";
if($texto=="-1")
	return "";
return $texto;
}


function recorta($texto,$max)
{
if(strlen($texto)>$max)
	return substr($texto,0,$max)."...";
else
	return $texto;
}

function diafecha($dia,$inicio,$fin) 
	{ 


	$dias=substr($inicio,-2);
	settype($dias,"integer");
	$fecha=strftime("%Y-%m-%d", mktime(0, 0, 0, substr($inicio,5,2), substr($inicio,-2), substr($inicio,0,4)));
	$fechafin=strftime("%Y-%m-%d", mktime(0, 0, 0, substr($fin,5,2), substr($fin,-2), substr($fin,0,4)));
#echo jddayofweek ( cal_to_jd(CAL_GREGORIAN, substr($fecha,5,2),substr($fecha,-2), substr($fecha,0,4)) , 1 );
#exit();

	while($fecha!=$fechafin)
		{
		if($dia==jddayofweek ( cal_to_jd(CAL_GREGORIAN, substr($fecha,5,2),substr($fecha,-2), substr($fecha,0,4)) , 0 ))
			return $fecha;			
		else
			$fecha=strftime("%Y-%m-%d", mktime(0, 0, 0, substr($inicio,5,2), $dias+1, substr($inicio,0,4)));
		$dias +=1;
		}
	if($dia==jddayofweek ( cal_to_jd(CAL_GREGORIAN, substr($fecha,5,2),substr($fecha,-2), substr($fecha,0,4)) , 0 ))
		return $fecha;			
	else
		return "none";
	}

function completa($texto,$caracter,$tam,$izq)
	{
	if(strlen($texto)>=$tam)
		return $texto;
	else
		{
		if($izq=="S")
			return str_repeat($caracter,$tam-strlen($texto)).$texto;
		else
			return $texto.str_repeat($caracter,$tam-strlen($texto));
		}

	}


function fecha_sp($fechaa)
	{
	$FechaStamp=mktime(0, 0, 0, substr($fechaa,5,2), substr($fechaa,-2), substr($fechaa,0,4));
	$ano = date('Y',$FechaStamp);
	$mes = date('n',$FechaStamp);
	$dia = date('d',$FechaStamp);
	$diasemana = date('w',$FechaStamp);

 
	$diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
	"Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
	"Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
	}

function fecha_semi($fechaa)
	{
	if(strlen($fechaa)>10)
		{
		$resto=substr($fechaa,10,strlen($fechaa));
		$fechaa=substr($fechaa,0,10);
		}
	else
		{
		if(strlen($fechaa)<10)
			return $fechaa;
		else
			$resto="";
		}
		
	$dia=substr($fechaa,8,2);
	settype($dia,"integer");
	$mes=substr($fechaa,5,2);
	settype($mes,"integer");
	$anio=substr($fechaa,0,4);	
	$contrato="$dia de ".mes($mes)." de $anio";
	return $contrato." ".$resto;
	}

function permiso_old($modulo,$idusuario)
	{
	global $conexio;
	$csql = "select a.tipo, b.status from adm_permisos a left join adm_modulos as b on a.modulo=b.modulo where a.modulo='$modulo' and a.idusuario='$idusuario';";		
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		{
		if($val5[1]==0)
			$Back=-10;
		else
			$Back=$val5[0];
		}
	else 
		$Back=-1;
	mysqli_free_result($res2);
	return $Back;
	}
function permiso($modulo,$idusuario)
	{
	global $conexio;
	if(isset($_SESSION['dias']))
		$licdias=$_SESSION['dias'];
	else
		$licdias=0;
	if($licdias<0)
		return -1;
	if($idusuario==1)
		return 5;
	$csql = "select tipo from adm_permisos where modulo='$modulo' and idusuario='$idusuario';";		
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		$Back=$val5[0];
	else 
		$Back=-1;
	mysqli_free_result($res2);
	return $Back;
	}

function fixrutaimg($idmodulo)
	{
	$imgruta=traedato("adm_scanner","idmodulo",$idmodulo,"S","directorio");
	if($imgruta!="-1")
		{
		$imgruta ="../".$imgruta."/";
		$imgruta=str_replace ("\\","/",$imgruta);
		}
	else
		$imgruta="";
	return $imgruta;
	}
	
function iconoapp_old($archivo)
	{
	if($archivo=="")
		$imgicono="";
	else
		{
		if(strtoupper(substr($archivo,-3))=="PDF")
			$imgicono="pdf.gif";
		if(strtoupper(substr($archivo,-3))=="DOC" || strtoupper(substr($archivo,-3))=="DOCX")
			$imgicono="doc.gif";
		if(strtoupper(substr($archivo,-3))=="XLS" || strtoupper(substr($archivo,-3))=="XLSX")
			$imgicono="xls.gif";
		}
	return $imgicono;
	}

function iconoapp($archivo)
	{
	if($archivo=="")
		$imgicono="";
	else
		{
		if(file_exists("../img/".strtolower(extension($archivo)).".gif"))
			$imgicono="../img/".strtolower(extension($archivo)).".gif";		
		else
			$imgicono="../img/icndefault.gif";
		}
	return $imgicono;
	}
	
function mes($num)
	{
	$mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return $mesesN[$num];
	}

function debugea($rollo)
{
global $conexio;
$rollo= str_replace("'","\'",$rollo);
$csql = "INSERT INTO `adm_debugger` (`rollo`,`fecha` ) VALUES ('$rollo',NOW());";
#echo $csql;
mysqli_query($conexio,$csql);

if(mysqli_error()=="")
	return "OK";
else
	return mysqli_error();

}

function tamanio($archivo,$x,$y)
	{
	
	list($x1, $y1) = getimagesize($archivo);
	$proporcion=(100*$y1)/$x1;
	
	$nx=$x;
	$ny=($proporcion*$nx)/100;
	if($ny>$y)
		{
		$proporcion=(100*$x1)/$y1;
		$ny=$y;
		$nx=($proporcion*$ny)/100;
		}	
	return " width='$nx' height='$ny'";
	}

function proceder($fecha)
	{
	global $conexio;
	$csql = "select id from ope_tesoreria where status='1' and fecha>='$fecha';";		
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		$back=false;		
	else 
		$back=true;
	mysqli_free_result($res2);
	return $back;
	}

function procedecaptura($tabla,$fecha)
	{
	global $conexio;
	$back=true;
	$csql = "select id from $tabla where status='1' and fecha>='$fecha';";		
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		$back=false;	
	mysqli_free_result($res2);
	return $back;
	}

function loguea($tipo,$idorigen,$accion,$iduser,$descripcion)
	{
	global $conexio;
	$descripcion= str_replace("'","\'",$descripcion);
	$csql = "INSERT INTO `adm_logs` (`tipo`,`idorigen`,`accion`,`iduser`,`fecha`,`descripcion` ) VALUES ('$tipo','$idorigen','$accion','$iduser',NOW(),'$descripcion');";
#echo $csql;
	mysqli_query($conexio,$csql);

	if(mysqli_error($conexio)=="")
		return "OK";
	else
		return mysqli_error($conexio);
	}

function exportar($tabla,$id)
	{
	global $conexio;
	$regreso="INSERT INTO `$tabla` (";	
	$consulta = "Select * from `$tabla` where id='$id'";
	$res = mysqli_query($conexio,$consulta);
	$field = mysql_num_fields( $res);
    for ( $i = 0; $i < $field; $i++ ) 
    	{
    	$regreso .="`".mysql_field_name($res, $i )."`,";        
        }
    $regreso=substr($regreso,0,strlen($regreso)-1);
    
	$regreso .=") VALUES (";
	
	if($valp=mysqli_fetch_array($res))
		{
		#$regreso .=count($valp);
		$m=count($valp);
		for($i=0;$i<$m;$i++)
			{
			if(isset($valp[$i]))
				$regreso .="\'".$valp[$i]."\',";
			}
		}
	$regreso=substr($regreso,0,strlen($regreso)-1);
	
	$regreso .=");";
	mysqli_free_result($res);

	return $regreso;
	}

function logthis($tipo,$idorigen,$accion,$iduser,$usuario,$descripcion)
	{
	global $conexio;
	$descripcion= str_replace("'","\'",$descripcion);
	$csql = "INSERT INTO `adm_logs` (`tipo`,`idorigen`,`accion`,`iduser`,`usuario`,`fecha`,`descripcion` ) VALUES ('$tipo','$idorigen','$accion','$iduser','$usuario',NOW(),'$descripcion');";
#echo $csql;
	mysqli_query($conexio,$csql);

	if(mysqli_error()=="")
		return "OK";
	else
		return mysqli_error();
	}

function lognow($tabla,$idorigen,$tipo,$usuario,$descripcion)
	{
	global $conexio;
	$descripcion= str_replace("'","\'",$descripcion);
	$csql = "INSERT INTO `$tabla` (`idorigen`,`tipo`,`descripcion`,`status`,`ultactfec`,`ultactusu` ) VALUES ('$idorigen','$tipo','$descripcion','1','".date("Y-m-d H:i:s")."','$usuario');";
	mysqli_query($conexio,$csql);

	if(mysqli_error($conexio)=="")
		return "OK";
	else
		return mysqli_error($conexio);
	}

function ids($tipo)
	{
	global $conexio;
	if($tipo==1)
		{
		$idscontratados="";
		$csql="SELECT id from cat_statusoperador where contratado='1'";
		$resx = mysqli_query($conexio,$csql);
		while($val=mysqli_fetch_array($resx))
			$idscontratados .=$val['id'].",";
		mysqli_free_result($resx);
		if($idscontratados!="")
			$idscontratados=substr($idscontratados,0,strlen($idscontratados)-1);	
		}
	return $idscontratados;
	}

function hit($pagina,$descripcion,$idusuario,$usuario)
	{
	global $conexio;
	$ip=$_SERVER['REMOTE_ADDR'];
	$csql = "INSERT INTO `ope_hits` (`idusuario`,`usuario`,`pagina`,`descripcion`,`ip`,`fecha`) ";
	$csql .="VALUES ('$idusuario','$usuario','$pagina','$descripcion','$ip',NOW());";
#echo $csql;
	mysqli_query($conexio,$csql);
	if(mysqli_error($conexio)!="") {
		return "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
		exit(); }

	return "OK";
	}
?>

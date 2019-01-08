<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");
session_name ("siccsession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$conexio=conecta($IDBase);
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	} 

if(isset($_GET['rfc']))
	{
	$rfc=strtoupper(substr($_GET['rfc'],0,9));
	
	$id=$_GET['id'];
	
	#echo traedato2("select id from cat_operadores where UPPER(LEFT(rfc,9))='$rfc' and id!='$id'","id");
	#exit();
	
	$idmiembro=traedato2("select id from cat_clientes where UPPER(LEFT(rfc,9))='$rfc' and id!='$id'","id");
	if($idmiembro>0)
		$res="El RFC proporcionado ya existe.";
	else
		$res="OK";
	}
else
	$res="ERROR. Especifique id";
#echo utf8_encode($res);
echo $res;
?>


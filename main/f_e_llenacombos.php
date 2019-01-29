<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php"); 
#Vemos si esta logueado el usuario
session_name ("siccsession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$conexio=conecta($IDBase);
	$IDL=permiso("AdminModulos",$IDU);
	if($IDL<0)
		{
		echo "ERROR. Usted no tiene acceso a este modulo.";
		exit();
		}

	if($_SESSION['vidamax']>0)
		{
		if(($_SESSION['vida']+$_SESSION['vidamax']) <= time())
			{		
			echo "ERROR. Su sesion ha expirado, debe autentificarse nuevamente para continuar.";
			exit();
			}
		}	
	}
else
	exit();

$res="<option selected value='0'>(seleccione)</option>";
if(isset($_GET['id']))
	{
	$id=$_GET['id'];
	$csql = "SELECT * FROM adm_modcatego WHERE idpadre='$id' and status='1' order by descripcion asc";
	$resx = mysqli_query($conexio, $csql);
	while($val=mysqli_fetch_array($resx))
		$res.="<option value='".$val['id']."'>".$val['descripcion']."</option>";		
	mysqli_free_result($resx);
	}
else
	$res="ERROR. Especifique id";
echo $res;
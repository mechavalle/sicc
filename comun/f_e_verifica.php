<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");
$conexio=conecta("");
  

if(isset($_GET['campo']))
	$campo=$_GET['campo'];
else
	{
	echo "ERROR: no hay campo especificado.";
  	exit();
	}

if(isset($_GET['valor']))
	$valor=$_GET['valor'];
else
	{
	echo "ERROR: no hay valor especificado.";
  	exit();
	}
if(isset($_GET['activo']))
	$activo=$_GET['activo'];
else
	$activo=1;
$back="";
if($activo==1)
	$csql = "SELECT * from `adm_usuarios` WHERE $campo='$valor' and status='1'";
else
	$csql = "SELECT * from `adm_usuarios` WHERE $campo='$valor'";
#echo "ERROR $csql";
#exit();
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{
	if($campo=="mail")
		$back="ERROR. Correo ya registrado. Puede recuperar su contraseña desde la página de inicio.";
	if($campo=="usuario")
		$back="ERROR. El usuario ya existe, especifique otro usuario.";
	}
mysqli_free_result($res2);

echo $back;
exit();
?>
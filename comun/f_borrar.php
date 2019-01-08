<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");

#Vemos si esta logueado el usuario
session_name ("micsession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
  {
  $idowner=$_SESSION['IDOwner'];
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

if(isset($_GET['id']))
	$id=$_GET['id'];
else
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		exit();
	}


if(isset($_GET['id']))	
	$id=$_GET['id'];
else {
	echo "<html><head><title>Borrar</title></head><body onLoad=\"window.close();\"></body></html>";
	exit(); }

if(isset($_GET['campoid']))	
	$campoid=$_GET['campoid'];
else {
	echo "<html><head><title>Borrar</title></head><body onLoad=\"window.close();\"></body></html>";
	exit(); }
	
if(isset($_GET['tabla']))	
	$tabla=$_GET['tabla'];
else {
	echo "<html><head><title>Borrar</title></head><body onLoad=\"window.close();\"></body></html>";
	exit(); }
	
if(isset($_GET['img']))	
	$img=$_GET['img'];
else
	$img="";
	
if(isset($_GET['ver']))	
	$ver=$_GET['ver'];
else {
	echo "<html><head><title>Borrar</title></head><body onLoad=\"window.close();\"></body></html>";
	exit(); }

$ahora=md5($id.$campoid.$tabla."masamuneshirow");
if($ver!=$ahora)
	{
	echo "<html><head><title>Borrar</title></head><body onLoad=\"alert('Uso no autorizado de funcion');\"></body></html>";
	exit(); }

if(isset($_GET['accion']))
	{
	if($_GET['accion']=="1")
		{
		
		if($img!="")
			if(file_exists($img))
				unlink($img);
		
		$csql = "DELETE FROM `$tabla` WHERE `$campoid`='$id'";
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!=""){
			echo "Error al grabar el registro. ".mysqli_error($conexio)."-> $csql";
			exit();	}
		echo "<html><head><title>Borrar</title></head><body onLoad=\" w2=window.opener; w2.location.reload(); window.close(); \"></body></html>";
		exit();
		}
	}
?>

<html>

<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Seleccione el archivo</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
</head>

<body style="background-color: yellow;"">
<form name="edicion" method="GET" target="_self" enctype="multipart/form-data">
	<br>
	<h4><p align="center"><font color="#FF0000">¿Realmente desea borrar este registro?</font></p></h4>
	<br>
	<p align="center">
		<button type='button' onClick="document.edicion.submit(); " class='btn btn-success' style="width: 100px">SÍ</button>
		&nbsp;&nbsp;&nbsp;<button type='button' onClick="window.close();" class='btn btn-danger' style="width: 100px">NO</button>
	</p>


	<input type="hidden" name="id" value="<? echo $id;?>">
	<input type="hidden" name="tabla" value="<? echo $tabla;?>">
	<input type="hidden" name="campoid" value="<? echo $campoid;?>">
	<input type="hidden" name="img" value="<? echo $img;?>">
	<input type="hidden" name="ver" value="<? echo $ver;?>">
	<input type="hidden" name="accion" value="1">
</form>
</body>

</html>
<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php"); 

if(isset($_GET['permiso']))
	$permiso=$_GET['permiso'];
else
	{
	if(isset($_POST['permiso']))
		$permiso=$_POST['permiso'];
	else
		exit();
	}
	
if(isset($_GET['minlev']))
	$minlev=$_GET['minlev'];
else
	{
	if(isset($_POST['minlev']))
		$minlev=$_POST['minlev'];
	else
		$maxlev=0;
	}

if(isset($_GET['maxlev']))
	$maxlev=$_GET['maxlev'];
else
	{
	if(isset($_POST['maxlev']))
		$maxlev=$_POST['maxlev'];
	else
		$maxlev=0;
	}

if(isset($_GET['desc']))
	$desc=$_GET['desc'];
else
	{
	if(isset($_POST['desc']))
		$desc=$_POST['desc'];
	else
		$desc="¿?";
	}

if(isset($_GET['tabla']))
	$tabla=$_GET['tabla'];
else
	{
	if(isset($_POST['tabla']))
		$tabla=$_POST['tabla'];
	else
		exit();
	}
	
if(isset($_GET['tablacom']))
	$tablacom=$_GET['tablacom'];
else
	{
	if(isset($_POST['tablacom']))
		$tablacom=$_POST['tablacom'];
	else
		$tablacom="";
	}	
	
if(isset($_GET['campo']))
	$campo=$_GET['campo'];
else
	{
	if(isset($_POST['campo']))
		$campo=$_POST['campo'];
	else
		$campo="";
	}
	

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
	$IDL=permiso($permiso,$IDU);
	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
		exit();
		}
	if($minlev!=0)
		{
		if($IDL<$minlev)
			{
			echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su nivel de acceso es insuficiente para acceder.'); window.close();\"></body></html>";
			exit();
			}
		}
	if($_SESSION['vidamax']>0)
		{
		if(($_SESSION['vida']+$_SESSION['vidamax']) <= time())
			{		
			echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su sesion ha expirado, debe autentificarse nuevamente para continuar.'); wx=window.parent; wx.location.href='../index.php'; \"></body></html>";
			exit();
			}
		}	
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	} 


?>


<html>

<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?echo $desc?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

</head>


<body>
<form method="POST" name="edicion" target="_self">
<div style="padding: 0 20px;">
<?
if($desc!="")
	echo "<p><h3><font color='#888888'>Consulta <font color='#ff0000'>$desc</font></font></h3></p>";
if($maxlev!=0)
	{
	if($IDL>=2)
		echo "<button type='button' onClick=\" abre('registro','f_registroc.php?permiso=$permiso&minlev=$minlev&maxlev=$maxlev&desc=$desc&tabla=$tabla',550,250,'NO'); \" class='btn btn-success btn-xs'>Nuevo Registro</button>";
	}
else
	echo "<button type='button' onClick=\" abre('registro','f_registro.php?permiso=$permiso&minlev=$minlev&maxlev=$maxlev&desc=$desc&tabla=$tabla',550,250,'NO'); \" class='btn btn-success btn-xs'>Nuevo Registro</button>";
?>
&nbsp;<a href="#"  onclick="document.edicion.submit();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>
<br>
<table class="table table-striped" style="width: 500px">
	 <thead>
      	<tr>
      		<th></th>
      		<th><font size="2" face="Arial">Descripción</font></th>
      		<th><font size="2" face="Arial">Color Asociado</font></th>
			<th><font face="Arial" size="2">Status</font></th>
		</tr>
	</thead>      	  
    <tbody>
<?
			$i=0;
			$consulta="select * from $tabla order by descripcion";
			$res = mysqli_query($conexio,$consulta);		
			while($val=mysqli_fetch_array($res))
				{
				$i +=1;
				$id=$val['id'];
				$descripcion=$val['descripcion'];
				$color=$val['color'];
				$status=$val['status'];
				if($status==1 || $status==11)
					{
					$status="Activo";
					$foncolor="color='#000000'";
					}
				else
					{
					$status="Inactivo";
					$foncolor="color='#808080'";
					}

				if($minlev!=0)
					{
					if($IDL>=2)
						$link="<a href='#' onclick=\"abre('registro','f_registroc.php?permiso=$permiso&minlev=$minlev&maxlev=$maxlev&desc=$desc&tabla=$tabla&tablacom=$tablacom&campo=$campo&id=$id',550,250,'NO');\">";
					else
						$link="";
					}
				
				echo "<tr>
				<td><font face='Verdana' size='1' color='#808080'>$i</font></td>
				<td>$link<font face='Arial' size='2' $foncolor>$descripcion</font></a></td>
				<td><div style='width: 100px; height: 30px; background-color: $color;'></div></td>
				<td>$link<font face='Arial' size='2' $foncolor>$status</font></a></td>
				</tr>";
				}
			mysqli_free_result($res);			
			?>
			</tbody>
			</table>
			
</div>
<input type="hidden" name="accion" value="0">
<input type="hidden" name="id" value="0">
<input type="hidden" name="valor" value="">
</form>

</body>

</html>
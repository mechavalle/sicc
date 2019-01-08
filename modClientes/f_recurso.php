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
	$IDL=permiso("AdminCatalogos",$IDU);

	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
		exit();
		}
	if($IDL<2)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su nivel de acceso es insuficiente para acceder.'); window.close();\"></body></html>";
		exit();
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

	
if(isset($_GET['id']))
	$id=$_GET['id'];
else
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		$id="-1";
	}

if(isset($_POST['accion']))	
	{
	$accion=$_POST['accion'];
	if($accion==1)
		{
		$tipo=$_POST['tipo'];
		$orden=$_POST['orden'];
		$descripcion=$_POST['descripcion'];
		$status=$_POST['status'];
		if(Existe("cat_recursos","id",$id)=="NE")
			{
			$csql = "INSERT INTO `cat_recursos` (`tipo`,`orden`,`descripcion`,`status`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$tipo','$orden','$descripcion','$status',NOW(),'$IDUser');";
			}
		else{
			$csql = "UPDATE `cat_recursos` SET `tipo`='$tipo',`orden`='$orden',`descripcion`='$descripcion', `status`='$status',`ultactfec`=NOW(),`ultactusu`='$IDUser' ";
			$csql .="WHERE `id`='$id';";
			}
		mysqli_query($conexio,$csql);
		
		echo "<html><head><title>Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.close(); \"></body></html>";
		exit();

		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
			#Fin guardado
		}
	if($accion==2)
		{
		if($IDL<3)
				{
				echo "<html><head><title>Registro</title></head><body onLoad=\" alert('No es posible borrar este registro usted no tiene el nivel de acceso adecuado'); window.close(); \"></body></html>";
				exit();					
				}



			#buscamos si existen registro que utilicen el proximo a borrar
			$cuantos=cuenta("rel_reecursos","id","idrecurso='$id'");
			if($cuantos>0)
				{
				echo "<html><head><title>Registro</title></head><body onLoad=\" alert('No es posible borrar este registro porque existen otros registros que dependen de él'); window.close(); \"></body></html>";
				exit();					
				}

		$csql="DELETE FROM `cat_recursos` WHERE `id`='$id'";
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" alert('Registro borrado con éxito'); ww=window.opener; ww.location.reload(); window.close(); \"></body></html>";
		exit();

		}
	
	}
	
if($id!="-1")
	{
	$csql = "SELECT * from `cat_recursos` WHERE `id` = '$id';";
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		{
		$tipo=$val5['tipo'];
		if($tipo==0)
			$tipov="<option selected value=0>(seleccionar)</option><option value=1>Ingreso</option><option value=2>Egreso</option>";
		if($tipo==1)
			$tipov="<option value=0>(seleccionar)</option><option selected value=1>Ingreso</option><option value=2>Egreso</option>";
		if($tipo==2)
			$tipov="<option value=0>(seleccionar)</option><option value=1>Ingreso</option><option selected value=2>Egreso</option>";
		$orden=$val5['orden'];
		$descripcion=$val5['descripcion'];
		$status=$val5['status'];
		if($status==0)
			$statusv="<option value=1>Activo</option><option selected value=0>Inactivo</option>";
		if($status==1)
			$statusv="<option selected value=1>Activo</option><option value=0>Inactivo</option>";
		if($status==10)
			$statusv="<option value=11>Activo</option><option selected value=10>Inactivo</option>";
		if($status==11)
			$statusv="<option selected value=11>Activo</option><option value=10>Inactivo</option>";		
		$ultima=$val5['ultactusu']." el ".fixfecha($val5['ultactfec']);
		}
	mysqli_free_result($res2);
	}
else
	{
	$tipo=0;
	$tipov="<option selected value=0>(seleccionar)</option><option value=1>Ingreso</option><option value=2>Egreso</option>";
	$orden=0;
	$descripcion="";
	$status="1";
	$statusv="<option selected value=1>Activo</option><option value=0>Inactivo</option>";
	$ultima="";
	}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Recurso</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link rel="stylesheet" href="../lib/stlinks.css">
<SCRIPT LANGUAGE="JavaScript">
function guardar()
	{
	document.getElementById("divboton").innerHTML="<i class='fa fa-refresh fa-spin fa-2x'></i>";
	document.edicion.accion.value='1';	
	document.edicion.submit();
	}

function borrar()
	{
	if(confirm("¿Esta usted seguro de borrar este registro?"))
		{
		document.edicion.accion.value='2';	
		document.edicion.submit();
		}
	}	

</SCRIPT>
</head>
<body>
<form method="POST" name="edicion" target="_self">
	<div class="container-fluid">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td><? echo "<h3>Editar Recurso</h3>";  ?></td>
				<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
			</tr>
		</table>	

		<div id="divboton">
		<?
		echo "<button type='button' onClick=\" guardar(); \" class='btn btn-success btn-xs'>Guardar</button>";		
		if($IDL>=2 && $id>0 && $status<10)
			echo "&nbsp;<button type='button' onClick=\" borrar(); \" class='btn btn-danger btn-xs'>Borrar</button>";			
		?>
		</div>
		<br>

		<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="0">
			<tr>
				<td align="right" width="100" height="25"><font face="Arial" size="2">Status:</font></td>
				<td width="5" height="25">&nbsp;</td>
				<td height="25">
				<select size="1" name="status" class="cenboxfrmmin"><?echo $statusv;?></select></td>
			</tr>
			<tr>
				<td align="right" width="100" height="25"><font face="Arial" size="2">Tipo:</font></td>
				<td width="5" height="25">&nbsp;</td>
				<td height="25">
				<select size="1" name="tipo" class="cenboxfrmmin"><?echo $tipov;?></select></td>
			</tr>
			<tr>
				<td align="right" width="100" height="25"><font face="Arial" size="2">Orden:</font></td>
				<td width="5" height="25">&nbsp;</td>
				<td height="25">
				<input type="text" name="orden" class="cenboxfrmmin" <?echo "value='$orden'";?>></td>
			</tr>
			<tr>
				<td align="right" width="100" height="25"><font face="Arial" size="2">Descripción:</font></td>
				<td width="5" height="25">&nbsp;</td>
				<td height="25">
				<input type="text" name="descripcion" class="cenboxfrm" <?echo "value='$descripcion'";?>></td>
			</tr>
		</table>
		<br>
		<p><font face="Verdana" size="1" color="#808080">Ultima Actualización: <?echo $ultima;?></font></p>


		<input type="hidden" name="id" <?echo "value='$id'";?>>		
		<input type="hidden" name="accion" value='0'>
	</div>
</form>
</body>

</html>
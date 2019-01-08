<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php"); 

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

if(isset($_GET['regreso']))
	$regreso=$_GET['regreso'];
else
	{
	if(isset($_POST['regreso']))
		$regreso=$_POST['regreso'];
	else
		$regreso=0;
	}

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
  $IDL=permiso("AdminComics",$IDU);  
  #echo $IDL;
  if($IDL<1)
    {
    echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
    exit();
    }
  if($_SESSION['vidamax']>0)
    {
    if(($_SESSION['vida']+$_SESSION['vidamax']) <= time())
      {   
      echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su sesion ha expirado, debe autentificarse nuevamente para continuar.'); wx=window.parent; wx.location.href='../index.php'; \"></body></html>";
      exit();
      }
    else
      {
      $_SESSION['vida']=time();
      session_write_close();
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
		$descripcion=$_POST['descripcion'];
		$status=$_POST['status'];
		if(Existe($tabla,"id",$id)=="NE")
			{
			$csql = "INSERT INTO `$tabla` (`idowner`,`descripcion`,`status`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$idowner','$descripcion','$status',NOW(),'$IDUser');";
			}
		else{
			$csql = "UPDATE `$tabla` SET `descripcion`='$descripcion', `status`='$status',`ultactfec`=NOW(),`ultactusu`='$IDUser' ";
			$csql .="WHERE `id`='$id';";
			}
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		#Fin guardado
		
		if($regreso==1)
			echo "<html><head><title>Guardado</title></head><body onLoad=\" ww=window.opener; ww.document.edicion.buscar.value='$descripcion';   ww.document.edicion.submit(); window.close(); \"></body></html>";
		else
			echo "<html><head><title>Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.close(); \"></body></html>";
		exit();

		}
	if($accion==2)
		{
		if($maxlev!=0)
			{
			if($IDL<$maxlev)
				{
				echo "<html><head><title>Registro</title></head><body onLoad=\" alert('No es posible borrar este registro usted no tiene el nivel de acceso adecuado'); window.close(); \"></body></html>";
				exit();					
				}
			}

		if($tablacom!="")
			{
			#buscamos si existen registro que utilicen el proximo a borrar
			$cuantos=cuenta($tablacom,"id","$campo='$id'");
			if($cuantos>0)
				{
				echo "<html><head><title>Registro</title></head><body onLoad=\" alert('No es posible borrar este registro porque existen otros registros que dependen de él'); window.close(); \"></body></html>";
				exit();					
				}
			}
		$csql="DELETE FROM `$tabla` WHERE `id`='$id'";
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
	$csql = "SELECT * from `$tabla` WHERE `id` = '$id';";
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		{
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
	$descripcion="";
	$status="";
	$statusv="<option selected value=1>Activo</option><option value=0>Inactivo</option>";
	$ultima="";
	}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link rel="stylesheet" href="../lib/stlinks.css">
<SCRIPT LANGUAGE="JavaScript">
function guardar()
	{
	if(document.edicion.descripcion.value=="")
		{
		alert('Especifique una descripción');
		document.edicion.descripcion.focus();
		}
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
				<td><? echo "<h3>$desc</h3>";  ?></td>
				<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
			</tr>
		</table>	

		<div id="divboton">
		<?
		if($IDL>=1)
			echo "<button type='button' onClick=\" guardar(); \" class='btn btn-success btn-xs'>Guardar</button>";
		if($maxlev!=0)
			{
			if($IDL>=$maxlev && $id>0 && $status<10)
				echo "&nbsp;<button type='button' onClick=\" borrar(); \" class='btn btn-danger btn-xs'>Borrar</button>";		
			}
		else
			{
			if($id>0 && $status<10)
				echo "&nbsp;<button type='button' onClick=\" borrar(); \" class='btn btn-danger btn-xs'>Borrar</button>";	
			}	
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
				<td align="right" width="100" height="25"><font face="Arial" size="2">Descripción:</font></td>
				<td width="5" height="25">&nbsp;</td>
				<td height="25">
				<input type="text" name="descripcion" class="cenboxfrm" <?echo "value='$descripcion'";?>></td>
			</tr>
		</table>
		<br>
		<p><font face="Verdana" size="1" color="#808080">Ultima Actualización: <?echo $ultima;?></font></p>


		<input type="hidden" name="id" <?echo "value='$id'";?>>
		<input type="hidden" name="desc" <?echo "value='$desc'";?>>
		<input type="hidden" name="tabla" <?echo "value='$tabla'";?>>
		<input type="hidden" name="tablacom" <?echo "value='$tablacom'";?>>
		<input type="hidden" name="campo" <?echo "value='$campo'";?>>
		<input type="hidden" name="permiso" <?echo "value='$permiso'";?>>
		<input type="hidden" name="regreso" <?echo "value='$regreso'";?>>
		<input type="hidden" name="accion" value='0'>
	</div>
</form>
</body>

</html>
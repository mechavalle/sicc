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
	$IDL=permiso("adminUsuarios",$IDU);
	$IDL2=permiso("AdminModulos",$IDU);
	if($IDL<=0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close();\"></body></html>";
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
		exit();		
	}

if(isset($_GET['actualizar']))
	$actualizar=$_GET['actualizar'];
else
	{
	if(isset($_POST['actualizar']))
		$actualizar=$_POST['actualizar'];
	else		
		$actualizar=1;		
	}


	
$csql = "SELECT * from `adm_permisos` WHERE `id` = '$id';";
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{
	$idmodulo=$val5['idmodulo'];
	$tipo=$val5['tipo'];
	}
else
	exit();
mysqli_free_result($res2);

$idusuario=traedato("adm_permisos","id",$id,"S","idusuario");

$elusuario=traedato("adm_usuarios","id",$idusuario,"S","nombre");

$csql = "SELECT * from `adm_modulos` WHERE `id` = '$idmodulo';";
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{
	$idcata=$val5['idcata'];
	$categoria=traedato("adm_modcatego","id",$idcata,"S","descripcion");
	$idcatb=$val5['idcatb'];
	$idcatbv=traedato("adm_modcatego","id",$idcatb,"S","descripcion");
	$modulo=$val5['modulo'];
	$categoria .=" / $idcatbv";
	$nombre=$val5['nombre'];
	$descripcion=$val5['descripcion'];
	$maxniveles=$val5['maxniveles'];
	if($tipo==1)
		$nivelv="<option selected value='1'>1</option>";
	else
		$nivelv="<option value='1'>1</option>";
	for($j=2;$j<=$maxniveles;$j++)
		{
		if($tipo==$j)
			$nivelv .="<option selected value='$j'>$j</option>";
		else
			$nivelv .="<option value='$j'>$j</option>";
		}
	$niveles=$val5['niveles'];
	$ultima=fixfecha($val5['ultactfec'])." por ".$val5['ultactusu'];
	mysqli_free_result($res2);
	}
else
	exit();
	
if(isset($_GET['accion']))	
	{	
	$accion=$_GET['accion'];
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$tipo=$_GET['nivel'];
		$csql = "UPDATE `adm_permisos` set tipo='$tipo', ultactfec=NOW(), ultactusu='$IDUser' where id='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "ERROR: "."Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }

		loguea("Permisos",$idusuario,"Editar",$IDU,"Se editó un permiso: '$nombre' al usuario '$elusuario' al nivel: '$tipo'");
		if($actualizar==1)
			echo "<html><head><title>Permiso Guardado</title></head><body onLoad=\"w2=window.opener; w2.location.reload(); window.close();\"></body></html>";
		else
			echo "<html><head><title>Permiso Guardado</title></head><body onLoad=\"window.close();\"></body></html>";
		exit();
		#Fin guardado
		}
	if($accion==5)
		{
		$csql = "DELETE from `adm_permisos`  where id='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "ERROR: "."Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }
		
		loguea("Permisos",$idusuario,"Borrado",$IDU,"$IDUser borró el permiso: '$nombre' al usuario '$elusuario'");
	
		if($actualizar==1)
			echo "<html><head><title>Permiso Guardado</title></head><body onLoad=\"w2=window.opener; w2.location.reload(); window.close();\"></body></html>";
		else
			echo "<html><head><title>Permiso Guardado</title></head><body onLoad=\"window.close();\"></body></html>";
		exit();
		}
	}

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Permiso</title>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/stlinks.css">
<SCRIPT LANGUAGE="JavaScript">

function guardar()
	{
	document.getElementById("divboton").innerHTML="<p align='center'><i class='fa fa-refresh fa-spin fa-2x'></i></p>";
	document.edicion.accion.value=1;
	document.edicion.submit();
	}
	
function borrar()
	{
	if(confirm('Va a eliminar este permiso, ¿continuar?'))
		{
		document.edicion.accion.value=5;
		document.edicion.submit();
		}
	}

</SCRIPT>
</head>


<body>
<form method="GET" name="edicion" target="_self">
	<div class="container-fluid">
		<div class="row" style=" padding: 0 10px;">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td><? echo "<h3>Actualiza Permiso de <font color='#ff0000'>$elusuario</font></h3>";  ?></td>
				<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
			</tr>
		</table>	
		</div>

<? if($idmodulo!=0){?>
		<div class="row">
			<div class="col-sm-6">
				<table border="0" width="100%" id="table11" cellspacing="0" cellpadding="0">
					<? if($IDL2>0){?>
						<tr>
							<td width="100" height="25"><font face="Arial" size="2">Identificador:</font></td>
							<td><font face="Arial" size="2"><b><?echo $modulo;?></b></font></td>
						</tr>
					<?}?>
					<tr>
						<td width="100" height="25"><font face="Arial" size="2">Categoría:</font></td>
						<td><font face="Arial" size="2"><b><?echo $categoria;?></b></font></td>
					</tr>
					<tr>
						<td width="100" height="25"><font face="Arial" size="2">Nombre:</font></td>
						<td><font face="Arial" size="2"><b><?echo $nombre;?></b></font></td>
					</tr>
					<tr>
						<td width="100" height="25"><font face="Arial" size="2">Nivel:</font></td>
						<td>
							<select size="1" name="nivel" class="cenboxfrmmin">
								<?echo $nivelv;?>
							</select>
						</td>
					</tr>
					<tr>
						<td width="100" height="25"></td>
						<td><font face="Arial" size="2"><b><?echo $niveles;?></b></font></td>
					</tr>
				</table>
			</div>
			<div class="col-sm-6">
				<? if($descripcion!=""){?>
				<table border="0" width="100%" id="table11" cellspacing="0" cellpadding="0">					
					<tr>
						<td width="100" height="25"><font face="Arial" size="2">Descripción:</font></td>
						<td><font face="Arial" size="2"><b><?echo $descripcion;?></b></font></td>
					</tr>					
				</table>
				<?}?>
			</div>
		</div>
<?}?>

		<br>
		<div id='divboton'>
			<p align="center">
				<button type='button' onClick="guardar();" class='btn btn-success'>Actualizar Permiso Ahora</button>
				&nbsp;<button type='button' onClick="borrar();" class='btn btn-danger'>Eliminar Permiso</button>
			</p>
		</div>
		<br>
		<p><font color="#808080" face="Verdana" size="1">Última Actualización: <?echo $ultima;?></font></p>
		<br>


	</div>

<input type="hidden" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="actualizar" <?echo "value='$actualizar'";?>>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
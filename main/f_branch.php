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

if(isset($_GET['tabla']))
	$tabla=$_GET['tabla'];
else
	{
	if(isset($_POST['tabla']))
		$tabla=$_POST['tabla'];
	else
		exit();
	}

if(isset($_GET['desc']))
	$desc=$_GET['desc'];
else
	{
	if(isset($_POST['desc']))
		$desc=$_POST['desc'];
	else
		exit();
	}


#Vemos si esta logueado el usuario
session_name ("siccsession");
session_start();
if(isset($_SESSION['IDU']) )
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$conexio=conecta($IDBase);
	$IDL=3;
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	} 

function asigna($variable) 
{ 
if(isset($_POST[$variable]))	
	return $_POST[$variable];
else 
   	return ""; 
}

		
function borracc($elid)
	{
	global $conexio;
	global $tabla;
	$csql = "SELECT * from $tabla WHERE `idpadre` = '$elid'";
	$res2 = mysqli_query($conexio,$csql);
	while($val5=mysqli_fetch_array($res2))
		borracc($val5['id']);		
	mysqli_free_result($res2);
		
	$csql="DELETE FROM $tabla WHERE `id`='$elid'";
	mysqli_query($conexio,$csql);
	if(mysqli_error($conexio)!="") {
		echo "Error al borrar registro. ".mysqli_error($conexio)." ->$csql";
		exit(); }
	}	

if(isset($_GET['id']))
	$id=$_GET['id'];
else
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		{ #va a ser nuevo		
		if(isset($_GET['idpadre']) && isset($_GET['nivel']))
			{
			$id=-1;
			$idpadre=$_GET['idpadre'];######################
			$nivel=$_GET['nivel'];
			}
		else
			{echo "<html><head><title>Inicio</title></head><body onLoad=\" alert('Falta algun parametro para crear el nuevo registro.'); window.close();\"></body></html>";
			exit();}
		}
	}
	


if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	
	
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$idpadre=$_POST['idpadre'];
		$nivel=$_POST['nivel'];
		$descripcion=$_POST['descripcion'];
		$status=$_POST['status'];
				
		
		if(Existe($tabla,"id",$id)=="NE")
			{
			$csql = "INSERT INTO `$tabla` (`idpadre`,`nivel`,`descripcion`,`status`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$idpadre','$nivel','$descripcion','$status',NOW(),'$IDUser');";			
			}
		else{
			$csql = "UPDATE `$tabla` SET `idpadre`='$idpadre',`nivel`='$nivel', `descripcion`='$descripcion',`status`='$status',`ultactfec`=NOW(), `ultactusu`='$IDUser' ";
			$csql .="WHERE `id`='$id';";			
			}
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" wx=window.opener; wx.location.reload(); window.close(); \"></body></html>";
		exit();
		#Fin guardado
		}
	
		
	if($accion==2)
		{		
		borracc($id);
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" wx=window.opener; wx.location.reload(); window.close(); \"></body></html>";
		exit();
		}
		
	if($accion==3)
		{
		$csql = "SELECT * from $tabla WHERE `idpadre` = '$id';";
		$res2 = mysqli_query($conexio,$csql);
		$cuantos=0;
		while($val5=mysqli_fetch_array($res2))
			borracc($val5['id']);		
		mysqli_free_result($res2);	
		echo "<html><head><title>Registros Borrados</title></head><body onLoad=\" wx=window.opener; wx.location.reload(); window.close(); \"></body></html>";
		exit();		
		}
			

		
	}
else{ #Fin del existe 'Accion'
	if($id!="-1")
		{
		#Realizamos la consulta para traer los valores
		
		$csql = "SELECT * from `$tabla` WHERE `id` = '$id';";
		$res2 = mysqli_query($conexio,$csql);
		if($val5=mysqli_fetch_array($res2))
			{
			$idpadre=$val5['idpadre'];
			
			$clavebase="";

			$nivel=$val5['nivel'];
			$descripcion=$val5['descripcion'];
			
			$status=$val5['status'];
			if($status==1)
				$statusv="<option value='0'>Inactivo</option><option value='1' selected>Activo</option>";
			else
				$statusv="<option value='0' selected>Inactivo</option><option value='1' >Activo</option>";			
			
			$ultima=$val5['ultactusu']." ".fixfecha($val5['ultactfec']);
			$titulo="$descripcion";
			}
		mysqli_free_result($res2);
		}
	else 
		{
		$descripcion="";
				
		$status=1;
		$statusv="<option value='0' >Inactivo</option><option value='1' selected>Activo</option>";				
		$ultima="";
		$titulo="Registro nuevo";	
		}		
	}
if($idpadre==0)
	$padrev="Ningúno";
else
	$padrev=traedato($tabla,"id",$idpadre,"S","descripcion");	

$hijos=traedato2("select ifnull(count(id),0) as resu from $tabla where idpadre='$id'","resu");
	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?echo $titulo?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
var conexion1;



function borrar(id)
 {
 if (confirm("¿Realmente desea borrar este registro?. Todas los dependientes (si existen) seran borrados."))
 	{ 
 	document.edicion.accion.value=2;
 	document.edicion.submit(); 	
 	}
}

function borrarh()
 {
 if (confirm("¿Realmente desea borrar todos los dependientes?"))
 	{ 
 	document.edicion.accion.value=3;
 	document.edicion.submit(); 	
 	}
}


function guardarahora()
	{
	if(document.edicion.descripcion.value=="")
		{
		alert("Es necesario especificar una descripcion");
		document.edicion.descripcion.focus();
		return "0";
		}	
	document.edicion.accion.value=1;		
	document.edicion.submit();
	}

</SCRIPT>

</head>

<body>
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">
<div class="row" style=" padding: 0 10px;">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td><? echo "<h3>$titulo</h3>";  ?></td>
		<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
	</tr>
</table>	
</div>

<div id="divboton">
<?
if($IDL>=1)
	echo "<button type='button' onClick=\" guardarahora(); \" class='btn btn-success btn-xs'>Guardar</button>";

if($IDL>=3 && $id>0)
	echo "&nbsp;<button type='button' onClick=\" borrar(); \" class='btn btn-danger btn-xs'>Borrar</button>";		
	
?>
</div>
<br>

<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="0">
	<tr>
		<td width="150" align="right" height="25">
			<font face="Arial" size="2">Objeto Superior:</font></td>
		<td width="5">&nbsp;</td>
		<td><b><font face="Arial" size="2"><? echo $padrev;?></font></b></td>
	</tr>
	<tr>
		<td width="150" align="right" height="25"><font face="Arial" size="2">
				Status:</font></td>
				<td width="5">&nbsp;</td>
				<td><select size="1" name="status" style="font-family: Arial; font-size: 10pt;">
				<? echo $statusv?>
				</select></td>
	</tr>
	<tr>
		<td width="150" align="right"><font face="Arial" size="2">
				Descripción:</font></td>
		<td width="5">&nbsp;</td>
		<td>
			<textarea rows="3" name="descripcion" cols="46" style="font-family: Arial; font-size: 10pt;"><? echo $descripcion?></textarea></td>
		</tr>
</table>
<br>

		
<?if($hijos>0)
	{
	echo "<table border='0' width='100%' id='tab' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='300'><font face='Arial' size='2'><b>Este registro tiene $hijos dependientes</b></font></td>
				<td align='left'><button type='button' onClick=\" borrarh(); \" class='btn btn-danger btn-xs'>Borrar dependientes ahora</button></td>
			</tr>
		</table>";
	}	
?>
		

<br>
<p><font color="#808080" face='Verdana' size="1">Ultima Actualización: <?echo $ultima;?></font></p>

<input type="hidden" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="idpadre" <?echo "value='$idpadre'";?>>
<input type="hidden" name="nivel" <?echo "value='$nivel'";?>>

<input type="hidden" name="permiso" <?echo "value='$permiso'";?>>
<input type="hidden" name="desc" <?echo "value='$desc'";?>>
<input type="hidden" name="tabla" <?echo "value='$tabla'";?>>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
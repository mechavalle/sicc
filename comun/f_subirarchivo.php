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

if(isset($_GET['tabla']))
	$tabla=$_GET['tabla'];
else
	{
	if(isset($_POST['tabla']))
		$tabla=$_POST['tabla'];
	else
		{
		echo "Error: No hay tabla para actualizar imagen";
		exit();
		}
	}

if(isset($_GET['dir']))
	$dir=$_GET['dir'];
else
	{
	if(isset($_POST['dir']))
		$dir=$_POST['dir'];
	else
		{
		echo "Error: No hay ruta para actualizar imagen";
		exit();
		}
	}

if(isset($_GET['tipo']))
	$tipo=$_GET['tipo'];
else
	{
	if(isset($_POST['tipo']))
		$tipo=$_POST['tipo'];
	else
		exit();
	}
	
if(isset($_GET['desc']))
	$desc=$_GET['desc'];
else
	$desc="";
	
if(isset($_POST['desc2']))
	$desc2=$_POST['desc2'];
else
	$desc2="";


if(isset($_POST['accion']))	
	{
	$accion=$_POST['accion'];

	if($accion==1)
		{		
		if($tipo=="upd")	
			{
			#Actualizar descripcion
			$csql = "UPDATE `$tabla` set `descripcion`='$desc2', `ultactfec`='".date("Y-m-d h:i:s")."', `ultactusu`='$IDUser' WHERE `id`='$id';";
			mysqli_query($conexio,$csql);
			if(mysqli_error($conexio)!=""){
				echo "Error al actualizar la descripción: ".mysqli_error($conexio);
				exit();}							
			echo "<html><head><title>Subir Archivo</title></head><body onLoad=\"w2=window.opener; w2.location.reload(); window.close();\"></body></html>";
			exit();
			}
	
		if(strlen(basename($_FILES['foto']['name']))>0)
			{
		#echo "<br>1";
			$extension=extension(basename($_FILES['foto']['name']));
			if($tipo=="foto")
				$desc=$tipo;
		#echo "<br>1.2";
			$nuevonombre=completa($id,"0","9","S")."_".MD5($desc.Date("Y-m-d h:i:s")).".".$extension;
			$uploadfile = "../comics/".$dir."/".$nuevonombre;
		#echo "<br>1.3 ($dir,$nuevonombre,$uploadfile)";
		#echo "<br>$uploadfile";
			if(subearchivo("foto",$uploadfile)=="OK")
				{
		#echo "<br>2";			
				if($tipo=="foto")
					{
					if(Existe2($tabla,"`idorigen`='$id' and `tipo`='$tipo'")=="NE")
						{
						$csql = "INSERT INTO `$tabla` ( `idorigen` ,`idowner`, `tipo` , `archivo` , `tipoarchivo` , `tamaarchivo` , `fecha` , ";
						$csql .="`descripcion` , `comentario` , `ultactfec` , `ultactusu` ) ";
						$csql .= "VALUES ('$id','$idowner','$tipo','".$nuevonombre."','".$_FILES['foto']['type']."','".$_FILES['foto']['size']."',NOW(),";
						$csql .="'$desc2','','".date("Y-m-d h:i:s")."','$IDUser');";
						}
					else{
						#Primero borramos el archivo si existe
						$posiblefile="../".$dir."/".traedato2("select `archivo` from `$tabla` where `idorigen`='$id' and `tipo`='$tipo'","archivo");
						if(file_exists($posiblefile))
							unlink($posiblefile);
						$csql = "UPDATE `$tabla` set `archivo`='$nuevonombre' , `tipoarchivo`='".$_FILES['foto']['type']."' , `tamaarchivo`='".$_FILES['foto']['size']."' , `fecha`='".date("Y-m-d h:i:s")."', ";
						$csql .="`descripcion`='$desc',`ultactfec`=NOW() , `ultactusu`='$IDUser' WHERE `idorigen`='".$id."' and `tipo`='$tipo';";
						}
					mysqli_query($conexio,$csql);
					if(mysqli_error($conexio)!=""){
						echo "Error al grabar imagen: ".mysqli_error($conexio)."->$csql";
						exit();}
					echo "<html><head><title>Subir Archivo</title></head><body onLoad=\"w2=window.opener; w2.location.reload(); window.close();\"></body></html>";
					exit();			
					}
				else{
			#echo "<br>3";			
					$csql = "INSERT INTO `$tabla` (`idorigen`,`idowner`,`tipo` , `archivo` , `tipoarchivo` , `tamaarchivo` , `fecha` , ";
					$csql .="`descripcion` , `comentario` , `ultactfec` , `ultactusu` ) ";
					$csql .= "VALUES ('$id','$idowner','$tipo','".$nuevonombre."','".$_FILES['foto']['type']."','".$_FILES['foto']['size']."',NOW(),";
					$csql .="'$desc2','','".date("Y-m-d h:i:s")."','$IDUser');";
					mysqli_query($conexio,$csql);
					if(mysqli_error($conexio)!=""){
						echo "Error al grabar la imagen: ".mysqli_error($conexio)."->$csql";
						exit();}
					echo "<html><head><title>Subir Archivo</title></head><body onLoad=\"w2=window.opener; w2.location.reload(); window.close();\"></body></html>";
					exit();
					}				
				} #si subio archivo
			}# si hay archivo
		#exit();
		}# Accion=1
	}# E accion
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Subir Archivo o Imagen</title>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<script type="text/javascript">
window.resizeTo(400,350);
function go()
	{
	<? if($tipo!="upd") {?>
	if(document.edicion.foto.value=="")
		{
		alert ("seleccione algún archivo para continuar");
		return "";	
		}
	<?}?>
	document.getElementById("divboton").innerHTML="<p align='center'><i class='fa fa-refresh fa-spin fa-2x'></i></p>";
	document.edicion.accion.value=1;	
	document.edicion.submit();
	}
</script>
</head>
<body>
<form name="edicion" method="POST" target="_self" enctype="multipart/form-data">
<div class="container-fluid">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4>Actualizar Archivo</h4></td>
			<td width="33" align="right">			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>			
	</table>
	<? if($tipo!="upd") { ?>
	<table border="0" width="100%" id="table4" cellspacing="0" cellpadding="0">
		<tr>
			<td width="100" height="25">
				<button type="button" onclick="document.edicion.foto.click();" id="archfake" name="archfake" class="btn btn-info btn-xs" >Seleccionar</button>
			</td>
			<td width="5" height="25">&nbsp;</td>
			<td height="25">
				<input type="file" name="foto" size="25"  onchange="document.getElementById('divfake').innerHTML=document.edicion.foto.value.split('\\').pop(-1)" style="display: none;"><font color='#ff0000' face="Arial" size="2"><div id="divfake"></div></font>
			</td>
		</tr>		
	</table>
	<?} else echo "<br>";?>

	<?if($tipo!="foto"){?>
	<table border="0" width="100%" id="table4" cellspacing="0" cellpadding="0">
		<tr>
			<td width="100" valign="top"><b><font face="Arial" size="2">Descripción:</font></b></td>
			<td width="5">&nbsp;</td>
			<td><textarea class="cenboxfrm" name="desc2" style="height: 100px"><? echo $desc; ?></textarea></td>
		</tr>
	</table>
	<?}?>
	<br>
	<div id="divboton">
		<p align="center">
			<button type='button' onClick=" go(); " class='btn btn-success'>Continuar</button>
		</p>
	</div>


	<input type="hidden" name="id" <? echo "value='$id'";?>>
	<input type="hidden" name="tipo" <? echo "value='$tipo'";?>>	
	<input type="hidden" name="tabla" <? echo "value='$tabla'";?>>	
	<input type="hidden" name="dir" <? echo "value='$dir'";?>>	
	<input type="hidden" name="accion" value='0'>	
</div>
</form>
</body>

</html>
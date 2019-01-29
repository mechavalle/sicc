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
	$IDL=permiso("AdminUsuarioContrasena",$IDU);
	
	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close();\"></body></html>";
		exit();
		}
	
	if($_SESSION['vidamax']>0)
		{
		if(($_SESSION['vida']+$_SESSION['vidamax']) <= time())
			{		
			echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su sesion ha expirado, debe autentificarse nuevamente para continuar.'); window.close(); \"></body></html>";
			exit();
			}
		}	
	}
else
	{	
	echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('No hay sesion abierta, debe autentificarse nuevamente para continuar.'); window.close(); \"></body></html>";
	exit();	
	} 


if(isset($_GET['msg']))
	$msg=$_GET['msg'];
else
	$msg="";


if(isset($_POST['nuevo']))
	{
	$nuevo=$_POST['nuevo'];
	$nuevo2=$_POST['nuevo2'];	
	}
else
	{
	$nuevo="";
	$nuevo2="";	
	}

if(isset($_POST['go']))
	{
	if($_POST['go']=="1")
		{
		$actual=$_POST['actual'];
		$nuevo=$_POST['nuevo'];
		
		$pass=traedato("adm_usuarios","id",$IDU,"S","password");
		if(MD5($actual)!=$pass)
			{
			$conexio=conecta($IDBase);
			$msg="Error. La Contraseña Actual no coincide.";
			}
		else
			{
			#Cambiamos el password
			if(llevadato("adm_usuarios","id",$IDU,"S","password",MD5($nuevo),"N")=="OK")	
				{
				loguea("Usuarios",$IDU,"Cambio Password",$IDU,"Hubo un cambio de password del usuario '$IDName' por parte de '$IDUser'");
				$msg="Contraseña cambiada con Exito";
				}
			else
				$msg="Hubo un error al tratar de cambiar la Contraseña, intente de nuevo";
	
			}
		}		
	}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cambio de Contraseña</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript">

function cambiar()
	{
	if(document.edicion.actual.value=="")
		{alert("Por favor escriba la contraseña actual");
		document.edicion.actual.focus();
		return"0";}
	if(document.edicion.nuevo.value!=document.edicion.nuevo2.value)
		{alert("Las contraseñas no coinciden. Favor de revisar");
		document.edicion.nuevo.focus();
		return"0";}
	if(document.edicion.nuevo.value=="")
		{if(confirm("Su contraseña esta en blanco, esto NO es recomendable, ¿Continuar?"))
			document.edicion.submit();
		else
			return "0";}
	document.getElementById("divboton").innerHTML="<p align='center'><i class='fa fa-refresh fa-spin fa-2x'></i></p>";
	document.edicion.submit();		
	}


</SCRIPT>
</head>

<body topmargin="0" leftmargin="0">
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">
	<div class="row" style=" padding: 10px;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><? echo "<h3>Cambio de contraseña</h3>";  ?></td>
			<td width="33" align="right"><div id="divclose"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></div></td>
		</tr>
	</table>	
	</div>

<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">

	<tr>
		<td width="285" colspan="3" align="center"><b>
<? if($msg!="")
		{
		if(substr($msg,0,5)=="Error")
			echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$msg</div>";
		else
			echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>$msg</div>";
		}
?>
	</td>
	</tr>
	<tr>
		<td width="200" align="right" height="30">
		<font face="Arial" size="2">Contraseña Actual:</font></td>
		<td width="5" height="30">
			&nbsp;</td>
		<td height="30">
			<input type="password" name="actual" size="26" style="font-size: 12pt; color: #000080; font-family:Arial" <? echo "value='$nuevo'";?>></td>
	</tr>
	<tr>
		<td width="200" align="right" height="30">
		<font face="Arial" size="2">Contraseña Nueva:</font></td>
		<td width="5" height="30">
			&nbsp;</td>
		<td height="30">
			<input type="password" name="nuevo" size="26" style="font-size: 12pt; color: #000080; font-family:Arial" <? echo "value='$nuevo'";?>></td>
	</tr>
	<tr>
		<td width="200" align="right" height="30">
		<font face="Arial" size="2">Escriba de nuevo:</font></td>
		<td width="5" height="30">
		&nbsp;</td>
		<td height="30">
		<input type="password" name="nuevo2" size="26" style="font-size: 12pt; color: #000080; font-family:Arial" <? echo "value='$nuevo2'";?>></td>
	</tr>
	
</table>
<br>
<div id="divboton"><p align='center'><button type='button' onClick="cambiar();" class='btn btn-success'>Cambiar</button></p></div>

		<input type="hidden" name="go" value="1">
		</form>
</body>

</html>
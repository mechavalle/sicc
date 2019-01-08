<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");

#Vemos si esta logueado el usuario
session_name ("siccsession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
  {
  $idowner=$_SESSION['IDOwner'];  
  $IDU=$_SESSION['IDU'];
  $IDBase=$_SESSION['IDBase'];
  $IDUser=$_SESSION['IDUser'];
  $IDName=$_SESSION['IDName'];
  $Empresa=$_SESSION['Empresa'];
  $conexio=conecta($IDBase);
  $IDL=permiso("AdmUsuarios",$IDU);  
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
		$actual=md5($_POST['actual']);
		$nuevo=$_POST['nuevo'];
		$conexio=conecta("");
		#Verificamos contraseña actual
		$consulta="Select * from adm_usuarios where id='$IDU' and password='$actual' and status='1'";
		$res2 = mysqli_query($conexio,$consulta);
		if($val2=mysqli_fetch_array($res2))
			{
			if(llevadato("adm_usuarios","id",$IDU,"S","password",md5($nuevo),"N")=="OK")	
				$msg="Contraseña cambiada con Éxito";
			else
				$msg="Error al tratar de cambiar la Contraseña, intente de nuevo";
			}
		else
			$msg="Error en la contraseña actual, es incorrecta o usuario está deshabilitado";
		mysqli_free_result($res2);

		}		
	}
$done=0;
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<title>SICC - Contraseña</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery-2.1.1.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<link rel="stylesheet" href="../lib/style.css">
<SCRIPT LANGUAGE="JavaScript">

function cambiar()
	{
	if(document.edicion.actual.value=="")
		{
		alert("Proporcione su contraseña actual");
		document.edicion.actual.focus();
		return"0";
		}
	if(document.edicion.nuevo.value!=document.edicion.nuevo2.value)
		{
		alert("Las contraseñas no coinciden. Favor de revisar");
		document.edicion.nuevo.focus();
		return"0";
		}
	if(document.edicion.nuevo.value=="")
		{
		if(confirm("Su contraseña esta en blanco, esto NO es recomendable, ¿Continuar?"))
			document.edicion.submit();
		else
			return "0";
		}
	document.getElementById("divboton").innerHTML="<p align='center'><i class='fa fa-refresh fa-spin fa-2x'></i></p>";
	document.edicion.submit();		
	}


</SCRIPT>
</head>

<body topmargin="0" leftmargin="0">
<form method="POST" name="edicion" target="_self">
	<div class="container-fluid">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td><? echo "<h3>Cambio de contraseña</h3>";  ?></td>
				<td width="33" align="right"><div id="divclose"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></div></td>
			</tr>
		</table>	
	<? if($msg!="")
		{
		if(strtoupper(substr($msg,0,5))=="ERROR")
			echo "<div class='alert alert-danger'>$msg</div>";
		else
			{
			$done=1;
			echo "<div class='alert alert-success'>$msg</div>";
			}
		}
	?>
	<?if($done==0){?>
		<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
			<tr>
				<td width="140" align="right" height="30">
				<font face="Arial" size="2">Contraseña <b>Actual</b>:</font></td>
				<td width="5" height="30">
					&nbsp;</td>
				<td height="30">
					<input type="password" name="actual" class="cenboxfrm"></td>
			</tr>
			<tr>
				<td width="140" align="right" height="30">
				<font face="Arial" size="2">Contraseña <b>Nueva</b>:</font></td>
				<td width="5" height="30">
					&nbsp;</td>
				<td height="30">
					<input type="password" name="nuevo" class="cenboxfrm"></td>
			</tr>
			<tr>
				<td width="140" align="right" height="30">
				<font face="Arial" size="2">Escriba de nuevo:</font></td>
				<td width="5" height="30">
				&nbsp;</td>
				<td height="30">
				<input type="password" name="nuevo2" class="cenboxfrm"></td>
			</tr>	
		</table>
		<br>
		<div id="divboton"><p align='center'><button type='button' onClick="cambiar();" class='btn btn-success'>Cambiar</button></p></div>

		<?}?>
		<input type="hidden" name="go" value="1">
	</form>
</body>
</html>
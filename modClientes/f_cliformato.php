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
	$IDL=permiso("AdminClientesFor",$IDU);
		
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
############

function asigna($variable)
	{
	if(isset($_POST[$variable]))
		return $_POST[$variable];
	else
		return "";
	}

if(isset($_GET['id']))
	$id=$_GET['id'];
else
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		{ #va a ser nuevo		
		$id=-1;
		if(isset($_GET['idpersona']))
			$idpersona=$_GET['idpersona'];
		else
			{
			if(isset($_POST['idpersona']))
				$idpersona=$_POST['idpersona'];
			else
				{echo "falta idpersona"; 
				exit();
				}
			}		
		}
	}

if(isset($_GET['idformato']))
	$idformato=$_GET['idformato'];	
else
	{
	if(isset($_POST['idformato']))
		$idformato=$_POST['idformato'];
	else
		exit();
	}

$consulta="Select * from adm_documentos where identificador='$idformato'";
$res2 = mysqli_query($conexio, $consulta);
if($val5=mysqli_fetch_array($res2))
	{
	$descripcion=$val5['descripcion'];
	$archivo=$val5['archivo'];
	$tipo=$val5['tipo'];
	}
mysqli_free_result($res2);	

if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables

		$idpersona=$_POST['idpersona'];
		#$descripcion=$_POST['descripcion'];
		#$archivo=$_POST['archivo'];
		$persona=asigna("persona");
		$fechadoc=asigna("fechadoc");



		$puesto=asigna("puesto");
		$departamento=asigna("departamento");
		$actividades=asigna("actividades");
		$sueldodiario=asigna("sueldodiario");
		$jornada=asigna("jornada");
		$duracion=asigna("duracion");
		$fecha=asigna("fecha");
		$servicio=asigna("servicio");
		$honorarios=asigna("honorarios");		
		$lugar=asigna("lugar");
		
		if(Existe("ope_formatos","id",$id)=="NE")
			{
			$csql = "INSERT INTO `ope_formatos` (`idpersona`,`idformato`,`descripcion`,`puesto`,`departamento`,`actividades`,";
			$csql .="`honorarios`,`servicio`,`persona`,`duracion`,`sueldodiario`,`jornada`,`fecha`,`fechadoc`,`lugar`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$idpersona','$idformato','$descripcion','$puesto','$departamento','$actividades',";
			$csql .="'$honorarios','$servicio','$persona','$duracion','$sueldodiario','$jornada','$fecha','$fechadoc','$lugar',NOW(),'$IDUser');";
			}
		else
			{
			$csql = "UPDATE `ope_formatos` SET `idformato`='$idformato', `descripcion`='$descripcion', `puesto`='$puesto',`duracion`='$duracion',";
			$csql .="`departamento`='$departamento',`actividades`='$actividades', `sueldodiario`='$sueldodiario',`jornada`='$jornada',`fecha`='$fecha',`lugar`='$lugar', `ultactfec`=NOW(),";
			$csql .="`honorarios`='$honorarios',`servicio`='$servicio',`persona`='$persona',`fechadoc`='$fechadoc',`ultactusu`='$IDUser' ";
			$csql .="WHERE `id`='$id';";
			}
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio);
			exit(); }
		else
			{
			if($id=="-1")
				$id=mysqli_insert_id($conexio);
			}
	
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"wx=window.opener; wx.location.reload(); window.location.href='".$archivo."?id=$id'; \"></body></html>";
		exit();		
		}
		
	if($accion==5)
		{		
		$csql="delete from ope_formatos where id='$id'";
		mysqli_query($conexio, $csql);
		
		if(mysqli_error($conexio)!="") {
			echo "Error al borrar el registro. ".mysqli_error($conexio)."->";
			exit(); }
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\"wx=window.opener; wx.location.reload(); window.close(); \"></body></html>";
		exit();				
		}

	}
	
if($id!=-1)
	{
	$csql = "SELECT * from `ope_formatos` WHERE `id` = '$id';";
	$res2 = mysqli_query($conexio, $csql);
	if($val5=mysqli_fetch_array($res2))
		{
		$idpersona=$val5['idpersona'];
		$descripcion=$val5['descripcion'];
		$puesto=$val5['puesto'];
		$departamento=$val5['departamento'];
		$actividades=$val5['actividades'];
		$sueldodiario=$val5['sueldodiario'];
		$jornada=$val5['jornada'];
		$duracion=$val5['duracion'];
		$fecha=$val5['fecha'];
		$persona=$val5['persona'];
		$servicio=$val5['servicio'];
		$honorarios=$val5['honorarios'];
		$fechadoc=$val5['fechadoc'];
		$lugar=$val5['lugar'];
		$ultactfec=$val5['ultactfec'];
		$ultactusu=$val5['ultactusu'];
		$ultima=fixfecha($ultactfec)." por $ultactusu";
		}
	mysqli_free_result($res2);
	}
else
	{
	$puesto="";
	$departamento="";
	$actividades="";
	$sueldodiario="";
	$jornada="";
	$duracion="";
	$persona="";
	$servicio="";
	$honorarios="";
	$fechadoc="";
	$lugar="";
	$fecha="";
	$ultima="";
	}

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Formato</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="../lib/calendar/calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../lib/calendar/calendar.js?random=20060118"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/stlinks.css">

<SCRIPT LANGUAGE="JavaScript">

function siguiente() 
	{
	document.edicion.accion.value=1;
	document.edicion.submit();
	}

function eliminar()
	{
	if(confirm('¿Desea eliminar permanantemente este formato?'))
		{
		document.edicion.accion.value=5;
		document.edicion.submit();
		}
	}

</SCRIPT>

</head>


<body>
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">
	<div class="row" style=" padding: 10px;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><? echo "<h4>$descripcion</h4>";  ?></td>
			<td width="33" align="right"><div id="divclose"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></div></td>
		</tr>
	</table>	
	</div>

<?
if($id>0)
	echo "<button type='button' onClick=\"eliminar();\" class='btn btn-danger btn-xs'>Eliminar Formato</button>";
?>

<?if($tipo==0)
	echo "<p align='center'><h5><font color='#808080'>No es necesario ningún dato para continuar.</font></h5></p>";
?>

<?if($tipo==1){?>

<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Formato:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" class="cenboxfrmmin" <?echo "value='$fecha'"?>>&nbsp;<a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><span class="glyphicon glyphicon-calendar" style="font-size: 15px;"></span> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Lugar:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="lugar" class="cenboxfrm" <?echo "value='$lugar'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Persona que firma:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="persona" class="cenboxfrm" <?echo "value='$persona'"?>></td>
	</tr>	
</table>
<?}?>

<?if($tipo==2){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Inicio de Obra:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" class="cenboxfrmmin" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Final de Obra:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fechadoc" class="cenboxfrmmin" <?echo "value='$fechadoc'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fechadoc,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
</table>
<?}?>

<?if($tipo==3){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Firma:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Lugar:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="lugar" class="cenboxfrm" <?echo "value='$lugar'"?>></td>
	</tr>
</table>
<?}?>

<?if($tipo==4){?>

<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Firma:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>	
</table>
<?}?>

<?if($tipo==5){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Contratación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Puesto:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="puesto" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$puesto'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Departamento:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="departamento" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$departamento'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Actividades:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="actividades" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$actividades'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Sueldo Diario:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="sueldodiario" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$sueldodiario'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Jornada:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="jornada" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$jornada'"?>></td>
	</tr>
</table>
<?}?>

<?if($tipo==6){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Contratación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Puesto:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="puesto" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$puesto'"?>></td>
	</tr>
</table>
<?}?>

<?if($tipo==7){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Terminación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
</table>
<?}?>


<?if($tipo==8){?>

<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Contratación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Puesto:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="puesto" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$puesto'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Departamento:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="departamento" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$departamento'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Actividades:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="actividades" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$actividades'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Sueldo Diario:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="sueldodiario" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$sueldodiario'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Jornada:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="jornada" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$jornada'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Actividades:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="actividades" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$actividades'"?>></td>
	</tr>
</table>

<?}?>

<?if($tipo==9){?>

<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Contratación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Puesto:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="puesto" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$puesto'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Departamento:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="departamento" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$departamento'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Sueldo Diario:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="sueldodiario" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$sueldodiario'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Jornada:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="jornada" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$jornada'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Actividades:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="actividades" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$actividades'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25">
		<font face="Arial" size="2">Duración:</font></td>
		<td width="10" align="left" height="25">
		&nbsp;</td>
		<td align="left" height="25">
		<input type="text" name="duracion" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$duracion'"?>></td>
	</tr>
</table>
<?}?>

<?if($tipo==10){?>

<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Contratación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Servicio a Proporcionar:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="servicio" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$servicio'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Honorarios:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="honorarios" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$honorarios'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Lugar de Trabajo:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="lugar" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$lugar'"?>></td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha de Firma:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fechadoc" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fechadoc'"?>></td>
	</tr>
</table>
<?}?>

<?if($tipo==11){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Contratación:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fecha" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Renuncia:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="fechadoc" size="13" style="font-family: Verdana; font-size: 8pt" <?echo "value='$fechadoc'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fechadoc,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a> </td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Puesto:</font></td>
		<td width="10" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
		<input type="text" name="puesto" size="43" style="font-family: Verdana; font-size: 8pt" <?echo "value='$puesto'"?>></td>
	</tr>
</table>
<?}?>

<?if($tipo==12){?>
<table border="0" width="90%" id="table3" cellspacing="0" cellpadding="0">
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Fecha Entrega:</font></td>
		<td width="5" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
			<input type="text" name="fecha" class="cenboxfrmmin" <?echo "value='$fecha'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].fecha,'yyyy-mm-dd',this);"><img border="0" src="../img/calendar.gif" width="16" height="15"></a>
		</td>
	</tr>
	<tr>
		<td width="147" align="right" height="25" bordercolor="#FFFF99">
		<font face="Arial" size="2">Uniforme Entregado:</font></td>
		<td width="5" align="left" height="25" bordercolor="#FFFF99">
		&nbsp;</td>
		<td align="left" height="25" bordercolor="#FFFF99">
			<textarea name="actividades" class="cenboxfrm" style="height: 100px;"><? echo $actividades;?></textarea>
		</td>
	</tr>	
</table>
<?}?>


<br>
<p align="center">
	<button type='button' onClick="siguiente();" class='btn btn-success'>Siguiente &gt;&gt;</button>
</p>

<input type="hidden" name="idpersona" <?echo "value='$idpersona'";?>>
<input type="hidden" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="idformato" <?echo "value='$idformato'";?>>
<input type="hidden" name="accion" value="0">
</div></form>

</body>

</html>
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

	$IDL=permiso("AdminClientes",$IDU);
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
		}
	}

$numopeauto=traedato("adm_parametros","parametro","numopeauto","N","valor");	
if($numopeauto<0)
	{
	echo "Error al tratar de recuperar información de configuración";
	exit();
	}



if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$idcli=asigna("idcli");
		
		$nombre=$_POST['nombre'];
		$apellidop=$_POST['apellidop'];
		$apellidom=$_POST['apellidom'];		
		$nacimiento=$_POST['nacimiento'];
		$rfc=$_POST['rfc'];
		$asesor=$IDName;		
		$status="1";
		
		if(Existe("cat_clientes","id",$id)=="NE")
			{
			if($numopeauto==1)
				{
				$idcli=traedato2("select max(cast(idcli as SIGNED)) as mas from cat_clientes","mas");
				if($idcli=="-1")
					$idcli="000001";
				else
					{$idcli +=1;
					$idcli=completa($idcli,"0",6,"S");}
				}
			$csql = "INSERT INTO `cat_clientes` (`idcli`,`nombre`,`apellidop`,`apellidom`,`ecivil`,";
			$csql .="`rfc`,`nacimiento`,`nacionalidad`,`asesor`,`fecha`,`owner`,`status`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$idcli','$nombre','$apellidop','$apellidom','Soltero',";
			$csql .="'$rfc','$nacimiento','México','$IDName','".date("Y-m-d h:i:s")."','$IDUser','$status',NOW(),'$IDUser');";
			}
	
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		else
			{
			if($id=="-1")
				$id=mysqli_insert_id($conexio);
			}

		#docsmust
		###directorio
		$consulta="select * from adm_archivos where modulo='clientes'";
		$resx = mysqli_query($conexio, $consulta);
		if($val=mysqli_fetch_array($resx))
			{
			$laruta="../".$val['ruta'];
			$latabla=$val['tabla'];
			}
		else
			{
			echo "Error: El modulo enviado (clientes) no existe";
				exit();
			}
		mysqli_free_result($resx);

		if($laruta==-1)
			echo "<br><font color='#ff0000'><b>ERROR</b> No existe ruta para los archivos";
		if($latabla==-1)
			echo "<br><font color='#ff0000'><b>ERROR</b> No existe tabla para los archivos";


		$consulta="Select * from cat_docsmust where status='1' order by descripcion asc";
		$res = mysqli_query($conexio, $consulta);
		$i=0;
		while($val8=mysqli_fetch_array($res))
			{
			$i +=1;
			$aid=$val8['id'];
			$adescripcion=$val8['descripcion'];
			$csql = "INSERT INTO `$latabla` ( `idorigen` ,`iddoc` , `tipo` , `archivo` , `tipoarchivo` , `tamaarchivo` , `fecha` , ";
			$csql .="`descripcion` , `comentario` , `ultactfec` , `ultactusu` ) ";
			$csql .= "VALUES ('$id','$aid','must','','','','',";
			$csql .="'$adescripcion','','','$IDUser')";
			mysqli_query($conexio,$csql);
			if(mysqli_error($conexio)!=""){
				echo "Error al actualizar el must: ".mysqli_error($conexio)."->$csql";
				exit();}
			}
		mysqli_free_result($res);

		$csql="UPDATE cat_clientes set docmust='$i' where id='$id'";
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!=""){
			echo "Error al actualizar el must: ".mysqli_error($conexio)."->$csql";
			exit();}


		## Origen de los recursos
			$csql = "INSERT INTO `rel_recursos` (`tipo`,`idcliente`,`idrecurso` ) VALUES ('1','$id','1');";
				mysqli_query($conexio, $csql);
				if(mysqli_error($conexio)!="") {
					echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
					exit(); }

		## Destino de los recursos
			$csql = "INSERT INTO `rel_recursos` (`tipo`,`idcliente`,`idrecurso` ) VALUES ('2','$id','19');";
				mysqli_query($conexio, $csql);
				if(mysqli_error($conexio)!="") {
					echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
					exit(); }

		#Fin guardado
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.location.href='f_cliente.php?id=$id'; \"></body></html>";
		exit();		
		
		
	}
}

$idper="(sin guardar)";			
$nombre="";
$apellidop="";
$apellidom="";
$nacimiento="";
$rfc="";
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crear Cliente</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/boot/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="../lib/calendar/calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../lib/calendar/calendar.js?random=20060118"></script>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<SCRIPT LANGUAGE="JavaScript">

function guardar() 
	{
	if(document.edicion.nombre.value=="")
		{
		alert('Especifique el Nombre');
		document.edicion.nombre.focus();
		return "0";
		}
	if(document.edicion.apellidop.value=="")
		{
		alert('Especifique el Apellido Paterno');
		document.edicion.apellidop.focus();
		return "0";
		}
	if(document.edicion.apellidom.value=="")
		{
		alert('Especifique el Apellido Materno');
		document.edicion.apellidom.focus();
		return "0";
		}
	if(document.edicion.nacimiento.value=="")
		{
		alert('Especifique la fecha de Nacimiento');
		return "0";
		}
	if(document.edicion.rfc.value=="")
		{
		alert('Especifique el RFC');
		document.edicion.rfc.focus();
		return "0";
		}
	
	conexion1=crearXMLHttpRequest();
  	conexion1.onreadystatechange = prorevisa;
  	conexion1.open("GET", "f_e_revisa.php?id="+document.edicion.id.value+"&rfc="+document.edicion.rfc.value+"&ahora="+hoy(true), true);
  	conexion1.send(null);
	
	}

function prorevisa()
	{
	if(conexion1.readyState == 4)
  		{
    	if(Left(conexion1.responseText,2)!="OK")
    		{
    		alert (conexion1.responseText);
    		return "0";
    		}
    	else
    		{
			document.edicion.nacimiento.disabled=false;
			document.edicion.nombre.disabled=false;
			document.edicion.apellidop.disabled=false;
			document.edicion.apellidom.disabled=false;
			document.edicion.nacimiento.disabled=false;
			document.edicion.rfc.disabled=false;	
			document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";		
			document.edicion.accion.value=1;
			document.edicion.submit();
			}
		}
	}


function calculaedad()
	{
	//alert(document.edicion.nacimiento.value);
	if(document.edicion.nacimiento.value!="0000-00-00" && document.edicion.nacimiento.value!="")
		{
		conexion1=crearXMLHttpRequest();
	 	conexion1.onreadystatechange = procalculaedad;
		conexion1.open("GET", "f_e_calculaedad.php?fecha="+document.edicion.nacimiento.value+"&hoy="+hoy(true), true);
		conexion1.send(null);
		}
	}
	
function procalculaedad()
{
  if(conexion1.readyState == 4)
  {
    if(Left(conexion1.responseText,5)=="ERROR")
    	{
    	alert (conexion1.responseText);
    	}
    else{
    	var res=String(conexion1.responseText);
    	document.getElementById("divedad").innerHTML=res+" años";
    	}
  } 
}

function alcargar()
	{
	/*document.edicion.tipo.disabled=true;
	document.edicion.nombre.disabled=true;
	document.edicion.apellidop.disabled=true;
	document.edicion.apellidom.disabled=true;
	document.edicion.nacimiento.disabled=true;
	document.edicion.rfc.disabled=true;*/
	}

</SCRIPT>

</head>


<body onload="alcargar();">

<form method="POST" name="edicion" target="_self">

<div class="container">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h3><font face="Arial">Nuevo Cliente</font></h3></td>
			<td width="30" align="right">			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>		
	</table>

<br>
<div id="divboton">
<button type='button' onClick="guardar();" class='btn btn-success btn-xs'>Guardar</button>
</div>

<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">

			<tr>
				
				<td align="right" height="22">
				<font face="Arial" size="2">Nombre (s):</font></td>
				<td width="5" align="left" height="22">

				&nbsp;</td>
				<td width="603" align="left" height="22">
				<font color="#000080">
				<input type="text" name="nombre" class="cenboxfrm" <?echo "value='$nombre'"?>></font></td>
				
			</tr>
			<tr>
				
				<td align="right" height="22">
				<font face="Arial" size="2">Apellido Paterno:</font></td>
				<td width="5" align="left" height="22">

				&nbsp;</td>
				<td width="603" align="left" height="22">
				<input type="text" name="apellidop" class="cenboxfrm" <?echo "value='$apellidop'"?>></td>
				
			</tr>
			<tr>
				<td align="right" height="22">
				<font face="Arial" size="2">Apellido Materno:</font></td>
				<td width="5" align="left" height="22">

				&nbsp;</td>
				<td width="603" align="left" height="22">
				<input type="text" name="apellidom" class="cenboxfrm" <?echo "value='$apellidom'"?>></td>
				
			</tr>
			<tr>
				
				<td align="right" height="22">
				<font face="Arial" size="2">Fecha Nacimiento:</font></td>
				<td width="5" align="left" height="22">

				&nbsp;</td>
				<td width="603" align="left" height="22">
				<input type="text" id="nacimiento" name="nacimiento" class="cenboxfrmmin" <?echo "value='$nacimiento'"?> disabled><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].nacimiento,'yyyy-mm-dd',this);"><span class="glyphicon glyphicon-calendar" style="font-size: 15px;"></span></a>
				</td>
				
			</tr>
			<tr>
				
				<td align="right" height="22">
				<font face="Arial" size="2">Edad:</font></td>
				<td width="5" align="left" height="22">

				&nbsp;</td>
				<td width="603" align="left" height="22">
				<table border="0" width="100%" id="table9" cellspacing="0" cellpadding="0">
					<tr>
						<td width="56"><font face="Arial" size="2"><div id="divedad">-</div></font></td>
						<td><font face="Arial" size="2">
						<a href="#" onclick="calculaedad();"><img border="0" src="../img/actualizar.gif" width="16" height="16"></a></font></td>
					</tr>
				</table>
				</td>
				
			</tr>
			<tr>
				
				<td align="right" height="22">
				<font face="Arial" size="2">RFC:</font></td>
				<td width="5" align="left" height="22">

				&nbsp;</td>
				<td width="603" align="left" height="22">
				<input type="text" name="rfc" maxlength="13" class="cenboxfrm" <?echo "value='$rfc'"?>></td>
				
			</tr>
				
			
			</table>

<input type="hidden" name="id" <?echo "value='$id'"?>>
<input type="hidden" name="accion" value="0">
</div></form>

</body>

</html>
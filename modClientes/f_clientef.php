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
	$IDL2=permiso("AdminClientesArc",$IDU);
	$IDL3=permiso("AdminClientesFor",$IDU);
	$IDL4=permiso("AdminClientesLog",$IDU);
	$IDL5=permiso("AdminClientesCom",$IDU);
	$IDL6=permiso("AdminClientesInt",$IDU);
	$IDL7=permiso("AdminClientesAse",$IDU);
	$IDL8=permiso("AdminClientesPto",$IDU);

	if($IDL3<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
		exit();
		}
	if($IDL3<1)
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
		exit();
		}
	}

$csql = "SELECT * from `cat_clientes` WHERE `id` = '$id'";		
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];			
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$status=$val5['status'];			
	}
mysqli_free_result($res2);


?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Consultar Capital Humano</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<SCRIPT LANGUAGE="JavaScript">
function editar() 
	{
	window.location.href="f_operadorc.php?id="+document.edicion.id.value;
	}
</SCRIPT>

</head>


<body style="background-attachment: fixed">

<form method="POST" name="edicion" target="_self">

<div class="container-fluid">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h3><font face="Arial">Cliente</font></h3></td>
			<td width="33" align="right">			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
		<tr>
			<td colspan="2"><h4><font face="Arial" color="#000080"><? echo "$idcli $nombre";?></font></h3></td>			
		</tr>
	</table>
<?
echo "<ul class='nav nav-tabs'>";
echo "<li><a href='f_clienter.php?id=$id'>General</a></li>";
if($IDL8>0)
	echo "<li><a href='f_clientep.php?id=$id'>Presupuesto de Obra</a></li>";
if($IDL2>0)
	echo "<li><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
echo "<li class='active'><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
if($IDL4>0)
	echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
echo "</ul><br>";


?>


<h4><font face="Arial">Formatos</font></h4>
<? if($IDL3>=2)
	echo "<button type='button' onClick=\"abre('adddoc','f_documento.php?idpersona='+document.edicion.id.value,800,600,'YES');\" class='btn btn-success btn-xs'>Agregar Nuevo</button>";
?>						
				<table class="table table-condensed">
				<thead>
					<tr>
						<td><font face="Arial" size="2"><b>Formato</b></font></td>
						<td><font face="Arial" size="2"><b>Última actualización</b></font></td>						
					</tr>
				</thead>
				<tbody>
					<?
					$consulta="Select * from ope_formatos where idpersona='$id' order by fecha desc";
					$res = mysqli_query($conexio, $consulta);
					while($val8=mysqli_fetch_array($res))
						{
						$vid=$val8['id'];
						$vdescripcion=$val8['descripcion'];
						$vfecha=fixfecha($val8['ultactfec'])." por ".$val8['ultactusu'];
						
							
						$archivo=traedato("adm_documentos","identificador",$val8['idformato'],"N","archivo");
						if($archivo!="" && $archivo!="-1")
							$link="<a href='#' onclick=\"abre('documento','$archivo?id=$vid',800,600,'NO');\">";
						else	
							$link="";
							
						if($val8['idformato']!="" && $IDL2>=3)
							$link2="<br><button type='button' onClick=\" abre('documento','f_cliformato.php?idformato=".$val8['idformato']."&id=$vid',800,600,'NO'); \" class='btn btn-primary btn-xs'>Editar</button>";
						else
							$link2="";	
						echo "<tr>
						<td>$link<font face='Arial' size='2' color='#000000'>$vdescripcion</font></a>$link2</td>
						<td>$link<font face='Arial' size='2' color='#000000'>$vfecha</font></a></td>
					
						</tr>";

						}
					mysqli_free_result($res);
					?>					
					
				</tbody>	
				</table>
<input type="hidden" name="id" <?echo "value='$id'"?>>
<input type="hidden" name="accion" value="0">
</div></form>

</body>

</html>
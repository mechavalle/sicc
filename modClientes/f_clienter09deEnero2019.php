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


	if($IDL<0)
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
		exit();
	}


if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	

	if($accion==4)
		{
		$comentario=$_POST['comentario'];
		$idcom=$_POST['idcom'];
		$logmsg="";
		if($idcom==0)
			{
			$csql = "INSERT INTO `ope_clientecoms` (`idorigen`,`tipo`,`descripcion`,`fecha`,`usuario`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$id','0','$comentario','".date("Y-m-d H:i:s")."','$IDUser','".date("Y-m-d H:i:s")."','$IDUser');";
			$logmsg .="Comentario nuevo: '$comentario''. ";
			}
		else
			{
			$actcomentario=traedato("ope_clientecoms","id",$idcom,"S","descripcion");
			$csql = "UPDATE `ope_clientecoms` SET `idorigen`='$id', `descripcion`='$comentario',`ultactfec`='".date("Y-m-d H:i:s")."', `ultactusu`='$IDUser' WHERE `id`='$idcom';";
			$logmsg .="Cambio un Comentario, de '$actcomentario' a '$comentario'. ";
			}
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		lognow("log_clientes",$id,1,$IDUser,$logmsg);
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" window.location.href='f_clienter.php?id=$id'; \"></body></html>";
		exit();	
		}


	if($accion==6)
		{
		$idcom=$_POST['idcom'];
		$logmsg="";
		if($idcom>0)
			{
			$actcomentario=traedato("ope_clientecoms","id",$idcom,"S","descripcion");
			$csql = "DELETE FROM `ope_clientecoms` where `id`='$idcom';";
			$logmsg .="Borrado del Comentario '$actcomentario'. ";
			}
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		lognow("log_clientes",$id,5,$IDUser,$logmsg);
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" window.location.href='f_clienter.php?id=$id'; \"></body></html>";
		exit();	
		}

	if($accion==7)
		{
		$integranew=$_POST['integranew'];
		$actintegradora=traedato("cat_clientes","id",$id,"S","integradora");
		if($integranew!=$actintegradora)
			{
			$csql = "update cat_clientes set integradora='$integranew',ultactfec='".date("Y-m-d h:i:s")."',ultactusu='$IDUser' where `id`='$id'";		
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$logmsg="Actualización de Integradora de $actintegradora a $integranew.";
			lognow("log_clientes",$id,5,$IDUser,$logmsg);
			#echo $csql;
			echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_clienter.php?id=$id'; \"></body></html>";
			exit();	
			}
		}

	if($accion==8)
		{
		$asesornew=$_POST['asesornew'];
		$actasesor=traedato("cat_clientes","id",$id,"S","asesor");
		if($asesornew!=$actasesor)
			{
			$csql = "update cat_clientes set asesor='$asesornew',ultactfec='".date("Y-m-d h:i:s")."',ultactusu='$IDUser' where `id`='$id'";		
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$logmsg="Actualización de Asesor de $actasesor a $asesornew.";
			lognow("log_clientes",$id,5,$IDUser,$logmsg);
			#echo $csql;
			echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_clienter.php?id=$id'; \"></body></html>";
			exit();	
			}
		}
		
	}
	
$csql = "SELECT * from `cat_clientes` WHERE `id` = '$id';";
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$rfc=$val5['rfc'];
	$curp=$val5['curp'];
	$nss=$val5['nss'];			
	$nacimiento=fixfecha($val5['nacimiento']);
	$edad=calcular_edad($val5['nacimiento']);
	$nacionalidad=$val5['nacionalidad'];
	$ecivil=$val5['ecivil'];
	$fecha=fixfecha($val5['fecha']);
	$fechafin=fixfecha($val5['fechafin']);
	$genero=$val5['genero'];
	$idextranjero=$val5['idextranjero'];
	$estadonac=$val5['estadonac'];
	$escolaridad=$val5['escolaridad'];
	$domicilio=$val5['calle'].", ".$val5['numero'].". ".$val5['colonia'].", ".$val5['municipio'].". ".$val5['estado'].", ".$val5['cp'];
	$domiciliof=$val5['callef'].", ".$val5['numerof'].". ".$val5['coloniaf'].", ".$val5['municipiof'].". ".$val5['estadof'].", ".$val5['cpf'];
	$oficina=$val5['oficina'];
	$celular=$val5['celular'];
	$telefonos=$val5['telefonos'];
	$email=$val5['email'];

	$profesion=$val5['profesion'];
	$ocupacion=$val5['ocupacion'];
	$fuentei=$val5['fuentei'];
	$procedencia=$val5['procedencia'];
	$puestopolitico=$val5['puestopolitico'];

	$recursosori=$val5['recursosori'];
	$recursosdes=$val5['recursosdes'];

	$valorampliacion=fixmontosin($val5['valorampliacion']);
	$valorregla=fixmontosin($val5['valorregla']);
	$valorneto=fixmontosin($val5['valorneto']);

	$integradora=$val5['integradora'];
	$asesor=$val5['asesor'];

	$idbanco=$val5['idbanco'];
	if($idbanco=="")
		$idbancov="-";
	else
		$idbancov=traedato("cat_instituciones","id",$idbanco,"S","descripcion");
	$cuenta=$val5['cuenta'];
	$clabe=$val5['clabe'];
	$beneficiario=$val5['beneficiario'];

	$propietariorv=$val5['propietarior'];
	if($propietariorv=="")
		$propietariorv="-";

	$owner=$val5['owner'];
		
	$status=$val5['status'];
	$statusv=traedato("cat_statuscliente","id",$status,"S","descripcion");
				
	$ultactfec=$val5['ultactfec'];
	$ultactusu=$val5['ultactusu'];
	$ultima=fixfecha($ultactfec)." por $ultactusu";
	}
mysqli_free_result($res2);

#relaciones
$consulta="select * from rel_recursos where idcliente='$id'";
$arrdato=array();
$arrrecu=array();
$resx = mysqli_query($conexio,$consulta);
while($val=mysqli_fetch_array($resx))
	{
	$arrdato[0]=$val['idrecurso'];
	$arrdato[1]=$val['tipo'];
	array_push($arrrecu,$arrdato);
	}
mysqli_free_result($resx);
$cr=count($arrrecu);

function erecu($tipo,$idrecurso)
	{
	global $arrrecu;
	global $cr;
	$res=0;
	for($i=0;$i<$cr;$i++)
		{
		if($arrrecu[$i][0]==$idrecurso && $arrrecu[$i][1]==$tipo)
			{
			$res=1;
			$i=$cr;
			}
		}	
	return $res;
	}
#asesores nuevos
$consulta="select a.nombre from adm_usuarios a left join adm_permisos as b on a.id=b.idusuario where b.modulo='AdminClientes' and b.tipo>='2' and a.status='1'";
$asesornewv="";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	$asesornewv .="<option value='".$val['nombre']."'>".$val['nombre']."</option>";
mysqli_free_result($resx);

#integradoras nuevos
$consulta="select * from cat_integradoras where status='1'";
$integranewv="";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	$integranewv .="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
mysqli_free_result($resx);
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Consultar Cliente</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/popup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

function editar() 
	{
	window.location.href="f_cliente.php?id="+document.edicion.id.value;	
	
	}

function nuevocom()
	{
	document.edicion.idcom.value=0;
	Popup.showModal('modal6');
	}
	
function guardarcom()
	{
	document.edicion.accion.value=4;
	document.edicion.submit();
	}

function editacom(cid,cdescripcion)
	{
	document.edicion.idcom.value=cid;
	document.edicion.comentario.value=cdescripcion;
	Popup.showModal('modal6');
	}
function borrarcom(cid)
	{
	if(confirm('Se borrará este comentario, ¿continuar?'))
		{
		document.edicion.idcom.value=cid;
		document.edicion.accion.value=6;
		document.edicion.submit();
		}
	}
function seleccionadestino()
	{
	abre('seldestino','f_selcch.php?destino=cc',550,500,'YES');
	}

function cambiarintegra()
	{
	if(document.edicion.integranew.options[document.edicion.integranew.selectedIndex].value=="")
		{
		alert("seleccione una integradora para continuar");
		return 0;
		}
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=7;
	document.edicion.submit(); 			
	}

function cambiarasesor()
	{
	if(document.edicion.asesornew.options[document.edicion.asesornew.selectedIndex].value=="")
		{
		alert("seleccione un asesor para continuar");
		return 0;
		}
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=8;
	document.edicion.submit(); 			
	}
</SCRIPT>

</head>


<body onload="alcargar();">
	<form method="POST" name="edicion" target="_self">
		<div class="container-fluid">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td><h3><font face="Arial">Consultar Cliente</font></h3></td>
					<td width="33" align="right">	
					<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
				</tr>
				<tr>
					<td colspan="2"><h4><font face="Arial" color="#000080"><? echo "$idcli $nombre";?></font></h3></td>			
				</tr>
			</table>

			<?
			echo "<ul class='nav nav-tabs'>
				<li class='active'><a href='f_cliente.php?id=$id'><b>General</b></a></li>";
			if($id>0)
				{
				if($IDL2>0)
					echo "<li><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
				if($IDL3>0)
					echo "<li><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
				if($IDL4>0)
					echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
				}
			echo "</ul>";
			?>

			<br>
			<div class="row">
				<div class="col-sm-12">
					<div id="divboton">
						<button type='button' onClick="editar();" class='btn btn-primary btn-xs'>Editar</button>
						<?				
						if($IDL7>=1)
							echo "&nbsp;<button type='button' onClick=\"Popup.showModal('modal5');\" class='btn btn-warning btn-xs'>Cambiar Asesor</button>";
						
						if($IDL6>=1)
							echo "&nbsp;<button type='button' onClick=\"Popup.showModal('modal4');\" class='btn btn-warning btn-xs'>Cambiar Integradora</button>";
						?>
						
					</div>
				</div>	
			</div>
			<div class="well well-sm">
				<div class="row">
					<div class="col-sm-6">
						<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">ID:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<? echo "<b><font face='Arial' size='2' color='#000080'>$idcli</font></b>";
									?>				
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Asesor:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $asesor;?></font></b>			
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Captura:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $fecha;?></font></b>			
								</td>
							</tr>
						</table>
					</div>
					<div class="col-sm-6">
						<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
							<tr>
								<td  width="150" align="right" height="22"><font face="Arial" size="2">Status:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<font face="Arial" size="2" color="#ff0000"><b><? echo $statusv; ?></b></font>				
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Integradora:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $integradora;?></font></b>			
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Creador:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $owner;?></font></b>			
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Nombre (s):</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $nombre; ?></b></font>
							</td>
						</tr>
						
					
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Fecha Nacimiento:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $nacimiento; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Edad:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><? echo $edad;?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">RFC:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $rfc; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">CURP:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $curp; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">NSS:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $nss; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Género:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $genero; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">E-mail:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $email; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Teléfono:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $telefonos; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Teléfono Oficina:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $oficina; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Celular:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $celular; ?></b></font>
							</td>							
						</tr>
					</table>
				</div>
				<div class="col-sm-6">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">						
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Escolaridad:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $escolaridad; ?></b></font>
							</td>							
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Estado Civil:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $ecivil; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Páis de Nacimiento:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $nacionalidad; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Estado de Nacimiento:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $estadonac; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">No. Identificación Fiscal (en caso de ser extranjero):</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $idextranjero; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Profesión:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $profesion; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Ocupación:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $ocupacion; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Fuente principal de Ingresos:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $fuentei; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Procedencia de recursos fideicomitidos:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $procedencia; ?></b></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Puesto político que ocupa o ha ocupado:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $puestopolitico; ?></b></font>
							</td>
						</tr>
					</table>
				</div>
			</div>

		
		
		<br>		
		<div class="row">
			<div class="col-sm-6">	
				<h4><font face="Arial">Domicilio Fiscal</font></h4>	
				<div class="subr">			
					<font face="Arial" size="2"><b><?echo $domiciliof; ?></b></font>
				</div>
			</div>
			<div class="col-sm-6">	
				<h4><font face="Arial">Domicilio Particular</font></h4>	
				<div class="subr">			
					<font face="Arial" size="2"><b><?echo $domicilio; ?></b></font>
				</div>
			</div>
		</div>

		<br>
		<h4><font face="Arial">Recursos de la cuenta</font></h4>
		<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
			<tr>
				<td width="200" align="right" height="22">
					<font face="Arial" size="2">Origen de recursos a manejar:</font></td>
				<td width="5" align="left" height="22">&nbsp;</td>

				<td class="subr" align="left" height="22">	
					<font face="Arial" size="2"><b><?echo $propietariorv; ?></b></font>												
				</td>				
			</tr>
		</table>

		<div class="row">
			<div class="col-sm-6">
				<h5>Origen de recursos</h5>
				<div class="row">
					<div class="col-sm-12">
						<?				

						#Ingresos
						$actrecori="0";
						$consulta="select * from cat_recursos where tipo='1' and status='1' order by orden";					
						echo "<table border='0' width='100%' id='table3' cellspacing='0' cellpadding='0'>";
						$resx = mysqli_query($conexio,$consulta);
						while($val=mysqli_fetch_array($resx))
							{
							if(erecu(1,$val['id'])==1)
								{								
								echo "<tr><td width='10'><span class='glyphicon glyphicon-hand-right'></span></td><td  class='subr'width='150' height='22'><font face='Arial' size='2'>".$val['descripcion']."</font></td></tr>";
								}			
							}
						mysqli_free_result($resx);
						if($recursosori!="")
							echo "<tr><td width='10'><span class='glyphicon glyphicon-hand-right'></span></td><td  class='subr'width='150' height='22'><font face='Arial' size='2'><b>Otro: </b>$recursosori</font></td></tr>";

						echo "</table>";
						?>
					</div>
					
				</div>

			</div>
			<div class="col-sm-6">
				<h5>Destino de recursos</h5>
				<div class="row">
					<div class="col-sm-12">
						<?				

						#Egresos
						$actrecdes="0";
						$consulta="select * from cat_recursos where tipo='2' and status='1' order by orden";					
						echo "<table border='0' width='100%' id='table3' cellspacing='0' cellpadding='0'>";
						$resx = mysqli_query($conexio,$consulta);
						while($val=mysqli_fetch_array($resx))
							{
							if(erecu(2,$val['id'])==1)
								echo "<tr><td width='10'><span class='glyphicon glyphicon-hand-right'></span></td><td class='subr' width='150' height='22'><font face='Arial' size='2'>".$val['descripcion']."</font></td></tr>";
							//echo $val['descripcion']."<br>";				
							}
						mysqli_free_result($resx);
						if($recursosdes!="")
							echo "<tr><td width='10'><span class='glyphicon glyphicon-hand-right'></span></td><td class='subr' width='150' height='22'><font face='Arial' size='2'><b>Otro: </b>$recursosdes</font></td></tr>";
						echo "</table>";
						?>
					</div>
					
				</div>

			</div>
		</div>

		<br>
		<div class="row">
			<div class="col-sm-6">
				<h4><font face="Arial">Monto a solicitar</font></h4>
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Valor ampliación, remodelación o mejora:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $valorampliacion; ?></b></font>
							</td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Monto según reglas:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $valorregla; ?></b></font>
							</td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">El solicitante contaría con:</font></td>
							<td width="5" align="left" height="22" >&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $valorneto; ?></b></font>
							</td>				
						</tr>						
					</table>
				</div>
			<div class="col-sm-6">
				<h4><font face="Arial">Información Bancaria</font></h4>
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Institución Bancaria:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $idbancov; ?></b></font>
							</td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Número de Cuenta:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $cuenta; ?></b></font>
							</td>			
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">CLABE Interbancaria:</font></td>
							<td width="5" align="left" height="22" >&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $clabe; ?></b></font>
							</td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Beneficiario:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td class="subr" align="left" height="22">
								<font face="Arial" size="2"><b><?echo $beneficiario; ?></b></font>
							</td>			
						</tr>
					</table>
				</div>
			</div>


				

		

	
<?

if($IDL5>0){?>		
<p>&nbsp;</p>
<h4><font face="Arial">Comentarios</font></h4>
<? if($IDL5>=2)
	echo "<button type='button' onClick=\"nuevocom();\" class='btn btn-success btn-xs'>Agregar Comentario</button>";
?>

<table class="table table-condensed">
	<thead>
      <tr>
        <th><font face="Arial" size="2">Comentario</font></th>
        <th><font face="Arial" size="2">Creación</font></th>
        <th><font face="Arial" size="2">Actualización</font></th>
      </tr>
    </thead>
    <tbody>
   
<?

					$consulta="Select * from ope_clientecoms where idorigen='$id' order by fecha desc";
					$res = mysqli_query($conexio, $consulta);
					while($val8=mysqli_fetch_array($res))
						{
						$cid=$val8['id'];
						$cdescripcion=$val8['descripcion'];
						$cfecha=fixfecha($val8['fecha'])."<br>por ".$val8['usuario'];
						$cact=fixfecha($val8['ultactfec'])."<br> por ".$val8['ultactusu'];
						$clink="";
						if($IDL5>=3)
							$clink .="<br><button type='button' onClick=\" editacom($cid,'$cdescripcion'); \" class='btn btn-primary btn-xs'>Editar</button>";
						if($IDL5>=4)
							$clink .="&nbsp;<button type='button' onClick=\" borrarcom($cid); \" class='btn btn-danger btn-xs'>Borrar</button>";
						echo "<tr>
						<td><font face='Arial' size='2' color='#000000'>$cdescripcion</font>$clink</td>
						<td><font face='Arial' size='2' color='#808080'>$cfecha</font></td>
						<td><font face='Arial' size='2' color='#808080'>$cact</font></td>
						</tr>";

						}
					mysqli_free_result($res);
					?>					
					</tbody>
				</table>
<?}?>
<br>
<? echo "<font face='Verdana' size='1' color='#808080'>Última Actualización: $ultima</font>";?>
<br>
<input type="hidden" name="id" <?echo "value='$id'"?>>
<input type="hidden" name="accion" value="0">
<input type="hidden" name="idcom" value="0">


</div>

<div id="modal4" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Establecer Integradora</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal4');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
		<select class="cenboxfrm" name="integranew">
			<?echo $integranewv;?>
		</select>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="cambiarintegra();">Cambiar</button>
	</p>
</div>


<div id="modal5" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Establecer Asesor</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal5');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
		<select class="cenboxfrm" name="asesornew">
			<?echo $asesornewv;?>
		</select>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="cambiarasesor();">Cambiar</button>
	</p>
</div>




<div id="modal6" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Comentarios</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal6');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
	<textarea class="cenboxfrm" name="comentario" style="height: 150px"></textarea>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="guardarcom();">Guardar</button>
	</p>
</div>

</form>

</body>
</html>
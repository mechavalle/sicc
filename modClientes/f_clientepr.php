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
	$IDL5=permiso("AdminClientesPto",$IDU);
	
	if($IDL5<0)
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
	
$csql = "SELECT * from `cat_clientes` WHERE `id` = '$id';";
		
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];			
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$montopresupuesto=$val5['montopresupuesto'];
	$status=$val5['status'];			
	}
mysqli_free_result($res2);

	
	$csql = "SELECT * from `cat_clientespto` WHERE `idcliente` = '$id';";
	$res2 = mysqli_query($conexio,$csql);
	$subtotal=0;
	if($val5=mysqli_fetch_array($res2))
		{
		$subtotal +=$val5['permisos'];
		$permisos=fixmontosin($val5['permisos']);
		$porpermisos=fixmontosin(($val5['permisos']*100)/$montopresupuesto,2)." %";
		
		$subtotal +=$val5['preliminares'];
		$preliminares=fixmontosin($val5['preliminares']);
		$porpreliminares=fixmontosin(($val5['preliminares']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['cimentacion'];
		$cimentacion=fixmontosin($val5['cimentacion']);
		$porcimentacion=fixmontosin(($val5['cimentacion']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['estructura'];
		$estructura=fixmontosin($val5['estructura']);
		$porestructura=fixmontosin(($val5['estructura']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['albanileria'];
		$albanileria=fixmontosin($val5['albanileria']);
		$poralbanileria=fixmontosin(($val5['albanileria']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['hidrosanitaria'];
		$hidrosanitaria=fixmontosin($val5['hidrosanitaria']);
		$porhidrosanitaria=fixmontosin(($val5['hidrosanitaria']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['electrica'];
		$electrica=fixmontosin($val5['electrica']);
		$porelectrica=fixmontosin(($val5['electrica']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['especiales'];
		$especiales=fixmontosin($val5['especiales']);
		$porespeciales=fixmontosin(($val5['especiales']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['acabados'];
		$acabados=fixmontosin($val5['acabados']);
		$poracabados=fixmontosin(($val5['acabados']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['pintura'];
		$pintura=fixmontosin($val5['pintura']);
		$porpintura=fixmontosin(($val5['pintura']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['herreria'];
		$herreria=fixmontosin($val5['herreria']);
		$porherreria=fixmontosin(($val5['herreria']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['carpinteria'];
		$carpinteria=fixmontosin($val5['carpinteria']);
		$porcarpinteria=fixmontosin(($val5['carpinteria']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['imperme'];
		$imperme=fixmontosin($val5['imperme']);
		$porimperme=fixmontosin(($val5['imperme']*100)/$montopresupuesto,2)." %";
		
		$subtotal +=$val5['limpieza'];
		$limpieza=fixmontosin($val5['limpieza']);
		$porlimpieza=fixmontosin(($val5['limpieza']*100)/$montopresupuesto,2)." %";

		$subtotalv=fixmontosin($subtotal);
		$porsubtotal=fixmontosin(($subtotal*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['honorarios'];
		$honorarios=fixmontosin($val5['honorarios']);
		$porhonorarios=fixmontosin(($val5['honorarios']*100)/$montopresupuesto,2)." %";

		$subtotal +=$val5['otros'];
		$otros=fixmontosin($val5['otros']);
		$porotros=fixmontosin(($val5['otros']*100)/$montopresupuesto,2)." %";

		$totalv=fixmontosin($subtotal);
		$portotal=fixmontosin(($subtotal*100)/$montopresupuesto,2)." %";

		$ultima=$val5['ultactusu']." el ".fixfecha($val5['ultactfec']);
		}
	mysqli_free_result($res2);


	$disponible=fixmontosin($montopresupuesto-$subtotal);

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Presupuesto de obra</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/stlinks.css">
<SCRIPT LANGUAGE="JavaScript">

function editar() 
	{		
	window.location.href='f_clientep.php?id='+document.edicion.id.value;
	}

</SCRIPT>
<style type="text/css">
	.eltexto
		{
		font-family: Arial;
		font-size: 13px;

		}

	.celb
		{
		background-color: #d9edf7;
		}
</style>

</head>


<body>
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">

	
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h3><font face="Arial">Cliente</font></h3></td>
			<td width="33" align="right">			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
		<tr>
			<td colspan="2"><h4><font face="Arial" color="#000080"><? echo "$idcli $nombre";?></font></h4></td>			
		</tr>
	</table>

	<?
	echo "<ul class='nav nav-tabs'>";
	echo "<li><a href='f_clienter.php?id=$id'>General</a></li>";
	if($IDL5>0)
		echo "<li class='active'><a href='f_clientepr.php?id=$id'>Presupuesto de Obra</a></li>";
	if($IDL2>0)
		echo "<li><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
	if($IDL3>0)
		echo "<li><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
	if($IDL4>0)
		echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
	echo "</ul><br>";

	?>
	<div id="divboton">
		<? if($IDL5>=2)
			echo "<button type='button' onClick=\"editar();\" class='btn btn-primary btn-xs'>Editar</button>";
		?>						
	</div>
	<p align="center">
		<table class="table table-condensed">
			<thead>			
				<tr>
					<th width="150" align="center" height="25"><font face="Arial" size="3">Presupuesto</font></th>
					<th align="center"><font face="Arial" size="3">Disponible</font></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="150" align="center" height="25"><font face="Arial" size="3" color='#808080'><b><? echo fixmontosin($montopresupuesto);?></b></font></td>
					<td><font face="Arial" size="3"><b><div id="divdisponible"><? echo $disponible;?></div></b></font></td>
				</tr>
			</tbody>
		</table>
	</p>
	<br>
	<p align="left">
		<table class="table" style="width: 400px;">
			<thead>
				<tr>
					<th width="200" align="center" height="25"><b><font face="Arial" size="2">Partida</font></b></th>
					<th width="5">&nbsp;</th>
					<th width="80" align="left"><b><font face="Arial" size="2">Importe</font></b></th>
					<th><b><font face="Arial" size="2">Porcentaje</font></b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Permisos y Licencias:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $permisos;?></b></font></td>
					<td><div class="eltexto" id="divpermisos"><? echo $porpermisos;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Preliminares (es su caso):</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $preliminares;?></b></font></td>
					<td><div class="eltexto" id="divpreliminares"><? echo $porpreliminares;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Cimentación:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $cimentacion;?></b></font></td>
					<td><div class="eltexto" id="divcimentacion"><? echo $porpermisos;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Estructura:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $estructura;?></b></font></td>
					<td><div class="eltexto" id="divestructura"><? echo $porestructura;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Albañilería:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $albanileria;?></b></font></td>
					<td><div class="eltexto" id="divalbanileria"><? echo $poralbanileria;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Instalación Hidro-sanitaria:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $hidrosanitaria;?></b></font></td>
					<td><div class="eltexto" id="divhidrosanitaria"><? echo $porhidrosanitaria;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Instalación eléctrica:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $electrica;?></b></font></td>
					<td><div class="eltexto" id="divelectrica"><? echo $porelectrica;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Instalaciones especiales:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $especiales;?></b></font></td>
					<td><div class="eltexto" id="divespeciales"><? echo $porespeciales;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Acabados:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $acabados;?></b></font></td>
					<td><div class="eltexto" id="divacabados"><? echo $poracabados;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Pintura:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $pintura;?></b></font></td>
					<td><div class="eltexto" id="divpintura"><? echo $porpintura;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Herrería y ventanería:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $herreria;?></b></font></td>
					<td><div class="eltexto" id="divherreria"><? echo $porherreria;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Carpintería:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $carpinteria;?></b></font></td>
					<td><div class="eltexto" id="divcarpinteria"><? echo $porcarpinteria;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Impermebilización:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $imperme;?></b></font></td>
					<td><div class="eltexto" id="divimperme"><? echo $porimperme;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Limpieza:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $limpieza;?></b></font></td>
					<td><div class="eltexto" id="divlimpieza"><? echo $porlimpieza;?></div></td>
				</tr>
				<tr>
					<td class="celb" width="200" align="right" height="25"><font face="Arial" size="2"><b>Subtotal:</b></font></td>
					<td class="celb" width="5">&nbsp;</td>
					<td class="celb" width="80"><b><div class="eltexto" id="divsubtotalm"><? echo $subtotalv;?></div></b></td>
					<td class="celb"><b><div class="eltexto" id="divsubtotal"><? echo $porsubtotal;?></div></b></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Honoraios:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $honorarios;?></b></font></td>
					<td><div class="eltexto" id="divhonorarios"><? echo $porhonorarios;?></div></td>
				</tr>
				<tr>
					<td width="200" align="right" height="25"><font face="Arial" size="2">Otros:</font></td>
					<td width="5">&nbsp;</td>
					<td width="80"><font face="Arial" size="2"><b><?echo $otros;?></b></font></td>
					<td><div class="eltexto" id="divotros"><? echo $porotros;?></div></td>
				</tr>
				<tr>
					<td class="celb" width="200" align="right" height="25"><font face="Arial" size="2"><b>Total:</b></font></td>
					<td class="celb" width="5">&nbsp;</td>
					<td class="celb" width="80"><b><div class="eltexto" id="divtotalm"><? echo $totalv;?></div></b></td>
					<td class="celb"><b><div class="eltexto" id="divtotal"><? echo $portotal;?></div></b></td>
				</tr>
			</tbody>
		</table>
	</p>
	<p style="padding: 15px,0;">
		<font face="Verdana" size="1" color="#808080"><? echo $ultima;?></font>
	</p>


</div>
<input type="hidden" id="id" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="montopresupuesto" <?echo "value='$montopresupuesto'";?>>
<input type="hidden" name="accion" value='0'>
<input type="hidden" name="total" value='0'>
</form>
</body>

</html>
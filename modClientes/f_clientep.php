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
		$id="-1";
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

	
if(isset($_POST['accion']))	
	$accion=$_POST['accion'];
else
	$accion=0;

if($accion==1)
	{
	$permisos=$_POST['permisos'];
	$preliminares=$_POST['preliminares'];
	$cimentacion=$_POST['cimentacion'];
	$estructura=$_POST['estructura'];
	$albanileria=$_POST['albanileria'];
	$hidrosanitaria=$_POST['hidrosanitaria'];
	$electrica=$_POST['electrica'];
	$especiales=$_POST['especiales'];
	$acabados=$_POST['acabados'];
	$pintura=$_POST['pintura'];
	$herreria=$_POST['herreria'];
	$carpinteria=$_POST['carpinteria'];
	$imperme=$_POST['imperme'];
	$limpieza=$_POST['limpieza'];
	$honorarios=$_POST['honorarios'];
	$otros=$_POST['otros'];
	$status=1;
	
	if(Existe("cat_clientespto","id",$id)=="NE")
		{
		$csql = "INSERT INTO `cat_clientespto` (`idcliente`,`permisos`,`preliminares`,`cimentacion`,`estructura`,`albanileria`,";
		$csql .="`hidrosanitaria`,`electrica`,`especiales`,`acabados`,`pintura`,`herreria`,";
		$csql .="`carpinteria`,`imperme`,`limpieza`,`honorarios`,`otros`,`status`,";
		$csql .="`ultactfec`,`ultactusu` )";
		$csql .="VALUES ('$id','$permisos','$preliminares','$cimentacion','$estructura','$albanileria',";
		$csql .="'$hidrosanitaria','$electrica','$especiales','$acabados','$pintura','$herreria',";
		$csql .="'$carpinteria','$imperme','$limpieza','$honorarios','$otros','$status',";
		$csql .="'".date("Y-m-d h:i:s")."','$IDUser')";
		}
	else 
		{
		$csql = "UPDATE `cat_clientespto` SET `permisos`='$permisos', `preliminares`='$preliminares', `cimentacion`='$cimentacion',";
		$csql .="`estructura`='$estructura', `albanileria`='$albanileria', `hidrosanitaria`='$hidrosanitaria', `electrica`='$electrica',";
		$csql .="`especiales`='$especiales', `acabados`='$acabados', `pintura`='$pintura', `herreria`='$herreria',";
		$csql .="`carpinteria`='$carpinteria', `imperme`='$imperme', `limpieza`='$limpieza', `honorarios`='$honorarios',";
		$csql .="`otros`='$otros', `status`='$status', `ultactfec`='".date("Y-m-d h:i:s")."', `ultactusu`='$IDUser' ";
		$csql .="WHERE `idcliente`='$id'";
		}
	mysqli_query($conexio,$csql);
	if(mysqli_error($conexio)!="") {
		echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
		exit(); }
	else
		{
		if($id=="-1")
			$id=mysql_insert_id($conexio);
		}

	#Fin guardado
	echo "<html><head><title>Guardado</title></head><body onLoad=\" wx=window.opener; wx.location.reload(); window.location.href='f_clientep.php?id=$id'; \"></body></html>";
	exit();
	}

if($id!="-1")
	{
	$csql = "SELECT * from `cat_clientespto` WHERE `idcliente` = '$id';";
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		{
		$permisos=$val5['permisos'];
		$preliminares=$val5['preliminares'];
		$cimentacion=$val5['cimentacion'];
		$estructura=$val5['estructura'];
		$albanileria=$val5['albanileria'];
		$hidrosanitaria=$val5['hidrosanitaria'];
		$electrica=$val5['electrica'];
		$especiales=$val5['especiales'];
		$acabados=$val5['acabados'];
		$pintura=$val5['pintura'];
		$herreria=$val5['herreria'];
		$carpinteria=$val5['carpinteria'];
		$imperme=$val5['imperme'];
		$limpieza=$val5['limpieza'];
		$honorarios=$val5['honorarios'];
		$otros=$val5['otros'];
		$ultima=$val5['ultactusu']." el ".fixfecha($val5['ultactfec']);
		}
	else
		{
		$permisos="0";
		$preliminares="0";
		$cimentacion="0";
		$estructura="0";
		$albanileria="0";
		$hidrosanitaria="0";
		$electrica="0";
		$especiales="0";
		$acabados="0";
		$pintura="0";
		$herreria="0";
		$carpinteria="0";
		$imperme="0";
		$limpieza="0";
		$honorarios="0";
		$otros="0";		
		$ultima="(sin guardar)";
		}
	mysqli_free_result($res2);
	$porpermisos="0 %";
	$porpreliminares="0 %";
	$porcimentacion="0 %";
	$porestructura="0 %";
	$poralbanileria="0 %";
	$porhidrosanitaria="0 %";
	$porelectrica="0 %";
	$porespeciales="0 %";
	$poracabados="0 %";
	$porpintura="0 %";
	$porherreria="0 %";
	$porcarpinteria="0 %";
	$porimperme="0 %";
	$porlimpieza="0 %";
	$porhonorarios="0 %";
	$porotros="0 %";	
	$subtotal="0";
	$porsubtotal="0 %";
	$totalv="0";
	$portotal="0 %";

	$disponible=fixmontosin($montopresupuesto);
	}
else
	exit();




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
var tporcent=0
function porcent(valor)
	{
	if(Number(valor)==0)
		return "0 %";
	else
		{
		aux=Number(valor*100)/Number(document.edicion.montopresupuesto.value);
		tporcent +=aux;
		return aux.toFixed(2)+ " %";
		}
	}
function calcula()
	{
	tporcent=0;
	var subtotal;
	var aux;
	if(!esnumero(document.edicion.permisos.value))
		document.edicion.permisos.value=0;
	document.getElementById("divpermisos").innerHTML=porcent(document.edicion.permisos.value);
	if(!esnumero(document.edicion.preliminares.value))
		document.edicion.preliminares.value=0;
	document.getElementById("divpreliminares").innerHTML=porcent(document.edicion.preliminares.value);
	if(!esnumero(document.edicion.cimentacion.value))
		document.edicion.cimentacion.value=0;
	document.getElementById("divcimentacion").innerHTML=porcent(document.edicion.cimentacion.value);
	if(!esnumero(document.edicion.estructura.value))
		document.edicion.estructura.value=0;
	document.getElementById("divestructura").innerHTML=porcent(document.edicion.estructura.value);
	if(!esnumero(document.edicion.albanileria.value))
		document.edicion.albanileria.value=0;
	document.getElementById("divalbanileria").innerHTML=porcent(document.edicion.albanileria.value);
	if(!esnumero(document.edicion.hidrosanitaria.value))
		document.edicion.hidrosanitaria.value=0;
	document.getElementById("divhidrosanitaria").innerHTML=porcent(document.edicion.hidrosanitaria.value);
	if(!esnumero(document.edicion.electrica.value))
		document.edicion.electrica.value=0;
	document.getElementById("divelectrica").innerHTML=porcent(document.edicion.electrica.value);
	if(!esnumero(document.edicion.especiales.value))
		document.edicion.especiales.value=0;
	document.getElementById("divespeciales").innerHTML=porcent(document.edicion.especiales.value);
	if(!esnumero(document.edicion.acabados.value))
		document.edicion.acabados.value=0;
	document.getElementById("divacabados").innerHTML=porcent(document.edicion.acabados.value);
	if(!esnumero(document.edicion.pintura.value))
		document.edicion.pintura.value=0;
	document.getElementById("divpintura").innerHTML=porcent(document.edicion.pintura.value);
	if(!esnumero(document.edicion.herreria.value))
		document.edicion.herreria.value=0;
	document.getElementById("divherreria").innerHTML=porcent(document.edicion.herreria.value);
	if(!esnumero(document.edicion.carpinteria.value))
		document.edicion.carpinteria.value=0;
	document.getElementById("divcarpinteria").innerHTML=porcent(document.edicion.carpinteria.value);
	if(!esnumero(document.edicion.imperme.value))
		document.edicion.imperme.value=0;
	document.getElementById("divimperme").innerHTML=porcent(document.edicion.imperme.value);
	if(!esnumero(document.edicion.limpieza.value))
		document.edicion.limpieza.value=0;
	document.getElementById("divlimpieza").innerHTML=porcent(document.edicion.limpieza.value);
	
	subtotal=0;
	var subtotal=Number(document.edicion.permisos.value)+Number(document.edicion.preliminares.value)+Number(document.edicion.cimentacion.value)+Number(document.edicion.estructura.value)+Number(document.edicion.albanileria.value)+Number(document.edicion.hidrosanitaria.value)+Number(document.edicion.electrica.value)+Number(document.edicion.especiales.value)+Number(document.edicion.acabados.value)+Number(document.edicion.pintura.value)+Number(document.edicion.herreria.value)+Number(document.edicion.carpinteria.value)+Number(document.edicion.imperme.value)+Number(document.edicion.limpieza.value);

	document.getElementById("divsubtotalm").innerHTML=subtotal.toFixed(2);
	document.getElementById("divsubtotal").innerHTML=tporcent.toFixed(2)+" %";

	if(!esnumero(document.edicion.honorarios.value))
		document.edicion.honorarios.value=0;
	document.getElementById("divhonorarios").innerHTML=porcent(document.edicion.honorarios.value);
	if(!esnumero(document.edicion.otros.value))
		document.edicion.otros.value=0;
	document.getElementById("divotros").innerHTML=porcent(document.edicion.otros.value);

	var total=subtotal+Number(document.edicion.honorarios.value)+Number(document.edicion.otros.value);

	document.getElementById("divtotalm").innerHTML=total.toFixed(2);
	document.getElementById("divtotal").innerHTML=tporcent.toFixed(2)+" %";

	var disponible=Number(document.edicion.montopresupuesto.value)-total;
	if(disponible<0)
		document.getElementById("divdisponible").innerHTML="<font color='#ff0000'>"+disponible.toFixed(2)+"</font>";
	else
		document.getElementById("divdisponible").innerHTML="<font color='#000000'>"+disponible.toFixed(2)+"</font>";


	
	}

function guardar() 
	{	
		
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=1;
	document.edicion.submit();
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


<body onload="calcula();">
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
		echo "<li class='active'><a href='f_clientep.php?id=$id'>Presupuesto de Obra</a></li>";
	if($IDL2>0)
		echo "<li><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
	if($IDL3>0)
		echo "<li><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
	if($IDL4>0)
		echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
	echo "</ul><br>";

	?>
	<div id="divboton">
		<button type='button' onClick="guardar();" class='btn btn-success btn-xs'>Guardar</button>						
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
		<table border="0" width="400" id="table3" cellspacing="0" cellpadding="0">
			<tr>
				<td width="200" align="center" height="25"><b><font face="Arial" size="2">Partida</font></b></td>
				<td width="5">&nbsp;</td>
				<td width="80" align="left"><b><font face="Arial" size="2">Importe</font></b></td>
				<td><b><font face="Arial" size="2">Porcentaje</font></b></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Permisos y Licencias:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="permisos" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.preliminares.focus();}"  class='cenboxfrmmin' <?echo "value='$permisos'";?>></td>
				<td><div class="eltexto" id="divpermisos"><? echo $porpermisos;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Preliminares (es su caso):</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="preliminares" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.cimentacion.focus();}"  class='cenboxfrmmin' <?echo "value='$preliminares'";?>></td>
				<td><div class="eltexto" id="divpreliminares"><? echo $porpreliminares;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Cimentación:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="cimentacion" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.estructura.focus();}"  class='cenboxfrmmin' <?echo "value='$cimentacion'";?>></td>
				<td><div class="eltexto" id="divcimentacion"><? echo $porpermisos;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Estructura:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="estructura" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.albanileria.focus();}"  class='cenboxfrmmin' <?echo "value='$estructura'";?>></td>
				<td><div class="eltexto" id="divestructura"><? echo $porestructura;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Albañilería:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="albanileria" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.hidrosanitaria.focus();}"  class='cenboxfrmmin' <?echo "value='$albanileria'";?>></td>
				<td><div class="eltexto" id="divalbanileria"><? echo $poralbanileria;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Instalación Hidro-sanitaria:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="hidrosanitaria" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.electrica.focus();}"  class='cenboxfrmmin' <?echo "value='$hidrosanitaria'";?>></td>
				<td><div class="eltexto" id="divhidrosanitaria"><? echo $porhidrosanitaria;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Instalación eléctrica:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="electrica" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.especiales.focus();}"  class='cenboxfrmmin' <?echo "value='$electrica'";?>></td>
				<td><div class="eltexto" id="divelectrica"><? echo $porelectrica;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Instalaciones especiales:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="especiales" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.acabados.focus();}"  class='cenboxfrmmin' <?echo "value='$especiales'";?>></td>
				<td><div class="eltexto" id="divespeciales"><? echo $porespeciales;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Acabados:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="acabados" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.pintura.focus();}"  class='cenboxfrmmin' <?echo "value='$acabados'";?>></td>
				<td><div class="eltexto" id="divacabados"><? echo $poracabados;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Pintura:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="pintura" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.herreria.focus();}"  class='cenboxfrmmin' <?echo "value='$pintura'";?>></td>
				<td><div class="eltexto" id="divpintura"><? echo $porpintura;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Herrería y ventanería:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="herreria" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.carpinteria.focus();}"  class='cenboxfrmmin' <?echo "value='$herreria'";?>></td>
				<td><div class="eltexto" id="divherreria"><? echo $porherreria;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Carpintería:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="carpinteria" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.imperme.focus();}"  class='cenboxfrmmin' <?echo "value='$carpinteria'";?>></td>
				<td><div class="eltexto" id="divcarpinteria"><? echo $porcarpinteria;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Impermebilización:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="imperme" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.limpieza.focus();}"  class='cenboxfrmmin' <?echo "value='$imperme'";?>></td>
				<td><div class="eltexto" id="divimperme"><? echo $porimperme;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Limpieza:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="limpieza" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.honorarios.focus();}"  class='cenboxfrmmin' <?echo "value='$limpieza'";?>></td>
				<td><div class="eltexto" id="divlimpieza"><? echo $porlimpieza;?></div></td>
			</tr>
			<tr>
				<td class="celb" width="200" align="right" height="25"><font face="Arial" size="2"><b>Subtotal:</b></font></td>
				<td class="celb" width="5">&nbsp;</td>
				<td class="celb" width="80"><b><div class="eltexto" id="divsubtotalm"><? echo $subtotal;?></div></b></td>
				<td class="celb"><b><div class="eltexto" id="divsubtotal"><? echo $porsubtotal;?></div></b></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Honoraios:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="honorarios" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.otros.focus();}"  class='cenboxfrmmin' <?echo "value='$honorarios'";?>></td>
				<td><div class="eltexto" id="divhonorarios"><? echo $porhonorarios;?></div></td>
			</tr>
			<tr>
				<td width="200" align="right" height="25"><font face="Arial" size="2">Otros:</font></td>
				<td width="5">&nbsp;</td>
				<td width="80"><input type="text" name="otros" onfocus="this.select();" onkeypress="if(event.keyCode==13){ calcula(); document.edicion.miboton.focus();}"  class='cenboxfrmmin' <?echo "value='$otros'";?>></td>
				<td><div class="eltexto" id="divotros"><? echo $porotros;?></div></td>
			</tr>
			<tr>
				<td class="celb" width="200" align="right" height="25"><font face="Arial" size="2"><b>Total:</b></font></td>
				<td class="celb" width="5">&nbsp;</td>
				<td class="celb" width="80"><b><div class="eltexto" id="divtotalm"><? echo $totalv;?></div></b></td>
				<td class="celb"><b><div class="eltexto" id="divtotal"><? echo $portotal;?></div></b></td>
			</tr>
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
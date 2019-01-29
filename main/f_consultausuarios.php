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
	$IDL=permiso("adminUsuarios",$IDU);
	if($IDL<1)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close();\"></body></html>";
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
	
if(isset($_GET['nombre']))	
	$nombre=$_GET['nombre'];
else 
	$nombre="";
	
if(isset($_GET['status']))
	{	
	if($_GET['status']=="1")
		$statusv="<option value='-1'>Todo</option><option selected value='1'>Activo</option><option value='0'>Inactivo</option>";		
	if($_GET['status']=="0")
		$statusv="<option value='-1'>Todo</option><option value='1'>Activo</option><option selected value='0'>Inactivo</option>";
	if($_GET['status']=="-1")
		$statusv="<option selected value='-1'>Todo</option><option value='1'>Activo</option><option value='0'>Inactivo</option>";
	$status=$_GET['status'];
	}
else {
	$statusv="<option value='-1'>Todo</option><option selected value='1'>Activo</option><option value='0'>Inactivo</option>";
	$status="1"; }	

if(isset($_GET['todos']))	
	$todos=$_GET['todos'];
else 
	$todos="1";

$consulta = "SELECT * FROM `adm_usuarios` where id>0 ";

$consultaT1="";
$consultaT2="";
			
		if($nombre!="")
			$consultaT1 .="(`nombre` like '%".$nombre."%') ";			
		if($status!="-1")
			$consultaT2 .="(`status` = '$status' ) ";				
$consulta2="";
		if($consultaT1!="")
			$consulta2 .="AND ".$consultaT1;
		if($consultaT2!="")
			$consulta2 .="AND ".$consultaT2;
#echo $consulta2;

$consulta .=$consulta2."ORDER BY nombre";

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../img/icono.png" type="image/x-icon">
	<title>Consulta de Usuarios</title>
	<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
	<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
	<script src="../lib/jquery-2.1.1.min.js"></script>
	<script src="../lib/boot/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
	<SCRIPT LANGUAGE="JavaScript">
		function alcargar()
			{
		<? if($todos==1){?>
			document.getElementById("divregistros").innerHTML="<b>"+document.edicion.i.value+" Usuarios Totales</b><br><a href='#' onClick='document.edicion.todos.value=0; document.edicion.submit();'>"+document.edicion.k.value+" Usuarios con Acceso a <? echo $razon;?></a>";
		<?} if($todos==0){?>
			document.getElementById("divregistros").innerHTML="<a href='#' onClick='document.edicion.todos.value=1; document.edicion.submit();'>"+document.edicion.i.value+" Usuarios Totales</a><br><b>"+document.edicion.k.value+" Usuarios con Acceso a <? echo $razon;?></b>";
		<?}?>
			}
	</SCRIPT>
</head>

<body topmargin="0" onload="alcargar();">
<form name="edicion" method="GET" target="_self">
	<?
	$mnu="configuracion";
    include("f_header.php");
    ?>
<div style="padding: 0 20px;">
	<p>
	<h3><font color="#888888">Consulta <font color='#ff0000'>Usuarios</font></font></h3>
	</p>

	<br>

	<div class="well well-sm">
		<table border="0" width="100%" id="table5" cellspacing="0" cellpadding="0">
			<tr>
				<td width="60"><font size="1" face="Verdana">Nombre:</font></td>
				<td width="200">
				<input type="text" name="nombre" size="28" style="font-family: Verdana; font-size: 8pt" onkeypress="if(event.keyCode==13) document.edicion.submit();" <? echo "value='$nombre'";?>></td>
				<td width="50"><font size="1" face="Verdana">Status:</font></td>
				<td width="250">
				<select size="1" name="status" style="font-family: Verdana; font-size: 8pt" onchange="document.edicion.submit();">
				<? echo $statusv;?>
				</select></td>
				<td align="right">
					<a href="#"  onclick="document.edicion.submit();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>
				&nbsp;|&nbsp;<a href="#" onclick="window.location.href='f_consultausuarios.php';"><span class="glyphicon glyphicon-circle-arrow-left"></span><font size="1" face="Verdana">Limpiar</font></a>
				</td>
			</tr>
		</table>
	</div>

	<? 
	if($IDL>=3)
			echo "<button type='button' onclick=\"abre('usuario','f_usuarios.php',800,600,'YES');\" class='btn btn-primary btn-xs'>Crear Usuario Nuevo</button>";
	if($IDL>=2)
			echo "&nbsp;<button type='button' onclick=\"abre('borrar','f_eliminarpermisos.php',800,600,'YES');\" class='btn btn-warning btn-xs'>Borrar Permisos de...</button>";
	?>				
	<p><div id="divregistros" style="font-family: Verdana; font-size: 10px; color: grey;"></div></p>		

<table class="table table-striped">
	 <thead>
      	<tr>
      		<th></th>
      		<th style="width: 320px;"><font size="2" face="Arial">Nombre</font></th>
      		<th><font size="2" face="Arial">Empresa</font></th>
      		<th><font size="2" face="Arial">Usuario</font></th> 
      		<th><font size="2" face="Arial">Correo</font></th>
      		<th><font size="2" face="Arial">Comentarios</font></th>
      		<th><font size="2" face="Arial">Status</font></th>
      	</tr>
      </thead>      	  
    <tbody>

		<?		
		$res = mysqli_query($conexio, $consulta);
		$i=0;
		$k=0;
		while($val=mysqli_fetch_array($res))
			{
			$i=$i+1;
			
			if($val['status']=="0")
				{
				$fcolor="color='#808080'";
				$status="Inactivo";
				}
			else
				{
				$fcolor="color='#000000'";
				$status="Activo";
				}
			if($IDL>=2)
				$link="<button type='button' onClick=\"abre('usuario','f_permisos.php?id=".$val['id']."',800,600,'YES');\" class='btn btn-link'>";
			else
				$link="";

			if($todos==1)
				{
	    		echo "<tr>";			
				echo "<td align='center'><font size='1' color='#808080'>$i</font></td>";
				echo "<td>$link<font size='2' face='Arial' $fcolor>".$val['nombre']."</font></button></td>";
				echo "<td><font size='2' face='Arial' $fcolor>".$val['empresa']."</font></td>";
				echo "<td><font size='2' face='Arial' $fcolor>".$val['usuario']."</font></td>";
				echo "<td><font size='2' face='Arial' $fcolor>".$val['mail']."</font></td>";
				echo "<td><font size='2' face='Arial' $fcolor>".$val['comentario']."</font></td>";
				echo "<td><font size='2' face='Arial' $fcolor>$status</font></td>";			
				echo "</tr>";
				}
			else
				{
				if($elacceso>0)
					{
					echo "<tr>";			
					echo "<td align='center'><font size='1' color='#808080'>$k</font></td>";
					echo "<td>$link<font size='2' face='Arial' $fcolor>".$val['nombre']."</font></button></td>";
					echo "<td><font size='2' face='Arial' $fcolor>".$val['empresa']."</font></td>";
					echo "<td><font size='2' face='Arial' $fcolor>".$val['usuario']."</font></td>";
					echo "<td><font size='2' face='Arial' $fcolor>".$val['mail']."</font></td>";
					echo "<td><font size='2' face='Arial' $fcolor>".$val['comentario']."</font></td>";
					echo "<td><font size='2' face='Arial' $fcolor>$status</font></td>";			
					echo "</tr>";
					}
				}
			}
		mysqli_free_result($res);
		?>			
	</tbody>			
</table>
</div>
<input type="hidden" name="todos" <?echo "value='$todos'";?>>
<input type="hidden" name="i" <?echo "value='$i'";?>>
<input type="hidden" name="k" <?echo "value='$k'";?>>
</form>
</body>
</html>
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
	
	if($IDL2<0)
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
	exit();
	
$csql = "SELECT * from `cat_clientes` WHERE `id` = '$id';";
		
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];			
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$status=$val5['status'];			
	}
mysqli_free_result($res2);


	
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

if(isset($_GET['orden']))	
	$orden=$_GET['orden'];
else
	$orden="descripcion";
	

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Archivos</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

</head>


<body>

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
if($IDL5>0)
	echo "<li><a href='f_clientep.php?id=$id'>Presupuesto de Obra</a></li>";
if($IDL2>0)
	echo "<li class='active'><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
if($IDL3>0)
	echo "<li><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
if($IDL4>0)
	echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
echo "</ul><br>";

echo "<br><h4>Documentos Obligatorios</h4>";
echo "<table class='table'>";						
				
$consulta="Select * from $latabla where idorigen='$id' and tipo='must' order by descripcion asc";
#echo $consulta;
$res = mysqli_query($conexio, $consulta);
$i=0;
while($val8=mysqli_fetch_array($res))
	{
	$i +=1;
	$aid=$val8['id'];
	$adescripcion=$val8['descripcion'];
	$ver=md5($aid."id".$latabla."masamuneshirow");
	if($val8['archivo']=="")
		{
		$icono="<span class='glyphicon glyphicon-time'></span>";
		$link="<button type='button' onClick=\" abre('subirarchivo','../main/f_subirarchivomust.php?id=$aid&tabla=$latabla&dir=$laruta',350,200,'NO'); \" class='btn btn-danger btn-xs'>Agregar...</button>";
		$link2="";
		}
	else
		{
		$elarchivo=$laruta."/".$val8['archivo'];
		$icono="<span class='glyphicon glyphicon-ok'></span>";
		$link="<button type='button' onClick=\" abre('archivo','$elarchivo',800,800,'AUTO'); \" class='btn btn-success btn-xs'><span class='glyphicon glyphicon-search'></span>&nbsp;Ver</button>";
		if($IDL2>=3)
			$link2="&nbsp;<button type='button' class='btn btn-danger btn-xs' onClick=\"abre('borrarimagen','../main/f_borrar.php?id=$aid&tabla=$latabla&campoid=id&img=$elarchivo&ver=$ver',400,150,'NO');\"><span class='glyphicon glyphicon-trash'></span>&nbsp;Eliminar</button>";
		else
			$link2="";
		}
	echo "<tr><td width='20' height='25' align='center'><font face='Verdana' size='1' color='#808080'>$i</font></td>";
	echo "<td width='20' height='25' align='center'>$icono</td>";	
	echo "<td width='200' height='25'><font face='Arial' size='2'>$adescripcion</font></td>";
	echo "<td width='80' height='25'>$link</td>";
	echo "<td height='25'>$link2</td></tr>";
	}
mysqli_free_result($res);
echo "</table>";
echo "<br><h4>Archivos Extra</h4>";		

if($IDL2>=2)
	echo "<button type='button' onClick=\" abre('subirarchivo','../main/f_subirarchivo.php?id=$id&tabla=$latabla&dir=$laruta&tipo=extra',350,200,'NO'); \" class='btn btn-success btn-xs'>Agregar Nuevo</button>";
#Realizamos la consulta para traer los valores
echo "<div class='row'>";
$csql = "SELECT * from $latabla WHERE idorigen = '$id' and tipo='extra' ORDER BY $orden";
$k=0;
			
$res2 = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($res2))
	{
	$k +=1;
	$idimg=$val['id'];
				
	$ver=md5($idimg."id".$latabla."masamuneshirow");
	$imgdesc=$val['descripcion'];
	$ultima=fixfecha($val['ultactfec'])." por ".$val['ultactusu'];
					
								
	echo "<span style='position: relative; display: inline-block; width: 120px; height: 200px; background: rgb(243,243,243); margin: 10px; padding: 10px 5px; z-index: 1'>";
	echo "<table border='0' width='100%' id='tablex' cellspacing='0' cellpadding='0'>";
	echo "<tr><td align='center'>";
					
	if($val['tipoarchivo']=="applicatio" || $val['tipoarchivo']=="text/xml")
		{
		echo "<a href='#' onclick=\"abre('archivo','".$laruta."/".$val['archivo']."',800,600,'YES');\">";
		$imgicono=iconoapp($val['archivo']);
		echo "<img border='0' src='$imgicono'></a>";
		}
	else
		{
		echo "<a href='#' onclick=\"abre('archivo','".$laruta."/".$val['archivo']."',800,600,'YES');\">";
		echo "<img border='0' src='".$laruta."/".$val['archivo']."' ".tamanio($laruta."/".$val['archivo'],90,90)."></a>";
		}			
	echo "</td></tr><tr><td align='center' height='10'></td></tr>";
	echo "<tr><td align='center'><font size='1' face='Verdana'>".$val['descripcion']."</font></td></tr>";
	echo "<tr><td align='center' height='10'></td></tr><tr><td align='center'>";
	if($IDL2>=2)
		echo "<button type='button' onclick=\" abre('subirarchivo','../main/f_subirarchivo.php?id=$idimg&tabla=$latabla&dir=$laruta&tipo=upd&desc=$imgdesc',370,250,'NO'); \" class='btn btn-primary btn-xs'>Editar</button>";		
	else					
		echo "&nbsp;";
	#echo $IDL3;
	if($IDL2>=3)
		echo "&nbsp;<button type='button' onclick=\" abre('borrarimagen','../main/f_borrar.php?id=$idimg&tabla=$latabla&campoid=id&img=".$laruta."/".$val['archivo']."&ver=$ver',400,150,'NO'); \" class='btn btn-danger btn-xs'>Borrar</button>";
	echo "</td></tr>";					
	echo "<tr><td align='center' height='10'></td></tr><tr><td align='center'><font size='1' face='Verdana' color='#808080' style='font-size: 7pt'><i>$ultima</i></font></td></tr>";					
    echo "</table>";
    echo "</span>";				    
    }
mysqli_free_result($res2);			
echo "</div>";				
?>				

</div>
</body>

</html>
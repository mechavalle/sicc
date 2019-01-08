<?
include("../lib/f_conecta.php"); 
include("../lib/f_fnBD.php"); 

#Vemos si esta logueado el usuario
session_name ("censession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$conexio=conecta($IDBase);
	$IDL=permiso("AdminPopera",$IDU);
	$IDL2=permiso("AdminPoperaConf",$IDU);
	$IDL3=permiso("AdminPoperaArc",$IDU);
	$IDL4=permiso("AdminPoperaLog",$IDU);
	$IDL9=permiso("AdminPoperaAct",$IDU);
	$IDL10=permiso("AdminCHEstudio",$IDU);
	if($IDL<0 || $IDL3<0)
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
	
$csql = "SELECT * from `cat_operadores` WHERE `id` = '$id';";
		
$res2 = mysql_query($csql);
if($val5=mysql_fetch_array($res2))
	{			
	$idper=$val5['idper'];			
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$status=$val5['status'];			
	}
mysql_free_result($res2);


	
###directorio
$consulta="select * from adm_archivos where modulo='operadores'";
$resx = mysql_query($consulta);
if($val=mysql_fetch_array($resx))
	{
	$laruta="../".$val['ruta'];
	$latabla=$val['tabla'];
	$categotab="cat_invimg";
	}
else
	{
	echo "Error: El modulo enviado (invproductos) no existe";
		exit();
	}
mysql_free_result($resx);

if($laruta==-1)
	echo "<br><font color='#ff0000'><b>ERROR</b> No existe ruta para los archivos";
if($latabla==-1)
	echo "<br><font color='#ff0000'><b>ERROR</b> No existe tabla para los archivos";

if(isset($_GET['back']))	
	$back=$_GET['back'];
else
	$back="f_operadorr.php";

if(isset($_GET['orden']))	
	$orden=$_GET['orden'];
else
	$orden="descripcion";
	

#Realizamos la consulta para traer los valores

$csql = "SELECT * from $latabla WHERE idorigen = '$id' ";

$csql .=" ORDER BY $orden";

?>


<html>

<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Archivos</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/boot/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

</head>


<body>

<div class="container">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h3><font face="Arial">Capital Humano</font></h3></td>
			<td width="300" align="right">
				
			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
		<tr>
			<td colspan="2"><h4><font face="Arial" color="#000080"><? echo "$idper $nombre";?></font></h3></td>			
		</tr>
	</table>

<?
echo "<ul class='nav nav-tabs'>";
echo "<li><a href='f_operadorr.php?id=$id'>General</a></li>";
echo "<li><a href='f_operadordc.php?id=$id'>Documentos y Capacitación</a></li>";
echo "<li><a href='f_operadorcr.php?id=$id'>Contratación</a></li>";
echo "<li><a href='f_operadormd.php?id=$id'>Información Médica</a></li>";
if($IDL3>0)
	echo "<li class='active'><a href='f_operadori.php?id=$id'><b>Archivos</b></a></li>";
if($IDL2>0)
	echo "<li><a href='f_operadorcf.php?id=$id'><font color='#808080'><i class='fa fa-user-secret'></i></font>&nbsp;Información Confidencial</a></li>";
if($IDL10>0)
	echo "<li><a href='f_operadorest.php?id=$id'>&nbsp;Estudio Socioeconómico</a></li>";
if($IDL9>0)
	echo "<li><a href='f_operadorprl.php?id=$id'>&nbsp;Procedimientos Legales</a></li>";
if($IDL4>0)
	echo "<li><a href='f_operadorl.php?id=$id'>Log Cambios</a></li>";
echo "</ul><br>";

if($IDL3>=2)
	echo "<button type='button' onClick=\" abre('subirarchivo','../modMain/f_subirarchivo.php?id=$id&tabla=$latabla&dir=$laruta&tipo=extra',350,200,'NO'); \" class='btn btn-success btn-xs'>Agregar Nuevo</button>";

echo "<br>";				

			$k=0;
			
$res2 = mysql_query($csql);
			#echo $csql;	
while($val=mysql_fetch_array($res2))
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
		echo "<a href='#' onClick=\"abre('imagen','../modMain/f_imagengral.php?desc=$imgdesc&archivo=$laruta"."/".$val['archivo']."',800,600,'YES');\">";
		echo "<img border='0' src='".$laruta."/".$val['archivo']."' ".tamanio($laruta."/".$val['archivo'],90,90)."></a>";
		}				
	echo "</td></tr><tr><td align='center' height='10'></td></tr>";
	echo "<tr><td align='center'><font size='1' face='Verdana'>".$val['descripcion']."</font></td></tr>";
	echo "<tr><td align='center' height='10'></td></tr><tr><td align='center'>";
	if($IDL3>=3)
		echo "<button type='button' onclick=\" abre('subirarchivo','../modMain/f_subirarchivo.php?id=$idimg&tabla=$latabla&dir=$laruta&tipo=upd&desc=$imgdesc',370,250,'NO'); \" class='btn btn-primary btn-xs'>Editar</button>";		
	else					
		echo "&nbsp;";
	if($IDL3>=4)
		echo "&nbsp;<button type='button' onclick=\" abre('borrarimagen','../modMain/f_borrar.php?id=$idimg&tabla=$latabla&campoid=id&img=".$laruta."/".$val['archivo']."&ver=$ver',400,150,'NO'); \" class='btn btn-danger btn-xs'>Borrar</button>";
	echo "</td></tr>";					
	echo "<tr><td align='center' height='10'></td></tr><tr><td align='center'><font size='1' face='Verdana' color='#808080' style='font-size: 7pt'><i>$ultima</i></font></td></tr>";					
    echo "</table>";
    echo "</span>";				    
    }
mysql_free_result($res2);			
					
?>				

</div>
</body>

</html>
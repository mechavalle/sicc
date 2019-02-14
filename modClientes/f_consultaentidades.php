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
	$IDL=permiso("AdminCatalogos",$IDU);
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
		}	
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	}

if(isset($_GET['titulo']))
	$titulo=$_GET['titulo'];
else
	$titulo=1;


if(isset($_GET['tipo']))
	$tipo=$_GET['tipo'];
else
	{
	if(isset($_POST['tipo']))
		$tipo=$_POST['tipo'];
	else
		exit();
	}

switch($tipo)
	{
	case 1: $titulov="Administradora"; $elcampo="idadministradora"; break;
	case 2: $titulov="Constructora"; $elcampo="idconstructora"; break;
	case 3: $titulov="Verificadora"; $elcampo="idverificadora"; break;
	}

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Consulta Entidad <?echo $titulov;?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery-2.1.1.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

</head>


<body>
<form method="POST" name="edicion" target="_self">
<div style="padding: 0 20px;">
<?
if($titulo==1)
	echo "<p><h3><font color='#888888'>Consulta <font color='#ff0000'>".$titulov."s</font></font></h3></p>";


	if($IDL>=2)
		echo "<button type='button' onClick=\" abre('registro','f_entidad.php?tipo=$tipo',550,350,'NO'); \" class='btn btn-success btn-xs'>Nuevo Registro</button>";
?>
&nbsp;<a href="#"  onclick="window.location.reload();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>
<br>
<table class="table table-striped">
	 <thead>
      	<tr>
      		<th></th>
      		<th><font size="2" face="Arial">Razón Social</font></th>
      		<th><font size="2" face="Arial">Nombre que aparece en Estado de Cuenta</font></th> 
      		<th><font size="2" face="Arial">RFC</font></th> 
      		<th><font size="2" face="Arial">CLABE</font></th>      		
			<th><font face="Arial" size="2">Status</font></th>
		</tr>
	</thead>      	  
    <tbody>
<?
			$i=0;
			$consulta="select * from cat_entidades where tipo='$tipo' order by razonsocial";
			$res = mysqli_query($conexio,$consulta);		
			while($val=mysqli_fetch_array($res))
				{
				$i +=1;
				$id=$val['id'];
									
				$razonsocial=$val['razonsocial'];
				$nombre=$val['nombre'];
				$rfc=$val['rfc'];
				$clabe=$val['clabe'];
				$status=$val['status'];
				if($status==1 || $status==11)
					{
					$status="Activo";
					$foncolor="color='#000000'";
					}
				else
					{
					$status="Inactivo";
					$foncolor="color='#808080'";
					}
				if($IDL>=2)
					$link="<a href='#' onclick=\"abre('registro','f_entidad.php?id=$id&tipo=$tipo',550,350,'NO');\">";
				else
					$link="";

				
				echo "<tr>
				<td><font face='Verdana' size='1' color='#808080'>$i</font></td>
				<td>$link<font face='Arial' size='2' $foncolor>$razonsocial</font></a></td>
				<td>$link<font face='Arial' size='2' $foncolor>$nombre</font></a></td>	
				<td>$link<font face='Arial' size='2' $foncolor>$rfc</font></a></td>	
				<td>$link<font face='Arial' size='2' $foncolor>$clabe</font></a></td>				
				<td>$link<font face='Arial' size='2' $foncolor>$status</font></a></td>
				</tr>";
				}
			mysqli_free_result($res);			
			?>
			</tbody>
			</table>
			
</div>
<input type="hidden" name="tipo" <?echo "value='$tipo'";?>>
<input type="hidden" name="accion" value="0">
<input type="hidden" name="id" value="0">
</form>

</body>

</html>
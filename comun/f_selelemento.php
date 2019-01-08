<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");

#Vemos si esta logueado el usuario
session_name ("micsession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
  {
  $idowner=$_SESSION['IDOwner'];
  $IDU=$_SESSION['IDU'];
  $IDBase=$_SESSION['IDBase'];
  $IDUser=$_SESSION['IDUser'];
  $IDName=$_SESSION['IDName'];
  $conexio=conecta($IDBase);
 /* $IDL=permiso("AdminClientes",$IDU);
  $IDL2=permiso("AdminClientesArc",$IDU);
  
  if($IDL2<0)
    {
    echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
    exit();
    }
  */
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

if(isset($_GET['destino']))
	$destino=$_GET['destino'];
else
	exit();

if(isset($_GET['tabla']))	
	$tabla=$_GET['tabla'];
else 
	$tabla="";

if(isset($_GET['nuevo']))
	$nuevo=$_GET['nuevo'];
else
	$nuevo="";

if(isset($_GET['titulo']))
	$titulo=$_GET['titulo'];
else
	$titulo="";	

if($nuevo=="")
	$nuevo="../comun/f_registro.php?desc=$titulo&tabla=$tabla&regreso=1";
else
	$nuevo .=".php?regreso=1";

if(isset($_GET['buscar']))
	$buscar=$_GET['buscar'];
else
	$buscar="";		
?>
<!DOCTYPE html>
<html>
<head>
  <title>Editar Comic</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
  <link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
  <script src="../lib/jquery-2.1.1.min.js"></script>
  <script src="../lib/boot/js/bootstrap.min.js"></script>
  <SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<link rel="stylesheet" href="../lib/stylecomics.css">
<SCRIPT LANGUAGE="JavaScript">
function regresar(idcc,descripcion)
	{
	//w2=window.opener;
	window.opener.document.getElementById('<?echo "div".$destino;?>').innerHTML=descripcion;	
	window.opener.document.getElementById('<?echo "id".$destino;?>').value=idcc;
	window.close();
	}

function buscar()
	{
	//if(document.edicion.buscar.value!="")
	document.edicion.submit();
	}
</SCRIPT>
</head>

<body>
<form class="form-horizontal" role="form" method="GET" name="edicion" target="_self">
<div class="container">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h3>Seleccione <font color='#ff0000'><? echo $titulo; ?></font></h3></td>
			<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<div class="well well-sm">
		<div class="row">
			<div class="col-xs-8">
				<font size="2" face="Arial">Buscar:</font>&nbsp;<input type="text" name="buscar" onkeypress="if(event.keyCode==13) buscar();" class="cenboxfrm" <?echo "value='$buscar'";?>>
				<? if($buscar!="")
				echo "&nbsp;<a href='#' onclick=\"document.edicion.buscar.value=''; document.edicion.submit(); \"><span class='glyphicon glyphicon-trash' style='font-size: 20px;'></span></a>";
				?>
			</div>
			<div class="col-xs-4 text-right">
				<? echo "<button type='button' class='btn btn-primary btn-xs' onclick=\"abre('nuevoele','$nuevo',400,400,'AUTO');\">Crear Nuevo</button>"; ?>	
			</div>
		</div>
	</div>
	
	<p>

	<?
	
	$lineas="<table class='table table-hover'>";
	if($buscar!="")
		$consulta="Select * from $tabla where idowner='$idowner' and status='1' and descripcion like '%$buscar%' order by descripcion";
	else
		$consulta="Select * from $tabla where idowner='$idowner' and status='1' order by descripcion";
#echo $consulta;	
	$i=0;
	$res = mysqli_query($conexio,$consulta);	
	while($val=mysqli_fetch_array($res))
		{
		$i +=1;
		$idpar=$val['id'];	
		$descripcion=$val['descripcion'];
		$color="bgcolor='#FFFFFF'";		
		$colorf="color='#000000'";
		$link="<a href='#' onclick=\"regresar($idpar,'$descripcion');\">";
		$lineas .="<tr>
					<td style='width: 25px;'>$link<span class='glyphicon glyphicon-hand-right' style='font-size: 20px;'></span></a></td>
					<td><font face='Arial' size='2' $colorf>$descripcion</font></td>
				</tr>";			
		}
	mysqli_free_result($res);		
	$lineas .="</table>";

	if($i==0 && $buscar=="")
		echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Aun no existe ningun <b>$titulo</b>, utiliza 'Crear Nuevo'.</div>";
	else
		echo $lineas;
	?>

	</p>
	
</div>
<input type="hidden" name="destino" <?echo "value='$destino'";?>>
<input type="hidden" name="tabla" <?echo "value='$tabla'";?>>
<input type="hidden" name="nuevo" <?echo "value='$nuevo'";?>>
<input type="hidden" name="titulo" <?echo "value='$titulo'";?>>
</form>
</body>

</html>
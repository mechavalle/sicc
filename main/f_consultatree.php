<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php"); 

if(isset($_GET['permiso']))
	$permiso=$_GET['permiso'];
else
	{
	if(isset($_POST['permiso']))
		$permiso=$_POST['permiso'];
	else
		exit();
	}

if(isset($_GET['desc']))
	$desc=$_GET['desc'];
else
	{
	if(isset($_POST['desc']))
		$desc=$_POST['desc'];
	else
		$desc="¿?";
	}

if(isset($_GET['tabla']))
	$tabla=$_GET['tabla'];
else
	{
	if(isset($_POST['tabla']))
		$tabla=$_POST['tabla'];
	else
		exit();
	}

if(isset($_GET['maxnivel']))
	$maxnivel=$_GET['maxnivel'];
else
	{
	if(isset($_POST['maxnivel']))
		$maxnivel=$_POST['maxnivel'];
	else
		exit();
	}
$maxnivel -=1;
#Vemos si esta logueado el usuario
session_name ("siccsession");
session_start();
if(isset($_SESSION['IDU']))
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$conexio=conecta($IDBase);
	$IDL=permiso("adminModulos",$IDU);
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	} 

function traecolor($nivel)
	{
	switch ($nivel) 
		{
		case '1': return "#000000"; break;
		case '2': return "#35168F"; break;
		case '3': return "#6B8366"; break;
		case '4': return "#900C3F"; break;
		case '5': return "#FFC300"; break;
		default: return "#000000"; break;
		}
	}

function traepartida($nivel,$idpadre)
	{
	global $conexio;
	global $tabla;
	global $IDL;
	global $maxnivel;
	global $permiso;
	global $desc;
	$lineas="";
	if($idpadre==0)
		$consulta="Select * from $tabla where nivel='$nivel' order by descripcion";
	else
		$consulta="Select * from $tabla where nivel='$nivel' and idpadre='$idpadre' order by descripcion";
	$nivel +=1;	
	$res = mysqli_query($conexio,$consulta);	
	while($val=mysqli_fetch_array($res))
		{
		$desc=$val['descripcion'];
		$idpar=$val['id'];
		$padre=$val['idpadre'];
		$status=$val['status'];
		$nivel2=$val['nivel'];
		$subnivel=$nivel2+1;
		$tama=$nivel2*22;
		$margen="<div style='display: inline-block; width: ".$tama."px; height= 16px'></div>";

		$colorf="color='".traecolor($nivel2)."'";

		if($status==0)
			$colorf="color='#808080'";
	
		$lineas .="<tr><td align='left'>";
		if($nivel2==1)
			$desc="<b>$desc</b>";

		if($IDL>=2)
			{			
			$lineas .="$margen<button type='button' class='btn btn-link' onclick=\"abre('branch','f_branch.php?permiso=$permiso&desc=$desc&tabla=$tabla&id=$idpar',700,500,'YES');\"><font face='Verdana' size='2' $colorf>$desc</font></button>";				
			}
		else
			$lineas .="$margen<font face='Arial' size='2' $colorf>$desc</font>";
		
		$lineas .="</td>";
		if($nivel2<=$maxnivel & $status==1)
			$lineas .="<td><button type='button' onClick=\" abre('branch','f_branch.php?permiso=$permiso&desc=$desc&tabla=$tabla&nivel=$subnivel&idpadre=$idpar',550,250,'NO'); \" class='btn btn-default btn-xs'><span class='glyphicon glyphicon-download-alt'></span> Crear dependiente a este nivel</button></td>";
		else
			$lineas .="<td></td>";
		$lineas .="</tr>";
		$linea2=traepartida($nivel,$val['id']);
		if($linea2!="")
			$lineas .=$linea2;		
		}
	mysqli_free_result($res);
	return $lineas;
	}


?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../img/icono.png" type="image/x-icon">
<title><? echo $desc; ?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery-2.1.1.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/style.css">
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>
<style type="text/css">
.btn-link {
	    padding: 1px 5px;
}

</style>
</head>
<body>
<form method="POST" name="edicion" target="_self">
	<?
	$mnu="configuracion";
    include("f_header.php");
    ?>
<div style="padding: 0 20px;">
<div style="display: inline-block; width: $tam; ">
<p>
<h3><font color="#888888"><?echo $desc;?></font></h3>
</p>

<?
if($IDL>=2)
	echo "<button type='button' onClick=\" abre('branch','f_branch.php?permiso=$permiso&desc=$desc&tabla=$tabla&idpadre=0&nivel=1',550,250,'NO'); \" class='btn btn-success btn-xs'>Nuevo Registro en Raíz</button>";
?>
&nbsp;<a href="#"  onclick="document.edicion.submit();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>

<br>
<table class="table table-hover" >
	 <thead>
      	<tr>
      		<th></th>
      		<th></th>
		</tr>
	</thead>      	  
    <tbody>

	<?

			echo traepartida(1,0);

		?>			

	</tbody>
	
</table>
</div>
</div>

</form>
<?
echo "<br>";
include("../main/f_footer.php");
?>
</body>

</html>
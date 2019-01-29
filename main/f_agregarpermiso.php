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
	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close();\"></body></html>";
		exit();
		}
	if($IDL<2)
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
		}	
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	} 

if(isset($_GET['idusuario']))
	$idusuario=$_GET['idusuario'];
else
	{
	if(isset($_POST['idusuario']))
		$idusuario=$_POST['idusuario'];
	else		
		exit();		
	}

if(isset($_GET['idmodulo']))
	$idmodulo=$_GET['idmodulo'];
else
	{
	if(isset($_POST['idmodulo']))
		$idmodulo=$_POST['idmodulo'];
	else		
		$idmodulo=0;		
	}
	
if(isset($_GET['idcata']))
	$idcata=$_GET['idcata'];
else
	{
	if(isset($_POST['idcata']))
		$idcata=$_POST['idcata'];
	else		
		$idcata=0;		
	}

if(isset($_GET['m']))
	$backmodulo=$_GET['m'];
else
	$backmodulo="";
	

if(isset($_GET['accion']))	
	{	
	$accion=$_GET['accion'];
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$tipo=$_GET['nivel'];
		
		$modulo=traedato("adm_modulos","id",$idmodulo,"S","modulo");
		$nombre=traedato("adm_modulos","id",$idmodulo,"S","nombre");
		$elusuario=traedato("adm_usuarios","id",$idusuario,"S","nombre");
				
		$csql = "INSERT INTO `adm_permisos` (`idusuario` , `idmodulo`,`modulo`, `tipo` ,`ultactfec` , `ultactusu`) ";
		$csql .= "VALUES ('$idusuario','$idmodulo','$modulo','$tipo',NOW(),'$IDUser');";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }
		else
			$id=mysqli_insert_id($conexio);
						
		
		loguea("Permisos",$idusuario,"Agregar",$IDU,$IDName,"Se agrego un nuevo permiso: '$nombre' al usuario '$elusuario' nivel: '$tipo'");
		echo "<html><head><title>Permiso Guardado</title></head><body onLoad=\"w2=window.opener; w2.location.reload(); window.location.href='f_agregarpermiso.php?m=$nombre&idcata=$idcata&idusuario=$idusuario';\"></body></html>";
		exit();
		#Fin guardado
		}
	}


$idms="''";
$consulta="Select idmodulo from adm_permisos where idusuario='$idusuario'";
$res = mysqli_query($conexio, $consulta);
while($val8=mysqli_fetch_array($res))
	$idms .=",'".$val8[0]."'";						
mysqli_free_result($res);

if($idcata==0)	
	$idcatav="<option selected value='0'>(seleccione)</option>";
else
	$idcatav="<option value='0'>(seleccione)</option>";
$csql = "SELECT * from adm_modcatego where idpadre=0 order by descripcion;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx))
	{
	$descripcion=$val['descripcion'];
	if($val['id']==$idcata)
		$idcatav.="<option selected value=".$val['id'].">$descripcion</option>";				
	else
		$idcatav.="<option value=".$val['id'].">$descripcion</option>";
	}
mysqli_free_result($resx);

if($idmodulo!=0)
	{
	$csql = "SELECT * from `adm_modulos` WHERE `id` = '$idmodulo';";
	$res2 = mysqli_query($conexio, $csql);
	if($val5=mysqli_fetch_array($res2))
		{
		$categoria=traedato("adm_modcatego","id",$idcata,"S","descripcion");
		$idcatb=$val5['idcatb'];
		$modulo=$val5['modulo'];
		$idcatbv=traedato("adm_modcatego","id",$idcatb,"S","descripcion");
		$categoria .=" / $idcatbv";
		$nombre=$val5['nombre'];
		$descripcion=$val5['descripcion'];
		$maxniveles=$val5['maxniveles'];
		$nivelv="<option selected value='1'>1</option>";
		for($j=2;$j<=$maxniveles;$j++)
			$nivelv .="<option value='$j'>$j</option>";
		$niveles=$val5['niveles'];		
		}
	mysqli_free_result($res2);	
	}
else
	{
	$categoria="";
	$nombre="";
	$modulo="";
	$descripcion="";
	$maxniveles=0;
	$nivelv="";
	$niveles="";	
	}

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Agregar Permiso</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

function guardar()
	{
	document.edicion.accion.value=1;
	document.edicion.submit();
	}

</SCRIPT>
</head>


<body>
<form method="GET" name="edicion" target="_self">
<div class="container-fluid">

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td><? echo "<h3>Agregar Permisos</h3>";  ?></td>
		<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
	</tr>
</table>	


<?
if($backmodulo!="")
	echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  Permiso <strong>$backmodulo</strong> agregado con éxito. 
</div>";

?>

<? if($idmodulo!=0){?>
<div class="well well-sm">
  <div class="row">
    <div class="col-sm-8">
      <h4>Permiso Nuevo:</h4>
      <p>
      	<table border="0" width="100%" id="table11" cellspacing="0" cellpadding="0">
			<tr>
				<td width="136" align="right"><font face="Arial" size="2">Categoría:</font></td>
				<td width="8">&nbsp;</td>
				<td><font size="2" face="Arial" color="#000080"><?echo $categoria;?></font></td>
			</tr>
			<tr>
				<td width="136" align="right"><font face="Arial" size="2">Nombre:</font></td>
				<td width="8">&nbsp;</td>
				<td><font size="2" face="Arial" color="#000080"><b><?echo $nombre;?></b></font></td>
			</tr>
			<tr>
				<td width="136" align="right"><font face="Arial" size="2">Descripción:</font></td>
				<td width="8">&nbsp;</td>
				<td><font size="2" face="Arial" color="#000080"><?echo $descripcion;?></font></td>
			</tr>
			<tr>
				<td width="136" align="right"><font face="Arial" size="2">Nivel:</font></td>
				<td width="8">&nbsp;</td>
				<td>				
				<select size="1" name="nivel" style="width:150px; font-family: Arial; font-size: 10pt; color: #000080">
				<?echo $nivelv;?>
				</select></td>
			</tr>
			<tr>
				<td width="136" align="right">&nbsp;</td>
				<td width="8">&nbsp;</td>
				<td><font size="2" face="Arial" color="#000080"><?echo $niveles;?></font></td>
			</tr>
		</table>
      </p>
    </div>
    
    <div class="col-sm-4">
    <br>
      <p align='center'><button type='button' onclick="guardar();" class='btn btn-success'>Agregar Permiso Ahora</button></p>
    </div>
  </div>
</div>


<?}?>
<table border="0" width="100%" id="table11" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100" align="left" height="25"><b><font face="Arial" size="2">Menú:</font></b></td>
		<td align="left" height="25">
			<select size="1" name="idcata" onchange="document.edicion.submit();" style="font-family: Arial; font-size: 10pt">
			<? echo $idcatav;?>
			</select>
		</td>
	</tr>
</table>

<table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th width='150'><font face="Arial" size="2">Categoría</font></th>
        <th width='150'><font face="Arial" size="2">Nombre</font></th>
        <th><font face="Arial" size="2">Descripción</font></th>
      </tr>
    </thead>
    <tbody>
<?
	$grupoi="";
	$cuantos=0;
	$k=1;
	$color="bgcolor='#FFFFFF'";
	$consulta="Select a.id, b.descripcion as categoria, a.nombre, a.descripcion
	from adm_modulos a
	left join adm_modcatego as b on a.idcatb=b.id
	where a.id not in($idms) and a.status='1' and a.idcata='$idcata' order by categoria,nombre";
					#echo $consulta;
	$res = mysqli_query($conexio, $consulta);
	while($val8=mysqli_fetch_array($res))
		{
		$cuantos +=1;
		$idmodulom=$val8['id'];
		$categoriam=$val8['categoria'];
		if($categoriam==$grupoi)
			$categoriam="&nbsp;";
		else
			$grupoi=$categoriam;
		$nombrem=$val8['nombre'];
		$descripcionm=$val8['descripcion'];
		if($idmodulo==$idmodulom)
			{
			$color="color='#808080'";
			$linko="";
			}
		else
			{
			$color="color='#000000'";
			$linko="<a href='#' onclick=\"window.location.href='f_agregarpermiso.php?idusuario=$idusuario&idcata=$idcata&idmodulo=$idmodulom'\";>";
			}
		#if($categoriam!="&nbsp;" && $cuantos!=1)
		#	echo "<tr><td colspan='5' height='10' bgcolor='#E9E9E9'></td></tr>";
		echo "<tr>
		<td width='150' align='left'><font face='Arial' size='2' $color>$categoriam</font></td>
		<td width='200' align='left'><font face='Arial' size='2' $color>$linko".$nombrem."</a></font></td>
		<td align='left'><font face='Arial' size='2' $color>$descripcionm</font></td>						
		</tr>";					
		}
	mysqli_free_result($res);
?>
	</tbody>					
</table>

</div>

<input type="hidden" name="idusuario" <?echo "value='$idusuario'";?>>
<input type="hidden" name="idmodulo" <?echo "value='$idmodulo'";?>>
<input type="hidden" name="modulo" <?echo "value='$modulo'";?>>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
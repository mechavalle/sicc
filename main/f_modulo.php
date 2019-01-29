<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");


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
	$IDL=permiso("AdminModulos",$IDU);
	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo. ($IDL)'); window.close(); \"></body></html>";
		exit();
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

if(isset($_POST['accion']))	
	{
	$accion=$_POST['accion'];
	if($accion==1 || $accion==3)
		{
		$idcata=$_POST['idcata'];
		$idcatb=$_POST['idcatb'];
		$nombre=$_POST['nombre'];
		$modulo=$_POST['modulo'];
		$descripcion=$_POST['descripcion'];
		$maxniveles=$_POST['maxniveles'];
		$niveles=$_POST['niveles'];
		$status=$_POST['status'];
		if(Existe("adm_modulos","id",$id)=="NE")
			{
			$csql = "INSERT INTO `adm_modulos` (`idcata`,`idcatb`,`nombre`,";
			$csql .="`modulo`,`descripcion`,`maxniveles`,`niveles`,`status`,`ultactfec`,`ultactusu`) ";
			$csql .="VALUES ('$idcata','$idcatb','$nombre',";
			$csql .="'$modulo','$descripcion','$maxniveles','$niveles','$status',NOW(),'$IDUser');";
			}
		else{
			$csql = "UPDATE `adm_modulos` SET `idcata`='$idcata', `idcatb`='$idcatb',`nombre`='$nombre',";
			$csql .="`modulo`='$modulo', `descripcion`='$descripcion', `maxniveles`='$maxniveles', `niveles`='$niveles', `status`='$status',";
			$csql .="`ultactfec`=NOW(), `ultactusu`='$IDUser' ";
			$csql .="WHERE `id`='$id';";
			}
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="") {
			echo "ERROR: "."Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		else
			{
			if($id=="-1")
				$id=mysqli_insert_id($conexio);
			}

	#Fin guardado
	
		if($accion==1)
			echo "<html><head><title>Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.location.href='f_modulo.php?id=$id'; \"></body></html>";
		if($accion==3)
			echo "<html><head><title>Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.location.href='f_modulo.php'; \"></body></html>";
		exit();

		#Fin guardado
		}
		
	if($accion==2)
		{
		$modulo=traedato("adm_modulos","id",$id,"S","modulo");

		$cuantos=traedato2("select ifnull(count(id),0) as resu from adm_permisos where modulo='$modulo'","resu");

		if($cuantos>0)
			{
			echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" alert('No es posible borrar este modulo, porque existen permisos que lo utilizan'); window.close(); \"></body></html>";
			exit();			
			}
		
		$csql="DELETE FROM adm_modulos WHERE id='$id'";
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al borrar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }
		
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" alert('Registro(s) borrado(s) con éxito'); ww=window.opener; ww.location.reload(); window.close(); \"></body></html>";
		exit();
		}
		
	}
	
if($id!="-1")
	{
	$csql = "SELECT * from `adm_modulos` WHERE `id` = '$id';";
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		{
		$idcata=$val5['idcata'];
		if($idcata==0)	
			$idcatav="<option selected value='0'>(seleccione)</option>";
		else
			$idcatav="<option value='0'>(seleccione)</option>";
		$csql = "SELECT * from adm_modcatego where idpadre=0 order by descripcion;";
		$resx = mysqli_query($conexio,$csql);
		while($val=mysqli_fetch_array($resx))
			{
			$descripcion=$val['descripcion'];
			if($val['id']==$idcata)
				$idcatav.="<option selected value=".$val['id'].">$descripcion</option>";				
			else
				$idcatav.="<option value=".$val['id'].">$descripcion</option>";
			}
		mysqli_free_result($resx);
			
		$idcatb=$val5['idcatb'];
		if($idcata!=0)
			{			
			if($idcatb==0)	
				$idcatbv="<option selected value='0'>(seleccione)</option>";
			else
				$idcatbv="<option value='0'>(seleccione)</option>";
			$csql = "SELECT * from adm_modcatego where idpadre='$idcata' and status='1' order by descripcion;";
			$resx = mysqli_query($conexio,$csql);
			while($val=mysqli_fetch_array($resx))
				{
				$descripcion=$val['descripcion'];
				if($val['id']==$idcatb)
					$idcatbv.="<option selected value=".$val['id'].">$descripcion</option>";				
				else
					$idcatbv.="<option value=".$val['id'].">$descripcion</option>";
				}
			mysqli_free_result($resx);
			}
		else
			$idcatbv="<option selected value='0'>-</option>";		
		
		$nombre=$val5['nombre'];
		$modulo=$val5['modulo'];
		#$grupo=$val5['grupo'];
		$descripcion=$val5['descripcion'];
		$maxniveles=$val5['maxniveles'];
		$niveles=$val5['niveles'];
		$status=$val5['status'];
		if($status==1)
			$statusv="<option selected value=1>Activo</option><option value=0>Inactivo</option>";
		else
			$statusv="<option value=1>Activo</option><option selected value=0>Inactivo</option>";
		$ultima=$val5['ultactusu']." el ".fixfecha($val5['ultactfec']);		
		}
	mysqli_free_result($res2);	
	}
else
	{
	$idcata=0;
	$idcatav="<option selected value='0'>(seleccione)</option>";
	$csql = "SELECT * from adm_modcatego where idpadre=0 order by descripcion;";
	$resx = mysqli_query($conexio,$csql);
	while($val=mysqli_fetch_array($resx))
		{
		$descripcion=$val['descripcion'];
		$idcatav.="<option value=".$val['id'].">$descripcion</option>";
		}
	mysqli_free_result($resx);
			
	$idcatb=0;
	$idcatbv="<option selected value='0'>-</option>";		
	$nombre="";
	#$grupo="";
	$modulo="";
	$descripcion="";
	$maxniveles="";
	$niveles="";
	$status=1;
	$statusv="<option selected value=1>Activo</option><option value=0>Inactivo</option>";
	$ultima="";
	}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editar de Módulos</title>
	<script SRC="../lib/fns.js"></script>
	<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
	<script src="../lib/jquery.min.js"></script>
	<script src="../lib/boot/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
	<script type="text/javascript" src="../lib/whizzywig61.js"></script>
	<link rel="stylesheet" href="../lib/stlinks.css">
	<script type="text/javascript">
		function llenapol0()
			{
			document.getElementById("divpol0").innerHTML="<select size='1' name='idcatb' class='cenboxfrm'>-</select>";
			conexion1=crearXMLHttpRequest();
		 	conexion1.onreadystatechange = prollenapol0;
			conexion1.open("GET", "f_e_llenacombos.php?id="+document.edicion.idcata.options[document.edicion.idcata.selectedIndex].value+"&hoy="+hoy(true), true);
			conexion1.send(null);
			}
			
		function prollenapol0()
		{
		  if(conexion1.readyState == 4)
		  {
		    if(Left(conexion1.responseText,5)=="ERROR")
		    	{
		    	alert (conexion1.responseText);
		    	document.getElementById("divpol0").innerHTML="<select size='1' name='idcatb' class='cenboxfrm'>"+res+"</select>";
		    	}
		    else{
		    	var res=String(conexion1.responseText);
		    	document.getElementById("divpol0").innerHTML="<select size='1' name='idcatb' class='cenboxfrm'>"+res+"</select>";	 
		    	}
		  } 
		}


		function guardar(valor)
			{
			document.edicion.accion.value=valor;
			syncTextarea();	
			document.edicion.submit();
			}

		function borrar()
			{
			if(confirm("¿Esta usted seguro de borrar este registro?"))
				{
				document.edicion.accion.value='2';	
				document.edicion.submit();
				}
			}	
			
			
	</script>
</head>

<body>
<form method="POST" name="edicion" target="_self">
	<div style="padding: 0 20px;">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td><? echo "<h3>Editar Módulo</h3>";  ?></td>
				<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
			</tr>
		</table>



		<div class="btn btn-success btn-xs"><a style="color: #fff;" onclick="guardar(3);">Guardar +</a></div>
		<div class="btn btn-success btn-xs"><a style="color: #fff;" onclick="guardar(1);">Guardar</a></div>
		<div class="btn btn-danger btn-xs"><a style="color: #fff;" onclick="borrar();">Borrar</a></div>
		
		<br><br>

		<div class="table-responsive"> 
		<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="0">
			<tr>
				<td align="right" width="100"><font face="arial" size="2">Status:</font></td>
				<td width="5">&nbsp;</td>
				<td>
					<select size="1" name="status" class='cenboxfrm'>
					<?echo $statusv;?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" width="100"><font face="arial" size="2">
				Categoría:</font></td>
				<td width="5">&nbsp;</td>
				<td>
					<select size="1" name="idcata" class="cenboxfrm" onchange="llenapol0();">
				<?echo $idcatav;?>
				</select>
				</td>
			</tr>

			<tr>
				<td align="right" width="100"><font face="arial" size="2">Subcategoría:</font></td>
				<td width="5">&nbsp;</td>
				<td>
				<div id="divpol0"><select size="1" name="idcatb" class="cenboxfrm">
				<?echo $idcatbv;?>
				</select></div>
				</td>
			</tr>

			<tr>
				<td align="right" width="100"><font face="arial" size="2">
				Modulo:</font></td>
				<td width="5">&nbsp;</td>
				<td>
				<input type="text" name="modulo"  class="cenboxfrm" <?echo "value='$modulo'";?>></td>
			</tr>

			<tr>
				<td align="right" width="100" height="19">
				<font face="arial" size="2">Nombre:</font></td>
				<td width="5" height="19">&nbsp;</td>
				<td height="19">
				<input type="text" name="nombre"  class="cenboxfrm" <?echo "value='$nombre'";?>></td>
			</tr>

			<tr>
				<td align="right" width="100"><font face="arial" size="2">
				Descripción:</font></td>
				<td width="5">&nbsp;</td>
				<td>
					<textarea rows="4" name="descripcion" cols="55"  class="cenboxfrm" style="height: 100px"><? echo $descripcion;?></textarea></td>
			</tr>

			<tr>
				<td align="right" width="100"><font face="arial" size="2">Max. 
				Niveles:</font></td>
				<td width="5">&nbsp;</td>
				<td>
				<input type="text" name="maxniveles"  class="cenboxfrmmin" <?echo "value='$maxniveles'";?>></td>
			</tr>

			<tr>
				<td align="right" width="100"><font face="arial" size="2">
				Desc. Niveles:</font></td>
				<td width="5">&nbsp;</td>
				<td>
						<textarea id="contenido" rows="4" name="niveles" cols="55"  class="cenboxfrm"><? echo $niveles;?></textarea>
				<script type="text/javascript">
				//buttonPath = "../lib";
				//buttonExt=".png";
				//cssFile="../lib/inc/simple.css";
				makeWhizzyWig("contenido", "formatblock fontname fontsize newline bold italic underline | left center right justify | number bullet indent outdent | undo redo | color hilite rule | table | spellcheck fullscreen");
				</script>		
						
						</td>
			</tr>
		</table>
		</div>
		<br>
		<font face="arial" size="1" color="#808080">Ultima Actualización: <?echo $ultima;?></font>

		<input type="hidden" name="id" <?echo "value='$id'";?>>
		<input type="hidden" name="valor" value=''>
		<input type="hidden" name="accion" value='0'>
	</div>
</form>
</body>

</html>
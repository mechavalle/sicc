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


if(isset($_POST['accion']))
	$accion=$_POST['accion'];
else
	$accion=0;
	
if($accion==1)
		{
		if(strlen(basename($_FILES['mixml']['name']))>0)
			{
			$extension=extension(basename($_FILES['mixml']['name']));	
			$nuevonombre =MD5(date("Y-m-d h:i:s")).".".$extension;
			$uploadfile = "../rec/".$nuevonombre;	
			
			if(subearchivo("mixml",$uploadfile)!="OK")
				{
				echo "Hubo un error al intentar mover a: $uploadfile";
				exit();
				}
			 $xml = simplexml_load_file($uploadfile);
			  $salida =0;
			  foreach($xml->permiso1 as $item)
			  	{
			  	$status=$item->status;
			  	$idcatav=utf8_decode($item->idcatav);
			  	$idcatbv=utf8_decode($item->idcatbv);
			  	$modulo=utf8_decode($item->modulo);
			  	$nombre=utf8_decode($item->nombre);
			  	$descripcion=utf8_decode($item->descripcion);
			  	$maxniveles=$item->maxniveles;
			  	$niveles=utf8_decode($item->niveles);
			  	$salida=1;
			    /*$salida .=
			      "<b>Status:</b> " . $item->status . "<br/>".
			      "<b>Categoria:</b> " . utf8_decode($item->idcatav) . "<br/>".
			      "<b>Subcategoria:</b> " . utf8_decode($item->idcatbv) . "<br/>".
			      "<b>Modulo:</b> " . utf8_decode($item->modulo) . "<br/><hr/>";
			     */
			  	}
			 if($salida==1)
			 	{
			 	mysql_select_db("cen");
			 	#verificamos si existe la categoria
			 	$idcata=traedato("adm_modcatego","descripcion",$idcatav,"N","id");
			 	if($idcata<=0)
			 		{
			 		#como no existe, creamos a la categoria
			 		$csql = "INSERT INTO `adm_modcatego` (`descripcion`,`status`,`ultactfec`,`ultactusu` )";
					$csql .="VALUES ('$idcatav','1',NOW(),'$IDUser');";
					mysqli_query($conexio,$csql);
					if(mysqli_error($conexio)!="") {
						echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
						exit(); }
					else
						$idcata=mysqli_insert_id($conexio);
						
					#generamos subcategoria
					$csql = "INSERT INTO `adm_modcatego` (`idpadre`,`descripcion`,`status`,`ultactfec`,`ultactusu` )";
					$csql .="VALUES ('$idcata','$idcatbv','1',NOW(),'$IDUser');";
					mysqli_query($conexio,$csql);
					if(mysqli_error($conexio)!="") {
						echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
						exit(); }
					else
						$idcatb=mysqli_insert_id($conexio);

			 		}
			 	else
			 		{
			 		#veamos si existe la sub categoria
			 		$idcatb=traedato2("select id from adm_modcatego where idpadre='$idcata' and descripcion='$idcatbv'","id");
			 		if($idcatb<0)
			 			{
			 			#generamos subcategoria
						$csql = "INSERT INTO `adm_modcatego` (`idpadre`,`descripcion`,`status`,`ultactfec`,`ultactusu` )";
						$csql .="VALUES ('$idcata','$idcatbv','1',NOW(),'$IDUser');";
						mysqli_query($conexio,$csql);
						if(mysqli_error($conexio)!="") {
							echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
							exit(); }
						else
							$idcatb=mysqli_insert_id($conexio);
			 			}			 		
			 		} #else idcata
			 	
				#ya validadas las categorias, agregamos el modulo
				
				$csql = "INSERT INTO `adm_modulos` (`idcata`,`idcatb`,`nombre`,";
				$csql .="`modulo`,`descripcion`,`maxniveles`,`niveles`,`status`,`ultactfec`,`ultactusu`) ";
				$csql .="VALUES ('$idcata','$idcatb','$nombre',";
				$csql .="'$modulo','$descripcion','$maxniveles','$niveles','1',NOW(),'$IDUser');";	
			 	mysqli_query($conexio,$csql);
			 	if(mysqli_error($conexio)!="") 
			 		{
					echo "Error al grabar el registro. ".mysqli_error($conexio)."->$conexio";
					exit(); 
					}
				else
					{
					echo "<html><head><title>Guardado</title></head><body onLoad=\" alert('Información importada con éxito, modulo ".$modulo." generado'); window.location.href='f_consultamodulos.php'; \"></body></html>";
					}
			 		
			 	} #fin salida=1
			#echo $salida;
			exit();											
			} #fin if
		} #fin del accion=1



if(isset($_GET['modulo']))	
	$modulo=$_GET['modulo'];
else 
	{
	if(isset($_POST['modulo']))	
		$modulo=$_POST['modulo'];
	else 
		$modulo="";
	}
	
		
		$consulta = "SELECT a.id, b.descripcion as categoria, c.descripcion as subcategoria, a.modulo, a.nombre, a.descripcion,a.status
		FROM adm_modulos a 
		left join adm_modcatego as b on a.idcata=b.id
		left join adm_modcatego as c on a.idcatb=c.id
		where a.id>0 ";
		$consultaT1="";
				
		if($modulo!="")
			$consultaT1 .="(a.modulo like '%".$modulo."%') ";			
	
		$consulta2="";
		if($consultaT1!="")
			$consulta2 .="AND ".$consultaT1;
		
		#echo $consulta;
		#exit("");
		
mysqli_query($conexio,$consulta);
$total=mysqli_affected_rows($conexio);

if(isset($_POST['limite'])){
	$limite=$_POST['limite'];
	if($total<=25){
		if($limite==" ")
			$limitev="<option  value=' ' selected>Todo</option>";
		else
			$limitev="<option  value=' '>Todo</option>";			
		}
	else {
		if($limite==" ")
			$limitev="<option value=' ' selected>Todo</option>";
		else
			$limitev="<option value=' '>Todo</option>";			
		$sub=-1;
		$k=0;
		while($sub+25<=$total-1){
			$k=$k+1;
			$limiter=sprintf("LIMIT %s,%s",$sub+1,25);
			#$limitev .=sprintf("<option selected value='%s'>%s-%s</option>",$limiter,$sub+2,$sub+26);
			if($limite==$limiter)				
				$limitev .=sprintf("<option selected value='%s'>%s</option>",$limiter,$k);
			else				
				$limitev .=sprintf("<option value='%s'>%s</option>",$limiter,$k);
			$sub=$sub+25;
			}
		if($sub<$total-1)
			{
			$k=$k+1;
			$limiter=sprintf("LIMIT %s,%s",$sub+1,25);
			if($limite==$limiter)
				$limitev .=sprintf("<option selected value='%s'>%s</option>",$limiter,$k);
			else
				$limitev .=sprintf("<option value='%s'>%s</option>",$limiter,$k);
			}
		}
	}	
else {
	#Calculamos limite
	if($total<=25){
		$limitev="<option value=' ' selected>Todo</option>";			
		$limite =" ";}
	else {		
		$limitev="<option value=' '>Todo</option>";			
		$sub=-1;
		$limiter=sprintf("LIMIT %s,%s",$sub+1,25);
		$k=1;
		$limitev .=sprintf("<option selected value='%s'>%s</option>",$limiter,$k);
		$sub=24;
		while($sub+25<=$total-1){
			$k=$k+1;
			$limiter=sprintf("LIMIT %s,%s",$sub+1,25);
			$limitev .=sprintf("<option value='%s'>%s</option>",$limiter,$k);
			$sub=$sub+25;
			}
		if($sub<$total-1)
			{
			$k=$k+1;
			$limiter=sprintf("LIMIT %s,%s",$sub+1,25);
			$limitev .=sprintf("<option value='%s'>%s</option>",$limiter,$k);
			}
		$limite="LIMIT 0,25";
		}
	}
	

$consulta .=$consulta2."ORDER BY categoria,subcategoria,nombre ".$limite;

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../img/icono.png" type="image/x-icon">
	<title>Consulta de Módulos</title>
	<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
	<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
	<script src="../lib/jquery-2.1.1.min.js"></script>
	<script src="../lib/boot/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
	<script type="text/javascript">
		function importar(){
		document.edicion.accion.value=1;
		document.edicion.submit();
		}
		
	</script>
</head>
<body>
<form name="edicion" method="POST" target="_self" enctype="multipart/form-data">
	<?
	$mnu="configuracion";
    include("f_header.php");
    ?>

	<div style="padding: 0 20px;">
		<p>
		<h3><font color="#888888">Consulta <font color='#ff0000'>Módulos</font></font></h3>
		</p>

		<div class="well well-sm">
		<table border="0" width="100%" id="table5" cellspacing="0" cellpadding="0">
			<tr>
				<td height="27">
					<font face="Verdana" size="1">Módulo</font><font size="2">:&nbsp;</font>
					<input type="text" name="modulo" size="31" onkeypress="if(event.keyCode==13) document.edicion.submit();" value="<?echo $modulo;?>" style="font-size: 10px; ">
				</td>
		
				<td align="right" height="27">
					<a href="#"  onclick="document.edicion.submit();"><span class="glyphicon glyphicon-refresh"></span><font size="1" face="Verdana">refrescar</font></a>
					&nbsp; |&nbsp;
					<a href="#"  onclick="window.location.href='f_consultamodulos.php';"><span class="glyphicon glyphicon-circle-arrow-left"></span>
					<font size="1" face="Verdana">limpiar</font>
					</a>
				</td>
			</tr>
		</table>
		</div>

		<div>
		<a class="btn btn-success btn-xs" onclick="abre('modulo','f_modulo.php',800,600,'YES');"><font face="arial" size="2"> Crear Nuevo</font></a>
		<br><br>
		</div>


		<font face="Verdana" size="1" color="#808080">(<? echo $total; ?>&nbsp;Registros)</font>
		<font face="Verdana" size="1">Página: </font>
		<select size="1" name="limite" style="color: #30009B; font-size: 10px" onchange="document.edicion.submit();"><?= $limitev ?>
		</select>
				
		<table class="table table-striped">	
				<tr>
					<td>
						<b><font face="Arial" size="2">Categoría</font></b>
					</td>				
					<td>
						<b><font face="Arial" size="2">Subcategoría</font></b>
					</td>				
					<td>
						<b><font face="Arial" size="2">Módulo</font></b>
					</td>				
					<td>
						<b><font face="Arial" size="2">Nombre</font></b>
					</td>				
					<td>
						<b><font face="Arial" size="2">Descripción</font></b>
					</td>				
					<td>
						<b><font size="2" face="Arial">Status</font></b>
					</td>				
				</tr>
					
				<?
				#echo $consulta;
				#exit();		
				$res = mysqli_query($conexio,$consulta);
				$k=1;				
				while($val=mysqli_fetch_array($res))
					{
					$k=-1*$k;
					if($k==1)
						$color="bgcolor='#E8E6F3'";
					else
						$color="";
					$mid=$val['id'];
					$mcategoria=$val['categoria'];
					$msubcategoria=$val['subcategoria'];
					$mmodulo=$val['modulo'];
					$mnombre=$val['nombre'];
					$mdescripcion=$val['descripcion'];				
					if($val['status']=="1")
						{
						$fcolor="color='#000000'";
						$statusv="Activo";
						}
					else
						{
						$fcolor="color='#808080'";
						$statusv="Inactivo";
						}
					$link="<a href='#' onClick=\"abre('modulo','f_modulo.php?id=$mid',800,600,'YES');\">";
					echo "<tr>";
					echo "<td $color align='left'>$link<font face='arial' size='2' $fcolor>$mcategoria</font></a></td>";
					echo "<td $color align='left'>$link<font face='arial' size='2' $fcolor>$msubcategoria</font></a></td>";
					echo "<td $color align='left'>$link<font face='arial' size='2' $fcolor>$mmodulo</font></a></td>";
					echo "<td $color align='left'>$link<font face='arial' size='2' $fcolor>$mnombre</font></a></td>";
					echo "<td $color align='left'>$link<font face='arial' size='2' $fcolor>$mdescripcion</font></a></td>";
					echo "<td $color align='center'><font face='arial' size='2' $fcolor>$statusv</font></a></td>";
					echo "</tr>";
					}
				mysqli_free_result($res);
				?>			
		</table>

		<input type="file" onchange="importar();" class="form-control campotxt" id="mixml" placeholder="" name="mixml" style="display: none;" size="1">
		<input type="hidden" name="accion" value='0'>
	</div>
</form>
</body>

</html>
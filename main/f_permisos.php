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
	$IDL2=permiso("adminLogs",$IDU);
	if($IDL<1)
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

if(isset($_GET['id']))
	$id=$_GET['id'];
else
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else		
		exit();		
	}

if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==2)
		{
		$idpermiso=$_POST['idpermiso'];
		$csql="DELETE FROM `adm_permisos` WHERE `id`='$id'";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" alert('Registro borrado con éxito'); window.location.href='f_permisos.php?id=$id'; \"></body></html>";
		exit();

		}
	if($accion==3)
		{
		$csql="DELETE FROM `adm_permisos` WHERE `idusuario`='$id'";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al eliminar registros. ".mysqli_error($conexio)." ->$csql";
			exit(); }
		$elusuario=traedato("adm_usuarios","id",$id,"S","nombre");
		loguea("Permisos",$id,"Borrado",$IDU,"$IDUser eliminó todos los permisos al usuario '$elusuario'");		
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" window.location.href='f_permisos.php?id=$id'; \"></body></html>";
		exit();

		}
	}

#Realizamos la consulta para traer los valores
$csql = "SELECT * from `adm_usuarios` WHERE `id` = '$id';";
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{
	$mail=$val5['mail'];
	$nombre=$val5['nombre'];
	$usuario=$val5['usuario'];
	$empresa=$val5['empresa'];	
	$comentario=$val5['comentario'];
	$ultima=fixfecha($val5['ultactfec'])." ".$val5['ultactusu'];
	}
mysqli_free_result($res2);	

if(isset($_POST['idcata']))
	$idcata=$_POST['idcata'];
else
	$idcata=0;

if($idcata==0)	
	$idcatav="<option selected value='0'>Todos</option>";
else
	$idcatav="<option value='0'>Todos</option>";
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

if(isset($_POST['idcatb']))
	$idcatb=$_POST['idcatb'];
else
	$idcatb=0;	
if($idcatb==0)	
	$idcatbv="<option selected value='0'>Todos</option>";
else
	$idcatbv="<option value='0'>Todos</option>";
if($idcata!=0)
	{
	$csql = "SELECT * from adm_modcatego where idpadre='$idcata' order by descripcion;";
	$resx = mysqli_query($conexio, $csql);
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


$modulos=array();					
$misdatos=array();
					
$consulta="Select a.id,b.descripcion as categoria, c.descripcion as subcategoria,a.nombre,a.descripcion,a.niveles 
	from adm_modulos a 
	left join adm_modcatego as b on a.idcata=b.id
	left join adm_modcatego as c on a.idcatb=c.id 
	where a.id>0 ";
$consultaT1="";
$consultaT2="";

if($idcata!=0)
	$consultaT1 ="(a.idcata='$idcata' ) ";	
if($idcatb!=0)
	$consultaT1 ="(a.idcatb='$idcatb' ) ";	

$consulta2="";
if($consultaT1!="")
	$consulta2 .="AND ".$consultaT1;
if($consultaT2!="")
	$consulta2 .="AND ".$consultaT2;
$res = mysqli_query($conexio, $consulta.$consulta2." order by categoria,subcategoria,nombre");
while($val8=mysqli_fetch_array($res))
	{
	$misdatos[0]=$val8['categoria'];
	$misdatos[1]=$val8['subcategoria'];
	$misdatos[2]=$val8['nombre'];
	$misdatos[3]=$val8['descripcion'];
	$misdatos[4]=$val8['niveles'];
	$misdatos[5]=$val8['id'];
	array_push($modulos,$misdatos);						
	}
	mysqli_free_result($res);
# Termina obtencion de datos de cen


$conexio=conecta($IDBase);
	
	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Permisos de <?echo $nombre;?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/stlinks.css">
<SCRIPT LANGUAGE="JavaScript">

function borrar(id)
 {
 if (confirm("¿Realmente desea borrar este Permiso?."))
 	{ 	
 	document.edicion.accion.value=2;
 	document.edicion.idpermiso.value=id;
 	document.edicion.submit();
 	}
}

function guardar()
	{
	if(document.edicion.nombre.value=="")
		{alert("Especifique el Nombre del usuario");
		return "0";}
	if(document.edicion.usuario.value=="")
		{alert("Especifique el Usuario");
		return "0";}
	document.edicion.submit();
	}
	
function eliminapermisos()
	{
	if(confirm('Todos los permisos serán eliminados, ¿Continuar?'))
		{
		document.getElementById('divboton1').innerHTML="<p align='center'><font color='#808080' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
		document.getElementById('divboton2').innerHTML="";
		document.edicion.accion.value=3;
		document.edicion.submit();
		}
	}

function go()
	{
	document.getElementById("divboton2").innerHTML="<i class='fa fa-refresh fa-spin fa-2x'></i>";
	document.edicion.submit();
	}
</SCRIPT>
<style type="text/css">


</style>
</head>


<body>
<form method="POST" name="edicion" target="_self">
	<div class="container-fluid">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td><? echo "<h3>Permisos de <font color='#ff0000'>$nombre</font></h3>";  ?></td>
				<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
			</tr>
		</table>	

		<span id='divboton1'>
			<button type='button' onclick="abre('copiar','f_copiarpermisos.php?id='+document.edicion.id.value,800,600,'YES');" class='btn btn-primary btn-xs'>Copiar Permisos a...</button>
			<?if($IDL>=3)
				echo "&nbsp;<button type='button' onClick=\"window.location.href='f_usuarios.php?id=$id';\" class='btn btn-primary btn-xs'>Editar Usuario</button>";
			?>
			<?if($IDL>=4)
				echo "&nbsp;<button type='button' onClick=\"eliminapermisos();\" class='btn btn-danger btn-xs'>Borrar todos los Permisos</button>";
			?>
		</span>
		<br>
		<br>
		<div class="row">
		  	<div class="col-sm-12">
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
					<tr>
						<td width="150" align="right" height="25">
						<font face="Arial" size="2">Nombre Completo:</font></td>
						<td width="5" align="left" height="25">
						</td>
						<td align="left" height="25" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom-style: dotted; border-bottom-width: 1px">
						<font size="2" face="Arial" color="#000080"><?echo $nombre;?></font>
						</td>
					</tr>
					<tr>
						<td width="150" align="right" height="25">
						<font face="Arial" size="2">Usuario:</font></td>
						<td width="5" align="left" height="25">
						</td>
						<td align="left" height="25" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom-style: dotted; border-bottom-width: 1px">
						<font size="2" face="Arial" color="#000080"><?echo $usuario;?></font></td>
					</tr>
					<tr>
						<td width="150" align="right" height="25">
						<font face="Arial" size="2">Correo:</font></td>
						<td width="5" align="left" height="25">
						</td>
						<td align="left" height="25" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom-style: dotted; border-bottom-width: 1px">
						<font size="2" face="Arial" color="#000080"><?echo $mail;?></font></td>
					</tr>
					<tr>
						<td width="150" align="right" height="25">
						<font face="Arial" size="2">Empresa:</font></td>
						<td width="5" align="left" height="25">
						</td>
						<td align="left" height="25" style="border-left-width: 1px; border-right-width: 1px; border-top-width: 1px; border-bottom-style: dotted; border-bottom-width: 1px">
						<font size="2" face="Arial" color="#000080"><?echo $empresa;?></font></td>
					</tr>
					<tr>
						<td width="150" align="right" height="25">
						<font face="Arial" size="2">Comentarios:</font></td>
						<td width="5" align="left" height="25">
						</td>
						<td align="left" height="25">
						<font size="2" face="Arial" color="#000080"><?echo $comentario;?></font>
						</td>
					</tr>
				</table>
			</div>			
		</div>


		<br>
		<h4>Permisos Otorgados</h4>
		<div class="well well-sm">
			<div class="row">
				<div class="col-sm-4">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td width="60" height="20">
								<font size="2" face="Arial">Módulo:</font>
							</td>
							<td>
								<select size="1" class="cenbox" name="idcata" onchange="document.edicion.idcatb.options[document.edicion.idcatb.selectedIndex].value=0;  go();">
									<?echo $idcatav;?>
								</select>
							</td>
						</tr>				
					</table>
				</div>		
				<div class="col-sm-4">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td width="60" height="20">
								<font size="2" face="Arial">Categoría:</font>
							</td>
							<td>
								<select size="1" class="cenbox" name="idcatb" onchange="go();">
									<?echo $idcatbv;?>
								</select>
							</td>
						</tr>				
					</table>
				</div>
				<div class="col-sm-4">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td height="20" align="right">
								<a href="#" onclick="go();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>
								&nbsp;|&nbsp;<a href="#"  onclick="window.location.href='f_permisos.php?id='+document.edicion.id.value;"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;<font size="1" face="Verdana">Limpiar</font></a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<span id='divboton2'>
			<button type='button' onclick="abre('permisonuevo','f_agregarpermiso.php?idusuario='+document.edicion.id.value,800,500,'YES');" class='btn btn-primary btn-xs'>Agregar nuevo permiso</button>
			<?if($IDL2>=1)
				echo "&nbsp;<button type='button' onclick=\"abre('log','f_consultalog.php?idorigen='+document.edicion.id.value,1000,600,'YES');\" class='btn btn-primary btn-xs'>Ver log</button>";
			?>
		</span>

		<table class='table table-condensed table-hover'>
							    <thead>
							      <tr>
							        <th><font face='Arial' size='2'>Módulo</font></th>
							        <th><font face='Arial' size='2'>Categoría</font></th>
							        <th><font face='Arial' size='2'>Nombre</font></th>
							        <th><font face='Arial' size='2'>Nivel</font></th>
							      </tr>
							    </thead>
							    <tbody>

<?
					
#echo "<pre>".print_r($modulos,true)."</pre>";					
					$conexio=conecta($IDBase);			
					$grupoh="";
					$grupoi="";
					$cuantos=0;
					$k=1;
					$color="bgcolor='#FFFFFF'";
					$i=count($modulos);

					for($j=0;$j<$i;$j++)
						{
						$idmodulo=$modulos[$j][5];
						
						$consulta="Select * from adm_permisos where idusuario='$id' and idmodulo='$idmodulo'";
						$res = mysqli_query($conexio, $consulta);
						if($val8=mysqli_fetch_array($res))
							{
							$cuantos +=1;
							$idpermiso=$val8['id'];
							$idmodulo=$val8['idmodulo'];
							$modulo=$val8['modulo'];
							$categoriam=$modulos[$j][0];
							$subcategoriam=$modulos[$j][1];
							
							if($subcategoriam==$grupoh)
								$subcategoriam="&nbsp;";
							else
								$grupoh=$subcategoriam;							
							if($categoriam==$grupoi)
								$categoriam="&nbsp;";
							else
								$grupoi=$categoriam;
														
							$nombrem=$modulos[$j][2];
							$rollom=$modulos[$j][3];
							$tipo=$val8['tipo'];
							$color="";
							if($categoriam!="&nbsp;" && $subcategoriam!="&nbsp;" && $cuantos!=1)
								echo "<tr><td colspan='5' height='10' bgcolor='#E9E9E9'></td></tr>";
							$link="<a href='#' onclick=\"abre('permiso','f_actualizarpermiso.php?id=$idpermiso',800,300,'YES');\">";
							echo "<tr>
							<td align='left' $color><font face='Arial' size='2' color='#000000'>$categoriam</font></td>
							<td align='left' $color><font face='Arial' size='2' color='#000000'>$subcategoriam</font></td>
							<td align='left' $color>$link<font face='Arial' size='2' color='#000000'>$nombrem</font></a></td>
							<td align='center' $color>$link<font face='Arial' size='2' color='#000000'>$tipo</font></a></td>
							</tr>";					
							}
						mysqli_free_result($res);
						}

					
					?>
					
				</table>

				
<hr color="#808080" style="height: 1px">
<font face="Verdana" size="1" color="#808080">Última Actualización: <? echo $ultima;?></font>
</div>
<input type="hidden" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="idpermiso" value='0'>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
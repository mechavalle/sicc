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
	$IDL3=permiso("AdminClientesExp",$IDU);
	
	
	if($IDL<=0)
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
if(isset($_GET['titulo']))	
	$titulo=$_GET['titulo'];
else 
	$titulo="1";	
	
if(isset($_GET['idcli']))	
	$idcli=$_GET['idcli'];
else 
	$idcli="";
if(isset($_GET['nombre']))	
	$nombre=$_GET['nombre'];
else 
	$nombre="";	
if(isset($_GET['rfc']))	
	$rfc=$_GET['rfc'];
else 
	$rfc="";
	
if(isset($_GET['estado']))	
	$estado=$_GET['estado'];
else 
	$estado="";
if($estado=="")
	$estadov="<option selected value=''>Todo</option>";
else
	$estadov="<option value=''>Todo</option>";
$csql = "SELECT * from `cat_estadosrep` where status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
	{
	if($val['descripcion']==$estado)
		$estadov.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
	else
		$estadov.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
	}
mysqli_free_result($resx);

if(isset($_GET['integradora']))	
	$integradora=$_GET['integradora'];
else 
	$integradora="";
if($integradora=="")
	$integradorav="<option selected value=''>Todo</option>";
else
	$integradorav="<option value=''>Todo</option>";
$csql = "SELECT * from `cat_integradoras` where status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
	{
	if($val['descripcion']==$integradora)
		$integradorav.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
	else
		$integradorav.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
	}
mysqli_free_result($resx);

if(isset($_GET['asesor']))	
	$asesor=$_GET['asesor'];
else 
	$asesor="";
if($asesor=="")
	$asesorv="<option selected value=''>Todo</option>";
else
	$asesorv="<option value=''>Todo</option>";
$consulta="select a.nombre from adm_usuarios a left join adm_permisos as b on a.id=b.idusuario where b.modulo='AdminClientes' and b.tipo>='2' and a.status='1'";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	{
	if($val['nombre']==$asesor)
		$asesorv.="<option selected value='".$val['nombre']."'>".$val['nombre']."</option>";
	else
		$asesorv.="<option value='".$val['nombre']."'>".$val['nombre']."</option>";
	}
mysqli_free_result($resx);

if(isset($_GET['fecha1']))
	$fecha1=$_GET['fecha1'];
else
	$fecha1="";

if(isset($_GET['fecha2']))
	$fecha2=$_GET['fecha2'];
else
	$fecha2="";

if($fecha1=="")
	$fecha1v="&#8734;";
else
	$fecha1v=fixfecha($fecha1);

if($fecha2=="")
	$fecha2v="&#8734;";
else
	$fecha2v=fixfecha($fecha2);
if($fecha1v==$fecha2v)
	$fechav=$fecha1v;
else
	$fechav=$fecha1v." - ".$fecha2v;

if(isset($_GET['status']))
	$status=$_GET['status'];
else
	$status="0";
if($status=="0")
	$statusv="<option selected value='0'>Todo</option>";
else
	$statusv="<option value='0'>Todo</option>";
$csql = "SELECT * from `cat_statuscliente` where status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
	{
	if($val['id']==$status)
		$statusv.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
	else
		$statusv.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
	}
mysqli_free_result($resx);	
	
if(isset($_GET['accion']))	
	$accion=$_GET['accion'];
else
	$accion=0;

#####################################	
$consulta = "SELECT a.id,a.nombre,a.apellidop,a.apellidom,a.rfc,a.estadof,a.idcli,a.integradora,a.asesor,a.fecha,a.valorneto,a.docmust,a.status,b.descripcion as statusv,b.color   
 FROM `cat_clientes` a
 left join cat_statuscliente as b on a.status=b.id
  where a.id>0 ";
		$consultaT1="";
		$consultaT2="";
		$consultaT3="";
		$consultaT4="";
		$consultaT5="";
		$consultaT6="";
		$consultaT7="";
		$consultaT8="";
		$consultaT9="";

		if($idcli!="")
			$consultaT1 .="(cast(a.idcli as SIGNED) = '$idcli' ) ";
		if($nombre!="")
			$consultaT2 .="(a.apellidop like '%$nombre%' or a.apellidom like '%$nombre%' or a.nombre like '%$nombre%' ) ";			
		if($rfc!="")
			$consultaT3 .="(a.rfc = '$rfc' ) ";	
		if($estado!="")
			$consultaT4 .="( a.estadof='$estadof' ) ";
		if($integradora!="")
			$consultaT5 .="( a.integradora='$integradora' ) ";
		if($asesor!="")
			$consultaT6 .="( a.asesor='$asesor' ) ";
		if($fecha1!="")
			$consultaT7 .="( a.fecha>='$fecha1 00:00:01' ) ";
		if($fecha2!="")
			$consultaT8 .="( a.fecha<='$fecha2 23:59:59' ) ";
		if($status!="0")
			$consultaT9 .="(a.status = '$status' ) ";

			
		$consulta2="";
		if($consultaT1!="")
			$consulta2 .="AND ".$consultaT1;
		if($consultaT2!="")
			$consulta2 .="AND ".$consultaT2;
		if($consultaT3!="")
			$consulta2 .="AND ".$consultaT3;
		if($consultaT4!="")
			$consulta2 .="AND ".$consultaT4;
		if($consultaT5!="")
			$consulta2 .="AND ".$consultaT5;
		if($consultaT6!="")
			$consulta2 .="AND ".$consultaT6;
		if($consultaT7!="")
			$consulta2 .="AND ".$consultaT7;
		if($consultaT8!="")
			$consulta2 .="AND ".$consultaT8;
		if($consultaT9!="")
			$consulta2 .="AND ".$consultaT9;
			
		#echo $consulta;
		#exit("");

mysqli_query($conexio, $consulta.$consulta2);
$total=mysqli_affected_rows($conexio);		

if(isset($_GET['limite'])){
	$limite=$_GET['limite'];
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
	
if(isset($_GET['orden']))	
	$orden=$_GET['orden'];
else 
	$orden="eco asc";

if(isset($_GET['orden']))
	{	
	if($_GET['orden']=="idcli asc")
		$ordenv="<option selected value='idcli asc'>id</option><option value='apellidop asc'>Nombre</option><option value='status asc'>Status</option><option value='tipo asc'>Tipo</option>";		
	if($_GET['orden']=="tipo asc")
		$ordenv="<option value='idcli asc'>id</option><option value='apellidop asc'>Nombre</option><option value='status asc'>Status</option><option selected value='tipo asc'>Tipo</option>";
	if($_GET['orden']=="apellidop asc")
		$ordenv="<option value='idcli asc'>id</option><option selected value='apellidop asc'>Nombre</option><option value='status asc'>Status</option><option value='tipo asc'>Tipo</option>";
	if($_GET['orden']=="status asc")
		$ordenv="<option value='idcli asc'>id</option><option value='apellidop asc'>Nombre</option><option selected value='status asc'>Status</option><option value='tipo asc'>Tipo</option>";
	$orden=$_GET['orden'];
	}
else {
	$ordenv="<option selected value='idcli asc'>id</option><option value='apellidop asc'>Nombre</option><option value='status asc'>Status</option><option value='tipo asc'>Tipo</option>";
	$orden="cast(idcli as SIGNED) asc"; }





if($accion==1)
	{
	$csql=$consulta.$consulta2;
	$resx = mysqli_query($conexio, $csql);
	while($val=mysqli_fetch_array($resx))
		{
		$idp=$val['id'];
		$nacimientop=$val['nacimiento'];
		$dias = explode("-", $nacimientop,3);
		$dias = mktime(0,0,0,$dias[1],$dias[2],$dias[0]);
		$edad = (int)((time()-$dias)/31556926 );
		$csql="UPDATE cat_operadores set edad='$edad' where id='$idp'";
		mysqli_query($conexio,$csql);
		if(mysqli_error($conexio)!="")
			echo "Error al borrar el registro. ".mysqli_error($conexion)." $csql";
		}
	mysqli_free_result($resx);
	}	

$consulta .=$consulta2."ORDER BY ".$orden." ".$limite;
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Consulta Capital Humano</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<script src="../lib/jquery-2.1.1.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<link rel="stylesheet" href="../lib/style.css">
<SCRIPT LANGUAGE="JavaScript">
window.recargar = function(){
	document.edicion.submit();
	}
</SCRIPT>
</head>
<body topmargin="0">
<form method="GET" name="edicion" target="_self">
	<?
	$mnu="vistas";
    include("../main/f_header.php");
    ?>
	<div style="padding: 0 20px;">
		<? if($titulo==1)
			echo "<p><h3><font color='#888888'>Clientes</font></h3></p>";
		?>

		<div class="well well-sm">
			<div class="row">
				<div class="col-sm-4">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td width="90" height="20"><font face="Verdana" size="1">ID:</font></td>
							<td><input type="text" name="idcli" class='cenboxmin' onkeypress="if(event.keyCode==13) document.edicion.submit();" value="<?echo $idcli;?>"></td>
						</tr>
						<tr>
							<td width="90" height="20"><font face="Verdana" size="1">RFC:</font></td>
							<td>
								<input type="text" name="rfc" class='cenboxmin' onkeypress="if(event.keyCode==13) document.edicion.submit();" value="<?echo $rfc;?>">			
							</td>
						</tr>
						<tr>
							<td width="90" height="20"><font face="Verdana" size="1">Integradora:</font></td>
							<td>
								<select size="1" name="integradora" class="cenboxmin" onchange="document.edicion.submit();">
									<?echo $integradorav;?>
								</select>
							</td>
						</tr>
						<tr>
						<td width="60" height="20">
							<ul class="nav navbar-nav">
						      <li class="dropdown"><a style="padding: 0px !important;" class="dropdown-toggle" data-toggle="dropdown" href="#"><font face="Verdana" size="1" color="#000000">Fecha</font><span class="caret"></span></a>
								<ul class="dropdown-menu">
						          <li>
						          	<a href='#' onclick="abre('selfecha','../main/f_selfecha.php?tipo=1',100,100,'NO');"><font size='1' face='Verdana'>por Día</font></a>
						          </li>
						          <li>
						          	<a href='#' onclick="abre('selfecha','../main/f_selfecha.php?tipo=2',100,100,'NO');"><font size='1' face='Verdana'>por Semana</font></a>
						          </li>
						          <li>
						          	<a href='#' onclick="abre('selfecha','../main/f_selfecha.php?tipo=3',100,100,'NO');"><font size='1' face='Verdana'>por Mes</font></a>
						          </li>
						          <li>
						          	<a href='#' onclick="abre('selfecha','../main/f_selfecha.php?tipo=4',100,100,'NO');"><font size='1' face='Verdana'>por Rango</font></a>
						          </li>
						        </ul>
						       </li>
						    </ul>
						</td>
						<td height="20">
							<b><font face="Verdana" size="1" color="#000080"><div style="display: inline;" id="divfecha"><? echo $fechav;?></div></font></b>
						</td>
					</tr>				
					</table>
				</div>		
				<div class="col-sm-4">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td width="90"><font face="Verdana" size="1">Nombre:</font></td>
							<td>
								<input type="text" name="nombre" class='cenbox' onkeypress="if(event.keyCode==13) document.edicion.submit();" value="<?echo $nombre;?>">
							</td>
						</tr>
						<tr>
							<td width="90"><font face="Verdana" size="1">Estado:</font></td>
							<td>
								<select size="1" name="estado" class="cenboxmin" onchange="document.edicion.submit();">
									<?echo $estadov;?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="90"><font face="Verdana" size="1">Asesor:</font></td>
							<td>
								<select size="1" name="asesor" class="cenboxmin" onchange="document.edicion.submit();">
									<?echo $asesorv;?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="90"><font face="Verdana" size="1">Status:</font></td>
							<td>
								<select size="1" name="status" class="cenbox" onchange="document.edicion.submit();">
									<?echo $statusv;?>
								</select>
							</td>
						</tr>							
					</table>
				</div>
				<div class="col-sm-4">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td align="right">
								<a href="#"  onclick="document.edicion.submit();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>
								&nbsp;|&nbsp;<a href="#"  onclick="window.location.href='f_consultaclientes.php';"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;<font size="1" face="Verdana">Limpiar</font></a>
								<?
								if($IDL3>=1)
									echo "&nbsp;|&nbsp;<a href='f_consultaoperador_ex.php?idper=$idper&nombre=$nombre&tipo=$tipo&status=$status&idscat_organigrama=$idscat_organigrama&hoy=".date("h i s")."' target='blank'><span class='glyphicon glyphicon-download-alt'></span>&nbsp;<font size='1' face='Verdana'>Exportar</font></a>";							
								?>
							</td>
						</tr>
														
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<?
				if($IDL>=3)
					echo "<button type='button' onClick=\" abre('padmin','f_clienteini.php',850,600,'YES'); \" class='btn btn-primary btn-xs'>Crear Nuevo</button>";	
				?>
			</div>
			
		</div>

		<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
			<tr>
				<td width="150" align="left"><font face="Verdana" size="1" color="#808080">(<? echo $total; ?>&nbsp;Registros)</font></td>
				<td width="40" align="right"><font face="Verdana" size="1">Página:</font></td>
				<td width="5" align="right"></td>
				<td align="left" width="119"><select size="1" name="limite" style="color: #30009B; font-size: 10px" onchange="document.edicion.submit();">
				<?echo $limitev;?></select></td>
				<td width="100" align="right"><font face="Verdana" size="1">Ordenar por:</font></td>
				<td width="5" align="right"></td>
				<td align="left"><select size="1" name="orden" style="color: #30009B; font-size: 10px" onchange="document.edicion.submit();">
				<?echo $ordenv;?></select></td>
			</tr>
		</table>

		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
			      	<tr>
			      		<th><font size="2" face="Arial">ID</font></th>
			      		<th><font size="2" face="Arial">Nombre</font></th>
			      		<th><font size="2" face="Arial">RFC</font></th>
			      		<th><font size="2" face="Arial">Estado</font></th>
			      		<th><font size="2" face="Arial">Ingreso</font></th>
			      		<th><font size="2" face="Arial">Integradora</font></th>
			      		<th><font size="2" face="Arial">Asesor</font></th>
			      		<th><font size="2" face="Arial">Monto</font></th>
			      		<th><font size="2" face="Arial">Documentación</font></th>
			      		<th><font size="2" face="Arial">Status</font></th>
			      	</tr>
			    </thead>      	  
			    <tbody>

				
				<?
				$imgtabla=traedato("adm_archivos","modulo","clientes","N","tabla");
				#echo $consulta;
				#exit();	
				$hoy=date("Y-m-d");	
				$res = mysqli_query($conexio, $consulta);
				$k=1;			
				while($val=mysqli_fetch_array($res))
					{
					$vid=$val['id'];
					$nombrecompleto=$val['apellidop']." ".$val['apellidom']." ".$val['nombre'];
					if(trim($nombrecompleto)=="")
						$nombrecompleto="&nbsp;";

					$vrfc=$val['rfc'];
					$vestado=$val['estadof'];
					$vfecha=fixfecha($val['fecha']);
					$vintegradora=$val['integradora'];
					$vasesor=$val['asesor'];
					$vvalorneto=fixmontosin($val['valorneto']);
					$colof="color='".$val['color']."'";
					$vstatus=$val['statusv'];
					$color="";

					$vdocmust=$val['docmust'];				
					$cdoc=traedato2("Select ifnull(count(id),0) as resu from $imgtabla where idorigen='$vid' and tipo='must' and archivo!=''","resu");
					$vdoc="$cdoc de $vdocmust";
			
					$link="<a href='#' onClick=\"abre('popera','f_clienter.php?id=".$val['id']."',850,600,'YES');\">";
					echo "<tr>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>".$val['idcli']."</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>".$nombrecompleto."</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vrfc</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vestado</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vfecha</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vintegradora</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vasesor</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vvalorneto</font></a></td>";
					echo "<td $color>$link<font size='2' face='Arial' $colof>$vdoc</font></a></td>";
					echo "<td $color><font size='2' fa2e='Arial' $colof>$vstatus</font></td>";
					echo "</tr>";
					}
				mysqli_free_result($res);
				?>			
				</tbody>
			</table>
		</div>	
	</div>
<?
echo "<br>";
include("../main/f_footer.php");
?>
<input type="hidden" id="fecha1" name="fecha1" <?echo "value='$fecha1'";?>>
<input type="hidden" id="fecha2" name="fecha2" <?echo "value='$fecha2'";?>>
<input type="hidden" id="accion" name="accion" value=''>
</form>
</body>
</html>
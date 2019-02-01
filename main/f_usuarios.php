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
	if($IDL<3)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su nivel de acceso es insuficiente para acceder.'); window.close();\"></body></html>";
		exit();
		}	
	$_SESSION['permiso']=md5("adminUsuarios".date("Y-m-d").$IDUser);
	session_write_close();
			
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
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		{ #va a ser nuevo		
		$id=-1;
		}
	}
	

if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$status=$_POST['status'];
		$nombre=$_POST['nombre'];		
		$usuario=$_POST['usuario'];	
		$mail=$_POST['mail'];
		$empresa=$_POST['empresa'];
		if($id=="-1")	
			$password= MD5($_POST['password']);	
		$comentario=$_POST['comentario'];


		#1.2 Verificamos si existe el ID enviado

		if(Existe("adm_usuarios","id",$id)=="NE")
			{
	   		#1.3 Nuevo. Comienza el guardado
	   		#echo $monto;
	   		#exit();
			$cuantos=cuenta("adm_usuarios","id","usuario='$usuario'");
			if($cuantos>0)
				{
				echo "<html><head><title>Usuario Guardado</title></head><body onLoad=\" alert('El usuario $usuario, ya existe'); window.location.href='f_usuarios.php';\"></body></html>";
				exit();
				}	
			$csql = "INSERT INTO `adm_usuarios` ( `nombre` , `usuario`, `password` , `mail` , `comentario` ,";
			$csql .="`empresa` ,`status` , `ultactfec` , `ultactusu`) ";
			$csql .= "VALUES ('$nombre','$usuario','$password','$mail','$comentario', ";
			$csql .="'$empresa','1',NOW(),'$IDUser');";
			$nid=1;
			}
		else{
			$csql = "UPDATE `adm_usuarios` SET `nombre`='$nombre' , `usuario`='$usuario', `empresa`='$empresa',";
			$csql .= "`mail`='$mail',`comentario`='$comentario',`status`='$status',`ultactfec`=NOW() , `ultactusu`='$IDUser' ";
			$csql .="WHERE `id`='$id';";					
			}
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		else
			{
			if($id=="-1")
				{
				$id=mysqli_insert_id($conexio);

				$csql = "INSERT INTO `rel_usuarios` ( `idusuario`, `idempresa`) VALUES ('$id','1');";
				mysqli_query($conexio, $csql);
				if(mysqli_error($conexio)!="") {
					echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
					exit(); }
				loguea("Usuarios",$id,"Agregar",$IDU,$IDName,"$IDUser creó al usuario '$nombre'");
				}
			else
				loguea("Usuarios",$id,"Editar",$IDU,$IDName,"$IDUser edito al usuario '$nombre'");				
			}
			
		echo "<html><head><title>Usuario Guardado</title></head><body onLoad=\" w2=window.opener; w2.location.reload(); window.close(); \"></body></html>";
		exit();
		#Fin guardado
		}

	if($accion==2)
		{		

		$csql="DELETE FROM `adm_permisos` WHERE `idusuario`='$id'";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "ERROR: Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }
			
		$elusuario=traedato("adm_usuarios","id",$id,"S","nombre");
		#echo "usuario=$elusuario";
		$csql="DELETE FROM `adm_usuarios` WHERE `id`='$id'";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)." ->$csql";
			exit(); }

		loguea("Usuarios",$id,"Borrar Permisos",$IDU,$IDName,"$IDUser borró los permisos de '$elusuario' porque será borrado");
		loguea("Usuarios",$id,"Borrar Usuario",$IDU,$IDName,"$IDUser borró al usuario '$elusuario'");
		
		echo "<html><head><title>Registro Borrado</title></head><body onLoad=\" alert('Registro borrado con éxito'); wx=window.opener; wx.location.reload(); window.close(); \"></body></html>";
		exit();

		}

	}
else{ #Fin del existe 'Accion'
	if($id!="-1")
		{
		$csql = "SELECT * from `adm_usuarios` WHERE `id` = '$id';";
		$res2 = mysqli_query($conexio, $csql);
		if($val5=mysqli_fetch_array($res2))
			{
			$mail=$val5['mail'];
			$nombre=$val5['nombre'];
			$usuario=$val5['usuario'];
			

			$password="&nbsp;*****&nbsp;&nbsp;";

			$empresa=$val5['empresa'];
			$csql="SELECT * from adm_empresas where status='1' order by razon";
			if($empresa=="")
				$empresav="<option selected value=''>(sin especificar)</option>";
			else
				$empresav="<option value=''>(sin especificar)</option>";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				{		
				if($empresa==$val['razon'])
					$empresav.="<option selected value='".$val['razon']."'>".$val['razon']."</option>";
				else
					$empresav.="<option value='".$val['razon']."'>".$val['razon']."</option>";
				}
			mysqli_free_result($resx);

			$status=$val5['status'];
			$statusv="";			
			if($status=="0")
				$statusv="<option value='1'>Activo</option><option selected value='0'>Inactivo</option>";			
			if($status=="1")
				$statusv="<option selected value='1'>Activo</option><option value='0'>Inactivo</option>";
			if($status=="2")
				$statusv="<option selected value='1'>Activo</option>";
			$comentario=$val5['comentario'];
			$ultima=fixfecha($val5['ultactfec'])." ".$val5['ultactusu'];
			}
		mysqli_free_result($res2);	

		}
	else #es nuevo
		{
			$mail="";
			$nombre="";
			$usuario="";
			$password="";
			$status="1";
			$statusv="<option selected value='1'>Activo</option><option value='0'>InActivo</option>";
			$comentario="";
			$empresa="";
			$csql="SELECT * from adm_empresas where status='1' order by razon";
			$empresav="<option selected value=''>(sin especificar)</option>";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				$empresav.="<option value='".$val['razon']."'>".$val['razon']."</option>";
			mysqli_free_result($resx);
			$ultima="";
		}
}
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?if($id=="-1")
	echo "<title>Usuario Nuevo</title>";
else
	echo "<title>Usuario $nombre</title>";
	?>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<SCRIPT LANGUAGE="JavaScript">

function borrar()
 {
 if (confirm("¿Realmente desea borrar este usuario?."))
 	{ 	
 	document.edicion.accion.value=2;
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
<? if($id<=0){ ?>		
	if(document.edicion.password.value=="")
		{alert("Especifique una contraseña");
		return "0";}
	if(document.edicion.password.value!=document.edicion.password2.value)
		{alert("Las contraseñas no coinciden");
		return "0";}
<?}?>
	document.edicion.accion.value=1;
	document.edicion.submit();
	}

</SCRIPT>
<style type="text/css">

</style>
</head>


<body>
<form name="edicion" method="POST" target="_self" enctype="multipart/form-data">
<div class="container-fluid">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><? echo "<h3>Editar <font color='#ff0000'>Usuario</font></h3>";  ?></td>
			<td width="33" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>	

	<span id='divboton'>
		<button type='button' onClick="guardar();" class='btn btn-success btn-xs'>Guardar</button>
<?if($IDL>=4 && $id>0 && $status!=2)
		echo "&nbsp;<button type='button' onClick=\"borrar();\" class='btn btn-danger btn-xs'>Borrar</button>";
?>
	</span>
	<br>
	<br>

	<div class="row">
		<div class="col-sm-12">
			<table border="0" width="500" id="table3" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Status:</font></td>
					<td><select class="cenboxfrm" name="status" style="color: red;">
							<?echo $statusv;?>
						</select>
					</td>				
				</tr>
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Usuario:</font></td>
					<td>
						<input class="cenboxfrm" type="text" name="usuario" <?echo "value='$usuario'";?>>
					</td>				
				</tr>
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Nombre Completo:</font></td>
					<td>
						<input class="cenboxfrm" type="text" name="nombre" <?echo "value='$nombre'";?>>
					</td>				
				</tr>				
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Empresa:</font></td>
					<td><select class="cenboxfrm" size="1" name="empresa">
							<?echo $empresav;?>
						</select>
					</td>				
				</tr>
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Correo:</font></td>
					<td>
						<input class="cenboxfrm" type="text" name="mail" <?echo "value='$mail'";?>>
					</td>				
				</tr>
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Contraseña:</font></td>
					<td>
<?if($id=="-1"){?>
						<input class="cenboxfrm" type="text" name="password" <?echo "value='$password'";?>>
<?} else
		{
		echo "<font face='Arial' size='2'>$password</font>";
		echo "<button type='button'  onclick=\"abre('login','f_cambiopassadmin.php?id='+document.edicion.id.value,550,300,'NO');\" class='btn btn-warning btn-xs'>Cambiar contraseña actual</button>";
		}
?>
					</td>				
				</tr>
<?if($id=="-1"){?>				
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Ratifique Contraseña:</font></td>
					<td>
						<input class="cenboxfrm" type="text" name="password2">
					</td>				
				</tr>
<?}?>
				<tr>
					<td align="right" width="150" height="25"><font face="Arial" size="2">Comentarios:</font></td>
					<td>
						<textarea class="cenboxfrm" name="comentario" style="height: 150px"><? echo $comentario;?></textarea>
					</td>				
				</tr>
			</table>
		</div>
	</div>
	<br>
	<font face="Arial" size="1" color="#808080">Ultima Actualización: <? echo $ultima;?></font>

</div>

<input type="hidden" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
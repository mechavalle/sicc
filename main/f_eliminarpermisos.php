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

if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==1 )
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$ids=$_POST['ids'];
		$ids=substr($ids,1,strlen($ids));
		
		$csql="delete from adm_permisos where idusuario in($ids)";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "<html><head><title>Error</title></head><body onLoad=\" alert('Error al ejecutar query.: ".mysqli_error($conexio)."-> $csql'); window.close();\"></body></html>";			
			exit(); }
			
		echo "<html><head><title>OK</title></head><body onLoad=\" alert('Eliminación Realizada'); window.close();\"></body></html>";
		exit();
		}
	}	

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eliminar Permisos</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

function go()
	{
	var ids="";	
	if(confirm('¿Iniciar el borrado?'))
		{
		document.getElementById("divboton").innerHTML="<i class='fa fa-refresh fa-spin fa-2x'></i>";	
		for(i=0;i<document.edicion.length;i++)
			{
	  		if(document.edicion.elements[i].type=="checkbox")
	  			if(document.edicion.elements[i].checked==true)//alert(x.elements[i].value);  
	  				ids=ids+","+document.edicion.elements[i].name;  				
	  		}
	  	//alert (ids);
	  	if(ids=="")
	  		window.close();
	  	else
	  		{		
			document.edicion.ids.value=ids;
			document.edicion.accion.value=1;
			document.edicion.submit();	
			}
		}
	}


	
function seltodo()
	{
	for(i=0;i<document.edicion.length;i++)
		{
  		if(document.edicion.elements[i].type=="checkbox")
  			document.edicion.elements[i].checked=true;
  		}
	}
	
function selnada()
	{
	for(i=0;i<document.edicion.length;i++)
		{
  		if(document.edicion.elements[i].type=="checkbox")
  			document.edicion.elements[i].checked=false;
  		}
	}

</SCRIPT>
<style type="text/css">
	/* Note: Try to remove the following lines to see the effect of CSS positioning */
  .affix {
      top: 0;
      width: 100%;
  }

  .affix + .container-fluid {
      padding-top: 70px;
  }

  .navbar-default {
    text-align: center;
    padding: 10;
}
</style>
</head>


<body>
<form method="POST" name="edicion" target="_self">
	<div class="container-fluid">
		<div class="row" style=" padding: 10px;">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td><? echo "<h3>Eliminar <font color='#ff0000'>Permisos</font></h3>";  ?></td>
					<td width="100" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
				</tr>
			</table>	
		</div>
		<nav class="navbar navbar-default" data-spy="affix" data-offset-top="50">
			<div id='divboton'><button type='button' onclick="go();" class='btn btn-danger'>Borrar Ahora</button></div>
		</nav>

		<p align="center">
		<b><font face="Arial" size="2">Seleccione los Usuarios a quien se les Borrarán todos los permisos</font></font></b>
		<br>
		<font face="Verdana" size="1">seleccionar: <a href="#" onclick="seltodo();">Todo</a> | <a href="#" onclick="selnada();">Ningúno</a></font>
		<br>
		<table class="table" style="width: 70%;">
	    	<tbody>
<?

				$consulta = "SELECT * FROM adm_usuarios where id not in(1) and status='1' order by nombre asc";
					$res = mysqli_query($conexio, $consulta);
					while($val8=mysqli_fetch_array($res)){
						$idusu=$val8['id'];						
						$nombre=$val8['nombre'];
												
						echo "<tr><td><input type='checkbox' name='$idusu' value='1' style='width: 20px; height: 20px'>&nbsp;&nbsp;
						<font face='Arial' size='2'>$nombre</font></td>
						</tr>";						
						}
					mysqli_free_result($res);					
?>
			</tbody>
		</table>

	</p>


<input type="hidden" name="ids" value=''>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
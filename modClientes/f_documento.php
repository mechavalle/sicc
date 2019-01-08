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
	$IDL=permiso("AdminClientesFor",$IDU);
	
	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
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
############

function asigna($variable)
	{
	if(isset($_POST[$variable]))
		return $_POST[$variable];
	else
		return "";
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
		if(isset($_GET['idpersona']))
			$idpersona=$_GET['idpersona'];
		else
			{
			if(isset($_POST['idpersona']))
				$idpersona=$_POST['idpersona'];
			else
				{echo "falta idpersona"; 
				exit();
				}
			}		
		}
	}

#$descripcion=traedato("adm_documentos","identificador","operacontrato1","N","descripcion");

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nuevo Documento</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript">

function siguiente() 
	{
	varcuenta=lacuenta();
	if(varcuenta=="0")
		{
		alert('Seleccione un documento');
		return "";		
		}
	//alert(varcuenta);
	window.location.href="f_operacontrato.php?idformato="+varcuenta+"&idpersona="+document.edicion.idpersona.value;	
	//window.location.href="f_"+varcuenta+".php?idpersona="+document.edicion.idpersona.value;	
	}

function lacuenta()
    {
        var resultado="0";
        
        var porNombre=document.getElementsByName("docs");
        // Recorremos todos los valores del radio button para encontrar el
        // seleccionado
        for(var i=0;i<porNombre.length;i++)
        {
            if(porNombre[i].checked)
                resultado=porNombre[i].value;
        }
     return resultado;
    }

</SCRIPT>


</head>


<body>
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">
	<div class="row" style=" padding: 10px;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><? echo "<h3>Seleccione el tipo de Formato</h3>";  ?></td>
			<td width="33" align="right"><div id="divclose"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></div></td>
		</tr>
	</table>	
	</div>
		
<?

	$consulta="Select * from adm_documentos where identificador like 'clienteformato%' and status='1' order by descripcion asc";
	$res = mysqli_query($conexio, $consulta);
	$i=0;
	while($val8=mysqli_fetch_array($res))
		{
		$i +=1;
		$vid=$val8['id'];
		$videntificador=$val8['identificador'];
		$vdescripcion=$val8['descripcion'];
		echo "<div style='padding: 5px 50px;'><a href='f_cliformato.php?idformato=$videntificador&idpersona=$idpersona'><span class='glyphicon glyphicon-hand-right' style='font-size: 20px;'></span>&nbsp;&nbsp;<font face='Arial' size='2' color='#000000'>$vdescripcion</font></a></div>";
		}
	mysqli_free_result($res);

if($i>0)
	{
	echo "<br>
<p align='center'>
	<button type='button' onClick=\"siguiente();\" class='btn btn-success'>Siguiente &gt;&gt;</button>
</p>";
	}
?>	

<input type="hidden" name="id" <?echo "value='$id'"?>>
<input type="hidden" name="idpersona" <?echo "value='$idpersona'"?>>
<input type="hidden" name="accion" value="0">
</div>
</form>
</body>

</html>
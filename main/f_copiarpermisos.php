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
		exit();		
	}
	
if($id!=-1)
	{
	if(Existe("adm_usuarios","id",$id)=="NE")
		{
		echo "<html><head><title>Usuario No existe</title></head><body onLoad=\" window.close();\"></body></html>";
		exit();
		}
	}

$nombreusuario=traedato("adm_usuarios","id",$id,"S","nombre");
$usuario1=traedato("adm_usuarios","id",$id,"S","nombre");


if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==1 )
		{
		#1. Obtenemos array de permisos origen
		$arrdato=array();
		$arrpermisos=array();
		$csql="SELECT * from adm_permisos where idusuario='$id'";
		$resx = mysqli_query($conexio, $csql);
		while($val=mysqli_fetch_array($resx))
			{	
			$arrdato[0]=$val['idmodulo'];
			$arrdato[1]=$val['modulo'];
			$arrdato[2]=$val['tipo'];
			array_push($arrpermisos,$arrdato);
			}
		mysqli_free_result($resx);

		#2. Complementamos info de los usuarios a copiar
		$ids=$_POST['ids'];
		$ids=substr($ids,1,strlen($ids));
		$arrdato=array();
		$arrusuarios=array();
		$csql="SELECT * from adm_usuarios where id in($ids)";
		$resx = mysqli_query($conexio, $csql);
		while($val=mysqli_fetch_array($resx))
			{
			$arrdato[0]=$val['id'];
			$arrdato[1]=$val['nombre'];
			array_push($arrusuarios,$arrdato);
			}
		mysqli_free_result($resx);

/*echo "<pre>".print_r($arrusuarios,true)."</pre>";
echo "<pre>".print_r($arrpermisos,true)."</pre>";	
echo "Empresa ->$empresa";	
exit();*/	

		#3. Abrimos la empresa destino

		$csql="delete from adm_permisos where idusuario in($ids)";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "<html><head><title>Error</title></head><body onLoad=\" alert('Error al ejecutar query -> $csql'); window.close(); \"></body></html>";			
			exit(); }
		
		$maxi=count($arrusuarios);
		$maxj=count($arrpermisos);

		for ($i = 0; $i < $maxi; $i++)
			{		
			$csql="INSERT INTO `adm_permisos` (`idusuario`, `idmodulo`, `modulo`, `tipo`, `ultactfec`, `ultactusu`) VALUES ";

			for ($j = 0; $j <$maxj; $j++)			
				$csql .="('".$arrusuarios[$i][0]."','".$arrpermisos[$j][0]."','".$arrpermisos[$j][1]."','".$arrpermisos[$j][2]."',NOW(),'$IDUser'),";

			$csql=substr($csql,0,strlen($csql)-1).";";
			mysqli_query($conexio, $csql);
			#echo $csql."</br>";
			
			if(mysqli_error($conexio)!="")
				{
				echo "<html><head><title>Error</title></head><body onLoad=\" alert('Error al ejecutar query. ".mysqli_error($conexio)." -> $csql'); window.close(); \"></body></html>";			
				exit(); 
				}

			loguea("Usuarios",$arrusuarios[$i][0],"Copiar Permisos",$IDU,$IDName,"$IDUser copió los permisos de '$usuario1' al usuario '".$arrusuarios[$i][1]."'");
			}

		echo "<html><head><title>OK</title></head><body onLoad=\" alert('Copiado finalizado de $maxi usuarios'); window.close(); \"></body></html>";
		exit();
		}
	}	

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Copiar Permisos</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

function go()
	{
	var ids="";	
	if(confirm('¿Iniciar el copiado?'))
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
.camposm {
	 font-family: Arial; 
	 font-size: 10pt;
	 width: 150px;
	 margin-left: 5px;
}

.campobg {
	 font-family: Arial; 
	 font-size: 10pt;
	 width: 250px;
	 margin-left: 5px;
}

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
				<td><? echo "<h3>Copiar <font color='#ff0000'>Permisos</font></h3>";  ?></td>
				<td width="100" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
			</tr>
		</table>	
	</div>
	<nav class="navbar navbar-default" data-spy="affix" data-offset-top="50">
		<div id='divboton'><button type='button' onclick="go();" class='btn btn-primary'>Copiar Ahora</button></div>
	</nav>

	<p align="center">
		<b><font face="Arial" size="2">Seleccione los Usuarios a quien se les copiaran los permisos de <br><font color="#FF0000"><?echo $nombreusuario;?></font></font></b>
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
</div>

<input type="hidden" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="ids" value=''>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
<?
include("lib/f_conectai.php"); 
include("lib/f_fnBDi.php"); 
$conexio=conecta("");


/*if($_SERVER['HTTPS']!="on")
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location:$redirect");
  }
*/

if(isset($_POST['tries']))
	$tries=$_POST['tries'];
else
	$tries=0;	

$manto=0;
	
function nope($tries)
	{
	$tries +=1;
	if($tries>=3)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Demasiados Intentos.'); window.close();\"></body></html>";
		exit();
		}
	else
		return $tries;
	}
$nuevocontenido="";

if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	$accesoconcedido=0;
	
	if($accion=="1")
		{
		$usuario=$_POST['usuario'];		
		$password=$_POST['password'];		
		
		$consulta="Select * from adm_usuarios where usuario='$usuario' and status='1'";

		$res2 = mysqli_query($conexio,$consulta);
		if($val2=mysqli_fetch_array($res2))
			{			
			if(MD5($password)==$val2['password'])
				{
				$accesoconcedido=1;
				$idusuario=$val2['id'];
				$nombre=$val2['nombre'];
				$avatar=$val2['avatar'];
				if($avatar=="")
					$avatar="nobody.jpg";

				$empresanum=0;			

				#Capa inicial de filtrado de empresas (Enero2018)
				$arrdato=array();
				$arrempresas=array();
				$consulta="Select b.id,b.base,b.razon,b.logo,b.vidamax  
				from rel_usuarios a 
				left join adm_empresas as b on a.idempresa=b.id 
				where a.idusuario='$idusuario'";		
				$res = mysqli_query($conexio,$consulta);
				while($val=mysqli_fetch_array($res))
					{
					$arrdato[0]=$val['id'];
					$arrdato[1]=$val['base'];
					$arrdato[2]=$val['razon'];
					$arrdato[3]=$val['logo'];
					$arrdato[4]=$val['vidamax'];
					array_push($arrempresas,$arrdato);
					}
				mysqli_free_result($res);
				$carrempresas=count($arrempresas);
#echo "<pre>".print_r($arrempresas,true)."</pre>";
#exit();


				if($carrempresas==1)
					{
					session_name ("siccsession");
					session_start();
					$_SESSION['IDOwner']=$arrempresas[0][0];
					$_SESSION['IDBase']=$arrempresas[0][1];
					$_SESSION['Empresa']=$arrempresas[0][2];
					$_SESSION['IDU']=$idusuario;
					$_SESSION['Avatar']=$avatar;
					$_SESSION['IDUser']=$usuario;
					$_SESSION['IDName']=$nombre;
					$_SESSION['logo']=$arrempresas[0][3];
					$_SESSION['vidamax']=$arrempresas[0][4];
					$_SESSION['vida']=time();
					session_write_close();
			#echo $arrempresas[0][3];
					hit("acceso",$usuario,$idusuario,$arrempresas[0][0]);
					header("location:main/f_blank.php");
					header("Cache-control: private");
					die();
			
					}
				
/*
				if($carrempresas>1)
					{
					$nuevocontenido="";
					for($i=0;$i<$carrempresas;$i++)
						{
						$nuevocontenido .="<button type='button' onclick=\"go('".$arrempresas[$i][0]."','".$arrempresas[$i][1]."','".$arrempresas[$i][2]."','$idusuario','$avatar','$usuario','$nombre','".$arrempresas[$i][3]."','".$arrempresas[$i][4]."');\" class='btn btn-default' style='width: 150px; height: 150px; margin: 10px; padding: 10px 5px; z-index: 1; white-space: normal;'>";
						switch($arrempresas[$i][3])
							{
							case "comics":	$nuevocontenido .= "<span><h4>Mis Comics</h4></span><span><img src='img/icono.png' border='0' style='margin: 5px'></span>"; break;
							}
						$nuevocontenido .= "<span><h5><b>".$arrempresas[$i][2]."</b></h5></span>";
						$nuevocontenido .= "</button>";
						}
					}
	*/			
				}
			else
				$tries=nope($tries);
			}
		mysqli_free_result($res2);
				
		}#fin de accion==1

	if($accion=="2")
		{
		$idowner=$_POST['idowner'];		
		$idbase=$_POST['idbase'];
		$empresa=$_POST['empresa'];
		$idu=$_POST['idu'];
		$avatar=$_POST['avatar'];
		$iduser=$_POST['iduser'];
		$idname=$_POST['idname'];
		$tipo=$_POST['tipo'];
		$max=$_POST['max'];

		session_name ("micsession");
		session_start();
		$_SESSION['IDOwner']=$idowner;
		$_SESSION['IDBase']=$idbase;
		$_SESSION['Empresa']=$empresa;
		$_SESSION['IDU']=$idu;
		$_SESSION['Avatar']=$avatar;
		$_SESSION['IDUser']=$iduser;
		$_SESSION['IDName']=$idname;
		$_SESSION['Tipo']=$tipo;
		$_SESSION['Max']=$max;
		$_SESSION['vida']=time();
		$_SESSION['vidamax']=0;
		session_write_close();
		hit("acceso",$idowner,$idu,$iduser);
		header("location:".$tipo."/f_inicio.php");
		header("Cache-control: private");
		die();
		
		}
	
	}#fin post accion
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SICC</title>
<link rel="icon" href="img/icono.png" type="image/x-icon">
<link rel="stylesheet" href="lib/boot/css/bootstrap.min.css">
<script src="lib/jquery-2.1.1.min.js"></script>
<script src="lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="lib/popup.js"></SCRIPT>
<link rel="stylesheet" href="lib/stlinks.css">
<SCRIPT LANGUAGE="JavaScript">

if (top.location!= self.location) { 
          top.location = self.location.href ;}

function cargar()
	{
	if(document.edicion.usuario.value=="")
		{alert('Proporcione el usuario');
		document.edicion.usuario.focus();
		return "0";}
	if(document.edicion.password.value=="")
		{alert('Proporcione la contraseña');
		document.edicion.password.focus();
		return "0";}
	document.getElementById('divboton').innerHTML="<p align='center'><font color='#000000' style='font-size: 30px; padding: 75px'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=1;
	document.edicion.submit();
	}

function go(fowner,fidbase,fempresa,fidu,favatar,fiduser,fidname,ftipo,fmax)
	{
	document.edicion.idowner.value=fowner;
	document.edicion.idbase.value=fidbase;
	document.edicion.empresa.value=fempresa;
	document.edicion.idu.value=fidu;
	document.edicion.avatar.value=favatar;
	document.edicion.iduser.value=fiduser;
	document.edicion.idname.value=fidname;
	document.edicion.tipo.value=ftipo;
	document.edicion.max.value=fmax;
	document.edicion.accion.value=2;
	document.edicion.submit();
	}


</SCRIPT>
<style type="text/css">
a:link {text-decoration:none;}    /* unvisited link */
a:visited {text-decoration:none;} /* visited link */
a:hover {text-decoration:underline;}   /* mouse over link */
a:active {text-decoration:none;}  /* selected link */

body {
		margin: 0px;
		background-color: #5396B6;
	}

.normal { 
			/*text-transform: uppercase;*/
			font-size:16px;
		}
		
.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  height: 45px;
  background-color: #fff;
  color: #83827F;
}		
</style>
</head>

<body>
<form method="POST" name="edicion" target="_self">
<?
if($nuevocontenido!="")
	{
	echo "

	<div align='center' style='margin: 50px auto; padding: 20px; width: 80%; background-color: #a04343; border-radius: 10px;'>
	<img src='img/logot.png' class='img-responsive' border='0' style='margin: 10px 0'>
	<h2><font style='color: beige; text-shadow: 2px 1px black; font-weight: 600;'>$nombre</font></h2>
	<h3><font style='color: white; text-shadow: 2px 1px black;'>Selecciona tu colección</font></h3>
	<div style='margin: 0 auto;''>";
	echo $nuevocontenido;
	echo "</div>";
	}
else {?>

<div align="center" class="container" style="margin: 100px auto; width: 350px; text-align: center; background-color: #fff; border-radius: 10px;">
	<!-- <p><img src="img/muri_logo.jpg" border="0"></p> -->
	<img src='img/Logo_CEIDE.png' border="0" style="width: 300px; height: auto; margin: 10px 0">
<?if($manto==1)
	echo "<h3><font color='#ff0000'>El sistema se encuentra en Mantenimiento<br>favor de acceder más tarde</font></h3>";
else {?>	
	<p><input type="text" class="form-control normal" name="usuario" id="usuario" placeholder="Usuario" onkeypress="if(event.keyCode==13) document.edicion.password.focus();"></p>
	<p><input type="password" class="form-control normal" name="password" id="password" placeholder="Contraseña" onkeypress="if(event.keyCode==13) cargar();"></p>
	
	
	

	<p><div id="divboton"><button type='button' onClick="cargar();" class='btn btn-primary'>Continuar</button></div></p>
	
	
<?}?>
</div>
<footer class="footer">
      <div class="container">
       		<p align="center" style="margin: 8px">
		<!--<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=tZaGZ5gmVdkwk123LiSJZZicVemGrZxLolRKiMO5ObdOKEcBP13mXy8XHgKp"></script></span>
  		&nbsp;|&nbsp;
  		Desarrollado por <a href='#' onclick="Popup.showModal('modal');"><span style="font-size: 16px; display: inline; color: yellow;"><b>Abraham Valle</b></span></a>
  		&nbsp;|&nbsp;-->
  		Sitio optimizado para <img src="img/chrome-32.png">
  			</p>
      </div>
    </footer>



<div id="modal" style="width: 400px; border:2px solid grey; background-color: #f5f5f5; padding:10px; font-size:150%; text-align:center; display:none;">
	<h3>Mi Colección</h3>
	<h4><font color='#808080'>desarrollado por</font></h4>
	<h3><b>Abraham Valle</b></h3>	
	<h3><a href='mailto:abraham@im-pulso.com.mx'>abraham@im-pulso.com.mx</a></h3>
	<br>
	<p align="center">
		<button type="button" class="btn btn-success" onclick="Popup.hide('modal');">OK</button>
	</p>
</div>
<?}?>


<input type="hidden" name="idowner" value=''>
<input type="hidden" name="idbase" value=''>
<input type="hidden" name="empresa" value=''>
<input type="hidden" name="idu" value=''>
<input type="hidden" name="avatar" value=''>
<input type="hidden" name="iduser" value=''>
<input type="hidden" name="idname" value=''>
<input type="hidden" name="tipo" value=''>
<input type="hidden" name="max" value=''>
<input type="hidden" name="accion" value='0'>

</form>
</body>
</html>
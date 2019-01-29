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

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Catálogos</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/popup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

function selecciona(menu)
	{
	var x = document.getElementsByTagName("li");
	
	for(i=0;i<x.length;i++)
		{
		if(Left(x[i].id,3)=="mnu")
		  	document.getElementById(x[i].id).className="";	  		
	  	}

	var x = document.getElementsByTagName("div");
	for(i=0;i<x.length;i++)
		{
	  	if(Left(x[i].id,3)=="sub")
		  	document.getElementById(x[i].id).className="invisible";
	  	}

	document.getElementById("mnu"+menu).className="active";
	document.getElementById("sub"+menu).className="esvisible";
	document.getElementById("midwindow").src="f_blank2.php";
	}

function activa(submenu)
	{
	var x = document.getElementsByTagName("li");
	for(i=0;i<x.length;i++)
		{
		//	alert(x[i].id);
	  	if(Left(x[i].id,3)=="cub")
		  	{		  	
	  		document.getElementById(x[i].id).className="inactive";
	  		}
	  	}
	 document.getElementById("cub"+submenu).className="active";
	}

</SCRIPT>



</head>


<body>
<form method="POST" name="edicion" target="_self">
	<?
	$mnu="catalogos";
    include("f_header.php");
    ?>
	<div class="container-fluid">
		<p>
			<h3><font face="Arial">Catálogos</font></h3>
		</p>

		<ul class='nav nav-tabs'>
		<? echo "<li id='mnugeneral'><a href='#' onclick=\"selecciona('general');\"><span>General</span></a></li>"; ?>
		<? echo "<li id='mnuoperacion'><a href='#' onclick=\"selecciona('operacion');\"><span>Operación</span></a></li>"; ?>
		
		</ul>

		<div id="subgeneral" class="invisible">
			<ul class="nav nav-pills">
			  <? 
			  echo "<li id='cubestadosrep'><a href='#' onclick=\"activa('estadosrep');  midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_estadosrep';\"><span>Estados de la república</span></a></li>"; 
			  echo "<li id='cubbancos'><a href='#' onclick=\"activa('bancos'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_instituciones';\"><span>Instituciones Bancarias</span></a></li>";
			  echo "<li id='cubescolaridad'><a href='#' onclick=\"activa('escolaridad'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_escolaridad';\"><span>Escolaridad</span></a></li>";

			  echo "<li id='cubedocivil'><a href='#' onclick=\"activa('edocivil'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_ecivil';\"><span>Estado civil</span></a></li>";

			  echo "<li id='cubrecursos'><a href='#' onclick=\"activa('recursos'); midwindow.location.href='../modClientes/f_consultarecursos.php?titulo=0';\"><span>Recursos de Ingreso y Egreso</span></a></li>";

			  echo "<li id='cubproducto'><a href='#' onclick=\"activa('producto'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_creproductos';\"><span>Productos Crédito</span></a></li>";

			  echo "<li id='cubtipoproducto'><a href='#' onclick=\"activa('tipoproducto'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_cretipopro';\"><span>Tipo de Productos Crédito</span></a></li>";

			  echo "<li id='cubdestino'><a href='#' onclick=\"activa('destino'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_credestino';\"><span>Destino Crédito</span></a></li>";

			  echo "<li id='cubplazo'><a href='#' onclick=\"activa('plazo'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_creplazo';\"><span>Plazo Crédito</span></a></li>";

			  echo "<li id='cubparentesco'><a href='#' onclick=\"activa('parentesco'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_parentezco';\"><span>Parentesco</span></a></li>";

			  ?>
			</ul>
			<br>
		</div>

		<div id="suboperacion" class="invisible">
			<ul class="nav nav-pills">
			  <?  

			   echo "<li id='cubintegradora'><a href='#' onclick=\"activa('integradora'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_integradoras';\"><span>Integradoras</span></a></li>";

			   echo "<li id='cubdocmusts'><a href='#' onclick=\"activa('docmusts'); midwindow.location.href='f_consultaregs.php?permiso=AdminCatalogos&minlev=1&maxlev=1&desc=&tabla=cat_docsmust';\"><span>Documentos Obligatorios</span></a></li>";

			  ?>
			</ul>
			<br>
		</div>

		<div id="sublineas" class="invisible">
			<ul class="nav nav-pills">
			  <?  echo "<li id='cubtipolineas'><a href='#' onclick=\"activa('tipolineas');  midwindow.location.href='../modMain/f_consultaregs.php?permiso=AdminLineas&minlev=1&maxlev=3&desc=&tabla=cat_invlineas';\"><span>Líneas de Producto</span></a></li>"; ?>
			</ul>
			<br>
		</div>

		<div id="submonedas" class="invisible">
			<ul class="nav nav-pills">
			  <?  echo "<li id='cubtipomonedas'><a href='#' onclick=\"activa('tipomonedas');  midwindow.location.href='../modMain/f_consultaregs.php?permiso=AdminIndirectos&minlev=1&maxlev=1&desc=&tabla=cat_monedas';\"><span>Monedas</span></a></li>"; ?>
			</ul>
			<br>
		</div>

		<div id="subproductos" class="invisible">
			<ul class="nav nav-pills">
				<? 
					echo "<li id='cubproduct'><a href='#' onclick=\"activa('product'); midwindow.location.href='../modInventario/f_consultaproductos.php?titulo=0';\"><span>Productos</span></a></li>";
					echo "<li id='cubtip'><a href='#' onclick=\"activa('tip'); midwindow.location.href='../modInventario/f_consultatipoproducto.php';\"><span>Tipo de Productos</span></a></li>"; 
					echo "<li id='cubuni'><a href='#' onclick=\"activa('uni'); midwindow.location.href='../modInventario/f_consultaunidades.php?titulo=0';\"><span>Unidades de Producto</span></a></li>";
					echo "<li id='cubmarcas'><a href='#' onclick=\"activa('marcas'); midwindow.location.href='../modMain/f_consultaregs.php?permiso=AdminIndirectos&minlev=1&maxlev=1&desc=&tabla=cat_marcas';\"><span>Marcas de Producto</span></a></li>";
					echo "<li id='cubcondiciones'><a href='#' onclick=\"activa('condiciones'); midwindow.location.href='../modMain/f_consultaregs.php?permiso=AdminIndirectos&minlev=1&maxlev=1&desc=&tabla=cat_condiciones';\"><span>Condiciones de Pago</span></a></li>";
					echo "<li id='cubentrega'><a href='#' onclick=\"activa('entrega'); midwindow.location.href='../modMain/f_consultaregs.php?permiso=AdminIndirectos&minlev=1&maxlev=1&desc=&tabla=cat_tipoentrega';\"><span>Tipo de Entrega</span></a></li>";
					echo "<li id='cublab'><a href='#' onclick=\"activa('lab'); midwindow.location.href='../modMain/f_consultaregs.php?permiso=AdminIndirectos&minlev=1&maxlev=1&desc=&tabla=cat_tipolab';\"><span>Tipos L.A.B.</span></a></li>";
					?>
			</ul>
			<br>
		</div>



		<script>
			if (window.innerHeight){ 
			   //navegadores basados en mozilla 
			   espacio_iframe = window.innerHeight - 100 
			}else{ 
			   if (document.body.clientHeight){ 
			      //Navegadores basados en IExplorer, es que no tengo innerheight 
			      	espacio_iframe = document.body.clientHeight - 100
			   }else{ 
			      	//otros navegadores 
			      	espacio_iframe = 700 
			   } 
			 }
			document.write ('<iframe allowtransparency="allowtransparency" id="midwindow" name="midwindow" marginwidth="0" marginheight="0" frameborder="0" Scrolling="auto" src="f_blank2.php" width="100%" height="' + espacio_iframe + '">') 
			document.write ('</iframe>')
		</script>

	</div>

	<?
echo "<br>";
include("../main/f_footer.php");
?>
</form>
</body>

</html>
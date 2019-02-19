<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php"); 

#Vemos si esta logueado el usuario
session_name ("siccsession");
session_start();
if(isset($_SESSION['vida'])&&isset($_SESSION['vidamax']))
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$conexio=conecta($IDBase);
	$IDL=permiso("AdminClientes",$IDU);
	$IDL2=permiso("AdminClientesArc",$IDU);
	$IDL3=permiso("AdminClientesFor",$IDU);
	$IDL4=permiso("AdminClientesLog",$IDU);
	$IDL5=permiso("AdminClientesPto",$IDU);
	
	if($IDL5<0)
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
	
$csql = "SELECT * from `cat_clientes` WHERE `id` = '$id';";	
$res2 = mysqli_query($conexio, $csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];			
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$montopresupuesto=$val5['montopresupuesto'];
	$status=$val5['status'];			
	}
mysqli_free_result($res2);

?>

<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Presupuesto de obra</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link rel="stylesheet" href="../lib/stlinks.css">
<style type="text/css">
	.eltexto
		{
		font-family: Arial;
		font-size: 13px;

		}

	.celb
		{
		background-color: #d9edf7;
		}
</style>

</head>

<body>
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h3><font face="Arial">Cliente</font></h3></td>
			<td width="33" align="right">			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
		<tr>
			<td colspan="2"><h4><font face="Arial" color="#000080"><? echo "$idcli $nombre";?></font></h4></td>			
		</tr>
	</table>

	<?
	echo "<ul class='nav nav-tabs'>";
	echo "<li><a href='f_clienter.php?id=$id'>General</a></li>";
	if($IDL5>0)
		echo "<li class='active'><a href='f_clientepr.php?id=$id'>Presupuesto de Obra</a></li>";
	if($IDL2>0)
		echo "<li><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
	if($IDL3>0)
		echo "<li><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
	if($IDL4>0)
		echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
	echo "</ul><br>";
	?>   

	<p align="center">
		<table class="table table-condensed">
			<thead>			
				<tr>
					<th width="150" align="center" height="25"><font face="Arial" size="3">Presupuesto</font></th>
					<?//<th align="center"><font face="Arial" size="3">Disponible</font></th>?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="150" align="left" height="25"><font face="Arial" size="3" color='#808080'><b><? echo fixmontosin($montopresupuesto);?></b></font></td>
					<?//<td><font face="Arial" size="3"><b><div id="divdisponible"><? echo $disponible;</div></b></font></td>?>
				</tr>
			</tbody>
		</table>
	</p>
	<br>

	<table border='0'>
		<tr>
			<td width='400'><b>&nbsp; Presupuesto</b></td>
			<td width='100' align="center"><b>Importe</b></td>
			<td width='100' align="center"><b>Porcentaje</b></td>
		</tr>
	</table>

	<div class="panel-group" id="accordion">

	<?

	$ttotali=0;
	$ttotalp=0;
	$ttotalt=0;

	$consulta="SELECT * from cat_presupuestos where status='1' order by id";
	$res0 = mysqli_query($conexio, $consulta);   
	while($val0=mysqli_fetch_array($res0))
		{
		$idp=$val0['id'];
		$descripcionp=$val0['descripcion'];
		$linea="";

		$totali=0;
		$totalp=0;
		$totalt=0;

	    $linea.= "<div class='table-responsive'>
				 	<table class='table table-striped'>
			  			<thead>
			   				<tr>
					     		<th><font size='2' face='Arial'>Detalle</font></th> 
					        	<th><font size='2' face='Arial'>Unidad</font></th>  
					        	<th><font size='2' face='Arial'>Cantidad</font></th>    
					        	<th><font size='2' face='Arial'>Precio Unitario</font></th>    
					        	<th><font size='2' face='Arial'>Importe</font></th>    
					        	<th><font size='2' face='Arial'>Porcentaje</font></th>    
					        	<th><font size='2' face='Arial'>Semana (s)</font></th>    
					        	<th><font size='2' face='Arial'>Inicio</font></th>                         
			    			</tr>
			  			</thead>          
			   			<tbody>";

				$consulta="SELECT a.id, a.idpto, a.idcliente, a.descripcion, a.idunidad, c.descripcion as unidad, a.cantidad, a.preciounitario, a.tiempo, a.inicio
				FROM ope_clientepto as a
				left join cat_presupuestos as b on a.idpto=b.id 
				left join cat_unidades as c on a.idunidad=c.id 
				left join cat_clientes as d on a.idcliente=d.id
				where a.idpto='$idp'";
		     	$res = mysqli_query($conexio, $consulta);   
		     	while($val=mysqli_fetch_array($res))
			        { 
        			$idx=$val['id'];
        			$idpto==$val['idpto'];
			        $descripcion=$val['descripcion'];//dónde se guarda
			        $unidad=$val['unidad'];
			        $cantidad=$val['cantidad'];
			        $preciounitario=$val['preciounitario'];
			        $importe=$val['importe'];
			        $tiempo=$val['tiempo'];
			        $inicio=$val['inicio'];
			        $descripcion=$val['descripcion'];

			        $totalt +=$tiempo;	
			        $importe= $preciounitario * $cantidad;
			        $totali +=$importe;
			      
					$porcent=$importe*100/$montopresupuesto;
					$totalp +=$porcent;
					$porcent1=bcdiv($porcent, '1', 2);
					$totalp=bcdiv($porcent, '1', 2);
			     
			        $link="<a href='#' onclick=\"abre('editardetalle','f_agregardetalle.php?id=$idx',550,450,'YES');\">";
			        $linea .= "<tr>
			        <td>$link<font face='Arial' size='2' color='#000000'>$descripcion</font></a></td>
			        <td>$link<font face='Arial' size='2' color='#000000'>$unidad</font></a></td>
			        <td>$link<font face='Arial' size='2' color='#000000'>$cantidad</font></a></td>
			        <td>$link<font face='Arial' size='2' color='#000000'>$preciounitario</font></a></td>
			        <td>$link<font face='Arial' size='2' color='#000000'>$importe</font></a></td>
			        <td>$link<font face='Arial' size='2' color='#000000'>$porcent1 %</font></a>
			        <td>$link<font face='Arial' size='2' color='#000000'>$tiempo</font></a></td>
			        <td>$link<font face='Arial' size='2' color='#000000'>$inicio</font></a></td>
			        </tr>";
			    	}
		      	mysqli_free_result($res);  

		      	$ttotali +=$totali;
				$ttotalp +=$totalp;
				$ttotalt +=$totalt;

		      	$totali=fixmontosin($totali); 
		      	$totalp=fixmontosin($totalp); 
		      	$totalt=$totalt; 

			    $linea .= "<tr><td align='right' colspan='4'><font size='2' face='Arial'><b>Total:</b></font></td>";
				$linea .= "<td><font size='2' face='Arial'><b>$totali</b></font></td>";
				$linea .= "<td><font size='2' face='Arial'><b>$totalp %</b></font></td>";
				$linea .= "<td><font size='2' face='Arial'><b>$totalt</b></font></td>";
				$linea .= "<td><font size='2' face='Arial'><b></b></font></td></tr>";
				
				$linea .= "</tbody>
			</table>
		</div>";

		echo "<div class='panel panel-default'>";
		echo "<div class='panel-heading'>";
		echo "<table border='0'>
				<tr>
					<td width='400'>
		        		<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse".$idp."'>$descripcionp</h4></a>
		        	</td>
		        	<td width='100'>
			    		<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse".$idp."'>$totali</h4></a>
			    	</td>
			    	<td width='100'>
			    		<h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse".$idp."'>$totalp %</h4></a>
			    	</td>
			    </tr>
			</table>";
		echo "</div>";

		echo "<div id='collapse".$idp."' class='panel-collapse collapse'>
			    <div class='panel-body'>";	    
		echo "<button type='button' class='btn btn-primary btn-xs' onclick=\"abre('agregardetalle','f_agregardetalle.php?idpto=$idp&idcliente=$id',550,450,'YES');\">Agregar Detalle</button>";

		echo $linea;

		echo "</div>
	    	</div>
	  		</div>";
	  		}
		mysqli_free_result($res0);

		 ?>

	</div>

	<?
	$ttotali=fixmontosin($ttotali); 
	$ttotalp=fixmontosin($ttotalp); 
	$ttotalt=fixmontosin($ttotalt);
	echo "<table border='0'>
		<tr>
			<td width='380' align='right'><b>Totales &nbsp; </b></td>
			<td width='100' align='center'><b>$ttotali</b></td>
			<td width='90' align='right'><b>$ttotalp %</b></td>
		</tr>
	</table>";
	?>

	<p style="padding: 15px,0;">
		<font face="Verdana" size="1" color="#808080"><? echo $ultima;?></font>
	</p>

</div>

<input type="hidden" id="id" name="id" <?echo "value='$id'";?>>
<input type="hidden" name="idcliente" <?echo "value='$idcliente'";?>>
<input type="hidden" id="idpto" name="idpto" <?echo "value='$idpto'";?>>
<input type="hidden" name="montopresupuesto" <?echo "value='$montopresupuesto'";?>>
<input type="hidden" name="accion" value='0'>
</form>
</body>

</html>
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
    { #va a ser nuevo   
    if(isset($_GET['idpto']))
      $idpto=$_GET['idpto'];
    else
      exit();
    if(isset($_GET['idcliente']))
      $idcliente=$_GET['idcliente'];
    else
      exit();

    $id=-1;
    }
  }

if(isset($_POST['accion'])) 
  { 
  $accion=$_POST['accion'];
  if($accion==1)
    { #Guardamos
    #Validaciones y asignamos variables
    $idunidad=$_POST['idunidad'];
    $cantidad=$_POST['cantidad'];
    $preciounitario=$_POST['preciounitario'];
    $tiempo=$_POST['tiempo'];
    $inicio=$_POST['inicio'];
    $idcliente=$_POST['idcliente'];
    $idpto=$_POST['idpto'];
    $descripcion=$_POST['descripcion'];

    if(Existe("ope_clientepto","id",$id)=="NE")
      {
      $csql = "INSERT INTO ope_clientepto (idpto,idcliente,descripcion,idunidad,cantidad,preciounitario,tiempo,inicio,";
      $csql .="status,ultactfec,ultactusu)";
      $csql .="VALUES ('$idpto','$idcliente','$descripcion','$idunidad','$cantidad','$preciounitario','$tiempo','$inicio',";
      $csql .="'$status',NOW(),'$IDUser')";
      }
    else
      {
      $csql = "UPDATE ope_clientepto SET descripcion='$descripcion',idunidad='$idunidad',cantidad='$cantidad',preciounitario='$preciounitario',tiempo='$tiempo',inicio='$inicio',";
      $csql .="status='$status', ultactfec=NOW(), ultactusu='$IDUser' WHERE id='$id'";
      }
    mysqli_query($conexio,$csql);
    if(mysqli_error($conexio)!="") 
      {
      echo "Error al grabar el registro. ".mysqli_error($conexio)." -> $csql";
      exit(); 
      }
    else
      {
      if($id=="-1")
        $id=mysqli_insert_id($conexio);     
      }
    echo "<html><head><title>Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.location.href='f_agregardetalle.php?id=$id'; \"></body></html>";
    exit();
    } #Fin guardado
    
  if($accion==5)
    {  #Borrado
    $csql = "DELETE from ope_clientepto where id='$id';";      
    mysqli_query($conexio,$csql);
    if(mysqli_error($conexio)!="") 
      {
      echo "Error al grabar el registro. ".mysqli_error($conexio)." -> $csql";
      exit(); 
      }
    echo "<html><head><title>Borrado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_agregardetalle.php?id=$id'; \"></body></html>";
    exit();
    }
  }

	if($id!="-1")
    { #Realizamos la consulta para traer los valores
    $csql = "SELECT * from ope_clientepto WHERE id = '$id';"; 
    $res2 = mysqli_query($conexio,$csql);
    if($val5=mysqli_fetch_array($res2))
      {
      $idpto=$val5['idpto'];
      $idptov=traedato("cat_presupuestos","id",$idpto,"S","descripcion");

      $idcliente=$val5['idcliente'];
      $cantidad=$val5['cantidad'];
      $preciounitario=$val5['preciounitario'];
      $tiempo=$val5['tiempo'];
      $inicio=$val5['inicio'];
      $descripcion=$val5['descripcion'];
      $ultima=$val5['ultactusu']."  ".fixfecha($val5['ultactfec']);

      $idunidad=$val5['idunidad'];
      if($idunidad=="")
        $idunidadv="<option selected value=''>(sin asignar)</option>";
      else
        $idunidadv="<option value=''>(sin asignar)</option>";      
      $csql = "SELECT * from `cat_unidades` where status='1' order by `id` desc;";
      $resx = mysqli_query($conexio, $csql);
      while($val=mysqli_fetch_array($resx))
        {
        if($val['id']==$idunidad)
          $idunidadv.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
        else
          $idunidadv.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
        }
      mysqli_free_result($resx);
      }
    mysqli_free_result($res2);  
    }
  else #es nuevo
    {
    $idunidad=0;
    $idunidadv="<option selected value='0'>(sin asignar)</option>"; 
    $csql = "SELECT * from `cat_unidades` where status='1' order by `id` desc;";
    $res1 = mysqli_query($conexio, $csql);
    while($val1=mysqli_fetch_array($res1))
    $idunidadv.="<option value='".$val1['id']."'>".$val1['descripcion']."</option>";
    mysqli_free_result($res1);
     $idptov=traedato("cat_presupuestos","id",$idpto,"S","descripcion");
    $cantidad="";
    $preciounitario="";
    $tiempo="";
    $inicio="";
    $descripcion="";
    $ultima="";
    }

?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Presupuesto de obra - <?echo $idptov;?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<link rel="stylesheet" href="../lib/stlinks.css">

<style type="text/css">
	.principales
		{
		font-family: Verdana;
		font-size: 8pt;
		font-weight: 600;
		color: 000080;
		}
	.cenboxfrm
	  {	 
		font-family: Verdana;
		font-size: 8pt;
		color: 000080;
	  }	
	.cenboxfrmbig
	  {
		font-family: Verdana;
		font-size: 8pt;
		color: 000080;
    height: 70px;
	  }	
	.cenboxfrmmin
	  { 
		font-family: Verdana;
		font-size: 8pt;
		color: 000080;
	  }	
</style>

<SCRIPT LANGUAGE="JavaScript">
	function guardar()
  {
  document.edicion.accion.value=1;
  document.edicion.submit();
  }

	function borrar()
	  {
	  if(confirm('¿Desea realmente borrar este registro?'))
	    { 
	    document.edicion.accion.value=5;
	    document.edicion.submit();
	    }
	  }
</SCRIPT>

</head>

<body>
<form method="POST" name="edicion" target="_self">
<div class="container-fluid">

	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td width="80"><h3><font face="Arial">Detalle</font></h3>
      <? 
      echo"<td align='left'><h3><font color='#ff0000'>$idptov</font></h3></td>";
      ?>  
			<td width="33" align="right">			
			<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
  <?
  echo "<p>
  <td width='150' align='center' height='25'><button type='button' onclick=\"guardar();\" class='btn btn-success btn-xs'>Guardar</button>
  </p>";						
  ?>
  <table width="100%" id="table">
    <tr>
      <td width="100" align="left" height="30"><font face="Arial" size="2">Detalle</font></td>
    </tr>
    <tr>
      <td><textarea type="text" class="cenboxfrmbig" name="descripcion" style="width: 431px;"><?echo $descripcion;?></textarea></td>
    </tr>
  </table>
  <table width="100%" id="table">
  	<tr>
      <td width="90" align="left" height="30"><font face="Arial" size="2">Unidad:</font></td>
      <td><select name="idunidad" id="idunidad" class='cenboxfrmmin'><?echo $idunidadv;?></select></td>
    </tr>
  </table>
  <table width="100%" id="table">
    <tr>
      <td width="90" align="left" height="30"><font face="Arial" size="2">Cantidad:</font></td>
      <td><input type="text" class="cenboxfrmmin" name="cantidad" <?echo "value='$cantidad'";?>></td>
      <td width="166" align="right" height="30"><font face="Arial" size="2">Tiempo asignado:</font></td>
      <td><input type="text" class="cenboxfrmmin" name="tiempo" <?echo "value='$tiempo'";?>><i><font face="Arial" size="1"> &nbsp;semanas</font></i></td>
    </tr>
  </table>
  <table width="100%" id="table">
    <tr>
      <td width="90" align="left" height="30"><font face="Arial" size="2">Precio unitario:</font></td>
      <td><input type="text" class="cenboxfrmmin" name="preciounitario" <?echo "value='$preciounitario'";?>></td>
      <td width="102" align="right" height="30"><font face="Arial" size="2">Inicio en semana:</font></td>
      <td><input type="text" class="cenboxfrmmin" name="inicio" <?echo "value='$inicio'";?>></td>
    </tr>
  </table>
</div>

	<p style="padding: 15px 0 0 10px;">
		<font face="Verdana" size="1" color="#808080"><? echo $ultima;?></font>
	</p>

</div>
<input type="hidden" name="id" <? echo "value='$id'"; ?>>
<input type="hidden" name="idpto" <?echo "value='$idpto'";?>>
<input type="hidden" name="idcliente" <?echo "value='$idcliente'";?>>
<input type="hidden" name="accion" value='0'>
<input type="hidden" name="total" value='0'>
</form>
</body>

</html>
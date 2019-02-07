<?
include("../../lib/f_conectai.php"); 
include("../../lib/f_fnBDi.php");
require("../../lib/fpdf.php");

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
	if($IDL=="-1")
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
	if($IDL<2)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no cuenta con el acceso suficiente'); window.close(); \"></body></html>";
		exit();
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
	exit();

$hoy=fixfecha(date("Y-m-d h:i:s"));

$csql = "SELECT * from `ope_formatos` WHERE `id` = '$id';";		
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idpersona=$val5['idpersona'];
	$persona=$val5['persona'];
	$lugar=strtoupper($val5['lugar']);
	$dia=substr($val5['fecha'],8,2);
	settype($dia,"integer");
	$mes=substr($val5['fecha'],5,2);
	settype($mes,"integer");
	$anio=substr($val5['fecha'],2,2);	
	$mesv=mes($mes);	
	}
mysqli_free_result($res2);

$csql = "SELECT * from `cat_clientes` WHERE `id` = '$idpersona';";
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];
		
	$nombre=strtoupper($val5['apellidop']." ".$val5['apellidom']." ".$val5['nombre']);
	
	$idproducto=$val5['idproducto'];
	$segundocredito=$val5['segundocredito'];
	$plazocredito=$val5['plazocredito'];
	$calle=strtoupper($val5['calle']);
	$numero=strtoupper($val5['numero']);
	$numeroint=strtoupper($val5['numeroint']);
	$lote=strtoupper($val5['lote']);
	$mza=strtoupper($val5['mza']);
	$colonia=strtoupper($val5['colonia']);
	$municipio=strtoupper($val5['municipio']);
	$estado=strtoupper($val5['estado']);
	$cp=$val5['cp'];

	$discapacidad=$val5['discapacidad'];
	$tipodiscapacidad=$val5['tipodiscapacidad'];
	$personacapacidad=$val5['personacapacidad'];

	$montopresupuesto=$val5['montopresupuesto'];

	$afectaestructura=$val5['afectaestructura'];

	$razonsocialpatron=$val5['razonsocialpatron'];
	$rfcpatron=$val5['rfcpatron'];
	$telpatron=$val5['telpatron'];


	$nss=$val5['nss'];
	$rfc=$val5['rfc'];
	$curp=$val5['curp'];

	$telefonos=$val5['telefonos'];
	$celular=$val5['celular'];
	$genero=substr($val5['genero'],0,1);

	$email=$val5['email'];

	$ecivil=$val5['ecivil'];
	$regimenpat=$val5['ecivil'];##############

	$idadministradora=$val5['idadministradora'];
	if($idadministradora!=0)
		{
		$consulta="select * from cat_entidades where id='$idadministradora'";
		$res3 = mysqli_query($conexio,$consulta);
		if($val3=mysqli_fetch_array($res3))
			{			
			$administradora=$val3['razonsocial'];
			$rfcadmin=$val3['rfc'];
			$nomadmin=$val3['nombre'];
			$clabeadmin=$val3['clabe'];
			}
		mysqli_free_result($res3);		
		}
	else
		{
		$administradora="";
		$rfcadmin="";
		$nomadmin="";
		$clabeadmin="";
		}

	$ref1apellidop=$val5['ref1apellidop'];
	$ref1apellidom=$val5['ref1apellidom'];
	$ref1nombre=$val5['ref1nombre'];
	$ref1telefono=$val5['ref1telefono'];
	$ref2apellidop=$val5['ref2apellidop'];
	$ref2apellidom=$val5['ref2apellidom'];
	$ref2nombre=$val5['ref2nombre'];
	$ref2telefono=$val5['ref2telefono'];

	$razonsocialacreditado=$val5['razonsocialacreditado'];
	$rfcacreditado=$val5['rfcacreditado'];
	$nombreacreditado=$val5['nombreacreditado'];
	$clabeacreditado=$val5['clabeacreditado'];
	}
mysqli_free_result($res2);

### Generación de PDF

	$hs=7;
	$fs=6;
	$es=6;
	$maximo=177;	
	$pdf=new FPDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(20,20);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',$hs);
    $pdf->SetY(20);
    $pdf->Cell(40,$es,"NOMBRE:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$nombre,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"NSS:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$nss,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"RFC:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$rfc,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"CELULAR:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$celular,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"TEL CASA:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$telefonos,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"DIRECCIÓN.",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
     $aux=$calle;
    if($numero!="")
    	$aux .=" ".$numero;
    if($numeroint!="")
    	$aux .=" ".$numeroint;
    if($lote!="")
    	$aux .=" lt ".$lote;
    if($mza!="")
    	$aux .=" mz ".$mza;
    $pdf->Cell(80,$es,$aux,'LR',1,'L');
    $pdf->Cell(40,$es,"COLONIA:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$colonia,'R',1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"DELEGACIÓN:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$municipio,'R',1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"C.P.:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$cp,'R',1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"ESTADO:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$estado,'BR',1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"CORREO:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$email,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"ESTADO CIVIL:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$ecivil,1,1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es,"SUBTOTAL:",1,0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es,$montopresupuesto,1,1,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(40,$es-2,"",'LTR',0,'L');
    $pdf->Cell(80,$es-2,"PRESUPUESTO",'LTR',1,'L');
    $pdf->Cell(40,$es-2,"",'LR',0,'L');
    $pdf->Cell(80,$es-2,"PROGRAMA DE OBRA",'LR',1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es-2,"DOCUMENTOS",'LR',0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es-2,"SOLICITUD",'LR',1,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(40,$es-2,"ADJUNTOS",'LR',0,'L');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell(80,$es-2,"INE TRABAJADOR",'LR',1,'L');
    $pdf->Cell(40,$es-2,"",'LR',0,'L');
    $pdf->Cell(80,$es-2,"COMPROBANTE DE DOMICILIO",'LR',1,'L');
    $pdf->Cell(40,$es-2,"",'LBR',0,'L');
    $pdf->Cell(80,$es-2,"BOLETA PREDIAL",'LBR',1,'L');




    $pdf->Output();//muestro el pdf

?>

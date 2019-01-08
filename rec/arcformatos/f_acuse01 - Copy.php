<?
include("../lib/f_conecta.php"); 
include("../lib/f_fnBD.php");
require('../lib/WriteTag.php');

#Vemos si esta logueado el usuario
session_name ("censession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
	{
	$IDU=$_SESSION['IDU'];
	$IDBase=$_SESSION['IDBase'];
	$IDUser=$_SESSION['IDUser'];
	$IDName=$_SESSION['IDName'];
	$milogo=$_SESSION['logo'];
		
	$conexio=conecta($IDBase);
	$IDL=permiso("AdminPoperaDoc",$IDU);
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


$empresa=traedato("adm_config","id",1,"S","empresa");	

$csql = "SELECT * from `ope_contratos` WHERE `id` = '$id';";		
$res2 = mysql_query($csql);
if($val5=mysql_fetch_array($res2))
	{			
	$idpersona=$val5['idpersona'];
	$dia=substr($val5['fecha'],8,2);
	settype($dia,"integer");
	$mes=substr($val5['fecha'],5,2);
	settype($mes,"integer");
	$anio=substr($val5['fecha'],0,4);	
	$contrato="$dia de ".mes($mes)." de $anio";
	$hoy="$dia de ".mes($mes)." de $anio";
	}
mysql_free_result($res2);

$csql = "SELECT * from `cat_operadores` WHERE `id` = '$idpersona';";
$res2 = mysql_query($csql);
if($val5=mysql_fetch_array($res2))
	{			
	$idper=$val5['idper'];
	$tipov=$val5['tipo'];
	
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$unombre=strtoupper($nombre);
	$nss=$val5['nss'];
	
	$nacimiento=fixfecha($val5['nacimiento']);
	$edad=$val5['edad'];
	$nacionalidad=$val5['nacionalidad'];
	$ecivilv=$val5['ecivil'];
	if($ecivilv=="")
		$ecivilv="(sin seleccionar)";
	
	$escolaridadv=$val5['escolaridad'];
	$calle=$val5['calle'];
	$numero=$val5['numero'];
	$colonia=$val5['colonia'];
	$municipio=$val5['municipio'];
	$estado=$val5['estado'];
	$cp=$val5['cp'];
	$rfc=$val5['rfc'];
	$curp=$val5['curp'];
	$telefonos=$val5['telefonos'];
	$email=$val5['email'];
	$idbanco=$val5['idbanco'];
	if($idbanco!="0")
		$idbancov=traedato("cat_instituciones","id",$idbanco,"S","descripcion");
	else
		$idbancov="-";
	$cuenta=$val5['cuenta'];
	$clabe=$val5['clabe'];
	$beneficiario=$val5['beneficiario'];
	}
mysql_free_result($res2);



#Realizamos la consulta para traer los valores
$csql = "SELECT * from `adm_config` WHERE `id` = '1';";
$res2 = mysql_query($csql);
if($val5=mysql_fetch_array($res2))
	{
	$empresa=$val5['empresa'];
	$rfcempresa=$val5['rfcempresa'];
	#$dirempresa=$val5['dirempresa'];
	$dirempresa=$val5['calle']." ".$val5['numero'].", ".$val5['colonia'].", ".$val5['municipio'].", ".$val5['estado'].". CP:".$val5['cp'];
	$lugarfirma=$val5['municipio'].", ".$val5['estado'];
	$representante=$val5['representantelegal'];	
	$escdenominacion=$val5['escdenominacion'];
	$escescritura=ucwords($val5['escescritura']);
	#$escfecha=ucwords($val5['escfecha']);
	$escfecha=$val5['escfecha'];
	$escnotario=$val5['escnotario'];
	$escnotarionum=$val5['escnotarionum'];
	$escinscripcion=$val5['escinscripcion'];
	$escinscripcionnum=$val5['escinscripcionnum'];
	$escinscripcionfecha=$val5['escinscripcionfecha'];
	$desccorta=$val5['desccorta'];	
	$registropatronal=$val5['registropatronal'];
	}
mysql_free_result($res2);


	### Generación de PDF

$pdf=new PDF_WriteTag();

$fs=12;
$es=6;

$pdf->AddPage();
$pdf->SetMargins(30,10);
$pdf->SetFont('arial','',$fs);

// Stylesheet
$pdf->SetStyle("p","arial","N",12,"0,0,0",15);
$pdf->SetStyle("h1","times","N",18,"102,0,102",0);
$pdf->SetStyle("a","times","BU",9,"0,0,255");
$pdf->SetStyle("pers","times","I",0,"255,0,0");
$pdf->SetStyle("place","arial","U",0,"153,0,0");
$pdf->SetStyle("vb","Arial","B",0,"0,0,0");


$pdf->Ln(20);    
$pdf->SetFont('Arial','',$fs);
$pdf->Cell(155,$es,$empresa,0,1,"L");

$pdf->Ln(10);    
    
$pdf->Cell(155,$es,"P R E S E N T E",0,1,'L');			
$pdf->Ln(15);    

$txt="<p>Por medio de la presente, el que suscribe, doy mi consentimiento y autorización para que se me realice el pago de mi salario y/o Nomina, ya sea por medio de depósito bancario, tarjeta de debito, transferencia o cualquier otro medio electrónico, en mí cuenta bancaria número <vb>".$cuenta."</vb>, de la Institución Bancaria <vb>".$idbancov."</vb>, y para el caso de cambio dicha cuenta bancaria, la que posteriormente les indique.</p>";

$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(13);

$txt="<p>Asimismo autorizo para emitir el respectivo certificado digital derivado del deposito y por el concepto a que se refiere el parrafo anterior.</p>";

$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(13);

$txt="<p>Expresando desde éste momento que al encontrarse registrados los pagos de <vb>".$empresa."</vb>, por concepto de salario y/o Nomina en mi cuenta bancaria y/o tarjeta de debito señalada en líneas anteriores, me doy por pagado por mis servicios prestados.</p>";

$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(25);

$pdf->Cell(155,$es,$lugarfirma.", a ".$hoy,0,1,"C");
$pdf->Ln(25);

$pdf->SetFont('Arial','B',$fs);
$pdf->Cell(30,7,"",0,0,"C");
$pdf->Cell(85,7,$nombre,0,1,"C");

$pdf->Output();



?>
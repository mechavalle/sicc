<?
include("../../lib/f_conectai.php"); 
include("../../lib/f_fnBDi.php");
require('../../lib/WriteTag.php');

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


//$empresa=traedato("adm_config","id",1,"S","empresa");	

$csql = "SELECT * from `ope_formatos` WHERE `id` = '$id';";		
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idpersona=$val5['idpersona'];
	$persona=$val5['persona'];
	$lugar=$val5['lugar'];
	$dia=substr($val5['fecha'],8,2);
	settype($dia,"integer");
	$mes=substr($val5['fecha'],5,2);
	settype($mes,"integer");
	$anio=substr($val5['fecha'],0,4);	
	$contrato="$dia de ".mes($mes)." de $anio";
	$hoy="$lugar a $dia de ".mes($mes)." de $anio";
	}
mysqli_free_result($res2);

$csql = "SELECT * from `cat_clientes` WHERE `id` = '$idpersona';";
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];
		
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$unombre=strtoupper($nombre);
	
	/*$nss=$val5['nss'];
	
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
	$beneficiario=$val5['beneficiario'];*/
	}
mysqli_free_result($res2);

/*

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

*/
	### Generación de PDF



$pdf=new PDF_WriteTag();

$fs=10;
$es=6;

$pdf->AddPage();
$pdf->SetMargins(15,10);
$pdf->SetFont('Arial','',$fs);

// Stylesheet

$pdf->SetStyle("p","Arial","N",10,"0,0,0",0);
$pdf->SetStyle("p2","Arial","N",12,"0,0,0",15);
$pdf->SetStyle("p3","Arial","BU",10,"0,0,0");
$pdf->SetStyle("h1","times","N",18,"102,0,102",0);
$pdf->SetStyle("a","Arial","BU",9,"0,0,255");
$pdf->SetStyle("pers","times","I",0,"255,0,0");
$pdf->SetStyle("place","Arial","U",100,"153,0,0");
$pdf->SetStyle("vb","Arial","B",0,"0,0,0");


$pdf->Ln(20);    
$pdf->SetFont('Arial','',$fs);
$pdf->Cell(190,$es,$hoy,0,1,"R");

$pdf->Ln(15);   

$txt="<p>Por medio del presente yo el C.C <p3>$unombre</p3> hago constar que es mi deseo adquirir un <vb>crédito de línea IV sin garantía hipotecaria y sin afectación estructural</vb> con el Instituto del Fondo Nacional para la Vivienda de los Trabajadores bajo las siguientes consideraciones:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$txt="<p>Presente la documentación requerida para la inscripción de crédito, a la empresa administradora <vb>PROMOTORIA ASOCIADOS ESTA ES TU CASA S.A DE C.V</vb> autorizada por INFONAVIT toda ella en original y conozco las penas en que se incurre por falsificación de documentos, por lo cual asumo la responsabilidad sobre dicha documentación.</p>";
$pdf->Cell(10,$es,"-",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Declaro que mi empresa Recibió original del aviso de retención y que comenzara a hacerme los descuentos correspondientes.</p>";
$pdf->Cell(10,$es,"-",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Se me explico a detalle todo el proceso de línea VI:</p>";
$pdf->Cell(10,$es,"-",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$txt="<p>Tengo plena conciencia de que es un crédito y que si no realizo la mejoras no se utilizara el SSV para liquidarlo y seguiré pagando el crédito hasta su liquidación total.</p>";
$pdf->Cell(12,$es,"A)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Se que tienen 180 días para hacer las remodelaciones correspondientes y que no existe prórroga para ampliar el plazo.</p>";
$pdf->Cell(12,$es,"B)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Se que tengo que cumplir al pie de la letra el programa y presupuesto de obra ya que el hecho de no hacerlo pone en riesgo que el dictamen de aplicación de recursos (segunda visita) resulte negativo por ende no se liquidara mi crédito.</p>";
$pdf->Cell(12,$es,"C)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Que una vez concluidas las mejoras se realizara una segunda visita a la vivienda bajo el objeto del crédito y de proceder de emitirá un DAR positivo donde se determinara que se jale el SSV, para liquidar el crédito.</p>";
$pdf->Cell(12,$es,"D)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Que una vez emitido el DAR positivo el tiempo estimado para que el crédito se vea liquidado y por ende poder bajar el aviso de suspensión de descuentos es de 3 meses contados a partir de que el área técnica envía el dictamen a oficinas centrales.</p>";
$pdf->Cell(12,$es,"E)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");

$pdf->Ln(30);
$pdf->Cell(45,7,"",0,0,"C");
$pdf->Cell(90,$es,"Atentamente",0,1,"C");
$pdf->Ln(20);

$pdf->SetFont('Arial','B',$fs);
$pdf->Cell(45,7,"",0,0,"C");
$pdf->Cell(90,7,$unombre,"T",1,"C");

$pdf->Output();
?>
<?
include("../../lib/f_conectai.php"); 
include("../../lib/f_fnBDi.php");
require('../../lib/WriteTagF.php');
require("../../lib/f_letra.php");
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
	//$persona=$val5['persona'];

	$dia=substr($val5['fecha'],8,2);
	settype($dia,"integer");
	$mes=substr($val5['fecha'],5,2);
	settype($mes,"integer");
	$anio=substr($val5['fecha'],0,4);	
	$inicio=strtoupper("$dia de ".mes($mes)." de $anio");

	$dia=substr($val5['fechadoc'],8,2);
	settype($dia,"integer");
	$mes=substr($val5['fechadoc'],5,2);
	settype($mes,"integer");
	$anio=substr($val5['fechadoc'],0,4);	
	$fin=strtoupper("$dia de ".mes($mes)." de $anio");


	
	//$hoy="$lugar a $dia de ".mes($mes)." de $anio";
	}
mysqli_free_result($res2);

$csql = "SELECT * from `cat_clientes` WHERE `id` = '$idpersona';";
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];
		
	$nombre=$val5['nombre']." ".$val5['apellidop']." ".$val5['apellidom'];
	$unombre=strtoupper($nombre);
	$domicilio=strtoupper($val5['calle']." ".$val5['numero'].", ".$val5['colonia'].", ".$val5['municipio'].". ".$val5['estado'].". CP".$val5['cp']);
	$email=$val5['email'];
	$valorneto=fixmonto($val5['valorneto']);
	$valornetov=strtoupper(convertir($val5['valorneto']));
	/*$nss=$val5['nss'];
	
	$nacimiento=fixfecha($val5['nacimiento']);
	$edad=$val5['edad'];
	$nacionalidad=$val5['nacionalidad'];
	$ecivilv=$val5['ecivil'];
	if($ecivilv=="")
		$ecivilv="(sin seleccionar)";
	
	$escolaridadv=$val5['escolaridad'];

	$domicilio=$val5['calle']." ".$val5['numero'].", ".$val5['colonia'].", ".$val5['municipio'].". ".$val5['estado'].". CP".$val5['cp'];
	$rfc=$val5['rfc'];
	$curp=$val5['curp'];
	$telefonos=$val5['telefonos'];
	
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
	### Generaci�n de PDF

$pdf=new PDF_WriteTag();

$fs=10;
$es=5;

$pdf->AddPage();
$pdf->SetMargins(20,20);
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

//$pdf->SetFont('Arial','',$fs);


$txt="<p>CONTRATO DE REPARACI�N O REMODELACI�N DE CASA HABITACI�N (CONTRATO DE OBRA) QUE CELEBRAN <vb>".$unombre."</vb>, POR SU PROPIO DERECHO Y POR LA OTRA PARTE <vb>VITTA COCINAS DE ESTILO, S.A. de C.V.</vb> ,  REPRESENTADA EN ESTE ACTO POR <vb>ALEJANDRO PEREZ BOBADILLA</vb> EN SU CAR�CTER DE REPRESENTANTE LEGAL AL TENOR DE LAS DECLARACIONES Y CL�USULAS SIGUIENTES.</p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"A N T E C E D E N T E S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    CONTRATO MAESTRO DE COLABORACI�N. �</vb> PROMOTOR�A ASOCIADOS ESTA ES TU CASA S.A. DE C.V. (el Administrador) y el Instituto del Fondo Nacional de la Vivienda para los Trabajadores (Infonavit) han suscrito un Contrato Maestro de Colaboraci�n para la Incorporaci�n al Programa de Apoyo de L�nea Cuatro. En virtud del mismo, el Administrador presta servicios de: A) asesor�a en la solicitud del cr�dito l�nea IV de acuerdo a la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores (Cr�dito Infonavit) para la reparaci�n o mejora de habitaciones, sin afectaci�n estructural y sin garant�a hipotecaria; y B) administraci�n y aplicaci�n de los recursos de dicho cr�dito a trav�s de un fideicomiso de administraci�n de pago.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    CONTRATO ADMINISTRADOR - DERECHOHABIENTE. </vb> El Derechohabiente y el Administrador tienen celebrado un contrato para la prestaci�n de los servicios descritos en el antecedente I inmediato anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    CR�DITO INFONAVIT. </vb> El Infonavit le autoriz� al Derechohabiente un Cr�dito Infonavit para la reparaci�n o mejora de casa habitaci�n sobre el Inmueble de conformidad con el art�culo 42 fracci�n II apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>IV.    CONVENIO DE ADHESI�N. -</vb> El Derechohabiente tiene suscrito un convenio de adhesi�n con GRUPO FINANCIERO VE POR MAS S.A. DE C.V. Divisi�n Fiduciaria y el Administrador. Mediante ese instrumento, el Derechohabiente se adhiri� al Fideicomiso 437 referido en la Cl�usula Primera siguiente. </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->Cell(180,$es,"D  E  C  L  A  R  A  C  I  O  N  E  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    El Derechohabiente declara, por su propio derecho, que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Es de nacionalidad mexicano(a), en pleno uso de sus facultades y con capacidad para obligarse conforme al presente instrumento.</p>";
$pdf->Cell(10,$es,"A",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Es propietario del inmueble ubicado en <vb>$domicilio</vb> en el cual se ejecutar�n los trabajos objeto de este Contrato.</p>";
$pdf->Cell(10,$es,"B",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Tener su domicilio en el Inmueble descrito en el apartado B anterior y con correo electr�nico $email.</p>";
$pdf->Cell(10,$es,"C",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Como consecuencia del Cr�dito Infonavit que le fuera autorizado por el Infonavit, es su deseo celebrar el presente contrato con el Ejecutor de Obra para la aplicaci�n de dicho cr�dito a la ejecuci�n de los trabajos en el Inmueble contenidos en la Cotizaci�n de la Obra, los Planos y en su caso, el Programa de Trabajo (t�rminos definidos m�s adelante); por lo que, manifiesta que los revis� y que conoce las especificaciones contenidas en dichos documentos, y por tanto, est� conforme con estos as� como con todos los dem�s documentos anexos que integran el presente Contrato.</p>";
$pdf->Cell(10,$es,"D",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    El Ejecutor de Obra declara, bajo protesta de decir verdad, que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);


$pdf->SetFont('Arial','',$fs);
$txt="<p>Es una sociedad debidamente constituida y v�lidamente existente de conformidad con las leyes de la Rep�blica Mexicana, seg�n consta en la escritura p�blica No. <vb>69502</vb> de fecha <vb>05 DE MARZO DE 2013</vb> , otorgada ante la fe del notario p�blico No. <vb>109</vb> <vb>LIC. LUIS DE ANGOITIA BECERRA</vb> , la cual qued� debidamente inscrita en el Registro P�blico de la Propiedad y Comercio de <vb>CIUDAD DE MEXICO</vb> bajo el folio mercantil electr�nico No. <vb>495570-1</vb> .</p>";
$pdf->Cell(10,$es,"A",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Su representante <vb>ALEJANDRO PEREZ BOBADILLA</vb> tiene facultades suficientes para obligar a su representada en t�rminos del presente Contrato, las cuales no le han sido modificadas o revocadas en forma alguna a la fecha de firma del presente Contrato..</p>";
$pdf->Cell(10,$es,"B",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Est� al corriente en el pago del Impuesto sobre la Renta y que su clave de Registro Federal de Contribuyentes es <vb>VCE130305C26</vb> . Asimismo, el Ejecutor de Obra se encuentra al corriente en el pago de sus cuotas obrero-patronales y que su n�mero de registro ante el Instituto Mexicano de Seguridad Social es </p>";
$pdf->Cell(10,$es,"C",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Fue elegido libremente por el Derechohabiente para la ejecuci�n de los trabajos en el Inmueble de conformidad con la Cotizaci�n de la Obra y en su caso, los Planos y el Programa de Trabajo; que conoce las especificaciones solicitadas por el Derechohabiente en esos documentos; que con tal motivo revis� y est� conforme esos documentos anexos.</p>";
$pdf->Cell(10,$es,"D",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ha inspeccionado el Inmueble donde se ejecutar�n los trabajos descritos en la Cotizaci�n de la Obra y en su caso, el Programa de Trabajo y los Planos, y conoce todas las condiciones, a fin de considerar todos los factores que intervendr�n en su realizaci�n incluyendo, entre otros, ubicaci�n y accesos.</p>";
$pdf->Cell(10,$es,"E",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Cuenta con amplia experiencia y con todos los recursos materiales, humanos y equipos necesarios para la ejecuci�n eficiente de los trabajos requeridos para la Obra.</p>";
$pdf->Cell(10,$es,"F",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Se�ala su domicilio para todos los efectos de este Contrato, el ubicado en ENCINOS MZ.244 LT.43, COL. CHICHICASPATL C.P. 14108 DEL. TLALPAN, CIUDAD DE MEXICO con correo electr�nico____________________________.</p>";
$pdf->Cell(10,$es,"G",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Expuesto lo anterior, las partes est�n de acuerdo en sujetar el presente contrato a las siguientes cl�usulas:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"C  L  �  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);


$txt="<p><vb>PRIMERA. - OBJETO Y DEFINICIONES.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente encomienda al Ejecutor de Obra y �ste bajo su propia responsabilidad se obliga a ejecutar en el Inmueble los trabajos de reparaci�n, o mejora descritos en la Cotizaci�n de la Obra, y en su caso, en los Planos y el Programa de Trabajo. �stos se adjuntan al presente contrato como Anexo A en forma escrita y firmados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectos de este Contrato, las siguientes definiciones tendr�n los significados a continuaci�n indicados:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ACTA DE ENTREGA.</vb> Es el documento en el cual consta la conclusi�n de los trabajos a cargo del Ejecutor de Obra, y la conformidad del Derechohabiente respecto a los mismos, el cual estar� firmado por ambas partes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ACTA DE INCUMPLIMIENTO.</vb> Es el documento elaborado por el Derechohabiente y/o el Ejecutor de Obra, en el cual se detallan los incumplimientos del Derechohabiente o del Ejecutor de Obra al Contrato de Obra o a la calidad de la misma, seg�n sea el caso. El Acta de Incumplimiento podr� ser elaborada conforme a los formatos sugeridos por el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ADMINISTRADOR.</vb> Es PROMOTOR�A ASOCIADOS ESTA ES TU CASA S.A. DE C.V., la cual apoyar� al Ejecutor de Obra y al Derechohabiente como partes de este Contrato en t�rminos de este instrumento y del Anexo B.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>AFIANZADORA.</vb> Es BERKLEY MEXICO FIANZAS autorizada por la Secretar�a de Hacienda y Cr�dito P�blico para expedir fianzas y garantizar el cumplimiento del Contrato de Obra, y la obligaci�n de calidad, ambas a cargo del Ejecutor de Obra de conformidad con ese instrumento y la normatividad vigente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ANTICIPO.</vb> Es el pago inicial al que tiene derecho el Ejecutor de Obra para que compre el material, pague mano de obra e invierta en la Obra, en t�rminos de la Cotizaci�n de la Obra y de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CONTRATO GENERAL DE AFIANZAMIENTO.</vb> Es el Contrato que regula las relaciones jur�dicas entre la Afianzadora, el Fideicomiso como beneficiario y el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CONTRATO INDIVIDUAL DE AFIANZAMIENTO.</vb> Es el contrato que se firmar� por cada Ejecutor de Obra con la Afianzadora, previo a la emisi�n de los Endosos de Inclusi�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>COTIZACI�N DE LA OBRA.</vb> Es la propuesta econ�mica del Ejecutor de la Obra que resulta de multiplicar unidades de material requerido con determinadas especificaciones de calidad y funcionalidad para ejecutar una obra en el �rea designada por el Derechohabiente en el Inmueble, por el precio unitario de ese material.  La Cotizaci�n de la Obra tambi�n incluir� los costos directos e indirectos de la Obra, mano de obra, de los equipos, insumos, costos de almacenaje, as� como la utilidad de la Obra. La Cotizaci�n de la Obra se adjunta al presente instrumento como Anexo A, el cual est� firmado por las Partes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CR�DITO INFONAVIT.</vb> Significa el cr�dito otorgado por el Infonavit a los Derechohabientes para que �stos los destinen a la reparaci�n o mejora de habitaci�n, de conformidad con el art�culo 42 fracci�n II de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>EMPRESA VERIFICADORA.</vb> Significa la entidad o empresa verificadora, registrada ante el Infonavit y autorizada por �ste para ejecutar los actos referidos en el Cl�usula Segunda respecto a la verificaci�n inicial, verificaci�n final y/o cualquier otra verificaci�n adicional.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIANZAS, ENDOSOS DE INCLUSION.</vb> Se entender�n indistintamente como las fianzas de cumplimiento y fianzas de calidad otorgadas por la Afianzadora contratadas por el Ejecutor de Obra en virtud de este Contrato de Obra en t�rminos de la Cl�usula Sexta, as� como del Contrato General de Afianzamiento, por medio del cual se incorporan los Fiados a la Fianza Global y se establece la vigencia, fecha de emisi�n, los montos y conceptos a garantizar.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIANZA GLOBAL.</vb> Es el documento donde se establecen las obligaciones adquiridas por la Afianzadora ante el Beneficiario en los t�rminos del art�culo 144 de la Ley de Instituciones de Seguros y Fianzas.<p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIDEICOMISO.</vb> Es el contrato de fideicomiso 437 celebrado entre GRUPO FINANCIERO VE POR MAS S.A. DE C.V. Divisi�n Fiduciaria y el administrador para la administraci�n de los fondos procedentes de los Cr�ditos Infonavit, y al cual, se ya se adhiri� el Derechohabiente mediante el Convenio de Adhesi�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIDUCIARIO.</vb> Es GRUPO FINANCIERO VE POR MAS S.A. DE C.V., Divisi�n Fiduciaria.<p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>OBRA.</vb> Son los trabajos de reparaci�n, y/o mejora realizados o que deba realizar el Ejecutor de Obra en el Inmueble en t�rminos de este Contrato y sus anexos.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Por regla general y a menos que expresamente se estipule lo contrario, la Cotizaci�n de la Obra, y en su caso, los Planos indican todo el trabajo y obra necesaria para una ejecuci�n y acabado completo de cada concepto, se encuentren o no mencionados todos los detalles, pues el Ejecutor de Obra debe entregar los trabajos de reparaci�n y/o mejora cabalmente concluidos con las especificaciones, calidad y funcionalidad que la buena pr�ctica de la ingenier�a y arquitectura suponen, as� como en cumplimiento a los requerimientos y est�ndares establecidos por el Administrador conforme al contrato firmado entre �sta y el Ejecutor de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PLANOS.</vb> Significan el documento que contiene la descripci�n del Inmueble y detalla el �rea en la que se realizar�n las modificaciones por parte del Ejecutor de la Obra. Los Plaos incluir�n entre otros aspectos, las medidas, volumen y dimensiones del �rea del Inmueble en el que se ejecutar� la Obra y en su caso, se adjuntan como Anexo A.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PROGRAMA DE TRABAJO.</vb> Es la descripci�n ordenada de actividades que el Ejecutor de Obra debe llevar a cabo en el Inmueble en un periodo de tiempo determinado, y que incluye la aplicaci�n de la Cotizaci�n de la Obra en los Planos, plazos de ejecuci�n de los trabajos y dem�s elementos necesarios para la ejecuci�n de la Obra en el Inmueble. En su caso, ese documento se adjuntar a este instrumento como Anexo A.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SISTEMA.</vb> Es la plataforma tecnol�gica operada mediante la p�gina web del Administrador (www.ceide.toole.mx) en la cual el Derechohabiente autorizar�, entre otros, el pago del Anticipo al Ejecutor de Obra; �ste incorporar� los avances de los trabajos de Obra para el Derechohabiente los revise, y en su caso, emita la autorizaci�n final de la Obra. El Derechohabiente reconocer� como v�lidos todos los actos, informaci�n y acuerdos contenidos en el Sistema, y todos los efectos legales derivados de los mismos. En caso de que el Sistema presente fallas, las partes podr�n acordar por escrito los actos respectivos o emitir la informaci�n correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PERITO.</vb>  Es el experto, y puede ser arquitecto y/o ingeniero civil, con c�dula expedida por la Secretar�a de Educaci�n P�blica, designado de acuerdo al Contrato de Obra para que acuda al Inmueble, a solicitud del Derechohabiente o el Ejecutor de Obra para resolver las diferencias de trabajos ejecutados o no ejecutados conforme a la Cotizaci�n de la Obra, en su caso, los Planos, el Programa de Trabajo o para revisar la calidad de la Obra una vez que �sta sea entregada conforme al Contrato de Obra, de acuerdo con la Cl�usula Quinta de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEGUNDA. - DE LAS PARTES</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>I. 	Del Ejecutor de Obra:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Ejecutor de Obra har� la Obra en el Inmueble, por un monto total de $valorneto ($valornetov). Las partes acuerdan que los trabajos iniciar�n $inicio y concluir�n el $fin . En todo caso, el plazo m�ximo para terminar esos trabajos no podr� exceder de 6 (seis) meses contados a partir del otorgamiento del Cr�dito Infonavit. La Cotizaci�n de la Obra se ejecutar� �nica y exclusivamente utilizando el monto del Cr�dito Infonavit efectivamente transferido al Fideicomiso, el cual se indica arriba. Asimismo, las partes reconocen que dicha cantidad puede diferir del monto solicitado por el Derechohabiente en la solicitud de Cr�dito Infonavit. Si, como consecuencia de lo anterior, se precisaran cambios en la Cotizaci�n de la Obra, se aplicar� el siguiente p�rrafo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las partes reconocen y est�n de acuerdo en que si con motivo de la cantidad transferida en el Fideicomiso, es necesario hacer ajustes a la Cotizaci�n de la Obra, esos cambios versar�n �nica y exclusivamente en unidades de material y en especificaciones de calidad, sin que se vea alterada la funcionalidad de la Obra en el �rea designada en el Inmueble, ni el concepto integral de la Obra. Lo anterior dado que la Empresa Verificadora, derivado de la visita inicial de verificaci�n, autoriz� precisamente la ejecuci�n de la Obra en el Inmueble aplicando la Cotizaci�n de la Obra originalmente presentada ante el Infonavit Si evaluado lo anterior, las partes aun as� consideran que debe hacerse un cambio que exceda lo establecido anteriormente, se aplicar� el p�rrafo 1 siguiente para lo cual, previo a cualquier modificaci�n, deber�n solicitar una nueva visita de verificaci�n inicial a la Empresa Verificadora que realiz� la primera visita para efectos de obtener del Cr�dito Infonavit. En cualquier caso, esa nueva Cotizaci�n de la Obra ser� elaborada y almacenada en el Sistema y/o se generar� por escrito y ser� firmada por las partes en forma aut�grafa. Dicho documento ser� parte integrante de este contrato y reemplazar� al anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectuar la entrega final de la Obra, el Ejecutor de Obra le dar� aviso por escrito al Derechohabiente a fin de que esas partes suscriban el Acta de Entrega de la Obra, en la que conste la conclusi�n de los trabajos contratados y la conformidad del Derechohabiente respecto a los mismos, la cual estar� firmada por las partes El Ejecutor de Obra entregar� al Administrador un ejemplar original firmado de esa Acta de Entrega. Posteriormente, el Administrador solicitar� al Infonavit la asignaci�n de una Empresa Verificadora para que haga la verificaci�n final de la Obra respecto a la aplicaci�n del Cr�dito Infonavit en el Inmueble, y generar� los reportes de la visita final y el dictamen de aplicaci�n de recursos. El Derechohabiente dar� las facilidades necesarias a dicha empresa para la realizaci�n de la verificaci�n final.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2); 

$txt="<p>Ser� responsabilidad del Administrador asistir al Derechohabiente durante el proceso de verificaci�n final. El Derechohabiente ser� responsable del pago directo de las visitas de verificaci�n inicial, final y cualquier otra visita que se genere en t�rminos de este contrato, sin que se tome del Cr�dito Infonavit. El pago se har� en la cuenta bancaria de la Empresa Verificadora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si el resultado de la verificaci�n final es positivo, y as� se lo informa la Empresa Verificadora al Administrador emitiendo un dictamen de aplicaci�n de recursos positivo, el Administrador solicitar� a la Afianzadora que cancele la Fianza de Cumplimiento contratada por el Ejecutor de Obra. Si el resultado es negativo, el Ejecutor de Obra se obliga a atender las instrucciones del Administrador derivadas de esa verificaci�n final, lo que implicar�, en su caso, que el Ejecutor de Obra ponga los recursos necesarios para dicho cumplimiento. El Administrador apoyar� y asistir� al Derechohabiente para que el Ejecutor de Obra resuelva la problem�tica planteada por el dictamen de la Empresa Verificadora, lo que incluir� la intervenci�n del Administraci�n y/o la del Perito, y la ejecuci�n de la fianza conforme a la Cl�usula Quinta de este Contrato. Asimismo, si el Derechohabiente se niega a firmar el Acta de Entrega o permitir la verificaci�n final, el Ejecutor de Obra as� se lo notificar� al Administrador para que este y/o el Perito intervengan conforme a dicha Cl�usula Quinta.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>1.	Las partes reconocen y aceptan que solo podr� modificarse la Cotizaci�n de la Obra, y en caso de existir, los Planos y el Programa de Trabajo si la Empresa Verificadora, que ejecut� la verificaci�n inicial previo al otorgamiento del Cr�dito Infonavit, ha realizado una visita de verificaci�n al Inmueble y ha aprobado esos cambios propuestos; y asimismo, de ser necesario, la Afianzadora ha autorizado esos cambios. La Empresa Verificadora entregar� al Administrador una copia del documento que emita con tal motivo. En todo caso, esas modificaciones no exceder�n el monto del Cr�dito Infonavit. Esa nueva Cotizaci�n de la Obra ser� elaborada y almacenada en el Sistema y/o se generar� por escrito y ser� firmada por las partes en forma aut�grafa Dicho documento ser� parte integrante de este contrato y reemplazar� al anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si los cambios propuestos tambi�n requieren la autorizaci�n de la Afianzadora, en tanto dicha instituci�n revisa las modificaciones, el Ejecutor de Obra no podr� ejecutar trabajo alguno relacionado con la Obra; tampoco el Derechohabiente deber� girar instrucci�n alguna conforme a este Contrato para el pago al Ejecutor de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2); 

$txt="<p>Si la Afianzadora autoriza expresamente dichos cambios por escrito, el Ejecutor de Obra podr� retomar la ejecuci�n de los trabajos en el Inmueble, y el Derechohabiente autorizar� el pago por trabajos hechos conforme al procedimiento de pagos de la Cl�usula Cuarta de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si la Afianzadora no aprueba expresamente esos cambios, el Ejecutor de Obra no podr� proceder con los cambios acordados con el Derechohabiente, cualquiera que sea su naturaleza. Ser� nula esta obligaci�n puesto que no se habr� cumplido la condici�n a la que estaba sujeta, y la Afianzadora no estar� obligada a garantizar obligaci�n alguna.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>2.	El Ejecutor de Obra no ser� responsable por los retrasos en la ejecuci�n de los trabajos contenidos en los documentos del Anexo A cuando aquellos sean causados por el Derechohabiente, familiares de este, terceros en el Inmueble y/o vecinos del primero. En caso de ocurrir dicha situaci�n, el Ejecutor de Obra avisar� al Administrador para que, si es necesario extender el plazo de ejecuci�n de los trabajos o cambiar los documentos del Anexo A, el Administrador solicite a la Empresa Verificadora que realice una nueva visita de verificaci�n. De ser necesario, el Ejecutor de Obra tambi�n solicitar� la autorizaci�n de la Afianzadora respecto al cambio en el plazo de ejecuci�n y/o los trabajos de la Obra, todo lo anterior de acuerdo lo referido en el p�rrafo 2 anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B.	El Ejecutor de Obra utilizar� el Anticipo que, por instrucciones del Administrador, el Fiduciario le pague, para la compra de material de acuerdo con la Cotizaci�n de la Obra, para mano de obra y/o para invertir en la Obra en cuesti�n. Para que el Administrador instruya al Fiduciario que pague al Ejecutor de Obra ese Anticipo, el Derechohabiente previamente deber� revisar en el Sistema el monto requerido y los conceptos a los que corresponde en t�rminos de la Cotizaci�n de la Obra. El Derechohabiente deber� autorizar la Cotizaci�n de la Obra, ya incorporada en el Sistema con el monto neto del Cr�dito Infonavit, con la indicaci�n del porcentaje de Anticipo dentro de las 24 (veinticuatro) horas siguientes a la fecha en que aparezca la notificaci�n correspondiente en los Sistema.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Previo a la entrega del Anticipo, el Ejecutor de Obra deber� invariablemente garantizar el cumplimiento de la Obra y la garant�a por buena calidad, de acuerdo con este contrato y en especial de la Cl�usula Sexta.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C.	El Ejecutor de Obra emplear� en la ejecuci�n de la Obra equipos de la mejor calidad y en buenas condiciones de operaci�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D.	El Ejecutor de Obra deber� cumplir con todas las leyes, reglamentos y disposiciones aplicables, siendo por cuenta exclusiva del Ejecutor de Obra cualquier sanci�n o multa que las autoridades o sindicatos llegaren a imponer por violaci�n a cualquiera de dichas disposiciones.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E.	El Ejecutor de Obra ser� responsable de informar al Derechohabiente si son necesarios permisos y autorizaciones expedidas por la autoridad competente sean federales, locales o municipales, para la ejecuci�n de la Obra en el Inmueble; as� como tramitar y gestionar esos permisos directamente con esas autoridades. Los gastos por esos conceptos ser�n incluidos en la Cotizaci�n de la Obra, y la gesti�n de esas autorizaciones ser� contemplada para efectos de la entrega de la Obra en el plazo acordado con el Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>F.	Durante el plazo de ejecuci�n de la Obra y cuando el Ejecutor de Obra haga las reparaciones de acuerdo con el apartado I siguiente, en un horario lunes a viernes de 8:00 a 18:00 horas, y el s�bado de 8:00 a 13:00 horas, el Ejecutor de Obra ser� responsable de los materiales, equipos y herramientas requeridos para la ejecuci�n de la Obra y que permanezcan en el Inmueble hasta la entrega formal de la misma. Lo anterior incluir� tambi�n las medidas necesarias para su custodia mientras esos materiales, equipos y herramientas no se est�n utilizando para la ejecuci�n de los trabajos, solamente durante el horario citado al principio de este p�rrafo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Fuera de esos horarios, el Derechohabiente ser� responsable de la conservaci�n y custodia de ese material, equipos y herramientas, as� como de la Obra misma, independientemente del grado de avance de �sta. El Derechohabiente deber� tomar todas las medidas necesarias para resguardar sus pertenencias y objetos de valor en el Inmueble durante todo el periodo en el que se ejecuten los trabajos de la Obra y cuando el Ejecutor de Obra haga las reparaciones de acuerdo con el apartado I siguiente. Esas medidas incluir�n sin limitaci�n: remover y resguardar objetos fr�giles, objetos de valor, dinero, valores, documentos importantes, tarjetas de cr�dito, productos electr�nicos, electrodom�sticos, l�mparas, tapetes, cuadros, esculturas.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>G.	El Ejecutor de Obra tomar� las precauciones necesarias para evitar que como resultado de la Obra se causen directamente da�os o perjuicios al Derechohabiente, el Inmueble o a cualquier tercero en sus bienes o personas. El Ejecutor de Obra ser� responsable por dichos da�os salvo en los casos de caso fortuito o fuerza mayor, siempre y cuando no exista negligencia alguna por parte del Ejecutor de Obra y �ste se apegue al cumplimiento del y las buenas pr�cticas en la construcci�n, remodelaci�n y/o reparaci�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>H.	El Ejecutor de Obra asumir� tambi�n todos los riesgos por la ejecuci�n de la Obra hasta la entrega formal.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>I.	El Ejecutor de Obra ser� responsable de que la Obra funcione para lo cual fue contratada por el Derechohabiente y conforme a las especificaciones calidad y funcionalidad descritas en la Cotizaci�n de la Obra y en su caso, los Planos y el Programa de Trabajo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para ello, durante 3 (tres) meses contados a partir de la entrega de la Obra conforme al apartado A precedente, el Ejecutor de Obra har� las reparaciones necesarias para su buen funcionamiento y operaci�n, incluyendo las reparaciones requeridas por vicios ocultos. El Derechohabiente contactar� al Administrador para que el Ejecutor de Obra haga las correcciones correspondientes. Asimismo, el Ejecutor de Obra ser� responsable por los da�os y perjuicios causados al Derechohabiente y los terceros en sus bienes y en sus personas con posterioridad a la entrega de la Obra que sean atribuibles directamente a la ejecuci�n de la misma.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Ejecutor de Obra quedar� eximido de esta obligaci�n, si las reparaciones requeridas por el Derechohabiente obedecen a que �ste, sus familiares, personas en el Inmueble o vecinos del Derechohabiente: (1) han hecho un uso inadecuado de la Obra y/o partes integrantes de la misma, de acuerdo con los manuales de uso o pr�cticas aceptadas, (2) han causado da�o o merma a las mismas, y/o (3) no le han dado mantenimiento correcto de acuerdo con las recomendaciones del Ejecutor de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>J.	El Ejecutor de Obra mantendr� limpias y en buen estado todas las partes de la Obra hasta su entrega y recepci�n total. Asimismo, el Ejecutor de Obra deber� mantener disciplina y orden en el trabajo durante el horario referido en el apartado F anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>K.	Si existe un problema o diferendo con el Derechohabiente en relaci�n con la Obra, la Cotizaci�n de la Obra, los Planos y/o, el Ejecutor de Obra solicitar� la intervenci�n del Perito de acuerdo con la cl�usula Quinta. En cualquier momento, el Ejecutor de Obra podr� enviar al Derechohabiente un Acta de Incumplimiento con el formato descargado del Sistema, se�alando los incumplimientos del Derechohabiente, y lo que el Ejecutor de Obra reclama.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>L.	El Ejecutor de Obra ser� siempre responsable de (1) tomar nota de los trabajos en las bit�coras a trav�s del Sistema, y (2) sujeto al apartado A, acordar con el Derechohabiente los cambios a la Cotizaci�n de la Obra, y en su caso los Planos y el Programa de Trabajo en el Sistema incluyendo pr�rrogas. El Derechohabiente supervisar� el cumplimiento del Ejecutor de Obra a la obligaci�n consignada en esta cl�usula.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>M. El Ejecutor de Obra ser� responsable de entregar al Derechohabiente el aviso de privacidad por lo que respecta al tratamiento de los datos personales que haga el Ejecutor de Obra en t�rminos de la normatividad en la materia vigente. Ello con independencia del Aviso de Privacidad que le entregue el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>II.	Del Derechohabiente.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A.	El Derechohabiente deber� autorizar las solicitudes de ministraci�n presentadas por el Ejecutor de Obra en los Sistema, de acuerdo con el apartado B de la secci�n I de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B.	El Derechohabiente revisar� semanalmente los trabajos de la Obra y otorgar� su aceptaci�n o rechazo conforme a la Cl�usula Cuarta siguiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C.	El Derechohabiente se abstendr� de realizar cualquier acto u acci�n que impida al Ejecutor de Obra la ejecuci�n de la Obra de acuerdo con este contrato, o bien la custodia y conservaci�n de los materiales, equipos y herramientas en dicho domicilio cuando se utilicen para la ejecuci�n de la Obra. Asimismo, el Derechohabiente dar� las facilidades necesarias al Ejecutor de Obra para la realizaci�n de la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D.	El Derechohabiente tomar� las medidas necesarias respecto a sus bienes, pertenencias y objetos de valor, se�aladas en el apartado F de la secci�n I de esta Cl�usula Segunda. En caso de incumplimiento, el Derechohabiente ser� responsable de la p�rdida o menoscabo de esos bienes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E.	Si existe un problema o diferendo con el Ejecutor de Obra en relaci�n con la Obra, la Cotizaci�n de la Obra, los Planos, el Derechohabiente solicitar� la intervenci�n del Perito de acuerdo con la cl�usula Quinta. En cualquier momento, el Derechohabiente podr� enviar al Ejecutor de Obra un Acta de Incumplimiento con el formato descargado del Sistema, se�alando los incumplimientos del Ejecutor de Obra, y lo que el Derechohabiente reclama.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>III.	De las Obligaciones Comunes de las Partes.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para cualquier comunicaci�n relativa al cumplimiento de este Contrato, incluyendo la coordinaci�n entre el Ejecutor de Obra y el Derechohabiente para el acceso al Inmueble, las partes designan como sus coordinadores a las siguientes personas:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>I. Ejecutor de Obra:  ALEJANDRO PEREZ BOBADILLA </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>II. Derechohabiente:  $unombre</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En la inteligencia de que todas las comunicaciones entre las partes deber�n hacerse a trav�s del Sistema. En caso de falla de este, las partes podr�n comunicarse por escrito con firma aut�grafa.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que cualquiera de las partes desee cambiar a su coordinador, aqu�lla deber� notificar por escrito a la otra con por lo menos 48 (cuarenta y ocho) horas de anticipaci�n mediante el Sistema.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);



/*
$txt="<p>Tengo plena conciencia de que es un cr�dito y que si no realizo la mejoras no se utilizara el SSV para liquidarlo y seguir� pagando el cr�dito hasta su liquidaci�n total.</p>";
$pdf->Cell(12,$es,"A)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Se que tienen 180 d�as para hacer las remodelaciones correspondientes y que no existe pr�rroga para ampliar el plazo.</p>";
$pdf->Cell(12,$es,"B)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Se que tengo que cumplir al pie de la letra el programa y presupuesto de obra ya que el hecho de no hacerlo pone en riesgo que el dictamen de aplicaci�n de recursos (segunda visita) resulte negativo por ende no se liquidara mi cr�dito.</p>";
$pdf->Cell(12,$es,"C)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Que una vez concluidas las mejoras se realizara una segunda visita a la vivienda bajo el objeto del cr�dito y de proceder de emitir� un DAR positivo donde se determinara que se jale el SSV, para liquidar el cr�dito.</p>";
$pdf->Cell(12,$es,"D)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Que una vez emitido el DAR positivo el tiempo estimado para que el cr�dito se vea liquidado y por ende poder bajar el aviso de suspensi�n de descuentos es de 3 meses contados a partir de que el �rea t�cnica env�a el dictamen a oficinas centrales.</p>";
$pdf->Cell(12,$es,"E)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");

$pdf->Ln(30);
$pdf->Cell(45,7,"",0,0,"C");
$pdf->Cell(90,$es,"Atentamente",0,1,"C");
$pdf->Ln(20);

$pdf->SetFont('Arial','B',$fs);
$pdf->Cell(45,7,"",0,0,"C");
$pdf->Cell(90,7,$unombre,"T",1,"C");*/

$pdf->Output();
?>
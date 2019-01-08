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
	### Generación de PDF

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


$txt="<p>CONTRATO DE REPARACIÓN O REMODELACIÓN DE CASA HABITACIÓN (CONTRATO DE OBRA) QUE CELEBRAN <vb>".$unombre."</vb>, POR SU PROPIO DERECHO Y POR LA OTRA PARTE <vb>VITTA COCINAS DE ESTILO, S.A. de C.V.</vb> ,  REPRESENTADA EN ESTE ACTO POR <vb>ALEJANDRO PEREZ BOBADILLA</vb> EN SU CARÁCTER DE REPRESENTANTE LEGAL AL TENOR DE LAS DECLARACIONES Y CLÁUSULAS SIGUIENTES.</p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"A N T E C E D E N T E S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    CONTRATO MAESTRO DE COLABORACIÓN. –</vb> PROMOTORÍA ASOCIADOS ESTA ES TU CASA S.A. DE C.V. (el Administrador) y el Instituto del Fondo Nacional de la Vivienda para los Trabajadores (Infonavit) han suscrito un Contrato Maestro de Colaboración para la Incorporación al Programa de Apoyo de Línea Cuatro. En virtud del mismo, el Administrador presta servicios de: A) asesoría en la solicitud del crédito línea IV de acuerdo a la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores (Crédito Infonavit) para la reparación o mejora de habitaciones, sin afectación estructural y sin garantía hipotecaria; y B) administración y aplicación de los recursos de dicho crédito a través de un fideicomiso de administración de pago.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    CONTRATO ADMINISTRADOR - DERECHOHABIENTE. </vb> El Derechohabiente y el Administrador tienen celebrado un contrato para la prestación de los servicios descritos en el antecedente I inmediato anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    CRÉDITO INFONAVIT. </vb> El Infonavit le autorizó al Derechohabiente un Crédito Infonavit para la reparación o mejora de casa habitación sobre el Inmueble de conformidad con el artículo 42 fracción II apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>IV.    CONVENIO DE ADHESIÓN. -</vb> El Derechohabiente tiene suscrito un convenio de adhesión con GRUPO FINANCIERO VE POR MAS S.A. DE C.V. División Fiduciaria y el Administrador. Mediante ese instrumento, el Derechohabiente se adhirió al Fideicomiso 437 referido en la Cláusula Primera siguiente. </p>";
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

$txt="<p>Es propietario del inmueble ubicado en <vb>$domicilio</vb> en el cual se ejecutarán los trabajos objeto de este Contrato.</p>";
$pdf->Cell(10,$es,"B",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Tener su domicilio en el Inmueble descrito en el apartado B anterior y con correo electrónico $email.</p>";
$pdf->Cell(10,$es,"C",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Como consecuencia del Crédito Infonavit que le fuera autorizado por el Infonavit, es su deseo celebrar el presente contrato con el Ejecutor de Obra para la aplicación de dicho crédito a la ejecución de los trabajos en el Inmueble contenidos en la Cotización de la Obra, los Planos y en su caso, el Programa de Trabajo (términos definidos más adelante); por lo que, manifiesta que los revisó y que conoce las especificaciones contenidas en dichos documentos, y por tanto, está conforme con estos así como con todos los demás documentos anexos que integran el presente Contrato.</p>";
$pdf->Cell(10,$es,"D",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    El Ejecutor de Obra declara, bajo protesta de decir verdad, que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);


$pdf->SetFont('Arial','',$fs);
$txt="<p>Es una sociedad debidamente constituida y válidamente existente de conformidad con las leyes de la República Mexicana, según consta en la escritura pública No. <vb>69502</vb> de fecha <vb>05 DE MARZO DE 2013</vb> , otorgada ante la fe del notario público No. <vb>109</vb> <vb>LIC. LUIS DE ANGOITIA BECERRA</vb> , la cual quedó debidamente inscrita en el Registro Público de la Propiedad y Comercio de <vb>CIUDAD DE MEXICO</vb> bajo el folio mercantil electrónico No. <vb>495570-1</vb> .</p>";
$pdf->Cell(10,$es,"A",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Su representante <vb>ALEJANDRO PEREZ BOBADILLA</vb> tiene facultades suficientes para obligar a su representada en términos del presente Contrato, las cuales no le han sido modificadas o revocadas en forma alguna a la fecha de firma del presente Contrato..</p>";
$pdf->Cell(10,$es,"B",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Está al corriente en el pago del Impuesto sobre la Renta y que su clave de Registro Federal de Contribuyentes es <vb>VCE130305C26</vb> . Asimismo, el Ejecutor de Obra se encuentra al corriente en el pago de sus cuotas obrero-patronales y que su número de registro ante el Instituto Mexicano de Seguridad Social es </p>";
$pdf->Cell(10,$es,"C",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Fue elegido libremente por el Derechohabiente para la ejecución de los trabajos en el Inmueble de conformidad con la Cotización de la Obra y en su caso, los Planos y el Programa de Trabajo; que conoce las especificaciones solicitadas por el Derechohabiente en esos documentos; que con tal motivo revisó y está conforme esos documentos anexos.</p>";
$pdf->Cell(10,$es,"D",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ha inspeccionado el Inmueble donde se ejecutarán los trabajos descritos en la Cotización de la Obra y en su caso, el Programa de Trabajo y los Planos, y conoce todas las condiciones, a fin de considerar todos los factores que intervendrán en su realización incluyendo, entre otros, ubicación y accesos.</p>";
$pdf->Cell(10,$es,"E",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Cuenta con amplia experiencia y con todos los recursos materiales, humanos y equipos necesarios para la ejecución eficiente de los trabajos requeridos para la Obra.</p>";
$pdf->Cell(10,$es,"F",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Señala su domicilio para todos los efectos de este Contrato, el ubicado en ENCINOS MZ.244 LT.43, COL. CHICHICASPATL C.P. 14108 DEL. TLALPAN, CIUDAD DE MEXICO con correo electrónico____________________________.</p>";
$pdf->Cell(10,$es,"G",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Expuesto lo anterior, las partes están de acuerdo en sujetar el presente contrato a las siguientes cláusulas:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"C  L  Á  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);


$txt="<p><vb>PRIMERA. - OBJETO Y DEFINICIONES.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente encomienda al Ejecutor de Obra y éste bajo su propia responsabilidad se obliga a ejecutar en el Inmueble los trabajos de reparación, o mejora descritos en la Cotización de la Obra, y en su caso, en los Planos y el Programa de Trabajo. Éstos se adjuntan al presente contrato como Anexo A en forma escrita y firmados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectos de este Contrato, las siguientes definiciones tendrán los significados a continuación indicados:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ACTA DE ENTREGA.</vb> Es el documento en el cual consta la conclusión de los trabajos a cargo del Ejecutor de Obra, y la conformidad del Derechohabiente respecto a los mismos, el cual estará firmado por ambas partes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ACTA DE INCUMPLIMIENTO.</vb> Es el documento elaborado por el Derechohabiente y/o el Ejecutor de Obra, en el cual se detallan los incumplimientos del Derechohabiente o del Ejecutor de Obra al Contrato de Obra o a la calidad de la misma, según sea el caso. El Acta de Incumplimiento podrá ser elaborada conforme a los formatos sugeridos por el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ADMINISTRADOR.</vb> Es PROMOTORÍA ASOCIADOS ESTA ES TU CASA S.A. DE C.V., la cual apoyará al Ejecutor de Obra y al Derechohabiente como partes de este Contrato en términos de este instrumento y del Anexo B.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>AFIANZADORA.</vb> Es BERKLEY MEXICO FIANZAS autorizada por la Secretaría de Hacienda y Crédito Público para expedir fianzas y garantizar el cumplimiento del Contrato de Obra, y la obligación de calidad, ambas a cargo del Ejecutor de Obra de conformidad con ese instrumento y la normatividad vigente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>ANTICIPO.</vb> Es el pago inicial al que tiene derecho el Ejecutor de Obra para que compre el material, pague mano de obra e invierta en la Obra, en términos de la Cotización de la Obra y de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CONTRATO GENERAL DE AFIANZAMIENTO.</vb> Es el Contrato que regula las relaciones jurídicas entre la Afianzadora, el Fideicomiso como beneficiario y el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CONTRATO INDIVIDUAL DE AFIANZAMIENTO.</vb> Es el contrato que se firmará por cada Ejecutor de Obra con la Afianzadora, previo a la emisión de los Endosos de Inclusión.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>COTIZACIÓN DE LA OBRA.</vb> Es la propuesta económica del Ejecutor de la Obra que resulta de multiplicar unidades de material requerido con determinadas especificaciones de calidad y funcionalidad para ejecutar una obra en el área designada por el Derechohabiente en el Inmueble, por el precio unitario de ese material.  La Cotización de la Obra también incluirá los costos directos e indirectos de la Obra, mano de obra, de los equipos, insumos, costos de almacenaje, así como la utilidad de la Obra. La Cotización de la Obra se adjunta al presente instrumento como Anexo A, el cual está firmado por las Partes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CRÉDITO INFONAVIT.</vb> Significa el crédito otorgado por el Infonavit a los Derechohabientes para que éstos los destinen a la reparación o mejora de habitación, de conformidad con el artículo 42 fracción II de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>EMPRESA VERIFICADORA.</vb> Significa la entidad o empresa verificadora, registrada ante el Infonavit y autorizada por éste para ejecutar los actos referidos en el Cláusula Segunda respecto a la verificación inicial, verificación final y/o cualquier otra verificación adicional.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIANZAS, ENDOSOS DE INCLUSION.</vb> Se entenderán indistintamente como las fianzas de cumplimiento y fianzas de calidad otorgadas por la Afianzadora contratadas por el Ejecutor de Obra en virtud de este Contrato de Obra en términos de la Cláusula Sexta, así como del Contrato General de Afianzamiento, por medio del cual se incorporan los Fiados a la Fianza Global y se establece la vigencia, fecha de emisión, los montos y conceptos a garantizar.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIANZA GLOBAL.</vb> Es el documento donde se establecen las obligaciones adquiridas por la Afianzadora ante el Beneficiario en los términos del artículo 144 de la Ley de Instituciones de Seguros y Fianzas.<p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIDEICOMISO.</vb> Es el contrato de fideicomiso 437 celebrado entre GRUPO FINANCIERO VE POR MAS S.A. DE C.V. División Fiduciaria y el administrador para la administración de los fondos procedentes de los Créditos Infonavit, y al cual, se ya se adhirió el Derechohabiente mediante el Convenio de Adhesión.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIDUCIARIO.</vb> Es GRUPO FINANCIERO VE POR MAS S.A. DE C.V., División Fiduciaria.<p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>OBRA.</vb> Son los trabajos de reparación, y/o mejora realizados o que deba realizar el Ejecutor de Obra en el Inmueble en términos de este Contrato y sus anexos.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Por regla general y a menos que expresamente se estipule lo contrario, la Cotización de la Obra, y en su caso, los Planos indican todo el trabajo y obra necesaria para una ejecución y acabado completo de cada concepto, se encuentren o no mencionados todos los detalles, pues el Ejecutor de Obra debe entregar los trabajos de reparación y/o mejora cabalmente concluidos con las especificaciones, calidad y funcionalidad que la buena práctica de la ingeniería y arquitectura suponen, así como en cumplimiento a los requerimientos y estándares establecidos por el Administrador conforme al contrato firmado entre ésta y el Ejecutor de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PLANOS.</vb> Significan el documento que contiene la descripción del Inmueble y detalla el área en la que se realizarán las modificaciones por parte del Ejecutor de la Obra. Los Plaos incluirán entre otros aspectos, las medidas, volumen y dimensiones del área del Inmueble en el que se ejecutará la Obra y en su caso, se adjuntan como Anexo A.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PROGRAMA DE TRABAJO.</vb> Es la descripción ordenada de actividades que el Ejecutor de Obra debe llevar a cabo en el Inmueble en un periodo de tiempo determinado, y que incluye la aplicación de la Cotización de la Obra en los Planos, plazos de ejecución de los trabajos y demás elementos necesarios para la ejecución de la Obra en el Inmueble. En su caso, ese documento se adjuntar a este instrumento como Anexo A.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SISTEMA.</vb> Es la plataforma tecnológica operada mediante la página web del Administrador (www.ceide.toole.mx) en la cual el Derechohabiente autorizará, entre otros, el pago del Anticipo al Ejecutor de Obra; éste incorporará los avances de los trabajos de Obra para el Derechohabiente los revise, y en su caso, emita la autorización final de la Obra. El Derechohabiente reconocerá como válidos todos los actos, información y acuerdos contenidos en el Sistema, y todos los efectos legales derivados de los mismos. En caso de que el Sistema presente fallas, las partes podrán acordar por escrito los actos respectivos o emitir la información correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PERITO.</vb>  Es el experto, y puede ser arquitecto y/o ingeniero civil, con cédula expedida por la Secretaría de Educación Pública, designado de acuerdo al Contrato de Obra para que acuda al Inmueble, a solicitud del Derechohabiente o el Ejecutor de Obra para resolver las diferencias de trabajos ejecutados o no ejecutados conforme a la Cotización de la Obra, en su caso, los Planos, el Programa de Trabajo o para revisar la calidad de la Obra una vez que ésta sea entregada conforme al Contrato de Obra, de acuerdo con la Cláusula Quinta de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEGUNDA. - DE LAS PARTES</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>I. 	Del Ejecutor de Obra:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Ejecutor de Obra hará la Obra en el Inmueble, por un monto total de $valorneto ($valornetov). Las partes acuerdan que los trabajos iniciarán $inicio y concluirán el $fin . En todo caso, el plazo máximo para terminar esos trabajos no podrá exceder de 6 (seis) meses contados a partir del otorgamiento del Crédito Infonavit. La Cotización de la Obra se ejecutará única y exclusivamente utilizando el monto del Crédito Infonavit efectivamente transferido al Fideicomiso, el cual se indica arriba. Asimismo, las partes reconocen que dicha cantidad puede diferir del monto solicitado por el Derechohabiente en la solicitud de Crédito Infonavit. Si, como consecuencia de lo anterior, se precisaran cambios en la Cotización de la Obra, se aplicará el siguiente párrafo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las partes reconocen y están de acuerdo en que si con motivo de la cantidad transferida en el Fideicomiso, es necesario hacer ajustes a la Cotización de la Obra, esos cambios versarán única y exclusivamente en unidades de material y en especificaciones de calidad, sin que se vea alterada la funcionalidad de la Obra en el área designada en el Inmueble, ni el concepto integral de la Obra. Lo anterior dado que la Empresa Verificadora, derivado de la visita inicial de verificación, autorizó precisamente la ejecución de la Obra en el Inmueble aplicando la Cotización de la Obra originalmente presentada ante el Infonavit Si evaluado lo anterior, las partes aun así consideran que debe hacerse un cambio que exceda lo establecido anteriormente, se aplicará el párrafo 1 siguiente para lo cual, previo a cualquier modificación, deberán solicitar una nueva visita de verificación inicial a la Empresa Verificadora que realizó la primera visita para efectos de obtener del Crédito Infonavit. En cualquier caso, esa nueva Cotización de la Obra será elaborada y almacenada en el Sistema y/o se generará por escrito y será firmada por las partes en forma autógrafa. Dicho documento será parte integrante de este contrato y reemplazará al anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectuar la entrega final de la Obra, el Ejecutor de Obra le dará aviso por escrito al Derechohabiente a fin de que esas partes suscriban el Acta de Entrega de la Obra, en la que conste la conclusión de los trabajos contratados y la conformidad del Derechohabiente respecto a los mismos, la cual estará firmada por las partes El Ejecutor de Obra entregará al Administrador un ejemplar original firmado de esa Acta de Entrega. Posteriormente, el Administrador solicitará al Infonavit la asignación de una Empresa Verificadora para que haga la verificación final de la Obra respecto a la aplicación del Crédito Infonavit en el Inmueble, y generará los reportes de la visita final y el dictamen de aplicación de recursos. El Derechohabiente dará las facilidades necesarias a dicha empresa para la realización de la verificación final.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2); 

$txt="<p>Será responsabilidad del Administrador asistir al Derechohabiente durante el proceso de verificación final. El Derechohabiente será responsable del pago directo de las visitas de verificación inicial, final y cualquier otra visita que se genere en términos de este contrato, sin que se tome del Crédito Infonavit. El pago se hará en la cuenta bancaria de la Empresa Verificadora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si el resultado de la verificación final es positivo, y así se lo informa la Empresa Verificadora al Administrador emitiendo un dictamen de aplicación de recursos positivo, el Administrador solicitará a la Afianzadora que cancele la Fianza de Cumplimiento contratada por el Ejecutor de Obra. Si el resultado es negativo, el Ejecutor de Obra se obliga a atender las instrucciones del Administrador derivadas de esa verificación final, lo que implicará, en su caso, que el Ejecutor de Obra ponga los recursos necesarios para dicho cumplimiento. El Administrador apoyará y asistirá al Derechohabiente para que el Ejecutor de Obra resuelva la problemática planteada por el dictamen de la Empresa Verificadora, lo que incluirá la intervención del Administración y/o la del Perito, y la ejecución de la fianza conforme a la Cláusula Quinta de este Contrato. Asimismo, si el Derechohabiente se niega a firmar el Acta de Entrega o permitir la verificación final, el Ejecutor de Obra así se lo notificará al Administrador para que este y/o el Perito intervengan conforme a dicha Cláusula Quinta.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>1.	Las partes reconocen y aceptan que solo podrá modificarse la Cotización de la Obra, y en caso de existir, los Planos y el Programa de Trabajo si la Empresa Verificadora, que ejecutó la verificación inicial previo al otorgamiento del Crédito Infonavit, ha realizado una visita de verificación al Inmueble y ha aprobado esos cambios propuestos; y asimismo, de ser necesario, la Afianzadora ha autorizado esos cambios. La Empresa Verificadora entregará al Administrador una copia del documento que emita con tal motivo. En todo caso, esas modificaciones no excederán el monto del Crédito Infonavit. Esa nueva Cotización de la Obra será elaborada y almacenada en el Sistema y/o se generará por escrito y será firmada por las partes en forma autógrafa Dicho documento será parte integrante de este contrato y reemplazará al anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si los cambios propuestos también requieren la autorización de la Afianzadora, en tanto dicha institución revisa las modificaciones, el Ejecutor de Obra no podrá ejecutar trabajo alguno relacionado con la Obra; tampoco el Derechohabiente deberá girar instrucción alguna conforme a este Contrato para el pago al Ejecutor de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2); 

$txt="<p>Si la Afianzadora autoriza expresamente dichos cambios por escrito, el Ejecutor de Obra podrá retomar la ejecución de los trabajos en el Inmueble, y el Derechohabiente autorizará el pago por trabajos hechos conforme al procedimiento de pagos de la Cláusula Cuarta de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si la Afianzadora no aprueba expresamente esos cambios, el Ejecutor de Obra no podrá proceder con los cambios acordados con el Derechohabiente, cualquiera que sea su naturaleza. Será nula esta obligación puesto que no se habrá cumplido la condición a la que estaba sujeta, y la Afianzadora no estará obligada a garantizar obligación alguna.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>2.	El Ejecutor de Obra no será responsable por los retrasos en la ejecución de los trabajos contenidos en los documentos del Anexo A cuando aquellos sean causados por el Derechohabiente, familiares de este, terceros en el Inmueble y/o vecinos del primero. En caso de ocurrir dicha situación, el Ejecutor de Obra avisará al Administrador para que, si es necesario extender el plazo de ejecución de los trabajos o cambiar los documentos del Anexo A, el Administrador solicite a la Empresa Verificadora que realice una nueva visita de verificación. De ser necesario, el Ejecutor de Obra también solicitará la autorización de la Afianzadora respecto al cambio en el plazo de ejecución y/o los trabajos de la Obra, todo lo anterior de acuerdo lo referido en el párrafo 2 anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B.	El Ejecutor de Obra utilizará el Anticipo que, por instrucciones del Administrador, el Fiduciario le pague, para la compra de material de acuerdo con la Cotización de la Obra, para mano de obra y/o para invertir en la Obra en cuestión. Para que el Administrador instruya al Fiduciario que pague al Ejecutor de Obra ese Anticipo, el Derechohabiente previamente deberá revisar en el Sistema el monto requerido y los conceptos a los que corresponde en términos de la Cotización de la Obra. El Derechohabiente deberá autorizar la Cotización de la Obra, ya incorporada en el Sistema con el monto neto del Crédito Infonavit, con la indicación del porcentaje de Anticipo dentro de las 24 (veinticuatro) horas siguientes a la fecha en que aparezca la notificación correspondiente en los Sistema.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Previo a la entrega del Anticipo, el Ejecutor de Obra deberá invariablemente garantizar el cumplimiento de la Obra y la garantía por buena calidad, de acuerdo con este contrato y en especial de la Cláusula Sexta.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C.	El Ejecutor de Obra empleará en la ejecución de la Obra equipos de la mejor calidad y en buenas condiciones de operación.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D.	El Ejecutor de Obra deberá cumplir con todas las leyes, reglamentos y disposiciones aplicables, siendo por cuenta exclusiva del Ejecutor de Obra cualquier sanción o multa que las autoridades o sindicatos llegaren a imponer por violación a cualquiera de dichas disposiciones.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E.	El Ejecutor de Obra será responsable de informar al Derechohabiente si son necesarios permisos y autorizaciones expedidas por la autoridad competente sean federales, locales o municipales, para la ejecución de la Obra en el Inmueble; así como tramitar y gestionar esos permisos directamente con esas autoridades. Los gastos por esos conceptos serán incluidos en la Cotización de la Obra, y la gestión de esas autorizaciones será contemplada para efectos de la entrega de la Obra en el plazo acordado con el Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>F.	Durante el plazo de ejecución de la Obra y cuando el Ejecutor de Obra haga las reparaciones de acuerdo con el apartado I siguiente, en un horario lunes a viernes de 8:00 a 18:00 horas, y el sábado de 8:00 a 13:00 horas, el Ejecutor de Obra será responsable de los materiales, equipos y herramientas requeridos para la ejecución de la Obra y que permanezcan en el Inmueble hasta la entrega formal de la misma. Lo anterior incluirá también las medidas necesarias para su custodia mientras esos materiales, equipos y herramientas no se estén utilizando para la ejecución de los trabajos, solamente durante el horario citado al principio de este párrafo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Fuera de esos horarios, el Derechohabiente será responsable de la conservación y custodia de ese material, equipos y herramientas, así como de la Obra misma, independientemente del grado de avance de ésta. El Derechohabiente deberá tomar todas las medidas necesarias para resguardar sus pertenencias y objetos de valor en el Inmueble durante todo el periodo en el que se ejecuten los trabajos de la Obra y cuando el Ejecutor de Obra haga las reparaciones de acuerdo con el apartado I siguiente. Esas medidas incluirán sin limitación: remover y resguardar objetos frágiles, objetos de valor, dinero, valores, documentos importantes, tarjetas de crédito, productos electrónicos, electrodomésticos, lámparas, tapetes, cuadros, esculturas.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>G.	El Ejecutor de Obra tomará las precauciones necesarias para evitar que como resultado de la Obra se causen directamente daños o perjuicios al Derechohabiente, el Inmueble o a cualquier tercero en sus bienes o personas. El Ejecutor de Obra será responsable por dichos daños salvo en los casos de caso fortuito o fuerza mayor, siempre y cuando no exista negligencia alguna por parte del Ejecutor de Obra y éste se apegue al cumplimiento del y las buenas prácticas en la construcción, remodelación y/o reparación.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>H.	El Ejecutor de Obra asumirá también todos los riesgos por la ejecución de la Obra hasta la entrega formal.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>I.	El Ejecutor de Obra será responsable de que la Obra funcione para lo cual fue contratada por el Derechohabiente y conforme a las especificaciones calidad y funcionalidad descritas en la Cotización de la Obra y en su caso, los Planos y el Programa de Trabajo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para ello, durante 3 (tres) meses contados a partir de la entrega de la Obra conforme al apartado A precedente, el Ejecutor de Obra hará las reparaciones necesarias para su buen funcionamiento y operación, incluyendo las reparaciones requeridas por vicios ocultos. El Derechohabiente contactará al Administrador para que el Ejecutor de Obra haga las correcciones correspondientes. Asimismo, el Ejecutor de Obra será responsable por los daños y perjuicios causados al Derechohabiente y los terceros en sus bienes y en sus personas con posterioridad a la entrega de la Obra que sean atribuibles directamente a la ejecución de la misma.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Ejecutor de Obra quedará eximido de esta obligación, si las reparaciones requeridas por el Derechohabiente obedecen a que éste, sus familiares, personas en el Inmueble o vecinos del Derechohabiente: (1) han hecho un uso inadecuado de la Obra y/o partes integrantes de la misma, de acuerdo con los manuales de uso o prácticas aceptadas, (2) han causado daño o merma a las mismas, y/o (3) no le han dado mantenimiento correcto de acuerdo con las recomendaciones del Ejecutor de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>J.	El Ejecutor de Obra mantendrá limpias y en buen estado todas las partes de la Obra hasta su entrega y recepción total. Asimismo, el Ejecutor de Obra deberá mantener disciplina y orden en el trabajo durante el horario referido en el apartado F anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>K.	Si existe un problema o diferendo con el Derechohabiente en relación con la Obra, la Cotización de la Obra, los Planos y/o, el Ejecutor de Obra solicitará la intervención del Perito de acuerdo con la cláusula Quinta. En cualquier momento, el Ejecutor de Obra podrá enviar al Derechohabiente un Acta de Incumplimiento con el formato descargado del Sistema, señalando los incumplimientos del Derechohabiente, y lo que el Ejecutor de Obra reclama.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>L.	El Ejecutor de Obra será siempre responsable de (1) tomar nota de los trabajos en las bitácoras a través del Sistema, y (2) sujeto al apartado A, acordar con el Derechohabiente los cambios a la Cotización de la Obra, y en su caso los Planos y el Programa de Trabajo en el Sistema incluyendo prórrogas. El Derechohabiente supervisará el cumplimiento del Ejecutor de Obra a la obligación consignada en esta cláusula.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>M. El Ejecutor de Obra será responsable de entregar al Derechohabiente el aviso de privacidad por lo que respecta al tratamiento de los datos personales que haga el Ejecutor de Obra en términos de la normatividad en la materia vigente. Ello con independencia del Aviso de Privacidad que le entregue el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>II.	Del Derechohabiente.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A.	El Derechohabiente deberá autorizar las solicitudes de ministración presentadas por el Ejecutor de Obra en los Sistema, de acuerdo con el apartado B de la sección I de este Contrato.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B.	El Derechohabiente revisará semanalmente los trabajos de la Obra y otorgará su aceptación o rechazo conforme a la Cláusula Cuarta siguiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C.	El Derechohabiente se abstendrá de realizar cualquier acto u acción que impida al Ejecutor de Obra la ejecución de la Obra de acuerdo con este contrato, o bien la custodia y conservación de los materiales, equipos y herramientas en dicho domicilio cuando se utilicen para la ejecución de la Obra. Asimismo, el Derechohabiente dará las facilidades necesarias al Ejecutor de Obra para la realización de la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D.	El Derechohabiente tomará las medidas necesarias respecto a sus bienes, pertenencias y objetos de valor, señaladas en el apartado F de la sección I de esta Cláusula Segunda. En caso de incumplimiento, el Derechohabiente será responsable de la pérdida o menoscabo de esos bienes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E.	Si existe un problema o diferendo con el Ejecutor de Obra en relación con la Obra, la Cotización de la Obra, los Planos, el Derechohabiente solicitará la intervención del Perito de acuerdo con la cláusula Quinta. En cualquier momento, el Derechohabiente podrá enviar al Ejecutor de Obra un Acta de Incumplimiento con el formato descargado del Sistema, señalando los incumplimientos del Ejecutor de Obra, y lo que el Derechohabiente reclama.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>III.	De las Obligaciones Comunes de las Partes.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para cualquier comunicación relativa al cumplimiento de este Contrato, incluyendo la coordinación entre el Ejecutor de Obra y el Derechohabiente para el acceso al Inmueble, las partes designan como sus coordinadores a las siguientes personas:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>I. Ejecutor de Obra:  ALEJANDRO PEREZ BOBADILLA </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>II. Derechohabiente:  $unombre</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En la inteligencia de que todas las comunicaciones entre las partes deberán hacerse a través del Sistema. En caso de falla de este, las partes podrán comunicarse por escrito con firma autógrafa.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que cualquiera de las partes desee cambiar a su coordinador, aquélla deberá notificar por escrito a la otra con por lo menos 48 (cuarenta y ocho) horas de anticipación mediante el Sistema.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);



/*
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
$pdf->Cell(90,7,$unombre,"T",1,"C");*/

$pdf->Output();
?>
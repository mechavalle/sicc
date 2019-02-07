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
	$montopresupuesto=fixmonto($val5['montopresupuesto']);
	//$valornetov=strtoupper(convertir($val5['valorneto']));

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
	### GeneraciÃ³n de PDF

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


$txt="<p><vb>CONVENIO DE ADHESIÓN AL CONTRATO DE FIDEICOMISO IRREVOCABLE NÚMERO “437” (EL “FIDEICOMISO”) QUE CELEBRAN POR UNA PARTE, ".$unombre.", DERECHOHABIENTE ACREDITADO POR EL INFONAVIT  EN SU CARÁCTER DE FIDEICOMITENTE ADHERENTE Y/O FIDEICOMISARIO EN PRIMER LUGAR (EL DERECHOHABIENTE); “PROMOTORA ASOCIADOS ESTA ES TU CASA” S.A. DE C.V., REPRESENTADO EN ESTE ACTO POR DANIELA GODOY CONTRERAS, COMO FIDEICOMITENTE Y FIDEICOMISARIO EN SEGUNDO LUGAR  Y BANCO VE POR MÁS, SOCIEDAD ANÓNIMA, INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO VE POR MÁS, ACTUANDO ÚNICA Y EXCLUSIVAMENTE COMO FIDUCIARIO DEL FIDEICOMISO IRREVOCABLE DE ADMINISTRACIÓN E INVERSIÓN NÚMERO 437 (EL “FIDUCIARIO”), REPRESENTADO EN ESTE ACTO POR SUS DELEGADOS FIDUCIARIOS LICENCIADOS SALVADOR DE LA LLATA MERCADO Y MIRIAM GAMERO ESPINOSA, DE CONFORMIDAD CON LO ESTABLECIDO EN LAS SIGUIENTES ANTECEDENTES, DECLARACIONES Y CLÁUSULAS:</vb></p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$pdf->Cell(180,$es,"A N T E C E D E N T E S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    CONTRATO MAESTRO DE COLABORACIÓN. –</vb> “PROMOTORA ASOCIADOS ESTA ES TU CASA” S.A. DE C.V. y el INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES (INFONAVIT) han suscrito un Contrato Maestro de Colaboración para su incorporación al Programa de Apoyo de Línea Cuatro. En virtud del mismo, el Administrador presta servicios de: A) asesoría en la solicitud del crédito línea IV de acuerdo a la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores (CRÉDITO INFONAVIT) para la reparación o mejora de habitaciones, sin afectación estructural y sin garantía hipotecaria; y B) administración y aplicación de los recursos de dicho crédito a través de un fideicomiso de administración de pago.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    CONTRATO DE FIDEICOMISO. </vb>PROMOTORÍA  y el FIDUCIARIO han suscrito el contrato de fideicomiso número 437 (el FIDEICOMISO) con el fin de que los trabajadores o derechohabientes del INFONAVIT que así lo eligieran, a través del propio INFONAVIT, aportaran los recursos derivados de los CRÉDITOS INFONAVIT, para que el FIDUCIARIO los administre y realice los pagos pertinentes durante el proyecto de reparación, o mejora correspondiente, cuya copia que se adjunta al presente bajo la letra “A“ para formar parte integral de este convenio.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    CONTRATO DE PRESTACIÓN DE SERVICIOS. </vb>El DERECHOHABIENTE y PROMOTORÍA tienen celebrado un contrato para la prestación de los servicios descritos en el antecedente I anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>IV.    CRÉDITO INFONAVIT. </vb>El INFONAVIT le autorizó al DERECHOHABIENTE un CRÉDITO INFONAVIT para la reparación o mejora de casa habitación sobre vivienda de conformidad con el artículo 42 fracción II apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores por un monto equivalente a $montopresupuesto</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>V.    ADHESIÓN. </vb>El DERECHOHABIENTE desea adherirse al FIDEICOMISO citado en el antecedente II, mismo que conoce en todos sus términos y desea aportar al patrimonio de dicho FIDEICOMISO el CRÉDITO INFONAVIT citado en el inciso anterior, para pagarle al ejecutor de obra (el EJECUTOR DE OBRA) por los trabajos en el inmueble conforme al contrato de obra respectivo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(60);

$pdf->Cell(180,$es,"D  E  C  L  A  R  A  C  I  O  N  E  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    Declara EL DERECHOHABIENTE COMO FIDEICOMITENTE ADHERENTE Y FIDEICOMISARIO EN PRIMER LUGAR que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Es mexicano(a)  en pleno uso de sus facultades y con capacidad para obligarse conforme al presente instrumento.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Con la celebración de este contrato no viola convenio, licencia, sentencia u orden con que estén vinculados, ni autorización, ley, reglamento, circular o decreto alguno a que estén sujetos o les sea aplicable.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Al celebrar el CONVENIO DE ADHESIÓN adquirirá y asumirá los derechos y obligaciones que, como FIDEICOMITENTE y FIDEICOMISARIO EN PRIMER LUGAR, constan en el Contrato de FIDEICOMISO citado en los antecedentes del presente convenio.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Con la celebración del presente CONVENIO DE ADHESIÓN está conforme y acepta plenamente que el INFONAVIT transfiera en su totalidad esos fondos directamente al FIDEICOMISO.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Con anterioridad a la firma del presente CONVENIO DE ADHESIÓN, el FIDUCIARIO le invitó y sugirió obtener del profesionista, despacho, o firma de su elección, la asesoría y apoyo en cuanto al alcance, consecuencias, trámites, implicaciones y en general cuestiones legales y fiscales directa o indirectamente relacionadas con el presente FIDEICOMISO, así como su apoyo en la negociación y evaluación del riesgo legal y fiscal del texto definitivo a firmarse. Lo anterior ya que el FIDUCIARIO no se hace responsable de tales cuestiones, por lo que el FIDUCIARIO no garantiza ni asegura que la estructura fiscal contenida en el FIDEICOMISO definitivo no sea alterada con subsecuentes modificaciones a la legislación fiscal y los impactos fiscales e impositivos puedan modificarse. Por lo que manifiesta conocer el FIDEICOMISO, así como los demás contratos y convenios que lo componen.</p>";
$pdf->Cell(10,$es,"E.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Los bienes y/o derechos que se afectan para los fines del FIDEICOMISO son de procedencia lícita, producto de actividades realizadas dentro del marco de la ley y que no existe conexión alguna entre el origen, procedencia o destino de los bienes afectos al FIDEICOMISO o los productos que tales generen y actividades ilícitas o de apoyo a grupos terroristas. Asimismo, se obliga a proporcionar, a través de PROMOTORÍA en términos del presente Convenio de Adhesión y del FIDEICOMISO, al FIDUCIARIO cualquier información que le sea requerida por éste a efecto de dar cumplimiento con lo establecido en el artículo 212 de la Ley del Mercado de Valores y demás disposiciones reglamentarias y políticas institucionales a las que se encuentra sujeta el FIDUCIARIO.</p>";
$pdf->Cell(10,$es,"F.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>De conformidad con lo establecido en la Ley de Protección de Datos Personales, declara que previo al otorgamiento de sus datos personales, el FIDUCIARIO le explicó y entregó el Aviso de Privacidad de Datos Personales.</p>";
$pdf->Cell(10,$es,"G.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>El FIDUCIARIO le ha hecho saber inequívocamente el contenido del artículo 186  de la Ley del Mercado de Valores y el texto aplicable de la Circular 1/2005 y las modificaciones a dicha Circular emitidas por el Banco de México, respecto a las prohibiciones que la limitan en términos de ley y de las disposiciones vigentes, cuyo contenido se reprodujo en el FIDEICOMISO.</p>";
$pdf->Cell(10,$es,"H.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    Declara el FIDUCIARIO, por conducto de sus delegados fiduciarios, que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);


$pdf->SetFont('Arial','',$fs);
$txt="<p>Su representada es una sociedad mercantil, constituida conforme a las leyes de los Estados Unidos Mexicanos y que se encuentra autorizada para llevar a cabo operaciones fiduciarias.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Sus delegados fiduciarios cuentan con las facultades suficientes para obligar a su representada. Las facultades otorgadas de acuerdo con lo anterior, no les han sido revocadas ni restringidas o limitadas en forma alguna.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Celebra el presente convenio en términos del FIDEICOMISO con el objeto de cumplir con los fines del mismo, principalmente para que el FIDEICOMISO reciba los recursos del DERECHOHABIENTE provenientes del Créditos Línea Cuatro para destinarlos a la realización de las obras de reparación o mejora de conformidad con las instrucciones que, para el efecto reciba de PROMOTORÍA, como prestador de servicios y autorizado por el DERECHOHABIENTE para ello, sin que el FIDUCIARIO adquiera ninguna relación con el contratista, ni obligación de supervisión de obra.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ha hecho saber inequívocamente a las Partes del presente convenio el contenido en la disposición B) de la fracción XIX (diecinueve romano), del artículo 106 de la Ley de Instituciones de crédito vigente, cuyo contenido se reprodujo en el Fideicomiso.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    Declara PROMOTORÍA como FIDEICOMISARIO EN SEGUNDO LUGAR, por conducto de su representante que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Es una sociedad debidamente constituida y válidamente existente de conformidad con las leyes de la República Mexicana, según consta en la Escritura Pública No. 77872 de fecha 18 de MARZO de 2010 otorgada ante la fe del Notario Público No. 52 del DISTRITO FEDERAL  Lic. LIC. PROTACIO GUERRA RAMIRO, la cual quedó debidamente inscrita en el Registro Público de Comercio de la Ciudad de México bajo el folio mercantil electrónico No. 417954 el 14 de junio 2010.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>La personalidad con la que se ostenta su representante legal no le ha sido revocada, ni en forma alguna modificada o limitada.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>El FIDUCIARIO le ha hecho saber inequívocamente el contenido y alcance del artículo 115 de la Ley de Instituciones de Crédito así como diversas prohibiciones aplicables al FIDUCIARIO contenidas en distintas leyes y circulares yal como lo establece la circular 1/2005 del banco de México y circular 1/2005 BIS cuyo contenido se reprodujo en el FIDEICOMISO.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Derivado de lo anterior, las partes acuerdan someterse a los términos y condiciones establecidos en las siguientes:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->Cell(180,$es,"C  L  Á  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);


$txt="<p><vb>PRIMERA. - OBJETO.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El DERECHOHABIENTE por medio del presente instrumento acepta y está conforme con adherirse y formar parte del FIDEICOMISO número 437 citado en el antecedente II del presente convenio. Por lo tanto, el DERECHOHABIENTE o también llamado FIDEICOMITENTE ADHERENTE Y FIDEICOMISARIO EN PRIMER LUGAR se obliga en términos del Contrato de FIDEICOMISO citado y gozará de los derechos conferidos por dicho acuerdo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para mayor comprensión, algunos de los términos definidos utilizados en este CONVENIO DE ADHESIÓN tendrán el mismo significado que los contenidos en el contrato de FIDEICOMISO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El DERECHOHABIENTE en este acto y en términos del FIDEICOMISO cede a favor del mismo todos los derechos de las FIANZAS y está de acuerdo en que el FIDEICOMISO sea el único beneficiario de las mismas; en especial, para ejercer los derechos de cobro y ejecución de las FIANZAS en términos del FIDEICOMISO y demás contratos relacionados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En virtud de lo anterior, el  DERECHOHABIENTE directamente o a través del INFONAVIT, se obliga a  depositar en el FIDEICOMISO en la cuenta número <vb>242773 con CLABE interbancaria 113180000002427731 a nombre de BANCO VE POR MÁS, S.A., FIDEICOMISO 437 del Banco Ve por Más, S.A.</vb>, en un término no mayor a los 2 (Dos) días hábiles siguientes contados a partir de  la firma del presente Convenio,  la totalidad de la cantidad del CRÉDITO INFONAVIT a que se refiere el numeral IV de los antecedentes del presente convenio con la debida notificación por parte de PROMOTORÍA sobre la transferencia realizada, para ser destinada a los fines encomendados al FIDUCIARIO en el FIDEICOMISO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEGUNDA. INFORMACIÓN.</vb> PROMOTORÍA deberá proporcionar al FIDUCIARIO los datos e información requerida del DERECHOHABIENTE en los términos del FIDEICOMISO mediante el “LAY OUT KYC” diseñado por el FIDUCIARIO según dicho término se define en el propio FIDEICOMISO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Asimismo, PROMOTORÍA proporcionará al FIDUCIARIO los datos e información del EJECUTOR DE OBRA elegido por el DERECHOHABIENTE para realizar las obras de reparación o mejora de casa habitación y al cuál por virtud de instrucciones de PROMOTORÍA, el FIDUCIARIO pagará en los términos del FIDEICOMISO (“LAY OUT” PAGOS).</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>TERCERA. CONTRAPRESTACIÓN DE PROMOTORÍA.</vb> De conformidad con el CONTRATO DE PRESTACIÓN DE SERVICIOS celebrado por el(la) DERECHOHABIENTE con PROMOTORÍA, el FIDUCIARIO, previa instrucción que reciba de este último mediante el “LAY OUT” DE PAGOS, pagará a PROMOTORÍA, por concepto de contraprestación, una cantidad que no deberá exceder del 4.5% más IVA sobre el CONTRATO DE OBRA, y además le liquidará los gastos de administración citados en el apartado G la cláusula Quinta del FIDEICOMISO. En el entendido de que FIDUCIARIO no estará obligado a realizar el cálculo ni vigilar, estipular, establecer monto o cantidad alguna por este concepto, siendo que el obligado es PROMOTORÍA para instruir y calcular el pago por el monto o porcentaje correspondiente, en términos del FIDEICOMISO, así como del CONTRATO DE PRESTACION DE SERVICIOS.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CUARTA. FIDEICOMISARIOS SUSTITUTOS.</vb> En caso de fallecimiento del DERECHOHABIENTE, este designa como su fideicomisario sustituto a ___________________________________________ quien lo reemplazará en todos los derechos y obligaciones que le correspondan al DERECHOHABIENTE en el FIDEICOMISO. </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efecto de que FIDUCIARIO reconozca al fideicomisario substituto designado en esta cláusula, PROMOTORÍA deberá notificar al FIDUCIARIO sobre el fallecimiento del FIDEICOMISARIO anexando copia certificada del acta de defunción correspondiente, así como el LAY OUT KYC respecto del FIDEICOMISARIO SUBSTITUTO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>QUINTA. AVISOS.</vb> Los avisos y notificaciones que deba hacer el FIDUCIARIO a los FIDEICOMITENTES y/o a los FIDEICOMISARIOS, a través de PROMOTORÍA, así como el envío de la información financiera que corresponda en términos del FIDEICOMISO, se harán en los domicilios que a continuación se señalan. En caso de que hubiere algún cambio de estos, PROMOTORÍA deberá notificarlo por escrito al FIDUCIARIO y demás partes del FIDEICOMISO, señalando el nuevo domicilio y anexando el comprobante de domicilio correspondiente. En caso de omitirse esta notificación, los avisos, las notificaciones y los estados de cuenta, antes mencionados, realizados o remitidos al último domicilio designado, surtirán plenamente sus efectos legales y liberarán al FIDUCIARIO de cualquier responsabilidad.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>LAS PARTES en este contrato, designan para los efectos legales correspondientes, los siguientes domicilios:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PROMOTORÍA y DERECHOHABIENTE.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIDUCIARIO:</vb> Paseo de la Reforma 243, piso 20, Colonia Cuauhtémoc, Delegación Cuauhtémoc, C.P. 06500, Ciudad de México.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(0);

$txt="<p>Teléfonos 5625-1628</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEXTA.  DURACIÓN. -</vb> El presente convenio tendrá la duración necesaria para el cumplimiento de sus fines y se extinguirá por cualquiera de las causas establecidas en el artículo 392 de la Ley General de Títulos y Operaciones de Crédito, que sean compatibles con la naturaleza de este contrato, a excepción de lo previsto en la fracción VI del citado artículo, toda vez que los FIDEICOMITENTES y FIDEICOMISARIOS no se reservan el derecho a revocarlo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2); 

$txt="<p>Asimismo, el presente Convenio de Adhesión podrá darse por terminado según lo establecido en la cláusula Vigésima Primera del Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SÉPTIMA. JURISDICCIÓN Y COMPETENCIA.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para todo lo relacionado de este contrato las partes se someten a la jurisdicción de los tribunales competentes de la Ciudad de México, y renuncian expresamente al fuero territorial distinto que por cualquier causa pudiere corresponderles en razón de sus domicilios presentes o futuros.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El presente Convenio se firma en CIUDAD DE MEXICO a los 6 días del mes de 9 de 2018.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$pdf->SetFont('','B');
$pdf->Cell(85,$es,$unombre,0,0,"J");
$pdf->Cell(85,$es,"DANIEL GODOY CONTRERAS",0,1,"J");
$pdf->Ln(2);

$pdf->Cell(85,$es,"DERECHOHABIENTE EN SU",0,0,"J");
$pdf->Cell(85,$es,"PROMOTORÍA",0,1,"J");
$pdf->Cell(85,$es,"CARÁCTER	DE FIDEICOMITENTE",0,0,"J");
$pdf->Cell(85,$es,"FIDEICOMITENTE Y FIDEICOMISARIO",0,1,"J");
$pdf->Cell(85,$es,"ADHERENTE Y/O FIDEICOMISARIO",0,0,"J");
$pdf->Cell(85,$es,"EN SEGUNDO LUGAR",0,1,"J");
$pdf->Cell(85,$es,"EN PRIMER LUGAR",0,1,"J");
$pdf->Ln(20);

$pdf->Cell(1,$es,"",0,0,"J");
$pdf->Cell(50,$es,"",'T',0,"J");
$pdf->Cell(35,$es,"",0,0,"J");
$pdf->Cell(50,$es,"",'T',1,"J");

$txt="<p><vb>FIDUCIARIO</vb></p>";
$pdf->WriteTag(180,$es,$txt,0,"C");
$pdf->Ln(20);

$pdf->SetFont('','B');
$pdf->Cell(1,$es,"",0,0,"J");
$pdf->Cell(50,$es,"",'T',0,"J");
$pdf->Cell(35,$es,"",0,0,"J");
$pdf->Cell(50,$es,"",'T',1,"J");

$pdf->Cell(85,$es,"SALVADOR DE LA LLATA MERCADO",0,0,"J");
$pdf->Cell(85,$es,"MIRIAM GAMERO ESPINOSA",0,1,"J");
$pdf->Cell(85,$es,"DELEGADO FIDUCIARIO",0,0,"J");
$pdf->Cell(85,$es,"DELEGADO FIDUCIARIO",0,1,"J");

$pdf->Output();
?>
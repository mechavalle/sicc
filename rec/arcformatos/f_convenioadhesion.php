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


$txt="<p><vb>CONVENIO DE ADHESI�N AL CONTRATO DE FIDEICOMISO IRREVOCABLE N�MERO �437� (EL �FIDEICOMISO�) QUE CELEBRAN POR UNA PARTE, ".$unombre.", DERECHOHABIENTE ACREDITADO POR EL INFONAVIT  EN SU CAR�CTER DE FIDEICOMITENTE ADHERENTE Y/O FIDEICOMISARIO EN PRIMER LUGAR (EL DERECHOHABIENTE); �PROMOTORA ASOCIADOS ESTA ES TU CASA� S.A. DE C.V., REPRESENTADO EN ESTE ACTO POR DANIELA GODOY CONTRERAS, COMO FIDEICOMITENTE Y FIDEICOMISARIO EN SEGUNDO LUGAR  Y BANCO VE POR M�S, SOCIEDAD AN�NIMA, INSTITUCI�N DE BANCA M�LTIPLE, GRUPO FINANCIERO VE POR M�S, ACTUANDO �NICA Y EXCLUSIVAMENTE COMO FIDUCIARIO DEL FIDEICOMISO IRREVOCABLE DE ADMINISTRACI�N E INVERSI�N N�MERO 437 (EL �FIDUCIARIO�), REPRESENTADO EN ESTE ACTO POR SUS DELEGADOS FIDUCIARIOS LICENCIADOS SALVADOR DE LA LLATA MERCADO Y MIRIAM GAMERO ESPINOSA, DE CONFORMIDAD CON LO ESTABLECIDO EN LAS SIGUIENTES ANTECEDENTES, DECLARACIONES Y CL�USULAS:</vb></p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$pdf->Cell(180,$es,"A N T E C E D E N T E S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    CONTRATO MAESTRO DE COLABORACI�N. �</vb> �PROMOTORA ASOCIADOS ESTA ES TU CASA� S.A. DE C.V. y el INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES (INFONAVIT) han suscrito un Contrato Maestro de Colaboraci�n para su incorporaci�n al Programa de Apoyo de L�nea Cuatro. En virtud del mismo, el Administrador presta servicios de: A) asesor�a en la solicitud del cr�dito l�nea IV de acuerdo a la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores (CR�DITO INFONAVIT) para la reparaci�n o mejora de habitaciones, sin afectaci�n estructural y sin garant�a hipotecaria; y B) administraci�n y aplicaci�n de los recursos de dicho cr�dito a trav�s de un fideicomiso de administraci�n de pago.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    CONTRATO DE FIDEICOMISO. </vb>PROMOTOR�A  y el FIDUCIARIO han suscrito el contrato de fideicomiso n�mero 437 (el FIDEICOMISO) con el fin de que los trabajadores o derechohabientes del INFONAVIT que as� lo eligieran, a trav�s del propio INFONAVIT, aportaran los recursos derivados de los CR�DITOS INFONAVIT, para que el FIDUCIARIO los administre y realice los pagos pertinentes durante el proyecto de reparaci�n, o mejora correspondiente, cuya copia que se adjunta al presente bajo la letra �A� para formar parte integral de este convenio.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    CONTRATO DE PRESTACI�N DE SERVICIOS. </vb>El DERECHOHABIENTE y PROMOTOR�A tienen celebrado un contrato para la prestaci�n de los servicios descritos en el antecedente I anterior.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>IV.    CR�DITO INFONAVIT. </vb>El INFONAVIT le autoriz� al DERECHOHABIENTE un CR�DITO INFONAVIT para la reparaci�n o mejora de casa habitaci�n sobre vivienda de conformidad con el art�culo 42 fracci�n II apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores por un monto equivalente a $montopresupuesto</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>V.    ADHESI�N. </vb>El DERECHOHABIENTE desea adherirse al FIDEICOMISO citado en el antecedente II, mismo que conoce en todos sus t�rminos y desea aportar al patrimonio de dicho FIDEICOMISO el CR�DITO INFONAVIT citado en el inciso anterior, para pagarle al ejecutor de obra (el EJECUTOR DE OBRA) por los trabajos en el inmueble conforme al contrato de obra respectivo.</p>";
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

$txt="<p>Con la celebraci�n de este contrato no viola convenio, licencia, sentencia u orden con que est�n vinculados, ni autorizaci�n, ley, reglamento, circular o decreto alguno a que est�n sujetos o les sea aplicable.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Al celebrar el CONVENIO DE ADHESI�N adquirir� y asumir� los derechos y obligaciones que, como FIDEICOMITENTE y FIDEICOMISARIO EN PRIMER LUGAR, constan en el Contrato de FIDEICOMISO citado en los antecedentes del presente convenio.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Con la celebraci�n del presente CONVENIO DE ADHESI�N est� conforme y acepta plenamente que el INFONAVIT transfiera en su totalidad esos fondos directamente al FIDEICOMISO.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Con anterioridad a la firma del presente CONVENIO DE ADHESI�N, el FIDUCIARIO le invit� y sugiri� obtener del profesionista, despacho, o firma de su elecci�n, la asesor�a y apoyo en cuanto al alcance, consecuencias, tr�mites, implicaciones y en general cuestiones legales y fiscales directa o indirectamente relacionadas con el presente FIDEICOMISO, as� como su apoyo en la negociaci�n y evaluaci�n del riesgo legal y fiscal del texto definitivo a firmarse. Lo anterior ya que el FIDUCIARIO no se hace responsable de tales cuestiones, por lo que el FIDUCIARIO no garantiza ni asegura que la estructura fiscal contenida en el FIDEICOMISO definitivo no sea alterada con subsecuentes modificaciones a la legislaci�n fiscal y los impactos fiscales e impositivos puedan modificarse. Por lo que manifiesta conocer el FIDEICOMISO, as� como los dem�s contratos y convenios que lo componen.</p>";
$pdf->Cell(10,$es,"E.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Los bienes y/o derechos que se afectan para los fines del FIDEICOMISO son de procedencia l�cita, producto de actividades realizadas dentro del marco de la ley y que no existe conexi�n alguna entre el origen, procedencia o destino de los bienes afectos al FIDEICOMISO o los productos que tales generen y actividades il�citas o de apoyo a grupos terroristas. Asimismo, se obliga a proporcionar, a trav�s de PROMOTOR�A en t�rminos del presente Convenio de Adhesi�n y del FIDEICOMISO, al FIDUCIARIO cualquier informaci�n que le sea requerida por �ste a efecto de dar cumplimiento con lo establecido en el art�culo 212 de la Ley del Mercado de Valores y dem�s disposiciones reglamentarias y pol�ticas institucionales a las que se encuentra sujeta el FIDUCIARIO.</p>";
$pdf->Cell(10,$es,"F.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>De conformidad con lo establecido en la Ley de Protecci�n de Datos Personales, declara que previo al otorgamiento de sus datos personales, el FIDUCIARIO le explic� y entreg� el Aviso de Privacidad de Datos Personales.</p>";
$pdf->Cell(10,$es,"G.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>El FIDUCIARIO le ha hecho saber inequ�vocamente el contenido del art�culo 186  de la Ley del Mercado de Valores y el texto aplicable de la Circular 1/2005 y las modificaciones a dicha Circular emitidas por el Banco de M�xico, respecto a las prohibiciones que la limitan en t�rminos de ley y de las disposiciones vigentes, cuyo contenido se reprodujo en el FIDEICOMISO.</p>";
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

$txt="<p>Celebra el presente convenio en t�rminos del FIDEICOMISO con el objeto de cumplir con los fines del mismo, principalmente para que el FIDEICOMISO reciba los recursos del DERECHOHABIENTE provenientes del Cr�ditos L�nea Cuatro para destinarlos a la realizaci�n de las obras de reparaci�n o mejora de conformidad con las instrucciones que, para el efecto reciba de PROMOTOR�A, como prestador de servicios y autorizado por el DERECHOHABIENTE para ello, sin que el FIDUCIARIO adquiera ninguna relaci�n con el contratista, ni obligaci�n de supervisi�n de obra.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ha hecho saber inequ�vocamente a las Partes del presente convenio el contenido en la disposici�n B) de la fracci�n XIX (diecinueve romano), del art�culo 106 de la Ley de Instituciones de cr�dito vigente, cuyo contenido se reprodujo en el Fideicomiso.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    Declara PROMOTOR�A como FIDEICOMISARIO EN SEGUNDO LUGAR, por conducto de su representante que:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Es una sociedad debidamente constituida y v�lidamente existente de conformidad con las leyes de la Rep�blica Mexicana, seg�n consta en la Escritura P�blica No. 77872 de fecha 18 de MARZO de 2010 otorgada ante la fe del Notario P�blico No. 52 del DISTRITO FEDERAL  Lic. LIC. PROTACIO GUERRA RAMIRO, la cual qued� debidamente inscrita en el Registro P�blico de Comercio de la Ciudad de M�xico bajo el folio mercantil electr�nico No. 417954 el 14 de junio 2010.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>La personalidad con la que se ostenta su representante legal no le ha sido revocada, ni en forma alguna modificada o limitada.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>El FIDUCIARIO le ha hecho saber inequ�vocamente el contenido y alcance del art�culo 115 de la Ley de Instituciones de Cr�dito as� como diversas prohibiciones aplicables al FIDUCIARIO contenidas en distintas leyes y circulares yal como lo establece la circular 1/2005 del banco de M�xico y circular 1/2005 BIS cuyo contenido se reprodujo en el FIDEICOMISO.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Derivado de lo anterior, las partes acuerdan someterse a los t�rminos y condiciones establecidos en las siguientes:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->Cell(180,$es,"C  L  �  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);


$txt="<p><vb>PRIMERA. - OBJETO.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El DERECHOHABIENTE por medio del presente instrumento acepta y est� conforme con adherirse y formar parte del FIDEICOMISO n�mero 437 citado en el antecedente II del presente convenio. Por lo tanto, el DERECHOHABIENTE o tambi�n llamado FIDEICOMITENTE ADHERENTE Y FIDEICOMISARIO EN PRIMER LUGAR se obliga en t�rminos del Contrato de FIDEICOMISO citado y gozar� de los derechos conferidos por dicho acuerdo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para mayor comprensi�n, algunos de los t�rminos definidos utilizados en este CONVENIO DE ADHESI�N tendr�n el mismo significado que los contenidos en el contrato de FIDEICOMISO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El DERECHOHABIENTE en este acto y en t�rminos del FIDEICOMISO cede a favor del mismo todos los derechos de las FIANZAS y est� de acuerdo en que el FIDEICOMISO sea el �nico beneficiario de las mismas; en especial, para ejercer los derechos de cobro y ejecuci�n de las FIANZAS en t�rminos del FIDEICOMISO y dem�s contratos relacionados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En virtud de lo anterior, el  DERECHOHABIENTE directamente o a trav�s del INFONAVIT, se obliga a  depositar en el FIDEICOMISO en la cuenta n�mero <vb>242773 con CLABE interbancaria 113180000002427731 a nombre de BANCO VE POR M�S, S.A., FIDEICOMISO 437 del Banco Ve por M�s, S.A.</vb>, en un t�rmino no mayor a los 2 (Dos) d�as h�biles siguientes contados a partir de  la firma del presente Convenio,  la totalidad de la cantidad del CR�DITO INFONAVIT a que se refiere el numeral IV de los antecedentes del presente convenio con la debida notificaci�n por parte de PROMOTOR�A sobre la transferencia realizada, para ser destinada a los fines encomendados al FIDUCIARIO en el FIDEICOMISO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEGUNDA. INFORMACI�N.</vb> PROMOTOR�A deber� proporcionar al FIDUCIARIO los datos e informaci�n requerida del DERECHOHABIENTE en los t�rminos del FIDEICOMISO mediante el �LAY OUT KYC� dise�ado por el FIDUCIARIO seg�n dicho t�rmino se define en el propio FIDEICOMISO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Asimismo, PROMOTOR�A proporcionar� al FIDUCIARIO los datos e informaci�n del EJECUTOR DE OBRA elegido por el DERECHOHABIENTE para realizar las obras de reparaci�n o mejora de casa habitaci�n y al cu�l por virtud de instrucciones de PROMOTOR�A, el FIDUCIARIO pagar� en los t�rminos del FIDEICOMISO (�LAY OUT� PAGOS).</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>TERCERA. CONTRAPRESTACI�N DE PROMOTOR�A.</vb> De conformidad con el CONTRATO DE PRESTACI�N DE SERVICIOS celebrado por el(la) DERECHOHABIENTE con PROMOTOR�A, el FIDUCIARIO, previa instrucci�n que reciba de este �ltimo mediante el �LAY OUT� DE PAGOS, pagar� a PROMOTOR�A, por concepto de contraprestaci�n, una cantidad que no deber� exceder del 4.5% m�s IVA sobre el CONTRATO DE OBRA, y adem�s le liquidar� los gastos de administraci�n citados en el apartado G la cl�usula Quinta del FIDEICOMISO. En el entendido de que FIDUCIARIO no estar� obligado a realizar el c�lculo ni vigilar, estipular, establecer monto o cantidad alguna por este concepto, siendo que el obligado es PROMOTOR�A para instruir y calcular el pago por el monto o porcentaje correspondiente, en t�rminos del FIDEICOMISO, as� como del CONTRATO DE PRESTACION DE SERVICIOS.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CUARTA. FIDEICOMISARIOS SUSTITUTOS.</vb> En caso de fallecimiento del DERECHOHABIENTE, este designa como su fideicomisario sustituto a ___________________________________________ quien lo reemplazar� en todos los derechos y obligaciones que le correspondan al DERECHOHABIENTE en el FIDEICOMISO. </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efecto de que FIDUCIARIO reconozca al fideicomisario substituto designado en esta cl�usula, PROMOTOR�A deber� notificar al FIDUCIARIO sobre el fallecimiento del FIDEICOMISARIO anexando copia certificada del acta de defunci�n correspondiente, as� como el LAY OUT KYC respecto del FIDEICOMISARIO SUBSTITUTO.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>QUINTA. AVISOS.</vb> Los avisos y notificaciones que deba hacer el FIDUCIARIO a los FIDEICOMITENTES y/o a los FIDEICOMISARIOS, a trav�s de PROMOTOR�A, as� como el env�o de la informaci�n financiera que corresponda en t�rminos del FIDEICOMISO, se har�n en los domicilios que a continuaci�n se se�alan. En caso de que hubiere alg�n cambio de estos, PROMOTOR�A deber� notificarlo por escrito al FIDUCIARIO y dem�s partes del FIDEICOMISO, se�alando el nuevo domicilio y anexando el comprobante de domicilio correspondiente. En caso de omitirse esta notificaci�n, los avisos, las notificaciones y los estados de cuenta, antes mencionados, realizados o remitidos al �ltimo domicilio designado, surtir�n plenamente sus efectos legales y liberar�n al FIDUCIARIO de cualquier responsabilidad.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>LAS PARTES en este contrato, designan para los efectos legales correspondientes, los siguientes domicilios:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>PROMOTOR�A y DERECHOHABIENTE.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>FIDUCIARIO:</vb> Paseo de la Reforma 243, piso 20, Colonia Cuauht�moc, Delegaci�n Cuauht�moc, C.P. 06500, Ciudad de M�xico.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(0);

$txt="<p>Tel�fonos 5625-1628</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEXTA.  DURACI�N. -</vb> El presente convenio tendr� la duraci�n necesaria para el cumplimiento de sus fines y se extinguir� por cualquiera de las causas establecidas en el art�culo 392 de la Ley General de T�tulos y Operaciones de Cr�dito, que sean compatibles con la naturaleza de este contrato, a excepci�n de lo previsto en la fracci�n VI del citado art�culo, toda vez que los FIDEICOMITENTES y FIDEICOMISARIOS no se reservan el derecho a revocarlo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2); 

$txt="<p>Asimismo, el presente Convenio de Adhesi�n podr� darse por terminado seg�n lo establecido en la cl�usula Vig�sima Primera del Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>S�PTIMA. JURISDICCI�N Y COMPETENCIA.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para todo lo relacionado de este contrato las partes se someten a la jurisdicci�n de los tribunales competentes de la Ciudad de M�xico, y renuncian expresamente al fuero territorial distinto que por cualquier causa pudiere corresponderles en raz�n de sus domicilios presentes o futuros.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El presente Convenio se firma en CIUDAD DE MEXICO a los 6 d�as del mes de 9 de 2018.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$pdf->SetFont('','B');
$pdf->Cell(85,$es,$unombre,0,0,"J");
$pdf->Cell(85,$es,"DANIEL GODOY CONTRERAS",0,1,"J");
$pdf->Ln(2);

$pdf->Cell(85,$es,"DERECHOHABIENTE EN SU",0,0,"J");
$pdf->Cell(85,$es,"PROMOTOR�A",0,1,"J");
$pdf->Cell(85,$es,"CAR�CTER	DE FIDEICOMITENTE",0,0,"J");
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
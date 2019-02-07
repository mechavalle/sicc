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


$txt="<p><vb>CONTRATO DE PRESTACIÓN DE SERVICIOS QUE CELEBRAN PROMOTORÍA ASOCIADOS ESTA ES TU CASA S.A. DE C.V. REPRESENTADA EN ESTE ACTO POR DANIELA GODOY CONTRERAS Y ".$unombre." POR SU PROPIO DERECHO,  AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:</vb></p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"D  E  C  L  A  R  A  C  I  O  N  E  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    EL ADMINISTRADOR DECLARA, POR CONDUCTO DE SU REPRESENTANTE LEGAL: </vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Que su representada es una sociedad debidamente constituida y válidamente existente de conformidad con las leyes de la República Mexicana.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que la personalidad con la que se ostenta su representante legal no le ha sido revocada, ni en forma alguna modificada.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que cuenta la experiencia y conocimiento para cumplir con el objeto de este Contrato.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Señala su domicilio para todos los efectos de este Contrato, el ubicado en: SUR 8 D 68, AGRICOLA ORIENTAL, IZTACALCO, CIUDAD DE MEXICO, C.P. 08500</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    EL DERECHOHABIENTE DECLARA, POR SU PROPIO DERECHO:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Ser mexicano(a)  en pleno uso de sus facultades y con capacidad para obligarse conforme al presente instrumento.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ser propietario del inmueble marcado con:  SUR 8 D 68, AGRÍCOLA ORIENTAL, IZTACALCO, CIUDAD DE MÉXICO, C.P. 08500</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ser Soltero.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que es su intención solicitar al Instituto del Fondo Nacional de la Vivienda para los Trabajadores (Infonavit) un Crédito Infonavit para la reparación o mejora de habitación en el inmueble referido en el párrafo B anterior, de conformidad con el artículo 42 fracción II, apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que desea contratar los servicios del Administrador a fin de que, entre otros, este lo asesore en la integración y presentación de la solicitud para el Crédito Infonavit,  en caso de obtenerlo, administre los fondos del Crédito Infonavit a través de un fideicomiso de administración y fuente de pago, y en su caso, ejecute la Obra.</p>";
$pdf->Cell(10,$es,"E.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Designa como su domicilo el descrito en el inciso B anterior.</p>";
$pdf->Cell(10,$es,"F.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>En virtud de las declaraciones de ambas partes, éstas convienen en obligarse de acuerdo con las siguientes:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"C  L  Á  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>PRIMERA. 	DEFINICIONES.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectos de este contrato, las siguientes definiciones tendrán los siguientes significados:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>A. Convenio de Adhesión.</vb> Es el instrumento firmado por el Derechohabiente, conjuntamente con el Administrador y el Fiduciario; en virtud del cual el Derechohabiente se adhiere al Fideicomiso y adquiere los derechos y obligaciones señalados en ese instrumento.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>B. Cotización de la Obra.</vb> Es la propuesta económica del Ejecutor de la Obra que resulta de multiplicar unidades de material requerido con determinadas especificaciones de calidad y funcionalidad para ejecutar una obra en el área designada por el Derechohabiente en el inmueble, por el precio unitario de ese material.  La Cotización de la Obra también incluirá los costos directos e indirectos de la Obra costos de mano de obra del, equipos, insumos, costos de almacenaje, así como la utilidad de la Obra. La Cotización de Obra se adjunta al presente instrumento como Anexo A, el cual está firmado por las Partes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>C. Créditos Infonavit.</vb> Significan los créditos otorgados por el Infonavit a los Derechohabientes para que éstos los destinen a la reparación o mejoras de habitación, de conformidad con el artículo 42 fracción II de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>D. Derechohabiente o Acreditado.</vb> Significa cada uno de los derechohabientes del Infonavit acreditados bajo los Créditos Infonavit, el cual será celebra este Contrato de Prestación de Servicios con el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>E. Ejecutor de la Obra.</vb> Significa el Administrador o el Constructor independiente que realiza los trabajos de la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>F. Fianza.</vb> Significa la garantía de cumplimiento, calidad y vicios ocultos de las Obras otorgadas por compañías afianzadoras, autorizadas por la Secretaria de Hacienda y Crédito Público, y contratadas por el Ejecutor de la Obra, respecto al Contrato con el Infonavit y del Contrato de Prestación de Servicios celebrado con los Derechohabientes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>G. Fideicomiso.</vb> Es el contrato de fideicomiso celebrado entre la institución financiera que se desempeñe como fiduciario y el Administrador para administrar los fondos procedentes de los Créditos Infonavit, y al cual se adherirán los derechohabientes con el fin de que los fondos del Crédito Infonavit sean aportados por este a nombre y cuenta de cada derechohabiente al Fideicomiso y aplicados a la reparación o mejora de la casa habitación en cuestión de conformidad con el artículo 42 fracción II apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores, de este Contrato y del Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>H. Inmueble.</vb> Es la vivienda del Derechohabiente en la cual se realizará la aplicación de los recursos del Crédito Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>I. Obra.</vb> Es la reparación o mejora en un área determinada del Inmueble, a la cual se pretende aplicar el Crédito Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>J. Planos.</vb> Significa el documento que contiene la descripción Inmueble y detalla el área en la que se realizarán las modificaciones por parte del Ejecutor de la Obra. Los Planos incluirán entre otra información, las medidas, volumen y dimensiones del área del Inmueble en el que se ejecutará la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>K. Programa de Trabajo.</vb> Es la descripción ordenada de actividades que el Ejecutor de la Obra debe llevar a cabo en el inmueble en un periodo de tiempo determinado y que incluye la aplicación de la Cotización de la Obra en las Planos, plazas de ejecución de los trabajos y demás elementos necesarios para la ejecución de la Obra en el Inmueble.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>SEGUNDA. OBJETO DEL CONTRATO.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En virtud de este Contrato, el Administrador se obliga a i) dar el acompañamiento a los Derechohabientes en la solicitud de crédito y obtención del Crédito Infonavit, ii) administrar y aplicar los recursos provenientes de los Crédito Infonavit a la ejecución de la Obra, mediante el Fidecomiso de administración y pago; iii) en su caso, ejecutar directamente la realización de la Obra o lo haga un constructor independiente, y iv) celebrar los Convenios de Adhesión con el Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>TERCERA. OBLIGACIONES DEL ADMINISTRADOR.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A. En cumplimiento con la Ley de Protección de Datos Personales en Posesión de los Particulares, el Administrador, en este acto entrega al Derechohabiente, como Anexo B, el Aviso de Privacidad.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B. El Administrador asesorará al Derechohabiente y le dará acompañamiento durante el procedimiento de solicitud del Crédito Infonavit. Esta asesoría podrá realizarse a través del Administrador o en su caso, de la empresa integradora de expedientes que subcontrate aquél.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C. El Administrador apoyará al Derechohabiente para que la verificación inicial y la verificación final se realicen de acuerdo con los términos establecidos por el Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D. En caso de que el Infonavit otorgue dicho el Crédito Infonavit, el Derechohabiente autorizará al Infonavit para que los recursos de dicho crédito sean depositado en el Fideicomiso, previa firma del Convenio de Adhesión respectivo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E. El Administrador, en su calidad de Fideicomitente, realizará la administración de los fondos derivados del Crédito Infonavit para que se apliquen a la ejecución de la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>No obstante lo anterior, el Administrador no será responsable por la negativa del Fiduciario para celebrar el Convenio de Adhesión con el Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>F. El Administrador tendrá la obligación de vigilar que el Ejecutor de la Obra inicie y termine los trabajos para la Obra de acuerdo a lo pactado en el Contrato de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>G. El Administrador deberá cerciorarse de que la Ejecución de la Obra esté garantizada mediante la Fianza correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>H. El Administrador deberá instruir al Fiduciario, previa autorización firmada por el Derechohabiente, el pago del anticipo convenido y los pagos correspondientes al Ejecutor de Obra por los trabajos de ejecución de Obra y administración de la misma, según sea aplicable, los cuales siempre serán autorizados por Derechohabiente respecto a las partidas contenidas en la Cotización de Obra adjunta como Anexo A de este instrumento. Una vez realizadas todas esas ministraciones, el Administrador dará aviso al Derechohabiente para que éste proceda conforme a los apartados B y C de la Cláusula Cuarta siguiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>I. En caso de que exista una controversia o diferendo en la ejecución o calidad de la Obra respecto de los cuales las partes no hayan podido llegar a un acuerdo, el Administrador hará las gestiones para la aplicación de la Fianza de Cumplimiento o de Calidad.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>CUARTA. OBLIGACIONES DEL DERECHOHABIENTE.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A. El Derechohabiente deberá autorizar las solicitudes de pagos presentadas por el Ejecutor de la Obra conforme a los procedimientos del Administrador con base en los trabajos efectivamente realizados conforme a la Cotización de Obra. Esas autorizaciones dejarán constancia de que los trabajos fueron aplicados en el Inmueble.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B. Para efectuar la entrega final de la Obra, el Ejecutor de la Obra dará aviso por escrito al Derechohabiente a fin de que ambas partes suscriban el acta entrega recepción de la Obra, en la que conste la conclusión de los trabajos contratados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C. Posteriormente, el Derechohabiente solicitará al número telefónico indicado por el Infonavit la programación y realización de la visita de verificación final de la Obra con la empresa verificadora, registrada ante el Infonavit respecto a la aplicación de los recursos, para tales efectos el se obliga a dar facilidades al Infonavit para esa verificación.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D. El Derechohabiente, deberá realizar el pago de la verificación inicial y verificación final con recursos de su propio peculio.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E. El Derechohabiente se abstendrá de realizar cualquier acto u acción que impida al Ejecutor de la Obra la ejecución de la misma de acuerdo a lo convenido.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>F. El Derechohabiente cede expresamente a favor del Fideicomiso los derechos derivados de las Fianzas otorgadas para garantizar el cumplimiento la ejecución de la Obra, y la calidad de la misma.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>QUINTA. PROCEDIMIENTO OPERATIVO.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las Partes reconocen que el detalle de la prestación de los servicios pactados en este Contrato y las obligaciones en particular están previstas en el Anexo C de este instrumento.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>SEXTA. CONTRAPRESTACIÓN.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente pagará a El Administrador por la prestación de los servicios previstos en este Contrato de Prestación de Servicios una comisión de 4.5% (cuatro punto cinco por ciento) más IVA sobre el monto total del Crédito Infonavit otorgado al mismo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El pago de la comisión será realizado con cargo al Crédito Infonavit obtenido por el Derechohabiente, en una sola exhibición, para tales efectos el Derechohabiente instruirá al Fideicomiso que realice la dispersión correspondiente a la cuenta de El Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>SÉPTIMA. CONFIDENCIALIDAD.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las partes acuerdan que toda información comunicada entre las partes, que sea marcada como información confidencial ya sea antes o después de la celebración del presente contrato, se considerará que ha sido recibida con tal carácter y se utilizarán únicamente para los fines relacionados con el presente Contrato. Ambas partes deberán aplicar las mismas medidas, pero en todo caso medidas razonables, que utiliza para proteger su propia información confidencial.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Lo anterior no se entenderá como una prohibición para que ninguna de las partes divulgue información que le pertenezca o:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que haya conocido sin obligación de confidencialidad;</p>";
$pdf->Cell(10,$es,"1)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que sea públicamente conocida;</p>";
$pdf->Cell(10,$es,"2)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que sea recibida de un tercero;</p>";
$pdf->Cell(10,$es,"3)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que sea entregada por el Derechohabientea una tercera parte sin restricciones similares; o</p>";
$pdf->Cell(10,$es,"4)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que deba ser divulgada por un requerimiento legal, gubernamental o judicial, siempre y cuando la parte requerida entregue a la parte propietaria de la información notificación de dicho requerimiento, previamente a su divulgación.</p>";
$pdf->Cell(10,$es,"5)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las obligaciones relativas a la información confidencial quedarán vigentes aún después de la terminación del presente contrato por un plazo de 3 años.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>OCTAVA. DURACIÓN, TERMINACIÓN  Y RESCISIÓN.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Duración</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A. El presente contrato estará vigente a partir de su firma y hasta que hayan vencidos los 3 (tres) meses correspondientes a la fianza de calidad respectiva.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Terminación</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B. Este Contrato podrá darse por terminado anticipadamente y en forma automática, sin necesidad de declaración judicial:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si el Infonavit niega el Crédito Infonavit y/o rechaza expedir la Constancia de Crédito.</p>";
$pdf->Cell(10,$es,"1)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si el Infonavit niega el Crédito Infonavit y/o rechaza hacer la transferencia directa de los fondos al Fideicomiso, o bien el Fiduciario del Fideicomiso se niega a celebrar el convenio de adhesión con el Derechohabiente.</p>";
$pdf->Cell(10,$es,"2)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si por cualquier causa, no se firma el contrato de crédito entre el Derechohabiente y el Infonavit. </p>";
$pdf->Cell(10,$es,"3)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Rescisión</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Este Contrato podrá rescindirse en caso de incumplimiento de cualquiera de las partes a las obligaciones de este Contrato, sin necesidad de resolución judicial o por caso fortuito o fuerza mayor. </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>NOVENA. - RESPONSABILIDAD LABORAL.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En virtud de que el Administrador es una sociedad con recursos suficientes para conducir sus negocios, el Administrador será el único responsable del cumplimiento de sus obligaciones para con sus empleados, trabajadores y agentes, toda vez que entre el Derechohabiente, el Fiduciario del Fideicomiso y los empleados, prestadores de servicios del Administrador no existirá relación laboral alguna ni de cualquier otra especie.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>DÉCIMA.  LEY APLICABLE Y SOLUCIÓN DE CONTROVERSIAS.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para todo lo relativo a la interpretación del presente subcontrato, las partes se someten a los tribunales competentes y leyes vigentes de la Ciudad de México, renunciando a cualquier otro fuero que por razón de sus domicilios presentes o futuros o por cualquier otra causa les pudiera corresponder.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Estando conformes ambas partes con el alcance y contenido de lo acordado mediante el presente contrato, lo firman por duplicado el día 31 DE 10 DE 18, quedando un ejemplar en poder de cada una de ellas.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(5);

$pdf->SetFont('','B');
$pdf->Cell(85,$es,$unombre,0,0,"C");
$pdf->Cell(85,$es,"DANIELA GODOY CONTRERAS",0,1,"C");
$pdf->Cell(85,$es,"DERECHOHABIENTE",0,0,"C");
$pdf->Cell(85,$es,"EL ADMINISTRADOR",0,1,"C");
$pdf->Ln(20);

$pdf->SetFont('','B');
$pdf->Cell(17.5,$es,"",0,0,"C");
$pdf->Cell(50,$es,"NOMBRE",'T',0,"C");
$pdf->Cell(35,$es,"",0,0,"C");
$pdf->Cell(50,$es,"REPRESENTANTE LEGAL",'T',1,"C");
$pdf->Ln(200);

$txt="<p><vb>ANEXO “B”</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(2);

$txt="<p><vb>AVISO DE PRIVACIDAD</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(3);

$txt="<p>De acuerdo con los artículos 15 y 16 de la ley federal de protección de Datos Personales en Posesión de Particulares, hago de su conocimiento que los datos recabados serán únicamente utilizados para ofrecer el servicio que usted ha solicitado.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Así mismo informarle que usted tiene derecho al acceso, cancelación u oposición de sus datos personales en cuanto usted lo decida. El medio en donde usted podrá ejercer estos derechos sería mediante una solicitud de “Derechos Arco”, esto se refiere a aquel derecho que tiene un titular de datos personales, para solicitar el acceso, rectificación, cancelación u oposición sobre el tratamiento de sus datos ante el Sujeto Obligado que esté en posesión de los mismos.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Es importante señalar, que para estar en posibilidad de rechazar una solicitud de Derechos Arco, el titular o representante legal deben acreditar su identidad o representación, respectivamente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Así como también es importante hacerle saber que, la empresa “PROMOTORIA ASOCIADOS ESTA ES TU CASA S.A DE C.V” con dirección en Barranca del Muerto Núm. 210, interior 100, Colonia Guadalupe Inn, delegación Álvaro Obregón, código postal 01020, es responsable tanto de recabar sus datos personales, del uso que se les dé a los mismos, así como de su protección.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Se establece que los Datos Personales constituyen información confidencial del Titular. Por tanto, el Responsable acuerda mantener todos y cada una de los Datos Personales en estricta confidencialidad y se obliga a no divulgar ni revelar los Datos Personales a personas distintas de las señaladas anteriormente sin contar con el previo consentimiento otorgado por escrito del Titular.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>La obligación de confidencialidad no será aplicable a: información que sea del dominio público, que sea pública o que obre en Fuentes de Acceso Público como dicho término se define en la Ley; información que resulte evidente, incluyendo para un técnico en la materia; información que previamente a su divulgación ya obre en poder del Responsable o de cualquiera de las personas a que se refiere el párrafo anterior o haya sido desarrollada independientemente por el Responsable o por dichas personas; o  información que deba ser divulgada por disposición legal, orden judicial o de autoridad competente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Con lo dicho anteriormente, hacemos de su conocimiento que ninguna otra persona, a menos que usted lo autorice, o solo por orden legal puede hacer uso de sus datos personales.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(200);

$txt="<p><vb>ANEXO “C”</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(2);

$txt="<p><vb>PROCEDIMIENTO OPERATIVO</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(3);

$txt="<p><vb>1º Promoción del Crédito Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador promoverá el Crédito Infonavit entre Derechohabientes potenciales. Para tal efecto, aquél podrá acudir a centros de trabajo cuyos empleados puedan ser sujetos de créditos de dicho instituto, particularmente del Crédito Infonavit. Una vez que el Administrador inicie la promoción en esos centros de trabajo, explicará al Derechohabiente potencial en qué consiste el Crédito Infonavit, su utilidad y los requisitos que debe cubrir para obtenerlo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que el Derechohabiente esté interesado, el Administrador le recabará los datos personales a dicho Derechohabiente (y le entregará el respectivo aviso de privacidad) y suscribirán el contrato de prestación de servicios correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador también podrá hacer otro tipo de promoción, sea por correo electrónico o en forma telefónica siempre y cuando tenga la autorización para hacerlo y la misma cumpla  con la normatividad en materia de datos personales.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>2° Viabilidad del Derechohabiente para obtener su Crédito Infonavit. Asesoría al mismo para esos propósitos.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador asesorará al Derechohabiente y verificará junto con éste la subcuenta del mismo en la página web del Infonavit u otro medio de consulta disponible para determinar si de acuerdo a la normatividad vigente, el Derechohabiente es sujeto de obtener un Crédito Infonavit; es decir, si el Derechohabiente precalifica para dicho crédito.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>3º Integración e ingreso del expediente de crédito al Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que el Derechohabiene sea sujeto de obtener del Crédito Infonavit, el Administrador asesorará al Derechohabiente en la integración de la solicitud del Crédito Infonavit, la cual cumplirá los requisitos establecidos por ese Instituto para esos fines, y acompañará los documentos requeridos por el mismo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Asimismo, dentro de esa asesoría, el Administrador explicará al Derechohabiente el procedimiento de adhesión al Fideicomiso y de la fianza de cumplimiento y calidad otorgada por el Ejecutor de Obra conforme al Contrato de Obra, con la finalidad de garantizar la correcta aplicación del Crédito Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador asistirá al Derechohabiente en la integración de la solicitud y el Derechohabiente deberá entregar al Administrador toda la documentación requerida para tal efecto. Sin embargo, el Administrador no será responsable por la negativa del Infonavit en el otorgamiento del crédito por cualquier causa.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>4° Presentación de Ejecutores de Obra afianzados.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador podrá sugerir al Derechohabiente a los Ejecutores de Obra afianzados para que ejecuten la Obra en el Inmueble. Lo anterior para que el Ejecutor de Obra acuda al Inmueble, revise el área en la que desea hacer la reparación o mejora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>5° Visita del Ejecutor de Obra al Inmueble.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Seleccionado el Ejecutor de Obra por el Derechohabiente, el Administrador coordinará la cita para que el Ejecutor de Obra acuda al Inmueble del Derechohabiente (en adelante la Visita). El Ejecutor de Obra revisará el área del Inmueble en la que el Derechohabiente desea realizar la Obra, y otros aspectos necesarios para ejecutar la reparación o mejora respectiva. Posteriormente, el Ejecutor de Obra elaborará la Cotización de la Obra mediante la cual sugerirá al Derechohabiente el tipo de trabajos que deban ejecutarse para lograr que en el área disponible en el Inmueble pueda ejecutarse la Obra, así como el material, que, a juicio del Ejecutor de Obra, debe emplearse y el costo de la ejecución de los mismo, sin que se exceda el monto del crédito precalificado en la página del Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>6° Cotización de Obra autorizada por el Derechohabiente.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Posteriormente, el Ejecutor de Obra enviará al Derechohabiente una Cotización de la Obra junto con el proyecto de esta última, y en su caso, los Planos y Programa de Trabajo. El Derechohabiente deberá revisar, aprobar o rechazar dichos documentos. El Administrador dará acompañamiento al Derechohabiente durante esta etapa.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>7° Acompañamiento para el Derechohabiente en la Verificación Inicial.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Cuando el Derechohabiente y el Ejecutor de Obra hayan acordado la Cotización de Obra definitiva, se entregará un original firmado por ambas partes al Administrador para que éste se lo haga llegar al Infonavit junto con los documentos necesarios para integrar el Expediente de Crédito Infonavit. El Infonavit asignará la Empresa Verificadora que realizará la verificación inicial al Inmueble respectivo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Dicha verificación se realizará en los plazos determinados entre la empresa verificadora y el Infonavit. Será responsabilidad del Administrador asistir al Derechohabiente durante el proceso de verificación inicial.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El objetivo de la visita es validar que los trabajos propuestos en la Cotización de Obra no se hayan ejecutado previamente en el Inmueble y así pueda otorgarse el Crédito Infonavit. En todo caso, será el Infonavit el cual, conforme a la normatividad aplicable, resolverá sobre el otorgamiento del Crédito Infonavit a favor del Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente será responsable directo del pago de esa verificación inicial en la cuenta bancaria de la empresa verificadora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>8° Inscripción del Crédito Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Ya que la Empresa Verificadora haya realizado la correspondiente visita de verificación inicial en el Inmueble y haya enviado el resultado directamente al Infonavit, y conforme a la normatividad del mismo, sea procedente el otorgamiento del Crédito Infonavit, éste inscribirá dicho crédito, generará los documentos correspondientes y otorgará el Crédito Infonavit al Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>9° Firma del Convenio de Adhesión. Transferencia del Crédito Infonavit al Fideicomiso. Confirmación de ministración de recursos a través del Fideicomiso.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente instruirá y autorizará al Infonavit para que el Crédito Infonavit sea depositado en la cuenta del Fideicomiso, previa firma por parte del Derechohabiente del Convenio de Adhesión al Fideicomiso. El fin principal del Fideicomiso es la administración del Crédito Infonavit para que se aplique a la Obra, incluyendo el pago directo al Ejecutor de Obra y el pago de la comisión al Administrador. La cantidad neta transferida ya incorporará los descuentos por gastos administrativos de Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Mediante este Convenio de Adhesión el Derechohabiente autorizará por escrito al Administrador para que instruya al Fideicomiso el pago del correspondiente anticipo al Ejecutor de Obra. Este iniciará y terminará los trabajos para la Obra de acuerdo a la fecha prevista en el Contrato de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>10° Suscripción del Contrato de Obra. Autorización de anticipo de Obra. Ejecución de la Obra y pago de avance de esta. Culminación de la Obra y acta de entrega de la misma.</vb<</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Transferido el Crédito Infonavit al Fideicomiso, el Derechohabiente suscribirá el Contrato de Obra con el Ejecutor de Obra. . 
El Administrador tendrá la obligación de vigilar que el Ejecutor de Obra cumpla con las fechas pactadas en el Contrato de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador deberá cerciorarse de que la Ejecución de la Obra esté garantizada mediante la Fianza correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador instruirá al Fideicomiso el pago a favor del Ejecutor de Obra conforme los avances de la misma en términos de la Cotización de Obra y al Contrato correspondiente, previa autorización por escrito del Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectuar la entrega final de la Obra, el Ejecutor de Obra dará aviso por escrito al Derechohabiente a fin de que ambas partes suscriban el acta entrega de la Obra, en la que conste la conclusión de los trabajos contratados. El Ejecutor de Obra entregará al Administrador una copia del  acta de entrega para que éste pueda dar el acompañamiento al Derechohabiente en la verificación final.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>11° Acompañamiento en la verificación final.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador solicitará al Infonavit la asignación de una Empresa Verificadora para que haga la verificación final de la Obra respecto a la aplicación del Crédito Infonavit en el Inmueble, y generará los reportres de la visita final y el dictamen de aplicación de recursos. El Derechohabiente dará las facilidades necesarias a dicha empresa para la realización de la verificación final.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Será responsabilidad del Administrador asistir al Derechohabiente durante el proceso de verificación final. El Derechohabiente será responsable del pago directo de esa verificación final en la cuenta bancaria de la empresa verificadora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>12º Entrega de reportes y dictamen de aplicación de recursos para solicitar aplicación del Saldo de la Subcuenta de Vivienda al Crédito Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador entregará directamente al Infonavit los reportes correspondientes a la conclusión de la Obra. Será responsabilidad de la empresa verificadora que realice la verificación final la generación y entrega al Infonavit del dictamen de aplicación de recursos para que el Infonavit aplique el Saldo de la Subcuenta de Vivienda del Derechohabiente al Crédito Infonavit y se tenga por concluida y terminada la Obra a cargo del Ejecutor de Obra bajo la supervisión del Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>13° Reclamo por el derechohabiente sobre la calidad de la Obra.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que el Derechohabiente decida tramitar la reclamación de la Fianza de Calidad y la Obra ya fue concluida, suscrita el acta de entrega y emitido el dictamen de la empresa verificadora; y la Obra presenta desperfectos o vicios ocultos y el Ejecutor de Obra no realiza las gestiones para reparar la Obra, el Administrador realizará los trámites de la reclamación de la fianza de calidad a fin de que ésta sea ejecutada y pagada. 
Dicha reclamación deberá ser solicitada y tramitada dentro del periodo contemplado en la Fianza de calidad, en caso de ser procedente los fondos serán depositados directamente al Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Output();
?>
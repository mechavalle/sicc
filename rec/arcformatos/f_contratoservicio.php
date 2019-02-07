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


$txt="<p><vb>CONTRATO DE PRESTACI�N DE SERVICIOS QUE CELEBRAN PROMOTOR�A ASOCIADOS ESTA ES TU CASA S.A. DE C.V. REPRESENTADA EN ESTE ACTO POR DANIELA GODOY CONTRERAS Y ".$unombre." POR SU PROPIO DERECHO,  AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CL�USULAS:</vb></p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"D  E  C  L  A  R  A  C  I  O  N  E  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    EL ADMINISTRADOR DECLARA, POR CONDUCTO DE SU REPRESENTANTE LEGAL: </vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Que su representada es una sociedad debidamente constituida y v�lidamente existente de conformidad con las leyes de la Rep�blica Mexicana.</p>";
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

$txt="<p>Se�ala su domicilio para todos los efectos de este Contrato, el ubicado en: SUR 8 D 68, AGRICOLA ORIENTAL, IZTACALCO, CIUDAD DE MEXICO, C.P. 08500</p>";
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

$txt="<p>Ser propietario del inmueble marcado con:  SUR 8 D 68, AGR�COLA ORIENTAL, IZTACALCO, CIUDAD DE M�XICO, C.P. 08500</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Ser Soltero.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que es su intenci�n solicitar al Instituto del Fondo Nacional de la Vivienda para los Trabajadores (Infonavit) un Cr�dito Infonavit para la reparaci�n o mejora de habitaci�n en el inmueble referido en el p�rrafo B anterior, de conformidad con el art�culo 42 fracci�n II, apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que desea contratar los servicios del Administrador a fin de que, entre otros, este lo asesore en la integraci�n y presentaci�n de la solicitud para el Cr�dito Infonavit,  en caso de obtenerlo, administre los fondos del Cr�dito Infonavit a trav�s de un fideicomiso de administraci�n y fuente de pago, y en su caso, ejecute la Obra.</p>";
$pdf->Cell(10,$es,"E.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Designa como su domicilo el descrito en el inciso B anterior.</p>";
$pdf->Cell(10,$es,"F.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>En virtud de las declaraciones de ambas partes, �stas convienen en obligarse de acuerdo con las siguientes:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(180,$es,"C  L  �  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>PRIMERA. 	DEFINICIONES.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectos de este contrato, las siguientes definiciones tendr�n los siguientes significados:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>A. Convenio de Adhesi�n.</vb> Es el instrumento firmado por el Derechohabiente, conjuntamente con el Administrador y el Fiduciario; en virtud del cual el Derechohabiente se adhiere al Fideicomiso y adquiere los derechos y obligaciones se�alados en ese instrumento.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>B. Cotizaci�n de la Obra.</vb> Es la propuesta econ�mica del Ejecutor de la Obra que resulta de multiplicar unidades de material requerido con determinadas especificaciones de calidad y funcionalidad para ejecutar una obra en el �rea designada por el Derechohabiente en el inmueble, por el precio unitario de ese material.  La Cotizaci�n de la Obra tambi�n incluir� los costos directos e indirectos de la Obra costos de mano de obra del, equipos, insumos, costos de almacenaje, as� como la utilidad de la Obra. La Cotizaci�n de Obra se adjunta al presente instrumento como Anexo A, el cual est� firmado por las Partes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>C. Cr�ditos Infonavit.</vb> Significan los cr�ditos otorgados por el Infonavit a los Derechohabientes para que �stos los destinen a la reparaci�n o mejoras de habitaci�n, de conformidad con el art�culo 42 fracci�n II de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>D. Derechohabiente o Acreditado.</vb> Significa cada uno de los derechohabientes del Infonavit acreditados bajo los Cr�ditos Infonavit, el cual ser� celebra este Contrato de Prestaci�n de Servicios con el Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>E. Ejecutor de la Obra.</vb> Significa el Administrador o el Constructor independiente que realiza los trabajos de la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>F. Fianza.</vb> Significa la garant�a de cumplimiento, calidad y vicios ocultos de las Obras otorgadas por compa��as afianzadoras, autorizadas por la Secretaria de Hacienda y Cr�dito P�blico, y contratadas por el Ejecutor de la Obra, respecto al Contrato con el Infonavit y del Contrato de Prestaci�n de Servicios celebrado con los Derechohabientes.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>G. Fideicomiso.</vb> Es el contrato de fideicomiso celebrado entre la instituci�n financiera que se desempe�e como fiduciario y el Administrador para administrar los fondos procedentes de los Cr�ditos Infonavit, y al cual se adherir�n los derechohabientes con el fin de que los fondos del Cr�dito Infonavit sean aportados por este a nombre y cuenta de cada derechohabiente al Fideicomiso y aplicados a la reparaci�n o mejora de la casa habitaci�n en cuesti�n de conformidad con el art�culo 42 fracci�n II apartado c) de la Ley del Instituto del Fondo Nacional de la Vivienda para los Trabajadores, de este Contrato y del Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>H. Inmueble.</vb> Es la vivienda del Derechohabiente en la cual se realizar� la aplicaci�n de los recursos del Cr�dito Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>I. Obra.</vb> Es la reparaci�n o mejora en un �rea determinada del Inmueble, a la cual se pretende aplicar el Cr�dito Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>J. Planos.</vb> Significa el documento que contiene la descripci�n Inmueble y detalla el �rea en la que se realizar�n las modificaciones por parte del Ejecutor de la Obra. Los Planos incluir�n entre otra informaci�n, las medidas, volumen y dimensiones del �rea del Inmueble en el que se ejecutar� la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>K. Programa de Trabajo.</vb> Es la descripci�n ordenada de actividades que el Ejecutor de la Obra debe llevar a cabo en el inmueble en un periodo de tiempo determinado y que incluye la aplicaci�n de la Cotizaci�n de la Obra en las Planos, plazas de ejecuci�n de los trabajos y dem�s elementos necesarios para la ejecuci�n de la Obra en el Inmueble.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>SEGUNDA. OBJETO DEL CONTRATO.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En virtud de este Contrato, el Administrador se obliga a i) dar el acompa�amiento a los Derechohabientes en la solicitud de cr�dito y obtenci�n del Cr�dito Infonavit, ii) administrar y aplicar los recursos provenientes de los Cr�dito Infonavit a la ejecuci�n de la Obra, mediante el Fidecomiso de administraci�n y pago; iii) en su caso, ejecutar directamente la realizaci�n de la Obra o lo haga un constructor independiente, y iv) celebrar los Convenios de Adhesi�n con el Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>TERCERA. OBLIGACIONES DEL ADMINISTRADOR.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A. En cumplimiento con la Ley de Protecci�n de Datos Personales en Posesi�n de los Particulares, el Administrador, en este acto entrega al Derechohabiente, como Anexo B, el Aviso de Privacidad.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B. El Administrador asesorar� al Derechohabiente y le dar� acompa�amiento durante el procedimiento de solicitud del Cr�dito Infonavit. Esta asesor�a podr� realizarse a trav�s del Administrador o en su caso, de la empresa integradora de expedientes que subcontrate aqu�l.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C. El Administrador apoyar� al Derechohabiente para que la verificaci�n inicial y la verificaci�n final se realicen de acuerdo con los t�rminos establecidos por el Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D. En caso de que el Infonavit otorgue dicho el Cr�dito Infonavit, el Derechohabiente autorizar� al Infonavit para que los recursos de dicho cr�dito sean depositado en el Fideicomiso, previa firma del Convenio de Adhesi�n respectivo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E. El Administrador, en su calidad de Fideicomitente, realizar� la administraci�n de los fondos derivados del Cr�dito Infonavit para que se apliquen a la ejecuci�n de la Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>No obstante lo anterior, el Administrador no ser� responsable por la negativa del Fiduciario para celebrar el Convenio de Adhesi�n con el Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>F. El Administrador tendr� la obligaci�n de vigilar que el Ejecutor de la Obra inicie y termine los trabajos para la Obra de acuerdo a lo pactado en el Contrato de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>G. El Administrador deber� cerciorarse de que la Ejecuci�n de la Obra est� garantizada mediante la Fianza correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>H. El Administrador deber� instruir al Fiduciario, previa autorizaci�n firmada por el Derechohabiente, el pago del anticipo convenido y los pagos correspondientes al Ejecutor de Obra por los trabajos de ejecuci�n de Obra y administraci�n de la misma, seg�n sea aplicable, los cuales siempre ser�n autorizados por Derechohabiente respecto a las partidas contenidas en la Cotizaci�n de Obra adjunta como Anexo A de este instrumento. Una vez realizadas todas esas ministraciones, el Administrador dar� aviso al Derechohabiente para que �ste proceda conforme a los apartados B y C de la Cl�usula Cuarta siguiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>I. En caso de que exista una controversia o diferendo en la ejecuci�n o calidad de la Obra respecto de los cuales las partes no hayan podido llegar a un acuerdo, el Administrador har� las gestiones para la aplicaci�n de la Fianza de Cumplimiento o de Calidad.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>CUARTA. OBLIGACIONES DEL DERECHOHABIENTE.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A. El Derechohabiente deber� autorizar las solicitudes de pagos presentadas por el Ejecutor de la Obra conforme a los procedimientos del Administrador con base en los trabajos efectivamente realizados conforme a la Cotizaci�n de Obra. Esas autorizaciones dejar�n constancia de que los trabajos fueron aplicados en el Inmueble.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B. Para efectuar la entrega final de la Obra, el Ejecutor de la Obra dar� aviso por escrito al Derechohabiente a fin de que ambas partes suscriban el acta entrega recepci�n de la Obra, en la que conste la conclusi�n de los trabajos contratados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>C. Posteriormente, el Derechohabiente solicitar� al n�mero telef�nico indicado por el Infonavit la programaci�n y realizaci�n de la visita de verificaci�n final de la Obra con la empresa verificadora, registrada ante el Infonavit respecto a la aplicaci�n de los recursos, para tales efectos el se obliga a dar facilidades al Infonavit para esa verificaci�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>D. El Derechohabiente, deber� realizar el pago de la verificaci�n inicial y verificaci�n final con recursos de su propio peculio.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>E. El Derechohabiente se abstendr� de realizar cualquier acto u acci�n que impida al Ejecutor de la Obra la ejecuci�n de la misma de acuerdo a lo convenido.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>F. El Derechohabiente cede expresamente a favor del Fideicomiso los derechos derivados de las Fianzas otorgadas para garantizar el cumplimiento la ejecuci�n de la Obra, y la calidad de la misma.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>QUINTA. PROCEDIMIENTO OPERATIVO.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las Partes reconocen que el detalle de la prestaci�n de los servicios pactados en este Contrato y las obligaciones en particular est�n previstas en el Anexo C de este instrumento.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>SEXTA. CONTRAPRESTACI�N.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente pagar� a El Administrador por la prestaci�n de los servicios previstos en este Contrato de Prestaci�n de Servicios una comisi�n de 4.5% (cuatro punto cinco por ciento) m�s IVA sobre el monto total del Cr�dito Infonavit otorgado al mismo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El pago de la comisi�n ser� realizado con cargo al Cr�dito Infonavit obtenido por el Derechohabiente, en una sola exhibici�n, para tales efectos el Derechohabiente instruir� al Fideicomiso que realice la dispersi�n correspondiente a la cuenta de El Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>S�PTIMA. CONFIDENCIALIDAD.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las partes acuerdan que toda informaci�n comunicada entre las partes, que sea marcada como informaci�n confidencial ya sea antes o despu�s de la celebraci�n del presente contrato, se considerar� que ha sido recibida con tal car�cter y se utilizar�n �nicamente para los fines relacionados con el presente Contrato. Ambas partes deber�n aplicar las mismas medidas, pero en todo caso medidas razonables, que utiliza para proteger su propia informaci�n confidencial.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Lo anterior no se entender� como una prohibici�n para que ninguna de las partes divulgue informaci�n que le pertenezca o:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que haya conocido sin obligaci�n de confidencialidad;</p>";
$pdf->Cell(10,$es,"1)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Que sea p�blicamente conocida;</p>";
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

$txt="<p>Que deba ser divulgada por un requerimiento legal, gubernamental o judicial, siempre y cuando la parte requerida entregue a la parte propietaria de la informaci�n notificaci�n de dicho requerimiento, previamente a su divulgaci�n.</p>";
$pdf->Cell(10,$es,"5)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Las obligaciones relativas a la informaci�n confidencial quedar�n vigentes a�n despu�s de la terminaci�n del presente contrato por un plazo de 3 a�os.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>OCTAVA. DURACI�N, TERMINACI�N  Y RESCISI�N.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Duraci�n</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>A. El presente contrato estar� vigente a partir de su firma y hasta que hayan vencidos los 3 (tres) meses correspondientes a la fianza de calidad respectiva.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Terminaci�n</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>B. Este Contrato podr� darse por terminado anticipadamente y en forma autom�tica, sin necesidad de declaraci�n judicial:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si el Infonavit niega el Cr�dito Infonavit y/o rechaza expedir la Constancia de Cr�dito.</p>";
$pdf->Cell(10,$es,"1)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si el Infonavit niega el Cr�dito Infonavit y/o rechaza hacer la transferencia directa de los fondos al Fideicomiso, o bien el Fiduciario del Fideicomiso se niega a celebrar el convenio de adhesi�n con el Derechohabiente.</p>";
$pdf->Cell(10,$es,"2)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Si por cualquier causa, no se firma el contrato de cr�dito entre el Derechohabiente y el Infonavit. </p>";
$pdf->Cell(10,$es,"3)",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Rescisi�n</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Este Contrato podr� rescindirse en caso de incumplimiento de cualquiera de las partes a las obligaciones de este Contrato, sin necesidad de resoluci�n judicial o por caso fortuito o fuerza mayor. </p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>NOVENA. - RESPONSABILIDAD LABORAL.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En virtud de que el Administrador es una sociedad con recursos suficientes para conducir sus negocios, el Administrador ser� el �nico responsable del cumplimiento de sus obligaciones para con sus empleados, trabajadores y agentes, toda vez que entre el Derechohabiente, el Fiduciario del Fideicomiso y los empleados, prestadores de servicios del Administrador no existir� relaci�n laboral alguna ni de cualquier otra especie.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>D�CIMA.  LEY APLICABLE Y SOLUCI�N DE CONTROVERSIAS.</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para todo lo relativo a la interpretaci�n del presente subcontrato, las partes se someten a los tribunales competentes y leyes vigentes de la Ciudad de M�xico, renunciando a cualquier otro fuero que por raz�n de sus domicilios presentes o futuros o por cualquier otra causa les pudiera corresponder.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Estando conformes ambas partes con el alcance y contenido de lo acordado mediante el presente contrato, lo firman por duplicado el d�a 31 DE 10 DE 18, quedando un ejemplar en poder de cada una de ellas.</p>";
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

$txt="<p><vb>ANEXO �B�</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(2);

$txt="<p><vb>AVISO DE PRIVACIDAD</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(3);

$txt="<p>De acuerdo con los art�culos 15 y 16 de la ley federal de protecci�n de Datos Personales en Posesi�n de Particulares, hago de su conocimiento que los datos recabados ser�n �nicamente utilizados para ofrecer el servicio que usted ha solicitado.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>As� mismo informarle que usted tiene derecho al acceso, cancelaci�n u oposici�n de sus datos personales en cuanto usted lo decida. El medio en donde usted podr� ejercer estos derechos ser�a mediante una solicitud de �Derechos Arco�, esto se refiere a aquel derecho que tiene un titular de datos personales, para solicitar el acceso, rectificaci�n, cancelaci�n u oposici�n sobre el tratamiento de sus datos ante el Sujeto Obligado que est� en posesi�n de los mismos.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Es importante se�alar, que para estar en posibilidad de rechazar una solicitud de Derechos Arco, el titular o representante legal deben acreditar su identidad o representaci�n, respectivamente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>As� como tambi�n es importante hacerle saber que, la empresa �PROMOTORIA ASOCIADOS ESTA ES TU CASA S.A DE C.V� con direcci�n en Barranca del Muerto N�m. 210, interior 100, Colonia Guadalupe Inn, delegaci�n �lvaro Obreg�n, c�digo postal 01020, es responsable tanto de recabar sus datos personales, del uso que se les d� a los mismos, as� como de su protecci�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Se establece que los Datos Personales constituyen informaci�n confidencial del Titular. Por tanto, el Responsable acuerda mantener todos y cada una de los Datos Personales en estricta confidencialidad y se obliga a no divulgar ni revelar los Datos Personales a personas distintas de las se�aladas anteriormente sin contar con el previo consentimiento otorgado por escrito del Titular.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>La obligaci�n de confidencialidad no ser� aplicable a: informaci�n que sea del dominio p�blico, que sea p�blica o que obre en Fuentes de Acceso P�blico como dicho t�rmino se define en la Ley; informaci�n que resulte evidente, incluyendo para un t�cnico en la materia; informaci�n que previamente a su divulgaci�n ya obre en poder del Responsable o de cualquiera de las personas a que se refiere el p�rrafo anterior o haya sido desarrollada independientemente por el Responsable o por dichas personas; o  informaci�n que deba ser divulgada por disposici�n legal, orden judicial o de autoridad competente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Con lo dicho anteriormente, hacemos de su conocimiento que ninguna otra persona, a menos que usted lo autorice, o solo por orden legal puede hacer uso de sus datos personales.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(200);

$txt="<p><vb>ANEXO �C�</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(2);

$txt="<p><vb>PROCEDIMIENTO OPERATIVO</vb></p>"; 
$pdf->WriteTag(0,$es,$txt,0,"C");
$pdf->Ln(3);

$txt="<p><vb>1� Promoci�n del Cr�dito Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador promover� el Cr�dito Infonavit entre Derechohabientes potenciales. Para tal efecto, aqu�l podr� acudir a centros de trabajo cuyos empleados puedan ser sujetos de cr�ditos de dicho instituto, particularmente del Cr�dito Infonavit. Una vez que el Administrador inicie la promoci�n en esos centros de trabajo, explicar� al Derechohabiente potencial en qu� consiste el Cr�dito Infonavit, su utilidad y los requisitos que debe cubrir para obtenerlo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que el Derechohabiente est� interesado, el Administrador le recabar� los datos personales a dicho Derechohabiente (y le entregar� el respectivo aviso de privacidad) y suscribir�n el contrato de prestaci�n de servicios correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador tambi�n podr� hacer otro tipo de promoci�n, sea por correo electr�nico o en forma telef�nica siempre y cuando tenga la autorizaci�n para hacerlo y la misma cumpla  con la normatividad en materia de datos personales.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>2� Viabilidad del Derechohabiente para obtener su Cr�dito Infonavit. Asesor�a al mismo para esos prop�sitos.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador asesorar� al Derechohabiente y verificar� junto con �ste la subcuenta del mismo en la p�gina web del Infonavit u otro medio de consulta disponible para determinar si de acuerdo a la normatividad vigente, el Derechohabiente es sujeto de obtener un Cr�dito Infonavit; es decir, si el Derechohabiente precalifica para dicho cr�dito.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>3� Integraci�n e ingreso del expediente de cr�dito al Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que el Derechohabiene sea sujeto de obtener del Cr�dito Infonavit, el Administrador asesorar� al Derechohabiente en la integraci�n de la solicitud del Cr�dito Infonavit, la cual cumplir� los requisitos establecidos por ese Instituto para esos fines, y acompa�ar� los documentos requeridos por el mismo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Asimismo, dentro de esa asesor�a, el Administrador explicar� al Derechohabiente el procedimiento de adhesi�n al Fideicomiso y de la fianza de cumplimiento y calidad otorgada por el Ejecutor de Obra conforme al Contrato de Obra, con la finalidad de garantizar la correcta aplicaci�n del Cr�dito Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador asistir� al Derechohabiente en la integraci�n de la solicitud y el Derechohabiente deber� entregar al Administrador toda la documentaci�n requerida para tal efecto. Sin embargo, el Administrador no ser� responsable por la negativa del Infonavit en el otorgamiento del cr�dito por cualquier causa.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>4� Presentaci�n de Ejecutores de Obra afianzados.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador podr� sugerir al Derechohabiente a los Ejecutores de Obra afianzados para que ejecuten la Obra en el Inmueble. Lo anterior para que el Ejecutor de Obra acuda al Inmueble, revise el �rea en la que desea hacer la reparaci�n o mejora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>5� Visita del Ejecutor de Obra al Inmueble.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Seleccionado el Ejecutor de Obra por el Derechohabiente, el Administrador coordinar� la cita para que el Ejecutor de Obra acuda al Inmueble del Derechohabiente (en adelante la Visita). El Ejecutor de Obra revisar� el �rea del Inmueble en la que el Derechohabiente desea realizar la Obra, y otros aspectos necesarios para ejecutar la reparaci�n o mejora respectiva. Posteriormente, el Ejecutor de Obra elaborar� la Cotizaci�n de la Obra mediante la cual sugerir� al Derechohabiente el tipo de trabajos que deban ejecutarse para lograr que en el �rea disponible en el Inmueble pueda ejecutarse la Obra, as� como el material, que, a juicio del Ejecutor de Obra, debe emplearse y el costo de la ejecuci�n de los mismo, sin que se exceda el monto del cr�dito precalificado en la p�gina del Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>6� Cotizaci�n de Obra autorizada por el Derechohabiente.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Posteriormente, el Ejecutor de Obra enviar� al Derechohabiente una Cotizaci�n de la Obra junto con el proyecto de esta �ltima, y en su caso, los Planos y Programa de Trabajo. El Derechohabiente deber� revisar, aprobar o rechazar dichos documentos. El Administrador dar� acompa�amiento al Derechohabiente durante esta etapa.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>7� Acompa�amiento para el Derechohabiente en la Verificaci�n Inicial.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Cuando el Derechohabiente y el Ejecutor de Obra hayan acordado la Cotizaci�n de Obra definitiva, se entregar� un original firmado por ambas partes al Administrador para que �ste se lo haga llegar al Infonavit junto con los documentos necesarios para integrar el Expediente de Cr�dito Infonavit. El Infonavit asignar� la Empresa Verificadora que realizar� la verificaci�n inicial al Inmueble respectivo.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Dicha verificaci�n se realizar� en los plazos determinados entre la empresa verificadora y el Infonavit. Ser� responsabilidad del Administrador asistir al Derechohabiente durante el proceso de verificaci�n inicial.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El objetivo de la visita es validar que los trabajos propuestos en la Cotizaci�n de Obra no se hayan ejecutado previamente en el Inmueble y as� pueda otorgarse el Cr�dito Infonavit. En todo caso, ser� el Infonavit el cual, conforme a la normatividad aplicable, resolver� sobre el otorgamiento del Cr�dito Infonavit a favor del Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente ser� responsable directo del pago de esa verificaci�n inicial en la cuenta bancaria de la empresa verificadora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>8� Inscripci�n del Cr�dito Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Ya que la Empresa Verificadora haya realizado la correspondiente visita de verificaci�n inicial en el Inmueble y haya enviado el resultado directamente al Infonavit, y conforme a la normatividad del mismo, sea procedente el otorgamiento del Cr�dito Infonavit, �ste inscribir� dicho cr�dito, generar� los documentos correspondientes y otorgar� el Cr�dito Infonavit al Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>9� Firma del Convenio de Adhesi�n. Transferencia del Cr�dito Infonavit al Fideicomiso. Confirmaci�n de ministraci�n de recursos a trav�s del Fideicomiso.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Derechohabiente instruir� y autorizar� al Infonavit para que el Cr�dito Infonavit sea depositado en la cuenta del Fideicomiso, previa firma por parte del Derechohabiente del Convenio de Adhesi�n al Fideicomiso. El fin principal del Fideicomiso es la administraci�n del Cr�dito Infonavit para que se aplique a la Obra, incluyendo el pago directo al Ejecutor de Obra y el pago de la comisi�n al Administrador. La cantidad neta transferida ya incorporar� los descuentos por gastos administrativos de Infonavit.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Mediante este Convenio de Adhesi�n el Derechohabiente autorizar� por escrito al Administrador para que instruya al Fideicomiso el pago del correspondiente anticipo al Ejecutor de Obra. Este iniciar� y terminar� los trabajos para la Obra de acuerdo a la fecha prevista en el Contrato de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>10� Suscripci�n del Contrato de Obra. Autorizaci�n de anticipo de Obra. Ejecuci�n de la Obra y pago de avance de esta. Culminaci�n de la Obra y acta de entrega de la misma.</vb<</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Transferido el Cr�dito Infonavit al Fideicomiso, el Derechohabiente suscribir� el Contrato de Obra con el Ejecutor de Obra. . 
El Administrador tendr� la obligaci�n de vigilar que el Ejecutor de Obra cumpla con las fechas pactadas en el Contrato de Obra.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador deber� cerciorarse de que la Ejecuci�n de la Obra est� garantizada mediante la Fianza correspondiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador instruir� al Fideicomiso el pago a favor del Ejecutor de Obra conforme los avances de la misma en t�rminos de la Cotizaci�n de Obra y al Contrato correspondiente, previa autorizaci�n por escrito del Derechohabiente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Para efectuar la entrega final de la Obra, el Ejecutor de Obra dar� aviso por escrito al Derechohabiente a fin de que ambas partes suscriban el acta entrega de la Obra, en la que conste la conclusi�n de los trabajos contratados. El Ejecutor de Obra entregar� al Administrador una copia del  acta de entrega para que �ste pueda dar el acompa�amiento al Derechohabiente en la verificaci�n final.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>11� Acompa�amiento en la verificaci�n final.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador solicitar� al Infonavit la asignaci�n de una Empresa Verificadora para que haga la verificaci�n final de la Obra respecto a la aplicaci�n del Cr�dito Infonavit en el Inmueble, y generar� los reportres de la visita final y el dictamen de aplicaci�n de recursos. El Derechohabiente dar� las facilidades necesarias a dicha empresa para la realizaci�n de la verificaci�n final.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>Ser� responsabilidad del Administrador asistir al Derechohabiente durante el proceso de verificaci�n final. El Derechohabiente ser� responsable del pago directo de esa verificaci�n final en la cuenta bancaria de la empresa verificadora.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>12� Entrega de reportes y dictamen de aplicaci�n de recursos para solicitar aplicaci�n del Saldo de la Subcuenta de Vivienda al Cr�dito Infonavit.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>El Administrador entregar� directamente al Infonavit los reportes correspondientes a la conclusi�n de la Obra. Ser� responsabilidad de la empresa verificadora que realice la verificaci�n final la generaci�n y entrega al Infonavit del dictamen de aplicaci�n de recursos para que el Infonavit aplique el Saldo de la Subcuenta de Vivienda del Derechohabiente al Cr�dito Infonavit y se tenga por concluida y terminada la Obra a cargo del Ejecutor de Obra bajo la supervisi�n del Administrador.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>13� Reclamo por el derechohabiente sobre la calidad de la Obra.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p>En caso de que el Derechohabiente decida tramitar la reclamaci�n de la Fianza de Calidad y la Obra ya fue concluida, suscrita el acta de entrega y emitido el dictamen de la empresa verificadora; y la Obra presenta desperfectos o vicios ocultos y el Ejecutor de Obra no realiza las gestiones para reparar la Obra, el Administrador realizar� los tr�mites de la reclamaci�n de la fianza de calidad a fin de que �sta sea ejecutada y pagada. 
Dicha reclamaci�n deber� ser solicitada y tramitada dentro del periodo contemplado en la Fianza de calidad, en caso de ser procedente los fondos ser�n depositados directamente al Fideicomiso.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Output();
?>
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
$pdf->SetStyle("placee","Arial","U",10,"0,0,0");
$pdf->SetStyle("vb","Arial","B",0,"0,0,0");

//$pdf->SetFont('Arial','',$fs);

$txt="<p><vb>CONTRATO QUE CELEBRAN VITTA COCINAS DE ESTILO S.A. DE C.V. REPRESENTADA EN ESTE ACTO POR SU REPRESENTANTE LEGAL <placee>ALEJANDRO PEREZ BOBADILLA</placee> A QUIEN EN LO SUCESIVO Y PARA LOS EFECTOS DEL PRESENTE CONTRATO SE LE DENOMINARA COMO �LA CONSTRUCTORA�  Y POR OTRA PARTE EL SR. (A): <placee>".$unombre."</placee> DERECHOHABIENTE BENEFICIARIO DEL CREDITO PARA REMODELACION DE CASA HABITACION OTORGADO POR EL INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES (INFONAVIT) QUIEN EN LO SUCESIVO Y PARA EFECTOS DEL PRESENTE INSTRUMENTO SE LE DENOMINARA COMO (DERECHOHABIENTE), AL TENOR DE LAS SIGUIENTES:</vb></p>";
$pdf->Ln(4);
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->SetFont('Arial','BU',$fs);
$pdf->Cell(180,$es,"D E C L A R A C I O N E S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>I.    DECLARA �EL PRESTADOR� POR CONDUCTO DE SU REPRESENTANTE:</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Que es una sociedad debidamente constituida conforme a las leyes de este pa�s, tal y como se acredita en la Escritura P�blica No. 109 de fecha 5 de marzo de 2013, pasada ante la fe del Licenciado Luis De Angoitia Becerra, titular de la notar�a n�mero 109 del Distrito Federal, misma que se encuentra debidamente inscrita en el registro P�blico de la Propiedad y el comercio del Distrito Federal con n�mero de folio mercantil n�mero 495570-1 <vb>(anexo 1)</vb>, inscrita en el Registro Federal de Contribuyentes del Servicio de Administraci�n Tributaria (SAT) con RFC AOBL660429PU5 <vb>(anexo 2)</vb>.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que su representante cuenta con los poderes suficientes para representar y obligar a la sociedad en este acto, tal y como consta en la Escritura P�blica N�mero 69502 de fecha 5 de marzo de 2013, pasada ante la fe del Licenciado Luis De Angoitia Becerra, Notario P�blico n�mero 230 del Distrito Federal, <vb>(anexo 3)</vb>, los cuales bajo protesta de decir verdad manifiesta que no le han sido revocados ni modificados de forma alguna.</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que dentro de su objeto social se encuentra contemplado la prestaci�n de servicios de mantenimiento y remodelaci�n de construcciones habitacionales e industriales, as� como la supervisi�n, asesor�a y asistencia t�cnica sobre las actividades  enunciadas anteriormente.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que su domicilio para los efectos del presente contrato se encuentra ubicado en M�xico Distrito Federal, se anexa comprobante de domicilio. <vb>(anexo 4)</vb>.</p>";
$pdf->Cell(10,$es,"D.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que cuenta con los elementos t�cnicos, humanos y materiales necesarios para el desarrollo eficaz de los servicios a prestar, objeto del presente instrumento contractual.</p>";
$pdf->Cell(10,$es,"E.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>II.    DECLARA �EL DERECHOHABIENTE�:</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Que es una persona con plena facultad f�sica y mental para celebrar este contrato el cual tiene como objeto recibir el cr�dito autorizado por el Instituto  del Fondo Nacional para la Vivienda de los Trabajadores,  de acuerdo y para la incorporaci�n al programa de apoyo de l�nea cuatro.  otorgado con la finalidad de que este contrate el servicio de ejecuci�n de la obra con la �CONSTRUCTORA� <vb>VITTA COCINAS DE ESTILO S.A. DE C.V.</vb> consistente en mantenimiento, remodelaci�n de vivienda, o en su caso el de Supervisi�n de obra, dado que el derechohabiente tiene la libre   voluntad de elegir a su conveniencia quien ejecutar� los trabajos de remodelaci�n de su casa habitaci�n. Por lo que, por as� convenir a su inter�s de elegir a otra constructora para la ejecuci�n de la obra consistente en la remodelaci�n, contratara en este caso (LA CONSTRUCTORA) solo como la encargada de la supervisi�n de los trabajos de remodelaci�n de vivienda.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>Que su domicilio para los efectos del presente contrato se encuentra ubicado en: <placee>".$domicilio.".</placee></p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Que es su voluntad celebrar este contrato con la �CONSTRUCTORA� para la ejecuci�n de lo trabajos de remodelaci�n de vivienda objeto del pr�stamo adquirido o en su caso de acuerdo a su libre voluntad y de acuerdo a lo establecido en las clausulas �D� y �E� punto 2 el contrato maestro celebrado con el �ADMINISTRADOR� de los fondos, encomendar los trabajos motivo del cr�dito recibido a la constructora de su elecci�n de acuerdo a sus intereses.</p>";
$pdf->Cell(10,$es,"C.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p><vb>III.    DECLARAN LAS PARTES.</vb></p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','',$fs);
$txt="<p>Que celebran el presente contrato en t�rminos de lo dispuesto por los art�culos 1794,1796,1803,1804,1805,1824,1832,1836,1839 y 2606 del C�digo Civil de la Ciudad de M�xico, el cual se celebra sin vicios en la voluntad, tales como dolo, error, mala fe o lesi�n, que afecten la validez y legalidad del contrato, siendo l�cito su objeto.</p>";
$pdf->Cell(10,$es,"A.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$txt="<p>De conformidad con las anteriores declaraciones, las partes reconocen su personalidad jur�dica y la capacidad legal que ostentan, as� mismo conocen el alcance y contenido de este contrato y est�n de acuerdo en someterse al tenor de las siguientes:</p>";
$pdf->Cell(10,$es,"B.",0,0,"C");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(3);

$pdf->SetFont('Arial','BU',$fs);
$pdf->Cell(180,$es,"C  L  �  U  S  U  L  A  S",0,1,"C");
$pdf->Ln(2);

$txt="<p><vb>PRIMERA.</vb> <p3>Objeto.</p3><vb>-</vb> �EL DERECHOHABIENTE� por voluntad propia decide llevar a cabo la remodelaci�n de su casa habitaci�n y acepta las condiciones contractuales que el INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES ha llevado a cabo con el Fideicomiso Promotor�a Asociados esta es tu Casa, S.A. de C.V., y �sta a su vez contra los servicios de la �CONSTRUCTORA� <vb>VITTA COCINAS DE ESTILO S.A. DE C.V.</vb>  Para la ejecuci�n de la obra, mediante cr�dito otorgado por el INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES al derechohabiente, derivado del programa de apoyo de l�nea cuatro, por lo que, y de acuerdo a su libre voluntad de selecci�n del ejecutor de la obra el derechohabiente decida contratar a otra Constructora para la encomienda de la ejecuci�n de la misma, por lo que de ser as�   <vb>VITTA COCINAS DE ESTILO S.A. DE C. V.</vb>   Entregar� el importe del cr�dito  otorgado, al derechohabiente, dado que los fondos provienen de cr�dito otorgado por el INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEGUNDA.- </vb>En caso de que el derechohabiente  acreditado decidiera sustituir a la �CONSTRUCTORA� <vb>VITTA COCINAS DE ESTILO S.A.DE C.V.</vb> mediante  convenio y una vez que se acuerde la devoluci�n entrega del cr�dito otorgado al derechohabiente el mismo  se compromete a contratar a esta �nica y exclusivamente con la finalidad de que se lleven a cabo la supervisi�n de los trabajos de remodelaci�n objeto del pr�stamo otorgado y de acuerdo  al programa de apoyo de l�nea cuatro, por lo que adem�s se compromete   a pagar a la �CONSTRUCTORA� un __% del importe del pr�stamo adquirido por concepto de supervisi�n de los trabajos a realizar, ya sea remodelaci�n, mantenimiento o ampliaci�n de vivienda.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>TERCERA.</vb> <p3>Vigencia.</p3><vb>-</vb> La vigencia del presente Contrato ser� m�ximo de 6 meses para concluir las obras contadas a partir de la fecha de la firma de �ste instrumento.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>CUARTA.- </vb>En caso de que el �EL DERECHOHABIENTE� decidiera sustituir a la �CONSTRUCTORA� de acuerdo a su libre voluntad de selecci�n de que constructora elija para la ejecuci�n de los trabajos, mediante convenio este recibir� por parte de la �CONSTRUCTORA� <vb>VITTA COCINAS DE ESTILO S.A. DE C.V.</vb>    el importe de $ _____________________M.N., mediante cheque nominativo proveniente del cr�dito otorgado por parte del INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES, para que de acuerdo a su libre voluntad  pueda contratar a la �CONSTRUCTORA�  �nica y exclusivamente para la supervisi�n de los trabajos que ejecute la constructora elegida por el derechohabiente, mediante el pago de un porcentaje establecido sobre el cr�dito recibido por el acreditado para que �ste a su vez, contin�e con el tr�mite contractual de un tercero (Constructora) para la ejecuci�n de la obra consistente en los trabajos encomendados.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>QUINTA.-</vb> <p3>Entrega del cr�dito.</p3><vb>-</vb> En el caso de que  �EL DERECHOHABIENTE�  decidiera sustituir  a la �CONSTRUCTORA�  <vb>VITTA COCINAS DE ESTILO S.A. DE C.V.</vb> para la ejecuci�n de  los trabajos de remodelaci�n, acudir� a las oficinas de  esta  para la entrega del cr�dito otorgado, fondos que provienen del INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES, mediante  cheque nominativo que ser� otorgado por el encargado de cuentas por pagar  el d�a que acuerden ambas partes y firmar� una copia que ser� archivado en el expediente para control, y queda a su libre voluntad de contratar a la  �CONSTRUCTORA� <vb>VITTA COCINAS DE ESTILO S.A. DE C.V.</vb> para la supervisi�n de la obra mediante el pago por el servicio prestado.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEXTA.</vb> <p3>Impuestos.</p3><vb>-</vb> En el  acto  de que la �CONSTRUCTORA� <vb>VITTA COCINAS DE ESTILO S.A. DE C.V.</vb> entregue al derechohabiente el importe del pr�stamo otorgado, derivado de la sustituci�n del ejecutor de obra y de acuerdo a su libre voluntad de elegir a un tercero para la ejecuci�n de lo trabajos de remodelaci�n no se genera ning�n tipo de impuesto por considerarse un pr�stamo para remodelaci�n, ampliaci�n o construcci�n de casa habitaci�n fondos que provienen  por parte del Instituto Nacional para la Vivienda de los Trabajadores  para la incorporaci�n al programa de apoyo de l�nea cuatro conforme a la Legislaci�n Fiscal vigente, oblig�ndose el derechohabiente a pagar el cr�dito otorgado a la Instituto.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>SEPTIMA.</vb> <p3>Naturaleza de este contrato.</p3><vb>-</vb> Tomando en consideraci�n la �ndole del presente contrato, este es de naturaleza civil, por lo que cualquier autoridad de car�cter diferente a esta materia, resulta incompetente para conocer de controversias que se susciten en la interpretaci�n del presente.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>OCTAVA.</vb> <p3>Celebraci�n de diversos contratos.</p3><vb>-</vb> �EL DERECHOHABIENTE�  podr� celebrar con cualquier otra persona ll�mese persona f�sica o persona moral todo tipo de contratos de prestaci�n de servicios de remodelaci�n a fin de cumplir con el prop�sito del cr�dito otorgado por el INSTITUTO DEL FONDO NACIONAL DE LA VIVIENDA PARA LOS TRABAJADORES el entendido de que el�DERECHOHABIENTE� Ser� el �nico responsable de pagarle al tercero el importe de los materiales y todo lo que implique para encomendada remodelaci�n.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$txt="<p><vb>L</vb>os contratantes convienen en que para la interpretaci�n y cumplimiento de este contrato, se someten en forma expresa a las leyes y tribunales de la Ciudad de M�xico, renunciando desde luego a cualquier  fuero que pudiera corresponderles por domicilios presentes o futuros, le�do y ratificado en todas y cada una de sus partes el presente contrato y enteradas de todas y cada una de las clausulas contenidas en este instrumento y manifestando su conformidad con las mismas, lo firman para constancia de aceptaci�n y conocimiento de su alcance y valor legal en la Ciudad de M�xico $hoy.</p>";
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(2);

$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Cell(170,$es,"-------------------------------------------------------------------------------------------------------------------------------------------------",0,1,"C");
$pdf->Ln(2);

$pdf->SetFont('Arial','B',$fs);
$pdf->Cell(85,$es,"�EL DERECHOHABIENTE�",0,0,"C");
$pdf->Cell(85,$es,"�VITTA COCINAS DE ESTILO S.A. DE C.V.�",0,1,"C");
$pdf->Ln(20);

$pdf->Cell(17.5,$es,"",0,0,"C");
$pdf->Cell(50,$es,"$unombre",'T',0,"C");
$pdf->Cell(35,$es,"",0,0,"C");
$pdf->Cell(50,$es,"por conducto de su representante",'T',1,"C");
$pdf->Cell(255,$es,"ALEJANDRO PEREZ BOBADILLA",0,1,"C");
$pdf->Ln(5);

$pdf->SetFont('Arial','B',$fs);
$pdf->Cell(180,$es,"TESTIGOS",0,1,"C");
$pdf->Ln(20);

$pdf->Cell(17.5,$es,"",0,0,"C");
$pdf->Cell(50,$es,"��������������",0,0,"C");
$pdf->Cell(35,$es,"",0,0,"C");
$pdf->Cell(50,$es,"��������������",0,1,"C");
$pdf->Ln(2);

/*
$txt="<p>Tengo plena conciencia de que es un crÃ©dito y que si no realizo la mejoras no se utilizara el SSV para liquidarlo y seguirÃ© pagando el crÃ©dito hasta su liquidaciÃ³n total.</p>";
$pdf->Cell(12,$es,"A)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Se que tienen 180 dÃ­as para hacer las remodelaciones correspondientes y que no existe prÃ³rroga para ampliar el plazo.</p>";
$pdf->Cell(12,$es,"B)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Se que tengo que cumplir al pie de la letra el programa y presupuesto de obra ya que el hecho de no hacerlo pone en riesgo que el dictamen de aplicaciÃ³n de recursos (segunda visita) resulte negativo por ende no se liquidara mi crÃ©dito.</p>";
$pdf->Cell(12,$es,"C)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Que una vez concluidas las mejoras se realizara una segunda visita a la vivienda bajo el objeto del crÃ©dito y de proceder de emitirÃ¡ un DAR positivo donde se determinara que se jale el SSV, para liquidar el crÃ©dito.</p>";
$pdf->Cell(12,$es,"D)",0,0,"R");
$pdf->WriteTag(0,$es,$txt,0,"J");
$pdf->Ln(1);

$txt="<p>Que una vez emitido el DAR positivo el tiempo estimado para que el crÃ©dito se vea liquidado y por ende poder bajar el aviso de suspensiÃ³n de descuentos es de 3 meses contados a partir de que el Ã¡rea tÃ©cnica envÃ­a el dictamen a oficinas centrales.</p>";
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
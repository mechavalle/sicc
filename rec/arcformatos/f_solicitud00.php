<?
include("../../lib/f_conectai.php"); 
include("../../lib/f_fnBDi.php");
require("../../lib/fpdf.php");
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
		
	$nombre=$val5['nombre'];
	$apellidop=$val5['apellidop'];
	$apellidom=$val5['apellidom'];
	$unombre=strtoupper($nombre);
	
	$idproducto=$val5['idproducto'];
	$segundocredito=$val5['segundocredito'];
	$plazocredito=$val5['plazocredito'];
	$calle=$val5['calle'];
	$numero=$val5['numero'];
	$numeroint=$val5['numeroint'];
	$lote=$val5['lote'];
	$mza=$val5['mza'];
	$colonia=$val5['colonia'];
	$municipio=$val5['municipio'];
	$estado=$val5['estado'];
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

$milogo="../../img/infonavit.png";
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
	$representante=$val5['representantelegal'];	
	$escdenominacion=ucwords($val5['escdenominacion']);
	$escescritura=ucwords($val5['escescritura']);
	$escfecha=ucwords($val5['escfecha']);
	$escnotario=$val5['escnotario'];
	$escnotarionum=ucwords($val5['escnotarionum']);
	$escinscripcion=$val5['escinscripcion'];
	$escinscripcionnum=$val5['escinscripcionnum'];
	$escinscripcionfecha=$val5['escinscripcionfecha'];
	$desccorta=$val5['desccorta'];	
	$registropatronal=$val5['registropatronal'];
	}
mysql_free_result($res2);
*/

	### Generación de PDF

	
	class PDF extends FPDF
		{
		
		// Current column
		var $col = 0;
		// Ordinate of column start
		var $y0;
		    //Encabezado de página

		function Circle($x, $y, $r, $style='D')
			{
			    $this->Ellipse($x,$y,$r,$r,$style);
			}

			function Ellipse($x, $y, $rx, $ry, $style='D')
			{
			    if($style=='F')
			        $op='f';
			    elseif($style=='FD' || $style=='DF')
			        $op='B';
			    else
			        $op='S';
			    $lx=4/3*(M_SQRT2-1)*$rx;
			    $ly=4/3*(M_SQRT2-1)*$ry;
			    $k=$this->k;
			    $h=$this->h;
			    $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
			        ($x+$rx)*$k,($h-$y)*$k,
			        ($x+$rx)*$k,($h-($y-$ly))*$k,
			        ($x+$lx)*$k,($h-($y-$ry))*$k,
			        $x*$k,($h-($y-$ry))*$k));
			    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
			        ($x-$lx)*$k,($h-($y-$ry))*$k,
			        ($x-$rx)*$k,($h-($y-$ly))*$k,
			        ($x-$rx)*$k,($h-$y)*$k));
			    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
			        ($x-$rx)*$k,($h-($y+$ly))*$k,
			        ($x-$lx)*$k,($h-($y+$ry))*$k,
			        $x*$k,($h-($y+$ry))*$k));
			    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
			        ($x+$lx)*$k,($h-($y+$ry))*$k,
			        ($x+$rx)*$k,($h-($y+$ly))*$k,
			        ($x+$rx)*$k,($h-$y)*$k,
			        $op));
			}


		    
		    function Header()
		    {   
				global $fecha;
				global $idcreditov;
				global $milogo;

				$this->SetFillColor(254,0,2);
		        $this->Image($milogo,175,8,22);

		        $this->SetY(8);
		        $this->SetTextColor(255,255,255);
		        $this->SetFont('Arial','B',16);
				$this->Cell(20,10,"",0,0,'C');
				$this->Cell(130,10,"SOLICITUD DE INSCRIPCIÓN DE CRÉDITO",0,1,'C',true);
				$this->y0 = $this->GetY();
		    }

##Funciones necesarias para las columnas
/*		    
		    function SetCol($col)
				{
				    // Set position at a given column
				    $this->col = $col;
				    $x = 10+$col*100;
				    $this->SetLeftMargin($x);
				    $this->SetX($x);
				}
		    
			function AcceptPageBreak()
				{
				    // Method accepting or not automatic page break
				    if($this->col<1)
				    {
				        // Go to next column
				        $this->SetCol($this->col+1);
				        // Set ordinate to top
				        $this->SetY($this->y0);
				        // Keep on page
				        return false;
				    }
				    else
				    {
				        // Go back to first column
				        $this->SetCol(0);
				        // Page break
				        return true;
				    }
				} 
*/
### Fin de funciones necesarias para las columnas
		    
 
		   function Footer()
				{
				
				    $this->SetY(-10);
				    $this->Line($this->GetX(),$this->GetY(),$this->GetX()+177,$this->GetY());

				    $this->SetX(10);	
				    $this->SetFont('Arial','',6);
					$this->Cell(15,6,"",0,0,'C');	
					$this->Cell(60,6,"*DATOS OBLIGATORIOS",0,0,'L');
					$this->Cell(60,6,"HOJA ".$this->PageNo()." DE {nb}",0,0,'C');
					$this->Cell(50,6,"CRED 1000.15",0,0,'R');				    				    
				   # $this->Cell(15,10,$this->PageNo().'/{nb}',0,0,'C');
				}

		}
	$hs=7;
	$fs=6;
	$es=6;
	$maximo=177;	
	$pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(20,8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',$hs);
    $pdf->SetY(20);
    $pdf->Cell($maximo,$es,"1. CRÉDITO SOLICITADO",0,1,'C');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(20,$es,"*PRODUCTO:",'LTB',0,'L');
    $m=20;
    $csql = "SELECT * from `cat_creproductos` WHERE `status` = '1';";		
	$res2 = mysqli_query($conexio,$csql);
	while($val5=mysqli_fetch_array($res2))
		{
		$long=strlen($val5['descripcion']);
		if($long>20)
			$llong=$long*1.4;
		else
			$llong=$long*1.6;
		$pdf->Cell($llong,$es,$val5['descripcion'],'TB',0,'L');
   		$x=$pdf->GetX();
    	$y=$pdf->GetY()+3;
    	if($idproducto==$val5['id'])
    		$pdf->SetFillColor(0,0,0);
    	else
    		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x,$y,1.5,'FD');
		$pdf->Cell(5,$es,'','TB',0,'L');
		$m +=$llong+5;		
		}
	mysqli_free_result($res2);

	$pdf->Cell(24,$es,'ENTIDAD FINANCIERA','TB',0,'L');
	$m +=24;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+5;
	$pdf->Line($x,$y,$x+13,$y);
	$pdf->Cell($maximo-$m,$es,'','TBR',1,'L');

	/*$pdf->Cell($maximo,$es,'',1,1,'L',true);*/



	$pdf->Cell(30,$es,"*TIPO DE CRÉDITO:",'LTB',0,'L');
	$m=30;
    $csql = "SELECT * from `cat_cretipopro` WHERE `status` = '1';";		
	$res2 = mysqli_query($conexio,$csql);
	while($val5=mysqli_fetch_array($res2))
		{
		$long=strlen($val5['descripcion']);
		if($long>20)
			$llong=$long*1.4;
		else
			$llong=$long*1.9;
		$pdf->Cell($llong,$es,$val5['descripcion'],'TB',0,'L');
   		$x=$pdf->GetX();
    	$y=$pdf->GetY()+3;
    	if($idproducto==$val5['id'])
    		$pdf->SetFillColor(0,0,0);
    	else
    		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x,$y,1.5,'FD');
		$pdf->Cell(5,$es,'','TB',0,'L');		
		$m +=$llong+5;
		}
	mysqli_free_result($res2);
	$pdf->Cell($maximo-$m,$es,'','TBR',1,'L');


	$pdf->Cell(30,$es,"*DESTINO DEL CRÉDITO:",'LT',0,'L');
	$m=30;
	$borde="T";
    $csql = "SELECT * from `cat_credestino` WHERE `status` = '1';";		
	$res2 = mysqli_query($conexio,$csql);
	while($val5=mysqli_fetch_array($res2))
		{
		$long=strlen($val5['descripcion']);
		if($long>20)
			$llong=$long*1.2;
		else
			$llong=$long*1.4;
		if($pdf->GetX()+$long+5>=$maximo)
			{
			$pdf->Cell($maximo-$m,$es,'','TR',1,'L');
			$pdf->Cell($llong,$es,$val5['descripcion'],'LB',0,'L');
			$borde="B";
			$m=0;
			}
		else
			$pdf->Cell($llong,$es,$val5['descripcion'],$borde,0,'L');

   		$x=$pdf->GetX();
    	$y=$pdf->GetY()+3;
    	if($idproducto==$val5['id'])
    		$pdf->SetFillColor(0,0,0);
    	else
    		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x,$y,1.5,'FD');

		$pdf->Cell(5,$es,'',$borde,0,'L');		
		$m +=$llong+5;
		}
	mysqli_free_result($res2);
	$pdf->Cell($maximo-$m,$es,'','BR',1,'L');

	$pdf->MultiCell(177,4,"Son requisitos y documentación necesarios para la contratación del crédito los siguientes: 1.-Participar en el taller de orientación Saber para Decidir, 2.Presentar Solicitud de Crédito, 3.-Contar con una relación laboral Vigente, 4.-Cumplir con las condiciones requeridas conforme a la Evaluación Integral. 
El solicitante deberá reunir los requisitos señalados y presentar la documentación solicitada al momento de aceptar la Oferta Vinculante.",1);
	$pdf->Ln(3);
	$px=$pdf->GetX();
	$py=$pdf->GetY();

	$pdf->Cell($maximo/2,4,"Plazo del crédito (aplica para segundo crédito)",'LTR',0,'L');
	$pdf->Cell($maximo/2,8,"Es el segundo crédito que solicita al infonavit?            SÍ                     NO",'TBR',0,'L');
	if($segundocredito==0)
		{
		$pdf->SetFillColor(255,255,255);
		$x=$pdf->GetX();
    	$y=$pdf->GetY()+4;
		$pdf->Circle($x-27,$y,1.5,'FD');

		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x-12,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(0,0,0);
		$x=$pdf->GetX();
    	$y=$pdf->GetY()+4;
		$pdf->Circle($x-27,$y,1.5,'FD');

		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x-12,$y,1.5,'FD');
		}
	$pdf->SetX($px);
	$pdf->SetY($py+4);

	$m=0;
    $csql = "SELECT descripcion,cast(descripcion as SIGNED) as num from `cat_creplazo` WHERE `status` = '1';";		
	$res2 = mysqli_query($conexio,$csql);
	while($val5=mysqli_fetch_array($res2))
		{
		$long=strlen($val5['descripcion']);
		$llong=$long*1.7;
		$llong=11;
		if($m==0)
			$pdf->Cell($llong,4,$val5['descripcion'],'LB',0,'L');
		else
			$pdf->Cell($llong,4,$val5['descripcion'],'B',0,'L');
   		$x=$pdf->GetX();
    	$y=$pdf->GetY()+1.5;
    	if($plazocredito==$val5['num'])
    		$pdf->SetFillColor(0,0,0);
    	else
    		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x,$y,1.5,'FD');
		$pdf->Cell(3,4,'','B',0,'L');		
		$m +=$llong+3;
		}
	mysqli_free_result($res2);
	$pdf->Cell(($maximo/2)-$m,4,'','BR',1,'L');

	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"2. DATOS PARA DETERMINAR EL MONTO DEL CRÉDITO",0,1,'C');

	$pdf->SetFont('Arial','',$fs);

	$pdf->Cell($maximo,$es,"A.- EN CASO DE TENER DESCUENTOS FAVOR DE  LLENAR LA SIGUIENTE INFORMACIÓN: ",'LTR',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(60,$es,"",'L',0,'L');
	$pdf->Cell(24,$es,"DERECHOHABIENTE",0,0,'C');
	$pdf->Cell(11,$es,"",0,0,'L');
	$pdf->Cell(24,$es,"CÓNYUGE",0,0,'C');
	$pdf->Cell(58,$es,"",'R',1,'C');

	
	$pdf->Cell(60,4,"  DESCUENTO MENSUAL POR PENSIÓN ALIMENTICIA (En su caso)",'L',0,'L');
	$x=$pdf->GetX()+3;
    $y=$pdf->GetY()+3;
	$pdf->Cell(24,4,"$",0,0,'L');
	$pdf->Line($x,$y,$x+20,$y);
	$pdf->Line($x,$y-1.5,$x,$y);
	$pdf->Line($x+4,$y-1.5,$x+4,$y);
	$pdf->Line($x+8,$y-1.5,$x+8,$y);
	$pdf->Line($x+12,$y-1.5,$x+12,$y);
	$pdf->Line($x+16,$y-1.5,$x+16,$y);
	$pdf->Line($x+20,$y-1.5,$x+20,$y);	

	$pdf->Cell(11,4,"",0,0,'L');

	$x=$pdf->GetX()+3;
    $y=$pdf->GetY()+3;
	$pdf->Cell(24,4,"$",0,0,'L');
	$pdf->Line($x,$y,$x+20,$y);
	$pdf->Line($x,$y-1.5,$x,$y);
	$pdf->Line($x+4,$y-1.5,$x+4,$y);
	$pdf->Line($x+8,$y-1.5,$x+8,$y);
	$pdf->Line($x+12,$y-1.5,$x+12,$y);
	$pdf->Line($x+16,$y-1.5,$x+16,$y);
	$pdf->Line($x+20,$y-1.5,$x+20,$y);
	$pdf->Cell(58,4,"",'R',1,'C');

	$pdf->SetFont('Arial','',4);
	$pdf->Cell(60,0,"",0,0,'L');
	$pdf->Cell(24,0,"(sin centavos)",0,0,'C');
	$pdf->Cell(11,0,"",0,0,'L');
	$pdf->Cell(24,0,"(sin centavos)",0,0,'C');
	$pdf->Cell(58,0,"",0,1,'C');


	$pdf->Cell($maximo,2,"",'LR',1,'L');
	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,4,"B.- EN CASO DE SOLICITAR UN MONTO DE CRÉDITO MENOR AL PROPUESTO EN LA PRECALIFICACIÓN FAVOR DE LLENAR LA SIGUIENTE INFORMACIÓN:",'LR',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(60,$es,"",'L',0,'L');
	$pdf->Cell(24,$es,"DERECHOHABIENTE",0,0,'C');
	$pdf->Cell(11,$es,"",0,0,'L');
	$pdf->Cell(24,$es,"CÓNYUGE",0,0,'C');
	$pdf->Cell(58,$es,"",'R',1,'C');	
	$pdf->Cell(60,4,"  MONTO DE CRÉDITO SOLICITADO:",'L',0,'L');
	$x=$pdf->GetX()+3;
    $y=$pdf->GetY()+3;
	$pdf->Cell(24,4,"$",0,0,'L');
	$pdf->Line($x,$y,$x+20,$y);
	$pdf->Line($x,$y-1.5,$x,$y);
	$pdf->Line($x+4,$y-1.5,$x+4,$y);
	$pdf->Line($x+8,$y-1.5,$x+8,$y);
	$pdf->Line($x+12,$y-1.5,$x+12,$y);
	$pdf->Line($x+16,$y-1.5,$x+16,$y);
	$pdf->Line($x+20,$y-1.5,$x+20,$y);	

	$pdf->Cell(11,4,"",0,0,'L');

	$x=$pdf->GetX()+3;
    $y=$pdf->GetY()+3;
	$pdf->Cell(24,4,"$",0,0,'L');
	$pdf->Line($x,$y,$x+20,$y);
	$pdf->Line($x,$y-1.5,$x,$y);
	$pdf->Line($x+4,$y-1.5,$x+4,$y);
	$pdf->Line($x+8,$y-1.5,$x+8,$y);
	$pdf->Line($x+12,$y-1.5,$x+12,$y);
	$pdf->Line($x+16,$y-1.5,$x+16,$y);
	$pdf->Line($x+20,$y-1.5,$x+20,$y);
	$pdf->Cell(58,4,"",'R',1,'C');

	$pdf->SetFont('Arial','',4);
	$pdf->Cell(60,0,"",0,0,'L');
	$pdf->Cell(24,0,"(sin centavos)",0,0,'C');
	$pdf->Cell(11,0,"",0,0,'L');
	$pdf->Cell(24,0,"(sin centavos)",0,0,'C');
	$pdf->Cell(58,0,"",0,1,'C');

	$pdf->Cell($maximo,2,"",'LR',1,'L');
	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,4,"C.-EN CASO DE AHORRO VOLUNTARIO PARA COMPLEMENTAR EL FINANCIAMIENTO DEL INSTITUTO PARA LA ADQUISICIÓN DE LA VIVIENDA, INDICAR EL MONTO:",'LR',1,'L');

	$x=$pdf->GetX()+41;
    $y=$pdf->GetY()+4.5;
	$pdf->Cell($maximo,$es,"  MONTO DE AHORRO VOLUNTARIO:  $",'LR',1,'L');
	$pdf->Line($x,$y,$x+20,$y);
	$pdf->Line($x,$y-1.5,$x,$y);
	$pdf->Line($x+4,$y-1.5,$x+4,$y);
	$pdf->Line($x+8,$y-1.5,$x+8,$y);
	$pdf->Line($x+12,$y-1.5,$x+12,$y);
	$pdf->Line($x+16,$y-1.5,$x+16,$y);
	$pdf->Line($x+20,$y-1.5,$x+20,$y);
	$pdf->SetY($pdf->GetY()-0.5);
	$pdf->SetFont('Arial','',4);
	$pdf->Cell(40,0,"",0,0,'L');
	$pdf->Cell(24,0,"(sin centavos)",0,0,'C');
	$pdf->Cell(143,0,"",0,1,'C');
	$pdf->Cell($maximo,5,"",'LBR',1,'L');

	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"3. DATOS DE LA VIVIENDA DESTINO DEL CRÉDITO",0,1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LTR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<strlen($calle);$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($calle,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');	
	$pdf->Line($x,$y,$x+160,$y);
	for($i=0;$i<=40;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"   *CALLE",0,1,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=3;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($numero,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Line($x,$y,$x+12,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(5,$es,'',0,0,'L');
	$m +=5;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=3;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($numeroint,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Line($x,$y,$x+12,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(5,$es,'',0,0,'L');
	$m +=5;


	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=3;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($lote,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Line($x,$y,$x+12,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(5,$es,'',0,0,'L');
	$m +=5;


	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=3;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($mza,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Line($x,$y,$x+12,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(5,$es,'',0,0,'L');
	$m +=5;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=20;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($colonia,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Line($x,$y,$x+80,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');



	$pdf->SetFont('Arial','',5);
	$pdf->Cell(2,0,"",0,0,'L');
	$pdf->Cell(22,0,"*No. Ext.",0,0,'L');
	$pdf->Cell(22,0,"No. INT.",0,0,'L');
	$pdf->Cell(20,0,"LOTE",0,0,'L');
	$pdf->Cell(20,0,"MZA.",0,0,'L');
	$pdf->Cell($maximo-91,0,"*COLONIA o FRACCIONAMIENTO",0,1,'L');


	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=17;$i++)
		{			
		$pdf->Cell(3,$es,strtoupper(substr($estado,$i,1)),0,0,'C');
		$m +=3;
		}
	$pdf->Line($x,$y,$x+51,$y);
	for($i=0;$i<=17;$i++)
		{
		$j=3*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(5,$es,'',0,0,'L');
	$m +=5;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=20;$i++)
		{			
		$pdf->Cell(3,$es,strtoupper(substr($municipio,$i,1)),0,0,'C');
		$m +=3;
		}
	$pdf->Line($x,$y,$x+60,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(5,$es,'',0,0,'L');
	$m +=5;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=5;$i++)
		{			
		$pdf->Cell(3,$es,strtoupper(substr($cp,$i,1)),0,0,'C');
		$m +=3;
		}
	$pdf->Line($x,$y,$x+15,$y);
	for($i=0;$i<=5;$i++)
		{
		$j=3*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');


	$pdf->SetFont('Arial','',5);
	$pdf->Cell(2,0,"",0,0,'L');
	$pdf->Cell(60,0,"*ENTIDAD",0,0,'L');
	$pdf->Cell(68,0,"*MUNICIPIO O DELEGACIÓN",0,0,'L');
	$pdf->Cell($maximo-47,0,"*CÓDIGO POSTAL",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,8,"*¿LA VIVIENDA ELEGIDA ES PARA UNA PERSONA CON DISCAPACIDAD?           SÍ                     NO",'LR',0,'L');
	if($discapacidad==0)
		{
		$pdf->SetFillColor(255,255,255);
		$x=$pdf->GetX();
    	$y=$pdf->GetY()+4;
		$pdf->Circle($x-90,$y,1.5,'FD');

		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x-75,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(0,0,0);
		$x=$pdf->GetX();
    	$y=$pdf->GetY()+4;
		$pdf->Circle($x-90,$y,1.5,'FD');

		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x-75,$y,1.5,'FD');
		}
	$pdf->Cell($maximo,$es,"",'LR',1,'L');

	$x=$pdf->GetX();
	$y=$pdf->GetY()+4;
	$pdf->Cell($maximo,8,"*TIPO DE DISCAPACIDAD:               MOTRIZ               AUDITIVA               MENTAL               VISUAL",'LR',1,'L');

	if(strtoupper($tipodiscapacidad)=="MOTRIZ")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+47,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+47,$y,1.5,'FD');
		}

	if(strtoupper($tipodiscapacidad)=="AUDITIVA")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+66,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+66,$y,1.5,'FD');
		}

	if(strtoupper($tipodiscapacidad)=="MENTAL")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+83,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+83,$y,1.5,'FD');
		}


	if(strtoupper($tipodiscapacidad)=="VISUAL")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+100,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+100,$y,1.5,'FD');
		}

	$x=$pdf->GetX();
	$y=$pdf->GetY()+4;
	$pdf->Cell($maximo,8,"*PERSONA QUE PRESENTARÁ COMPROBANTE DE DISCAPACIDAD:   DERECHOHABIENTE SOLICITANTE             CÓNYUGE             PADRE             MADRE             HIJO",'LR',1,'L');

	if(strtoupper($personacapacidad)=="DERECHOHABIENTE SOLICITANTE")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+110,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+110,$y,1.5,'FD');
		}

	if(strtoupper($personacapacidad)=="CÓNYUGE")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+128,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+128,$y,1.5,'FD');
		}

	if(strtoupper($personacapacidad)=="PADRE")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+143,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+143,$y,1.5,'FD');
		}

	if(strtoupper($personacapacidad)=="MADRE")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+158,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+158,$y,1.5,'FD');
		}

	if(strtoupper($personacapacidad)=="HIJO")
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x+171,$y,1.5,'FD');    		
		}
	else
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+171,$y,1.5,'FD');
		}

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,$es,"Nota: En caso de que desee hacer un cambio de vivienda, debe presentar una nueva solicitud de inscripción de crédito.",'LBR',1,'C');

	$pdf->SetFont('Arial','',$fs);	
	$pdf->Cell($maximo,4,"Anotar la cantidad que corresponda según el destino del crédito solicitado:",'LBR',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->SetFillColor(200,200,200);
	$pdf->Cell($maximo/4,4,"Para comprar vivienda",1,0,'C',true);
	$pdf->Cell($maximo/4,4,"Para construir tu vivienda",1,0,'C',true);
	$pdf->Cell($maximo/4,4,"Para reparar, ampliar o mejorar tu vivienda",1,0,'C',true);
	$pdf->Cell($maximo/4,4,"Para pagar el pasivo o la hipoteca de tu vivienda",1,1,'C',true);
	$pdf->Cell($maximo/4,4,"",'L',0,'C');
	$pdf->Cell($maximo/4,4,"",'L',0,'C');
	$pdf->Cell($maximo/4,4,"",'L',0,'C');
	$pdf->Cell($maximo/4,4,"",'LR',1,'C');

	$pdf->SetFont('Arial','',$fs);
	$x=$pdf->GetX()+12;
    $y=$pdf->GetY()+5;
	$pdf->Line($x,$y,$x+21,$y);
	for($i=0;$i<=7;$i++)
		{
		$j=$i*3;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo/4,8,"                $",'L',0,'L');

	$x=$pdf->GetX()+12;
    $y=$pdf->GetY()+5;
	$pdf->Line($x,$y,$x+21,$y);
	for($i=0;$i<=7;$i++)
		{
		$j=$i*3;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo/4,8,"                $",'L',0,'L');

	$x=$pdf->GetX()+12;
    $y=$pdf->GetY()+5;
	$pdf->Line($x,$y,$x+21,$y);
	for($i=0;$i<=7;$i++)
		{
		$j=$i*3;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	#$pdf->Cell($maximo/4,10,"                $",'L',0,'L');
	###########################3
	$pdf->Cell(12,8,"$",'L',0,'R');
	for($i=0;$i<7;$i++)		
		$pdf->Cell(3,7,substr($montopresupuesto,$i,1),0,0,'C');
	$pdf->Cell(11.25,8,"",0,0,'R');
	###############

	$x=$pdf->GetX()+12;
    $y=$pdf->GetY()+5;
	$pdf->Line($x,$y,$x+21,$y);
	for($i=0;$i<=7;$i++)
		{
		$j=$i*3;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo/4,8,"                $",'LR',1,'L');

	$pdf->SetFont('Arial','',4);
	$pdf->SetY($pdf->GetY()-2);
	$pdf->Cell($maximo/4,0,"(sin centavos)",0,0,'C');
	$pdf->Cell($maximo/4,0,"(sin centavos)",0,0,'C');
	$pdf->Cell($maximo/4,0,"(sin centavos)",0,0,'C');
	$pdf->Cell($maximo/4,0,"(sin centavos)",0,1,'C');

	$pdf->Cell($maximo/4,3,"*PRECIO DE COMPRA-VENTA",'L',0,'C');
	$pdf->Cell($maximo/4,3,"*MONTO DEL PRESUPUESTO",'L',0,'C');
	$pdf->Cell($maximo/4,3,"*MONTO DEL PRESUPUESTO",'L',0,'C');
	$pdf->Cell($maximo/4,3,"*MONTO DE LA DEUDA",'LR',1,'C');

	$pdf->Cell($maximo/4,6,"(precio total pactado libremente entre las partes)",'LB',0,'C');
	$pdf->Cell($maximo/4,6,"",'LB',0,'C');
	$pdf->Cell($maximo/4,6,"AFECTACIÓN ESTRUCTURAL    SÍ              NO",'LB',0,'C');
	$x=$pdf->GetX();
	$y=$pdf->GetY();
	if(strtoupper($afectaestructura)==0)
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x-11.8,$y+3,1.5,'FD'); 

		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x-4.8,$y+3,1.5,'FD');   		
		}
	else
		{
		$pdf->SetFillColor(0,0,0);
		$pdf->Circle($x-11.8,$y+3,1.5,'FD'); 

		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x-4.8,$y+3,1.5,'FD');  
		}

	$pdf->Cell($maximo/4,6,"",'LBR',1,'C');


	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"4. DATOS DE LA EMPRESA O PATRÓN",0,1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LTR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=28;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($razonsocialpatron,$i,1)),0,0,'C');
		$m +=4;
		}		
	$pdf->Line($x,$y,$x+112,$y);
	for($i=0;$i<=28;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');

	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<=11;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($rfcpatron,$i,1)),0,0,'C');
		$m +=4;
		}
	$pdf->Line($x,$y,$x+44,$y);
	for($i=0;$i<=11;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(2,0,"",0,0,'L');
	$pdf->Cell(121,0,"*NOMBRE DE LA EMPRESA O PATRÓN",0,0,'L');
	$pdf->Cell(49,0,"*NÚMERO DE REGISTRO PATRONAL (NRP)",0,1,'L');


	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(50,$es,'TELÉFONO DE LA EMPRESA DONDE TRABAJA:',0,0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($telpatron,$i,1)),0,0,'C');
		$m +=4;
		}		
	$pdf->Line($x,$y,$x+12,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<=11;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($telpatron,$i,1)),0,0,'C');
		$m +=4;
		}		
	$pdf->Line($x,$y,$x+44,$y);
	for($i=0;$i<=11;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$x=$pdf->GetX()+8;
    $y=$pdf->GetY()+4.5;
	/*for($i=3;$i<=6;$i++)
		{			
		$pdf->Cell(4,$es,strtoupper(substr($telpatron,$i,1)),0,0,'C');
		$m +=4;
		}	*/	
	$m +=24;
	$pdf->Line($x,$y,$x+24,$y);
	for($i=0;$i<=6;$i++)
		{
		$j=4*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(67,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(53,0,"",0,0,'L');
	$pdf->Cell(16,0,"LADA",0,0,'L');
	$pdf->Cell(48,0,"NÚMERO",0,0,'L');
	$pdf->Cell(49,0,"EXTENSIÓN",0,1,'L');

	$pdf->Cell($maximo,$es,'','LBR',1,'L');



	$pdf->AddPage();
    $pdf->SetMargins(20,8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',$hs);
    $pdf->SetY(20);

    $pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"5. DATOS DE IDENTIFICACIÓN DEL (DE LA) DERECHOHABIENTE / DATOS QUE SERÁN VALIDADOS",0,1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LTR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<11;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($nss,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+38.5,$y);
	for($i=0;$i<=11;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<18;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($curp,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+63,$y);
	for($i=0;$i<=18;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<13;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($rfc,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+45.5,$y);
	for($i=0;$i<=13;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');



	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(43,0,"*NÚMERO DE SEGURIDAD SOCIAL  (NSS)",0,0,'L');
	$pdf->Cell(67,0,"CURP",0,0,'L');
	$pdf->Cell(39,0,"RFC",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($apellidop,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($apellidom,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(74,0,"*APELLIDO PATERNO",0,0,'L');
	$pdf->Cell(67,0,"*APELLIDO MATERNO",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<40;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($nombre,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+140,$y);
	for($i=0;$i<=40;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(100,0,"*NOMBRE (S)",0,1,'L');
	$pdf->Cell($maximo,8,"     *DOMICILIO ACTUAL DEL DERECHOHABIENTE",'LR',1,'L');

	$pdf->SetFont('Arial','',$fs);

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
    $aux=$calle." ".$numero;
	for($i=0;$i<42;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($aux,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+147,$y);
	for($i=0;$i<=42;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(100,0,"*CALLE Y NÚMERO",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($colonia,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($estado,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(75,0,"*COLONIA O FRACCIONAMIENTO",0,0,'L');
	$pdf->Cell(100,0,"*ENTIDAD",0,1,'L');


	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<16;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($municipio,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+56,$y);
	for($i=0;$i<=16;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<5;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($cp,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+17.5,$y);
	for($i=0;$i<=5;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(60,0,"*MUNICIPIO O DELEGACIÓN",0,0,'L');
	$pdf->Cell(100,0,"*CÓDIGO POSTAL",0,1,'L');


	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(15,$es,'*TELÉFONO:',0,0,'L');
	$m=19;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($telefonos,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<11;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($telefonos,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$pdf->Cell(13,$es,'CELULAR:',0,0,'L');
	$m +=17;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($celular,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$pdf->Cell(10,$es,'*GÉNERO:        M             F',0,0,'L');
	$m +=14;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+3;
	if($genero=="M")
		{
		$pdf->SetFillColor(0,0,0);		
		$pdf->Circle($x+11,$y,1.5,'FD');
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+20,$y,1.5,'FD');
		}
	if($genero=="F")
		{
		$pdf->SetFillColor(255,255,255);
		$pdf->Circle($x+11,$y,1.5,'FD');
		$pdf->SetFillColor(0,0,0);	
		$pdf->Circle($x+20,$y,1.5,'FD');
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(28,$es,'CORREO ELECTRÓNICO:',0,0,'L');
	$m=32;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<30;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($email,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+105,$y);
	for($i=0;$i<=30;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$x=$pdf->GetX();
    $y=$pdf->GetY()+3;
	
	$pdf->Cell($maximo,$es,'     *ESTADO CIVIL:  SOLTERO(A)          CASADO(A)          RÉGIMEN PATRIMONIAL DEL MATRIMONIO:     SEPARACIÓN DE BIENES          SPCIEDAD CONYUGAL          SOCIEDAD LEGAL','LBR',1,'L');

	if(strtoupper($ecivil)=="SOLTERO")
		$pdf->SetFillColor(0,0,0);		
	else
		$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+30.5,$y,1.5,'FD');

	if(strtoupper($ecivil)=="CASADO")
		$pdf->SetFillColor(0,0,0);		
	else
		$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+45.5,$y,1.5,'FD');

	if(strtoupper(substr($regimenpat,-5))=="IENES")
		$pdf->SetFillColor(0,0,0);		
	else
		$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+111,$y,1.5,'FD');

	if(strtoupper(substr($regimenpat,-5))=="YUGAL")
		$pdf->SetFillColor(0,0,0);		
	else
		$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+135,$y,1.5,'FD');

	if(strtoupper(substr($regimenpat,-5))=="LEGAL")
		$pdf->SetFillColor(0,0,0);		
	else
		$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+155.5,$y,1.5,'FD');


	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"6. DATOS DE IDENTIFICACIÓN DEL (DE LA) CÓNYUGE (OBLIGATORIOS EN CRÉDITO CONYUGAL) / DATOS QUE SERÁN VALIDADOS",0,1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LTR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<11;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+38.5,$y);
	for($i=0;$i<=11;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<18;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+63,$y);
	for($i=0;$i<=18;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<13;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+45.5,$y);
	for($i=0;$i<=13;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');



	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(43,0,"*NÚMERO DE SEGURIDAD SOCIAL  (NSS)",0,0,'L');
	$pdf->Cell(67,0,"CURP",0,0,'L');
	$pdf->Cell(39,0,"RFC",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(74,0,"*APELLIDO PATERNO",0,0,'L');
	$pdf->Cell(67,0,"*APELLIDO MATERNO",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<40;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+140,$y);
	for($i=0;$i<=40;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(100,0,"*NOMBRE (S)",0,1,'L');
	
	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(15,$es,'*TELÉFONO:',0,0,'L');
	$m=19;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<11;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$pdf->Cell(13,$es,'CELULAR:',0,0,'L');
	$m +=17;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(28,$es,'CORREO ELECTRÓNICO:',0,0,'L');
	$m=32;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<30;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+105,$y);
	for($i=0;$i<=30;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');
	$pdf->Cell($maximo,1,'','LBR',1,'L');

	
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LTR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<28;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+98.5,$y);
	for($i=0;$i<=28;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<11;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+38.5,$y);
	for($i=0;$i<=11;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(102,0,"*NOMBRE DE LA EMPRESA O PATRÓN",0,0,'L');
	$pdf->Cell(80,0,"*NÚMERO DE REGISTRO PATRONAL (NRP)",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(70,$es,'*TELÉFONO DE LA EMPRESA DONDE TRABAJA EL (LA) CÓNYUGE:',0,0,'L');
	$m=74;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<11;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;

	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<6;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+21,$y);
	for($i=0;$i<=6;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell($maximo-$m,$es,'','R',1,'L');
	
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(73,0,"",0,0,'L');
	$pdf->Cell(12,0,"LADA",0,0,'L');
	$pdf->Cell(32,0,"NÚMERO",0,0,'L');
	$pdf->Cell(40,0,"EXT",0,1,'L');
	$pdf->Cell($maximo,2,'','LBR',1,'L');

	$pdf->Ln(3);

	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"7. REFERENCIAS FAMILIARES DEL DERECHOHABIENTE / DATOS QUE SERÁN VALIDADOS",0,1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,2,'','LT',0,'L');
	$pdf->Cell($maximo/2,2,'','LTR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1apellidop,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref2apellidop,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(4,0,"",0,0,'L');
	$pdf->Cell(88,0,"*APELLIDO PATERNO",0,0,'L');
	$pdf->Cell(80,0,"*APELLIDO PATERNO",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,2,'','L',0,'L');
	$pdf->Cell($maximo/2,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1apellidom,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref2apellidom,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(4,0,"",0,0,'L');
	$pdf->Cell(88,0,"*APELLIDO MATERNO",0,0,'L');
	$pdf->Cell(80,0,"*APELLIDO MATERNO",0,1,'L');


	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,2,'','L',0,'L');
	$pdf->Cell($maximo/2,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1nombre,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref2nombre,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(4,0,"",0,0,'L');
	$pdf->Cell(88,0,"*NOMBRE (S)",0,0,'L');
	$pdf->Cell(80,0,"*NOMBRE (S)",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,2,'','L',0,'L');
	$pdf->Cell($maximo/2,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(15,$es,'*TELÉFONO:',0,0,'L');
	$m=19;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1telefono,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<8;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1telefono,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');
	
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(15,$es,'*TELÉFONO:',0,0,'L');
	$m=19;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1telefono,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<8;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1telefono,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(18,0,"",0,0,'L');
	$pdf->Cell(12,0,"LADA",0,0,'L');
	$pdf->Cell(77,0,"NÚMERO",0,0,'L');
	$pdf->Cell(12,0,"LADA",0,0,'L');
	$pdf->Cell(80,0,"NÚMERO",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,2,'','L',0,'L');
	$pdf->Cell($maximo/2,2,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(13,$es,'CELULAR:',0,0,'L');
	$m=17;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1telefono,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');
	
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(13,$es,'CELULAR:',0,0,'L');
	$m=17;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=3;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($ref1telefono,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(17,0,"",0,0,'L');
	$pdf->Cell(89,0,"NÚMERO",0,0,'L');
	$pdf->Cell(80,0,"NÚMERO",0,1,'L');
	$pdf->Cell(($maximo/2),2,'','LB',0,'L');
	$pdf->Cell(($maximo/2),2,'','LBR',1,'L');

	###Página 3

	$pdf->AddPage();
    $pdf->SetMargins(20,8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',$hs);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetY(20);

    $pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"8. DATOS PARA ABONO EN CUENTA DEL CRÉDITO",0,1,'C');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo/2,2,'','LT',0,'L');
	$pdf->Cell($maximo/2,2,'','LTR',1,'L');
	$pdf->Cell($maximo/2,5,'    *DATOS DEL: VENDEDOR Y/O APODERADO DEL VENDEDOR            AGENTE INMOBILIARIO','L',0,'L');
	$x=$pdf->GetX();
    $y=$pdf->GetY()+2;
	$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x-32,$y,1.5,'FD');
	$pdf->Circle($x-6,$y,1.5,'FD');

	$pdf->Cell($maximo/2,5,'DATOS DEL ACREEDOR HIPOTECARIO','LR',1,'C');
	$pdf->SetFont('Arial','',4.5);
	$pdf->Cell($maximo/2,5,'  ADMINISTRADORA DESIGNADA PARA CONSTRUCCIÓN           DERECHOHABIENTE           EMPRENDEDOR','L',0,'L');
	$x=$pdf->GetX();
    $y=$pdf->GetY()+2;
	$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x-42.5,$y,1.5,'FD');
	$pdf->Circle($x-21.5,$y,1.5,'FD');
	$pdf->Circle($x-4,$y,1.5,'FD');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($razonsocialacreditado,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo/2,0,"",0,0,'L');
	$pdf->Cell(4,0,"",0,0,'L');
	$pdf->Cell(100,0,"*NOMBRE O DENOMINACIÓN O RAZÓN SOCIAL",0,1,'L');	

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($administradora,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(4,0,"",0,0,'L');
	$pdf->Cell(100,0,"* NOMBRE O DENOMINACIÓN O RAZÓN SOCIAL",0,1,'L');	

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(8,$es,'*RFC',0,0,'L');
	$m=12;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<13;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($rfcacreditado,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+45.5,$y);
	for($i=0;$i<=13;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$pdf->Cell(8,$es,'*RFC',0,0,'L');
	$m=12;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<13;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($rfcadmin,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+45.5,$y);
	for($i=0;$i<=13;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($nomadmin,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($nombreacreditado,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',4.5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(88,0,"* NOMBRE O DENOMINACIÓN O RAZÓN SOCIAL COMO APARECE  EN EL ESTADO DE CUENTA",0,0,'L');
	$pdf->Cell(80,0,"* NOMBRE O DENOMINACIÓN O RAZÓN SOCIAL COMO APARECE  EN EL ESTADO DE CUENTA",0,1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,"",0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo/2,1,'','L',0,'L');
	$pdf->Cell($maximo/2,1,'','LR',1,'L');
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($clabeadmin,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,'',0,0,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($clabeacreditado,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(($maximo/2)-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(3,0,"",0,0,'L');
	$pdf->Cell(88,0,"* CLAVE  BANCARIA ESTANDARIZADA (CLABE)",0,0,'L');
	$pdf->Cell(80,0,"* CLAVE  BANCARIA ESTANDARIZADA (CLABE)",0,1,'L');

	$pdf->Cell($maximo/2,1,'','LB',0,'L');
	$pdf->Cell($maximo/2,1,'','LBR',1,'L');

	$pdf->Cell($maximo,5,'En caso de existir varios destinatarios de pago y/o acreedores hipotecarios se deberá reimprimir la tercera hoja de esta solicitud para su llenado.',1,1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,1,'','LTR',1,'C');
	$pdf->Cell($maximo,4,'     TITULAR Y CÓNYUGE (EN CASO DE CRÉDITO CONYUGAL)','LR',1,'L');
	$pdf->Cell(58,$es,'     NÚMERO DE CRÉDITO OTORGADO POR INFONAVIT','L',0,'L');
	$m=58;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(4,$es,"",0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');


	$pdf->SetFont('Arial','',5);
	$pdf->Cell(58,0,'',0,0,'L');
	$pdf->Cell($maximo-58,0,"     Sólo para ser llenado en caso de que la vivienda tenga crédito(s)Infonavit vigente(s)",0,1,'L');
	$pdf->Cell($maximo,1,'','LR',1,'C');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(58,$es,'     NÚMERO DE INVENTARIO VIVIENDA RECUPERADA','L',0,'L');
	$m=58;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<12;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+42,$y);
	for($i=0;$i<=12;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');


	$pdf->Cell($maximo,1,'','LR',1,'L');

	$pdf->Cell(59,$es,'     NÚMERO DE CRÉDITO  DE LA ENTIDAD FINANCIERA','L',0,'L');
	$m=59;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"     Sólo aplica cuando el destino del crédito es para pagar el Pasivo o la Hipoteca de tu Vivienda",0,1,'L');
	$pdf->Cell($maximo,2,'','LBR',1,'L');

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"9. DESIGNACIÓN DE REPRESENTANTE (EN SU CASO)",0,1,'C');
	$pdf->Cell($maximo,2,'','LTR',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"     DESIGNO COMO REPRESENTANTE PARA  QUE EN MI (O NUESTRO) NOMBRE Y REPRESENTACIÓN SOLICITE Y TRAMITE LA INSCRIPCIÓN DE CRÉDITO EN LOS TÉRMINOS DE LAS REGLAS APLICABLES:",'LR',1,'L');
	$pdf->Cell($maximo,1,'','LR',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"     APELLIDO PATERNO                                                                                                                    APELLIDO MATERNO",'LR',1,'L');
	$pdf->Cell($maximo,1,'','LR',1,'L');

	$pdf->Cell(4,$es,'','L',0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<40;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+140,$y);
	for($i=0;$i<=40;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"     NOMBRES (S)",'LR',1,'L');
	$pdf->Cell($maximo,1,'','LR',1,'L');

	$pdf->Cell(2,$es,'','L',0,'L');
	$pdf->Cell(11,$es,'TELÉFONO:',0,0,'L');
	$m=13;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<8;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(4,$es,'',0,0,'L');
	$pdf->Cell(10,$es,'CELULAR:',0,0,'L');
	$m +=14;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<12;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+42,$y);
	for($i=0;$i<=12;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"                        LADA                NÚMERO                                                                     NÚMERO                                                                     NÚMERO (CREDENCIAL INE / PASAPORTE)",'LR',1,'L');
	$pdf->Cell($maximo,5,'','LR',1,'L');

	$pdf->Cell(4,1,'','L',0,'L');
	$pdf->Cell(40,1,'','LBR',0,'C');
	$pdf->Cell(10,1,'',0,0,'L');
	$pdf->Cell(40,1,'','LBR',0,'C');
	$pdf->Cell(10,1,'',0,0,'L');
	$pdf->Cell(50,1,'','LBR',0,'C');
	$pdf->Cell($maximo-154,1,'','R',1,'C');


	$pdf->Cell(4,3,'','LB',0,'L');
	$pdf->Cell(40,3,'FIRMA DEL REPRESENTANTE','B',0,'C');
	$pdf->Cell(10,3,'','B',0,'L');
	$pdf->Cell(40,3,'FIRMA DEL FIRMA DEL DERECHOHABIENTE','B',0,'C');
	$pdf->Cell(10,3,'','B',0,'L');
	$pdf->Cell(50,3,'FIRMA DEL CÓNYUGE (Sólo en caso de crédito conyugal)','B',0,'C');
	$pdf->Cell($maximo-154,3,'','BR',1,'C');

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"10. DATOS DE IDENTIFICACIÓN DEL CONTACTO",0,1,'C');
	$pdf->Cell($maximo,1,'','LTR',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(4,$es,'','L',0,'L');
	$m =4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<18;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+63,$y);
	for($i=0;$i<=18;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$pdf->SetFont('Arial','',5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+92,$y-1.5,1.5,'FD');
	$pdf->Circle($x+117,$y-1.5,1.5,'FD');
	$pdf->Circle($x+148,$y-1.5,1.5,'FD');
	$pdf->Cell($maximo-$m,$es,"PROMOTOR DE VENTAS                       EMPRENDEDOR                       AGENTE INMOBILIARIO",'R',1,'L');
	$pdf->Cell($maximo,0,"     *CURP",0,1,'L');
	
	$pdf->Cell($maximo,1,"",'LR',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(4,$es,'','L',0,'L');
	$m =4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<23;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+80.5,$y);
	for($i=0;$i<=23;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(4,$es,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<20;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+70.5,$y);
	for($i=0;$i<=20;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell(87,0,"     *APELLIDO PATERNO",'L',0,'L');
	$pdf->Cell($maximo-75,0,"*APELLIDO MATERNO",0,1,'L');

	$pdf->Cell($maximo,1,"",'LR',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(4,$es,'','L',0,'L');
	$m =4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<40;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+140.5,$y);
	for($i=0;$i<=40;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,'','R',1,'L');

	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo,0,"     *NOMBRE (S)",'LR',1,'L');

	//$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,1,"",'LR',1,'L');

	$pdf->Cell(2,$es,'','L',0,'L');
	$pdf->Cell(12,$es,'*TELÉFONO:',0,0,'L');
	$m=14;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<3;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+10.5,$y);
	for($i=0;$i<=3;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(1,$es,'',0,0,'L');
	$m +=1;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<8;$i++)
		{			
		$pdf->Cell(3.5,$es,'',0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+28,$y);
	for($i=0;$i<=8;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell($maximo-$m,$es,"",'R',1,'L');
	$pdf->Cell($maximo,0,"                           LADA                NÚMERO",'LR',1,'L');

	$pdf->Cell($maximo,1,'','LBR',1,'L');

	$pdf->Cell($maximo,5,'En caso de existir asesor de crédito y/o emprendedor y/o agente inmobiliario se deberá reimprimir la tercera hoja de esta solicitud  para su llenado.',1,1,'C');

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',$hs);
	$pdf->Cell($maximo,$es,"11. OFERTA VINCULANTE",0,1,'C');
	$pdf->Cell($maximo,2,'','LTR',1,'L');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(2,2,'','L',0,'L');
	$pdf->Cell(18,2,'EL SOLICITANTE',0,0,'L');
	$pdf->Cell(50,2,'','B',0,'L');
	$pdf->Cell($maximo-70,2,'REQUIERE UNA OFERTA VINCULANTE por parte del INFONAVIT en el entendido de que al solicitar dicha','R',1,'L');
	$pdf->Cell(2,3,'','L',0,'L');
	$pdf->Cell($maximo-2,3,'oferta vinculante no requiere presentar la documentación solicitada para efectos de la contratación del crédito sino hasta que dicha Oferta Vinculante haya sido aceptada en su totalidad','R',1,'L');
	$pdf->Cell(2,$es,'','L',0,'L');
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	$pdf->SetFillColor(255,255,255);
	$pdf->Circle($x+52,$y-1.5,1.5,'FD');
	$pdf->Circle($x+70,$y-1.5,1.5,'FD');
	$pdf->Cell($maximo-2,$es,'REQUIERO OFERTA VINCULANTE                   SI                        NO','R',1,'L');
	$pdf->MultiCell($maximo,2,'NOTA: El INFONAVIT se obliga a otorgar el crédito a que se refiere esta solicitud, siempre y cuando verifique que los datos proporcionados por el solicitante son veraces y no se modifiquen durante el trámite del crédito y hasta el momento de otorgamiento del mismo.','LR');
	$pdf->Cell($maximo,2,'','LBR',1,'L');
	$pdf->Cell($maximo,2,'',0,1,'L');

	$pdf->MultiCell($maximo,2,'Manifiesto (amos) que: a) todos los datos proporcionados son verdaderos, con pleno conocimiento del artículo 58 de la Ley del Infonavit que a la letra dice “Se reputará como f raude y se sancionará como tal, en los términos del Código Penal Federal, el obtener los créditos o recibir los depósitos a que esta Ley se refiere, sin tener derecho a ello, mediante engaño, simulación o sustitución de persona”. Asimismo,  b) acepto (amos)  incorporar las ecotecnologías que aseguren el ahorro en agua, energía eléctrica y gas, definido por el Infonavit, de acuerdo a mi (nuestro) ingreso salarial.');

	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell(18,$es,'           Ciudad de ',0,0,'L');
	$m=18;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<19;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($lugar,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+66.5,$y);
	for($i=0;$i<=19;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(4,$es,'a',0,0,'C');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<2;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($dia,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+7,$y);
	for($i=0;$i<=2;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(4,$es,'de',0,0,'C');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($mesv,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->Cell(8,$es,'de 20',0,0,'C');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<2;$i++)
		{			
		$pdf->Cell(3.5,$es,substr($anio,$i,1),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+7,$y);
	for($i=0;$i<=2;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}
	$pdf->Cell(1,$es,'',0,1,'C');

	$pdf->Ln(7);

	$pdf->Cell($maximo/4,1,'',0,0,'C');
	$pdf->Cell(($maximo/4)-2,1,'','LBR',0,'C');
	$pdf->Cell(2,1,'',0,0,'C');
	$pdf->Cell(($maximo/4)-2,1,'','LBR',1,'C');
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',5);
	$pdf->Cell($maximo/4,1,'',0,0,'C');
	$pdf->Cell(($maximo/4)-3,1,'FIRMA DEL DERECHOHABIENTE',0,0,'C');
	$pdf->Cell(6,0,'',0,0,'C');
	$pdf->Cell(($maximo/4)-3,1,'FIRMA DEL CÓNYUGE',0,1,'C');

	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$fs);
	$pdf->Cell($maximo,2,'En el Infonavit todos los trámites son gratuitos.','LTR',1,'C');

	$pdf->SetFont('Arial','',5);
	$pdf->MultiCell($maximo,2,'Consulta paso a paso el avance de tu solicitud de crédito en “Mi espacio Infonavit” www.infonavit.org.mx o para cualquier duda o aclaración favor de contactarnos a través de Infonatel al teléfono 91 71 5050 (D.F.) ó 01 800 00 83 900 para el interior de la República, o en cualquiera de nuestras oficinas.','LBR');

$pdf->Output();//muestro el pdf

?>
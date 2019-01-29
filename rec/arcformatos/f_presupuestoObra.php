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
	if($IDL<0)
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
	$anio=substr($val5['fecha'],0,4);	
	$contrato="$dia de ".strtoupper(mes($mes))." de $anio";
	$hoy="$lugar a $dia de ".strtoupper(mes($mes))." de $anio";	
	}
mysqli_free_result($res2);

$csql = "SELECT * from `cat_clientes` WHERE `id` = '$idpersona';";
$res2 = mysqli_query($conexio,$csql);
if($val5=mysqli_fetch_array($res2))
	{			
	$idcli=$val5['idcli'];
		
	$nombre=strtoupper($val5['apellidop']." ".$val5['apellidom']." ".$val5['nombre']);
	$nss=$val5['nss'];
	$rfc=strtoupper($val5['rfc']);
	
	$idproducto=$val5['idproducto'];
	$segundocredito=$val5['segundocredito'];
	$plazocredito=$val5['plazocredito'];
	$calle=strtoupper($val5['calle']);
	$numero=strtoupper($val5['numero']." ".$val5['numero']);
	$lote=$val5['numero'];
	$mza=$val5['numero'];
	$colonia=strtoupper($val5['colonia']);
	$municipio=strtoupper($val5['municipio']);
	$estado=strtoupper($val5['estado']);
	$cp=$val5['cp'];

	$discapacidad=$val5['discapacidad'];
	$tipodiscapacidad=$val5['tipodiscapacidad'];
	$personacapacidad=$val5['personacapacidad'];

	$montopresupuesto=$val5['montopresupuesto'];
	$montopresupuestov=convertir($montopresupuesto);

	$afectaestructura=$val5['afectaestructura'];

	$razonsocialpatron=$val5['razonsocialpatron'];
	$rfcpatron=$val5['rfcpatron'];
	$telpatron=$val5['telpatron'];


	
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
		    	$this->SetMargins(20,8);
		        $this->SetY(8);
		        $this->SetFont('Arial','B',13);
				$this->Cell(175,7,"PRESUPUESTO",0,1,'C');
				$this->SetFont('Arial','',6);
				$this->Cell(175,2,"AMPLIACIÓN, REPARACIÓN O MEJORA DE VIVIENDA",0,1,'C');
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
				/*
				    $this->SetY(-10);
				    $this->Line($this->GetX(),$this->GetY(),$this->GetX()+177,$this->GetY());

				    $this->SetX(10);	
				    $this->SetFont('Arial','',6);
					$this->Cell(15,6,"",0,0,'C');	
					$this->Cell(60,6,"*DATOS OBLIGATORIOS",0,0,'L');
					$this->Cell(60,6,"HOJA ".$this->PageNo()." DE {nb}",0,0,'C');
					$this->Cell(50,6,"CRED 1000.15",0,0,'R');	*/			    				    
				   # $this->Cell(15,10,$this->PageNo().'/{nb}',0,0,'C');
				}

		}
	$hs=7;
	$fs=6;
	$es=4;
	$maximo=175;	
	$pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(20,8);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',11);
    $pdf->SetY(18);
    $pdf->Cell($maximo,$es,"CARATULA",0,1,'C');
    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell($maximo,$es,"DATOS DEL DERECHOHABIENTE:",'LTR',1,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(15,$es,"NOMBRE:",'L',0,'L');
   	$pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(80,$es,$nombre,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(7,$es,"NSS:",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(20,$es,$nss,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(7,$es,"RFC:",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(20,$es,$rfc,'B',0,'L');
    $pdf->Cell($maximo-159,$es,"",'R',1,'L');
    $pdf->Cell($maximo,2,"",'LR',1,'L');

    $pdf->SetFont('Arial','',5);
    $pdf->Cell(15,0,'',0,0,'L');
    $pdf->Cell(80,0,"APELLIDO PATERNO     MATERNO      NOMBRE(S)",0,1,'L');
    
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell($maximo,$es,"DOMICILIO:",'LR',1,'L');
    $pdf->Cell(17,$es,"CALLE Y NUM:",'L',0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo-22,$es,$calle." ".$numero,'B',0,'L');
    $pdf->Cell(5,$es,"",'R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(15,$es,"COLONIA:",'L',0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(110,$es,$colonia,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(7,$es,"C.P.",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo-144,$es,$cp,'B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(30,$es,"DELEGACIÓN O MUNICIPIO:",'L',0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(90,$es,$municipio,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(12,$es,"ESTADO:",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo-144,$es,$estado,'B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');
    $pdf->Cell($maximo,2,"",'LBR',1,'L');

    $pdf->Ln(2);

    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell($maximo,$es,"IDENTIFICACIÓN DE LOS TRABAJOS A REALIZAR:",'LTR',1,'L');############
    $pdf->SetFont('Arial','',$fs);
    
    $pdf->Cell($maximo/2,5,"CON AFECTACIÓN ESTRUCTURAL",'L',0,'L');
    $x=$pdf->GetX()-20;
    $y=$pdf->GetY();
    if($afectaestructura==0)
    	{
    	$pdf->SetFillColor(255,255,255);
    	$pdf->Rect($x,$y,10,5,'FD');
    	$pdf->SetFillColor(0,0,0);
		$pdf->Rect($x+70,$y,10,5,'FD');
		}
    else
    	{
    	$pdf->SetFillColor(0,0,0);
    	$pdf->Rect($x,$y,10,5,'FD');
    	$pdf->SetFillColor(255,255,255);
		$pdf->Rect($x+70,$y,10,5,'FD');
		}	
    $pdf->Cell($maximo/2,5,"SIN AFECTACIÓN ESTRUCTURAL",'R',1,'L');

    $pdf->Cell($maximo,2,'','LR',1,'L');

    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo/2,6,"1) AMPLIACIÓN Y/O REPARACIÓN",'L',0,'L');
    $x=$pdf->GetX()-20;
    $y=$pdf->GetY();
   	$pdf->SetFillColor(255,255,255);
    $pdf->Rect($x,$y,10,5,'FD');
    $pdf->SetFont('Arial','',$fs);
    $pdf->MultiCell($maximo/2,3,"TRABAJOS QUE AFECTAN ELEMENTOS ESTRUCTURALES A CARGO DE UN CONSTRUCTOR QUE PRESENTE EL RESPALDO DE UN D.R.O.",'R');

    $pdf->Cell(17,$es,"CONSTRUCTOR:",'L',0,'L');
    $pdf->Cell(106,$es,"",'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(10,$es,"No. REG.",0,0,'L');
    $pdf->Cell($maximo-145,$es,'','B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->Cell(17,$es,"D.R.O. O PERITO:",'L',0,'L');
    $pdf->Cell(106,$es,"",'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(10,$es,"No. REG.",0,0,'L');
    $pdf->Cell($maximo-145,$es,'','B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->Cell($maximo,2,'','LR',1,'L');

    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo/2,6,"2) TERMINACIÓN DE VIVIENDA",'L',0,'L');
    $x=$pdf->GetX()-20;
    $y=$pdf->GetY();
   	$pdf->SetFillColor(255,255,255);
    $pdf->Rect($x,$y,10,5,'FD');
    $pdf->SetFont('Arial','',5.5);
    $pdf->MultiCell($maximo/2,3,"TRABAJOS QUE PERMITAN QUE LA VIVIENDA PRESENTE CONDICIONES DE HABITABILIDAD A CARGO DE UN CONSTRUCTOR CON O SIN AFECTACIÓN ESTRUCTURAL",'R');

    $pdf->Cell(17,$es,"CONSTRUCTOR:",'L',0,'L');
    $pdf->Cell(106,$es,"",'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(10,$es,"No. REG.",0,0,'L');
    $pdf->Cell($maximo-145,$es,'','B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->Cell(17,$es,"D.R.O. O PERITO:",'L',0,'L');
    $pdf->Cell(106,$es,"",'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(10,$es,"No. REG.",0,0,'L');
    $pdf->Cell($maximo-145,$es,'','B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->Cell($maximo,2,'','LR',1,'L');

    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo/2,6,"3) MEJORAMIENTO DE VIVIENDA",'L',0,'L');
    $x=$pdf->GetX()-20;
    $y=$pdf->GetY();
   	$pdf->SetFillColor(0,0,0);
    $pdf->Rect($x,$y,10,5,'FD');
    $pdf->SetFont('Arial','',5);
    $pdf->MultiCell($maximo/2,3,"TRABAJOS QUE MEJORAN EL FUNCIONAMIENTO Y ASPECTO DE LA VIVIENDA SIN AFECTAR ELEMENTOS ESTRUCTURALES A CARGO DEL DERECHOHABIENTE DE UN EMPRENDEDOR O",'R');

    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo,$es,"RESPONSABLE DE LA EJECUCIÓN DE LOS TRABAJOS:",'LR',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(50,$es,"DERECHOHABIENTE:",'L',0,'L');
    $x=$pdf->GetX()-20;
    $y=$pdf->GetY();
   	$pdf->SetFillColor(255,255,255);
    $pdf->Rect($x,$y,10,3,'FD');
    $pdf->Cell($maximo-50,$es,'','R',1,'L');

    $pdf->Cell(17,$es,"CONSTRUCTOR:",'L',0,'L');
    $x=$pdf->GetX()+13;
    $y=$pdf->GetY();
   	$pdf->SetFillColor(0,0,0);
    $pdf->Rect($x,$y,10,3,'FD');
    $pdf->Cell(111,$es,"",0,0,'L');
    $pdf->Cell(10,$es,"No. REG.",0,0,'L');
    $pdf->Cell($maximo-145,$es,'','B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->Cell(17,$es,"EMPRENDEDOR:",'L',0,'L');
    $x=$pdf->GetX()+13;
    $y=$pdf->GetY();
   	$pdf->SetFillColor(255,255,255);
    $pdf->Rect($x,$y,10,3,'FD');
    $pdf->Cell(111,$es,"",0,0,'L');
    $pdf->Cell(10,$es,"CURP",0,0,'L');
    $pdf->Cell($maximo-145,$es,'','B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->Cell($maximo,$es,"SE ANEXA REPORTE FOTOGRÁFICO QUE AMPARA LA SITUACIÓN INICIAL DE LA VIVIENDA ANTES DE LA REALIZACIÓN DE ESTOS TRABAJOS",'LBR',1,'L');

   	$pdf->Ln(2);

    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell($maximo,$es,"UBICACIÓN DE LA VIVIENDA:",'LTR',1,'L');############
    
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(15,$es,"CALLE:",'L',0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(110,$es,$calle,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(7,$es,"No.",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo-144,$es,$numero,'B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(15,$es,"COLONIA:",'L',0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(110,$es,$colonia,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(7,$es,"C.P.",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo-144,$es,$cp,'B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(30,$es,"DELEGACIÓN O MUNICIPIO:",'L',0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell(90,$es,$municipio,'B',0,'L');
    $pdf->Cell(5,$es,"",0,0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(12,$es,"ESTADO:",0,0,'L');
    $pdf->SetFont('Arial','B',$fs);
    $pdf->Cell($maximo-144,$es,$estado,'B',0,'L');
    $pdf->Cell(7,$es,"",'R',1,'L');
    $pdf->Cell($maximo,2,"",'LBR',1,'L');

    $pdf->Ln(2);

    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell($maximo,$es,"RESUMEN DEL PRESUPUESTO:",'LTR',1,'L');
    $pdf->Cell($maximo,$es,'','LR',1,'L');

    $pdf->Cell(120,$es,'PARTIDA','L',0,'C');
    $pdf->Cell(33,$es,'IMPORTE (NETO)',0,0,'C');
    $pdf->Cell(17,$es,'PORCENTAJE',0,0,'C');
    $pdf->Cell(5,$es,'','R',1,'C');

    $subtotal=0;
    $csql = "SELECT * from `cat_clientespto` WHERE `idcliente` = '$idpersona';";
	$res2 = mysqli_query($conexio,$csql);
	if($val5=mysqli_fetch_array($res2))
		{			
		$subtotal +=$val5['permisos'];
		$permisos=fixmontosin($val5['permisos']);
		$porpermisos=fixmontosin(($val5['permisos']*100)/$montopresupuesto,2);
		
		$subtotal +=$val5['preliminares'];
		$preliminares=fixmontosin($val5['preliminares']);
		$porpreliminares=fixmontosin(($val5['preliminares']*100)/$montopresupuesto,2);

		$subtotal +=$val5['cimentacion'];
		$cimentacion=fixmontosin($val5['cimentacion']);
		$porcimentacion=fixmontosin(($val5['cimentacion']*100)/$montopresupuesto,2);

		$subtotal +=$val5['estructura'];
		$estructura=fixmontosin($val5['estructura']);
		$porestructura=fixmontosin(($val5['estructura']*100)/$montopresupuesto,2);

		$subtotal +=$val5['albanileria'];
		$albanileria=fixmontosin($val5['albanileria']);
		$poralbanileria=fixmontosin(($val5['albanileria']*100)/$montopresupuesto,2);

		$subtotal +=$val5['hidrosanitaria'];
		$hidrosanitaria=fixmontosin($val5['hidrosanitaria']);
		$porhidrosanitaria=fixmontosin(($val5['hidrosanitaria']*100)/$montopresupuesto,2);

		$subtotal +=$val5['electrica'];
		$electrica=fixmontosin($val5['electrica']);
		$porelectrica=fixmontosin(($val5['electrica']*100)/$montopresupuesto,2);

		$subtotal +=$val5['especiales'];
		$especiales=fixmontosin($val5['especiales']);
		$porespeciales=fixmontosin(($val5['especiales']*100)/$montopresupuesto,2);

		$subtotal +=$val5['acabados'];
		$acabados=fixmontosin($val5['acabados']);
		$poracabados=fixmontosin(($val5['acabados']*100)/$montopresupuesto,2);

		$subtotal +=$val5['pintura'];
		$pintura=fixmontosin($val5['pintura']);
		$porpintura=fixmontosin(($val5['pintura']*100)/$montopresupuesto,2);

		$subtotal +=$val5['herreria'];
		$herreria=fixmontosin($val5['herreria']);
		$porherreria=fixmontosin(($val5['herreria']*100)/$montopresupuesto,2);

		$subtotal +=$val5['carpinteria'];
		$carpinteria=fixmontosin($val5['carpinteria']);
		$porcarpinteria=fixmontosin(($val5['carpinteria']*100)/$montopresupuesto,2);

		$subtotal +=$val5['imperme'];
		$imperme=fixmontosin($val5['imperme']);
		$porimperme=fixmontosin(($val5['imperme']*100)/$montopresupuesto,2);
		
		$subtotal +=$val5['limpieza'];
		$limpieza=fixmontosin($val5['limpieza']);
		$porlimpieza=fixmontosin(($val5['limpieza']*100)/$montopresupuesto,2);

		$subtotalv=fixmontosin($subtotal);
		$porsubtotal=fixmontosin(($subtotal*100)/$montopresupuesto,2);

		$subtotal +=$val5['honorarios'];
		$honorarios=fixmontosin($val5['honorarios']);
		$porhonorarios=fixmontosin(($val5['honorarios']*100)/$montopresupuesto,2);

		$subtotal +=$val5['otros'];
		$otros=fixmontosin($val5['otros']);
		$porotros=fixmontosin(($val5['otros']*100)/$montopresupuesto,2);

		$totalv=fixmontosin($subtotal);
		$portotal=fixmontosin(($subtotal*100)/$montopresupuesto,2);	
		}
	mysqli_free_result($res2);



    $pdf->SetFont('Arial','',$hs);

    $pdf->Cell(120,$es,'1. PERMISOS Y LICENCIAS (EN SU CASO)','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$permisos,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porpermisos,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'2. PRELIMINARES (EN SU CASO)','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$preliminares,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porpreliminares,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'3. CIMENTACIÓN (SOLO APLICA PARA INCISO 1)','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$cimentacion,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porcimentacion,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(21,$es,'4. ESTRUCTURA','L',0,'L');
    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(99,$es,'(MUROS, LOSAS, CASTILLOS, ETC. SOLO APLICA PARA INCISO 1)',0,0,'L');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$estructura,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porestructura,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'5. ALBAÑILERIA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$albanileria,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$poralbanileria,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'6. INSTALACIÓN HIDRO-SANITARIA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$hidrosanitaria,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porhidrosanitaria,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'7. INSTALACIÓN ELÉCTRICA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$electrica,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porelectrica,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'8. INSTALACIONES ESPECIALES (GAS, TELÉFONO, ETC.)','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$especiales,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porespeciales,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'9. ACABADOS','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$acabados,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$poracabados,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'10. PINTURA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$pintura,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porpintura,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'11. HERRERÍA Y VENTANERÍA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$herreria,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porherreria,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'12. CARPNTERÍA Y CERRAJERÍA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$carpinteria,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porcarpinteria,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'13. IMPERMEBILIZACIÓN','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$imperme,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porimperme,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'14. LIMPIEZA','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$limpieza,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porlimpieza,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->SetFillColor(180,180,180);
    $pdf->Cell(120,$es,'SUBTOTAL','L',0,'C',true);
    $pdf->Cell(2,$es,'$',0,0,'L',true);
    $pdf->Cell(26,$es,$subtotalv,'B',0,'R',true);
    $pdf->Cell(5,$es,'',0,0,'L',true);
    $pdf->Cell(14,$es,$porsubtotal,'B',0,'R',true);
    $pdf->Cell(8,$es,'%','R',1,'L',true);

    $pdf->Cell(120,$es,'15. HONORARIOS PRESTADOR DE SERVICIOS (INCLUYE IVA)','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$honorarios,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porhonorarios,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'16. OTROS (ECOTECNOLOGÍAS)','L',0,'L');
    $pdf->Cell(2,$es,'$',0,0,'L');
    $pdf->Cell(26,$es,$otros,'B',0,'R');
    $pdf->Cell(5,$es,'',0,0,'L');
    $pdf->Cell(14,$es,$porotros,'B',0,'R');
    $pdf->Cell(8,$es,'%','R',1,'L');

    $pdf->Cell(120,$es,'TOTAL','L',0,'C',true);
    $pdf->Cell(2,$es,'$',0,0,'L',true);
    $pdf->Cell(26,$es,$totalv,'B',0,'R',true);
    $pdf->Cell(5,$es,'',0,0,'L',true);
    $pdf->Cell(14,$es,$portotal,'B',0,'R',true);
    $pdf->Cell(8,$es,'%','R',1,'L',true);

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(40,$es+1,'IMPORTE CON LETRA:','L',0,'R');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(125,$es+1,$montopresupuestov,'B',0,'L');
    $pdf->Cell(10,$es+1,'','R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(40,$es+1,'LUGAR Y FECHA:','L',0,'R');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(125,$es+1,$hoy,'B',0,'L');
    $pdf->Cell(10,$es+1,'','R',1,'L');

    $pdf->Cell($maximo,2,'','LBR',1,'L');

    $pdf->Ln(2);

    $pdf->SetFont('Arial','B',$hs);
    $pdf->Cell($maximo,$es,"AUTORIZACIONES:",'LTR',1,'L');
    $pdf->Cell($maximo,12,'','LR',1,'L');
    $pdf->Cell(20,$es,'','L',0,'L');
    $pdf->Cell(50,$es,'','B',0,'L');
    $pdf->Cell(30,$es,'',0,0,'L');
    $pdf->Cell(50,$es,'','B',0,'L');
    $pdf->Cell($maximo-150,$es,'','R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $pdf->Cell(20,$es-1,'','L',0,'L');
    $pdf->Cell(50,$es-1,'NOMBRE Y FIRMA DEL DERECHOHABIENTE',0,0,'C');
    $pdf->Cell(30,$es-1,'',0,0,'L');
    $pdf->Cell(50,$es-1,'NOMBRE Y FIRMA DEL PRESTADOR DE',0,0,'C');
    $pdf->Cell($maximo-150,$es-1,'','R',1,'L');

    $pdf->Cell(100,$es-1,'','LB',0,'L');
    $pdf->Cell(50,$es-1,'SERVICIOS EN SU CASO','B',0,'C');
    $pdf->Cell($maximo-150,$es-1,'','BR',1,'L');

    ##página 2
    /*
    $pdf->AddPage();
    $pdf->SetMargins(20,8);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',11);
    $pdf->SetY(18);
    $pdf->Cell($maximo,$es,"DESGLOSE DEL PRESUPUESTO",0,1,'C');
    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell($maximo,2,'','LTR',1,'L');

    $pdf->Cell($maximo/2,5,"CON AFECTACIÓN ESTRUCTURAL",'L',0,'L');
    $x=$pdf->GetX()-20;
    $y=$pdf->GetY();
    if($afectaestructura==0)
    	{
    	$pdf->SetFillColor(255,255,255);
    	$pdf->Rect($x,$y,10,4,'FD');
    	$pdf->SetFillColor(0,0,0);
		$pdf->Rect($x+70,$y,10,4,'FD');
		}
    else
    	{
    	$pdf->SetFillColor(0,0,0);
    	$pdf->Rect($x,$y,10,4,'FD');
    	$pdf->SetFillColor(255,255,255);
		$pdf->Rect($x+70,$y,10,4,'FD');
		}	
    $pdf->Cell($maximo/2,5,"SIN AFECTACIÓN ESTRUCTURAL",'R',1,'L');

    $pdf->SetFont('Arial','',$fs);
    $x=$pdf->GetX();
    $y=$pdf->GetY();
    $pdf->SetFillColor(255,255,255);
    $pdf->Rect($x+36,$y,10,4,'FD');
    $pdf->Rect($x+92,$y,10,4,'FD');
    $pdf->SetFillColor(0,0,0);
    $pdf->Rect($x+153,$y,10,4,'FD');
    $pdf->Cell($maximo/3,$es,"1) AMPLICACIÓN/REPARACIÓN",'L',0,'L');
    $pdf->Cell($maximo/3,$es,"2) TERMINACIÓN DE VIVIENDA",0,0,'L');
    $pdf->Cell($maximo/3,$es,"3) MEJORAMIENTO DE VIVIENDA",'R',1,'L');

    $pdf->SetFont('Arial','',$hs);
    $pdf->Cell(100,$es+2,"PARTICIPACIÓN DE UN CONSTRUCTOR",'LB',0,'L');
    $x=$pdf->GetX();
    $y=$pdf->GetY()+1;
    $pdf->SetFillColor(0,0,0);
    $pdf->Rect($x+5,$y,10,4,'FD');
    $pdf->SetFillColor(255,255,255);
    $pdf->Rect($x+37,$y,10,4,'FD');
    $pdf->Cell(30,$es+2,"SÍ",'B',0,'L');
    $pdf->Cell(30,$es+2,"NO",'B',0,'L');
    $pdf->Cell($maximo-160,$es+2,"",'BR',1,'L');

   	$pdf->Ln(2);

  	$pdf->SetFont('Arial','',$hs);
    $pdf->Cell($maximo/2,$es,"PARTICIPACIÓN DE UN CONSTRUCTOR",'LB',0,'L');
    
*/

    $pdf->Output();//muestro el pdf

?>
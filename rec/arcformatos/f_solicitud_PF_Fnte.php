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
	$idtipoproducto=$val5['idtipoproducto'];
	$iddestino=$val5['iddestino'];
	$segundocredito=$val5['segundocredito'];
	$plazocredito=$val5['plazocredito'];
	$calle=$val5['calle'];
	$numero=$val5['numero'];
	$numeroint=$val5['numeroint'];
	$lote=$val5['lote'];
	$mza=$val5['mza'];
	$colonia=strtoupper($val5['colonia']);
	$municipio=strtoupper($val5['municipio']);
	$estado=strtoupper($val5['estado']);
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
	$genero=strtoupper($val5['genero']);

	$dia=substr($val5['nacimiento'],8,2);
	$mes=substr($val5['nacimiento'],5,2);
	$anio=substr($val5['nacimiento'],0,4);	
	$nacimiento="$mes/$dia/$anio";

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


	### Generaci0n de PDF

	
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

			function SetDash($black=false, $white=false)
			    {
			        if($black and $white)
			            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
			        else
			            $s='[] 0 d';
			        $this->_out($s);
			    }


		    
		    /*function Header()
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
		    }*/

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
					$this->Cell(60,6,"",0,0,'L');
					$this->Cell(60,6,"HOJA ".$this->PageNo()." DE {nb}",0,0,'C');
					$this->Cell(50,6,"",0,0,'R');				    				    
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
    $pdf->SetY(10);
    $pdf->SetFont('Arial','B');
    $pdf->Cell($maximo,$es,"SOLICITUD DE SERVICIO FIDUCIARIO",0,1,'C');

    $pdf->SetFont('Arial','B',$fs);
    $pdf->SetFillColor(207,207,207);
    $pdf->Cell(177,$es,"DATOS DEL FIDEICOMITENTE",1,1,'C',true);
    $pdf->ln(2);

    $pdf->SetFont('Arial','');
	$pdf->Cell(30,4,"Apellido Paterno",0,0,"L");
	$pdf->Cell(30,4,"Apellido Materno",0,0,"L");
	$pdf->Cell(30,4,"Nombre(s)",0,0,"L");
	$pdf->Cell(7,4,"",0,0,"L");
	$pdf->Cell(60,4,"Registro Federal de Causantes (10 posiciones):",0,0,"L");
	$pdf->Cell(27,4,"Homoclave:",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(30,4,$apellidop,1,0,"C");
	$pdf->Cell(30,4,$apellidom,1,0,"C");
	$pdf->Cell(30,4,$nombre,1,0,"C");
	$pdf->Cell(5,4,"",0,0,"C");

	$pdf->Cell(4,4,'',0,0,'L');
	$m=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;
	for($i=0;$i<10;$i++)
		{			
		$pdf->Cell(3.5,$es,strtoupper(substr($rfc,$i,1)),0,0,'C');
		$m +=3.5;
		}		
	$pdf->Line($x,$y,$x+35,$y);
	for($i=0;$i<=10;$i++)
		{
		$j=3.5*$i;
		$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
		}

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(21,4,"-",0,0,"C");

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(4,4,'',0,0,'L');
	$m +=4;
	$x=$pdf->GetX();
    $y=$pdf->GetY()+4.5;	
		for($i=0;$i<1;$i++)
			{			
			$pdf->Cell(3.5,$es,strtoupper(substr($rfc,-3,1)),0,0,'C');
			}		
		for($i=0;$i<1;$i++)
			{			
			$pdf->Cell(3.5,$es,strtoupper(substr($rfc,-2,1)),0,0,'C');
			}	
		for($i=0;$i<1;$i++)
			{			
			$pdf->Cell(3.5,$es,strtoupper(substr($rfc,-1,1)),0,0,'C');
			}				
		$pdf->Line($x,$y,$x+10.5,$y);
		for($i=0;$i<=3;$i++)
			{
			$j=3.5*$i;
			$pdf->Line($x+$j,$y-1.5,$x+$j,$y);
			}
		$pdf->Cell($maximo-$m,5,'','R',1,'L');

	$pdf->SetFont('Arial','');
	$pdf->Cell(25,4,"G�nero",0,0,"L");
	$pdf->Cell(25,4,"Tipo de identificaci�n",0,0,"L");
	$pdf->Cell(25,4,"No. de identificaci�n",0,0,"L");
	$pdf->Cell(15,4,"",0,0,"L");
	$pdf->Cell(97,4,"C.U.R.P.",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(25,4,$genero,1,0,"C");
	$pdf->Cell(25,4,"INE",1,0,"C");
	$pdf->Cell(25,4,"",1,0,"C");
	$pdf->Cell(12,4,"",0,0,"C");
	
	$pdf->Cell(4,4,'',0,0,'L');
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

	$pdf->Ln(5);
	
	$pdf->SetFont('Arial','');
	$pdf->Cell(59,4,"Fecha de nacimiento",0,0,"L");
	$pdf->Cell(59,4,"Entidad de nacimiento",0,0,"L");
	$pdf->Cell(59,4,"",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(59,4,$nacimiento,1,0,"C");
	$pdf->Cell(59,4,"MEXICANA",1,0,"C");
	$pdf->Cell(59,4,"",1,1,"C");
	$pdf->Ln(1);

	$pdf->SetFont('Arial','');
	$pdf->Cell(118,4,"N�mero de identificaci�n  fiscal (En caso de ser extranjero)",0,0,"L");
	$pdf->Cell(59,4,"Pa�s que expidi�",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(118,4,"",1,0,"C");
	$pdf->Cell(59,4,"",1,1,"C");
	$pdf->Ln(1);
	
	$pdf->SetFont('Arial','');
	$pdf->Cell(44,4,"Tel�fono Particular (clave lada + n�mero)",0,0,"L");
	$pdf->Cell(44,4,"Tel�fono Oficina (clave lada + n�mero)",0,0,"L");
	$pdf->Cell(44,4,"Tel�fono celular",0,0,"L");
	$pdf->Cell(45,4,"Correo electr�nico",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(14,4,"(  ".substr($telefonos,-10,2)."  )",1,0,"C");
	$pdf->Cell(30,4,substr($telefonos,-8,8),1,0,"C");
	$pdf->Cell(14,4,"(  ".substr("",-10,2)."  )",1,0,"C");
	$pdf->Cell(30,4,substr("",-8,8),1,0,"C");
	$pdf->Cell(44,4,$celular,1,0,"C");
	$pdf->Cell(45,4,$email,1,1,"C");
	$pdf->Ln(1);
	
	$pdf->SetFont('Arial','');
	$pdf->Cell(44,4,"Profesi�n",0,0,"L");
	$pdf->Cell(44,4,"Ocupaci�n",0,0,"L");
	$pdf->Cell(44,4,"Fuente principal de ingresos",0,0,"L");
	$pdf->Cell(45,4,"Firma electr�nica",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(44,4,"ASALARIADO",1,0,"C");
	$pdf->Cell(44,4,"EMPLEADO",1,0,"C");
	$pdf->Cell(44,4,"SALARIO",1,0,"C");
	$pdf->Cell(45,4,"",1,1,"C");
	$pdf->Ln(1);
	
	$pdf->SetFont('Arial','');
	$pdf->Cell(50,4,"Procedencia de los recursos fideicomitidos",0,0,"L");
	$pdf->Cell(68,4,"",0,0,"L");
	$pdf->Cell(9,4,"",0,0,"L");
	$pdf->Cell(50,4,"",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(50,4,"APORTACIONES INFONAVIT",1,0,"C");
	$pdf->Cell(68,4,"�Ocupa o ha ocupado alg�n puesto pol�tico?          S� (     ) No (  X  )",0,0,"L");
	$pdf->Cell(9,4,"�Cu�l?",0,0,"L");
	$pdf->Cell(50,4,"",1,1,"L");
	$pdf->Ln(1);
	
	$pdf->SetFont('Arial','');
	$pdf->Cell(177,4,"Estado Civil:",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(177,4,"Soltero(a) (  X  )     Casado(a) (     )     Sociedad Conyugal (     )     Separaci�n de Bienes (     )     Uni�n Libre (     )     Otro (     ) ",1,1,"C");
	$pdf->Ln(1);

	$pdf->SetFont('Arial','');
	$pdf->Cell(29,4,"Domicilio Fiscal",0,0,"L");
	$pdf->Cell(30,4,"�Corresponde a su domicilio particular?",0,0,"L");
	$pdf->Cell(59,4,"(  X  ) S�",0,0,"C");
	$pdf->Cell(59,4,"(     ) No",0,1,"C");
	$pdf->Ln(1);

	$pdf->SetFont('Arial','');
	$pdf->Cell(118,4,"Calle:",0,0,"L");
	$pdf->Cell(29.5,4,"N�mero Interior:",0,0,"L");
	$pdf->Cell(29.5,4,"N�mero Exterior:",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(118,4,$calle,1,0,"C");
	$aux="";
	if($numeroint!="")
		$aux .=$numeroint;
	if($lote!="")
		{
		if($aux=="")
			$aux .="lt $lote";
		else
			$aux .=", lt $lote";
		}
	if($mza!="")
		{
		if($aux=="")
			$aux .="mz $mza";
		else
			$aux .=", mz $mza";
		}
	$pdf->Cell(29.5,4,$aux,1,0,"C");
	$pdf->Cell(29.5,4,$numero,1,1,"C");
	$pdf->Ln(1);

	$pdf->SetFont('Arial','');
	$pdf->Cell(50,4,"Colonia:",0,0,"L");
	$pdf->Cell(50,4,"Delegaci�n o Municipio:",0,0,"L");
	$pdf->Cell(50,4,"Estado:",0,0,"L");
	$pdf->Cell(27,4,"C�digo Postal:",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(50,4,$colonia,1,0,"C");
	$pdf->Cell(50,4,$municipio,1,0,"C");
	$pdf->Cell(50,4,$estado,1,0,"C");
	$pdf->Cell(27,4,$cp,1,1,"C");
	$pdf->Ln(1);

	$pdf->SetFont('Arial','BU');
	$pdf->Cell(177,4,"Domicilio Particular, llenar s�lo en caso de ser diferente al domicilio fiscal",0,1,"L");
	
	$pdf->SetFont('Arial','');
	$pdf->Cell(118,4,"Calle:",0,0,"L");
	$pdf->Cell(29.5,4,"N�mero Interior:",0,0,"L");
	$pdf->Cell(29.5,4,"N�mero Exterior:",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(118,4,$calle,1,0,"C");
	$pdf->Cell(29.5,4,$aux,1,0,"C");
	$pdf->Cell(29.5,4,$numero,1,1,"C");
	$pdf->Ln(1);

	$pdf->SetFont('Arial','');
	$pdf->Cell(50,4,"Colonia:",0,0,"L");
	$pdf->Cell(50,4,"Delegaci�n o Municipio:",0,0,"L");
	$pdf->Cell(50,4,"Estado:",0,0,"L");
	$pdf->Cell(27,4,"C�digo Postal:",0,1,"L");

	$pdf->SetFont('Arial','');
	$pdf->Cell(50,4,$colonia,1,0,"C");
	$pdf->Cell(50,4,$municipio,1,0,"C");
	$pdf->Cell(50,4,$estado,1,0,"C");
	$pdf->Cell(27,4,$cp,1,1,"C");
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',$es);
	$pdf->SetFillColor(207,207,207);
	$pdf->Cell(177,4,"B - RECURSOS DE LA CUENTA",0,1,'L',true);

	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(177,3,"I. Propietario real de los recursos",0,1,'L');

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(100,3,"Los recursos que se van a manejar en la cuenta son propios o provienen de un tercero",0,0,'L');	
	$pdf->Cell(4,3,"",1,0,'C');
	$pdf->Cell(12,3,"Propios",0,0,'C');
	$pdf->Cell(12,3,"",0,0,'C');
	$pdf->Cell(4,3,"X",1,0,'C');	
	$pdf->Cell(15,3,"Terceros",0,1,'L');	
	$pdf->Ln(2);
	$pdf->Cell(177,1,"Nota: En caso de existir un tercero o propietario real de los recursos (sea persona f�sica o moral), deber� entregarse la documentaci�n comprobatoria tanto de la identificaci�n como del",0,1,'L');
	$pdf->Cell(177,4,"domicilio, as� como proporcionar la informaci�n adicional que le requiera el promotor a trav�s de un cuestionario.",0,1,'L');
	$pdf->Ln(0);

	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(177,4,"II. Origen y destino de los recursos",0,1,'L');

	$pdf->SetDash(0.5,0.5);
	$pdf->Cell(114,50,"",1,0);
	$pdf->Cell(63,50,"",1,0);
	$pdf->Ln(0);

	$pdf->SetDash(0,0);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(118,4,"Origen de los recursos:",0,0,'L');
	$pdf->Cell(59,4,"Destino de los recursos:",0,1,'L');
	$pdf->Cell(30,4,"Patrimonio /Ahorro",0,0,'R');
	$pdf->Cell(20,4,"X",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Rifas, premios, sorteos",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(19,4,"",0,0,'L');
	$pdf->Cell(30,4,"Administraci�n de Gastos e Ingresos",0,0,'R');
	$pdf->Cell(10,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Venta de Negocio",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Comisiones",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(19,4,"",0,0,'L');
	$pdf->Cell(30,4,"Concertaci�n de Fondos",0,0,'R');
	$pdf->Cell(10,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Beca",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Honorarios",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(19,4,"",0,0,'L');
	$pdf->Cell(30,4,"Cr�dito",0,0,'R');
	$pdf->Cell(10,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Bono Laboral",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Inversi�n",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(19,4,"",0,0,'L');
	$pdf->Cell(30,4,"Cuenta de Inversi�n",0,0,'R');
	$pdf->Cell(10,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Venta de Inmuebles",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Rentas",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(19,4,"",0,0,'L');
	$pdf->Cell(30,4,"Pago Proveedores",0,0,'R');
	$pdf->Cell(10,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Sueldo",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Rifas, premios, sorteos",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(19,4,"",0,0,'L');
	$pdf->Cell(10,4,"Otro, Especifique",0,0,'R');
	$pdf->Cell(30,4,"",'B',1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Venta de Activos",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Sueldos",0,0,'R');
	$pdf->Cell(20,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Liquidaci�n o finiquito",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(30,4,"Venta de productos/ servicios",0,0,'R');
	$pdf->Cell(20,4,"",1,1,'L');
	$pdf->Ln(1);

	$pdf->Cell(30,4,"Jubilaciones y Pensiones",0,0,'R');
	$pdf->Cell(20,4,"",1,0,'L');
	$pdf->Cell(9,4,"",0,0,'L');
	$pdf->Cell(20,4,"Otro, Especifique ",0,0,'R');
	$pdf->Cell(30,4,"",'B',1,'L');
	$pdf->Ln(3);

	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(20,4,"TIPO",0,0,'R');
	$pdf->Cell(156,4,"",'B',1,'L');
	$pdf->Ln(1);

	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(20,4,"OBJETO",0,0,'R');
	$pdf->Cell(156,4,"",'B',1,'L');
	$pdf->Ln(1);

	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(20,4,"PATRIMONIO",0,0,'R');
	$pdf->Cell(156,4,"",'B',1,'L');
	$pdf->Ln(5);

	$pdf->SetFont('Arial','B',$es);
	$pdf->SetFillColor(207,207,207);
	$pdf->Cell(177,4,"DECLARACIONES IMPORTANTES DEL FIDEICOMITENTE",1,1,'C',true);

	$pdf->Cell(177,22,"",1,0,'J');
	$pdf->Ln(2);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(3,0,"1.- ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(22,0,"EL FIDEICOMITENTE ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(152,0,"tiene conocimiento de que el llenado y entrega de esta solicitud no compromete al Grupo Financiero BX+( en adelante BX+) a otorgar ning�n tipo de servicio.",0,1,'J');
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(11,0,"2.- Declara ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(22,0,"EL FIDEICOMITENTE ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(74,0,"que los datos e informaci�n proporcionada es correcta y ver�dica, y  autoriza a ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(5,0,"BX+",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(65,0,"a verificarla en las ocasiones que se consideren pertinentes.",0,1,'J');
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(3,0,"3.- ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(22,0,"EL FIDEICOMITENTE ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(10,0,"autoriza a ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(5,0,"BX+ ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(137,0,"a conservar y utilizar para los fines de su objeto la presente solicitud y/o informaci�n contenida en la misma, en la que se conoce el aviso de ",0,1,'J');
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(13,0,"privacidad de ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(5,0,"BX+, ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(106,0,"y se da por enterado de que puede consultar modificaciones o actualizaciones al mismo en la p�gina de internet ",0,0,'J');
	$pdf->SetFont('Arial','B',$fs);
	$pdf->Cell(53,0,"www.vepormas.com.mx.",0,0,'J');
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(3,0,"4.- ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(22,0,"EL FIDEICOMITENTE ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(152,0,"declara que los fondos y/o bienes que pondr� a disposici�n para que se proporcionen los servicios fiduciarios ser�n de su propiedad y provendr�n de fuentes ",0,1,'J');
	$pdf->Ln(3);
	$pdf->Cell(177,0,"licitas.",0,1,'J');
	$pdf->Ln(3);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(3,0,"5.- ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(22,0,"EL FIDEICOMITENTE ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(10,0,"informa a ",0,0,'J');
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(5,0,"BX+ ",0,0,'J');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(137,0,"que ________ (SI/NO) ha estado desempe�ando en el �ltimo a�o funciones p�blicas destacadas en el territorio nacional o internacional en: ",0,1,'J');
	$pdf->Ln(3);

	$pdf->Cell(177,132,"",1,0,'J');
	$pdf->Ln(2);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,0,"gobiernos federales, estatales, municipales, organismos judiciales, partidos pol�ticos, o puestos de alta jerarqu�a en empresas estatales o en el �mbito militar. En la aceptaci�n o negaci�n ",0,1,'J');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,0,"de esta declaraci�n deber�n considerarse c�nyuge, concubina, concubinario, y las personas con las que mantenga parentesco por consanguinidad o afinidad hasta en segundo grado.",0,1,'J');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,0,"6. En este acto de manera expresa el firmante autoriza a BX+ para que pueda verificar con el Sistema de Administraci�n Tributaria (SAT) que la clave en el RFC y los datos de ",0,1,'J');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,0,"identificaci�n del firmante, correspondan a los que el SAT tiene registrados en su base de datos.  As� mismo, autoriza a Bx+ para que incluya la clave del RFC validada o proporcionada ",0,1,'J');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,0,"por el SAT en los estados de cuenta, declaraciones o avisos de los diversos productos contratados con Bx+, para dar cumplimiento a lo establecido en las fracciones V, IX y X del Art. ",0,1,'J');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,0,"32-B del C�digo Fiscal de la Federaci�n para 2014.",0,1,'J');
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,2,"7. �Desempe�a de manera habitual o profesional alguna de las siguientes actividades?",0,1,'J');

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(80,3,"",0,0,'L');
	$pdf->Cell(4,3,"S�",0,0,'L');
	$pdf->Cell(4,3,"No",0,0,'L');
	$pdf->Cell(79,3,"",0,0,'L');
	$pdf->Cell(4,3,"S�",0,0,'L');
	$pdf->Cell(4,3,"No",0,1,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');

	$pdf->Cell(79.5,3,"a) �Aquellas vinculadas con apuesta, concursos o sorteos?",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');
	$pdf->Cell(78.5,3,"i) �Prestaci�n  de servicios de blindaje de veh�culos terrestres, nuevos o usados,",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,1,'L');
	$pdf->Cell(121,3,"as� como de bienes inmuebles?",0,0,'R');
	$pdf->Cell(0.5,3,"",0,1,'L');

	$pdf->Cell(80,3,"b) �Emisi�n o comercializaci�n de tarjetas que constituyan instrumentos de",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,1,'L');
	$pdf->Cell(80,3,"almacenamiento de valor monetario?",0,0,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');
	$pdf->Cell(80,-3,"j) �Prestaci�n de servicios de traslado o custodia de dinero o valores, con",0,0,'R');
	$pdf->Cell(6.5,3,"",0,0,'L');
	$pdf->Cell(4,-3,"",1,0,'R');
	$pdf->Cell(4,-3,"X",1,1,'R');
	$pdf->Cell(157,9,"excepci�n de aquellos en los que intervenga BANXICO e instituciones",0,1,'R');
	$pdf->Cell(123,-3,"dedicadas al dep�sito de valores?",0,0,'R');
	$pdf->Cell(0.5,0,"",0,1,'L');

	$pdf->Cell(80,3,"c) �Emisi�n y comercializaci�n habitual o profesional de cheques de viajero?",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');
	$pdf->Cell(78.5,3,"k) �Prestaci�n de servicios de fe p�blica (Notarios o corredores p�blicos )?",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,4,"",0,1,'L');

	$pdf->Cell(80,3,"d) �Ofrecimiento de operaciones de mutuo o de garant�a o de otorgamiento",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,1,'L');
	$pdf->Cell(80,3,"de pr�stamos o cr�ditos?",0,0,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');
	$pdf->Cell(86.5,-3,"l) �Prestaci�n de servicios profesionales, sin relaci�n laboral, en los casos en los",0,0,'R');
	$pdf->Cell(4,-3,"",1,0,'R');
	$pdf->Cell(4,-3,"X",1,1,'R');
	$pdf->Cell(164.5,9,"que se prepare para un cliente o se lleven a cabo en nombre y representaci�n",0,1,'R');
	$pdf->Cell(169.5,-3,"del cliente: compraventa de bienes inmuebles o la cesi�n de derechos sobre estos;",0,1,'R');
	$pdf->Cell(162,9,"administraci�n y manejo de recursos, valores o cualquier otro activo de sus",0,1,'R');
	$pdf->Cell(166,-3,"clientes; manejo de cuentas bancarias, de ahorro o de valores; organizaci�n de",0,1,'R');
	$pdf->Cell(163.5,9,"aportaciones de capital o cualquier otro tipo de recursos para la constituci�n,",0,1,'R');
	$pdf->Cell(167,-3,"operaci�n y administraci�n de sociedades mercantiles, o;  constituci�n, escisi�n,",0,1,'R');
	$pdf->Cell(168,9,"fusi�n, operaci�n y administraci�n de personas morales o veh�culos corporativos,",0,1,'R');
	$pdf->Cell(156.5,-3,"incluido el fideicomiso y la compra o venta de entidades mercantiles?",0,0,'R');
	$pdf->Cell(0.5,0,"",0,1,'L');

	$pdf->Cell(80,3,"e) �Prestaci�n de servicios de construcci�n o desarrollo de bienes inmuebles o",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,3,"",0,1,'L');
	$pdf->Cell(80,3,"de intermediaci�n en la transmisi�n de la propiedad o constituci�n de derechos",0,1,'L');
	$pdf->Cell(80,3,"sobre dichos bienes, en los que se involucren operaciones de compra o venta de",0,1,'L');
	$pdf->Cell(80,3,"los propios bienes, por cuenta o a favor de clientes de quienes presten dichos",0,1,'L');
	$pdf->Cell(80,3,"servicios?",0,0,'L');
	
	$pdf->Cell(88.5,-21,"m) �Recepci�n de donativos, por parte de las asociaciones y sociedades sin         ",0,0,'R');
$x=$pdf->GetX();
$y=$pdf->GetY();	
	$pdf->Cell(-1.5,3,"",0,0,'R');
	$pdf->Cell(4,3,"",0,0,'R');
	$pdf->Cell(4,3,"",0,1,'R');
	$pdf->Cell(105,-21,"fines de lucro?",0,0,'R');
	$pdf->Cell(0.5,0,"",0,1,'R');

$x2=$pdf->GetX();
$y2=$pdf->GetY();
	$pdf->SetX($x);
	$pdf->SetY($y-12);
	$pdf->Cell(167,3,"",0,0,'R');
	$pdf->Cell(4,3,"",1,0,'R');
	$pdf->Cell(4,3,"X",1,1,'R');
	$pdf->SetX($x2);
	$pdf->SetY($y2);

	$pdf->Cell(80,3,"f) �La comercializaci�n o intermediaci�n habitual o profesional de Metales",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,3,"",0,1,'L');
	$pdf->Cell(80,3,"Preciosos, Piedras Preciosas, joyas o relojes?",0,0,'L');
	$pdf->Cell(82,-3,"n) �Prestaci�n de servicios de comercio exterior como agente o apoderado",0,0,'R');
	$pdf->Cell(5,0,"",0,0,'R');
	$pdf->Cell(4,-3,"",1,0,'R');
	$pdf->Cell(4,-3,"X",1,1,'R');
	$pdf->Cell(167.5,9,"aduanal, mediante autorizaci�n otorgada por la SHCP, para promover por cuenta",0,1,'R');
	$pdf->Cell(165,-3,"ajena, el despacho de la siguientes mercanc�as: veh�culos terrestres, a�reos y",0,1,'R');
	$pdf->Cell(163.5,9,"mar�timos; m�quinas para juegos de apuesta y sorteos; equipos y materiales",0,1,'R');
	$pdf->Cell(161.5,-3,"para la elaboraci�n de tarjetas de pago; joyas, relojes, Piedras Preciosas y",0,1,'R');
	$pdf->Cell(162.5,9,"Metales Preciosos; obras de arte; materiales de resistencia bal�stica para la",0,1,'R');
	$pdf->Cell(137.5,-3,"prestaci�n de servicios de blindaje de veh�culos?",0,0,'R');
	$pdf->Cell(0.5,1,"",0,1,'L');

	$pdf->Cell(80,3,"g) �La subasta o comercializaci�n de obras de arte?",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');
	$pdf->Cell(78,3,"o) �Constituci�n de derechos personales de uso o goce de bienes inmuebles?",0,0,'L');
	$pdf->Cell(0.5,3,"",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,4,"",0,1,'L');

	$pdf->Cell(80,3,"h) �Comercializaci�n o distribuci�n de veh�culos, nuevos o usados, ya sean",0,0,'L');
	$pdf->Cell(4,3,"",1,0,'L');
	$pdf->Cell(4,3,"X",1,0,'L');
	$pdf->Cell(0.5,3,"",0,1,'L');
	$pdf->Cell(80,3,"a�reos, mar�timos o terrestres?",0,1,'L');
	$pdf->Ln(10);

	$pdf->Cell(15,3,"",0,0,"C");
	$pdf->Cell(59,3,"Nombre y firma del fideicomitente",'T',0,"C");
	$pdf->Ln(5);

	$pdf->SetFont('Arial','B',$es);
	$pdf->SetFillColor(207,207,207);
	$pdf->Cell(177,4,"AVISO DE PRIVACIDAD DE GRUPO FINANCIERO VE POR M�S",1,1,'C',true);

	$pdf->Cell(177,105,"",1,0,'J');
	$pdf->Ln(1);

	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(177,3,"Grupo Financiero Ve por M�s, (en adelante �BX+�), en congruencia con su pol�tica de privacidad, as� como con su objetivo de delimitar los alcances y condiciones generales del",0,1,'J');
	$pdf->Cell(177,3,"tratamiento a los datos personales, acorde a la Ley Federal de Protecci�n de Datos Personales en Posesi�n de los Particulares (en adelante la �Ley�), su reglamento y dem�s",0,1,'J');
	$pdf->Cell(177,3,"normatividad aplicable, al respecto le informa lo siguiente:",0,1,'J');
	$pdf->Cell(177,3,"El responsable, es decir la persona que recibe y trata los datos personales que se captan por cualquier medio de los reconocidos en el presente aviso, Grupo Financiero Ve por M�s,",0,1,'J');
	$pdf->Cell(177,3,"instituci�n financiera debidamente autorizada por las leyes mexicanas, con domicilio en Avenida Paseo de la Reforma n�mero 365 Colonia Cuauht�moc, Delegaci�n Cuauht�moc, C.P.",0,1,'J');
	$pdf->Cell(177,3,"06500, en M�xico, Distrito Federal.",0,1,'J');
	$pdf->Cell(177,3,"1. �Para qu� fines utilizaremos sus datos personales?",0,1,'J');
	$pdf->Cell(177,3,"Sus datos personales ser�n tratados para la existencia y cumplimiento de las obligaciones derivadas de la relaci�n jur�dica entre �BX+� y usted, las cuales son:",0,1,'J');
	$pdf->Cell(177,3,"Finalidades primordiales: (i) La realizaci�n de todas y cada una de las operaciones y la prestaci�n de los servicios que otorga �BX+�; (ii) La celebraci�n de los actos que se deban o",0,1,'J');
	$pdf->Cell(177,3,"puedan realizar conforme a las disposiciones legales aplicables y los estatutos sociales de �BX+�; (iii) La creaci�n e implementaci�n de procesos anal�ticos y estad�sticos necesarios o",0,1,'J');
	$pdf->Cell(177,3,"convenientes relacionados con dichas operaciones, servicios y actos; (iv) La atenci�n de requerimientos de cualquier jurisdiccional; (v) La realizaci�n de cualquier actividad",0,1,'J');
	$pdf->Cell(177,3,"complementaria o auxiliar necesaria para la realizaci�n de los fines anteriores;",0,1,'J');
	$pdf->Cell(177,3,"Finalidades secundarias: (vi) La realizaci�n de consultas, investigaciones y revisiones en relaci�n a cualquier queja o aclaraci�n; (vii) La puesta en contacto con usted para tratar cualquier",0,1,'J');
	$pdf->Cell(177,3,"tema relacionado con la relaci�n jur�dica que exista con �BX+�; y (viii) La puesta en contacto con usted para tratar cualquier tema relacionado con sus datos personales o con el presente",0,1,'J');
	$pdf->Cell(177,3,"Aviso de Privacidad, (ix) La puesta en contacto con usted para ofrecerle nuevos productos que pudieran ser de su inter�s. (x) Conocer su opini�n respecto al lanzamiento de alg�n nuevo",0,1,'J');
	$pdf->Cell(177,3,"producto.",0,1,'J');
	$pdf->Cell(177,3,"En caso de que no desee que sus datos personales sean tratados, usted nos puede comunicar lo anterior, conforme a lo establecido en nuestro aviso de privacidad integral, mismo que se",0,1,'J');
	$pdf->Cell(177,3,"encuentra en la p�gina de internet www.vepormas.com.mx",0,1,'J');
	$pdf->Cell(177,3,"2. �Qu� datos personales utilizamos para los fines anteriores?",0,1,'J');
	$pdf->Cell(177,3,"Para prestarle los servicios y/o productos  que le ofrece �BX+�, requerimos (i) Datos de identificaci�n y/o de contacto; (ii) Datos laborales; (iii) referencias personales y comerciales, (iv)",0,1,'J');
	$pdf->Cell(177,3,"Datos financieros y/o patrimoniales, y (v) Datos de tr�nsito y movimientos migratorios.",0,1,'J');
	$pdf->Cell(177,3,"3. Procedimiento para el ejercicio de sus derechos ARCO.",0,1,'J');
	$pdf->Cell(177,3,"Usted tiene derecho a acceder a sus datos personales que poseemos y a los detalles del tratamiento de los mismos, as� como a rectificarlos en caso de ser inexactos o incompletos,",0,1,'J');
	$pdf->Cell(177,3,"cancelarlos cuando considere que no se requieren para algunas de las finalidades se�aladas en el presente Aviso de Privacidad, est�n siendo utilizados para finalidades no consentidas o",0,1,'J');
	$pdf->Cell(177,3,"haya finalizado la relaci�n contractual o de servicio, o bien oponerse al tratamiento de los mismos para fines espec�ficos.",0,1,'J');
	$pdf->Cell(177,3,"Los mecanismos que se han implementado para el ejercicio de dichos derechos, son los que se indican a trav�s del Aviso de Privacidad integral, mismo que se encuentra en la p�gina de",0,1,'J');
	$pdf->Cell(177,3,"internet  www.vepormas.com.mx",0,1,'J');
	$pdf->Cell(177,3,"4. Cambios al presente Aviso de Privacidad.",0,1,'J');
	$pdf->Cell(177,3," �BX+� se compromete a mantenerlo informado sobre los cambios que pueda sufrir el presente Aviso de Privacidad, a trav�s de la p�gina de internet  www.vepormas.com.mx",0,1,'J');
	$pdf->Cell(177,3,"He le�do y estoy de acuerdo con los t�rminos del Aviso de Privacidad.",0,1,'J');
	$pdf->Ln(10);

	$pdf->Cell(15,4,"",0,0,"C");
	$pdf->Cell(59,4,"Nombre y firma del fideicomitente",'T',0,"C");
	$pdf->Ln(7);

	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(20,3,"Lugar:",0,0,'R');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(40,3,$lugar,'B',0,"C");
	$pdf->Cell(10,$es,"",0,0,"C");
	$pdf->SetFont('Arial','B',$es);
	$pdf->Cell(20,3,"Fecha de la solicitud:",0,0,'R');
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(10,3,$dia,'B',0,"C");
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,3,"/",0,0,"C");
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(30,3,$mesv,'B',0,"C");
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,3,"/",0,0,"C");
	$pdf->SetFont('Arial','',$es);
	$pdf->Cell(15,3,$anio,'B',1,"C");

	$pdf->Cell(245,3,"D  D                                  M  M                                   A  A  A  A",0,0,"C");

$pdf->Output();//muestro el pdf

?>
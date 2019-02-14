<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");

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
	$IDL=permiso("AdminClientesExp",$IDU);
	
	
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
		else
			{
			$_SESSION['vida']=time();
			session_write_close();
			}
		}	
	}
else
	{	
	header("location:../index.php");
	header("Cache-control: private");
	die();
	} 
	
if(isset($_GET['idcli']))	
	$idcli=$_GET['idcli'];
else 
	$idcli="";
if(isset($_GET['nombre']))	
	$nombre=$_GET['nombre'];
else 
	$nombre="";	
if(isset($_GET['rfc']))	
	$rfc=$_GET['rfc'];
else 
	$rfc="";
	
if(isset($_GET['estado']))	
	$estado=$_GET['estado'];
else 
	$estado="";
if($estado=="")
	$estadov="Todo";
else
	$estadov=$estado;
if(isset($_GET['integradora']))	
	$integradora=$_GET['integradora'];
else 
	$integradora="";
if($integradora=="")
	$integradorav="Todo";
else
	$integradorav=$integradora;

if(isset($_GET['asesor']))	
	$asesor=$_GET['asesor'];
else 
	$asesor="";
if($asesor=="")
	$asesorv="Todo";
else
	$asesorv=$asesor;
if(isset($_GET['fecha1']))
	$fecha1=$_GET['fecha1'];
else
	$fecha1="";

if(isset($_GET['fecha2']))
	$fecha2=$_GET['fecha2'];
else
	$fecha2="";

if($fecha1=="")
	$fecha1v="todo";
else
	$fecha1v=fixfecha($fecha1);

if($fecha2=="")
	$fecha2v="todo";
else
	$fecha2v=fixfecha($fecha2);
if($fecha1v==$fecha2v)
	$fechav=$fecha1v;
else
	$fechav=$fecha1v." - ".$fecha2v;

if(isset($_GET['status']))
	$status=$_GET['status'];
else
	$status="0";
if($status=="0")
	$statusv="Todo";
else
	$statusv=traedato("cat_statuscliente","id",$status,"S","descripcion");


#####################################	
$consulta = "SELECT a.id,a.idcli,a.nombre,a.apellidop,a.apellidom,a.nacimiento,a.rfc,a.curp,a.nss,a.genero,a.email,a.telefonos,a.oficina,a.celular,a.ecivil,a.nacionalidad,a.ref1nombre,a.ref1apellidop,a.ref1apellidom,a.ref1telefono,a.ref2nombre,a.ref2apellidop,a.ref2apellidom,a.ref2telefono,a.callef,a.numerof,a.numerointf,a.lotef,a.mzaf,a.coloniaf,a.municipiof,a.estadof,a.cpf,a.calle,a.numero,a.numeroint,a.lote,a.mza,a.colonia,a.municipio,a.estado,a.cp,b.descripcion as banco,a.cuenta,a.clabe,a.beneficiario,a.razonsocialpatron,a.rfcpatron,a.telpatron,a.valorampliacion,a.valorregla,a.valorneto,a.montopresupuesto,a.afectaestructura,a.asesor,a.integradora,c.razonsocial as constructora,d.razonsocial as verificadora,a.fecha,a.owner,a.status,e.descripcion as statusv    
 FROM `cat_clientes` a 
 left join cat_instituciones as b on a.idbanco=b.id 
 left join cat_entidades as c on a.idconstructora=c.id 
 left join cat_entidades as d on a.idverificadora=d.id 
 left join cat_statuscliente as e on a.status=b.id
  where a.id>0 ";
		$consultaT1="";
		$consultaT2="";
		$consultaT3="";
		$consultaT4="";
		$consultaT5="";
		$consultaT6="";
		$consultaT7="";
		$consultaT8="";
		$consultaT9="";

		if($idcli!="")
			$consultaT1 .="(cast(a.idcli as SIGNED) = '$idcli' ) ";
		if($nombre!="")
			$consultaT2 .="(a.apellidop like '%$nombre%' or a.apellidom like '%$nombre%' or a.nombre like '%$nombre%' ) ";			
		if($rfc!="")
			$consultaT3 .="(a.rfc = '$rfc' ) ";	
		if($estado!="")
			$consultaT4 .="( a.estadof='$estadof' ) ";
		if($integradora!="")
			$consultaT5 .="( a.integradora='$integradora' ) ";
		if($asesor!="")
			$consultaT6 .="( a.asesor='$asesor' ) ";
		if($fecha1!="")
			$consultaT7 .="( a.fecha>='$fecha1 00:00:01' ) ";
		if($fecha2!="")
			$consultaT8 .="( a.fecha<='$fecha2 23:59:59' ) ";
		if($status!="0")
			$consultaT9 .="(a.status = '$status' ) ";

			
		$consulta2="";
		if($consultaT1!="")
			$consulta2 .="AND ".$consultaT1;
		if($consultaT2!="")
			$consulta2 .="AND ".$consultaT2;
		if($consultaT3!="")
			$consulta2 .="AND ".$consultaT3;
		if($consultaT4!="")
			$consulta2 .="AND ".$consultaT4;
		if($consultaT5!="")
			$consulta2 .="AND ".$consultaT5;
		if($consultaT6!="")
			$consulta2 .="AND ".$consultaT6;
		if($consultaT7!="")
			$consulta2 .="AND ".$consultaT7;
		if($consultaT8!="")
			$consulta2 .="AND ".$consultaT8;
		if($consultaT9!="")
			$consulta2 .="AND ".$consultaT9;
			
if(isset($_GET['orden']))	
	$orden=$_GET['orden'];
else 
	$orden="eco asc";

if(isset($_GET['orden']))
	$orden=$_GET['orden'];
else
	$orden="cast(idcli as SIGNED) asc";

$consulta .=$consulta2."ORDER BY ".$orden;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=clientes_".date("Y-m-d").".xls" );
header('Pragma: no-cache');
header('Expires: 0');

$result_excel = mysqli_query($conexio,$consulta);
if($result_excel)
    {
    echo "\nConsulta de Clientes (".date("Y-m-d").")\n";
    echo "\nID:\t$idcli";
    echo "\nRFC:\t$rfc";
    echo "\nIntegradora:\t$integradorav";
    echo "\nFecha:\t$fechav";
    echo "\nNombre:\t$nombre";
    echo "\nEstado:\t$estadov";
    echo "\nAsesor:\t$asesorv";
    echo "\nStatus:\t$statusv\n\n";

    echo "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tReferencia 1\t\t\t\tReferencia 2\t\t\t\tDomicilio Fiscal\t\t\t\t\t\t\t\t\tDomicilio Particular\n";
    echo "ID\tNombre\tApellido paterno\tApellido materno\tFecha nacimiento\tEdad\tRFC\tCURP\tNSS\tGénero\tE-mail\tTeléfono\tTeléfono oficina\tCelular\tEstado civil\tNacionalidad\tNombre\tApellido paterno\tApellido materno\tTeléfono\tNombre\tApellido paterno\tApellido materno\tTeléfono\tCalle\tNúmero exterior\tNúmero interior\tLote\tManzana\tColonia\tDelegación/Municipio\tEstado\tCP\tCalle\tNúmero exterior\tNúmero interior\tLote\tManzana\tColonia\tDelegación/Municipio\tEstado\tCP\tInstitución bancaria\tCuenta\tCLABE\tBeneficiario\tNombre de la empresa o patrón\tNúmero de registro patronal (NRP)\tTeléfono empresa\tValor ampliación\tMonto según reglas\tSolicitante cuenta con\tMonto presupuesto\tAfectación estructural\tAsesor\tIntegradora\tConstructora\tVerificadora\tCaptura\tCreador\tStatus\n";

	
	while($val=mysqli_fetch_array($result_excel))
		{
		$idcli=$val['idcli'];
		$nombre=$val['nombre'];
		$apellidop=$val['apellidop'];
		$apellidom=$val['apellidom'];
		$nacimiento=$val['nacimiento'];
		$edad=calcular_edad($nacimiento);
		$rfc=$val['rfc'];
		$curp=$val['curp'];
		$nss=$val['nss'];
		$genero=$val['genero'];
		$email=$val['email'];
		$telefonos=$val['telefonos'];
		$oficina=$val['oficina'];
		$celular=$val['celular'];
		$ecivil=$val['ecivil'];
		$nacionalidad=$val['nacionalidad'];
		$ref1nombre=$val['ref1nombre'];
		$ref1apellidop=$val['ref1apellidop'];
		$ref1apellidom=$val['ref1apellidom'];
		$ref1telefono=$val['ref1telefono'];
		$ref2nombre=$val['ref2nombre'];
		$ref2apellidop=$val['ref2apellidop'];
		$ref2apellidom=$val['ref2apellidom'];
		$ref2telefono=$val['ref2telefono'];
		$callef=$val['callef'];
		$numerof=$val['numerof'];
		$numerointf=$val['numerointf'];
		$lotef=$val['lotef'];
		$mzaf=$val['mzaf'];
		$coloniaf=$val['coloniaf'];
		$municipiof=$val['municipiof'];
		$estadof=$val['estadof'];
		$cpf=$val['cpf'];		
		$calle=$val['calle'];
		$numero=$val['numero'];
		$numeroint=$val['numeroint'];
		$lote=$val['lote'];
		$mza=$val['mza'];
		$colonia=$val['colonia'];
		$municipio=$val['municipio'];
		$estado=$val['estado'];
		$cp=$val['cp'];
		$banco=$val['banco'];
		$cuenta=$val['cuenta'];
		$clabe=$val['clabe'];
		$beneficiario=$val['beneficiario'];
		$razonsocialpatron=$val['razonsocialpatron'];
		$rfcpatron=$val['rfcpatron'];
		$telpatron=$val['telpatron'];
		$valorampliacion=$val['valorampliacion'];
		$valorregla=$val['valorregla'];
		$valorneto=$val['valorneto'];
		$montopresupuesto=$val['montopresupuesto'];
		if($val['afectaestructura']==0)
			$afectaestructura="NO";
		if($val['afectaestructura']==1)
			$afectaestructura="SÍ";
		$asesor=$val['asesor'];
		$integradora=$val['integradora'];
		$constructora=$val['constructora'];
		$verificadora=$val['verificadora'];
		$fecha=$val['fecha'];
		$owner=$val['owner'];
		$status=traedato("cat_statuscliente","id",$val['status'],"S","descripcion");

		echo "$idcli\t$nombre\t$apellidop\t$apellidom\t$nacimiento\t$edad\t$rfc\t$curp\t$nss\t$genero\t$email\t$telefonos\t$oficina\t$celular\t$ecivil\t$nacionalidad\t$ref1nombre\t$ref1apellidop\t$ref1apellidom\t$ref1telefono\t$ref2nombre\t$ref2apellidop\t$ref2apellidom\t$ref2telefono\t$callef\t$numerof\t$numerointf\t$lotef\t$mzaf\t$coloniaf\t$municipiof\t$estadof\t$cpf\t$calle\t$numero\t$numeroint\t$lote\t$mza\t$colonia\t$municipio\t$estado\t$cp\t$banco\t$cuenta\t$clabe\t$beneficiario\t$razonsocialpatron\t$rfcpatron\t$telpatron\t$valorampliacion\t$valorregla\t$valorneto\t$montopresupuesto\t$afectaestructura\t$asesor\t$integradora\t$constructora\t$verificadora\t$fecha\t$owner\t$status\n";
		}
	mysqli_free_result($result_excel);

	}
else
    {
    echo "No hay datos a exportar.";
    }
			
?>
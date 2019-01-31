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
	$IDL=permiso("AdminClientes",$IDU);
	$IDL2=permiso("AdminClientesArc",$IDU);
	$IDL3=permiso("AdminClientesFor",$IDU);
	$IDL4=permiso("AdminClientesLog",$IDU);
	$IDL5=permiso("AdminClientesCom",$IDU);
	$IDL6=permiso("AdminClientesInt",$IDU);
	$IDL7=permiso("AdminClientesAse",$IDU);
	$IDL8=permiso("AdminClientesPto",$IDU);
	$IDL9=permiso("AdminClientesCon",$IDU);
	$IDL10=permiso("AdminClientesVer",$IDU);

	if($IDL<0)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
		exit();
		}
	if($IDL<2)
		{
		echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su nivel de acceso es insuficiente para acceder.'); window.close();\"></body></html>";
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
############

function asigna($variable)
	{
	if(isset($_POST[$variable]))
		return $_POST[$variable];
	else
		return "";
	}

if(isset($_GET['id']))
	$id=$_GET['id'];
else
	{
	if(isset($_POST['id']))
		$id=$_POST['id'];
	else
		{ #va a ser nuevo		
		$id=-1;
		}
	}

$numopeauto=traedato("adm_parametros","parametro","numopeauto","N","valor");	
if($numopeauto<0)
	{
	echo "Error al tratar de recuperar información de configuración";
	exit();
	}

if(isset($_POST['accion']))	
	{	
	$accion=$_POST['accion'];
	if($accion==1)
		{
		#1. Guardamos.	
		#1.1 Validaciones y asignamos variables
		$idcli=asigna("idcli");
		
		$nombre=$_POST['nombre'];
		$apellidop=$_POST['apellidop'];
		$apellidom=$_POST['apellidom'];
		$nacimiento=$_POST['nacimiento'];
		$ecivil=$_POST['ecivil'];
		$nss=$_POST['nss'];
		//$escolaridad=$_POST['escolaridad'];
		$escolaridad="";
		$calle=$_POST['calle'];
		$numero=$_POST['numero'];
		$numeroint=$_POST['numeroint'];
		$lote=$_POST['lote'];
		$mza=$_POST['mza'];
		$colonia=$_POST['colonia'];
		$municipio=$_POST['municipio'];
		$estado=$_POST['estado'];
		$cp=$_POST['cp'];
		$rfc=$_POST['rfc'];
		$curp=$_POST['curp'];
		$celular=$_POST['celular'];
		$oficina=$_POST['oficina'];
		$telefonos=$_POST['telefonos'];
		$email=$_POST['email'];
		//$profesion=$_POST['profesion'];
		$profesion="";
		//$ocupacion=$_POST['ocupacion'];
		$ocupacion="";
		//$idextranjero=$_POST['idextranjero'];
		$idextranjero="";
		//$estadonac=$_POST['estadonac'];
		$estadonac="";
		$nacionalidad=$_POST['nacionalidad'];
		$idbanco=$_POST['idbanco'];
		$cuenta=$_POST['cuenta'];
		$clabe=$_POST['clabe'];
		$beneficiario=$_POST['beneficiario'];
		$genero=$_POST['genero'];
		//$fuentei=$_POST['fuentei'];
		$fuentei="";
		//$puestopolitico=$_POST['puestopolitico'];
		$puestopolitico="";
		//$procedencia=$_POST['procedencia'];
		$procedencia="";
		//$propietarior=$_POST['propietarior'];
		$propietarior="Terceros";
		$callef=$_POST['callef'];
		$numerof=$_POST['numerof'];
		$numerointf=$_POST['numerointf'];
		$lotef=$_POST['lotef'];
		$mzaf=$_POST['mzaf'];
		$coloniaf=$_POST['coloniaf'];
		$municipiof=$_POST['municipiof'];
		$estadof=$_POST['estadof'];
		$cpf=$_POST['cpf'];
		$recursosori="";
		$recursosdes="";
		$valorampliacion=$_POST['valorampliacion'];
		$valorregla=$_POST['valorregla'];
		$valorneto=$_POST['valorneto'];
		$status="1";

		//$idproducto=$_POST['idproducto'];
		$idproducto=1;
		//$idtipoproducto=$_POST['idtipoproducto'];
		$idtipoproducto=2;
		//$iddestino=$_POST['iddestino'];
		$iddestino=4;
		//$plazocredito=$_POST['plazocredito'];
		$plazocredito="";
		//$segundocredito=$_POST['segundocredito'];
		$segundocredito=0;
		//$discapacidad=$_POST['discapacidad'];
		$discapacidad=0;
		//$tipodiscapacidad=$_POST['tipodiscapacidad'];
		$tipodiscapacidad="";
		//$personacapacidad=$_POST['personacapacidad'];
		$personacapacidad="";
		$afectaestructura=$_POST['afectaestructura'];
		$razonsocialpatron=$_POST['razonsocialpatron'];
		$rfcpatron=$_POST['rfcpatron'];
		$telpatron=$_POST['telpatron'];
		$ref1apellidop=$_POST['ref1apellidop'];
		$ref1apellidom=$_POST['ref1apellidom'];
		$ref1nombre=$_POST['ref1nombre'];
		$ref1telefono=$_POST['ref1telefono'];
		$ref2apellidop=$_POST['ref2apellidop'];
		$ref2apellidom=$_POST['ref2apellidom'];
		$ref2nombre=$_POST['ref2nombre'];
		$ref2telefono=$_POST['ref2telefono'];
		//$razonsocialacreditado=$_POST['razonsocialacreditado'];
		$razonsocialacreditado="";
		//$rfcacreditado=$_POST['rfcacreditado'];
		$rfcacreditado="";
		//$nombreacreditado=$_POST['nombreacreditado'];
		$nombreacreditado="";
		//$clabeacreditado=$_POST['clabeacreditado'];
		$clabeacreditado="";
		
		$montopresupuesto=$_POST['montopresupuesto'];
		//$idadministradora=$_POST['idadministradora'];
		$idadministradora=1;
		//
		
		if($numopeauto==0)
			$minsql="`idcli`='$idcli',";
		else
			$minsql="";

		$csql = "UPDATE `cat_clientes` SET $minsql `nombre`='$nombre', `apellidop`='$apellidop', `apellidom`='$apellidom',";
		$csql .="`nacimiento`='$nacimiento',`ecivil`='$ecivil', `nss`='$nss',";
		$csql .="`escolaridad`='$escolaridad', `calle`='$calle', `numero`='$numero',`numeroint`='$numeroint',`lote`='$lote',`mza`='$mza', `colonia`='$colonia',";
		$csql .="`municipio`='$municipio', `estado`='$estado', `cp`='$cp', `rfc`='$rfc',";
		$csql .="`curp`='$curp', `celular`='$celular', `oficina`='$oficina', `telefonos`='$telefonos',";
		$csql .="`email`='$email', `profesion`='$profesion', `ocupacion`='$ocupacion', `idextranjero`='$idextranjero',";
		$csql .="`estadonac`='$estadonac', `nacionalidad`='$nacionalidad', `idbanco`='$idbanco', `cuenta`='$cuenta',";
		$csql .="`clabe`='$clabe', `beneficiario`='$beneficiario', `genero`='$genero', ";
		$csql .="`fuentei`='$fuentei', `puestopolitico`='$puestopolitico', `procedencia`='$procedencia', `propietarior`='$propietarior',";
		$csql .="`callef`='$callef', `numerof`='$numerof',`numerointf`='$numerointf',`lotef`='$lotef',`mzaf`='$mzaf', `coloniaf`='$coloniaf', `municipiof`='$municipiof',";
		$csql .="`estadof`='$estadof', `cpf`='$cpf',`idadministradora`='$idadministradora',";
		$csql .="`recursosori`='$recursosori', `recursosdes`='$recursosdes', `valorampliacion`='$valorampliacion', `valorregla`='$valorregla',";
		//
		$csql .="`idproducto`='$idproducto', `idtipoproducto`='$idtipoproducto', `iddestino`='$iddestino', `plazocredito`='$plazocredito',";
		$csql .="`segundocredito`='$segundocredito', `discapacidad`='$discapacidad', `tipodiscapacidad`='$tipodiscapacidad', `personacapacidad`='$personacapacidad',";
		$csql .="`afectaestructura`='$afectaestructura', `razonsocialpatron`='$razonsocialpatron', `rfcpatron`='$rfcpatron', `telpatron`='$telpatron',";
		$csql .="`ref1apellidop`='$ref1apellidop', `ref1apellidom`='$ref1apellidom', `ref1nombre`='$ref1nombre', `ref1telefono`='$ref1telefono',";
		$csql .="`ref2apellidop`='$ref2apellidop', `ref2apellidom`='$ref2apellidom', `ref2nombre`='$ref2nombre', `ref2telefono`='$ref2telefono',";
		$csql .="`razonsocialacreditado`='$razonsocialacreditado', `rfcacreditado`='$rfcacreditado', `nombreacreditado`='$nombreacreditado', `clabeacreditado`='$clabeacreditado', `montopresupuesto`='$montopresupuesto',";
		//
		$csql .="`valorneto`='$valorneto', `status`='$status', `ultactfec`='".date("Y-m-d h:i:s")."', `ultactusu`='$IDUser' ";
		$csql .="WHERE `id`='$id'";	
		
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }


		#registro ya existente, revisamos las diferencias para el log
		$logmsg="";
		
		$actnombre=$_POST['actnombre'];
		if($nombre!=$actnombre)
			$logmsg .="Cambio el Nombre de $actnombre a $nombre, ";
		$actapellidop=$_POST['actapellidop'];
		if($apellidop!=$actapellidop)
			$logmsg .="Cambio el Apellido paterno de $actapellidop a $apellidop, ";
		$actapellidom=$_POST['actapellidom'];
		if($apellidom!=$actapellidom)
			$logmsg .="Cambio el Apellido materno de $actapellidom a $apellidom, ";			
		$actnacimiento=$_POST['actnacimiento'];
		if($nacimiento!=$actnacimiento)
			$logmsg .="Cambio la fecha de Nacimiento de $actnacimiento a $nacimiento, ";
		$actecivil=$_POST['actecivil'];
		if($ecivil!=$actecivil)
			$logmsg .="Cambio el Estado Civil de $actecivil a $ecivil, ";
		$actnss=$_POST['actnss'];
		if($nss!=$actnss)
			$logmsg .="Cambio el NSS de $actnss a $nss, ";
		$actescolaridad=$_POST['actescolaridad'];
		if($escolaridad!=$actescolaridad)
			$logmsg .="Cambio la Escolaridad de $actescolaridad a $escolaridad, ";
		$actcalle=$_POST['actcalle'];
		if($calle!=$actcalle)
			$logmsg .="Cambio la Calle de $actcalle a $calle, ";
		$actnumero=$_POST['actnumero'];
		if($numero!=$actnumero)
			$logmsg .="Cambio el Número de la dirección de $actnumero a $numero, ";
		$actcolonia=$_POST['actcolonia'];
		if($colonia!=$actcolonia)
			$logmsg .="Cambio la Colonia de la dirección de $actcolonia a $colonia, ";
		$actmunicipio=$_POST['actmunicipio'];
		if($municipio!=$actmunicipio)
			$logmsg .="Cambio el Municipio de la dirección de $actmunicipio a $municipio, ";
		$actestado=$_POST['actestado'];
		if($estado!=$actestado)
			$logmsg .="Cambio el Estado de la dirección de $actestado a $estado, ";
		$actcp=$_POST['actcp'];
		if($cp!=$actcp)
			$logmsg .="Cambio el CP de la dirección de $actcp a $cp, ";
		$actrfc=$_POST['actrfc'];
		if($rfc!=$actrfc)
			$logmsg .="Cambio el RFC de $actrfc a $rfc, ";
		$actcurp=$_POST['actcurp'];
		if($curp!=$actcurp)
			$logmsg .="Cambio el CURP de $actcurp a $curp, ";
		$actcelular=$_POST['actcelular'];
		if($celular!=$actcelular)
			$logmsg .="Cambio el Teléfono celular de $actcelular a $celular, ";
		$actoficina=$_POST['actoficina'];
		if($oficina!=$actoficina)
			$logmsg .="Cambio el Teléfono de oficina $actoficina a $oficina, ";
		$acttelefonos=$_POST['acttelefonos'];
		if($telefonos!=$acttelefonos)
			$logmsg .="Cambio el Teléfono de $acttelefonos a $telefonos, ";
		$actemail=$_POST['actemail'];
		if($email!=$actemail)
			$logmsg .="Cambio el Correo electrónico de $actemail a $email, ";
		$actprofesion=$_POST['actprofesion'];
		if($profesion!=$actprofesion)
			$logmsg .="Cambio la profesión de $actprofesion a $profesion, ";
		$actocupacion=$_POST['actocupacion'];
		if($ocupacion!=$actocupacion)
			$logmsg .="Cambio la Ocupación de $actocupacion a $ocupacion, ";
		$actidextranjero=$_POST['actidextranjero'];
		if($idextranjero!=$actidextranjero)
			$logmsg .="Cambio la identificación fiscal de extranjero de $actidextranjero a $idextranjero, ";
		$actestadonac=$_POST['actestadonac'];
		if($estadonac!=$actestadonac)
			$logmsg .="Cambio el estado de nacimiento de $actestadonac a $estadonac, ";
		$actnacionalidad=$_POST['actnacionalidad'];
		if($nacionalidad!=$actnacionalidad)
			$logmsg .="Cambio la nacionalidad de $actnacionalidad a $nacionalidad, ";
		$actidbanco=$_POST['actidbanco'];
		if($idbanco!=$actidbanco)
			$logmsg .="Cambio el banco de $actidbanco a $idbanco, ";
		$actcuenta=$_POST['actcuenta'];
		if($cuenta!=$actcuenta)
			$logmsg .="Cambio la Cuenta de $actcuenta a $cuenta, ";
		$actclabe=$_POST['actclabe'];
		if($clabe!=$actclabe)
			$logmsg .="Cambio la Cuenta CLABE de $actclabe a $clabe, ";
		$actbeneficiario=$_POST['actbeneficiario'];
		if($beneficiario!=$actbeneficiario)
			$logmsg .="Cambio la Beneficiario de $actbeneficiario a $beneficiario, ";
		$actgenero=$_POST['actgenero'];
		if($genero!=$actgenero)
			$logmsg .="Cambio el Género $actgenero a $genero, ";
		$actfuentei=$_POST['actfuentei'];
		if($fuentei!=$actfuentei)
			$logmsg .="Cambio la fuente de ingresos de $actfuentei a $fuentei, ";
		$actpuestopolitico=$_POST['actpuestopolitico'];
		if($puestopolitico!=$actpuestopolitico)
			$logmsg .="Cambio el Puesto político de $actpuestopolitico a $puestopolitico, ";
		$actprocedencia=$_POST['actprocedencia'];
		if($procedencia!=$actprocedencia)
			$logmsg .="Cambio la Procedencia de $actprocedencia a $procedencia, ";
		$actpropietarior=$_POST['actpropietarior'];
		if($propietarior!=$actpropietarior)
			$logmsg .="Cambio el Propietario de recursos de $actpropietarior a $propietarior, ";
		$actcallef=$_POST['actcallef'];
		if($callef!=$actcallef)
			$logmsg .="Cambio la Calle (fiscal) de $actcallef a $callef, ";
		$actnumerof=$_POST['actnumerof'];
		if($numerof!=$actnumerof)
			$logmsg .="Cambio el Número (fiscal) de la dirección de $actnumerof a $numerof, ";
		$actcoloniaf=$_POST['actcoloniaf'];
		if($coloniaf!=$actcoloniaf)
			$logmsg .="Cambio la Colonia (fiscal) de la dirección de $actcoloniaf a $coloniaf, ";
		$actmunicipiof=$_POST['actmunicipiof'];
		if($municipiof!=$actmunicipiof)
			$logmsg .="Cambio el Municipio (fiscal) de la dirección de $actmunicipiof a $municipiof, ";
		$actestadof=$_POST['actestadof'];
		if($estadof!=$actestadof)
			$logmsg .="Cambio el Estado (fiscal) de la dirección de $actestadof a $estadof, ";
		$actcpf=$_POST['actcpf'];
		if($cpf!=$actcpf)
			$logmsg .="Cambio el CP (fiscal) de la dirección de $actcpf a $cpf, ";
		$actrecursosori=$_POST['actrecursosori'];
		if($recursosori!=$actrecursosori)
			$logmsg .="Cambio otro origen de recurosos de $actrecursosori a $recursosori, ";
		$actrecursosdes=$_POST['actrecursosdes'];
		if($recursosdes!=$actrecursosdes)
			$logmsg .="Cambio otro destino de recurosos de $actrecursosdes a $recursosdes, ";
		$valorampliacion=$_POST['valorampliacion'];
		if($valorampliacion!=$valorampliacion)
			$logmsg .="Cambio el valor apliación de $valorampliacion a $valorampliacion, ";
		$actvalorregla=$_POST['actvalorregla'];
		if($valorregla!=$actvalorregla)
			$logmsg .="Cambio el monto segun regla de $actvalorregla a $valorregla, ";
		$actvalorneto=$_POST['actvalorneto'];
		if($valorneto!=$actvalorneto)
			$logmsg .="Cambio el valor neto de $actvalorneto a $valorneto, ";

/*
		$actrecori=$_POST['actrecori'];
		$actrecdes=$_POST['actrecdes'];

		#recursos Ingresos
		$recori="0";
		$consulta="select * from cat_recursos where tipo='1' and status='1' order by orden";					
		$resx = mysqli_query($conexio,$consulta);
		while($val=mysqli_fetch_array($resx))
			{
			$aux=asigna("rec".$val['id']);
			if($aux==1)
				$recori .=",".$val['id'];
			}
		mysqli_free_result($resx);

		if($recori!=$actrecori)
			{
			$csql="delete from rel_recursos where tipo='1' and idcliente='$id'";
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$datos=explode(",",$recori);
			$cro=count($datos);
			for($i=1;$i<$cro;$i++)
				{
				$csql = "INSERT INTO `rel_recursos` (`tipo`,`idcliente`,`idrecurso` ) VALUES ('1','$id','".$datos[$i]."');";
				mysqli_query($conexio, $csql);
				if(mysqli_error($conexio)!="") {
					echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
					exit(); }
				}
			$logmsg .="Cambio en Origen de los recursos de $actrecori a $recori (ids del sistema), ";


			}

		#recursos Egresos
		$recdes="0";
		$consulta="select * from cat_recursos where tipo='2' and status='1' order by orden";					
		$resx = mysqli_query($conexio,$consulta);
		while($val=mysqli_fetch_array($resx))
			{
			$aux=asigna("rec".$val['id']);
			if($aux==1)
				$recdes .=",".$val['id'];
			}
		mysqli_free_result($resx);

		if($recdes!=$actrecdes)
			{
			$csql="delete from rel_recursos where tipo='2' and idcliente='$id'";
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$datos=explode(",",$recdes);
			$cro=count($datos);
			for($i=1;$i<$cro;$i++)
				{
				$csql = "INSERT INTO `rel_recursos` (`tipo`,`idcliente`,`idrecurso` ) VALUES ('2','$id','".$datos[$i]."');";
				mysqli_query($conexio, $csql);
				if(mysqli_error($conexio)!="") {
					echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
					exit(); }
				}
			$logmsg .="Cambio en Destino de los recursos de $actrecdes a $recdes (ids del sistema), ";
			}			
			
		lognow('log_clientes',$id,1,$IDUser,$logmsg);
		*/
		

	#Fin guardado
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.location.href='f_cliente.php?id=$id'; \"></body></html>";
		exit();		
		}
	
	if($accion==3)
		{
		$status=$_POST['status'];
		$actstatus=$_POST['actstatus'];
		$comentariostatus=$_POST['comentariostatus'];
		$logmsg="";
		$csql="Update cat_operadores set status='$status',ultactfec=NOW(),ultactusu='$IDUser' where id='$id'";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "ERROR: "."Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		if($status!=$actstatus)
			{
			$idstatusv=traedato("cat_statusoperador","id",$actstatus,"S","descripcion");
			$logmsg .="Cambio el Status de $idstatusv ";
			$idstatusv=traedato("cat_statusoperador","id",$status,"S","descripcion");
			$logmsg .="a $idstatusv, ";
			}
		$logmsg .=". Razón: $comentariostatus";
		lognow("log_clientes",$id,2,$IDUser,$logmsg);
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.location.href='f_operador.php?id=$id'; \"></body></html>";
		exit();	
		}
	if($accion==4)
		{
		$comentario=$_POST['comentario'];
		$idcom=$_POST['idcom'];
		$logmsg="";
		if($idcom==0)
			{
			$csql = "INSERT INTO `ope_clientecoms` (`idorigen`,`tipo`,`descripcion`,`fecha`,`usuario`,`ultactfec`,`ultactusu` )";
			$csql .="VALUES ('$id','0','$comentario','".date("Y-m-d H:i:s")."','$IDUser','".date("Y-m-d H:i:s")."','$IDUser');";
			$logmsg .="Comentario nuevo: '$comentario''. ";
			}
		else
			{
			$actcomentario=traedato("ope_clientecoms","id",$idcom,"S","descripcion");
			$csql = "UPDATE `ope_clientecoms` SET `idorigen`='$id', `descripcion`='$comentario',`ultactfec`='".date("Y-m-d H:i:s")."', `ultactusu`='$IDUser' WHERE `id`='$idcom';";
			$logmsg .="Cambio un Comentario, de '$actcomentario' a '$comentario'. ";
			}
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		lognow("log_clientes",$id,1,$IDUser,$logmsg);
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" window.location.href='f_cliente.php?id=$id'; \"></body></html>";
		exit();	
		}

	
	

	if($accion==5)
		{#borrar
		$idcli=asigna("idcli");
		#borramos los archivos
		$imgtabla=traedato("adm_archivos","modulo","clientes","N","tabla");
		$imgruta=traedato("adm_archivos","modulo","clientes","N","ruta");
		$consulta="Select * from $imgtabla where idorigen='$id'";
		$res2 = mysqli_query($conexio, $consulta);
		while($val5=mysqli_fetch_array($res2))
			{			
			$archivo=$imgruta.$val5['archivo'];
			if(file_exists($archivo))
				unlink($archivo);
			}
		mysqli_free_result($res2);
				
		$csql = "DELETE from `$imgtabla` where idorigen='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
			
		$csql = "DELETE from `ope_clientedocs` where idpersona='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }	
	
		$csql = "DELETE from `ope_clientecoms` where idorigen='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
			
		$csql = "DELETE from `ope_operadorms` where idorigen='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "ERROR: "."Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
			
		$csql = "DELETE from `cat_clientes` where id='$id';";
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar el registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		lognow('log_clientes',$id,2,$IDUser,'Se eliminó el cliente con el ID $idcli con toda su información asociada');
		echo "<html><head><title>Cliente borrado</title></head><body onLoad=\" ww=window.opener; ww.location.reload(); window.close(); \"></body></html>";
		exit();
		}

	if($accion==6)
		{
		$idcom=$_POST['idcom'];
		$logmsg="";
		if($idcom>0)
			{
			$actcomentario=traedato("ope_clientecoms","id",$idcom,"S","descripcion");
			$csql = "DELETE FROM `ope_clientecoms` where `id`='$idcom';";
			$logmsg .="Borrado del Comentario '$actcomentario'. ";
			}
		mysqli_query($conexio, $csql);
		if(mysqli_error($conexio)!="") {
			echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
			exit(); }
		lognow("log_clientes",$id,5,$IDUser,$logmsg);
		#echo $csql;
		echo "<html><head><title>Registro Guardado</title></head><body onLoad=\" window.location.href='f_cliente.php?id=$id'; \"></body></html>";
		exit();	
		}

	if($accion==7)
		{
		$integranew=$_POST['integranew'];
		$actintegradora=$_POST['actintegradora'];
		if($integranew!=$actintegradora)
			{
			$csql = "update cat_clientes set integradora='$integranew',ultactfec='".date("Y-m-d h:i:s")."',ultactusu='$IDUser' where `id`='$id'";		
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$logmsg="Actualización de Integradora de $actintegradora a $integranew.";
			lognow("log_clientes",$id,5,$IDUser,$logmsg);
			#echo $csql;
			echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_cliente.php?id=$id'; \"></body></html>";
			exit();	
			}
		}

	if($accion==8)
		{
		$asesornew=$_POST['asesornew'];
		$actasesor=$_POST['actasesor'];
		if($asesornew!=$actasesor)
			{
			$csql = "update cat_clientes set asesor='$asesornew',ultactfec='".date("Y-m-d h:i:s")."',ultactusu='$IDUser' where `id`='$id'";		
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$logmsg="Actualización de Asesor de $actasesor a $asesornew.";
			lognow("log_clientes",$id,5,$IDUser,$logmsg);
			#echo $csql;
			echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_cliente.php?id=$id'; \"></body></html>";
			exit();	
			}
		}

	if($accion==9)
		{
		$idconstructoranew=$_POST['idconstructoranew'];
		$actconstructora=$_POST['actconstructora'];
		if($idconstructoranew!=$actconstructora)
			{
			$csql = "update cat_clientes set idconstructora='$idconstructoranew',ultactfec='".date("Y-m-d h:i:s")."',ultactusu='$IDUser' where `id`='$id'";		
			mysqli_query($conexio, $csql);
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$logmsg="Actualización de Constructora de $actconstructora a $idconstructoranew.";
			lognow("log_clientes",$id,5,$IDUser,$logmsg);
			#echo $csql;
			echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_cliente.php?id=$id'; \"></body></html>";
			exit();	
			}
		}

	if($accion==10)
		{
		$idverificadoranew=$_POST['idverificadoranew'];
		$actverificadora=$_POST['actverificadora'];
		if($idverificadoranew!=$actverificadora)
			{
			$csql = "update cat_clientes set idverificadora='$idverificadoranew',ultactfec='".date("Y-m-d h:i:s")."',ultactusu='$IDUser' where `id`='$id'";		
			mysqli_query($conexio, $csql);
		
			if(mysqli_error($conexio)!="") {
				echo "Error al grabar al actualizar registro. ".mysqli_error($conexio)."->$csql";
				exit(); }
			$logmsg="Actualización de Verificadora de $actverificadora a $idverificadoranew.";
			lognow("log_clientes",$id,5,$IDUser,$logmsg);
			#echo $csql;
			echo "<html><head><title>Registro Guardado</title></head><body onLoad=\"ww=window.opener; ww.location.reload(); window.location.href='f_cliente.php?id=$id'; \"></body></html>";
			exit();	
			}
		}
		
	}
else{ #Fin del existe 'Accion'
	if($id!="-1")
		{	
		$csql = "SELECT * from `cat_clientes` WHERE `id` = '$id';";
		
		$res2 = mysqli_query($conexio, $csql);
		if($val5=mysqli_fetch_array($res2))
			{	

			//combos 08/01/19
		$idproducto=$val5['idproducto'];
            if($idproducto==0)
              $idproductov="<option selected value='0'>(sin asignar)</option>";
            else
              $idproductov="<option value='0'>(sin asignar)</option>";     
            $csql = "SELECT * from `cat_creproductos`  where status='1' order by descripcion asc";
            $res = $conexio->query($csql);
            while($val=mysqli_fetch_array($res))
              {
              if($val['id']==$idproducto)
          		$idproductov.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
        	else
         	 	$idproductov.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
       		  }
      		$res->free();

		$idtipoproducto=$val5['idtipoproducto'];
            if($idtipoproducto==0)
              $idtipoproductov="<option selected value='0'>(sin asignar)</option>";
            else
              $idtipoproductov="<option value='0'>(sin asignar)</option>";     
            $csql = "SELECT * from `cat_cretipopro`  where status='1' order by descripcion asc";
            $res = $conexio->query($csql);
            while($val=mysqli_fetch_array($res))
              {
              if($val['id']==$idtipoproducto)
          		$idtipoproductov.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
        	else
         	 	$idtipoproductov.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
       		  }
      		$res->free();

		$iddestino=$val5['iddestino'];
            if($iddestino==0)
              $iddestinov="<option selected value='0'>(sin asignar)</option>";
            else
              $iddestinov="<option value='0'>(sin asignar)</option>";     
            $csql = "SELECT * from `cat_credestino`  where status='1' order by descripcion asc";
            $res = $conexio->query($csql);
            while($val=mysqli_fetch_array($res))
              {
              if($val['id']==$iddestino)
          		$iddestinov.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
        	else
         	 	$iddestinov.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
       		  }
      		$res->free();

		$plazocredito=$val5['plazocredito'];
            if($plazocredito==0)
              $plazocreditov="<option selected value='0'>(sin asignar)</option>";
            else
              $plazocreditov="<option value='0'>(sin asignar)</option>";     
            $csql = "SELECT * from `cat_creplazo`  where status='1' order by descripcion asc";
            $res = $conexio->query($csql);
            while($val=mysqli_fetch_array($res))
              {
              if($val['id']==$plazocredito)
          		$plazocreditov.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
        	else
         	 	$plazocreditov.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
       		  }
      		$res->free();	

		$segundocredito=$val5['segundocredito'];
			if($segundocredito=="")
				$segundocreditov="<option selected value=''>(seleccione)</option><option value='0'>No</option><option value='1'>Si</option>";
			if($segundocredito=="0")
				$segundocreditov="<option value=''>(seleccione)</option><option selected value='0'>No</option><option value='1'>Si</option>";
			if($segundocredito=="1")
				$segundocreditov="<option value=''>(seleccione)</option><option value='0'>No</option><option selected value='1'>Si</option>";	

		$discapacidad=$val5['discapacidad'];
			if($discapacidad=="")
				$discapacidadv="<option selected value=''>(seleccione)</option><option value='0'>No</option><option value='1'>Si</option>";
			if($discapacidad=='0')
				$discapacidadv="<option value=''>(seleccione)</option><option selected value='0'>No</option><option value='1'>Si</option>";
			if($discapacidad=='1')
				$discapacidadv="<option value=''>(seleccione)</option><option value='0'>No</option><option selected value='1'>Si</option>";

		$tipodiscapacidad=$val5['tipodiscapacidad'];
			if($tipodiscapacidad=="")
				$tipodiscapacidadv="<option selected value=''>(seleccione)</option><option value='Motriz'>Motriz</option><option value='Auditiva'>Auditiva</option><option value='Mental'>Mental</option><option value='Visual'>Visual</option>";
			if($tipodiscapacidad=="Motriz")
				$tipodiscapacidadv="<option value=''>(seleccione)</option><option selected value='Motriz'>Motriz</option><option value='Auditiva'>Auditiva</option><option value='Mental'>Mental</option><option value='Visual'>Visual</option>";
			if($tipodiscapacidad=="Auditiva")
				$tipodiscapacidadv="<option value=''>(seleccione)</option><option value='Motriz'>Motriz</option><option selected value='Auditiva'>Auditiva</option><option value='Mental'>Mental</option><option value='Visual'>Visual</option>";
			if($tipodiscapacidad=="Mental")
				$tipodiscapacidadv="<option value=''>(seleccione)</option><option value='Motriz'>Motriz</option><option value='Auditiva'>Auditiva</option><option selected value='Mental'>Mental</option><option value='Visual'>Visual</option>";
			if($tipodiscapacidad=="Visual")
				$tipodiscapacidadv="<option value=''>(seleccione)</option><option value='Motriz'>Motriz</option><option value='Auditiva'>Auditiva</option><option value='Mental'>Mental</option><option selected value='Visual'>Visual</option>";

		$personacapacidad=$val5['personacapacidad'];
			if($personacapacidad=="")
				$personacapacidadv="<option selected value=''>(sin asignar)</option>";
			else
				$personacapacidadv="<option value=''>(sin asignar)</option>";			
			$csql = "SELECT * from `cat_parentezco` where status='1' order by `descripcion` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				{
				if($val['descripcion']==$personacapacidad)
					$personacapacidadv.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				else
					$personacapacidadv.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);	

		$afectaestructura=$val5['afectaestructura'];
			if($afectaestructura=="")
				$afectaestructurav="<option selected value=''>(seleccione)</option><option value='0'>No</option><option value='1'>Si</option>";
			if($afectaestructura=="0")
				$afectaestructurav="<option value=''>(seleccione)</option><option selected value='0'>No</option><option value='1'>Si</option>";
			if($afectaestructura=="1")
				$afectaestructurav="<option value=''>(seleccione)</option><option value='0'>No</option><option selected value='1'>Si</option>";;		

			$razonsocialpatron=$val5['razonsocialpatron'];
			$rfcpatron=$val5['rfcpatron'];
			$telpatron=$val5['telpatron'];
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
			$montopresupuesto=$val5['montopresupuesto'];
	//
		
			$idcli=$val5['idcli'];
			$nombre=$val5['nombre'];
			$apellidop=$val5['apellidop'];
			$apellidom=$val5['apellidom'];
			$rfc=$val5['rfc'];
			$curp=$val5['curp'];
			$nss=$val5['nss'];			
			$nacimiento=$val5['nacimiento'];
			$edad=calcular_edad($nacimiento);
			$nacionalidad=$val5['nacionalidad'];
			$ecivil=$val5['ecivil'];
			if($ecivil=="")
				$ecivilv="<option selected value=''>(seleccione)</option>";
			else
				$ecivilv="<option value=''>(seleccione)</option>";
			$csql = "SELECT * from `cat_ecivil` where status='1' order by `descripcion` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx)) 
				{
				if($val['descripcion']==$ecivil)
					$ecivilv.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				else
					$ecivilv.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);
			$fecha=fixfecha($val5['fecha']);
			$fechafin=fixfecha($val5['fechafin']);
			$genero=$val5['genero'];
			if($genero=="")
				$generov="<option selected value=''>(seleccione)</option><option value='Masculino'>Masculino</option><option value='Femenino'>Femenino</option>";
			if($genero=="Masculino")
				$generov="<option value=''>(seleccione)</option><option selected value='Masculino'>Masculino</option><option value='Femenino'>Femenino</option>";
			if($genero=="Femenino")
				$generov="<option value=''>(seleccione)</option><option value='Masculino'>Masculino</option><option selected value='Femenino'>Femenino</option>";
			$puestopolitico=$val5['puestopolitico'];
			

			$nacionalidad=$val5['nacionalidad'];
			$idextranjero=$val5['idextranjero'];
			
			$estadonac=$val5['estadonac'];
			if($estadonac=="")
				$estadonacv="<option selected value=''>(sin asignar)</option>";
			else
				$estadonacv="<option value=''>(sin asignar)</option>";			
			$csql = "SELECT * from `cat_estadosrep` where status='1' order by `descripcion` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				{
				if($val['descripcion']==$estadonac)
					$estadonacv.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				else
					$estadonacv.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);		
			
			$escolaridad=$val5['escolaridad'];
			if($escolaridad=="")
				$escolaridadv="<option selected value=''>(seleccione)</option>";
			else
				$escolaridadv="<option value=''>(seleccione)</option>";
			$csql = "SELECT * from `cat_escolaridad` where status='1' order by `id` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx)) 
				{
				if($val['descripcion']==$escolaridad)
					$escolaridadv.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				else
					$escolaridadv.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);

			
			$calle=$val5['calle'];
			$numero=$val5['numero'];
			$numeroint=$val5['numeroint'];
			$lote=$val5['lote'];
			$mza=$val5['mza'];
			$colonia=$val5['colonia'];
			$municipio=$val5['municipio'];
			$estado=$val5['estado'];
			if($estado=="")
				$estadov="<option selected value=''>(sin asignar)</option>";
			else
				$estadov="<option value=''>(sin asignar)</option>";			
			$csql = "SELECT * from `cat_estadosrep` where status='1' order by `descripcion` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				{
				if($val['descripcion']==$estado)
					$estadov.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				else
					$estadov.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);
			$cp=$val5['cp'];

			$callef=$val5['callef'];
			$numerof=$val5['numerof'];
			$numerointf=$val5['numerointf'];
			$lotef=$val5['lotef'];
			$mzaf=$val5['mzaf'];
			$coloniaf=$val5['coloniaf'];
			$municipiof=$val5['municipiof'];
			$estadof=$val5['estadof'];
			if($estadof=="")
				$estadofv="<option selected value=''>(sin asignar)</option>";
			else
				$estadofv="<option value=''>(sin asignar)</option>";			
			$csql = "SELECT * from `cat_estadosrep` where status='1' order by `descripcion` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				{
				if($val['descripcion']==$estadof)
					$estadofv.="<option selected value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				else
					$estadofv.="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);
			$cpf=$val5['cp'];


			$oficina=$val5['oficina'];
			$celular=$val5['celular'];
			$telefonos=$val5['telefonos'];
			$email=$val5['email'];

			$profesion=$val5['profesion'];
			$ocupacion=$val5['ocupacion'];
			$fuentei=$val5['fuentei'];
			$procedencia=$val5['procedencia'];

			$recursosori=$val5['recursosori'];
			$recursosdes=$val5['recursosdes'];

			$valorampliacion=$val5['valorampliacion'];
			$valorregla=$val5['valorregla'];
			$valorneto=$val5['valorneto'];

			$integradora=$val5['integradora'];
			$idconstructora=$val5['idconstructora'];
			if($idconstructora!=0)
				$idconstructorav=traedato("cat_entidades","id",$idconstructora,"S","razonsocial");
			else
				$idconstructorav="-";
			$idverificadora=$val5['idverificadora'];
			if($idverificadora!=0)
				$idverificadorav=traedato("cat_entidades","id",$idverificadora,"S","razonsocial");
			else
				$idverificadorav="-";
			$asesor=$val5['asesor'];

			$idbanco=$val5['idbanco'];
			if($idbanco=="")
				$idbancov="<option selected value=''>(seleccione)</option>";
			else
				$idbancov="<option value=''>(seleccione)</option>";
			$csql = "SELECT * from `cat_instituciones` where status='1' order by `descripcion` asc;";
			$resx = mysqli_query($conexio,$csql);
			while($val=mysqli_fetch_array($resx)) 
				{
				if($val['id']==$idbanco)
					$idbancov.="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
				else
					$idbancov.="<option value='".$val['id']."'>".$val['descripcion']."</option>";
				}
			mysqli_free_result($resx);
			$cuenta=$val5['cuenta'];
			$clabe=$val5['clabe'];
			$beneficiario=$val5['beneficiario'];

			$propietarior=$val5['propietarior'];
			$propietariorv="<option selected value=''>(seleccione)</option><option value='Terceros'>Terceros</option>";	
			if($propietarior=="")
				$propietariorv="<option selected value=''>(seleccione)</option><option value='Terceros'>Terceros</option>";			
			if($propietarior=="Terceros")
				$propietariorv="<option value=''>(seleccione)</option><option selected value='Terceros'>Terceros</option>";
			

			$idadministradora=$val5['idadministradora'];
			if($idadministradora=="")
				$idadministradorav="<option selected value=''>(sin asignar)</option>";
			else
				$idadministradorav="<option value=''>(sin asignar)</option>";			
			$csql = "SELECT * from `cat_entidades` where status='1' and tipo='1' order by `razonsocial` asc;";
			$resx = mysqli_query($conexio, $csql);
			while($val=mysqli_fetch_array($resx))
				{
				if($val['id']==$idadministradora)
					$idadministradorav.="<option selected value='".$val['id']."'>".$val['razonsocial']."</option>";
				else
					$idadministradorav.="<option value='".$val['id']."'>".$val['razonsocial']."</option>";
				}
			mysqli_free_result($resx);

			$owner=$val5['owner'];
					
			$status=$val5['status'];
			$statusv=traedato("cat_statuscliente","id",$status,"S","descripcion");
				

			if($IDL2>0)
				$statuschk="";
			else
				$statuschk="disabled";
			$ultactfec=$val5['ultactfec'];
			$ultactusu=$val5['ultactusu'];
			$ultima=fixfecha($ultactfec)." por $ultactusu";
			}
		mysqli_free_result($res2);
		}
	
	
	}

#relaciones
$consulta="select * from rel_recursos where idcliente='$id'";
$arrdato=array();
$arrrecu=array();
$resx = mysqli_query($conexio,$consulta);
while($val=mysqli_fetch_array($resx))
	{
	$arrdato[0]=$val['idrecurso'];
	$arrdato[1]=$val['tipo'];
	array_push($arrrecu,$arrdato);
	}
mysqli_free_result($resx);
$cr=count($arrrecu);

function erecu($tipo,$idrecurso)
	{
	global $arrrecu;
	global $cr;
	$res=0;
	for($i=0;$i<$cr;$i++)
		{
		if($arrrecu[$i][0]==$idrecurso && $arrrecu[$i][1]==$tipo)
			{
			$res=1;
			$i=$cr;
			}
		}	
	return $res;
	}


#asesores nuevos
$consulta="select a.nombre from adm_usuarios a left join adm_permisos as b on a.id=b.idusuario where b.modulo='AdminClientes' and b.tipo>='2' and a.status='1'";
$asesornewv="";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	$asesornewv .="<option value='".$val['nombre']."'>".$val['nombre']."</option>";
mysqli_free_result($resx);

#integradoras nuevos
$consulta="select * from cat_integradoras where status='1'";
$integranewv="";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	$integranewv .="<option value='".$val['descripcion']."'>".$val['descripcion']."</option>";
mysqli_free_result($resx);

#constructoras nuevas
$consulta="select * from cat_entidades where status='1' and tipo='2'";
$idconstructoranewv="";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	$idconstructoranewv .="<option value='".$val['id']."'>".$val['razonsocial']."</option>";
mysqli_free_result($resx);

#verificadoras nuevas
$consulta="select * from cat_entidades where status='1' and tipo='3'";
$idverificadoranewv="";
$resx = mysqli_query($conexio, $consulta);
while($val=mysqli_fetch_array($resx))
	$idverificadoranewv .="<option value='".$val['id']."'>".$val['razonsocial']."</option>";
mysqli_free_result($resx);
?>
<html>
<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar o Crear Operador</title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/calendar/calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../lib/calendar/calendar.js?random=20060118"></script>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/popup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

function guardar() 
	{	
	if(document.edicion.nombre.value=="")
		{
		alert('Especifique el Nombre');
		document.edicion.nombre.focus();
		return "0";
		}
	if(document.edicion.apellidop.value=="")
		{
		alert('Especifique el Apellido Paterno');
		document.edicion.apellidop.focus();
		return "0";
		}
	if(document.edicion.apellidom.value=="")
		{
		alert('Especifique el Apellido Materno');
		document.edicion.apellidom.focus();
		return "0";
		}
	if(document.edicion.nacimiento.value=="")
		{
		alert('Especifique la fecha de Nacimiento');
		return "0";
		}
	if(document.edicion.rfc.value=="")
		{
		alert('Especifique el RFC');
		document.edicion.rfc.focus();
		return "0";
		}
	
	document.edicion.nacimiento.disabled=false;
	document.edicion.nombre.disabled=false;
	document.edicion.apellidop.disabled=false;
	document.edicion.apellidom.disabled=false;
	document.edicion.nacimiento.disabled=false;
	document.edicion.rfc.disabled=false;
	
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=1;
	document.edicion.submit();
	}


function verificaCampos()
{
if(document.edicion.status.value!="1")
	{
	document.edicion.idcli.disabled=true;
	document.edicion.nombre.disabled=true;
	document.edicion.apellidop.disabled=true;
	document.edicion.apellidom.disabled=true;
	document.edicion.antiguedad.disabled=true;
	document.edicion.nss.disabled=true;
	document.edicion.escolaridad.disabled=true;
	document.edicion.email.disabled=true;	
	document.edicion.telefonos.disabled=true;
	document.edicion.rfc.disabled=true;
	document.edicion.curp.disabled=true;
	document.edicion.calle.disabled=true;
	document.edicion.numero.disabled=true;
	document.edicion.municipio.disabled=true;
	document.edicion.colonia.disabled=true;
	document.edicion.estado.disabled=true;
	document.edicion.cp.disabled=true;
	document.edicion.ref1.disabled=true;	
	document.edicion.tel1.disabled=true;	
	document.edicion.ref2.disabled=true;	
	document.edicion.tel2.disabled=true;		
	}
	
}
 


function actualizar()
	{
	if(confirm('¿Realmente desea borrar este Registro y todos sus archivos?'))
		{
		document.edicion.accion.value=5;
		document.edicion.submit();
 		}		
	}	


function alcargar()
	{

	document.edicion.nombre.disabled=true;
	document.edicion.apellidop.disabled=true;
	document.edicion.apellidom.disabled=true;
	document.edicion.nacimiento.disabled=true;
	document.edicion.rfc.disabled=true;

	}
	
function cambiast()
	{
	if(document.edicion.comentariostatus.value=="")
		{
		alert('Especifique la razón del cambio');
		return "0";
		}
	document.edicion.accion.value=3;
	document.edicion.submit();
	}
	
function nuevocom()
	{
	document.edicion.idcom.value=0;
	Popup.showModal('modal6');
	}
	
function guardarcom()
	{
	document.edicion.accion.value=4;
	document.edicion.submit();
	}

function editacom(cid,cdescripcion)
	{
	document.edicion.idcom.value=cid;
	document.edicion.comentario.value=cdescripcion;
	Popup.showModal('modal6');
	}
function borrarcom(cid)
	{
	if(confirm('Se borrará este comentario, ¿continuar?'))
		{
		document.edicion.idcom.value=cid;
		document.edicion.accion.value=6;
		document.edicion.submit();
		}
	}
function seleccionadestino()
	{
	abre('seldestino','f_selcch.php?destino=cc',550,500,'YES');
	}

function cambiarintegra()
	{
	if(document.edicion.integranew.options[document.edicion.integranew.selectedIndex].value=="")
		{
		alert("seleccione una integradora para continuar");
		return 0;
		}
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=7;
	document.edicion.submit(); 			
	}

function cambiarasesor()
	{
	if(document.edicion.asesornew.options[document.edicion.asesornew.selectedIndex].value=="")
		{
		alert("seleccione un asesor para continuar");
		return 0;
		}
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=8;
	document.edicion.submit(); 			
	}

function cambiarconstructora()
	{
	if(document.edicion.idconstructoranew.options[document.edicion.idconstructoranew.selectedIndex].value=="0")
		{
		alert("seleccione una constructora para continuar");
		return 0;
		}
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=9;
	document.edicion.submit(); 			
	}

function cambiarverificadora()
	{
	if(document.edicion.idverificadoranew.options[document.edicion.idverificadoranew.selectedIndex].value=="0")
		{
		alert("seleccione una verificadora para continuar");
		return 0;
		}
	document.getElementById('divboton').innerHTML="<font color='#000000' style='font-size: 30px;'><i class='fa fa-refresh fa-spin'></i></font></p>";
	document.edicion.accion.value=10;
	document.edicion.submit(); 			
	}
</SCRIPT>

</head>


<body onload="alcargar();">
	<form method="POST" name="edicion" target="_self">
		<div class="container-fluid">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td><h3><font face="Arial">Editar Cliente</font></h3></td>
					<td width="33" align="right">	
					<a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
				</tr>
				<tr>
					<td colspan="2"><h4><font face="Arial" color="#000080"><? echo "$idcli $nombre $apellidop $apellidom";?></font></h3></td>			
				</tr>
			</table>

			<?
			echo "<ul class='nav nav-tabs'>
				<li class='active'><a href='f_cliente.php?id=$id'><b>General</b></a></li>";
			if($id>0)
				{
				if($IDL8>0)
					echo "<li><a href='f_clientepr.php?id=$id'>Presupuesto de Obra</a></li>";
				if($IDL2>0)
					echo "<li><a href='f_clientei.php?id=$id'>Documentos y Archivos</a></li>";
				if($IDL3>0)
					echo "<li><a href='f_clientef.php?id=$id'>Impresión de Formatos</a></li>";				
				if($IDL4>0)
					echo "<li><a href='f_clientel.php?id=$id'>Log Cambios</a></li>";
				}
			echo "</ul>";
			?>

			<br>
			<div class="row">
				<div class="col-sm-12">
					<div id="divboton">
						<button type='button' onClick="guardar();" class='btn btn-success btn-xs'>Guardar</button>
						<?				
						if($IDL7>=1)
							echo "&nbsp;<button type='button' onClick=\"Popup.showModal('modal5');\" class='btn btn-warning btn-xs'>Cambiar Asesor</button>";
						
						if($IDL6>=1)
							echo "&nbsp;<button type='button' onClick=\"Popup.showModal('modal4');\" class='btn btn-warning btn-xs'>Cambiar Integradora</button>";

						if($IDL9>=1)
							echo "&nbsp;<button type='button' onClick=\"Popup.showModal('modal7');\" class='btn btn-warning btn-xs'>Cambiar Constructora</button>";

						if($IDL10>=1)
							echo "&nbsp;<button type='button' onClick=\"Popup.showModal('modal8');\" class='btn btn-warning btn-xs'>Cambiar Verificadora</button>";

						if($IDL>=4)
							{
							if($id!="-1")
								echo "&nbsp;<button type='button' onClick=\"actualizar();\" class='btn btn-danger btn-xs'>Borrar</button>";		
							}
						?>
						
					</div>
				</div>	
			</div>
			<div class="well well-sm">
				<div class="row">
					<div class="col-sm-6">
						<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">ID:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<? if($numopeauto==0)
										echo "<input type='text' name='idcli' class='cenboxfrmmin' value='$idcli'>	";
									else
										echo "<b><font face='Arial' size='2' color='#000080'>$idcli</font></b>";
									?>				
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Asesor:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $asesor;?></font></b>			
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Constructora:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $idconstructorav;?></font></b>			
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Captura:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $fecha;?></font></b>			
								</td>
							</tr>
						</table>
					</div>
					<div class="col-sm-6">
						<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
							<tr>
								<td  width="150" align="right" height="22"><font face="Arial" size="2">Status:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<font face="Arial" size="2" color="#ff0000"><b><? echo $statusv; ?></b></font>				
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Integradora:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $integradora;?></font></b>			
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Verificadora:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $idverificadorav;?></font></b>			
								</td>
							</tr>
							<tr>
								<td width="150" align="right" height="22"><font face="Arial" size="2">Creador:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">
									<b><font face='Arial' size='2'><? echo $owner;?></font></b>			
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Nombre (s):</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="nombre" class="cenboxfrm" <?echo "value='$nombre'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Apellido Paterno:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="apellidop" class="cenboxfrm" <?echo "value='$apellidop'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Apellido Materno:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="apellidom" class="cenboxfrm" <?echo "value='$apellidom'"?>>
							</td>
						</tr>
					
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Fecha Nacimiento:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="nacimiento" disabled class="cenboxfrmmin" <?echo "value='$nacimiento'"?>><a href="#" name="anchor2" id="anchor2" onClick="displayCalendar(document.forms[0].nacimiento,'yyyy-mm-dd',this);"><span class="glyphicon glyphicon-calendar" style="font-size: 15px;"></span></a>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Edad:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<font face="Arial" size="2"><? echo $edad;?></font>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">RFC:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="rfc" class="cenboxfrm" <?echo "value='$rfc'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">CURP:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="curp" class="cenboxfrm" <?echo "value='$curp'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">NSS:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="nss" class="cenboxfrm" <?echo "value='$nss'"?>>
							</td>
						</tr>
						
					</table>
				</div>
				<div class="col-sm-6">
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">						
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Género:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<select name="genero" class="cenboxfrm">
									<?echo $generov;?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">E-mail:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="email" class="cenboxfrm" <?echo "value='$email'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Teléfono:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="telefonos" class="cenboxfrm" <?echo "value='$telefonos'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Teléfono Oficina:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="oficina" class="cenboxfrm" <?echo "value='$oficina'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Celular:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="celular" class="cenboxfrm" <?echo "value='$celular'"?>>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Estado Civil:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<select name="ecivil" class="cenboxfrm">
									<?echo $ecivilv;?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Páis de Nacimiento:</font></td>
							<td width="5" align="left" height="22">
							&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="nacionalidad" class="cenboxfrm" <?echo "value='$nacionalidad'"?>>
							</td>
						</tr>
						
					</table>
				</div>
			</div>

		<?//?>
		<br>		
		<div class="row">
			<div class="col-sm-6">	
				<h4><font face="Arial">Referencias familiares</font></h4>	
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">			
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Nombre:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref1nombre" class="cenboxfrm" <?echo "value='$ref1nombre'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Apellido paterno:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref1apellidop" class="cenboxfrm" <?echo "value='$ref1apellidop'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Apellido materno:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref1apellidom" class="cenboxfrm" <?echo "value='$ref1apellidom'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Teléfono:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref1telefono" class="cenboxfrm" <?echo "value='$ref1telefono'"?>></td>
					</tr>
				</table>	
			</div>
			<br><br>
			<div class="col-sm-6">
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">			
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Nombre:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref2nombre" class="cenboxfrm" <?echo "value='$ref2nombre'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Apellido paterno:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref2apellidop" class="cenboxfrm" <?echo "value='$ref2apellidop'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Apellido materno:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref2apellidom" class="cenboxfrm" <?echo "value='$ref2apellidom'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Teléfono:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="ref2telefono" class="cenboxfrm" <?echo "value='$ref2telefono'"?>></td>
					</tr>
				</table>
			</div>
		</div>
		<?//?>
		
		<br>		
		<div class="row">
			<div class="col-sm-6">	
				<h4><font face="Arial">Domicilio Fiscal</font></h4>	
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">			
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Calle:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="callef" class="cenboxfrm" <?echo "value='$callef'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Número Ext.:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="numerof" class="cenboxfrm" <?echo "value='$numerof'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Número Int.:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="numerointf" class="cenboxfrm" <?echo "value='$numerointf'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Lote:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="lotef" class="cenboxfrm" <?echo "value='$lotef'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Manzana:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="mzaf" class="cenboxfrm" <?echo "value='$mzaf'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Colonia:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="coloniaf" class="cenboxfrm" <?echo "value='$coloniaf'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Delegación / Municipio:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="municipiof" class="cenboxfrm" <?echo "value='$municipiof'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Estado:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<select size="1" name="estadof" class="cenboxfrm">
							<?echo $estadofv;?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Código Postal:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="cpf" class="cenboxfrmmin" <?echo "value='$cpf'"?>></td>
					</tr>					
				</table>
			</div>
			<div class="col-sm-6">
				<h4><font face="Arial">Domicilio Particular</font></h4>
				<font face="Arial" size="2"><i>(llenar sólo en caso de ser diferente al domicilio fiscal)</i></font>
				
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">			
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Calle:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="calle" class="cenboxfrm" <?echo "value='$calle'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Número Ext.:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="numero" class="cenboxfrm" <?echo "value='$numero'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Número Int.:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="numeroint" class="cenboxfrm" <?echo "value='$numeroint'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Lote:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="lote" class="cenboxfrm" <?echo "value='$lote'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Manzana:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="mza" class="cenboxfrm" <?echo "value='$mza'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Colonia:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="colonia" class="cenboxfrm" <?echo "value='$colonia'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Delegación / Municipio:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="municipio" class="cenboxfrm" <?echo "value='$municipio'"?>></td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Estado:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<select size="1" name="estado" class="cenboxfrm">
							<?echo $estadov;?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="right" height="22" width="150">
						<font face="Arial" size="2">Código Postal:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<input type="text" name="cp" class="cenboxfrmmin" <?echo "value='$cp'"?>></td>
					</tr>

				</table>
			</div>
		</div>
<!--
		<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
			<tr>
						<td align="right" height="22" width="400">
						<font face="Arial" size="2">¿La vivienda elegida es para una persona con discapacidad?</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<select size="1" name="discapacidad" class="cenboxfrmmin">
							<?echo $discapacidadv;?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="right" height="22" width="400">
						<font face="Arial" size="2">Tipo de discapacidad:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<select size="1" name="tipodiscapacidad" class="cenboxfrm">
							<?echo $tipodiscapacidadv;?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="right" height="22" width="400">
						<font face="Arial" size="2">Persona que presentará comprobante de discapacidad:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22" bordercolor="#FFFF99">
						<select size="1" name="personacapacidad" class="cenboxfrm">
							<?echo $personacapacidadv;?>
						</select>
						</td>
					</tr>
		</table>
-->

		<h4><font face="Arial">Información Bancaria</font></h4>
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Institución Bancaria:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td align="left" height="22">
								<select class="cenboxfrm" name="idbanco">
									<?echo $idbancov;?>
								</select>
							</td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Número de Cuenta:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="cuenta" class="cenboxfrm" <?echo "value='$cuenta'"?>></td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">CLABE Interbancaria:</font></td>
							<td width="5" align="left" height="22" >&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="clabe" class="cenboxfrm" <?echo "value='$clabe'"?>></td>				
						</tr>
						<tr>
							<td width="150" align="right" height="22">
							<font face="Arial" size="2">Beneficiario:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="beneficiario" class="cenboxfrm" <?echo "value='$beneficiario'"?>></td>				
						</tr>
					</table>
		<br>
		<h4><font face="Arial">Datos de la empresa o patrón</font></h4>
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
					<tr>
						<td width="230" align="right" height="22">
						<font face="Arial" size="2">Nombre de la empresa o patrón:</font></td>
						<td width="5" align="left" height="22" >&nbsp;</td>
						<td align="left" height="22">
						<input type="text" name="razonsocialpatron" class="cenboxfrm" <?echo "value='$razonsocialpatron'"?>></td>				
					</tr>
					<tr>
						<td width="230" align="right" height="22">
						<font face="Arial" size="2">Número de registro patronal (NRP):</font></td>
						<td width="5" align="left" height="22" >&nbsp;</td>
						<td align="left" height="22">
						<input type="text" name="rfcpatron" class="cenboxfrm" <?echo "value='$rfcpatron'"?>></td>				
					</tr>
					<tr>
						<td width="230" align="right" height="22">
						<font face="Arial" size="2">Teléfono de la empresa donde trabaja:</font></td>
						<td width="5" align="left" height="22" >&nbsp;</td>
						<td align="left" height="22">
						<input type="text" name="telpatron" class="cenboxfrm" <?echo "value='$telpatron'"?>></td>				
					</tr>
				</table>

<!--				

		<br>
		<h4><font face="Arial">Recursos de la cuenta</font></h4>
		<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
			<tr>
				<td width="200" align="right" height="22">
					<font face="Arial" size="2">Origen de recursos a manejar:</font></td>
				<td width="5" align="left" height="22">&nbsp;</td>
				<td align="left" height="22">	
					<select class="cenboxfrm" name="propietarior">
						<?echo $propietariorv;?>
					</select>							
				</td>				
			</tr>
		</table>

		<div class="row">
			<div class="col-sm-6">
				<font face="Arial" size="2"><b>Origen de recursos</b></font>
				<div class="row">
					<div class="col-sm-6">
						<?				

						#Ingresos
						$actrecori="0";
						$consulta="select * from cat_recursos where tipo='1' and status='1' order by orden";					
						echo "<table border='0' width='100%' id='table3' cellspacing='0' cellpadding='0'>";
						$resx = mysqli_query($conexio,$consulta);
						while($val=mysqli_fetch_array($resx))
							{
							if(erecu(1,$val['id'])==1)
								{
								$srecu="checked";
								$actrecori .=",".$val['id'];
								}
							if(erecu(1,$val['id'])==0)
								$srecu="";
							echo "<tr><td width='150' height='22'><font face='Arial' size='2'>".$val['descripcion']."</font></td><td><input type='checkbox' $srecu name='rec".$val['id']."' value='1' style='width: 20px; height: 20px'></td></tr>";
							//echo $val['descripcion']."<br>";				
							}
						mysqli_free_result($resx);
						echo "</table>";
						?>
					</div>
					<div class="col-sm-6">
						<font face="Arial" size="2">Otro, especifique</font><br>
						<textarea  name="recursosori" class="cenboxfrm" style="width: 100%; height: 150px;"> <?echo $recursosori;?></textarea>
						
					</div>
				</div>

			</div>
			<div class="col-sm-6">
				<font face="Arial" size="2"><b>Destino de recursos</b></font>
				<div class="row">
					<div class="col-sm-6">
						<?				

						#Egresos
						$actrecdes="0";
						$consulta="select * from cat_recursos where tipo='2' and status='1' order by orden";					
						echo "<table border='0' width='100%' id='table3' cellspacing='0' cellpadding='0'>";
						$resx = mysqli_query($conexio,$consulta);
						while($val=mysqli_fetch_array($resx))
							{
							if(erecu(2,$val['id'])==1)
								{
								$srecu="checked";
								$actrecdes .=",".$val['id'];
								}
							if(erecu(2,$val['id'])==0)
								$srecu="";
							echo "<tr><td width='150' height='22'><font face='Arial' size='2'>".$val['descripcion']."</font></td><td><input type='checkbox' $srecu name='rec".$val['id']."' value='1' style='width: 20px; height: 20px'></td></tr>";
							//echo $val['descripcion']."<br>";				
							}
						mysqli_free_result($resx);
						echo "</table>";
						?>
					</div>
					<div class="col-sm-6">
						<font face="Arial" size="2">Otro, especifique</font><br>
						<textarea  name="recursosdes" class="cenboxfrm" style="width: 100%; height: 150px;"> <?echo $recursosdes;?></textarea>						
					</div>
				</div>

			</div>
		</div>
-->

		<br>
		<div class="row">
<!--			
			<div class="col-sm-6">
				<h4><font face="Arial">Crédito solicitado</font></h4>
				<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
					<tr>
						<td width="150" align="right" height="22">
							<font face="Arial" size="2">Producto:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22">	
							<select class="cenboxfrm" name="idproducto">
								<?echo $idproductov;?>
							</select>							
						</td>				
					</tr>
					<tr>
						<td width="150" align="right" height="22">
							<font face="Arial" size="2">Tipo de crédito:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22">	
							<select class="cenboxfrm" name="idtipoproducto">
								<?echo $idtipoproductov;?>
							</select>							
						</td>				
					</tr>
					<tr>
						<td width="150" align="right" height="22">
							<font face="Arial" size="2">Destino del crédito:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22">	
							<select class="cenboxfrm" name="iddestino">
								<?echo $iddestinov;?>
							</select>							
						</td>				
					</tr>
					<tr>
						<td width="150" align="right" height="22">
							<font face="Arial" size="2">Plazo del crédito:</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22">	
							<select class="cenboxfrmmin" name="plazocredito">
								<?echo $plazocreditov;?>
							</select>							
						</td>				
					</tr>
					<tr>
						<td width="150" align="right" height="22">
							<font face="Arial" size="2">¿Es el segundo crédito que solicita al infonavit?</font></td>
						<td width="5" align="left" height="22">&nbsp;</td>
						<td align="left" height="22">	
							<select class="cenboxfrmmin" name="segundocredito">
								<?echo $segundocreditov;?>
							</select>							
						</td>				
					</tr>				
				</table>	
			</div>
		-->
			<div class="col-sm-12">
				<h4><font face="Arial">Monto a solicitar</font></h4>
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
						<tr>
							<td width="240" align="right" height="22">
							<font face="Arial" size="2">Valor ampliación, remodelación o mejora:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td align="left" height="22">
								<input type="text" name="valorampliacion" class="cenboxfrmmin" <?echo "value='$valorampliacion'"?>>
							</td>				
						</tr>
						<tr>
							<td width="240" align="right" height="22">
							<font face="Arial" size="2">Monto según reglas:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="valorregla" class="cenboxfrmmin" <?echo "value='$valorregla'"?>></td>				
						</tr>
						<tr>
							<td width="240" align="right" height="22">
							<font face="Arial" size="2">El solicitante contaría con:</font></td>
							<td width="5" align="left" height="22" >&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="valorneto" class="cenboxfrmmin" <?echo "value='$valorneto'"?>></td>				
						</tr>
						<tr>
							<td width="240" align="right" height="22">
							<font face="Arial" size="2">Monto del presupuesto:</font></td>
							<td width="5" align="left" height="22" >&nbsp;</td>
							<td align="left" height="22">
							<input type="text" name="montopresupuesto" class="cenboxfrmmin" <?echo "value='$montopresupuesto'"?>></td>
							</td>				
						</tr>
						<tr>
							<td width="240" align="right" height="22">
							<font face="Arial" size="2">Afectación estructural:</font></td>
							<td width="5" align="left" height="22" >&nbsp;</td>
							<td align="left" height="22">
							<select class="cenboxfrmmin" name="afectaestructura">
							<?echo $afectaestructurav;?>
							</select>
							</td>				
						</tr>					
					</table>
				
				</div>
			</div>

			<?//?>	
		<!--	
			<br>
			<div class="row">
				<div class="col-sm-6">
					<h4><font face="Arial">Administradora del recurso</font></h4>
					<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
						<tr>
							<td width="100" align="right" height="22">
								<font face="Arial" size="2">Seleccione:</font></td>
							<td width="5" align="left" height="22">&nbsp;</td>
							<td align="left" height="22">	
								<select class="cenboxfrm" name="idadministradora">
									<?echo $idadministradorav;?>
								</select>
							</td>										
						</tr>						
					</table>								
				</div>
				<div class="col-sm-6">
					<h4><font face="Arial">Datos del acreedor hipotecario</font></h4>
						<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">	
							<tr>
								<td width="200" align="right" height="22">
									<font face="Arial" size="2">Nombre o denominación o razón social:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">	
								<input type="text" name="razonsocialacreditado" class="cenboxfrm" <?echo "value='$razonsocialacreditado'"?>></td>										
							</tr>
							<tr>
								<td width="200" align="right" height="22">
									<font face="Arial" size="2">RFC:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">	
								<input type="text" name="rfcacreditado" class="cenboxfrm" <?echo "value='$rfcacreditado'"?>></td>			
							</tr>
							<tr>
								<td width="200" align="right" height="22">
									<font face="Arial" size="2">Nombre o denominación o razón social como aparece en el estado de cuenta:</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">	
								<input type="text" name="nombreacreditado" class="cenboxfrm" <?echo "value='$nombreacreditado'"?>></td>			
							</tr>
							<tr>
								<td width="200" align="right" height="22">
									<font face="Arial" size="2">Clabe bancaria estandarizada (CLABE):</font></td>
								<td width="5" align="left" height="22">&nbsp;</td>
								<td align="left" height="22">	
								<input type="text" name="clabeacreditado" class="cenboxfrm" <?echo "value='$clabeacreditado'"?>></td>				
							</tr>
						</table>		
				</div>
			</div>

		-->

	
<?

if($IDL5>0){?>		
<p>&nbsp;</p>
<h4><font face="Arial">Comentarios</font></h4>
<? if($IDL5>=2)
	echo "<button type='button' onClick=\"nuevocom();\" class='btn btn-success btn-xs'>Agregar Comentario</button>";
?>

<table class="table table-condensed">
	<thead>
      <tr>
        <th><font face="Arial" size="2">Comentario</font></th>
        <th><font face="Arial" size="2">Creación</font></th>
        <th><font face="Arial" size="2">Actualización</font></th>
      </tr>
    </thead>
    <tbody>
   
<?

					$consulta="Select * from ope_clientecoms where idorigen='$id' order by fecha desc";
					$res = mysqli_query($conexio, $consulta);
					while($val8=mysqli_fetch_array($res))
						{
						$cid=$val8['id'];
						$cdescripcion=$val8['descripcion'];
						$cfecha=fixfecha($val8['fecha'])."<br>por ".$val8['usuario'];
						$cact=fixfecha($val8['ultactfec'])."<br> por ".$val8['ultactusu'];
						$clink="";
						if($IDL5>=3)
							$clink .="<br><button type='button' onClick=\" editacom($cid,'$cdescripcion'); \" class='btn btn-primary btn-xs'>Editar</button>";
						if($IDL5>=4)
							$clink .="&nbsp;<button type='button' onClick=\" borrarcom($cid); \" class='btn btn-danger btn-xs'>Borrar</button>";
						echo "<tr>
						<td><font face='Arial' size='2' color='#000000'>$cdescripcion</font>$clink</td>
						<td><font face='Arial' size='2' color='#808080'>$cfecha</font></td>
						<td><font face='Arial' size='2' color='#808080'>$cact</font></td>
						</tr>";

						}
					mysqli_free_result($res);
					?>					
					</tbody>
				</table>
<?}?>
<br>
<? echo "<font face='Verdana' size='1' color='#808080'>Última Actualización: $ultima</font>";?>
<br>
<input type="hidden" name="id" <?echo "value='$id'"?>>
<input type="hidden" name="accion" value="0">
<input type="hidden" name="idcom" value="0">

<input type="hidden" name="actnombre" <?echo "value='$nombre'"?>>
<input type="hidden" name="actapellidop" <?echo "value='$apellidop'"?>>
<input type="hidden" name="actapellidom" <?echo "value='$apellidom'"?>>
<input type="hidden" name="actnacimiento" <?echo "value='$nacimiento'"?>>
<input type="hidden" name="actecivil" <?echo "value='$ecivil'"?>>
<input type="hidden" name="actestadonac" <?echo "value='$estadonac'"?>>
<input type="hidden" name="actgenero" <?echo "value='$genero'"?>>
<input type="hidden" name="actidextranjero" <?echo "value='$idextranjero'"?>>
<input type="hidden" name="actoficina" <?echo "value='$oficina'"?>>
<input type="hidden" name="actcelular" <?echo "value='$celular'"?>>
<input type="hidden" name="actprofesion" <?echo "value='$profesion'"?>>
<input type="hidden" name="actocupacion" <?echo "value='$ocupacion'"?>>
<input type="hidden" name="actfuentei" <?echo "value='$fuentei'"?>>
<input type="hidden" name="actprocedencia" <?echo "value='$procedencia'"?>>	
<input type="hidden" name="actintegradora" <?echo "value='$integradora'"?>>
<input type="hidden" name="actasesor" <?echo "value='$asesor'"?>>
<input type="hidden" name="actpropietarior" <?echo "value='$propietarior'"?>>
<input type="hidden" name="actrecursosori" <?echo "value='$recursosori'"?>>
<input type="hidden" name="actrecursosdes" <?echo "value='$recursosdes'"?>>
<input type="hidden" name="actidbanco" <?echo "value='$idbanco'"?>>
<input type="hidden" name="actcuenta" <?echo "value='$cuenta'"?>>
<input type="hidden" name="actclabe" <?echo "value='$clabe'"?>>
<input type="hidden" name="actbeneficiario" <?echo "value='$beneficiario'"?>>
<input type="hidden" name="actvalorampliacion" <?echo "value='$valorampliacion'"?>>
<input type="hidden" name="actvalorregla" <?echo "value='$valorregla'"?>>
<input type="hidden" name="actvalorneto" <?echo "value='$valorneto'"?>>
<input type="hidden" name="actcallef" <?echo "value='$callef'"?>>
<input type="hidden" name="actnumerof" <?echo "value='$numerof'"?>>
<input type="hidden" name="actcoloniaf" <?echo "value='$coloniaf'"?>>		
<input type="hidden" name="actmunicipiof" <?echo "value='$municipiof'"?>>		
<input type="hidden" name="actestadof" <?echo "value='$estadof'"?>>
<input type="hidden" name="actcpf" <?echo "value='$cpf'"?>>
<input type="hidden" name="actrecdes" <?echo "value='$actrecdes'"?>>
<input type="hidden" name="actrecori" <?echo "value='$actrecori'"?>>
<input type="hidden" name="actnacionalidad" <?echo "value='$nacionalidad'"?>>		
<input type="hidden" name="actnss" <?echo "value='$nss'"?>>
<input type="hidden" name="actescolaridad" <?echo "value='$escolaridad'"?>>
<input type="hidden" name="actcalle" <?echo "value='$calle'"?>>
<input type="hidden" name="actnumero" <?echo "value='$numero'"?>>
<input type="hidden" name="actcolonia" <?echo "value='$colonia'"?>>		
<input type="hidden" name="actmunicipio" <?echo "value='$municipio'"?>>		
<input type="hidden" name="actestado" <?echo "value='$estado'"?>>
<input type="hidden" name="actcp" <?echo "value='$cp'"?>>
<input type="hidden" name="actrfc" <?echo "value='$rfc'"?>>
<input type="hidden" name="actcurp" <?echo "value='$curp'"?>>
<input type="hidden" name="acttelefonos" <?echo "value='$telefonos'"?>>	
<input type="hidden" name="actemail" <?echo "value='$email'"?>>
<input type="hidden" name="actpuestopolitico" <?echo "value='$puestopolitico'"?>>
<input type="hidden" name="actstatus" <?echo "value='$status'"?>>
<input type="hidden" name="actconstructora'" <?echo "value='$idconstructora'"?>>
<input type="hidden" name="actverificadora'" <?echo "value='$idverificadora'"?>>
<?//?>
<input type="hidden" name="idproducto'" <?echo "value='$idproducto'"?>>
<input type="hidden" name="idtipoproducto'" <?echo "value='$idtipoproducto'"?>>
<input type="hidden" name="iddestino'" <?echo "value='$iddestino'"?>>
<input type="hidden" name="plazocredito'" <?echo "value='$plazocredito'"?>>
<input type="hidden" name="segundocredito'" <?echo "value='$segundocredito'"?>>
<input type="hidden" name="discapacidad'" <?echo "value='$discapacidad'"?>>
<input type="hidden" name="tipodiscapacidad'" <?echo "value='$tipodiscapacidad'"?>>
<input type="hidden" name="personacapacidad'" <?echo "value='$personacapacidad'"?>>
<input type="hidden" name="afectaestructura'" <?echo "value='$afectaestructura'"?>>
<input type="hidden" name="razonsocialpatron'" <?echo "value='$razonsocialpatron'"?>>
<input type="hidden" name="rfcpatron'" <?echo "value='$rfcpatron'"?>>
<input type="hidden" name="telpatron'" <?echo "value='$telpatron'"?>>
<input type="hidden" name="ref1apellidop'" <?echo "value='$ref1apellidop'"?>>
<input type="hidden" name="ref1apellidom'" <?echo "value='$ref1apellidom'"?>>
<input type="hidden" name="ref1nombre'" <?echo "value='$ref1nombre'"?>>
<input type="hidden" name="ref1telefono'" <?echo "value='$ref1telefono'"?>>
<input type="hidden" name="ref2apellidop'" <?echo "value='$ref2apellidop'"?>>
<input type="hidden" name="ref2apellidom'" <?echo "value='$ref2apellidom'"?>>
<input type="hidden" name="ref2nombre'" <?echo "value='$ref2nombre'"?>>
<input type="hidden" name="ref2telefono'" <?echo "value='$ref2telefono'"?>>
<input type="hidden" name="razonsocialacreditado'" <?echo "value='$razonsocialacreditado'"?>>
<input type="hidden" name="rfcacreditado'" <?echo "value='$rfcacreditado'"?>>
<input type="hidden" name="nombreacreditado'" <?echo "value='$nombreacreditado'"?>>
<input type="hidden" name="clabeacreditado'" <?echo "value='$clabeacreditado'"?>>

<?//?>

</div>

<div id="modal4" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Establecer Integradora</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal4');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
		<select class="cenboxfrm" name="integranew">
			<?echo $integranewv;?>
		</select>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="cambiarintegra();">Cambiar</button>
	</p>
</div>


<div id="modal5" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Establecer Asesor</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal5');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
		<select class="cenboxfrm" name="asesornew">
			<?echo $asesornewv;?>
		</select>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="cambiarasesor();">Cambiar</button>
	</p>
</div>

<div id="modal6" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Comentarios</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal6');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
	<textarea class="cenboxfrm" name="comentario" style="height: 150px"></textarea>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="guardarcom();">Guardar</button>
	</p>
</div>

<div id="modal7" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Establecer Constructora</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal7');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
		<select class="cenboxfrm" name="idconstructoranew">
			<?echo $idconstructoranewv;?>
		</select>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="cambiarconstructora();">Cambiar</button>
	</p>
</div>

<div id="modal8" style="border:2px solid black; background-color:#ffffff; padding:10px; text-align:center; display:none;">
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial">Establecer Verificadora</font></h4></td>
			<td width="33" align="right"><a href="#" onclick="Popup.hide('modal8');"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
	<p align="center">	
		<select class="cenboxfrm" name="idverificadoranew">
			<?echo $idverificadoranewv;?>
		</select>
	</p>
	<p>
	<button type="button" class="btn btn-success" onclick="cambiarverificadora();">Cambiar</button>
	</p>
</div>

</form>

</body>
</html>
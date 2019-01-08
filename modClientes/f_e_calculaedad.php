<?
include("../lib/f_fnBDi.php");

if(isset($_GET['fecha']))
	$fecha=$_GET['fecha'];
else{
	echo "ERROR. Falta parametro fecha";
	exit();}

echo calcular_edad($fecha);

?>	
	
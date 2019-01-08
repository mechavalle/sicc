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
  $avatar=$_SESSION['Avatar'];
  $Empresa=$_SESSION['Empresa'];
  $conexio=conecta($IDBase);

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

?>
<!DOCTYPE html>
<html>
<head>
  <title>SICC - Inicio</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../img/icono.png" type="image/x-icon">
  <link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
  <link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
  <script src="../lib/jquery-2.1.1.min.js"></script>
  <script src="../lib/boot/js/bootstrap.min.js"></script>
  <SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<link rel="stylesheet" href="../lib/style.css">
 
</head>
<body>
  <form method="GET" name="edicion" target="_self">
    
  </form>
</body>
</html>